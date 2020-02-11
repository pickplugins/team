<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


add_action('team_member_metabox_content_general','team_member_metabox_content_general');

function team_member_metabox_content_general($post_id){


    $settings_tabs_field = new settings_tabs_field();
    $team_settings = get_option('team_settings');
    $team_member_meta_fields = isset($team_settings['team_member_meta_fields']) ? $team_settings['team_member_meta_fields'] : '';

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
            'title'		=> __('Member image','related-post'),
            'details'	=> __('Add team member image.','related-post'),
            'type'		=> 'media_url',
            'value'		=> $member_image,

        );

        $settings_tabs_field->generate_field($args);


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
            'title'		=> __('Meta fields','related-post'),
            'details'	=> sprintf(__('Customize meta fields. you can customize meta fields here on <a href="%s">setting page</a>','related-post'), admin_url().'edit.php?post_type=team&page=settings'),
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

    $team_member_social_field = isset($team_settings['team_member_social_field']) ? $team_settings['team_member_social_field'] : '';

    $team_member_data = get_post_meta($post_id, 'team_member_data', true);

    $member_image = isset($team_member_data['member_image']) ? $team_member_data['member_image'] : '';
    $social_fields = isset($team_member_data['social_fields']) ? $team_member_data['social_fields'] : array();

    //echo '<pre>'.var_export($social_fields, true).'</pre>';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Social', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Fill social & contact list.', 'team'); ?></p>


        <?php




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
            'title'		=> __('Social fields','related-post'),
            'details'	=> __('Customize social fields.','related-post'),
            'type'		=> 'option_group',
            'options'		=> $input_fields,

        );

        $settings_tabs_field->generate_field($args);

        ?>
    </div>

    <?php


}









add_action('team_member_metabox_save','team_member_metabox_save');

function team_member_metabox_save($job_id){


    $team_member_data = isset($_POST['team_member_data']) ? stripslashes_deep($_POST['team_member_data']) : '';
    update_post_meta($job_id, 'team_member_data', $team_member_data);


//    $job_bm_total_vacancies = isset($_POST['job_bm_total_vacancies']) ? sanitize_text_field($_POST['job_bm_total_vacancies']) : '';
//    update_post_meta($job_id, 'job_bm_total_vacancies', $job_bm_total_vacancies);


}

