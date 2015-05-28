<?php

if (!function_exists('tfuse_rewrite_worpress_reading_options')):

    /**
     *
     *
     * To override tfuse_rewrite_worpress_reading_options() in a child theme, add your own tfuse_rewrite_worpress_reading_options()
     * to your child theme's file.
     */

    add_action('tfuse_admin_save_options','tfuse_rewrite_worpress_reading_options', 10, 1);

    function tfuse_rewrite_worpress_reading_options ($options)
    {
        if($options[TF_THEME_PREFIX . '_homepage_category'] == 'page')
        {
            update_option('show_on_front', 'page');

            if(get_post_type(intval($options[TF_THEME_PREFIX . '_home_page'])) == 'page')
            {
                update_option('page_on_front', intval($options[TF_THEME_PREFIX . '_home_page']));
            }

            if(get_post_type(intval($options[TF_THEME_PREFIX . '_blog_page'])) == 'page')
            {
                update_option('page_for_posts', intval($options[TF_THEME_PREFIX . '_blog_page']));
            }
            else
            {
                update_option('page_for_posts', 0);
            }
        }
        else
        {
            update_option('show_on_front', 'posts');
            update_option('page_on_front', 0);
            update_option('page_for_posts', 0);
        }

    }
endif;

if (!function_exists('tfuse_ajax_get_terms')){
    function tfuse_ajax_get_terms(){
        global $TFUSE;
        $parent = (!$TFUSE->request->empty_POST('parent')) ? $TFUSE->request->POST('parent') : 0;
        $taxonomy = TF_SEEK_HELPER::get_post_type() . '_' . $TFUSE->request->POST('taxonomy');
        $args = array(
            'parent'        => $parent,
            'hide_empty'    => false
        );
        $terms = get_terms($taxonomy,$args);
        if(is_wp_error($terms)) $terms = array();
        $response = array(
            'parent'        =>$parent,
            'terms'         =>$terms,
            'terms_size'    =>sizeof($terms)
        );
        echo json_encode($response);
        die();
    }
}
add_action('wp_ajax_tfuse_ajax_get_terms','tfuse_ajax_get_terms');
add_action('wp_ajax_nopriv_tfuse_ajax_get_terms','tfuse_ajax_get_terms');

if (!function_exists('mb_ucfirst')) {
    function mb_ucfirst($str, $encoding = "UTF-8", $lower_str_end = false) {
        $first_letter = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding);
        $str_end = "";
        if ($lower_str_end) {
            $str_end = mb_strtolower(mb_substr($str, 1, mb_strlen($str, $encoding), $encoding), $encoding);
        }
        else {
            $str_end = mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
        }
        $str = $first_letter . $str_end;
        return $str;
    }
}


if (!function_exists('tfuse_aasort')) :
    /**
     *
     *
     * To override tfuse_aasort() in a child theme, add your own tfuse_aasort()
     * to your child theme's file.
     */
    function tfuse_aasort ($array, $key) {
        $sorter=array();
        $ret=array();
        if (!$array){$array = array();}
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii]=$va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii]=$array[$ii];
        }
        return $ret;
    }
endif;


if (!function_exists('tfuse_get_term_parent')):

    /*
     * To override tfuse_get_term_parent() in a child theme, add your own tfuse_get_term_parent()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
    */

    function tfuse_get_term_parent( $term_id, $taxonomy ) {
        if ( ! taxonomy_exists($taxonomy) )
            return new WP_Error('invalid_taxonomy', __('Invalid taxonomy','tfuse'));

        $term_id = intval( $term_id );
        $parents = array();
        $term = get_term( $term_id, $taxonomy );
        $parent_id = $term->parent;
        $parents[] = $parent_id;
        while ( $parent_id != 0 )
        {
            $term = get_term( $parent_id, $taxonomy );
            $parent_id = $term->parent;
            $parents[] = $parent_id;
        }
        array_pop($parents);
        return $parents;
    }

endif;

if (!function_exists('tfuse_ajax_get_parents')) :
    /**
     *
     *
     * To override tfuse_ajax_get_parents() in a child theme, add your own tfuse_ajax_get_parents()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_ajax_get_parents ()
    {
        global $TFUSE;
        $id = intval($TFUSE->request->POST('id'));
        $parents = tfuse_get_term_parent( $id,'holiday_locations');
        echo json_encode($parents);
        die();
    }

    add_action('wp_ajax_tfuse_ajax_get_parents','tfuse_ajax_get_parents');
    add_action('wp_ajax_nopriv_tfuse_ajax_get_parents','tfuse_ajax_get_parents');

endif;

if (!function_exists('tfuse_ajax_get_childs')) :
    /**
     *
     *
     * To override tfuse_ajax_get_childs() in a child theme, add your own tfuse_ajax_get_childs()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_ajax_get_childs ()
    {
        global $TFUSE;
        $id = intval($TFUSE->request->POST('id'));
        $childs = get_term_children( $id,'property_locations');
        echo json_encode($childs);
        die();
    }

    add_action('wp_ajax_tfuse_ajax_get_childs','tfuse_ajax_get_childs');
    add_action('wp_ajax_nopriv_tfuse_ajax_get_childs','tfuse_ajax_get_childs');

endif;


if (!function_exists('tfuse_send_contact_seller')) :
    /**
     *
     *
     * To override tfuse_send_contact_seller() in a child theme, add your own tfuse_send_contact_seller()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */
    function tfuse_send_contact_seller()
    {
        global $TFUSE;
        $client_name    = $TFUSE->request->POST('client_name');
        $client_email   = $TFUSE->request->POST('client_email');
        $checkbox       = $TFUSE->request->POST('checkbox');
        $seller_message = $TFUSE->request->POST('seller_message');
        $author_id      = intval($TFUSE->request->POST('author_id'));

        $the_blogname   = esc_attr(get_bloginfo('name'))." - ".$client_email;
        $the_myemail    = get_the_author_meta('user_email',$author_id);

        $send_options   = get_option(TF_THEME_PREFIX . '_tfuse_contact_form_general');
        $message = '';

        $message .= $checkbox . " <strong>" . $client_name . "</strong><br />";
        $message .= __('Email:','tfuse')." <strong>" .$client_email . "</strong><br />";
        $message .= "<strong>". $seller_message ."</strong><br />";

        $headers = __('From:','tfuse') . $the_blogname;
        add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));

        if ($send_options['mail_type'] == 'wpmail')
        {
            if(wp_mail($the_myemail, __('From : ','tfuse') . $the_blogname, $message, $headers))
                echo 'true';
            else
                echo 'false';

            die();
        }
        elseif($send_options['mail_type'] == 'smtp')
        {
            require_once ABSPATH . WPINC . '/class-phpmailer.php';
            require_once ABSPATH . WPINC . '/class-smtp.php';
            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->IsHTML(true);
            $phpmailer->Port = $send_options['smtp_port'];
            $phpmailer->Host = $send_options['smtp_host'];
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPDebug = false;
            $phpmailer->SMTPSecure = ($send_options['secure_conn'] != 'no') ? $send_options['secure_conn'] : null;
            $phpmailer->Username = $send_options['smtp_user'];
            $phpmailer->Password = $send_options['smtp_pwd'];
            $phpmailer->From   = $the_myemail;
            $phpmailer->FromName   = $the_myemail;
            $phpmailer->Subject    = __('From :','tfuse') . ' ' . $the_blogname;
            $phpmailer->Body       = $message;
            $phpmailer->AltBody    = __('To view the message, please use an HTML compatible email viewer!','tfuse');
            $phpmailer->WordWrap   = 50;
            $phpmailer->MsgHTML($message);
            $phpmailer->AddAddress($the_myemail);

            if(!$phpmailer->Send()) {
                echo "false" . $phpmailer->ErrorInfo;
            } else {
                echo "true";
            }
            die();
        }
        else
        {
            if(wp_mail($the_myemail, __('From :','tfuse') . ' ' . $the_blogname, $message, $headers))
            {
                echo 'true';
                die();
            }
            else
            {
                echo 'false';
                die();
            }
        }
    }

endif;
add_action('wp_ajax_tfuse_send_contact_seller','tfuse_send_contact_seller');
add_action('wp_ajax_nopriv_tfuse_send_contact_seller','tfuse_send_contact_seller');


// for send to a friend
if (!function_exists('tfuse_send_to_a_friend')) :
    /**
     *
     *
     * To override tfuse_send_to_a_friend() in a child theme, add your own tfuse_send_to_a_friend()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */
    function tfuse_send_to_a_friend()
    {
        global $TFUSE;
        $email_from = $TFUSE->request->POST('email_from');
        $the_myemail = $TFUSE->request->POST('email_send_to');
        $message = $TFUSE->request->POST('message');

        $send_options = get_option(TF_THEME_PREFIX . '_tfuse_contact_form_general');

        $headers = __('From:','tfuse') . $email_from;
        add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));

        if ($send_options['mail_type'] == 'wpmail')
        {
            if(wp_mail($the_myemail, __('From : ','tfuse') . $email_from, $message, $headers))
                echo 'true';
            else
                echo 'false';

            die();
        }
        elseif($send_options['mail_type'] == 'smtp')
        {
            require_once ABSPATH . WPINC . '/class-phpmailer.php';
            require_once ABSPATH . WPINC . '/class-smtp.php';
            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->IsHTML(true);
            $phpmailer->Port = $send_options['smtp_port'];
            $phpmailer->Host = $send_options['smtp_host'];
            $phpmailer->SMTPAuth = true;
            $phpmailer->SMTPDebug = false;
            $phpmailer->SMTPSecure = ($send_options['secure_conn'] != 'no') ? $send_options['secure_conn'] : null;
            $phpmailer->Username = $send_options['smtp_user'];
            $phpmailer->Password = $send_options['smtp_pwd'];
            $phpmailer->From   = $the_myemail;
            $phpmailer->FromName   = $the_myemail;
            $phpmailer->Subject    = __('From :','tfuse') . ' ' . $email_from;
            $phpmailer->Body       = $message;
            $phpmailer->AltBody    = __('To view the message, please use an HTML compatible email viewer!','tfuse');
            $phpmailer->WordWrap   = 50;
            $phpmailer->MsgHTML($message);
            $phpmailer->AddAddress($the_myemail);

            if(!$phpmailer->Send()) {
                echo "false" . $phpmailer->ErrorInfo;
            } else {
                echo "true";
            }
            die();
        }
        else
        {
            if(wp_mail($the_myemail, __('From :','tfuse') . ' ' . $email_from, $message, $headers))
            {
                echo 'true';
                die();
            }
            else
            {
                echo 'false';
                die();
            }
        }
    }

endif;
add_action('wp_ajax_tfuse_send_to_a_friend','tfuse_send_to_a_friend');
add_action('wp_ajax_nopriv_tfuse_send_to_a_friend','tfuse_send_to_a_friend');
