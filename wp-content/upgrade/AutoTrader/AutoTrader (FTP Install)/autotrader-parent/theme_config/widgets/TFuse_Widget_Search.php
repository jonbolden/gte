<?php
// =============================== Search widget ======================================

class TF_Widget_Search extends WP_Widget {

	function TF_Widget_Search() {
        $widget_ops = array('classname' => 'widget_search', 'description' => __( "A search form for your site","tfuse") );
        $this->WP_Widget('search', __('TFuse Search','tfuse'), $widget_ops);
	}

	function widget($args, $instance) { 
        extract($args);
        $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
        if (isset($instance['disable_box']) && $instance['disable_box'])
        {
            $before_box = '';
            $after_box ='';
        }
        else {
            $before_box = '<div class="box">';
            $after_box ='</div>';
        }
        echo $before_box; ?>

        <div class="widget-container widget_search">
            <?php if(!empty($title)){ ?><h3><?php echo tfuse_qtranslate($title); ?></h3><?php } ?>
            <form method="get" id="searchform" action="<?php echo home_url( '/' ) ?>">
                <div class="clearfix">
                    <label class="screen-reader-text" for="s"><?php _e('Search for:','tfuse'); ?></label>
                    <input class="inputField" name="s" id="s" value="<?php echo tfuse_options('search_box_text'); ?>" onfocus="if (this.value == '<?php echo tfuse_options('search_box_text'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo tfuse_options('search_box_text'); ?>';}" type="text">
                    <input id="searchsubmit" class="btn-submit" value="<?php _e('Submit','tfuse');?>" type="submit">
                </div>
            </form>
        </div>

    <?php echo $after_box; }

	function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
        $instance['title'] = $new_instance['title'];
        $instance['disable_box'] = isset($new_instance['disable_box']);
        return $instance;
	}

	function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
        $title = $instance['title']; ?>

        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','tfuse'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
        <p><input id="<?php echo $this->get_field_id('disable_box'); ?>" name="<?php echo $this->get_field_name('disable_box'); ?>" type="checkbox" <?php checked(isset($instance['disable_box']) ? $instance['disable_box'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('disable_box'); ?>"><?php _e('Disable box','tfuse'); ?></label></p>
    <?php }
}

function TFuse_Unregister_WP_Widget_Search() {
	unregister_widget('WP_Widget_Search');
}
add_action('widgets_init','TFuse_Unregister_WP_Widget_Search');

register_widget('TF_Widget_Search');