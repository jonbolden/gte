<?php
/**
 * Vehicle Types
 *
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 *
 */

function tfuse_vehicle_types($atts, $content) {
    global $slide;
    $slide='';
    extract(shortcode_atts(array('title' => ''), $atts));
    $get_vehicle_types = do_shortcode($content);
    $taxonomy = TF_SEEK_HELPER::get_post_type().'_type';
    $args = array(
        'include' => $slide['category'],
        'orderby' => 'none',
    );
    $term_arr = get_terms($taxonomy,$args);
    $term_arr_ord = array();
    foreach($slide['category'] as $key=>$ord){
        foreach($term_arr as $unord){
            if($ord==$unord->term_id) {
                $term_arr_ord[$key] = $unord;
                continue;
            }
        }
    }

    $output = '<div class="car_types_list">
            	<h2>'.tfuse_qtranslate($title).'</h2>
                <ul>';
    $i = 0;
    while (isset($slide['category'][$i]) && $slide['category'][$i] != '0') {
        $link = get_term_link( $term_arr_ord[$i]->slug, $taxonomy );
        if( isset($link->errors) ) $link = '#';
        $output .= '<li class="type_hover cart_type_'.($i+1).'">
                    <a href="'.$link.'" class="front"><strong>'.$term_arr_ord[$i]->name.'</strong> <em>' .$term_arr_ord[$i]->count.' '. __('OFFERS','tfuse').'</em></a>
                    <a href="'.$link.'" class="back"><strong>'.$term_arr_ord[$i]->name.'</strong> <em>'.__('View more','tfuse').'</em></a>
                </li>
                <style>
                    .car_types_list li.cart_type_'.($i+1).' .front {background-image:url('.$slide['image1'][$i].')}
                    .car_types_list li.cart_type_'.($i+1).' .back {background-image:url('.$slide['image2'][$i].')}
                </style>';
        $i++;
    }
    $output .= '</ul><a href="?s=~&tfseekfid=main_search" class="link_more">'.__('SEE ALL OUR OFFERS','tfuse').'</a></div>
        <script>
			jQuery(document).ready(function() {
				jQuery(".type_hover").hover(function(){
					jQuery(this).addClass("flip");
				},function(){
					jQuery(this).removeClass("flip");
				});
			});</script>';
    return $output;
}

$atts = array(
    'name' => __('Vehicle Types','tfuse'),
    'desc' => __('Here comes some lorem ipsum description for the shortcode.','tfuse'),
    'category' => 4,
    'options' => array(
        array(
            'name' => __('Title','tfuse'),
            'desc' => '',
            'id' => 'tf_shc_vehicle_types_title',
            'value' => 'Choose from a wide variety of vehicles',
            'type' => 'text'
        ),
        array(
            'name' => __('Vehicle Type','tfuse'),
            'desc' => __('Select the category of vehicle type','tfuse'),
            'id' => 'tf_shc_vehicle_types_category',
            'value' => '0',
            'properties' => array('class' => 'tf_shc_addable_0 tf_shc_addable'),
            'options' => tfuse_list_vehicle_types(),
            'type' => 'select'
        ),
        array(
            'name' => __('Image 1','tfuse'),
            'desc' => '',
            'id' => 'tf_shc_vehicle_types_image1',
            'value' => '',
            'properties' => array('class' => 'tf_shc_addable_1 tf_shc_addable'),
            'type' => 'text'
        ),
        array(
            'name' => __('Image 2','tfuse'),
            'desc' => '',
            'id' => 'tf_shc_vehicle_types_image2',
            'value' => '',
            'properties' => array('class' => 'tf_shc_addable_2 tf_shc_addable tf_shc_addable_last'),
            'type' => 'text'
        )

    )
);

tf_add_shortcode('vehicle_types', 'tfuse_vehicle_types', $atts);


function tfuse_vehicle_type($atts, $content = null)
{
    global $slide;
    extract(shortcode_atts(array('category' => '', 'image1' => '', 'image2' => ''), $atts));
    $slide['category'][] = $category;
    $slide['image1'][] = $image1;
    $slide['image2'][] = $image2;
}

$atts = array(
    'name' => __('Vehicle type','tfuse'),
    'desc' => __('Here comes some lorem ipsum description for the vehicle_type shortcode.','tfuse'),
    'category' => 3,
    'options' => array(
        array(
            'name' => __('Vehicle Type','tfuse'),
            'desc' => __('Select the category of vehicle type','tfuse'),
            'id' => 'tf_shc_vehicle_type_category',
            'value' => '0',
            'options' =>tfuse_list_vehicle_types(),
            'type' => 'select'
        ),
        array(
            'name' => __('Image1','tfuse'),
            'desc' => '',
            'id' => 'tf_shc_vehicle_type_image2',
            'value' => '',
            'type' => 'text'
        ),
        array(
            'name' => __('Image2','tfuse'),
            'desc' => '',
            'id' => 'tf_shc_vehicle_type_image2',
            'value' => '',
            'type' => 'text'
        )
    )
);

add_shortcode('vehicle_type', 'tfuse_vehicle_type', $atts);