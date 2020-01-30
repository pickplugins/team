<?php

/*
* @Author 		PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access





add_action('team_template_settings_tabs_content_layout', 'team_template_settings_tabs_content_layout',10, 2);

function team_template_settings_tabs_content_layout($tab, $post_id){

    $settings_tabs_field = new settings_tabs_field();
    $team_options = get_post_meta($post_id, 'team_template_options', true);

    $team_members = !empty($team_options['team_members']) ? $team_options['team_members'] : array();
    $skill = isset($team_options['skill']) ? $team_options['skill'] : array();
    $contacts = isset($team_options['contacts']) ? $team_options['contacts'] : array();

    ?>
    <pre><?php

        //echo var_export($team_members, true);

        ?></pre>
    <?php


    ?>
    <div class="section">
        <div class="section-title">Team members</div>
        <p class="description section-description">Simply copy these shortcode and user under content</p>

        <?php


        $teams_fields = array(

            array(
                'id'		=> 'name',
                'title'		=> __('Name','team'),
                'details'	=> __('Write name here.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> 'Mark Jhon',
            ),
            array(
                'id'		=> 'content',
                'title'		=> __('Content','team'),
                'details'	=> __('Write details text here.','team'),
                'type'		=> 'textarea',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> 'Content here...',
            ),



            array(
                'id'		    => 'thumbnail',
                'title'		    => __('Thumbnail ','text-domain'),
                'details'	    => __('Add thumbnail','text-domain'),
                'placeholder'	=> 'https://i.imgur.com/GD3zKtz.png',
                'type'		=> 'media',
            ),

            array(
                'id'		=> 'position',
                'title'		=> __('Position','team'),
                'details'	=> __('Write position here.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> 'Lead Developer',
            ),

            array(
                'id'		=> 'custom_link',
                'title'		=> __('Custom link','team'),
                'details'	=> __('Custom link to member.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '',
            ),

            array(
                'id'		=> 'skill',
                //'parent'		=> 'team_options',
                'title'		=> __('Skill','team'),
                'details'	=> __('Add some skills, please write as follows <code>Skill 1 | 90%</code>','team'),
                'type'		=> 'text_multi',
                'sortable'		=> true,
                'value'		=> $skill,
                'placeholder'		=> 'Skill 1 | 90%',
                'default'		=> array(),
                'args'		=> array(),
            ),


            array(
                'id'		=> 'contacts',
                'parent'		=> 'team_options',
                'title'		=> __('Member contact','team'),
                'details'	=> __('Add team member contact.','team'),
                'type'		=> 'team_social_input',
                'value'		=> $contacts,
                'default'		=> '',
                'placeholder'		=> '',
            ),

            array(
                'id'		=> 'class',
                'title'		=> __('Additional class','team'),
                'details'	=> __('Add some class to use filterable, add comma separated.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> 'designer founder',
            ),





        );


        $teams_fields = apply_filters('teams_fields', $teams_fields);


        $args = array(
            'id'		=> 'team_members',
            'parent'		=> 'team_options',
            'title'		=> __('Team members','text-domain'),
            'details'	=> __('Put your team members here','text-domain'),
            'collapsible'=>true,
            'type'		=> 'repeatable',
            'limit'		=> 10,
            'title_field'		=> 'name',
            'value'		=> $team_members,
            'fields'    => $teams_fields,
        );

        $settings_tabs_field->generate_field($args);


        ?>

    </div>

    <?php

}

