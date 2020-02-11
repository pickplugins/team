<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

add_action('team_settings_content_general', 'team_settings_content_general');

function team_settings_content_general(){
    $settings_tabs_field = new settings_tabs_field();

    $team_settings = get_option('team_settings');

    $team_member_slug = isset($team_settings['team_member_slug']) ? $team_settings['team_member_slug'] : '';
    $custom_meta_fields = isset($team_settings['custom_meta_fields']) ? $team_settings['custom_meta_fields'] : '';
    $custom_social_fields = isset($team_settings['custom_social_fields']) ? $team_settings['custom_social_fields'] : '';

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
            'id'		=> 'custom_meta_fields',
            'parent'		=> 'team_settings',
            'title'		=> __('Custom meta fields','text-domain'),
            'details'	=> __('Custom meta fields on team member profile','text-domain'),
            'collapsible'=> true,
            'type'		=> 'repeatable',
            'limit'		=> 10,
            'title_field'		=> 'name',
            'value'		=> $custom_meta_fields,
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
                'type'		=> 'media_url',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '',
            ),
            array(
                'id'		=> 'visibility',
                'title'		=> __('Visibility','team'),
                'details'	=> __('Write meta key here.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> '',
                'args'		=> array('1'=>'Yes',''=>'No'),
            ),

        );


        $args = array(
            'id'		=> 'custom_social_fields',
            'parent'		=> 'team_settings',
            'title'		=> __('Custom social fields','text-domain'),
            'details'	=> __('Custom social fields on team member profile','text-domain'),
            'collapsible'=> true,
            'type'		=> 'repeatable',
            'limit'		=> 10,
            'title_field'		=> 'name',
            'value'		=> $custom_social_fields,
            'fields'    => $social_field,
        );

        $settings_tabs_field->generate_field($args);



        ?>

    </div>

    <?php





}




add_action('team_settings_content_help_support', 'team_settings_content_help_support');

if(!function_exists('team_settings_content_help_support')) {
    function team_settings_content_help_support($tab){

        $settings_tabs_field = new settings_tabs_field();

        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Get support', 'team'); ?></div>
            <p class="description section-description"><?php echo __('Use following to get help and support from our expert team.', 'team'); ?></p>

            <?php


            ob_start();
            ?>

            <p><?php echo __('Ask question for free on our forum and get quick reply from our expert team members.', 'team'); ?></p>
            <a class="button" href="https://www.pickplugins.com/create-support-ticket/"><?php echo __('Create support ticket', 'team'); ?></a>

            <p><?php echo __('Read our documentation before asking your question.', 'team'); ?></p>
            <a class="button" href="https://www.pickplugins.com/documentation/team/"><?php echo __('Documentation', 'team'); ?></a>

            <p><?php echo __('Watch video tutorials.', 'team'); ?></p>
            <a class="button" href="https://www.youtube.com/playlist?list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy"><i class="fab fa-youtube"></i> <?php echo __('All tutorials', 'team'); ?></a>

            <ul>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=9SZKa0QYgsc">How to install & setup</a></li>

            </ul>



            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'get_support',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Ask question','team'),
                'details'	=> '',
                'type'		=> 'custom_html',
                'html'		=> $html,

            );

            $settings_tabs_field->generate_field($args);


            ob_start();
            ?>

            <p class="">We wish your 2 minutes to write your feedback about the related post plugin. give us <span style="color: #ffae19"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>

            <a target="_blank" href="https://wordpress.org/plugins/team/#reviews" class="button"><i class="fab fa-wordpress"></i> Write a review</a>


            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'reviews',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Submit reviews','team'),
                'details'	=> '',
                'type'		=> 'custom_html',
                'html'		=> $html,

            );

            $settings_tabs_field->generate_field($args);

            ?>


        </div>
        <?php


    }
}













add_action('team_settings_save', 'team_settings_save');

function team_settings_save(){

    $team_settings = isset($_POST['team_settings']) ?  stripslashes_deep($_POST['team_settings']) : array();
    update_option('team_settings', $team_settings);
}
