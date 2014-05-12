<?php
/** The init class for rp_test Theme */
require_once dirname( __FILE__ ) ."/TGM_Installer.php";
class RP_Init {
    protected static $_instance;

    private function __construct() {
        $this->register_scripts();
        $this->create_theme_options();
        $this->apply_filters();
        $this->add_image_size();
        $this->on_activation();
        if( !class_exists('acf') ) {
            $this->install_acf();
        }
    }
    private function __clone() {}

    public static function getInstance () {
        if(null===self::$_instance){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    /**
     *  Following steps are required for the theme to work
     *  1. Import ACF data
     *  2. Check for homePage - Create one, set as static home
     *
     */
    private function on_activation() {
        add_action("after_setup_theme","activation_hook");
        function activation_hook () {
            if(!get_option("rp_theme_active")) {
                add_option("rp_theme_active",true);
                // import ACF data
                global $wpdb;
                $acf_field = file_get_contents(dirname(__FILE__).'/acf-data/acf_fields.sql');
                $postID = "";
                if(!RP_Init::getInstance()->rp_page_exists("rp_home")) {
                    $postID = RP_Init::getInstance()->rp_insert_home_page();
                } else {
                    $page = get_page_by_path("rp_home");
                    $postID =$page->ID;
                }
                $preparedData = str_replace("uniqueID",$postID,$acf_field);
                $data = explode("--", $preparedData);
                for ($i = 0; $i < count( $data ); $i++){
                    $wpdb->query( $data[$i] );
                }
            }
        }
    }

    /**  ---------------------------------------------
            register scripts and styles
            Important : Maintain order !
        --------------------------------------------- */
    private function register_scripts () {
        add_action( 'wp_enqueue_scripts', 'rp_test_enqueue_scripts' );

        function rp_test_enqueue_scripts() {
            wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.css' );
            wp_enqueue_style( 'rp_style', get_template_directory_uri() . '/css/style.css' );
            // Wp has a build in jquery , but to use the markup version , we deregister the wp script and enque out version
            wp_deregister_script('jquery');
            wp_enqueue_script( 'jQuery', get_template_directory_uri() . '/js/jquery-1.11.0.min.js',array(),'1.11');
            wp_enqueue_script( 'jq_sticky', get_template_directory_uri() . '/js/jquery.sticky.js');
            wp_enqueue_script( 'rp_test_main', get_template_directory_uri() . '/js/main.js');
            // For html5shiv and IE
            add_action( 'wp_head', create_function( '',
                'echo \'<!--[if lt IE 9]><script src="'.get_template_directory_uri().'/js/html5shiv.js"></script><![endif]-->\';'
            ) );
        }
    }

    /**  --------------------------------------------
        Create some custom theme options and use
        wp_customize for that , to have a nice and
        intuitive WP theme customization UI
        ------------------------------------------- */
    private function create_theme_options(){
        add_action( 'customize_register', 'rp_test_customize_register' );

        function rp_test_customize_register( $wp_customize ) {

            $socials = array( "Facebook", "Twitter", "YouTube", "Instagram", "Pinterest" );
            $copyright = array( __("1st part","rp_test"), __( "2nd part", "rp_test" ), __( "3rd part","rp_test" ) );

            // Create the social section
            $wp_customize->add_section( 'social_networks', array(
                'title'          => __( 'Social networks', 'rp_test' ),
                'priority'       => 100,
            ) );

            // Create the copyright section
            $wp_customize->add_section( 'copyright_footer', array(
                'title'          => __( 'Copyright', 'rp_test' ),
                'priority'       => 101,
            ) );

            // Here we run through all socials and create a corresponding option
            for($i=0;$i<count($socials);$i++){

                $wp_customize->add_setting( 'rp_'.strtolower($socials[$i]).'_profile', array(
                        'default'        => '',
                        'type'           => 'option'
                    ) );

                $wp_customize->add_control( 'rp_'.strtolower($socials[$i]).'_profile', array(
                        'label'      => $socials[$i].' - '.__("User profile","rp_test"),
                        'section'    => 'social_networks',
                        'settings'   => 'rp_'.strtolower($socials[$i]).'_profile'
                    ) );
            }

            // Same as in socials but for copyright
            for($i = 0; $i < count( $copyright ); $i++){

                $wp_customize->add_setting( 'rp_copyright_'.($i+1), array(
                        'default'        => '',
                        'type'           => 'option'
                    ) );
                $wp_customize->add_control( 'rp_copyright_'.($i+1), array(
                        'label'      => $copyright[$i],
                        'section'    => 'copyright_footer',
                        'settings'   => 'rp_copyright_'.($i+1)
                    ) );
            }
        }
    }
    // Here we apply some filters as well as some actions
    private function apply_filters(){
        add_filter( 'wp_title', 'rp_test_title' );
        add_action( 'wp_head', 'add_favicon' );
        add_filter( 'excerpt_more', 'rp_excerpt_more' );

        function rp_test_title( $title ) {
            if( empty( $title ) && ( is_home() || is_front_page() ) ) {
                return get_bloginfo( 'name' );
            }
            return $title;
        }

        function rp_excerpt_more( $more ) {
            return '... <a href="'.get_permalink().'" title="'.__("read more","rp_test").'"> '.__("Read more","rp_test").'</a>';
        }

        function add_favicon () {
            echo '<link rel="shortcut icon" href="'.get_stylesheet_directory_uri().'/images/favicon.ico"  type="image/x-icon" />';
        }

    }

    /**  --------------------------------------------
        Create some custom image size for the
        Homepage section (Services , News )
        Posts (Featured image)

        The thumbs will be generated each time an image gets uploaded.
        So changing this values doesn't affect already uploaded images
        -------------------------------------------- */
    private function add_image_size (){
        add_image_size( 'newsThumb', 220, 230, true);
        add_image_size( 'serviceThumb', 220, 150, true);

        add_theme_support( 'post-thumbnails' );
        add_image_size( 'blogImage', 695, 300, true);
    }
    public function rp_page_exists ( $page_slug ) {
        $pages = get_pages();
        foreach ($pages as $page) {
            if( $page->post_name == $page_slug ) {
                return true;
            }
        }
    }

    /**
     * Creates a page
     *
     * @param string $pageTitle The Title of the page
     *
     *
     * @return int|\WP_Error The page id
     */
    public function rp_insert_home_page ( $pageTitle="Home page" ) {
        $defaults = array(
            'post_status'           => 'publish',
            'post_type'             => 'page',
            'post_name'             => 'rp_home',
            'post_title'            => $pageTitle
        );
        $postID = wp_insert_post( $defaults );
        update_option( 'page_on_front', $postID );
        update_option( 'show_on_front', 'page' );
        return $postID;
    }
    /**
     * This is the installer for plugins. For now it installs required ACF
     *
     * @return void
     */
    private function install_acf () {
        add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
        function my_theme_register_required_plugins() {
            $plugins = array(
                // This is an example of how to include a plugin from the WordPress Plugin Repository.
                array(
                    'name'      => 'Advanced Custom Fields',
                    'slug'      => 'advanced-custom-fields',
                    'required'  => true,
                ),
            );
            tgmpa( $plugins, array(
                'is_automatic' => true,
                'dismissable'  => false,
            ) );
        }
    }

} 