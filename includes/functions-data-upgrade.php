<?php
if ( ! defined('ABSPATH')) exit;  // if direct access



add_shortcode('team_cron_upgrade_settings', 'team_cron_upgrade_settings');
add_action('team_cron_upgrade_settings', 'team_cron_upgrade_settings');

function team_cron_upgrade_settings(){

    $team_member_slug = get_option( 'team_member_slug' );
    $team_member_meta_fields = get_option( 'team_member_meta_fields' );
    $team_member_social_field = get_option( 'team_member_social_field' );

    $team_settings = array();
    $team_settings['team_member_slug'] = $team_member_slug;

    $meta_fields_new = array();

    if(!empty($team_member_meta_fields))
    foreach ($team_member_meta_fields as $fieldIndex => $field){
        $field_name = isset($field['name']) ? $field['name'] : '';
        $field_meta_key = isset($field['meta_key']) ? $field['meta_key'] : '';

        $meta_fields_new[] = array('name'=> $field_name, 'meta_key'=> $field_meta_key);
    }

    $meta_fields_new[] = array('name'=> 'Custom link', 'meta_key'=> 'custom_link');

    $team_settings['custom_meta_fields'] = $meta_fields_new;


    $social_fields_new = array();

    if(!empty($team_member_social_field))
    foreach ($team_member_social_field as $fieldIndex => $field){
        $field_name = isset($field['name']) ? $field['name'] : '';
        $field_meta_key = isset($field['meta_key']) ? $field['meta_key'] : '';
        $field_icon = isset($field['icon']) ? $field['icon'] : '';
        $field_visibility = isset($field['visibility']) ? $field['visibility'] : '';

        $social_fields_new[] = array('name'=> $field_name, 'meta_key'=> $field_meta_key, 'icon'=> $field_icon, 'visibility'=> $field_visibility,   );
    }

    $team_settings['custom_social_fields'] = $social_fields_new;


    $update_status = update_option('team_settings', $team_settings);

    if($update_status){
        wp_clear_scheduled_hook('team_cron_upgrade_settings');
        wp_schedule_event(time(), '2minute', 'team_cron_upgrade_team_members');

        $team_plugin_info = get_option('team_plugin_info');
        $team_plugin_info['settings_upgrade'] = 'done';
        update_option('team_plugin_info', $team_plugin_info);

    }




}













add_shortcode('team_cron_upgrade_team_members', 'team_cron_upgrade_team_members');

add_action('team_cron_upgrade_team_members', 'team_cron_upgrade_team_members');

if(!function_exists('team_cron_upgrade_team_members')){
    function team_cron_upgrade_team_members() {



        $team_options = array();
        $meta_query = array();

        $team_settings = get_option('team_settings');
        $custom_meta_fields = isset($team_settings['custom_meta_fields']) ? $team_settings['custom_meta_fields'] : '';
        $custom_social_fields = isset($team_settings['custom_social_fields']) ? $team_settings['custom_social_fields'] : '';

        $meta_query[] = array(
            'key' => 'team_upgrade_status',
            'compare' => 'NOT EXISTS'
        );


        $args = array(
            'post_type' => 'team_member',
            'post_status' => 'any',
            'posts_per_page' => 3,
            'meta_query' => $meta_query,
        );


        $wp_query = new WP_Query($args);


        if ($wp_query->have_posts()) :
            while ($wp_query->have_posts()) : $wp_query->the_post();

                $team_member_id = get_the_id();
                $team_member_data = array();

                $team_member_social_links = get_post_meta( $team_member_id, 'team_member_social_links', true );

                $team_member_position = get_post_meta( $team_member_id, 'team_member_position', true );
                $team_member_data['custom_fields']['position'] = $team_member_position;

                $team_member_link_to_post = get_post_meta( $team_member_id, 'team_member_link_to_post', true );
                $team_member_data['custom_fields']['custom_link'] = $team_member_link_to_post;

                foreach ($custom_meta_fields as $field){
                    $field_name = isset($field['name']) ? $field['name'] : '';
                    $field_meta_key = isset($field['meta_key']) ? $field['meta_key'] : '';


                    if($field_meta_key == 'position' || $field_meta_key == 'custom_link') continue;


                    $meta_value = get_post_meta($team_member_id, $field_meta_key, true);
                    $team_member_data['custom_fields'][$field_meta_key] = $meta_value;
                }


                foreach ($custom_social_fields as $field){
                    $field_name = isset($field['name']) ? $field['name'] : '';
                    $field_meta_key = isset($field['meta_key']) ? $field['meta_key'] : '';

                    $team_member_data['social_fields'][$field_meta_key] = isset($team_member_social_links[$field_meta_key]) ? $team_member_social_links[$field_meta_key] : '';
                }


                $team_thumb = wp_get_attachment_image_src( get_post_thumbnail_id($team_member_id), 'full' );
                $team_thumb_url = isset($team_thumb['0']) ? $team_thumb['0'] : '';

                $team_member_data['member_image'] = $team_thumb_url;



                update_post_meta($team_member_id, 'team_upgrade_status', 'done');

                update_post_meta($team_member_id, 'team_member_data', $team_member_data);


            endwhile;
        else:
            wp_clear_scheduled_hook('team_cron_upgrade_team_members');
            wp_schedule_event(time(), '2minute', 'team_cron_upgrade_team');

            $team_plugin_info = get_option('team_plugin_info');
            $team_plugin_info['team_members_upgrade'] = 'done';
            update_option('team_plugin_info', $team_plugin_info);

        endif;


    }
}






add_shortcode('team_cron_upgrade_team', 'team_cron_upgrade_team');
add_action('team_cron_upgrade_team', 'team_cron_upgrade_team');


function team_cron_upgrade_team(){

    $meta_query = array();

        $meta_query[] = array(
        'key' => 'team_upgrade_status',
        'compare' => 'NOT EXISTS'
    );

    $args = array(
        'post_type'=>'team',
        'post_status'=>'any',
        'posts_per_page'=> 2,
        'meta_query'=> $meta_query,

    );



    $wp_query = new WP_Query($args);


    if ( $wp_query->have_posts() ) :
        while ( $wp_query->have_posts() ) : $wp_query->the_post();

            $team_id = get_the_id();
            $team_title = get_the_title();
            $team_options = array();

            echo $team_title.'<br/>';



            $team_themes = get_post_meta( $team_id, 'team_themes', true );
            $team_items_link_to_post = get_post_meta( $team_id, 'team_items_link_to_post', true );


            $team_items_max_width = get_post_meta( $team_id, 'team_items_max_width', true );
            $team_options['item_width']['large'] = $team_items_max_width;

            $team_items_width_tablet = get_post_meta( $team_id, 'team_items_width_tablet', true );
            $team_options['item_width']['medium'] = $team_items_width_tablet;

            $team_items_width_mobile = get_post_meta( $team_id, 'team_items_width_mobile', true );
            $team_options['item_width']['small'] = $team_items_width_mobile;

            $team_items_margin = get_post_meta( $team_id, 'team_items_margin', true );
            $team_options['item_margin'] = $team_items_margin;

            $team_item_text_align = get_post_meta( $team_id, 'team_item_text_align', true );
            $team_options['item_text_align'] = $team_item_text_align;


            $team_bg_img = get_post_meta( $team_id, 'team_bg_img', true );
            $team_options['container']['background_img_url'] = $team_bg_img;

            $team_container_bg_color = get_post_meta( $team_id, 'team_container_bg_color', true );
            $team_options['container']['background_color'] = $team_container_bg_color;

            $team_grid_item_align = get_post_meta( $team_id, 'team_grid_item_align', true );
            $team_options['container']['text_align'] = $team_grid_item_align;



            $team_query_orderby = get_post_meta( $team_id, 'team_query_orderby', true );
            $team_options['query']['orderby'] = $team_query_orderby;

            $team_query_orderby_meta_key = get_post_meta( $team_id, 'team_query_orderby_meta_key', true );
            $team_options['query']['orderby_meta_key'] = $team_query_orderby_meta_key;

            $team_query_order = get_post_meta( $team_id, 'team_query_order', true );
            $team_options['query']['order'] = $team_query_order;

            $team_total_items = get_post_meta( $team_id, 'team_total_items', true );
            $team_options['query']['post_per_page'] = $team_total_items;

            $team_taxonomy_terms = get_post_meta( $team_id, 'team_taxonomy_terms', true );
            $team_options['query']['taxonomy_terms'] = $team_taxonomy_terms;


            $team_items_custom_css = get_post_meta( $team_id, 'team_items_custom_css', true );
            $team_options['custom_scripts']['custom_css'] = $team_items_custom_css;


            $team_grid_style = get_post_meta( $team_id, 'team_grid_style', true );
            $team_options['view_type'] = $team_grid_style;

            $team_masonry_enable = get_post_meta( $team_id, 'team_masonry_enable', true );
            $team_options['masonry_enable'] = $team_masonry_enable;

            $team_pagination_type = get_post_meta( $team_id, 'team_pagination_type', true );
            $team_options['pagination']['type'] = $team_pagination_type;

            $team_pagination_prev_text = get_post_meta( $team_id, 'team_pagination_prev_text', true );
            $team_options['pagination']['prev_text'] = $team_pagination_prev_text;

            $team_pagination_next_text = get_post_meta( $team_id, 'team_pagination_next_text', true );
            $team_options['pagination']['next_text'] = $team_pagination_next_text;

            $team_pagination_bg_color = get_post_meta( $team_id, 'team_pagination_bg_color', true );
            $team_options['pagination']['background_color'] = $team_pagination_bg_color;

            $team_pagination_active_bg_color = get_post_meta( $team_id, 'team_pagination_active_bg_color', true );
            $team_options['pagination']['active_background_color'] = $team_pagination_active_bg_color;

            // Create layout from team settings.
            $team_grid_items = get_post_meta( $team_id, 'team_grid_items', true );
            unset($team_grid_items['popup']);
            unset($team_grid_items['skill']);
            unset($team_grid_items['meta']);

            $team_options['grid_items'] = $team_grid_items;

            $team_grid_items_hide = get_post_meta( $team_id, 'team_grid_items_hide', true );
            unset($team_grid_items_hide['popup']);
            unset($team_grid_items_hide['skill']);
            unset($team_grid_items_hide['meta']);


            $team_options['items_hide'] = $team_grid_items_hide;


            $layout_elements_data = array();

            $layout_elements_data[0]['wrapper_start']['wrapper_id'] = '';
            $layout_elements_data[0]['wrapper_start']['wrapper_class'] = 'layer-media';
            $layout_elements_data[0]['wrapper_start']['css_idle'] = '';

            $team_items_thumb_size = get_post_meta( $team_id, 'team_items_thumb_size', true );
            $team_items_thumb_max_hieght = get_post_meta( $team_id, 'team_items_thumb_max_hieght', true );
            $team_items_thumb_max_hieght_tablet = get_post_meta( $team_id, 'team_items_thumb_max_hieght_tablet', true );
            $team_items_thumb_max_hieght_mobile = get_post_meta( $team_id, 'team_items_thumb_max_hieght_mobile', true );

            $layout_elements_data[1]['thumbnail']['thumb_size'] = $team_items_thumb_size;
            $layout_elements_data[1]['thumbnail']['thumb_height']['large'] = $team_items_thumb_max_hieght;
            $layout_elements_data[1]['thumbnail']['thumb_height']['medium'] = $team_items_thumb_max_hieght_tablet;
            $layout_elements_data[1]['thumbnail']['thumb_height']['small'] = $team_items_thumb_max_hieght_mobile;

            $layout_elements_data[2]['wrapper_end']['wrapper_id'] = '';


            $layout_elements_data[3]['wrapper_start']['wrapper_id'] = '';
            $layout_elements_data[3]['wrapper_start']['wrapper_class'] = 'layer-content';
            $layout_elements_data[3]['wrapper_start']['css_idle'] = '';



            $item_count = 4;
            foreach ($team_grid_items as $itemIndex => $item){


                if($itemIndex == 'thumbnail'){

                }elseif($itemIndex == 'social'){
                    $team_items_social_icon_type = get_post_meta( $team_id, 'team_items_social_icon_type', true );
                    $team_items_social_icon_width = get_post_meta( $team_id, 'team_items_social_icon_width', true );
                    $team_items_social_icon_height = get_post_meta( $team_id, 'team_items_social_icon_height', true );
                    $team_items_social_font_family = get_post_meta( $team_id, 'team_items_social_font_family', true );

                    $layout_elements_data[$item_count]['social']['social_icon_type'] = $team_items_social_icon_type;
                    $layout_elements_data[$item_count]['social']['social_icon_width'] = $team_items_social_icon_width;
                    $layout_elements_data[$item_count]['social']['social_icon_height'] = $team_items_social_icon_height;

                    $layout_elements_data[$item_count]['social']['font_size'] = '';
                    $layout_elements_data[$item_count]['social']['color'] = '';
                    $layout_elements_data[$item_count]['social']['font_family'] = $team_items_social_font_family;

                }elseif($itemIndex == 'title'){
                    $team_items_title_font_size = get_post_meta( $team_id, 'team_items_title_font_size', true );
                    $team_items_title_font_family = get_post_meta( $team_id, 'team_items_title_font_family', true );
                    $team_items_title_color = get_post_meta( $team_id, 'team_items_title_color', true );

                    $layout_elements_data[$item_count]['title']['color'] = $team_items_title_color;
                    $layout_elements_data[$item_count]['title']['font_size'] = $team_items_title_font_size;
                    $layout_elements_data[$item_count]['title']['font_family'] = $team_items_title_font_family;

                }elseif($itemIndex == 'position'){
                    $team_items_position_font_size = get_post_meta( $team_id, 'team_items_position_font_size', true );
                    $team_items_position_font_family = get_post_meta( $team_id, 'team_items_position_font_family', true );
                    $team_items_position_color = get_post_meta( $team_id, 'team_items_position_color', true );

                    $layout_elements_data[$item_count]['position']['color'] = $team_items_position_color;
                    $layout_elements_data[$item_count]['position']['font_size'] = $team_items_position_font_size;
                    $layout_elements_data[$item_count]['position']['font_family'] = $team_items_position_font_family;

                }elseif($itemIndex == 'content'){

                    $team_items_content = get_post_meta( $team_id, 'team_items_content', true );
                    $team_items_excerpt_count = get_post_meta( $team_id, 'team_items_excerpt_count', true );
                    $team_items_excerpt_text = get_post_meta( $team_id, 'team_items_excerpt_text', true );
                    $team_items_content_color = get_post_meta( $team_id, 'team_items_content_color', true );
                    $team_items_content_font_size = get_post_meta( $team_id, 'team_items_content_font_size', true );
                    $team_items_content_font_family = get_post_meta( $team_id, 'team_items_content_font_family', true );

                    $layout_elements_data[$item_count]['content']['content_source'] = $team_items_content;
                    $layout_elements_data[$item_count]['content']['word_count'] = $team_items_excerpt_count;
                    $layout_elements_data[$item_count]['content']['read_more_text'] = $team_items_excerpt_text;

                    $layout_elements_data[$item_count]['content']['color'] = $team_items_content_color;
                    $layout_elements_data[$item_count]['content']['read_more_color'] = $team_items_content_color;

                    $layout_elements_data[$item_count]['content']['font_size'] = $team_items_content_font_size;
                    $layout_elements_data[$item_count]['content']['font_family'] = $team_items_content_font_family;
                }

                $item_count++;
            }

            $layout_elements_data[$item_count]['wrapper_end']['wrapper_id'] = '';


            $team_layout_id = wp_insert_post(
                array(
                    'post_title'    => $team_id.' - '.$team_title,
                    'post_content'  => '',
                    'post_status'   => 'publish',
                    'post_type'   	=> 'team_layout',
                    'post_author'   => 1,
                )
            );


            $team_options['item_layout_id'] = $team_layout_id;

            update_post_meta($team_id, 'team_options', $team_options);
            update_post_meta($team_layout_id, 'layout_elements_data', $layout_elements_data);
            update_post_meta($team_id, 'team_upgrade_status', 'done');



            wp_reset_query();
            wp_reset_postdata();
        endwhile;
    else:
        wp_clear_scheduled_hook('team_cron_upgrade_team');

        $team_plugin_info = get_option('team_plugin_info');
        $team_plugin_info['team_upgrade'] = 'done';
        update_option('team_plugin_info', $team_plugin_info);
    endif;


}



		
		
		
		

		
		