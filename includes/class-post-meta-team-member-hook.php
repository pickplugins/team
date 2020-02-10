<?php
if ( ! defined('ABSPATH')) exit;  // if direct access






add_action('team_member_metabox_content_social','team_member_metabox_content_social');


function team_member_metabox_content_social($post_id){


    $settings_tabs_field = new settings_tabs_field();
    $team_settings = get_option('team_settings');

    $team_member_social_field = isset($team_settings['team_member_social_field']) ? $team_settings['team_member_social_field'] : '';

    echo '<pre>'.var_export($team_member_social_field, ture).'</pre>';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Style', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose style settings.', 'team'); ?></p>


        <?php

        foreach ($team_member_social_field as $field){

            $field_name = $field['name'];
            $field_meta_key = $field['meta_key'];


            $meta_fields[] =array(
                'id'		=> $field_meta_key,
                'parent'		=> 'social_fields',
                'title'		=> $field_name,
                'details'	=> '',
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'   => '',
            );
        }

        $args = array(
            'id'		=> 'team_member_meta_fields',
            'title'		=> __('Social fields','related-post'),
            'details'	=> __('Customize social fields.','related-post'),
            'type'		=> 'option_group',
            'options'		=> $meta_fields,

        );

        $settings_tabs_field->generate_field($args);

        ?>
    </div>

        <?php


}



add_action('team_member_metabox_content_general','team_member_metabox_content_general');


function team_member_metabox_content_general($post_id){


    $settings_tabs_field = new settings_tabs_field();

    $team_options = get_post_meta($post_id,'team_options', true);
    $item_width = isset($team_options['item_width']) ? $team_options['item_width'] : array();

    $team_width_large = isset($item_width['large']) ? $item_width['large'] : '';
    $team_width_medium = isset($item_width['medium']) ? $item_width['medium'] : '';
    $team_width_small = isset($item_width['small']) ? $item_width['small'] : '';

    $item_margin = isset($team_options['item_margin']) ? $team_options['item_margin'] : '';
    $item_text_align = isset($team_options['item_text_align']) ? $team_options['item_text_align'] : '';

    $container_background_img_url = isset($team_options['container']['background_img_url']) ? $team_options['container']['background_img_url'] : '';
    $container_background_color = isset($team_options['container']['background_color']) ? $team_options['container']['background_color'] : '';
    $container_text_align = isset($team_options['container']['text_align']) ? $team_options['container']['text_align'] : '';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Style', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose style settings.', 'team'); ?></p>


        <?php


        $args = array(
            'id'		=> 'item_width',
            'title'		=> __('Item width','related-post'),
            'details'	=> __('Set item width.','related-post'),
            'type'		=> 'option_group',
            'options'		=> array(
                array(
                    'id'		=> 'large',
                    'parent'		=> 'team_options[item_width]',
                    'title'		=> __('In desktop','related-post'),
                    'details'	=> __('min-width: 1200px, ex: 45% or 280px','related-post'),
                    'type'		=> 'text',
                    'value'		=> $team_width_large,
                    'default'		=> '',
                    'placeholder'   => '45%',
                ),
                array(
                    'id'		=> 'medium',
                    'parent'		=> 'team_options[item_width]',
                    'title'		=> __('In tablet & small desktop','related-post'),
                    'details'	=> __('min-width: 992px, ex: 90% or 280px','related-post'),
                    'type'		=> 'text',
                    'value'		=> $team_width_medium,
                    'default'		=> '',
                    'placeholder'   => '90%',
                ),
                array(
                    'id'		=> 'small',
                    'parent'		=> 'team_options[item_width]',
                    'title'		=> __('In mobile','related-post'),
                    'details'	=> __('max-width: 768px, ex: 90% or 280px','related-post'),
                    'type'		=> 'text',
                    'value'		=> $team_width_small,
                    'default'		=> '',
                    'placeholder'   => '90%',
                ),
            ),

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'item_margin',
            'parent'		=> 'team_options',
            'title'		=> __('Item margin','job-board-manager'),
            'details'	=> __('Set grid item margin, ex: <code>10px 5px</code>','job-board-manager'),
            'type'		=> 'text',
            'value'		=> $item_margin,
            'default'		=> '',
            'placeholder'		=> '10px 5px',
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'item_text_align',
            'parent'		=> 'team_options',
            'title'		=> __('Item text align','job-board-manager'),
            'details'	=> __('Choose text align for grid items','job-board-manager'),
            'type'		=> 'select',
            'value'		=> $item_text_align,
            'default'		=> '',
            'args'		=> array('left'=>'Left','center'=>'Center', 'right'=>'Right',),
        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'		=> 'item_width',
            'title'		=> __('Container style','related-post'),
            'details'	=> __('Customize container style.','related-post'),
            'type'		=> 'option_group',
            'options'		=> array(
                array(
                    'id'		=> 'background_img_url',
                    'parent'		=> 'team_options[container]',
                    'title'		=> __('Background image','related-post'),
                    'details'	=> __('Container background image','related-post'),
                    'type'		=> 'media_url',
                    'value'		=> $container_background_img_url,
                    'default'		=> '',
                    'placeholder'   => '',
                ),
                array(
                    'id'		=> 'background_color',
                    'parent'		=> 'team_options[container]',
                    'title'		=> __('Background color','related-post'),
                    'details'	=> __('Container background color','related-post'),
                    'type'		=> 'colorpicker',
                    'value'		=> $container_background_color,
                    'default'		=> '',
                    'placeholder'   => '',
                ),
                array(
                    'id'		=> 'text_align',
                    'parent'		=> 'team_options[container]',
                    'title'		=> __('Text align','related-post'),
                    'details'	=> __('Container text align','related-post'),
                    'type'		=> 'select',
                    'value'		=> $container_text_align,
                    'default'		=> '',
                    'args'		=> array('left'=>'Left','center'=>'Center', 'right'=>'Right',),
                ),
            ),

        );

        $settings_tabs_field->generate_field($args);




        ?>
    </div>
    <?php


}











add_action('team_member_metabox_save','team_member_metabox_save');

function team_member_metabox_save($job_id){

    $team_options = isset($_POST['team_options']) ? stripslashes_deep($_POST['team_options']) : '';
    update_post_meta($job_id, 'team_options', $team_options);


//    $job_bm_total_vacancies = isset($_POST['job_bm_total_vacancies']) ? sanitize_text_field($_POST['job_bm_total_vacancies']) : '';
//    update_post_meta($job_id, 'job_bm_total_vacancies', $job_bm_total_vacancies);


}

