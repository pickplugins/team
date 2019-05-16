<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
















add_action('team_meta_tabs_content_custom_scripts', 'team_meta_tabs_content_custom_scripts',10, 2);

if(!function_exists('team_meta_tabs_content_custom_scripts')) {
    function team_meta_tabs_content_custom_scripts($tab, $post_id){
        $settings_tabs_field = new settings_tabs_field();
        $team_options = get_post_meta( $post_id, 'team_options', true );
        $custom_css = isset($team_options['custom_css']) ? $team_options['custom_css'] : '';

        ?>
        <div class="section">
            <div class="section-title">Custom scripts</div>
            <p class="description section-description">Add your own scritps and style css.</p>
            <?php

            $args = array(
                'id'		=> 'custom_css',
                'parent' => 'team_options',
                'title'		=> __('Custom CSS','team'),
                'details'	=> __('Add your own CSS..','team'),
                'type'		=> 'scripts_css',
                'value'		=> $custom_css,
                'default'		=> '.team-container #team-133{}&#10; ',
            );

            $settings_tabs_field->generate_field($args);
            ?>
        </div>
        <?php
	}

}





add_action('team_meta_tabs_content_grid', 'team_meta_tabs_content_grid',10, 2);

if(!function_exists('team_meta_tabs_content_grid')) {
    function team_meta_tabs_content_grid($tab, $post_id){
        $settings_tabs_field = new settings_tabs_field();
        $team_options = get_post_meta( $post_id, 'team_options', true );
        $item_width_desktop = isset($team_options['item_width_desktop']) ? $team_options['item_width_desktop'] : '';
        $item_width_tablet = isset($team_options['item_width_tablet']) ? $team_options['item_width_tablet'] : '';
        $item_width_mobile = isset($team_options['item_width_mobile']) ? $team_options['item_width_mobile'] : '';
        $item_margin = isset($team_options['item_margin']) ? $team_options['item_margin'] : '';
        $item_text_align = isset($team_options['item_text_align']) ? $team_options['item_text_align'] : '';



        ?>
        <div class="section">
            <div class="section-title">Custom scripts</div>
            <p class="description section-description">Add your own scritps and style css.</p>
            <?php

            ob_start();
            ?>
            <div>
                For Destop: (min-width:1024px) <br>
                <input type="text" name="team_options[item_width_desktop]" placeholder="ex:150px, px or %" id="team_items_max_width" value="<?php echo $item_width_desktop; ?>">
            </div>

            <div>
                For Tablet: ( min-width:768px ) <br>
                <input type="text" name="team_options[item_width_tablet]" placeholder="ex:150px, px or %" id="team_items_width_tablet" value="<?php echo $item_width_tablet; ?>">
            </div>

            <div>
                For Mobile: ( min-width : 320px, ) <br>
                <input type="text" name="team_options[item_width_mobile]" placeholder="ex:150px, px or %" id="team_items_width_mobile" value="<?php echo $item_width_mobile; ?>">
            </div>
            <?php

            $html = ob_get_clean();


            $args = array(
                'id' => 'item_width',
                'parent' => 'team_options',
                'title' => __('Slider elements', 'team'),
                'details' => '',
                'type' => 'custom_html',
                'html' => $html,
            );
            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'item_margin',
                'parent' => 'team_options',
                'title'		=> __('Items margin.','team'),
                'details'	=> __('Custom margin for item.','team'),
                'type'		=> 'text',
                'value'		=> $item_margin,
                'default'		=> '10px',
                'placeholder'		=> '10px',

            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'item_text_align',
                'parent' => 'team_options',
                'title'		=> __('Items text align','team'),
                'details'	=> __('Choose Items text align.','team'),
                'type'		=> 'select',
                'value'		=> $item_text_align,
                'default'		=> 'false',
                'args'		=> array(
                    'left'=>__('Left','team'),
                    'right'=>__('Right','team'),
                    'center'=>__('Center','team'),
                ),
            );

            $settings_tabs_field->generate_field($args);




            ?>
        </div>
        <?php
    }

}




























add_action('team_meta_tabs_content_pagination', 'team_meta_tabs_content_pagination',10, 2);

if(!function_exists('team_meta_tabs_content_pagination')) {
    function team_meta_tabs_content_pagination($tab, $post_id){
        $settings_tabs_field = new settings_tabs_field();
        $team_options = get_post_meta( $post_id, 'team_options', true );
        $pagination_prev_text = isset($team_options['pagination_prev_text']) ? $team_options['pagination_prev_text'] : '';
        $pagination_next_text = isset($team_options['pagination_next_text']) ? $team_options['pagination_next_text'] : '';
        $pagination_bg_color = isset($team_options['pagination_bg_color']) ? $team_options['pagination_bg_color'] : '#2593e8';
        $pagination_active_bg_color = isset($team_options['pagination_active_bg_color']) ? $team_options['pagination_active_bg_color'] : '#1e69bf';
        $pagination_item_padding = isset($team_options['pagination_item_padding']) ? $team_options['pagination_item_padding'] : '5px 15px';

        $pagination_text_color = isset($team_options['pagination_text_color']) ? $team_options['pagination_text_color'] : '#fff';



        ?>
        <div class="section">
            <div class="section-title">Custom scripts</div>
            <p class="description section-description">Add your own scritps and style css.</p>
            <?php


            $args = array(
                'id'		=> 'pagination_prev_text',
                'parent' => 'team_options',
                'title'		=> __('Pagination previous text.','team'),
                'details'	=> __('Custom text for pagination previous text.','team'),
                'type'		=> 'text',
                'value'		=> $pagination_prev_text,
                'default'		=> '« Previous',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'pagination_next_text',
                'parent' => 'team_options',
                'title'		=> __('Pagination next text.','team'),
                'details'	=> __('Custom text for pagination next text.','team'),
                'type'		=> 'text',
                'value'		=> $pagination_next_text,
                'default'		=> 'Next »',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'pagination_bg_color',
                'parent' => 'team_options',
                'title'		=> __('Pagination default background color.','team'),
                'details'	=> __('Choose pagination default background color.','team'),
                'type'		=> 'colorpicker',
                'value'		=> $pagination_bg_color,
                'default'		=> '#2593e8',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'pagination_active_bg_color',
                'parent' => 'team_options',
                'title'		=> __('Pagination active background color.','team'),
                'details'	=> __('Choose pagination active background color.','team'),
                'type'		=> 'colorpicker',
                'value'		=> $pagination_active_bg_color,
                'default'		=> '#1e69bf',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'pagination_text_color',
                'parent' => 'team_options',
                'title'		=> __('Pagination item text color.','team'),
                'details'	=> __('Choose pagination item text color.','team'),
                'type'		=> 'colorpicker',
                'value'		=> $pagination_text_color,
                'default'		=> '#fff',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'pagination_item_padding',
                'parent' => 'team_options',
                'title'		=> __('Pagination item padding.','team'),
                'details'	=> __('Custom padding for pagination item.','team'),
                'type'		=> 'text',
                'value'		=> $pagination_item_padding,
                'default'		=> '5px 15px',
            );

            $settings_tabs_field->generate_field($args);


            ?>
        </div>
        <?php
    }

}






























add_action('team_meta_tabs_content_masonry', 'team_meta_tabs_content_masonry',10, 2);

if(!function_exists('team_meta_tabs_content_masonry')) {
    function team_meta_tabs_content_masonry($tab, $post_id){
        $settings_tabs_field = new settings_tabs_field();
        $team_options = get_post_meta( $post_id, 'team_options', true );
        $masonry_enable = isset($team_options['masonry_enable']) ? $team_options['masonry_enable'] : 'no';

        ?>
        <div class="section">
            <div class="section-title">Masonry Settings</div>
            <p class="description section-description">Customize masonry settings.</p>
            <?php

            $args = array(
                'id'		=> 'masonry_enable',
                'parent' => 'team_options',
                'title'		=> __('Enable masonry','team'),
                'details'	=> __('Enable or disable masonry.','team'),
                'type'		=> 'select',
                'value'		=> $masonry_enable,
                'default'		=> 'false',
                'args'		=> array(
                    'no'=>__('No','team'),
                    'yes'=>__('Yes','team'),




                ),
            );

            $settings_tabs_field->generate_field($args);

            ?>
        </div>
        <?php
    }

}



add_action('team_meta_tabs_content_filterable', 'team_meta_tabs_content_filterable',10, 2);

if(!function_exists('team_meta_tabs_content_filterable')) {
    function team_meta_tabs_content_filterable($tab, $post_id){
        $settings_tabs_field = new settings_tabs_field();
        $team_options = get_post_meta( $post_id, 'team_options', true );
        $filterable_post_per_page = isset($team_options['filterable_post_per_page']) ? $team_options['filterable_post_per_page'] : '5';
        $filterable_default_filter = isset($team_options['filterable_default_filter']) ? $team_options['filterable_default_filter'] : 'all';

        $filterable_filter_scroll_top = isset($team_options['filterable_filter_scroll_top']) ? $team_options['filterable_filter_scroll_top'] : 'no';
        $filterable_filter_bg_color = isset($team_options['filterable_filter_bg_color']) ? $team_options['filterable_filter_bg_color'] : '#ddd';
        $filterable_filter_active_bg_color = isset($team_options['filterable_filter_active_bg_color']) ? $team_options['filterable_filter_active_bg_color'] : '#ddd';
        $filterable_filter_text_color = isset($team_options['filterable_filter_text_color']) ? $team_options['filterable_filter_text_color'] : '#999';
        $filterable_filter_padding = isset($team_options['filterable_filter_padding']) ? $team_options['filterable_filter_padding'] : '2px 15px';
        $filterable_filter_margin = isset($team_options['filterable_filter_margin']) ? $team_options['filterable_filter_margin'] : '2px';

        $filter_nav_args = isset($team_options['filter_nav_args']) ? $team_options['filter_nav_args'] : array();

        //var_dump($filter_nav_args);

        ?>
        <div class="section">
            <div class="section-title">Filterable Settings</div>
            <p class="description section-description">Customize filterable settings.</p>
            <?php








            $args = array(
                'id'		=> 'filter_nav_args',
                'parent'		=> 'team_options',
                'title'		=> __('Filterable navs','team'),
                'details'	=> __('Add some navs, please follow <code>Nave 1|nav1 , Nav 2|nav2, Nav 3|nav3</code>','team'),
                'type'		=> 'text_multi',
                'sortable'		=> true,
                'value'		=> $filter_nav_args,
                'default'		=> array(),
                'args'		=> array(),
                'placeholder'		=> 'Designer|designer , Developer|developer, Founder|founder',
            );

            $settings_tabs_field->generate_field($args);






            $args = array(
                'id'		=> 'filterable_post_per_page',
                'parent' => 'team_options',
                'title'		=> __('Post per page','team'),
                'details'	=> __('Custom value for post per page.','team'),
                'type'		=> 'text',
                'value'		=> $filterable_post_per_page,
                'default'		=> '5',
                'placeholder'		=> '10',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'filterable_default_filter',
                'parent' => 'team_options',
                'title'		=> __('Default filter','team'),
                'details'	=> __('Choose default filter.','team'),
                'type'		=> 'text',
                'value'		=> $filterable_default_filter,
                'default'		=> 'all',
                'placeholder'		=> 'all',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'filterable_filter_scroll_top',
                'parent' => 'team_options',
                'title'		=> __('Scroll top when pagination clicked.','team'),
                'details'	=> __('Enable or disable Scroll top when pagination clicked.','team'),
                'type'		=> 'select',
                'value'		=> $filterable_filter_scroll_top,
                'default'		=> 'false',
                'args'		=> array(
                    'no'=>__('No','team'),
                    'yes'=>__('Yes','team'),
                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'filterable_filter_bg_color',
                'parent' => 'team_options',
                'title'		=> __('Filter background color','team'),
                'details'	=> __('Choose custom filter background color','team'),
                'type'		=> 'colorpicker',
                'value'		=> $filterable_filter_bg_color,
                'default'		=> '#ddd',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'filterable_filter_active_bg_color',
                'parent' => 'team_options',
                'title'		=> __('Filter active background color','team'),
                'details'	=> __('Choose custom filter active background color','team'),
                'type'		=> 'colorpicker',
                'value'		=> $filterable_filter_active_bg_color,
                'default'		=> '#ddd',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'filterable_filter_text_color',
                'parent' => 'team_options',
                'title'		=> __('Filter text color','team'),
                'details'	=> __('Choose custom filter text color','team'),
                'type'		=> 'colorpicker',
                'value'		=> $filterable_filter_text_color,
                'default'		=> '#999',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'filterable_filter_padding',
                'parent' => 'team_options',
                'title'		=> __('Filter padding','team'),
                'details'	=> __('Choose custom filter padding','team'),
                'type'		=> 'text',
                'value'		=> $filterable_filter_padding,
                'default'		=> '2px 15px',
                'placeholder'		=> '10px',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'filterable_filter_margin',
                'parent' => 'team_options',
                'title'		=> __('Filter margin','team'),
                'details'	=> __('Choose custom filter margin','team'),
                'type'		=> 'text',
                'value'		=> $filterable_filter_margin,
                'default'		=> '2px 15px',
                'placeholder'		=> '10px',
            );

            $settings_tabs_field->generate_field($args);



            ?>
        </div>
        <?php
    }

}





















add_action('team_meta_tabs_content_templates', 'team_meta_tabs_content_templates',10, 2);

if(!function_exists('team_meta_tabs_content_templates')) {
    function team_meta_tabs_content_templates($tab, $post_id){
        $settings_tabs_field = new settings_tabs_field();

        //$team_items_thumb_size = get_post_meta( $post_id, 'team_items_thumb_size', true );
        $team_options = get_post_meta( $post_id, 'team_options', true );
        $template = isset($team_options['template']) ? $team_options['template'] : 'templateA';
        $template_id = isset($team_options['template_id']) ? $team_options['template_id'] : '';


        ?>
        <div class="section">
            <div class="section-title">Templates</div>
            <p class="description section-description">Choose your template.</p>

            <?php


            $args = array(
                'posts_per_page'   => -1,
                'orderby'          => 'date',
                'order'            => 'DESC',
                'post_type'        => 'team_template',
                'post_status'      => 'publish',

            );

            $posts_array = get_posts( $args );

            $postData = array();

            foreach ($posts_array as $post):
                $thumbnail_url = get_the_post_thumbnail_url($post->ID);
                $postData[$post->ID]['name'] = $post->post_title;
                $postData[$post->ID]['thumb'] = $thumbnail_url;

                $postData[$post->ID]['link'] = get_edit_post_link($post->ID);
                $postData[$post->ID]['link_text'] = 'Edit';


            endforeach;

            $postData['']['name'] = 'Create New';
            $postData['']['thumb'] = $thumbnail_url;

            $postData['']['link'] = admin_url().'post-new.php?post_type=team_template';
            $postData['']['link_text'] = 'Create New';
            $postData['']['disabled'] = true;



            $template_id = !empty($template_id) ? $template_id : key($postData);

            //var_dump(key($postData));



            $args = array(
                'id'		=> 'template_id',
                'parent' => 'team_options',
                'title'		=> __('Template','team'),
                'details'	=> __('Choose template.','team'),
                'type'		=> 'radio_image',
                'width'		=> '250px',
                'value'		=> $template_id,
                'default'		=> 'templateA',
                'args'		=> $postData,
            );

            $settings_tabs_field->generate_field($args);


            ?>


        </div>
        <?php

    }
}








//add_action('team_meta_tabs_content_templates', 'team_meta_tabs_content_elements',10, 2);

if(!function_exists('team_meta_tabs_content_elements')) {
    function team_meta_tabs_content_elements($tab, $post_id){

        $class_team_functions = new class_team_functions();
        $settings_tabs_field = new settings_tabs_field();
        $layout_templates = $class_team_functions->layout_templates();
        $layout_items = $class_team_functions->layout_items();




        $team_options = get_post_meta( $post_id, 'team_options', true );
        $template_layout_items = isset($team_options['layout_items']) ? $team_options['layout_items'] : array();
        $layout_items_sort = isset($team_options['layout_items_sort']) ? $team_options['layout_items_sort'] : array();
        $layout_items_hide = isset($team_options['layout_items_hide']) ? $team_options['layout_items_hide'] : array();
        $template = isset($team_options['template']) ? $team_options['template'] : 'templateA';

        $template_layout_items = isset($layout_templates[$template]) ? $layout_templates[$template] : $template_layout_items;

        $layout_items_sort = !empty($layout_items_sort) ? $layout_templates[$template] : $layout_items_sort;




        ?>
        <pre><?php //echo var_export($layout_templates[$template], true); ?></pre>
        <?php

        ?>
        <div class="section">
            <div class="section-title">Elements</div>
            <p class="description section-description">Customize the elements settings and style.</p>

            <?php

            ob_start();

            ?>
            <div class="expandable">

                <?php
                if(!empty($layout_items_sort)):
                    foreach ($layout_items_sort as $layout_item_key=>$layout_item_val):
                        $title = $layout_items[$layout_item_key]['title'];
                        $options_style = $layout_items[$layout_item_key]['style'];
                        $element_settings = isset($layout_items[$layout_item_key]['settings']) ?$layout_items[$layout_item_key]['settings'] : array();

                        $is_hide = isset($layout_items_hide[$layout_item_key]) ? true : false;



                        ?>
                        <div class="item">
                            <div class="header">
                                <span class="move"><i class="fa fa-bars"></i></span>
                                <span class="expand"><i class="fa fa-expand"></i><i class="fa fa-compress"></i></span>
                                <span class="name"><?php echo $title; ?></span>

                                <label class="float-right"><input type="checkbox" <?php if($is_hide ) echo 'checked';?>  class="layout_items_hide" name="team_options[layout_items_hide][<?php echo $layout_item_key; ?>]" value="1">Hide on front-end</label>

                                <input type="hidden" name="team_options[layout_items_sort][<?php echo $layout_item_key; ?>]" value="">

                            </div>
                            <div class="options">

                                <?php

                                if(!empty($element_settings)):
                                    foreach ($element_settings as $option){

                                        $option['css_id'] = $layout_item_key.'-'.$option['id'];
                                        $option['parent'] = 'team_options[layout_items]['.$layout_item_key.'][settings]';
                                        $option['value'] = isset($template_layout_items[$layout_item_key]['settings'][$option['id']]) ? $template_layout_items[$layout_item_key]['settings'][$option['id']] : '';

                                        $settings_tabs_field->generate_field($option);
                                    }
                                endif;



                                if(!empty($options_style)):
                                    foreach ($options_style as $option){

                                        $option['css_id'] = $layout_item_key.'-'.$option['id'];
                                        $option['parent'] = 'team_options[layout_items]['.$layout_item_key.'][style]';
                                        $option['value'] = isset($template_layout_items[$layout_item_key]['style'][$option['id']]) ? $template_layout_items[$layout_item_key]['style'][$option['id']] : '';

                                        $settings_tabs_field->generate_field($option);
                                    }
                                endif;


                                ?>

                            </div>
                        </div>
                        <?php

                    endforeach;

                    else:

                        foreach ($layout_items as $layout_item_key=>$layout_item_val):
                            $title = $layout_items[$layout_item_key]['title'];
                            $options_style = $layout_items[$layout_item_key]['style'];




                            ?>
                            <div class="item">
                                <div class="header">
                                    <span class="move"><i class="fa fa-bars"></i></span>
                                    <span class="expand"><i class="fa fa-expand"></i><i class="fa fa-compress"></i></span>
                                    <span class="name"><?php echo $title; ?></span>

                                    <label class="float-right"><input type="checkbox" class="layout_items_hide" name="layout_items_hide[<?php echo $layout_item_key; ?>]" value="1">Hide on front-end</label>

                                    <input type="hidden" name="team_options[layout_items_sort][<?php echo $layout_item_key; ?>]" value="">

                                </div>
                                <div class="options">

                                    <?php

                                    if(!empty($options_style)):
                                        foreach ($options_style as $option){

                                            $option['css_id'] = $layout_item_key.'-'.$option['id'];
                                            $option['parent'] = 'team_options[layout_items]['.$layout_item_key.'][style]';

                                            $settings_tabs_field->generate_field($option);
                                        }
                                    endif;


                                    ?>

                                </div>
                            </div>
                        <?php

                        endforeach;

                endif;

                ?>






            </div>
            <script>
                jQuery(document).ready(function($)
                {
                    $(function() {
                        $( ".expandable" ).sortable({ handle: '.move' });
                        //$( ".items" ).disableSelection();
                    });

                })

            </script>
            <?php



            $html = ob_get_clean();

            //var_dump($template);


                $args = array(
                    'id' => 'elements',
                    'parent' => 'team_options',
                    'title' => __('Slider elements', 'team'),
                    'details' => '',
                    'type' => 'custom_html',
                    'html' => $html,
                );
                $settings_tabs_field->generate_field($args);





            ?>


        </div>
        <?php


    }
}






























add_action('team_meta_tabs_content_team_members', 'team_meta_tabs_content_team_members',10, 2);

if(!function_exists('team_meta_tabs_content_team_members')) {
    function team_meta_tabs_content_team_members($tab, $post_id){
        $settings_tabs_field = new settings_tabs_field();

        $team_options = get_post_meta( $post_id, 'team_options', true );
        $team_members = isset($team_options['team_members']) ? $team_options['team_members'] : array();
        $skill = isset($team_options['skill']) ? $team_options['skill'] : array();
        $contacts = isset($team_options['contacts']) ? $team_options['contacts'] : array();

        $team_options_new = get_post_meta( $post_id, 'team_options_new', true );



        ?>
        <pre><?php //echo var_export($team_options, true);?></pre>

        <div class="section">
            <div class="section-title">Create team members</div>
            <p class="description section-description">Add your team members here.</p>



            <?php


//            $args = array(
//                'id' => 'social',
//                //'parent' => 'team_options',
//                'title' => __('team_social_input', 'team'),
//                'details' => '',
//                'type' => 'team_social_input',
//
//            );
//            $settings_tabs_field->generate_field($args);



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
}






















add_action('team_meta_tabs_content_slider_settings', 'team_meta_tabs_content_slider_settings',10, 2);

if(!function_exists('team_meta_tabs_content_slider_settings')) {
    function team_meta_tabs_content_slider_settings($tab, $post_id){

        $settings_tabs_field = new settings_tabs_field();
        $team_options = get_post_meta( $post_id, 'team_options', true );

        ?>
        <pre><?php //echo var_export($team_options, true); ?></pre>
        <?php



        $slider_column_desktop = isset($team_options['slider_column_desktop']) ? $team_options['slider_column_desktop'] : '2';
        $slider_column_tablet = isset($team_options['slider_column_tablet']) ? $team_options['slider_column_tablet'] : '2';
        $slider_column_mobile = isset($team_options['slider_column_mobile']) ? $team_options['slider_column_mobile'] : '1';

        $slider_rows_enable = isset($team_options['slider_rows_enable']) ? $team_options['slider_rows_enable'] : 'false';
        $slider_rows_desktop = isset($team_options['slider_rows_desktop']) ? $team_options['slider_rows_desktop'] : '2';
        $slider_rows_tablet = isset($team_options['slider_rows_tablet']) ? $team_options['slider_rows_tablet'] : '2';
        $slider_rows_mobile = isset($team_options['slider_rows_mobile']) ? $team_options['slider_rows_mobile'] : '2';

        $slider_auto_play = isset($team_options['slider_auto_play']) ? $team_options['slider_auto_play'] : 'true';
        $slider_auto_play_speed = isset($team_options['slider_auto_play_speed']) ? $team_options['slider_auto_play_speed'] : '1200';
        $slider_auto_play_timeout = isset($team_options['slider_auto_play_timeout']) ? $team_options['slider_auto_play_timeout'] : '1000';

        $slider_slide_speed = isset($team_options['slider_slide_speed']) ? $team_options['slider_slide_speed'] : '1000';
        $slider_pagination_slide_speed = isset($team_options['slider_pagination_slide_speed']) ? $team_options['slider_pagination_slide_speed'] : '1000';
        $slider_slideBy = isset($team_options['slider_slideBy']) ? $team_options['slider_slideBy'] : '4';


        $slider_rewind = isset($team_options['slider_rewind']) ? $team_options['slider_rewind'] : 'false';
        $slider_loop = isset($team_options['slider_loop']) ? $team_options['slider_loop'] : 'false';
        $slider_center = isset($team_options['slider_center']) ? $team_options['slider_center'] : 'false';
        $slider_stop_on_hover = isset($team_options['slider_stop_on_hover']) ? $team_options['slider_stop_on_hover'] : 'true';
        $slider_navigation = isset($team_options['slider_navigation']) ? $team_options['slider_navigation'] : 'false';
        $slider_navigation_position = isset($team_options['slider_navigation_position']) ? $team_options['slider_navigation_position'] : 'top-right';
        $slider_nav_theme = isset($team_options['slider_nav_theme']) ? $team_options['slider_nav_theme'] : 'navThemes1';


        $slider_pagination = isset($team_options['slider_pagination']) ? $team_options['slider_pagination'] : 'false';
        $slider_pagination_bg = isset($team_options['slider_pagination_bg']) ? $team_options['slider_pagination_bg'] : '';
        $slider_pagination_bg_active = isset($team_options['slider_pagination_bg_active']) ? $team_options['slider_pagination_bg_active'] : '';
        $slider_pagination_theme = isset($team_options['slider_pagination_theme']) ? $team_options['slider_pagination_theme'] : '';


        $slider_pagination_text_color = isset($team_options['slider_pagination_text_color']) ? $team_options['slider_pagination_text_color'] : '';
        $slider_pagination_count = isset($team_options['slider_pagination_count']) ? $team_options['slider_pagination_count'] : 'false';

        $slider_touch_drag = isset($team_options['slider_touch_drag']) ? $team_options['slider_touch_drag'] : 'true';
        $slider_mouse_drag = isset($team_options['slider_mouse_drag']) ? $team_options['slider_mouse_drag'] : 'true';
        $slider_rtl = isset($team_options['slider_rtl']) ? $team_options['slider_rtl'] : 'false';

        $slider_animateout = isset($team_options['slider_animateout']) ? $team_options['slider_animateout'] : '';
        $slider_animateIn = isset($team_options['slider_animateIn']) ? $team_options['slider_animateIn'] : '';




        ?>
        <div class="section">
        <div class="section-title">Slider Options</div>
        <p class="description section-description">Customize slider options here.</p>
            <?php


            ob_start();

            ?>
            <div><?php _e('In Destop: (min:1000px and max)', 'team');?></div>
            <input type="text" placeholder="4"   name="team_options[slider_column_desktop]" value="<?php echo $slider_column_desktop;  ?>" />

            <div><?php _e('In Tablet & Small Desktop: (900px max width)', 'team');?></div>
            <input type="text" placeholder="2"  name="team_options[slider_column_tablet]" value="<?php echo $slider_column_tablet;  ?>" />

            <div><?php _e('In Mobile: (479px max width)', 'team');?></div>
            <input type="text" placeholder="1"  name="team_options[slider_column_mobile]" value="<?php echo $slider_column_mobile;  ?>" />
            <?php


            $html = ob_get_clean();
            $args = array(
                'id' => 'slider_columns',
                'parent' => 'team_options',
                'title' => __('Slider column number', 'team'),
                'details' => '',
                'type' => 'custom_html',
                'html' => $html,
            );
            $settings_tabs_field->generate_field($args);




            $args = array(
                'id'		=> 'slider_rows_enable',
                'parent' => 'team_options',
                'title'		=> __('Enable slider row','team'),
                'details'	=> __('Enable or disable slider rows.','team'),
                'type'		=> 'select',
                'value'		=> $slider_rows_enable,
                'default'		=> 'false',
                'args'		=> array(
                    'true'=>__('True','team'),
                    'false'=>__('False','team'),



                ),
            );

            //$settings_tabs_field->generate_field($args);





            ob_start();

            ?>
            <div><?php _e('In Desktop: (min:1000px and max)', 'team');?></div>
            <input type="text" placeholder="2"   name="team_options[slider_rows_desktop]" value="<?php echo $slider_rows_desktop;  ?>" />

            <div><?php _e('In Tablet & Small Desktop: (900px max width)', 'team');?></div>
            <input type="text" placeholder="1"  name="team_options[slider_rows_tablet]" value="<?php echo $slider_rows_tablet;  ?>" />

            <div><?php _e('In Mobile: (479px max width)', 'team');?></div>
            <input type="text" placeholder="1"  name="team_options[slider_rows_mobile]" value="<?php echo $slider_rows_mobile;  ?>" />
            <?php


            $html = ob_get_clean();
            $args = array(
                'id' => 'slider_rows',
                'parent' => 'team_options',
                'title' => __('Slider row number', 'team'),
                'details' => '',
                'type' => 'custom_html',
                'html' => $html,
            );
            //$settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'slider_auto_play',
                'parent' => 'team_options',
                'title'		=> __('Slider auto play','team'),
                'details'	=> __('Enable or disable slider autoplay.','team'),
                'type'		=> 'select',
                'value'		=> $slider_auto_play,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','team'),
                    'false'=>__('False','team'),



                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_auto_play_speed',
                'parent' => 'team_options',
                'title'		=> __('Slider auto play speed','team'),
                'details'	=> __('Custom value for auto play speed, 1000 = 1 second','team'),
                'type'		=> 'text',
                'value'		=> $slider_auto_play_speed,
                'default'		=> '1000',
                'placeholder'		=> '1000',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_auto_play_timeout',
                'parent' => 'team_options',
                'title'		=> __('Slider auto play timeout','team'),
                'details'	=> __('Custom value for auto play timeout, 1000 = 1 second','team'),
                'type'		=> 'text',
                'value'		=> $slider_auto_play_timeout,
                'default'		=> '1200',
                'placeholder'		=> '1200',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_slide_speed',
                'parent' => 'team_options',
                'title'		=> __('Slide speed','team'),
                'details'	=> __('Custom value for slide speed, 1000 = 1 second','team'),
                'type'		=> 'text',
                'value'		=> $slider_slide_speed,
                'default'		=> '600',
                'placeholder'		=> '600',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_pagination_slide_speed',
                'parent' => 'team_options',
                'title'		=> __('Pagination Slide Speed','team'),
                'details'	=> __('Custom value for pagination slide speed, 1000 = 1 second','team'),
                'type'		=> 'text',
                'value'		=> $slider_pagination_slide_speed,
                'default'		=> '600',
                'placeholder'		=> '600',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'slider_slideBy',
                'parent' => 'team_options',
                'title'		=> __('Slider slideby count','team'),
                'details'	=> __('Custom value for slideby','team'),
                'type'		=> 'text',
                'value'		=> $slider_slideBy,
                'default'		=> '1',
                'placeholder'		=> '1',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_rewind',
                'parent' => 'team_options',
                'title'		=> __('Slider rewind','team'),
                'details'	=> __('Enable or disable slider rewind.','team'),
                'type'		=> 'select',
                'value'		=> $slider_rewind,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','team'),
                    'false'=>__('False','team'),
                ),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'slider_loop',
                'parent' => 'team_options',
                'title'		=> __('Slider loop','team'),
                'details'	=> __('Enable or disable slider loop.','team'),
                'type'		=> 'select',
                'value'		=> $slider_loop,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','team'),
                    'false'=>__('False','team'),
                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_center',
                'parent' => 'team_options',
                'title'		=> __('Slider center','team'),
                'details'	=> __('Enable or disable slider center. please set odd number of slider column to work slider center.','team'),
                'type'		=> 'select',
                'value'		=> $slider_center,
                'default'		=> 'false',
                'args'		=> array(
                    'true'=>__('True','team'),
                    'false'=>__('False','team'),
                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_stop_on_hover',
                'parent' => 'team_options',
                'title'		=> __('Slider stop on hover','team'),
                'details'	=> __('Enable or disable slider stop on hover.','team'),
                'type'		=> 'select',
                'value'		=> $slider_stop_on_hover,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','team'),
                    'false'=>__('False','team'),
                ),
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'slider_navigation',
                'parent' => 'team_options',
                'title'		=> __('Slider navigation at top','team'),
                'details'	=> __('Enable or disable slider navigation at Top.','team'),
                'type'		=> 'select',
                'value'		=> $slider_navigation,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','team'),
                    'false'=>__('False','team'),
                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_navigation_position',
                'parent' => 'team_options',
                'title'		=> __('Slider navigation position','team'),
                'details'	=> __('Choose slider navigation position.','team'),
                'type'		=> 'select',
                'value'		=> $slider_navigation_position,
                'default'		=> 'true',
                'args'		=> array(
                    'top-right'=>__('Top Right','team'),
                    'top-left'=>__('Top Left','team'),
                    'middle'=>__('Middle','team'),
                    'bottom-right'=>__('Bottom Right','team'),
                    'bottom-left'=>__('Bottom Left','team'),


                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_nav_theme',
                'parent' => 'team_options',
                'title'		=> __('Dots style','team'),
                'details'	=> __('Choose dots template.','team'),
                'type'		=> 'radio_image',
                'value'		=> $slider_nav_theme,
                'default'		=> 'navThemes1',
                'width'		=> '100px',
                'args'		=> array(

                    'navThemes1'=>array('name'=>'navThemes1','thumb'=>team_plugin_url.'assets/admin/images/navThemes1.png'),
                    'navThemes2'=>array('name'=>'navThemes2','thumb'=>team_plugin_url.'assets/admin/images/navThemes2.png'),

                    'navThemes3'=>array('name'=>'navThemes3','thumb'=>team_plugin_url.'assets/admin/images/navThemes3.png'),
                    'navThemes4'=>array('name'=>'navThemes4','thumb'=>team_plugin_url.'assets/admin/images/navThemes4.png'),

                    'navThemes5'=>array('name'=>'navThemes5','thumb'=>team_plugin_url.'assets/admin/images/navThemes5.png'),
                    'navThemes6'=>array('name'=>'navThemes6','thumb'=>team_plugin_url.'assets/admin/images/navThemes6.png'),

                    'navThemes7'=>array('name'=>'navThemes7','thumb'=>team_plugin_url.'assets/admin/images/navThemes7.png'),




                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_pagination',
                'parent' => 'team_options',
                'title'		=> __('Slider Pagination at bottom','team'),
                'details'	=> __('Enable or disable slider Pagination at bottom.','team'),
                'type'		=> 'select',
                'value'		=> $slider_pagination,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','team'),
                    'false'=>__('False','team'),
                ),
            );

            $settings_tabs_field->generate_field($args);





            $args = array(
                'id'		=> 'slider_pagination_bg',
                'parent' => 'team_options',
                'title'		=> __('Pagination background color','team'),
                'details'	=> __('Choose custom pagination background color','team'),
                'type'		=> 'colorpicker',
                'value'		=> $slider_pagination_bg,
                'default'		=> '#ddd',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_pagination_bg_active',
                'parent' => 'team_options',
                'title'		=> __('Pagination active background color','team'),
                'details'	=> __('Choose custom pagination background color','team'),
                'type'		=> 'colorpicker',
                'value'		=> $slider_pagination_bg_active,
                'default'		=> '#ddd',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_pagination_text_color',
                'parent' => 'team_options',
                'title'		=> __('Pagination text color','team'),
                'details'	=> __('Choose custom pagination text color','team'),
                'type'		=> 'colorpicker',
                'value'		=> $slider_pagination_text_color,
                'default'		=> '#999',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_pagination_theme',
                'parent' => 'team_options',
                'title'		=> __('Dots style','team'),
                'details'	=> __('Choose dots template.','team'),
                'type'		=> 'radio_image',
                'value'		=> $slider_pagination_theme,
                'default'		=> 'dotsThemes1',
                'width'		=> '100px',
                'args'		=> array(

                    'dotsThemes1'=>array('name'=>'dotsThemes1','thumb'=>team_plugin_url.'assets/admin/images/dotsThemes1.png'),
                    'dotsThemes2'=>array('name'=>'dotsThemes2','thumb'=>team_plugin_url.'assets/admin/images/dotsThemes2.png'),

                    'dotsThemes3'=>array('name'=>'dotsThemes3','thumb'=>team_plugin_url.'assets/admin/images/dotsThemes3.png'),
                    'dotsThemes4'=>array('name'=>'dotsThemes4','thumb'=>team_plugin_url.'assets/admin/images/dotsThemes4.png'),

                    'dotsThemes5'=>array('name'=>'dotsThemes5','thumb'=>team_plugin_url.'assets/admin/images/dotsThemes5.png'),
                    'dotsThemes6'=>array('name'=>'dotsThemes6','thumb'=>team_plugin_url.'assets/admin/images/dotsThemes6.png'),

                    'dotsThemes7'=>array('name'=>'dotsThemes7','thumb'=>team_plugin_url.'assets/admin/images/dotsThemes7.png'),
                    'dotsThemes8'=>array('name'=>'dotsThemes8','thumb'=>team_plugin_url.'assets/admin/images/dotsThemes8.png'),

//                    'dotsThemes9'=>array('name'=>'dotsThemes9','thumb'=>team_plugin_url.'assets/admin/images/dotsThemes9.png'),
//                    'dotsThemes10'=>array('name'=>'dotsThemes10','thumb'=>team_plugin_url.'assets/admin/images/dotsThemes10.png'),



                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_pagination_count',
                'parent' => 'team_options',
                'title'		=> __('Slider pagination number counting','team'),
                'details'	=> __('Enable or disable slider pagination number counting.','team'),
                'type'		=> 'select',
                'value'		=> $slider_pagination_count,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','team'),
                    'false'=>__('False','team'),
                ),
            );

            $settings_tabs_field->generate_field($args);




            $args = array(
                'id'		=> 'slider_touch_drag',
                'parent' => 'team_options',
                'title'		=> __('Slider touch drag enable','team'),
                'details'	=> __('Enable or disable slider touch drag.','team'),
                'type'		=> 'select',
                'value'		=> $slider_touch_drag,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','team'),
                    'false'=>__('False','team'),
                ),
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'slider_mouse_drag',
                'parent' => 'team_options',
                'title'		=> __('Slider mouse drag enable','team'),
                'details'	=> __('Enable or disable slider mouse drag.','team'),
                'type'		=> 'select',
                'value'		=> $slider_mouse_drag,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','team'),
                    'false'=>__('False','team'),
                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_rtl',
                'parent' => 'team_options',
                'title'		=> __('RTL enable','team'),
                'details'	=> __('Enable or disable slider RTL.','team'),
                'type'		=> 'select',
                'value'		=> $slider_rtl,
                'default'		=> 'false',
                'args'		=> array(
                    'true'=>__('True','team'),
                    'false'=>__('False','team'),
                ),
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'slider_animateout',
                'parent' => 'team_options',
                'title'		=> __('Animate Out','team'),
                'details'	=> __('Choose animation on out.','team'),
                'type'		=> 'select',
                'value'		=> $slider_animateout,
                'default'		=> 'false',
                'args'		=> array(
                    'fadeOut'=>__('fadeOut','team'),
                    'bounce'=>__('bounce','team'),
                    'flash'=>__('flash','team'),
                    'pulse'=>__('pulse','team'),
                    'shake'=>__('shake','team'),
                    'swing'=>__('swing','team'),
                    'tada'=>__('tada','team'),
                    'wobble'=>__('wobble','team'),
                    'flip'=>__('flip','team'),
                    'flipInX'=>__('flipInX','team'),
                    'flipInY'=>__('flipInY','team'),
                    'fadeIn'=>__('fadeIn','team'),
                    'fadeInDown'=>__('fadeInDown','team'),
                    'fadeInUp'=>__('fadeInUp','team'),
                    'bounceIn'=>__('bounceIn','team'),
                    'bounceInDown'=>__('bounceInDown','team'),
                    'bounceInUp'=>__('bounceInUp','team'),


                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_animateIn',
                'parent' => 'team_options',
                'title'		=> __('Animate Out','team'),
                'details'	=> __('Choose animation on out.','team'),
                'type'		=> 'select',
                'value'		=> $slider_animateIn,
                'default'		=> 'false',
                'args'		=> array(
                    'fadeOut'=>__('fadeOut','team'),
                    'bounce'=>__('bounce','team'),
                    'flash'=>__('flash','team'),
                    'pulse'=>__('pulse','team'),
                    'shake'=>__('shake','team'),
                    'swing'=>__('swing','team'),
                    'tada'=>__('tada','team'),
                    'wobble'=>__('wobble','team'),
                    'flip'=>__('flip','team'),
                    'flipInX'=>__('flipInX','team'),
                    'flipInY'=>__('flipInY','team'),
                    'fadeIn'=>__('fadeIn','team'),
                    'fadeInDown'=>__('fadeInDown','team'),
                    'fadeInUp'=>__('fadeInUp','team'),
                    'bounceIn'=>__('bounceIn','team'),
                    'bounceInDown'=>__('bounceInDown','team'),
                    'bounceInUp'=>__('bounceInUp','team'),


                ),
            );

            $settings_tabs_field->generate_field($args);











            ?>
        </div>
        <?php
    }
}


add_action('team_meta_tabs_content_shortcode', 'team_meta_tabs_content_shortcode',10, 2);

if(!function_exists('team_meta_tabs_content_shortcode')) {
    function team_meta_tabs_content_shortcode($tab, $post_id){

        $settings_tabs_field = new settings_tabs_field();


        ?>
        <div class="section">
            <div class="section-title">Shortcodes</div>
            <p class="description section-description">Simply copy these shortcode and user under post or page content</p>


            <?php
            ob_start();
            ?>

            <div class="copy-to-clipboard">
                <input type="text" value="[team id='<?php echo $post_id; ?>']"> <span class="copied">Copied</span>
                <p class="description">You can use this shortcode under post content</p>
            </div>

            <div class="copy-to-clipboard">
                To avoid conflict:<br>
                <input type="text" value="[team_pickplugins id='<?php echo $post_id; ?>']"> <span
                    class="copied">Copied</span>
                <p class="description">To avoid conflict with 3rd party shortcode also used same <code>[team]</code>You can use this shortcode under post content</p>
            </div>

            <div class="copy-to-clipboard">
                <textarea cols="50" rows="2" style="background:#bfefff" onClick="this.select();"><?php echo '<?php echo do_shortcode("[team id='; echo "'" . $post_id . "']"; echo '"); ?>'; ?></textarea> <span class="copied">Copied</span>
                <p class="description">PHP Code, you can use under theme .php files.</p>
            </div>

            <div class="copy-to-clipboard">
                <textarea cols="50" rows="2" style="background:#bfefff"
                          onClick="this.select();"><?php echo '<?php echo do_shortcode("[team_pickplugins id=';
                    echo "'" . $post_id . "']";
                    echo '"); ?>'; ?></textarea> <span class="copied">Copied</span>
                <p class="description">To avoid conflict, PHP code you can use under theme .php files.</p>
            </div>

            <style type="text/css">
                .team-meta-box .copy-to-clipboard {
                }

                .team-meta-box .copy-to-clipboard .copied {
                    display: none;
                    background: #e5e5e5;
                    padding: 4px 10px;
                    line-height: normal;
                }
            </style>

            <script>
                jQuery(document).ready(function ($) {
                    $(document).on('click', '.team-meta-box .copy-to-clipboard input, .team-meta-box .copy-to-clipboard textarea', function () {
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
                'id' => 'team_shortcodes',
                'title' => __('Get shortcode', 'team'),
                'details' => '',
                'type' => 'custom_html',
                'html' => $html,
            );
            $settings_tabs_field->generate_field($args);



            ob_start();
            ?>

            <div class="copy-to-clipboard">
                <input type="text" value="[team_form id='<?php echo $post_id; ?>']"> <span class="copied">Copied</span>
                <p class="description">You can use this shortcode under post content</p>
            </div>



            <div class="copy-to-clipboard">
                <textarea cols="50" rows="2" style="background:#bfefff" onClick="this.select();"><?php echo '<?php echo do_shortcode("[team_form id='; echo "'" . $post_id . "']"; echo '"); ?>'; ?></textarea> <span class="copied">Copied</span>
                <p class="description">PHP Code, you can use under theme .php files.</p>
            </div>

            <?php
            $html = ob_get_clean();
            $args = array(
                'id' => 'team_form',
                'title' => __('Submit form', 'team'),
                'details' => '',
                'type' => 'custom_html',
                'html' => $html,
            );
            $settings_tabs_field->generate_field($args);














            ?>
        </div>
        <?php
    }
}