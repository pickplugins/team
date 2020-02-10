<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


add_action('team_settings_content_general', 'team_settings_content_general');

function team_settings_content_general(){
    $settings_tabs_field = new settings_tabs_field();

    $team_settings = get_option('team_settings');

    $team_member_slug = isset($team_settings['team_member_slug']) ? $team_settings['team_member_slug'] : '';
    $team_member_meta_fields = isset($team_settings['team_member_meta_fields']) ? $team_settings['team_member_meta_fields'] : '';
    $team_member_social_field = isset($team_settings['team_member_social_field']) ? $team_settings['team_member_social_field'] : '';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('General', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose some general options.', 'team'); ?></p>

        <?php

        $args = array(
            'id'		=> 'wrapper_id',
            'parent' => 'team_settings',
            'title'		=> __('Team member slug','breadcrumb'),
            'details'	=> __('Write custom team member slug.','breadcrumb'),
            'type'		=> 'text',
            'value'		=> $team_member_slug,
            'default'		=> '',
            'placeholder'		=> 'volunteers',
        );

        $settings_tabs_field->generate_field($args);


        $meta_fields = array(

            array(
                'id'		=> 'name',
                'title'		=> __('Meta Name','team'),
                'details'	=> __('Write meta field name here.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> 'Address',
            ),
            array(
                'id'		=> 'meta_key',
                'title'		=> __('Meta key','team'),
                'details'	=> __('Write meta key here.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> 'meta_key',
            ),


        );


        $args = array(
            'id'		=> 'team_member_meta_fields',
            'parent'		=> 'team_settings',
            'title'		=> __('Custom meta fields','text-domain'),
            'details'	=> __('Custom meta fields on team member profile','text-domain'),
            'collapsible'=> true,
            'type'		=> 'repeatable',
            'limit'		=> 10,
            'title_field'		=> 'name',
            'value'		=> $team_member_meta_fields,
            'fields'    => $meta_fields,
        );

        $settings_tabs_field->generate_field($args);




        $social_field = array(

            array(
                'id'		=> 'name',
                'title'		=> __('Meta Name','team'),
                'details'	=> __('Write meta field name here.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '',
            ),
            array(
                'id'		=> 'meta_key',
                'title'		=> __('Meta key','team'),
                'details'	=> __('Write meta key here.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> 'meta_key',
            ),

            array(
                'id'		=> 'icon',
                'title'		=> __('Add icon','team'),
                'details'	=> __('Write meta key here.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '',
            ),
            array(
                'id'		=> 'visibility',
                'title'		=> __('Visibility','team'),
                'details'	=> __('Write meta key here.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '',
            ),

        );


        $args = array(
            'id'		=> 'team_member_social_field',
            'parent'		=> 'team_settings',
            'title'		=> __('Custom meta fields','text-domain'),
            'details'	=> __('Custom meta fields on team member profile','text-domain'),
            'collapsible'=> true,
            'type'		=> 'repeatable',
            'limit'		=> 10,
            'title_field'		=> 'name',
            'value'		=> $team_member_social_field,
            'fields'    => $social_field,
        );

        $settings_tabs_field->generate_field($args);



        ?>

    </div>

    <?php





}




add_action('team_settings_save', 'team_settings_save');

function team_settings_save(){

    $team_settings = isset($_POST['team_settings']) ?  stripslashes_deep($_POST['team_settings']) : array();
    update_option('team_settings', $team_settings);
}
