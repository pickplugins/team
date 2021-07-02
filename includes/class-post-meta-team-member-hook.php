<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


add_action('team_member_metabox_content_general','team_member_metabox_content_general');

function team_member_metabox_content_general($post_id){


    $settings_tabs_field = new settings_tabs_field();
    $team_settings = get_option('team_settings');
    $team_member_meta_fields = isset($team_settings['custom_meta_fields']) ? $team_settings['custom_meta_fields'] : array();

    $team_member_data = get_post_meta($post_id, 'team_member_data', true);

    $member_image = isset($team_member_data['member_image']) ? $team_member_data['member_image'] : '';
    $custom_fields = isset($team_member_data['custom_fields']) ? $team_member_data['custom_fields'] : '';

    //echo '<pre>'.var_export($custom_fields, true).'</pre>';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('General', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose some general settings.', 'team'); ?></p>


        <?php

        $args = array(
            'id'		=> 'member_image',
            'parent'		=> 'team_member_data',
            'title'		=> __('Member image','team'),
            'details'	=> __('Add team member image.','team'),
            'type'		=> 'media',
            'value'		=> $member_image,

        );

        $settings_tabs_field->generate_field($args);

        $input_fields = array();

        if(!empty($team_member_meta_fields))
        foreach ($team_member_meta_fields as $field){

            $field_name = $field['name'];
            $field_meta_key = $field['meta_key'];


            $input_fields[] =array(
                'id'		=> $field_meta_key,
                'parent'		=> 'team_member_data[custom_fields]',
                'title'		=> $field_name,
                'details'	=> '',
                'type'		=> 'text',
                'value'		=> isset($custom_fields[$field_meta_key]) ? $custom_fields[$field_meta_key] : '',
                'default'		=> '',
                'placeholder'   => '',
            );
        }

        $args = array(
            'id'		=> 'team_member_meta_fields',
            'title'		=> __('Meta fields','team'),
            'details'	=> sprintf(__('Customize meta fields. you can customize meta fields here on <a href="%s">setting page</a>','team'), admin_url().'edit.php?post_type=team&page=settings'),
            'type'		=> 'option_group',
            'options'		=> $input_fields,

        );

        $settings_tabs_field->generate_field($args);


        ?>
    </div>
    <?php


}




add_action('team_member_metabox_content_social','team_member_metabox_content_social');


function team_member_metabox_content_social($post_id){


    $settings_tabs_field = new settings_tabs_field();
    $team_settings = get_option('team_settings');

    $team_member_social_field = isset($team_settings['custom_social_fields']) ? $team_settings['custom_social_fields'] : array();

    $team_member_data = get_post_meta($post_id, 'team_member_data', true);

    $member_image = isset($team_member_data['member_image']) ? $team_member_data['member_image'] : '';
    $social_fields = isset($team_member_data['social_fields']) ? $team_member_data['social_fields'] : array();

    //echo '<pre>'.var_export($social_fields, true).'</pre>';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Social', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Fill social & contact list.', 'team'); ?></p>


        <?php


        $input_fields = array();

        if(!empty($team_member_social_field))
        foreach ($team_member_social_field as $field){

            $field_name = $field['name'];
            $field_meta_key = $field['meta_key'];


            $input_fields[] =array(
                'id'		=> $field_meta_key,
                'parent'		=> 'team_member_data[social_fields]',
                'title'		=> $field_name,
                'details'	=> '',
                'type'		=> 'text',
                'value'		=> isset($social_fields[$field_meta_key]) ? $social_fields[$field_meta_key] : '',
                'default'		=> '',
                'placeholder'   => '',
            );
        }

        $args = array(
            'id'		=> 'team_member_meta_fields',
            'title'		=> __('Social fields','team'),
            'details'	=> __('Customize social fields.','team'),
            'type'		=> 'option_group',
            'options'		=> $input_fields,

        );

        $settings_tabs_field->generate_field($args);

        ?>
    </div>

    <?php


}



add_action('team_member_metabox_content_layouts','team_member_metabox_content_layouts');
function team_member_metabox_content_layouts($post_id){


    $settings_tabs_field = new settings_tabs_field();
    $team_member_data = get_post_meta($post_id,'team_member_data', true);
    $layout_id = isset($team_member_data['layout_id']) ? $team_member_data['layout_id'] : '';



    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Layouts', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose item layouts.', 'team'); ?></p>


        <?php

        $item_layout_args = array();

        $query_args['post_type'] 		= array('team_layout');
        $query_args['post_status'] 		= array('publish');
        $query_args['orderby']  		= 'date';
        $query_args['order']  			= 'DESC';
        $query_args['posts_per_page'] 	= -1;
        $wp_query = new WP_Query($query_args);

        if ( $wp_query->have_posts() ) :

            while ( $wp_query->have_posts() ) : $wp_query->the_post();

                $post_id = get_the_id();
                $layout_name = get_the_title();
                $team_thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'full' );
                $team_thumb_url = isset($team_thumb['0']) ? esc_url_raw($team_thumb['0']) : '';

                $layout_options = get_post_meta($post_id,'layout_options', true);
                $layout_preview_img = isset($layout_options['layout_preview_img']) ? $layout_options['layout_preview_img'] : '';

                $team_thumb_url = !empty( $team_thumb_url ) ? $team_thumb_url : $layout_preview_img;

                $item_layout_args[$post_id] = array('name'=>$layout_name, 'link_text'=>'Edit', 'link'=> get_edit_post_link($post_id), 'thumb'=> $team_thumb_url, );

            endwhile;
        endif;





        $args = array(
            'id'		=> 'layout_id',
            'parent' => 'team_member_data',
            'title'		=> __('Team member layout','team'),
            'details'	=> __('Choose team member single page layout.','team'),
            'type'		=> 'radio_image',
            'value'		=> $layout_id,
            'default'		=> '',
            'width'		=> '250px',
            'args'		=> $item_layout_args,
        );

        $settings_tabs_field->generate_field($args);



        ?>
    </div>
    <?php


}









add_action('team_member_metabox_save','team_member_metabox_save');

function team_member_metabox_save($job_id){


    $team_member_data = isset($_POST['team_member_data']) ? team_recursive_sanitize_arr($_POST['team_member_data']) : '';
    update_post_meta($job_id, 'team_member_data', $team_member_data);


//    $job_bm_total_vacancies = isset($_POST['job_bm_total_vacancies']) ? sanitize_text_field($_POST['job_bm_total_vacancies']) : '';
//    update_post_meta($job_id, 'job_bm_total_vacancies', $job_bm_total_vacancies);


}

