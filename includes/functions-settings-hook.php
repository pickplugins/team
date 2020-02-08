<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


add_action('layout_elements_option_title','layout_elements_option_title');


function layout_elements_option_title($parameters){

    $settings_tabs_field = new settings_tabs_field();

    $input_name = isset($parameters['input_name']) ? $parameters['input_name'] : '{input_name}';
    $element_data = isset($parameters['element_data']) ? $parameters['element_data'] : array();
    $element_index = isset($parameters['index']) ? $parameters['index'] : '';


    $color = isset($element_data['color']) ? $element_data['color'] : '';
    $font_size = isset($element_data['font_size']) ? $element_data['font_size'] : '';
    $font_family = isset($element_data['font_family']) ? $element_data['font_family'] : '';

    $custom_css = isset($element_data['custom_css']) ? $element_data['custom_css'] : '';
    $custom_css_hover = isset($element_data['custom_css_hover']) ? $element_data['custom_css_hover'] : '';



    ?>
    <div class="item">
        <div class="element-title header ">
            <span class="remove" onclick="jQuery(this).parent().parent().remove()"><i class="fas fa-times"></i></span>
            <span class="sort"><i class="fas fa-sort"></i></span>

            <span class="expand"><?php echo __('Title','breadcrumb'); ?></span>
        </div>
        <div class="element-options options">

            <?php

            $args = array(
                'id'		=> 'color',
                'css_id'		=> $element_index.'_title_color',
                'parent' => $input_name.'[title]',
                'title'		=> __('Color','breadcrumb'),
                'details'	=> __('Title text color.','breadcrumb'),
                'type'		=> 'colorpicker',
                'value'		=> $color,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'font_size',
                'css_id'		=> $element_index.'_font_size',
                'parent' => $input_name.'[title]',
                'title'		=> __('Font size','breadcrumb'),
                'details'	=> __('Set font size.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $font_size,
                'default'		=> '',
                'placeholder'		=> '14px',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'font_family',
                'css_id'		=> $element_index.'_font_family',
                'parent' => $input_name.'[title]',
                'title'		=> __('Font family','breadcrumb'),
                'details'	=> __('Set font family.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $font_family,
                'default'		=> '',
                'placeholder'		=> 'Open Sans',
            );

            $settings_tabs_field->generate_field($args);
//
//            $args = array(
//                'id'		=> 'custom_css',
//                'css_id'		=> $element_index.'_custom_css',
//                'parent' => $input_name.'[title]',
//                'title'		=> __('Custom CSS','breadcrumb'),
//                'details'	=> __('Write custom CSS, do not use <code>&lt;style>&lt;/style></code> tag','breadcrumb'),
//                'type'		=> 'scripts_css',
//                'value'		=> $custom_css,
//                'default'		=> '',
//                'placeholder'		=> '',
//            );
//
//            $settings_tabs_field->generate_field($args);
//
//
//            $args = array(
//                'id'		=> 'custom_css_hover',
//                'css_id'		=> $element_index.'_custom_css_hover',
//                'parent' => $input_name.'[title]',
//                'title'		=> __('Custom hover CSS','breadcrumb'),
//                'details'	=> __('Write custom hover CSS, do not use <code>&lt;style>&lt;/style></code> tag','breadcrumb'),
//                'type'		=> 'scripts_css',
//                'value'		=> $custom_css_hover,
//                'default'		=> '',
//                'placeholder'		=> '',
//            );
//
//            $settings_tabs_field->generate_field($args);

            ?>

        </div>
    </div>
    <?php

}




add_action('layout_elements_option_thumbnail','layout_elements_option_thumbnail');


function layout_elements_option_thumbnail($parameters){

    $settings_tabs_field = new settings_tabs_field();

    $input_name = isset($parameters['input_name']) ? $parameters['input_name'] : '{input_name}';
    $element_data = isset($parameters['element_data']) ? $parameters['element_data'] : array();
    $element_index = isset($parameters['index']) ? $parameters['index'] : '';

    $thumb_size = isset($element_data['thumb_size']) ? $element_data['thumb_size'] : '';
    $thumb_height = isset($element_data['thumb_height']) ? $element_data['thumb_height'] : '';

    $thumb_height_large = isset($thumb_height['large']) ? $thumb_height['large'] : '';
    $thumb_height_medium = isset($thumb_height['medium']) ? $thumb_height['medium'] : '';
    $thumb_height_small = isset($thumb_height['small']) ? $thumb_height['small'] : '';


    ?>
    <div class="item">
        <div class="element-title header ">
            <span class="remove" onclick="jQuery(this).parent().parent().remove()"><i class="fas fa-times"></i></span>
            <span class="sort"><i class="fas fa-sort"></i></span>

            <span class="expand"><?php echo __('Thumbnail','breadcrumb'); ?></span>
        </div>
        <div class="element-options options">

            <?php

            $thumbnail_sizes = array();

            $get_intermediate_image_sizes =  get_intermediate_image_sizes();
            foreach($get_intermediate_image_sizes as $size_key){
                $size_name = str_replace('_', ' ',$size_key);
                $size_name = str_replace('-', ' ',$size_name);

                $thumbnail_sizes[$size_key] = ucfirst($size_name);
            }
            //echo '<pre>'.var_export($thumbnail_sizes, true).'</pre>';

            $args = array(
                'id'		=> 'thumb_size',
                'parent' => $input_name.'[thumbnail]',
                'title'		=> __('Thumbnail size','breadcrumb'),
                'details'	=> __('Choose thumbnail size.','breadcrumb'),
                'type'		=> 'select',
                'value'		=> $thumb_size,
                'default'		=> 'large',
                'args'		=> $thumbnail_sizes,
            );

            $settings_tabs_field->generate_field($args);





            $args = array(
                'id'		=> 'thumb_height',
                'title'		=> __('Thumbnail height','related-post'),
                'details'	=> __('Set thumbnail height.','related-post'),
                'type'		=> 'option_group',
                'options'		=> array(
                    array(
                        'id'		=> 'large',
                        'parent'		=> $input_name.'[thumbnail][thumb_height]',
                        'title'		=> __('In desktop','related-post'),
                        'details'	=> __('min-width: 1200px, ex: 45% or 280px','related-post'),
                        'type'		=> 'text',
                        'value'		=> $thumb_height_large,
                        'default'		=> '',
                        'placeholder'   => '45%',
                    ),
                    array(
                        'id'		=> 'medium',
                        'parent'		=> $input_name.'[thumbnail][thumb_height]',
                        'title'		=> __('In tablet & small desktop','related-post'),
                        'details'	=> __('min-width: 992px, ex: 90% or 280px','related-post'),
                        'type'		=> 'text',
                        'value'		=> $thumb_height_medium,
                        'default'		=> '',
                        'placeholder'   => '90%',
                    ),
                    array(
                        'id'		=> 'small',
                        'parent'		=> $input_name.'[thumbnail][thumb_height]',
                        'title'		=> __('In mobile','related-post'),
                        'details'	=> __('max-width: 768px, ex: 90% or 280px','related-post'),
                        'type'		=> 'text',
                        'value'		=> $thumb_height_small,
                        'default'		=> '',
                        'placeholder'   => '90%',
                    ),
                ),

            );

            $settings_tabs_field->generate_field($args);







            ?>

        </div>
    </div>
    <?php

}




add_action('layout_elements_option_content','layout_elements_option_content');


function layout_elements_option_content($parameters){

    $settings_tabs_field = new settings_tabs_field();

    $input_name = isset($parameters['input_name']) ? $parameters['input_name'] : '{input_name}';
    $element_data = isset($parameters['element_data']) ? $parameters['element_data'] : array();
    $element_index = isset($parameters['index']) ? $parameters['index'] : '';

    $content_source = isset($element_data['content_source']) ? $element_data['content_source'] : '';
    $word_count = isset($element_data['word_count']) ? $element_data['word_count'] : '';
    $read_more_text = isset($element_data['read_more_text']) ? $element_data['read_more_text'] : '';

    $color = isset($element_data['color']) ? $element_data['color'] : '';
    $font_size = isset($element_data['font_size']) ? $element_data['font_size'] : '';
    $font_family = isset($element_data['font_family']) ? $element_data['font_family'] : '';

    $custom_css = isset($element_data['custom_css']) ? $element_data['custom_css'] : '';
    $custom_css_hover = isset($element_data['custom_css_hover']) ? $element_data['custom_css_hover'] : '';

    ?>
    <div class="item">
        <div class="element-title header ">
            <span class="remove" onclick="jQuery(this).parent().parent().remove()"><i class="fas fa-times"></i></span>
            <span class="sort"><i class="fas fa-sort"></i></span>

            <span class="expand"><?php echo __('Content','breadcrumb'); ?></span>
        </div>
        <div class="element-options options">

            <?php

            $args = array(
                'id'		=> 'content_source',
                'css_id'		=> $element_index.'_content_source',
                'parent' => $input_name.'[content]',
                'title'		=> __('Content source','breadcrumb'),
                'details'	=> __('Choose content source.','breadcrumb'),
                'type'		=> 'select',
                'value'		=> $content_source,
                'default'		=> 'excerpt',
                'args'		=> array('excerpt'=> __('Excerpt', 'team'), 'content'=> __('Content', 'team')),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'word_count',
                'css_id'		=> $element_index.'_word_count',
                'parent' => $input_name.'[content]',
                'title'		=> __('Word count','breadcrumb'),
                'details'	=> __('Set word count.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $word_count,
                'default'		=> '',
                'placeholder'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'read_more_text',
                'css_id'		=> $element_index.'_read_more_text',
                'parent' => $input_name.'[content]',
                'title'		=> __('Read more text','breadcrumb'),
                'details'	=> __('Set custom read more text.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $read_more_text,
                'default'		=> '',
                'placeholder'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'color',
                'css_id'		=> $element_index.'_content_color',
                'parent' => $input_name.'[content]',
                'title'		=> __('Color','breadcrumb'),
                'details'	=> __('Title text color.','breadcrumb'),
                'type'		=> 'colorpicker',
                'value'		=> $color,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'font_size',
                'css_id'		=> $element_index.'_font_size',
                'parent' => $input_name.'[content]',
                'title'		=> __('Font size','breadcrumb'),
                'details'	=> __('Set font size.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $font_size,
                'default'		=> '',
                'placeholder'		=> '14px',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'font_family',
                'css_id'		=> $element_index.'_font_family',
                'parent' => $input_name.'[content]',
                'title'		=> __('Font family','breadcrumb'),
                'details'	=> __('Set font family.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $font_family,
                'default'		=> '',
                'placeholder'		=> 'Open Sans',
            );

            $settings_tabs_field->generate_field($args);


            ?>

        </div>
    </div>
    <?php

}




add_action('layout_elements_option_social','layout_elements_option_social');


function layout_elements_option_social($parameters){

    $settings_tabs_field = new settings_tabs_field();

    $input_name = isset($parameters['input_name']) ? $parameters['input_name'] : '{input_name}';
    $element_data = isset($parameters['element_data']) ? $parameters['element_data'] : array();
    $element_index = isset($parameters['index']) ? $parameters['index'] : '';

    $social_icon_type = isset($element_data['social_icon_type']) ? $element_data['social_icon_type'] : '';
    $social_icon_width = isset($element_data['social_icon_width']) ? $element_data['social_icon_width'] : '';
    $social_icon_height = isset($element_data['social_icon_height']) ? $element_data['social_icon_height'] : '';


    $color = isset($element_data['color']) ? $element_data['color'] : '';
    $font_size = isset($element_data['font_size']) ? $element_data['font_size'] : '';
    $font_family = isset($element_data['font_family']) ? $element_data['font_family'] : '';

    ?>
    <div class="item">
        <div class="element-title header ">
            <span class="remove" onclick="jQuery(this).parent().parent().remove()"><i class="fas fa-times"></i></span>
            <span class="sort"><i class="fas fa-sort"></i></span>

            <span class="expand"><?php echo __('Social','breadcrumb'); ?></span>
        </div>
        <div class="element-options options">

            <?php


            $args = array(
                'id'		=> 'social_icon_type',
                'css_id'		=> $element_index.'_content_source',
                'parent' => $input_name.'[social]',
                'title'		=> __('Social icon type','breadcrumb'),
                'details'	=> __('Choose icon type.','breadcrumb'),
                'type'		=> 'select',
                'value'		=> $social_icon_type,
                'default'		=> 'image_icon',
                'args'		=> array('image_icon'=> __('Image icon', 'team'), 'text_link'=> __('Text link', 'team')),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'social_icon_width',
                'css_id'		=> $element_index.'_social_icon_width',
                'parent' => $input_name.'[social]',
                'title'		=> __('Icon width','breadcrumb'),
                'details'	=> __('Set icon width.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $social_icon_width,
                'default'		=> '',
                'placeholder'		=> '20px',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'social_icon_height',
                'css_id'		=> $element_index.'_social_icon_height',
                'parent' => $input_name.'[social]',
                'title'		=> __('Icon height','breadcrumb'),
                'details'	=> __('Set icon height.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $social_icon_height,
                'default'		=> '',
                'placeholder'		=> '20px',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'color',
                'css_id'		=> $element_index.'_social_color',
                'parent' => $input_name.'[social]',
                'title'		=> __('Color','breadcrumb'),
                'details'	=> __('Title text color.','breadcrumb'),
                'type'		=> 'colorpicker',
                'value'		=> $color,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'font_size',
                'css_id'		=> $element_index.'_font_size',
                'parent' => $input_name.'[social]',
                'title'		=> __('Font size','breadcrumb'),
                'details'	=> __('Set font size.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $font_size,
                'default'		=> '',
                'placeholder'		=> '14px',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'font_family',
                'css_id'		=> $element_index.'_font_family',
                'parent' => $input_name.'[social]',
                'title'		=> __('Font family','breadcrumb'),
                'details'	=> __('Set font family.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $font_family,
                'default'		=> '',
                'placeholder'		=> 'Open Sans',
            );

            $settings_tabs_field->generate_field($args);


            ?>

        </div>
    </div>
    <?php

}



add_action('layout_elements_option_meta','layout_elements_option_meta');


function layout_elements_option_meta($parameters){

    $settings_tabs_field = new settings_tabs_field();

    $input_name = isset($parameters['input_name']) ? $parameters['input_name'] : '{input_name}';
    $element_data = isset($parameters['element_data']) ? $parameters['element_data'] : array();
    $element_index = isset($parameters['index']) ? $parameters['index'] : '';

    $meta_key = isset($element_data['meta_key']) ? $element_data['meta_key'] : '';
    $color = isset($element_data['color']) ? $element_data['color'] : '';
    $font_size = isset($element_data['font_size']) ? $element_data['font_size'] : '';
    $font_family = isset($element_data['font_family']) ? $element_data['font_family'] : '';

    $custom_css = isset($element_data['custom_css']) ? $element_data['custom_css'] : '';
    $custom_css_hover = isset($element_data['custom_css_hover']) ? $element_data['custom_css_hover'] : '';

    ?>
    <div class="item">
        <div class="element-title header ">
            <span class="remove" onclick="jQuery(this).parent().parent().remove()"><i class="fas fa-times"></i></span>
            <span class="sort"><i class="fas fa-sort"></i></span>

            <span class="expand"><?php echo __('Meta','breadcrumb'); ?></span>
        </div>
        <div class="element-options options">

            <?php

            $args = array(
                'id'		=> 'meta_key',
                'css_id'		=> $element_index.'_meta_key',
                'parent' => $input_name.'[meta]',
                'title'		=> __('Meta key','breadcrumb'),
                'details'	=> __('Write meta key.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $meta_key,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'color',
                'css_id'		=> $element_index.'_skill_color',
                'parent' => $input_name.'[meta]',
                'title'		=> __('Color','breadcrumb'),
                'details'	=> __('Title text color.','breadcrumb'),
                'type'		=> 'colorpicker',
                'value'		=> $color,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'font_size',
                'css_id'		=> $element_index.'_font_size',
                'parent' => $input_name.'[meta]',
                'title'		=> __('Font size','breadcrumb'),
                'details'	=> __('Set font size.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $font_size,
                'default'		=> '',
                'placeholder'		=> '14px',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'font_family',
                'css_id'		=> $element_index.'_font_family',
                'parent' => $input_name.'[meta]',
                'title'		=> __('Font family','breadcrumb'),
                'details'	=> __('Set font family.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $font_family,
                'default'		=> '',
                'placeholder'		=> 'Open Sans',
            );

            $settings_tabs_field->generate_field($args);


            ?>

        </div>
    </div>
    <?php

}




add_action('layout_elements_option_skill','layout_elements_option_skill');


function layout_elements_option_skill($parameters){

    $settings_tabs_field = new settings_tabs_field();

    $input_name = isset($parameters['input_name']) ? $parameters['input_name'] : '{input_name}';
    $element_data = isset($parameters['element_data']) ? $parameters['element_data'] : array();
    $element_index = isset($parameters['index']) ? $parameters['index'] : '';

    $color = isset($element_data['color']) ? $element_data['color'] : '';
    $font_size = isset($element_data['font_size']) ? $element_data['font_size'] : '';
    $font_family = isset($element_data['font_family']) ? $element_data['font_family'] : '';

    ?>
    <div class="item">
        <div class="element-title header ">
            <span class="remove" onclick="jQuery(this).parent().parent().remove()"><i class="fas fa-times"></i></span>
            <span class="sort"><i class="fas fa-sort"></i></span>

            <span class="expand"><?php echo __('Skill','breadcrumb'); ?></span>
        </div>
        <div class="element-options options">

            <?php

            $args = array(
                'id'		=> 'color',
                'css_id'		=> $element_index.'_skill_color',
                'parent' => $input_name.'[skill]',
                'title'		=> __('Color','breadcrumb'),
                'details'	=> __('Title text color.','breadcrumb'),
                'type'		=> 'colorpicker',
                'value'		=> $color,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'font_size',
                'css_id'		=> $element_index.'_font_size',
                'parent' => $input_name.'[skill]',
                'title'		=> __('Font size','breadcrumb'),
                'details'	=> __('Set font size.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $font_size,
                'default'		=> '',
                'placeholder'		=> '14px',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'font_family',
                'css_id'		=> $element_index.'_font_family',
                'parent' => $input_name.'[skill]',
                'title'		=> __('Font family','breadcrumb'),
                'details'	=> __('Set font family.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $font_family,
                'default'		=> '',
                'placeholder'		=> 'Open Sans',
            );

            $settings_tabs_field->generate_field($args);


            ?>

        </div>
    </div>
    <?php

}




add_action('layout_elements_option_position','layout_elements_option_position');


function layout_elements_option_position($parameters){

    $settings_tabs_field = new settings_tabs_field();

    $input_name = isset($parameters['input_name']) ? $parameters['input_name'] : '{input_name}';
    $element_data = isset($parameters['element_data']) ? $parameters['element_data'] : array();
    $element_index = isset($parameters['index']) ? $parameters['index'] : '';

    $color = isset($element_data['color']) ? $element_data['color'] : '';
    $font_size = isset($element_data['font_size']) ? $element_data['font_size'] : '';
    $font_family = isset($element_data['font_family']) ? $element_data['font_family'] : '';

    $custom_css = isset($element_data['custom_css']) ? $element_data['custom_css'] : '';
    $custom_css_hover = isset($element_data['custom_css_hover']) ? $element_data['custom_css_hover'] : '';

    ?>
    <div class="item">
        <div class="element-title header ">
            <span class="remove" onclick="jQuery(this).parent().parent().remove()"><i class="fas fa-times"></i></span>
            <span class="sort"><i class="fas fa-sort"></i></span>

            <span class="expand"><?php echo __('Position','breadcrumb'); ?></span>
        </div>
        <div class="element-options options">

            <?php
            $args = array(
                'id'		=> 'color',
                'css_id'		=> $element_index.'_position_color',
                'parent' => $input_name.'[position]',
                'title'		=> __('Color','breadcrumb'),
                'details'	=> __('Title text color.','breadcrumb'),
                'type'		=> 'colorpicker',
                'value'		=> $color,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'font_size',
                'css_id'		=> $element_index.'_font_size',
                'parent' => $input_name.'[position]',
                'title'		=> __('Font size','breadcrumb'),
                'details'	=> __('Set font size.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $font_size,
                'default'		=> '',
                'placeholder'		=> '14px',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'font_family',
                'css_id'		=> $element_index.'_font_family',
                'parent' => $input_name.'[position]',
                'title'		=> __('Font family','breadcrumb'),
                'details'	=> __('Set font family.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $font_family,
                'default'		=> '',
                'placeholder'		=> 'Open Sans',
            );

            $settings_tabs_field->generate_field($args);


            ?>

        </div>
    </div>
    <?php

}






add_action('layout_elements_option_popup','layout_elements_option_popup');


function layout_elements_option_popup($parameters){

    $settings_tabs_field = new settings_tabs_field();

    $input_name = isset($parameters['input_name']) ? $parameters['input_name'] : '{input_name}';
    $element_data = isset($parameters['element_data']) ? $parameters['element_data'] : array();

    $meta_key = isset($element_data['meta_key']) ? $element_data['meta_key'] : '';
    $font_size = isset($element_data['font_size']) ? $element_data['font_size'] : '';
    $font_family = isset($element_data['font_family']) ? $element_data['font_family'] : '';

    ?>
    <div class="item">
        <div class="element-title header ">
            <span class="remove" onclick="jQuery(this).parent().parent().remove()"><i class="fas fa-times"></i></span>
            <span class="sort"><i class="fas fa-sort"></i></span>

            <span class="expand"><?php echo __('Popup','breadcrumb'); ?></span>
        </div>
        <div class="element-options options">

            <?php

            $args = array(
                'id'		=> 'meta_key',
                'parent' => $input_name.'[popup]',
                'title'		=> __('Meta key','breadcrumb'),
                'details'	=> __('Write meta key.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $meta_key,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            ?>

        </div>
    </div>
    <?php

}






add_action('layout_elements_option_wrapper_start','layout_elements_option_wrapper_start');


function layout_elements_option_wrapper_start($parameters){

    $settings_tabs_field = new settings_tabs_field();

    $input_name = isset($parameters['input_name']) ? $parameters['input_name'] : '{input_name}';
    $element_data = isset($parameters['element_data']) ? $parameters['element_data'] : array();

    $wrapper_id = isset($element_data['wrapper_id']) ? $element_data['wrapper_id'] : '';
    $wrapper_class = isset($element_data['wrapper_class']) ? $element_data['wrapper_class'] : '';
    $css_idle = isset($element_data['css_idle']) ? $element_data['css_idle'] : '';

    ?>
    <div class="item">
        <div class="element-title header ">
            <span class="remove" onclick="jQuery(this).parent().parent().remove()"><i class="fas fa-times"></i></span>
            <span class="sort"><i class="fas fa-sort"></i></span>

            <span class="expand"><?php echo __('Wrapper start','breadcrumb'); ?></span>

            <span class="handle-start"><i class="fas fa-level-up-alt"></i></span>

        </div>
        <div class="element-options options">

            <?php

            $args = array(
                'id'		=> 'wrapper_id',
                'parent' => $input_name.'[wrapper_start]',
                'title'		=> __('Wrapper id','breadcrumb'),
                'details'	=> __('Write wrapper id, ex: my-unique-id.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $wrapper_id,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'wrapper_class',
                'parent' => $input_name.'[wrapper_start]',
                'title'		=> __('Wrapper class','breadcrumb'),
                'details'	=> __('Write wrapper class, ex: layer-thumbnail','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $wrapper_class,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'css_idle',
                'css_id'		=> 'css_idle_'.preg_replace('/\D/', '', $input_name) ,
                'parent' => $input_name.'[wrapper_start]',
                'title'		=> __('Custom CSS','breadcrumb'),
                'details'	=> __('Write custom CSS. do not use <code>&lt;style>&lt;/style></code>','breadcrumb'),
                'type'		=> 'scripts_css',
                'value'		=> $css_idle,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            ?>

        </div>
    </div>
    <?php

}




add_action('layout_elements_option_wrapper_end','layout_elements_option_wrapper_end');


function layout_elements_option_wrapper_end($parameters){

    $settings_tabs_field = new settings_tabs_field();

    $input_name = isset($parameters['input_name']) ? $parameters['input_name'] : '{input_name}';
    $element_data = isset($parameters['element_data']) ? $parameters['element_data'] : array();

    $meta_key = isset($element_data['meta_key']) ? $element_data['meta_key'] : '';
    $font_size = isset($element_data['font_size']) ? $element_data['font_size'] : '';
    $font_family = isset($element_data['font_family']) ? $element_data['font_family'] : '';

    ?>
    <div class="item">
        <div class="element-title header ">
            <span class="remove" onclick="jQuery(this).parent().parent().remove()"><i class="fas fa-times"></i></span>
            <span class="sort"><i class="fas fa-sort"></i></span>

            <span class="expand"><?php echo __('Wrapper end','breadcrumb'); ?></span>
            <span class="handle-end"><i class="fas fa-level-down-alt"></i></span>
        </div>
        <div class="element-options options">

            <?php

            $args = array(
                'id'		=> 'wrapper_id',
                'parent' => $input_name.'[wrapper_end]',
                'title'		=> __('Wrapper id','breadcrumb'),
                'details'	=> __('Write wrapper id, ex: div, p, span.','breadcrumb'),
                'type'		=> 'text',
                'value'		=> $meta_key,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);





            ?>

        </div>
    </div>
    <?php

}








