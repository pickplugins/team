<?php

/*
* @Author 		PickPlugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access




add_action('team_settings_tabs_content_shortcode', 'team_settings_tabs_content_shortcode',10, 2);

function team_settings_tabs_content_shortcode($tab, $post_id){

    $settings_tabs_field = new settings_tabs_field();


    ?>
    <div class="section">
        <div class="section-title">Shortcodes</div>
        <p class="description section-description">Simply copy these shortcode and user under content</p>


        <?php


        ob_start();

        ?>

        <div class="copy-to-clipboard">
            <input type="text" value="[team id='<?php echo $post_id;  ?>']"> <span class="copied">Copied</span>
            <p class="description">You can use this shortcode under post content</p>
        </div>


        <div class="copy-to-clipboard">
            <textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[team id='; echo "'".$post_id."']"; echo '"); ?>'; ?></textarea> <span class="copied">Copied</span>
            <p class="description">PHP Code, you can use under theme .php files.</p>
        </div>

        <div class="copy-to-clipboard">
            To avoid conflict:<br>
            <input type="text" value="[team_pickplugins id='<?php echo $post_id;  ?>']"> <span class="copied">Copied</span>
            <p class="description">To avoid conflict with 3rd party shortcode also used same <code>[team]</code>You can use this shortcode under post content</p>
        </div>


        <div class="copy-to-clipboard">
            <textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[team_pickplugins id='; echo "'".$post_id."']"; echo '"); ?>'; ?></textarea> <span class="copied">Copied</span>
            <p class="description">To avoid conflict, PHP code you can use under theme .php files.</p>
        </div>

        <style type="text/css">
            .copy-to-clipboard{}
            .copy-to-clipboard .copied{
                display: none;
                background: #e5e5e5;
                padding: 4px 10px;
                line-height: normal;
            }
        </style>

        <script>
            jQuery(document).ready(function($){
                $(document).on('click', '.copy-to-clipboard input, .copy-to-clipboard textarea', function () {
                    $(this).focus();
                    $(this).select();
                    document.execCommand('copy');
                    $(this).parent().children('.copied').fadeIn().fadeOut(2000);
                })
            })
        </script>
        <?php
        $html = ob_get_clean();
        $args = array(
            'id'		=> 'team_shortcodes',
            'title'		=> __('Shortcodes','post-grid'),
            'details'	=> '',
            'type'		=> 'custom_html',
            'html'		=> $html,
        );
        $settings_tabs_field->generate_field($args, $post_id);


        ?>
    </div>
    <?php
}



add_action('team_settings_tabs_content_style', 'team_settings_tabs_content_style',10, 2);

function team_settings_tabs_content_style($tab, $post_id){

    $settings_tabs_field = new settings_tabs_field();

    $team_options = get_post_meta($post_id,'team_options', true);

    $item_width_large = isset($team_options['item_width']['large']) ? $team_options['item_width']['large'] : '45%';
    $item_width_medium = isset($team_options['item_width']['medium']) ? $team_options['item_width']['medium'] : '90%';
    $item_width_small = isset($team_options['item_width']['small']) ? $team_options['item_width']['small'] : '90%';

    $item_margin_large = isset($team_options['item_margin']['large']) ? $team_options['item_margin']['large'] : '';
    $item_margin_medium = isset($team_options['item_margin']['medium']) ? $team_options['item_margin']['medium'] : '';
    $item_margin_small = isset($team_options['item_margin']['small']) ? $team_options['item_margin']['small'] : '';

    $item_padding_large = isset($team_options['item_padding']['large']) ? $team_options['item_padding']['large'] : '';
    $item_padding_medium = isset($team_options['item_padding']['medium']) ? $team_options['item_padding']['medium'] : '';
    $item_padding_small = isset($team_options['item_padding']['small']) ? $team_options['item_padding']['small'] : '';

    $item_text_align_large = isset($team_options['item_text_align']['large']) ? $team_options['item_text_align']['large'] : '';
    $item_text_align_medium = isset($team_options['item_text_align']['medium']) ? $team_options['item_text_align']['medium'] : '';
    $item_text_align_small = isset($team_options['item_text_align']['small']) ? $team_options['item_text_align']['small'] : '';


    ?>
    <div class="section">
        <div class="section-title">Style</div>
        <p class="description section-description">Customize style settings</p>

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
                    'value'		=> $item_width_large,
                    'default'		=> '',
                    'placeholder'   => '45%',
                ),
                array(
                    'id'		=> 'medium',
                    'parent'		=> 'team_options[item_width]',
                    'title'		=> __('In tablet & small desktop','related-post'),
                    'details'	=> __('min-width: 992px, ex: 90% or 280px','related-post'),
                    'type'		=> 'text',
                    'value'		=> $item_width_medium,
                    'default'		=> '',
                    'placeholder'   => '90%',
                ),
                array(
                    'id'		=> 'small',
                    'parent'		=> 'team_options[item_width]',
                    'title'		=> __('In mobile','related-post'),
                    'details'	=> __('max-width: 768px, ex: 90% or 280px','related-post'),
                    'type'		=> 'text',
                    'value'		=> $item_width_small,
                    'default'		=> '',
                    'placeholder'   => '90%',
                ),
            ),

        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'		=> 'item_margin',
            'title'		=> __('Item margin','related-post'),
            'details'	=> __('Set item margin.','related-post'),
            'type'		=> 'option_group',
            'options'		=> array(
                array(
                    'id'		=> 'large',
                    'parent'		=> 'team_options[item_margin]',
                    'title'		=> __('In desktop','related-post'),
                    'details'	=> __('min-width: 1200px, ex: 45% or 280px','related-post'),
                    'type'		=> 'text',
                    'value'		=> $item_margin_large,
                    'default'		=> '',
                    'placeholder'   => '10px',
                ),
                array(
                    'id'		=> 'medium',
                    'parent'		=> 'team_options[item_margin]',
                    'title'		=> __('In tablet & small desktop','related-post'),
                    'details'	=> __('min-width: 992px, ex: 90% or 280px','related-post'),
                    'type'		=> 'text',
                    'value'		=> $item_margin_medium,
                    'default'		=> '',
                    'placeholder'   => '5px',
                ),
                array(
                    'id'		=> 'small',
                    'parent'		=> 'team_options[item_margin]',
                    'title'		=> __('In mobile','related-post'),
                    'details'	=> __('max-width: 768px, ex: 90% or 280px','related-post'),
                    'type'		=> 'text',
                    'value'		=> $item_margin_small,
                    'default'		=> '',
                    'placeholder'   => '5px',
                ),
            ),

        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'		=> 'item_padding',
            'title'		=> __('Item padding','related-post'),
            'details'	=> __('Set item padding.','related-post'),
            'type'		=> 'option_group',
            'options'		=> array(
                array(
                    'id'		=> 'large',
                    'parent'		=> 'team_options[item_padding]',
                    'title'		=> __('In desktop','related-post'),
                    'details'	=> __('min-width: 1200px, ex: 45% or 280px','related-post'),
                    'type'		=> 'text',
                    'value'		=> $item_padding_large,
                    'default'		=> '',
                    'placeholder'   => '10px',
                ),
                array(
                    'id'		=> 'medium',
                    'parent'		=> 'team_options[item_padding]',
                    'title'		=> __('In tablet & small desktop','related-post'),
                    'details'	=> __('min-width: 992px, ex: 90% or 280px','related-post'),
                    'type'		=> 'text',
                    'value'		=> $item_padding_medium,
                    'default'		=> '',
                    'placeholder'   => '5px',
                ),
                array(
                    'id'		=> 'small',
                    'parent'		=> 'team_options[item_padding]',
                    'title'		=> __('In mobile','related-post'),
                    'details'	=> __('max-width: 768px, ex: 90% or 280px','related-post'),
                    'type'		=> 'text',
                    'value'		=> $item_padding_small,
                    'default'		=> '',
                    'placeholder'   => '5px',
                ),
            ),

        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'		=> 'item_text_align',
            'title'		=> __('Item text align','related-post'),
            'details'	=> __('Set item text align.','related-post'),
            'type'		=> 'option_group',
            'options'		=> array(
                array(
                    'id'		=> 'large',
                    'parent'		=> 'team_options[item_text_align]',
                    'title'		=> __('In desktop','related-post'),
                    'details'	=> __('min-width: 1200px, ex: 45% or 280px','related-post'),
                    'type'		=> 'select',
                    'value'		=> $item_text_align_large,
                    'default'		=> 'left',
                    'args'		=> array('left'=>__('Left','related-post'), 'center'=>__('Center','related-post'), 'right'=>__('Right','related-post')  ),
                ),
                array(
                    'id'		=> 'medium',
                    'parent'		=> 'team_options[item_text_align]',
                    'title'		=> __('In tablet & small desktop','related-post'),
                    'details'	=> __('min-width: 992px, ex: 90% or 280px','related-post'),
                    'type'		=> 'select',
                    'value'		=> $item_text_align_medium,
                    'default'		=> 'left',
                    'args'		=> array('left'=>__('Left','related-post'), 'center'=>__('Center','related-post'), 'right'=>__('Right','related-post')  ),
                ),
                array(
                    'id'		=> 'small',
                    'parent'		=> 'team_options[item_text_align]',
                    'title'		=> __('In mobile','related-post'),
                    'details'	=> __('max-width: 768px, ex: 90% or 280px','related-post'),
                    'type'		=> 'select',
                    'value'		=> $item_text_align_small,
                    'default'		=> 'left',
                    'args'		=> array('left'=>__('Left','related-post'), 'center'=>__('Center','related-post'), 'right'=>__('Right','related-post')  ),
                ),
            ),

        );

        $settings_tabs_field->generate_field($args);




        ?>
    </div>

    <?php

}




add_action('team_settings_tabs_content_team_members', 'team_settings_tabs_content_team_members',10, 2);

function team_settings_tabs_content_team_members($tab, $post_id){

    $settings_tabs_field = new settings_tabs_field();
    $team_options = get_post_meta($post_id, 'team_options', true);

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



add_action('team_settings_tabs_content_filterable', 'team_settings_tabs_content_filterable',10, 2);

function team_settings_tabs_content_filterable($tab, $post_id){

    $settings_tabs_field = new settings_tabs_field();

    $team_options = get_post_meta($post_id, 'team_options', true);

    $taxonomies = !empty($team_options['taxonomies']) ? $team_options['taxonomies'] : array();

    $filterable_filter = !empty($team_options['filterable']['filter']) ? $team_options['filterable']['filter'] : 'yes';
    $filterable_filter_style = !empty($team_options['filterable']['filter_style']) ? $team_options['filterable']['filter_style'] : 'inline';
    $filterable_post_per_page = !empty($team_options['filterable']['filterable_post_per_page']) ? $team_options['filterable']['filterable_post_per_page'] : '6';
    $filterable_font_size = !empty($team_options['filterable']['filterable_font_size']) ? $team_options['filterable']['filterable_font_size'] : '14px';
    $filterable_navs_margin = !empty($team_options['filterable']['filterable_navs_margin']) ? $team_options['filterable']['filterable_navs_margin'] : '5px';

    $filterable_font_color = !empty($team_options['filterable']['filterable_font_color']) ? $team_options['filterable']['filterable_font_color'] : '#999';
    $filterable_bg_color = !empty($team_options['filterable']['filterable_bg_color']) ? $team_options['filterable']['filterable_bg_color'] : '#fff';
    $filterable_active_bg_color = !empty($team_options['filterable']['filterable_active_bg_color']) ? $team_options['filterable']['filterable_active_bg_color'] : '#ddd';
    $filter_all_text = !empty($team_options['filterable']['filter_all_text']) ? $team_options['filterable']['filter_all_text'] : 'All';
    $active_filter = !empty($team_options['filterable']['active_filter']) ? $team_options['filterable']['active_filter'] : '';
    $display_post_count = !empty($team_options['filterable']['display_post_count']) ? $team_options['filterable']['display_post_count'] : 'no';
    $display_sort_filter = !empty($team_options['filterable']['display_sort_filter']) ? $team_options['filterable']['display_sort_filter'] : 'no';

    $filter_type = !empty($team_options['filterable']['filter_type']) ? $team_options['filterable']['filter_type'] : 'single';


    $enable_multi_filter = !empty($team_options['filterable']['enable_multi_filter']) ? $team_options['filterable']['enable_multi_filter'] : 'no';
    $filter_by = !empty($team_options['filterable']['filter_by']) ? $team_options['filterable']['filter_by'] : 'taxonomy';
    $multi_filter_group = !empty($team_options['filterable']['multi_filter_group']) ? $team_options['filterable']['multi_filter_group'] : array();

    ?>
    <div class="section">
        <div class="section-title">Filterable</div>
        <p class="description section-description">Customize filterable style grid settings.</p>

        <?php


        $args = array(
            'id'		=> 'filter',
            'parent'		=> 'team_options[filterable]',
            'title'		=> __('Filterable menu display','post-grid'),
            'details'	=> __('Hide or display filterable menu.','post-grid'),
            'type'		=> 'radio',
            'multiple'		=> true,
            'value'		=> $filterable_filter,
            'default'		=> 'yes',
            'args'		=> array(
                'yes'=>__('Yes','post-grid'),
                'no'=>__('No','post-grid'),
            ),
        );

        $settings_tabs_field->generate_field($args, $post_id);




        $args = array(
            'id'		=> 'filterable_post_per_page',
            'parent'		=> 'team_options[filterable]',
            'title'		=> __('Number of items per page','post-grid'),
            'details'	=> __('Set custom value post per page for filterable.','post-grid'),
            'type'		=> 'text',
            'value'		=> $filterable_post_per_page,
            'default'		=> '6',
        );

        $settings_tabs_field->generate_field($args, $post_id);


        $args = array(
            'id'		=> 'filterable_font_size',
            'parent'		=> 'team_options[filterable]',
            'title'		=> __('Navs font size','post-grid'),
            'details'	=> __('Set custom value filterable nav item font size.','post-grid'),
            'type'		=> 'text',
            'value'		=> $filterable_font_size,
            'default'		=> '14px',
        );

        $settings_tabs_field->generate_field($args, $post_id);

        $args = array(
            'id'		=> 'filterable_navs_margin',
            'parent'		=> 'team_options[filterable]',
            'title'		=> __('Navs margin','post-grid'),
            'details'	=> __('Set custom value filterable nav item margin. ex: 5px or 5px 10px','post-grid'),
            'type'		=> 'text',
            'value'		=> $filterable_navs_margin,
            'default'		=> '5px',
        );



        $settings_tabs_field->generate_field($args, $post_id);

        $args = array(
            'id'		=> 'filterable_font_color',
            'parent'		=> 'team_options[filterable]',
            'title'		=> __('Navs font color','post-grid'),
            'details'	=> __('Set custom value filterable nav item font color.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $filterable_font_color,
            'default'		=> '#999',
        );

        $settings_tabs_field->generate_field($args, $post_id);


        $args = array(
            'id'		=> 'filterable_bg_color',
            'parent'		=> 'team_options[filterable]',
            'title'		=> __('Navs background color','post-grid'),
            'details'	=> __('Set custom value filterable nav item background color.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $filterable_bg_color,
            'default'		=> '#fff',
        );

        $settings_tabs_field->generate_field($args, $post_id);


        $args = array(
            'id'		=> 'filterable_active_bg_color',
            'parent'		=> 'team_options[filterable]',
            'title'		=> __('Navs active background color','post-grid'),
            'details'	=> __('Set custom value filterable nav item active background color.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $filterable_active_bg_color,
            'default'		=> '#ddd',
        );

        $settings_tabs_field->generate_field($args, $post_id);

        $args = array(
            'id'		=> 'filter_all_text',
            'parent'		=> 'team_options[filterable]',
            'title'		=> __('Custom text for All','post-grid'),
            'details'	=> __('Set custom text for default all text.','post-grid'),
            'type'		=> 'text',
            'value'		=> $filter_all_text,
            'default'		=> 'All',
        );

        $settings_tabs_field->generate_field($args, $post_id);

        $args = array(
            'id'		=> 'filter_style',
            'parent'		=> 'team_options[filterable]',
            'title'		=> __('Single filter menu style','post-grid'),
            'details'	=> __('Display inline or dropdown style filterable menu.','post-grid'),
            'type'		=> 'radio',
            'multiple'		=> true,
            'value'		=> $filterable_filter_style,
            'default'		=> 'inline',
            'args'		=> array(
                'inline'=>__('Inline','post-grid'),
                'dropdown'=>__('Dropdown','post-grid'),
            ),
        );

        $settings_tabs_field->generate_field($args, $post_id);

        $args = array(
            'id'		=> 'display_sort_filter',
            'parent'		=> 'team_options[filterable]',
            'title'		=> __('Display sort filter','post-grid'),
            'details'	=> __('Display inline or dropdown style filterable menu.','post-grid'),
            'type'		=> 'radio',
            'value'		=> $display_sort_filter,
            'default'		=> 'yes',
            'args'		=> array(
                'yes'=>__('Yes','post-grid'),
                'no'=>__('No','post-grid'),
            ),
        );

        $settings_tabs_field->generate_field($args, $post_id);



        $teams_fields = array(

            array(
                'id'		=> 'name',
                'title'		=> __('Group name','team'),
                'details'	=> __('Write name here.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> 'Size or Color',
            ),

            array(
                'id'		=> 'name_display',
                'title'		=> __('Display group name','team'),
                'details'	=> __('Choose to display or hider group title.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'or',
                'args'		=> array(
                    'no'=>__('No','post-grid'),
                    'yes'=>__('Yes','post-grid'),

                ),
            ),

            array(
                'id'		=> 'type',
                'title'		=> __('Type','team'),
                'details'	=> __('Write details text here.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'taxonomy',
                'args'		=> array(
                    'inline'=>__('Inline','post-grid'),
                    'dropdown'=>__('Dropdown','post-grid'),
                    'radio'=>__('Radio','post-grid'),
                    'checkbox'=>__('Checkbox','post-grid'),
                ),
            ),
            array(
                'id'		=> 'data_logic',
                'title'		=> __('Data logic','team'),
                'details'	=> __('Write details text here.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'or',
                'args'		=> array(
                    'or'=>__('Or','post-grid'),
                    'and'=>__('And','post-grid'),
                ),
            ),


            array(
                'id'		=> 'filter_args',
                'title'		=> __('Filter arguments','team'),
                'details'	=> __('Write name here.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> 'Filter 1 | filterID , Filter 1 | filterID',
            ),
        );


        $teams_fields = apply_filters('teams_fields', $teams_fields);


        $args = array(
            'id'		=> 'multi_filter_group',
            'parent'		=> 'team_options[filterable]',
            'title'		=> __('Custom filters','text-domain'),
            'details'	=> __('Put your team members here','text-domain'),
            'collapsible'=>true,
            'type'		=> 'repeatable',
            'limit'		=> 10,
            'title_field'		=> 'name',
            'value'		=> $multi_filter_group,
            'fields'    => $teams_fields,
        );

        $settings_tabs_field->generate_field($args);


        ?>
    </div>

    <?php

}


add_action('team_settings_tabs_content_masonry', 'team_settings_tabs_content_masonry',10, 2);

function team_settings_tabs_content_masonry($tab, $post_id){

    $settings_tabs_field = new settings_tabs_field();

    $team_options = get_post_meta($post_id,'team_options', true);

    $masonry_enable = isset($team_options['masonry_enable']) ? $team_options['masonry_enable'] : 'no';

    ?>
    <div class="section">
        <div class="section-title">layout_builder</div>
        <p class="description section-description">Simply copy these shortcode and user under content</p>


        <?php
        $args = array(
            'id'		=> 'masonry_enable',
            'parent'		=> 'team_options',
            'title'		=> __('Enable masonry?','related-post'),
            'details'	=> __('Choose masonry enable or disable.','related-post'),
            'type'		=> 'select',
            'value'		=> $masonry_enable,
            'default'		=> 'no',
            'args'		=> array('no'=>__('No','related-post'), 'yes'=>__('Yes','related-post') ),
        );

        $settings_tabs_field->generate_field($args);

        ?>
    </div>

    <?php

}

add_action('team_settings_tabs_content_slider', 'team_settings_tabs_content_slider',10, 2);

function team_settings_tabs_content_slider($tab, $post_id){

    $settings_tabs_field = new settings_tabs_field();

    $team_options = get_post_meta($post_id,'team_options', true);

    $slider_column_number_desktop = isset($team_options['slider']['column_desktop']) ? $team_options['slider']['column_desktop'] : 3;
    $slider_column_number_tablet = isset($team_options['slider']['column_tablet']) ? $team_options['slider']['column_tablet'] : 2;
    $slider_column_number_mobile = isset($team_options['slider']['column_mobile']) ? $team_options['slider']['column_mobile'] : 1;

    $slider_slide_speed = isset($team_options['slider']['slide_speed']) ? $team_options['slider']['slide_speed'] : 1000;
    $slider_pagination_speed = isset($team_options['slider']['pagination_speed']) ? $team_options['slider']['pagination_speed'] : 1200;
    $slider_auto_play = isset($team_options['slider']['auto_play']) ? $team_options['slider']['auto_play'] : 'true';
    $slider_rewind = isset($team_options['slider']['rewind']) ? $team_options['slider']['rewind'] : 'true';
    $slider_loop = isset($team_options['slider']['loop']) ? $team_options['slider']['loop'] : 'true';
    $slider_center = isset($team_options['slider']['center']) ? $team_options['slider']['center'] : 'true';
    $slider_stop_on_hover = isset($team_options['slider']['stop_on_hover']) ? $team_options['slider']['stop_on_hover'] : 'true';
    $slider_navigation = isset($team_options['slider']['navigation']) ? $team_options['slider']['navigation'] : 'true';
    $slider_pagination = isset($team_options['slider']['pagination']) ? $team_options['slider']['pagination'] : 'true';
    $slider_pagination_count = isset($team_options['slider']['pagination_count']) ? $team_options['slider']['pagination_count'] : 'false';
    $slider_rtl = isset($team_options['slider']['rtl']) ? $team_options['slider']['rtl'] : 'false';


    ?>
    <div class="section">
        <div class="section-title">Slider</div>
        <p class="description section-description">Choose slider settings</p>


        <?php


        $args = array(
            'id'		=> 'slider',
            'title'		=> __('Slider column count ','related-post'),
            'details'	=> __('Set slider column count.','related-post'),
            'type'		=> 'option_group',
            'options'		=> array(
                array(
                    'id'		=> 'column_desktop',
                    'parent'		=> 'related_post_settings[slider]',
                    'title'		=> __('In desktop','related-post'),
                    'details'	=> __('min-width: 1200px, ex: 3','related-post'),
                    'type'		=> 'text',
                    'value'		=> $slider_column_number_desktop,
                    'default'		=> 3,
                    'placeholder'   => '3',
                ),
                array(
                    'id'		=> 'column_tablet',
                    'parent'		=> 'related_post_settings[slider]',
                    'title'		=> __('In tablet & small desktop','related-post'),
                    'details'	=> __('min-width: 992px, ex: 2','related-post'),
                    'type'		=> 'text',
                    'value'		=> $slider_column_number_tablet,
                    'default'		=> 2,
                    'placeholder'   => '2',
                ),
                array(
                    'id'		=> 'column_mobile',
                    'parent'		=> 'related_post_settings[slider]',
                    'title'		=> __('In mobile','related-post'),
                    'details'	=> __('min-width: 576px, ex: 1','related-post'),
                    'type'		=> 'text',
                    'value'		=> $slider_column_number_mobile,
                    'default'		=> 1,
                    'placeholder'   => '1',
                ),
            ),

        );

        $settings_tabs_field->generate_field($args);




        $args = array(
            'id'		=> 'slide_speed',
            'parent'		=> 'related_post_settings[slider]',
            'title'		=> __('Navigation slide speed','related-post'),
            'details'	=> __('Set slide speed, ex: 1000','related-post'),
            'type'		=> 'text',
            'value'		=> $slider_slide_speed,
            'default'		=> 1000,
            'placeholder'   => '1000',
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'pagination_speed',
            'parent'		=> 'related_post_settings[slider]',
            'title'		=> __('Dots slide speed','related-post'),
            'details'	=> __('Set dots slide speed, ex: 1200','related-post'),
            'type'		=> 'text',
            'value'		=> $slider_pagination_speed,
            'default'		=> 1200,
            'placeholder'   => '1200',
        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'		=> 'auto_play',
            'parent'		=> 'related_post_settings[slider]',
            'title'		=> __('Auto play','related-post'),
            'details'	=> __('Choose slider auto play.','related-post'),
            'type'		=> 'select',
            'value'		=> $slider_auto_play,
            'default'		=> 'true',
            'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'rewind',
            'parent'		=> 'related_post_settings[slider]',
            'title'		=> __('Slider rewind','related-post'),
            'details'	=> __('Choose slider rewind.','related-post'),
            'type'		=> 'select',
            'value'		=> $slider_rewind,
            'default'		=> 'true',
            'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'loop',
            'parent'		=> 'related_post_settings[slider]',
            'title'		=> __('Slider loop','related-post'),
            'details'	=> __('Choose slider loop.','related-post'),
            'type'		=> 'select',
            'value'		=> $slider_rewind,
            'default'		=> 'true',
            'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'		=> 'center',
            'parent'		=> 'related_post_settings[slider]',
            'title'		=> __('Slider center','related-post'),
            'details'	=> __('Choose slider center.','related-post'),
            'type'		=> 'select',
            'value'		=> $slider_center,
            'default'		=> 'true',
            'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'stop_on_hover',
            'parent'		=> 'related_post_settings[slider]',
            'title'		=> __('Slider stop on hover','related-post'),
            'details'	=> __('Choose stop on hover.','related-post'),
            'type'		=> 'select',
            'value'		=> $slider_stop_on_hover,
            'default'		=> 'true',
            'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
        );

        $settings_tabs_field->generate_field($args);




        $args = array(
            'id'		=> 'navigation',
            'parent'		=> 'related_post_settings[slider]',
            'title'		=> __('Slider navigation','related-post'),
            'details'	=> __('Choose slider navigation.','related-post'),
            'type'		=> 'select',
            'value'		=> $slider_navigation,
            'default'		=> 'true',
            'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'navigation_position',
            'parent'		=> 'related_post_settings[slider]',
            'title'		=> __('Slider navigation position','related-post'),
            'details'	=> __('Choose slider navigation position.','related-post'),
            'type'		=> 'select',
            'value'		=> $slider_navigation,
            'default'		=> 'topright',
            'args'		=> array('topright'=>__('Top-right','related-post'),  ), //'middle'=>__('Middle','related-post') , 'middle-fixed'=>__('Middle-fixed','related-post')
        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'		=> 'pagination',
            'parent'		=> 'related_post_settings[slider]',
            'title'		=> __('Slider pagination','related-post'),
            'details'	=> __('Choose slider pagination.','related-post'),
            'type'		=> 'select',
            'value'		=> $slider_pagination,
            'default'		=> 'true',
            'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'pagination_count',
            'parent'		=> 'related_post_settings[slider]',
            'title'		=> __('Slider pagination count','related-post'),
            'details'	=> __('Choose slider pagination count.','related-post'),
            'type'		=> 'select',
            'value'		=> $slider_pagination_count,
            'default'		=> 'true',
            'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'rtl',
            'parent'		=> 'related_post_settings[slider]',
            'title'		=> __('Slider rtl','related-post'),
            'details'	=> __('Choose slider rtl.','related-post'),
            'type'		=> 'select',
            'value'		=> $slider_rtl,
            'default'		=> 'true',
            'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
        );

        $settings_tabs_field->generate_field($args);



        ?>

    </div>

    <?php

}

add_action('team_settings_tabs_content_pagination', 'team_settings_tabs_content_pagination',10, 2);

function team_settings_tabs_content_pagination($tab, $post_id){

    $settings_tabs_field = new settings_tabs_field();

    $team_options = get_post_meta($post_id, 'team_options', true);

    $pagination_type = !empty($team_options['pagination']['type']) ? $team_options['pagination']['type'] : 'normal';
    $max_num_pages = !empty($team_options['pagination']['max_num_pages']) ? $team_options['pagination']['max_num_pages'] : '0';
    $prev_text = !empty($team_options['pagination']['prev_text']) ? $team_options['pagination']['prev_text'] : __('« Previous','post-grid');
    $next_text = !empty($team_options['pagination']['next_text']) ? $team_options['pagination']['next_text'] : __('Next »','post-grid');
    $font_size = !empty($team_options['pagination']['font_size']) ? $team_options['pagination']['font_size'] : '16px';
    $font_color = !empty($team_options['pagination']['font_color']) ? $team_options['pagination']['font_color'] : '#fff';
    $bg_color = !empty($team_options['pagination']['bg_color']) ? $team_options['pagination']['bg_color'] : '#646464';
    $active_bg_color = !empty($team_options['pagination']['active_bg_color']) ? $team_options['pagination']['active_bg_color'] : '#4b4b4b';


    ?>
    <div class="section">
        <div class="section-title">Pagination</div>
        <p class="description section-description">Simply copy these shortcode and user under content</p>

        <?php


        $args = array(
            'id'		=> 'pagination_type',
            'parent'		=> 'team_options[pagination]',
            'title'		=> __('Pagination type','post-grid'),
            'details'	=> __('Select pagination you want to display.','post-grid'),
            'type'		=> 'radio',
            'multiple'		=> true,
            'value'		=> $pagination_type,
            'default'		=> 'inline',
            'args'		=> array(
                'none'=>__('None','post-grid'),
                'normal'=>__('Normal Pagination','post-grid'),
                'ajax_pagination'=>__('Ajax Pagination','post-grid'),
                'next_previous'=>__('Next-Previous','post-grid'),
                'jquery'=>__('jQuery pagination','post-grid'),
                'loadmore'=>__('Load More','post-grid'),
                //'infinite'=>__('Infinite scroll','post-grid'),
            ),
        );

        $settings_tabs_field->generate_field($args, $post_id);


        $args = array(
            'id'		=> 'max_num_pages',
            'parent'		=> 'team_options[pagination]',
            'title'		=> __('Max number of pagination','post-grid'),
            'details'	=> __('keep 0 (zero) for auto','post-grid'),
            'type'		=> 'text',
            'value'		=> $max_num_pages,
            'default'		=> '0',
        );

        $settings_tabs_field->generate_field($args, $post_id);


        $args = array(
            'id'		=> 'prev_text',
            'parent'		=> 'team_options[pagination]',
            'title'		=> __('Previous text','post-grid'),
            'details'	=> __('Custom text for previous page','post-grid'),
            'type'		=> 'text',
            'value'		=> $prev_text,
            'default'		=> '0',
        );

        $settings_tabs_field->generate_field($args, $post_id);


        $args = array(
            'id'		=> 'next_text',
            'parent'		=> 'team_options[pagination]',
            'title'		=> __('Next text','post-grid'),
            'details'	=> __('Custom text for next page','post-grid'),
            'type'		=> 'text',
            'value'		=> $next_text,
            'default'		=> '0',
        );

        $settings_tabs_field->generate_field($args, $post_id);

        $args = array(
            'id'		=> 'font_size',
            'parent'		=> 'team_options[pagination]',
            'title'		=> __('Font size','post-grid'),
            'details'	=> __('Custom font size for pagination','post-grid'),
            'type'		=> 'text',
            'value'		=> $font_size,
            'default'		=> '16px',
        );

        $settings_tabs_field->generate_field($args, $post_id);




        $args = array(
            'id'		=> 'font_color',
            'parent'		=> 'team_options[pagination]',
            'title'		=> __('Font color','post-grid'),
            'details'	=> __('Set custom color for pagination text.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $font_color,
            'default'		=> '#ddd',
        );

        $settings_tabs_field->generate_field($args, $post_id);

        $args = array(
            'id'		=> 'bg_color',
            'parent'		=> 'team_options[pagination]',
            'title'		=> __('Default background color','post-grid'),
            'details'	=> __('Set custom value for pagination background color.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $bg_color,
            'default'		=> '#ddd',
        );

        $settings_tabs_field->generate_field($args, $post_id);

        $args = array(
            'id'		=> 'active_bg_color',
            'parent'		=> 'team_options[pagination]',
            'title'		=> __('Active/hover background color','post-grid'),
            'details'	=> __('Set custom value filterable pagination item active background color.','post-grid'),
            'type'		=> 'colorpicker',
            'value'		=> $active_bg_color,
            'default'		=> '#ddd',
        );

        $settings_tabs_field->generate_field($args, $post_id);



        ?>
    </div>

    <?php

}


add_action('team_settings_tabs_content_custom_scripts', 'team_settings_tabs_content_custom_scripts',10, 2);

function team_settings_tabs_content_custom_scripts($tab, $post_id){

    $settings_tabs_field = new settings_tabs_field();


    ?>
    <div class="section">
        <div class="section-title">custom_scripts</div>
        <p class="description section-description">Simply copy these shortcode and user under content</p>

    </div>

    <?php

}







add_action('settings_tabs_field_team_social_input', 'settings_tabs_field_team_social_input');

if(!function_exists('settings_tabs_field_team_social_input')) {
    function settings_tabs_field_team_social_input($option){

        $parent 		= isset( $option['parent'] ) ? $option['parent'] : "";
        $value 		= isset( $option['value'] ) ? $option['value'] : "";


        $post_id = get_the_id();

        $team_options = get_post_meta( $post_id, 'team_options', true );


        $unique_id = time();

        ?>
        <div class="setting-field">
            <div class="field-lable">Contact</div>
            <div class="field-input">

                <span class="button add-contact" data-name="<?php echo $parent; ?>">Add</span><br><br>
                <div class="sortable contact-list">


                    <?php

                    if(!empty($value)):

                        foreach ($value as $index => $contactData):

                            $type = isset($contactData['type']) ? $contactData['type'] :'';
                            $value = isset($contactData['value']) ? $contactData['value'] :'';
                            $label = isset($contactData['label']) ? $contactData['label'] :'';
                            $icon = isset($contactData['icon']) ? $contactData['icon'] :'';


                            ?>
                            <div class="item">

                                <div>Type:</div>
                                <select name="<?php echo $parent; ?>[contacts][<?php echo $index; ?>][type]">
                                    <option <?php selected($type, 'email'); ?> value="email">Email</option>
                                    <option <?php selected($type, 'phone'); ?> value="phone">Phone</option>
                                    <option <?php selected($type, 'link'); ?> value="link">Link</option>
                                    <option <?php selected($type, 'text'); ?> value="text">Text</option>
                                    <option <?php selected($type, 'skype'); ?> value="skype">Skype</option>
                                </select>

                                <div>Link or Value:</div>
                                <input type="text" name="<?php echo $parent; ?>[contacts][<?php echo $index; ?>][value]" placeholder="Write username, link, phone number or skype" value="<?php echo $value; ?>">

                                <div>Label:</div>
                                <input type="text" name="<?php echo $parent; ?>[contacts][<?php echo $index; ?>][label]" placeholder="Twitter" value="<?php echo $label; ?>">

                                <div>Icon:</div>
                                <input type="text" name="<?php echo $parent; ?>[contacts][<?php echo $index; ?>][icon]" placeholder="" value="<?php echo esc_html($icon); ?>">

                                <span class="button sort"><i class="fas fa-arrows-alt"></i></span>

                                <span class="button remove" onclick="jQuery(this).parent().remove()"><i class="fas fa-times"></i></span>
                                <hr/>
                            </div>
                        <?php
                        endforeach;


                    else:
                        ?>
                        <div class="item">

                            <div>Type: </div>
                            <select name="<?php echo $parent; ?>[contacts][<?php echo $unique_id; ?>][type]">
                                <option value="email">Email</option>
                                <option value="phone">Phone</option>
                                <option value="link">Link</option>
                                <option value="text">Text</option>
                                <option value="skype">Skype</option>
                            </select>

                            <div>Link or Value:</div>
                            <input type="text" name="<?php echo $parent; ?>[contacts][<?php echo $unique_id; ?>][value]" placeholder="Write username, link, phone number or skype" value="">

                            <div>Label:</div>
                            <input type="text" name="<?php echo $parent; ?>[contacts][<?php echo $unique_id; ?>][label]" placeholder="Twitter" value="">

                            <div>Icon:</div>
                            <input type="text" name="<?php echo $parent; ?>[contacts][<?php echo $unique_id; ?>][icon]" placeholder="" value="">

                            <span class="button sort"><i class="fas fa-arrows-alt"></i></span>

                            <span class="button remove" onclick="jQuery(this).parent().remove()"><i class="fas fa-times"></i></span>
                        </div>
                    <?php

                    endif;

                    ?>




                </div>
            </div>
        </div>

        <?php

    }
}

