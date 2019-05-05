<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
















add_action('testimonial_meta_tabs_content_custom_scripts', 'testimonial_meta_tabs_content_custom_scripts',10, 2);

if(!function_exists('testimonial_meta_tabs_content_custom_scripts')) {
    function testimonial_meta_tabs_content_custom_scripts($tab, $post_id){


        $settings_tabs_field = new settings_tabs_field();

        $team_options = get_post_meta( $post_id, 'team_options', true );

        ?>
        <pre><?php //echo var_export($team_options, true); ?></pre>
        <?php



        $custom_css = isset($team_options['custom_css']) ? $team_options['custom_css'] : '';


        ?>
        <div class="section">
            <div class="section-title">Custom scripts</div>
            <p class="description section-description">Add your own scritps and style css.</p>

            <?php

            $args = array(
                'id'		=> 'custom_css',
                'parent' => 'team_options',
                'title'		=> __('Custom CSS','testimonial'),
                'details'	=> __('Add your own CSS..','testimonial'),
                'type'		=> 'scripts_css',
                'value'		=> $custom_css,
                'default'		=> '.testimonial-container #testimonial-133{}&#10; ',
            );

            $settings_tabs_field->generate_field($args);









            ?>


        </div>
        <?php






	}

}









add_action('testimonial_meta_tabs_content_templates', 'testimonial_meta_tabs_content_templates',10, 2);

if(!function_exists('testimonial_meta_tabs_content_templates')) {
    function testimonial_meta_tabs_content_templates($tab, $post_id){
        $settings_tabs_field = new settings_tabs_field();

        //$testimonial_items_thumb_size = get_post_meta( $post_id, 'testimonial_items_thumb_size', true );
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
                'post_type'        => 'testimonial_template',
                'post_status'      => 'publish',

            );

            $posts_array = get_posts( $args );

            $postData = array();

            foreach ($posts_array as $post):
                $thumbnail_url = get_the_post_thumbnail_url($post->ID);
                $postData[$post->ID]['name'] = $post->post_title;
                $postData[$post->ID]['thumb'] = $thumbnail_url;


            endforeach;


            $template_id = !empty($template_id) ? $template_id : key($postData);

            //var_dump(key($postData));



            $args = array(
                'id'		=> 'template_id',
                'parent' => 'team_options',
                'title'		=> __('Template','testimonial'),
                'details'	=> __('Choose template.','testimonial'),
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








//add_action('testimonial_meta_tabs_content_templates', 'testimonial_meta_tabs_content_elements',10, 2);

if(!function_exists('testimonial_meta_tabs_content_elements')) {
    function testimonial_meta_tabs_content_elements($tab, $post_id){

        $class_testimonial_functions = new class_testimonial_functions();
        $settings_tabs_field = new settings_tabs_field();
        $layout_templates = $class_testimonial_functions->layout_templates();
        $layout_items = $class_testimonial_functions->layout_items();




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
                    'title' => __('Slider elements', 'testimonial'),
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






























add_action('testimonial_meta_tabs_content_team_members', 'testimonial_meta_tabs_content_team_members',10, 2);

if(!function_exists('testimonial_meta_tabs_content_team_members')) {
    function testimonial_meta_tabs_content_team_members($tab, $post_id){
        $settings_tabs_field = new settings_tabs_field();

        $team_options = get_post_meta( $post_id, 'team_options', true );
        $testimonials = isset($team_options['testimonials']) ? $team_options['testimonials'] : array();
        $skill = isset($team_options['skill']) ? $team_options['skill'] : array();
        $contacts = isset($team_options['contacts']) ? $team_options['contacts'] : array();

        //var_dump($team_options);

        ?>
        <pre><?php //echo var_export($skill, true);?></pre>

        <div class="section">
            <div class="section-title">Create team members</div>
            <p class="description section-description">Add your team members here.</p>



            <?php


//            $args = array(
//                'id' => 'social',
//                //'parent' => 'team_options',
//                'title' => __('team_social_input', 'testimonial'),
//                'details' => '',
//                'type' => 'team_social_input',
//
//            );
//            $settings_tabs_field->generate_field($args);



            $testimonials_fields = array(

                array(
                    'id'		=> 'name',
                    'title'		=> __('Name','testimonial'),
                    'details'	=> __('Write name here.','testimonial'),
                    'type'		=> 'text',
                    'value'		=> '',
                    'default'		=> '',
                    'placeholder'		=> 'Mark Jhon',
                ),
                array(
                    'id'		=> 'content',
                    'title'		=> __('Content','testimonial'),
                    'details'	=> __('Write details text here.','testimonial'),
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
                    'title'		=> __('Position','testimonial'),
                    'details'	=> __('Write position here.','testimonial'),
                    'type'		=> 'text',
                    'value'		=> '',
                    'default'		=> '',
                    'placeholder'		=> 'Lead Developer',
                ),

                array(
                    'id'		=> 'custom_link',
                    'title'		=> __('Custom link','testimonial'),
                    'details'	=> __('Custom link to member.','testimonial'),
                    'type'		=> 'text',
                    'value'		=> '',
                    'default'		=> '',
                    'placeholder'		=> '',
                ),

                array(
                    'id'		=> 'skill',
                    //'parent'		=> 'team_options',
                    'title'		=> __('Skill','testimonial'),
                    'details'	=> __('Add some skills.','testimonial'),
                    'type'		=> 'text_multi',
                    'sortable'		=> true,
                    'value'		=> $skill,
                    'default'		=> array(),
                    'args'		=> array(),
                ),


                array(
                    'id'		=> 'contacts',
                    'parent'		=> 'team_options',
                    'title'		=> __('Member contact','testimonial'),
                    'details'	=> __('Add team member contact.','testimonial'),
                    'type'		=> 'team_social_input',
                    'value'		=> $contacts,
                    'default'		=> '',
                    'placeholder'		=> '',
                ),





            );


            $testimonials_fields = apply_filters('testimonials_fields', $testimonials_fields);


            $args = array(
                'id'		=> 'testimonials',
                'parent'		=> 'team_options',
                'title'		=> __('Testimonials','text-domain'),
                'details'	=> __('Put your testimonial here','text-domain'),
                'collapsible'=>true,
                'type'		=> 'repeatable',
                'limit'		=> 10,
                'title_field'		=> 'name',
                'value'		=> $testimonials,
                'fields'    => $testimonials_fields,
            );

            $settings_tabs_field->generate_field($args);







            ?>


        </div>
        <?php

    }
}






















add_action('testimonial_meta_tabs_content_slider_settings', 'testimonial_meta_tabs_content_slider_settings',10, 2);

if(!function_exists('testimonial_meta_tabs_content_slider_settings')) {
    function testimonial_meta_tabs_content_slider_settings($tab, $post_id){

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
            <div><?php _e('In Destop: (min:1000px and max)', 'testimonial');?></div>
            <input type="text" placeholder="4"   name="team_options[slider_column_desktop]" value="<?php echo $slider_column_desktop;  ?>" />

            <div><?php _e('In Tablet & Small Desktop: (900px max width)', 'testimonial');?></div>
            <input type="text" placeholder="2"  name="team_options[slider_column_tablet]" value="<?php echo $slider_column_tablet;  ?>" />

            <div><?php _e('In Mobile: (479px max width)', 'testimonial');?></div>
            <input type="text" placeholder="1"  name="team_options[slider_column_mobile]" value="<?php echo $slider_column_mobile;  ?>" />
            <?php


            $html = ob_get_clean();
            $args = array(
                'id' => 'slider_columns',
                'parent' => 'team_options',
                'title' => __('Slider column number', 'testimonial'),
                'details' => '',
                'type' => 'custom_html',
                'html' => $html,
            );
            $settings_tabs_field->generate_field($args);




            $args = array(
                'id'		=> 'slider_rows_enable',
                'parent' => 'team_options',
                'title'		=> __('Enable slider row','testimonial'),
                'details'	=> __('Enable or disable slider rows.','testimonial'),
                'type'		=> 'select',
                'value'		=> $slider_rows_enable,
                'default'		=> 'false',
                'args'		=> array(
                    'true'=>__('True','testimonial'),
                    'false'=>__('False','testimonial'),



                ),
            );

            //$settings_tabs_field->generate_field($args);





            ob_start();

            ?>
            <div><?php _e('In Desktop: (min:1000px and max)', 'testimonial');?></div>
            <input type="text" placeholder="2"   name="team_options[slider_rows_desktop]" value="<?php echo $slider_rows_desktop;  ?>" />

            <div><?php _e('In Tablet & Small Desktop: (900px max width)', 'testimonial');?></div>
            <input type="text" placeholder="1"  name="team_options[slider_rows_tablet]" value="<?php echo $slider_rows_tablet;  ?>" />

            <div><?php _e('In Mobile: (479px max width)', 'testimonial');?></div>
            <input type="text" placeholder="1"  name="team_options[slider_rows_mobile]" value="<?php echo $slider_rows_mobile;  ?>" />
            <?php


            $html = ob_get_clean();
            $args = array(
                'id' => 'slider_rows',
                'parent' => 'team_options',
                'title' => __('Slider row number', 'testimonial'),
                'details' => '',
                'type' => 'custom_html',
                'html' => $html,
            );
            //$settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'slider_auto_play',
                'parent' => 'team_options',
                'title'		=> __('Slider auto play','testimonial'),
                'details'	=> __('Enable or disable slider autoplay.','testimonial'),
                'type'		=> 'select',
                'value'		=> $slider_auto_play,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','testimonial'),
                    'false'=>__('False','testimonial'),



                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_auto_play_speed',
                'parent' => 'team_options',
                'title'		=> __('Slider auto play speed','testimonial'),
                'details'	=> __('Custom value for auto play speed, 1000 = 1 second','testimonial'),
                'type'		=> 'text',
                'value'		=> $slider_auto_play_speed,
                'default'		=> '1000',
                'placeholder'		=> '1000',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_auto_play_timeout',
                'parent' => 'team_options',
                'title'		=> __('Slider auto play timeout','testimonial'),
                'details'	=> __('Custom value for auto play timeout, 1000 = 1 second','testimonial'),
                'type'		=> 'text',
                'value'		=> $slider_auto_play_timeout,
                'default'		=> '1200',
                'placeholder'		=> '1200',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_slide_speed',
                'parent' => 'team_options',
                'title'		=> __('Slide speed','testimonial'),
                'details'	=> __('Custom value for slide speed, 1000 = 1 second','testimonial'),
                'type'		=> 'text',
                'value'		=> $slider_slide_speed,
                'default'		=> '600',
                'placeholder'		=> '600',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_pagination_slide_speed',
                'parent' => 'team_options',
                'title'		=> __('Pagination Slide Speed','testimonial'),
                'details'	=> __('Custom value for pagination slide speed, 1000 = 1 second','testimonial'),
                'type'		=> 'text',
                'value'		=> $slider_pagination_slide_speed,
                'default'		=> '600',
                'placeholder'		=> '600',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'slider_slideBy',
                'parent' => 'team_options',
                'title'		=> __('Slider slideby count','testimonial'),
                'details'	=> __('Custom value for slideby','testimonial'),
                'type'		=> 'text',
                'value'		=> $slider_slideBy,
                'default'		=> '1',
                'placeholder'		=> '1',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_rewind',
                'parent' => 'team_options',
                'title'		=> __('Slider rewind','testimonial'),
                'details'	=> __('Enable or disable slider rewind.','testimonial'),
                'type'		=> 'select',
                'value'		=> $slider_rewind,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','testimonial'),
                    'false'=>__('False','testimonial'),
                ),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'slider_loop',
                'parent' => 'team_options',
                'title'		=> __('Slider loop','testimonial'),
                'details'	=> __('Enable or disable slider loop.','testimonial'),
                'type'		=> 'select',
                'value'		=> $slider_loop,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','testimonial'),
                    'false'=>__('False','testimonial'),
                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_center',
                'parent' => 'team_options',
                'title'		=> __('Slider center','testimonial'),
                'details'	=> __('Enable or disable slider center. please set odd number of slider column to work slider center.','testimonial'),
                'type'		=> 'select',
                'value'		=> $slider_center,
                'default'		=> 'false',
                'args'		=> array(
                    'true'=>__('True','testimonial'),
                    'false'=>__('False','testimonial'),
                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_stop_on_hover',
                'parent' => 'team_options',
                'title'		=> __('Slider stop on hover','testimonial'),
                'details'	=> __('Enable or disable slider stop on hover.','testimonial'),
                'type'		=> 'select',
                'value'		=> $slider_stop_on_hover,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','testimonial'),
                    'false'=>__('False','testimonial'),
                ),
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'slider_navigation',
                'parent' => 'team_options',
                'title'		=> __('Slider navigation at top','testimonial'),
                'details'	=> __('Enable or disable slider navigation at Top.','testimonial'),
                'type'		=> 'select',
                'value'		=> $slider_navigation,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','testimonial'),
                    'false'=>__('False','testimonial'),
                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_navigation_position',
                'parent' => 'team_options',
                'title'		=> __('Slider navigation position','testimonial'),
                'details'	=> __('Choose slider navigation position.','testimonial'),
                'type'		=> 'select',
                'value'		=> $slider_navigation_position,
                'default'		=> 'true',
                'args'		=> array(
                    'top-right'=>__('Top Right','testimonial'),
                    'top-left'=>__('Top Left','testimonial'),
                    'middle'=>__('Middle','testimonial'),
                    'bottom-right'=>__('Bottom Right','testimonial'),
                    'bottom-left'=>__('Bottom Left','testimonial'),


                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_nav_theme',
                'parent' => 'team_options',
                'title'		=> __('Dots style','testimonial'),
                'details'	=> __('Choose dots template.','testimonial'),
                'type'		=> 'radio_image',
                'value'		=> $slider_nav_theme,
                'default'		=> 'navThemes1',
                'width'		=> '50px',
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
                'title'		=> __('Slider Pagination at bottom','testimonial'),
                'details'	=> __('Enable or disable slider Pagination at bottom.','testimonial'),
                'type'		=> 'select',
                'value'		=> $slider_pagination,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','testimonial'),
                    'false'=>__('False','testimonial'),
                ),
            );

            $settings_tabs_field->generate_field($args);





            $args = array(
                'id'		=> 'slider_pagination_bg',
                'parent' => 'team_options',
                'title'		=> __('Pagination background color','testimonial'),
                'details'	=> __('Choose custom pagination background color','testimonial'),
                'type'		=> 'colorpicker',
                'value'		=> $slider_pagination_bg,
                'default'		=> '#ddd',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_pagination_bg_active',
                'parent' => 'team_options',
                'title'		=> __('Pagination active background color','testimonial'),
                'details'	=> __('Choose custom pagination background color','testimonial'),
                'type'		=> 'colorpicker',
                'value'		=> $slider_pagination_bg_active,
                'default'		=> '#ddd',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_pagination_text_color',
                'parent' => 'team_options',
                'title'		=> __('Pagination text color','testimonial'),
                'details'	=> __('Choose custom pagination text color','testimonial'),
                'type'		=> 'colorpicker',
                'value'		=> $slider_pagination_text_color,
                'default'		=> '#999',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_pagination_theme',
                'parent' => 'team_options',
                'title'		=> __('Dots style','testimonial'),
                'details'	=> __('Choose dots template.','testimonial'),
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
                'title'		=> __('Slider pagination number counting','testimonial'),
                'details'	=> __('Enable or disable slider pagination number counting.','testimonial'),
                'type'		=> 'select',
                'value'		=> $slider_pagination_count,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','testimonial'),
                    'false'=>__('False','testimonial'),
                ),
            );

            $settings_tabs_field->generate_field($args);




            $args = array(
                'id'		=> 'slider_touch_drag',
                'parent' => 'team_options',
                'title'		=> __('Slider touch drag enable','testimonial'),
                'details'	=> __('Enable or disable slider touch drag.','testimonial'),
                'type'		=> 'select',
                'value'		=> $slider_touch_drag,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','testimonial'),
                    'false'=>__('False','testimonial'),
                ),
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'slider_mouse_drag',
                'parent' => 'team_options',
                'title'		=> __('Slider mouse drag enable','testimonial'),
                'details'	=> __('Enable or disable slider mouse drag.','testimonial'),
                'type'		=> 'select',
                'value'		=> $slider_mouse_drag,
                'default'		=> 'true',
                'args'		=> array(
                    'true'=>__('True','testimonial'),
                    'false'=>__('False','testimonial'),
                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_rtl',
                'parent' => 'team_options',
                'title'		=> __('RTL enable','testimonial'),
                'details'	=> __('Enable or disable slider RTL.','testimonial'),
                'type'		=> 'select',
                'value'		=> $slider_rtl,
                'default'		=> 'false',
                'args'		=> array(
                    'true'=>__('True','testimonial'),
                    'false'=>__('False','testimonial'),
                ),
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'slider_animateout',
                'parent' => 'team_options',
                'title'		=> __('Animate Out','testimonial'),
                'details'	=> __('Choose animation on out.','testimonial'),
                'type'		=> 'select',
                'value'		=> $slider_animateout,
                'default'		=> 'false',
                'args'		=> array(
                    'fadeOut'=>__('fadeOut','testimonial'),
                    'bounce'=>__('bounce','testimonial'),
                    'flash'=>__('flash','testimonial'),
                    'pulse'=>__('pulse','testimonial'),
                    'shake'=>__('shake','testimonial'),
                    'swing'=>__('swing','testimonial'),
                    'tada'=>__('tada','testimonial'),
                    'wobble'=>__('wobble','testimonial'),
                    'flip'=>__('flip','testimonial'),
                    'flipInX'=>__('flipInX','testimonial'),
                    'flipInY'=>__('flipInY','testimonial'),
                    'fadeIn'=>__('fadeIn','testimonial'),
                    'fadeInDown'=>__('fadeInDown','testimonial'),
                    'fadeInUp'=>__('fadeInUp','testimonial'),
                    'bounceIn'=>__('bounceIn','testimonial'),
                    'bounceInDown'=>__('bounceInDown','testimonial'),
                    'bounceInUp'=>__('bounceInUp','testimonial'),


                ),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'slider_animateIn',
                'parent' => 'team_options',
                'title'		=> __('Animate Out','testimonial'),
                'details'	=> __('Choose animation on out.','testimonial'),
                'type'		=> 'select',
                'value'		=> $slider_animateIn,
                'default'		=> 'false',
                'args'		=> array(
                    'fadeOut'=>__('fadeOut','testimonial'),
                    'bounce'=>__('bounce','testimonial'),
                    'flash'=>__('flash','testimonial'),
                    'pulse'=>__('pulse','testimonial'),
                    'shake'=>__('shake','testimonial'),
                    'swing'=>__('swing','testimonial'),
                    'tada'=>__('tada','testimonial'),
                    'wobble'=>__('wobble','testimonial'),
                    'flip'=>__('flip','testimonial'),
                    'flipInX'=>__('flipInX','testimonial'),
                    'flipInY'=>__('flipInY','testimonial'),
                    'fadeIn'=>__('fadeIn','testimonial'),
                    'fadeInDown'=>__('fadeInDown','testimonial'),
                    'fadeInUp'=>__('fadeInUp','testimonial'),
                    'bounceIn'=>__('bounceIn','testimonial'),
                    'bounceInDown'=>__('bounceInDown','testimonial'),
                    'bounceInUp'=>__('bounceInUp','testimonial'),


                ),
            );

            $settings_tabs_field->generate_field($args);











            ?>
        </div>
        <?php
    }
}


add_action('testimonial_meta_tabs_content_shortcode', 'testimonial_meta_tabs_content_shortcode',10, 2);

if(!function_exists('testimonial_meta_tabs_content_shortcode')) {
    function testimonial_meta_tabs_content_shortcode($tab, $post_id){

        $settings_tabs_field = new settings_tabs_field();


        ?>
        <div class="section">
            <div class="section-title">Shortcodes</div>
            <p class="description section-description">Simply copy these shortcode and user under post or page content</p>


            <?php
            ob_start();
            ?>

            <div class="copy-to-clipboard">
                <input type="text" value="[testimonial id='<?php echo $post_id; ?>']"> <span class="copied">Copied</span>
                <p class="description">You can use this shortcode under post content</p>
            </div>

            <div class="copy-to-clipboard">
                To avoid conflict:<br>
                <input type="text" value="[testimonial_pickplugins id='<?php echo $post_id; ?>']"> <span
                    class="copied">Copied</span>
                <p class="description">To avoid conflict with 3rd party shortcode also used same <code>[testimonial]</code>You can use this shortcode under post content</p>
            </div>

            <div class="copy-to-clipboard">
                <textarea cols="50" rows="2" style="background:#bfefff" onClick="this.select();"><?php echo '<?php echo do_shortcode("[testimonial id='; echo "'" . $post_id . "']"; echo '"); ?>'; ?></textarea> <span class="copied">Copied</span>
                <p class="description">PHP Code, you can use under theme .php files.</p>
            </div>

            <div class="copy-to-clipboard">
                <textarea cols="50" rows="2" style="background:#bfefff"
                          onClick="this.select();"><?php echo '<?php echo do_shortcode("[testimonial_pickplugins id=';
                    echo "'" . $post_id . "']";
                    echo '"); ?>'; ?></textarea> <span class="copied">Copied</span>
                <p class="description">To avoid conflict, PHP code you can use under theme .php files.</p>
            </div>

            <style type="text/css">
                .testimonial-meta-box .copy-to-clipboard {
                }

                .testimonial-meta-box .copy-to-clipboard .copied {
                    display: none;
                    background: #e5e5e5;
                    padding: 4px 10px;
                    line-height: normal;
                }
            </style>

            <script>
                jQuery(document).ready(function ($) {
                    $(document).on('click', '.testimonial-meta-box .copy-to-clipboard input, .testimonial-meta-box .copy-to-clipboard textarea', function () {
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
                'id' => 'testimonial_shortcodes',
                'title' => __('Get shortcode', 'testimonial'),
                'details' => '',
                'type' => 'custom_html',
                'html' => $html,
            );
            $settings_tabs_field->generate_field($args);



            ob_start();
            ?>

            <div class="copy-to-clipboard">
                <input type="text" value="[testimonial_form id='<?php echo $post_id; ?>']"> <span class="copied">Copied</span>
                <p class="description">You can use this shortcode under post content</p>
            </div>



            <div class="copy-to-clipboard">
                <textarea cols="50" rows="2" style="background:#bfefff" onClick="this.select();"><?php echo '<?php echo do_shortcode("[testimonial_form id='; echo "'" . $post_id . "']"; echo '"); ?>'; ?></textarea> <span class="copied">Copied</span>
                <p class="description">PHP Code, you can use under theme .php files.</p>
            </div>

            <?php
            $html = ob_get_clean();
            $args = array(
                'id' => 'testimonial_form',
                'title' => __('Submit form', 'testimonial'),
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