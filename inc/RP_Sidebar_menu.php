<?php
class RP_Sidebar_menu extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        parent::__construct(
            'rp_sidebar_menu', // Base ID
            __('RP Sidebar menu', 'rp_sidebar_menu'), // Name
            array( 'description' => __( 'Displays the "RP Theme" menu in the sidebar' ), ) // Args
        );
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        global $post;

        if($post->post_parent)
            $children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0");
        else
            $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
        if ($children) { ?>

        <?php }

        extract( $args );

        $c = ! empty( $instance['count'] ) ? '1' : '0';
        $h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
        $d = ! empty( $instance['dropdown'] ) ? '1' : '0';

        // The first widget Part ?>
        <aside class="widget">
            <ul class="sidebar-menu">
                <?php echo $children; ?>
            </ul>

        <?php
        $cat_args = array('orderby' => 'name', 'show_count' => $c, 'hierarchical' => $h);
        if ( $d ) {
            $cat_args['show_option_none'] = __('Select Category');
            wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $cat_args ) );
            ?>

            <script type='text/javascript'>
                /* <![CDATA[ */
                var dropdown = document.getElementById("cat");
                function onCatChange() {
                    if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
                        location.href = "<?php echo home_url(); ?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
                    }
                }
                dropdown.onchange = onCatChange;
                /* ]]> */
            </script>

        <?php
        } else {
            ?>
            <ul class="sidebar-menu orange-sidebar-menu">
                <?php
                $cat_args['title_li'] = '';
                wp_list_categories( apply_filters( 'widget_categories_args', $cat_args ) );
                ?>
            </ul>
            </aside>
        <?php
        }
    }

    public function form( $instance ) {
        //Defaults
        $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
        $count = isset($instance['count']) ? (bool) $instance['count'] :false;
        $hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
        $dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
        ?>


        <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
            <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown' ); ?></label><br />

            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label><br />

            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
            <label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy' ); ?></label></p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = !empty($new_instance['count']) ? 1 : 0;
        $instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
        $instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;

        return $instance;
    }
}