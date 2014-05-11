<?php

/*  --------------------------------------------
    To keep the functions.php clean and readable
    We divide its init phase in an Init class
    ------------------------------------------- */
require_once "inc/RP_Init.php";
RP_Init::getInstance();

/*  --------------------------------------------
    Register Navigation menu
    And to keep our template files nice and clean
    we create a custom function for our menu
    witch will echo the menu with proper args
    -------------------------------------------- */

register_nav_menus( array(
    'top-nav' => __( 'General Header Menu' , 'rp_test' ),
    'footer-nav' => __( 'General Footer Menu' , 'rp_test' )
));

function rp_get_nav_menu( $location , $container, $container_class = '', $menuClass='menu', $menu='', $echo = true) {
    $fallback = $location == "top-nav" ? "rp_top_nav_fallback" : "rp_footer_nav_fallback";
    $args = array(
        'theme_location'  => $location,
        'menu'            => $menu,
        'menu_class'      => $menuClass,
        'container'       => $container,
        'container_class' => $container_class,
        'echo'            => $echo,
        'depth'           => 1,
        'fallback_cb'     => $fallback

    );
    wp_nav_menu( $args );
}
// If no menu assigned this will display in menu location
function rp_top_nav_fallback(){
            echo "<nav class='main-menu'>
                    <ul>
		                <li class='current-menu-item'><a href='/'>Home</a></li>
		            </ul>
                  </nav>";
}
function rp_footer_nav_fallback () {
    echo "<ul class='footer-info-menu'>
		     <li class='current-menu-item'><a href='/'>Home</a></li>
          </ul>";
}

/*  --------------------------------------------
    Register the sidebar and include our Widget
    -------------------------------------------- */
register_sidebar( array(
    'name'         => __( 'Left Sidebar' ),
    'id'           => 'sidebar-left',
    'description'  => __( 'Displays widgets in the left side bar.' ),
    'before_title' => '<h1>',
    'after_title'  => '</h1>',
) );
require_once 'inc/RP_sidebar_menu.php';
function register_rp_widgets() {
    register_widget( 'RP_Sidebar_menu' );
}
add_action( 'widgets_init', 'register_rp_widgets' );


/**
 * Shows the social icons with links
 * Receives data from Theme settings
 *
 * @return string The socials list
 */

function rp_footer_socials() {
    $socials = array(
        'names' => array(
            "Facebook",
            "Twitter",
            "YouTube",
            "Instagram",
            "Pinterest"
        ),
        'links' => array (
            "https://www.facebook.com/",
            "https://twitter.com/",
            "https://www.youtube.com/",
            "http://instagram.com/",
            "https://www.pinterest.com/"
        )
    );

    $html = '<ul class="social-networks">';
    for($i = 0; $i < count( $socials['names'] ); $i++) {
        $name = $socials['names'][$i];
        $link = $socials['links'][$i];
        $profile = get_option('rp_'.strtolower($name).'_profile');

        if($profile!=''){
            $html.= '<li class="'.strtolower($name).'"><a href="'.$link.$profile.'" title="Find Us on '.$name.'">'.$name.'</a></li>';
        }
    }

    $html.='</ul>';
    echo $html;
}

/**
 *  Used in archive template file ,
 *  to show the category banner
 *
 * @return string The category banner
 */

function rp_get_cat_banner () {
    if(is_category()) {
        global $cat;
        $category = "category_".$cat;
        if( function_exists('get_field') && get_field('cat_banner_image', $category) ){
            $image = get_field('cat_banner_image', $category);
            $height = $image['height'];
            $width = $image['width'];
            $url = $image['url'];
            $alt = $image['alt'];
            $imgTitle = $image['title'];
            $ratio = $width/$height;
            // if height is more then $maxHeight - resize
            if($height > 400){
                $height = 400;
                $width = $height*$ratio;
            }
            $titleType  = get_field('cat_banner_headline', $category);
            $bannerTitle = $titleType == "1" ? single_cat_title('',false): get_field("cat_banner_custom_title",$category);;
            $html = '<div class="page-banner">
                        <div class="page-banner-image">
                            <div class="image-cover"></div>
                                <img src="'.$url.'" alt="'.$alt.'" title="'.$imgTitle.'" height="'.$height.'" width="'.$width.'" />
                        </div>
                        <div class="page-banner-content">
                            <div class="container">
                                <div class="pbc-box">
                                    <h2>'.$bannerTitle.'</h2>
                                    '.get_field("cat_banner_description", $category).'
                                </div>
                            </div>
                        </div>
                    </div>';
            echo $html ;
        }
    }
}

/**
 * Show the banner image , does a proportional resize
 *
 * @param int $maxHeight The maximum height of the Image
 *
 * @return string The img container , with attributes
 */
function rp_get_banner_image( $maxHeight = 490 ) {
    if( function_exists("get_field") ){
        if(get_field('banner_image')){
            $image = get_field('banner_image');
            $height = $image['height'];
            $width = $image['width'];
            $url = $image['url'];
            $alt = $image['alt'];
            $title = $image['title'];
            $ratio = $width/$height;
            // if height is more then $maxHeight - resize
            if($height > $maxHeight){
                $height = $maxHeight;
                $width = $height*$ratio;
            }
            echo '<img src="'.$url.'" alt="'.$alt.'" title="'.$title.'" height="'.$height.'" width="'.$width.'" />';
        }
    }
}

function rp_get_banner_heading( $fieldName = "custom_page_title" ){
    if( function_exists("get_field") && get_field("banner_headline") ){
        if( !is_home() ){
            switch ( get_field( "banner_headline" ) ){
                case 1 : the_title() ; break;
                case 2 : echo get_field( $fieldName ) ; break;
            }
        }
    }
}
function rp_get_home_banner_heading() {
    if( is_front_page() && function_exists("get_field") && get_field('banner_word1') ){
        $word1 = get_field('banner_word1');
        $word2 = get_field('banner_word2') ? "<span>".get_field('banner_word2')."</span>" : "";
        $word3 = get_field('banner_word3');
        echo "<h2>".$word1." ".$word2." ".$word3."</h2>";
    }
}
function rp_get_home_banner_button($btnClass = "") {
    if( is_front_page() && function_exists("get_field") ){
        if(get_field('banner_btn_text') && get_field('banner_btn_url')) {
            echo '<a href="'.get_field('banner_btn_url').'" class="'.$btnClass.'" title="'.get_field('banner_btn_text').'">'.get_field('banner_btn_text').'</a>';
        }
    }
}
function rp_get_about_section($header_class = "") {
    if( is_front_page() && function_exists("get_field") && get_field('about_word1') ){
        $headline = '<h2>'.get_field('about_word1');
        $headline.= get_field('about_word2') ? ' <span>'.get_field('about_word2').'</span> ' : '';

        $link = get_field('about_link_url') && get_field('about_link_text') ?
            '<a href="'.get_field('about_link_url').'" title="'.get_field('about_link_text').'" >'.get_field('about_link_text').'</a>' : '';

        $headline.=$link.'</h2>';
        $desc = get_field('about_description');

        echo '<header class="'.$header_class.'" >'.$headline.$desc.'</header>';
    }
}

/**
 * Displays the service section for Homepage
 *
 * @param array $args {
 *     Optional. Array of container classes , for easy change from the template file.
 *
 *     @var string        $headerClass           The header class of the section. Default 'cs-headline multicolor-headline'.
 *     @var string        $imgContainerClass     The service image container class. Default 'service-image'.
 *     @var string        $coverClass            The service image cover class. Default 'service-cover'.
 *     @var string        $descriptionClass      The service description container  class. Default 'service-description'.
 *     @var string        $buttonClass           The service button class. Default 'base-button bb-small orange-button'.
 *     @var string        $listContainerClass    The service list container class. Default 'row cnews-list'.
 * }
 * @return string Output of the news section
 */

function rp_get_service_section ($args = array()) {
    if( function_exists("get_field") && get_field('services_word1')) {
        $defaults = empty($args) ?
            array(
                "headerClass" => "cs-headline multicolor-headline",
                "imgContainerClass"=>"service-image",
                "coverClass"=>"service-cover",
                "descriptionClass"=>"service-description",
                "buttonClass"=>"base-button bb-small orange-button",
                "listContainerClass" => 'row services-list'
            ) : $args;

        $serviceHeader = '<header class="'.$defaults['headerClass'].'">';
        $headLink = get_field('services_link_text') && get_field('services_link_url') ?
        '<a href="'.get_field('services_link_url').'" title="'.get_field('services_link_text').'">'.get_field('services_link_text').'</a>' : '';
        $word2 = get_field('services_word2') ? " <span>".get_field('services_word2')."</span> " : "";
        $serviceHeader.= '<h2>'.get_field('services_word1').$word2.$headLink.'</h2>';
        $serviceHeader.=get_field('services_description').'</header>';

        $serviceList ='<div class="'.$defaults['listContainerClass'].'">';
        $imgSize = "serviceThumb";

        for($i = 1; $i <= 4; $i++) {
            $currentItem = 'service'.$i;
            $serviceImage = get_field($currentItem.'_image');
            $imgWidth = $imgSize."-width";
            $imgHeight = $imgSize."-height";
            $serviceList.= '
            <div class="col-xs-3">
                <aside>
                    <div class="'.$defaults['imgContainerClass'].'">
                        <a href="'.get_field($currentItem.'_link_url').'">
                            <span class="'.$defaults['coverClass'].'"></span>
                            <img src="'.$serviceImage['sizes'][$imgSize].'" alt="'.$serviceImage['alt'].'" title="'.$serviceImage['title'].'" width="'.$serviceImage['sizes'][$imgWidth].'" height="'.$serviceImage['sizes'][$imgHeight].'" />
                        </a>
                    </div>
                    <div class="'.$defaults['descriptionClass'].'">
                        <h3><a href="'.get_field($currentItem.'_link_url').'">'.get_field($currentItem.'_link_text').'</a></h3>
                        <p>'.get_field($currentItem.'_description').'</p>
                    </div>
                    <a href="'.get_field($currentItem.'_link_url').'" class="'.$defaults['buttonClass'].'">'.get_field($currentItem.'_link_text').'</a>
                </aside>
            </div>';
        }
        $serviceList.='</div>';
        echo $serviceHeader.$serviceList;
    }
}

/**
 * Displays the Company news section for Homepage
 *
 * @param array $args Optional. Array of container classes , for easy change from the template file.
 *
 *     @type string        $headerClass           The header class of the section. Default 'cs-headline'.
 *     @type string        $imgContainerClass     The News image container class. Default 'news-image'.
 *     @type string        $descriptionClass      The News description container  class. Default 'news-description'.
 *     @type string        $dateClass             The News date container  class. Default 'news-date'.
 *     @type string        $buttonClass           The News button class. Default 'base-button bb-small orange-button'.
 *     @type string        $catBtnClass           The News category button class. Default 'base-button bb-small'.
 *     @type string        $listContainerClass    The News list container class. Default 'news-list'.
 *
 * @return string Output of the services section
 */

function rp_get_news_section($args  = array()) {
    if( function_exists("get_field") && get_field('cnews_word1') ) {
        $defaults = empty($args) ?
            array(
                "headerClass" => "cs-headline",
                "imgContainerClass"=>"news-image",
                "descriptionClass"=>"news-description",
                "dateClass"=>"news-date",
                "catBtnClass"=>"base-button bb-small",
                "buttonClass"=>"base-button bb-small orange-button",
                "listContainerClass" => 'news-list'
            ) : $args;

        $newsHeader ='<header class="'.$defaults['headerClass'].'">';
        $headLink =  get_field('contacts_link_text')&&get_field('cnews_link_url') ?
            '<a href="'.get_field('cnews_link_url').'" title="'.get_field('cnews_link_text').'">'.get_field('cnews_link_text').'</a>' : '';
        $word2 = get_field('cnews_word2') ? " <span>".get_field('cnews_word2')."</span> " : "";
        $newsHeader.= '<h2>'.get_field('cnews_word1').$word2.$headLink.'</h2>';
        $newsHeader.=get_field('cnews_description').'</header>';
        $newsList = '<div class="'.$defaults['listContainerClass'].'">';
        $newsList.= '<div class="row">';
        $imgSize = "newsThumb";

        for($i = 1; $i <= 4; $i++) {
            $currentItem = 'cnews'.$i;
            $newsImage = get_field($currentItem.'_image');
            $imgWidth = $imgSize."-width";
            $imgHeight = $imgSize."-height";
            $date = DateTime::createFromFormat('Ymd',get_field($currentItem.'_date'));
            $newsList.= '
                 <div class="col-xs-6">
                    <aside>
                        <div class="row">
                            <div class="col-xs-6">

                                <div class="'.$defaults['imgContainerClass'].'">
                                    <a href="'.get_field($currentItem.'_link_url').'">
                                        <img src="'.$newsImage['sizes'][$imgSize].'" alt="'.$newsImage['alt'].'" title="'.$newsImage['title'].'" width="'.$newsImage['sizes'][$imgWidth].'" height="'.$newsImage['sizes'][$imgHeight].'" />
                                    </a>
                                </div>
                            </div>
                            <div class="col-xs-6">

                                <div class="'.$defaults['descriptionClass'].'">
                                    <p class="'.$defaults['dateClass'].'">'.$date->format("F j, Y").'</p>
                                    <h3><a href="'.get_field($currentItem.'_link_url').'" title="'.get_field($currentItem.'_link_text').'">'.get_field($currentItem.'_link_text').'</a></h3>
                                    <p>'.get_field($currentItem.'_description').'</p>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="'.get_field($currentItem.'_cat_url').'" class="'.$defaults['catBtnClass'].'" title="'.get_field($currentItem.'_cat_text').'">
                                    '.get_field($currentItem.'_cat_text').'
                                </a>
                            </div>
                            <div class="col-xs-6">
                                <a href="'.get_field($currentItem.'_link_url').'" class="'.$defaults['buttonClass'].'" title="'.get_field($currentItem.'_link_text').'">
                                   '.get_field($currentItem.'_link_text').'
                                </a>
                            </div>
                        </div>
                    </aside>
                 </div>
            ';
            $newsList.= $i % 2 !=1 && $i != 4 ? '</div><div class="row">': '';
        }
        $newsList .='</div></div>';
        echo $newsHeader.$newsList;
    }
}

/**
 * Displays the contacts section for Homepage
 *
 * @param array $args      Optional. Array of container classes , for easy change from the template file.
 *
 *     @type string        $headerClass                      The header class of the section. Default 'cs-headline multicolor-headline'.
 *     @type string        $contactsContainerClass           The Contacts container class. Default 'contact-us'.
 *     @type string        $contactsContainerClass           The Contacts container class. Default 'contact-us'.
 *
 * @return string Output of the contacts section
 */

function rp_get_contacts_section($args = array()){
    if(function_exists("get_field")){
        $defaults = empty($args) ? array(
            'headerClass' => 'cs-headline multicolor-headline',
            'contactsContainerClass' => 'contact-us',
            'mapClass' => 'location-map',
            'infoContainerClass' => 'contact-information',
            'addressClass' => 'address',
            'detailClass' => 'contact-details',
        ) : $args;
        $contactsHeader = '<header class="'.$defaults['headerClass'].'">';
        $headLink =  get_field('contacts_link_text')&&get_field('contacts_link_url') ?
            '<a href="'.get_field('contacts_link_url').'" title="'.get_field('contacts_link_text').'">'.get_field('contacts_link_text').'</a>' : '';
        $word2 = get_field('contacts_word2') ? " <span>".get_field('contacts_word2')."</span> " : "";
        $contactsHeader.= '<h2>'.get_field('contacts_word1').$word2.$headLink.'</h2>';
        $contactsHeader.=get_field('contacts_description').'</header>';
        $contactMap = get_field('contacts_map');
        $contactsSection = '
            <div class="'.$defaults['contactsContainerClass'].'">
                <div class="row">
                    <div class="col-xs-6">
                        <div class="'.$defaults['mapClass'].'">
                            <img src="'.$contactMap['url'].'" alt="'.$contactMap['alt'].'" title="'.$contactMap['title'].'" height="208" width="458" />
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="'.$defaults['infoContainerClass'].'">
                            <h3>'.get_field('contacts_company_name').'</h3>
                            <div class="row">
                                <div class="col-xs-6">
                                    <p class="'.$defaults['addressClass'].'">'.strip_tags(get_field('contacts_company_address'),"<br><a>").'</p>
                                </div>
                                <div class="col-xs-6">
                                    <p class="'.$defaults['detailClass'].'">'.strip_tags(get_field('contacts_company_contacts'),"<br><a>").'</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
        echo $contactsHeader.$contactsSection;
    }
}