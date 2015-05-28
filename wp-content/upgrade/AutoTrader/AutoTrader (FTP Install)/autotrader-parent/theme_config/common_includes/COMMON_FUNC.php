<?php
/**
 * Functions to select homepage category
 *
 * @since AutoTrader 1.0
 */


if (!function_exists('tfuse_get_property_terms')) :
    /**
     *
     *
     * To override tfuse_get_property_terms() in a child theme, add your own tfuse_get_property_terms()
     * to your child theme's file.
     */

    function tfuse_get_property_terms( $taxonomy) {

        global $wpdb;
        $SQL = "SELECT $wpdb->terms.term_id, $wpdb->terms.name
            FROM  $wpdb->terms INNER JOIN $wpdb->term_taxonomy ON $wpdb->terms.term_id = $wpdb->term_taxonomy.term_id
            WHERE $wpdb->term_taxonomy.taxonomy = '" . $taxonomy ."'";

        $results =  $wpdb->get_results($SQL);
        return $results;

    }
endif;

if (!function_exists('tfuse_list_page_options')) :
    function tfuse_list_page_options() {
        $pages = get_pages();
        $result = array();
        $result[0] = 'Select a page';
        foreach ( $pages as $page ) {
            $result[ $page->ID ] = $page->post_title;
        }
        return $result;
    }
endif;

// get vehicle types
if (!function_exists('tfuse_list_vehicle_types')) :
    function tfuse_list_vehicle_types() {
        $args = array(
            'orderby'       => 'name',
            'order'         => 'ASC',
            'hide_empty'    => true,
        );
        $taxonomies = get_terms(TF_SEEK_HELPER::get_post_type().'_type', $args);
        $result = array();
        $result[0] = 'Select a vehicle type';
        foreach ( $taxonomies as $tax ) {
            $result[ $tax->term_id ] = $tax->name;
        }
        return $result;
    }
endif;

// get vehicle post list
if (!function_exists('tfuse_list_vehicle_post')) :
    function tfuse_list_vehicle_post() {
        $args = array(
            'posts_per_page'  => -1,
            'orderby'         => 'post_date',
            'order'           => 'DESC',
            'post_type'       => TF_SEEK_HELPER::get_post_type(),
            'post_status'     => 'publish',
        );
        $posts_array = get_posts( $args );
        $result = array();
        $result[0] = 'Select a vehicle';
        foreach ( $posts_array as $vehicle ) {
            $result[ $vehicle->ID ] = $vehicle->post_title;
        }
        return $result;
    }
endif;