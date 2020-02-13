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

            <span class="expand"><?php echo __('Title','team'); ?></span>
        </div>
        <div class="element-options options">

            <?php

            $args = array(
                'id'		=> 'color',
                'css_id'		=> $element_index.'_title_color',
                'parent' => $input_name.'[title]',
                'title'		=> __('Color','team'),
                'details'	=> __('Title text color.','team'),
                'type'		=> 'colorpicker',
                'value'		=> $color,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'font_size',
                'css_id'		=> $element_index.'_font_size',
                'parent' => $input_name.'[title]',
                'title'		=> __('Font size','team'),
                'details'	=> __('Set font size.','team'),
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
                'title'		=> __('Font family','team'),
                'details'	=> __('Set font family.','team'),
                'type'		=> 'text',
                'value'		=> $font_family,
                'default'		=> '',
                'placeholder'		=> 'Open Sans',
            );

            $settings_tabs_field->generate_field($args);


            ob_start();
            ?>
            <textarea readonly type="text"  onclick="this.select();">.element-<?php echo $element_index?>{}</textarea>
            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'use_css',
                'title'		=> __('Use of CSS','team'),
                'details'	=> __('Use following class selector to add custom CSS for this element.','team'),
                'type'		=> 'custom_html',
                'html'		=> $html,

            );

            $settings_tabs_field->generate_field($args);

            //
            //            $args = array(
            //                'id'		=> 'custom_css',
            //                'css_id'		=> $element_index.'_custom_css',
            //                'parent' => $input_name.'[title]',
            //                'title'		=> __('Custom CSS','team'),
            //                'details'	=> __('Write custom CSS, do not use <code>&lt;style>&lt;/style></code> tag','team'),
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
            //                'title'		=> __('Custom hover CSS','team'),
            //                'details'	=> __('Write custom hover CSS, do not use <code>&lt;style>&lt;/style></code> tag','team'),
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

            <span class="expand"><?php echo __('Thumbnail','team'); ?></span>
        </div>
        <div class="element-options options">

            <?php

            $thumbnail_sizes = array();

            $get_intermediate_image_sizes =  get_intermediate_image_sizes();

            if(!empty($get_intermediate_image_sizes))
            foreach($get_intermediate_image_sizes as $size_key){
                $size_name = str_replace('_', ' ',$size_key);
                $size_name = str_replace('-', ' ',$size_name);

                $thumbnail_sizes[$size_key] = ucfirst($size_name);
            }
            //echo '<pre>'.var_export($thumbnail_sizes, true).'</pre>';

            $args = array(
                'id'		=> 'thumb_size',
                'parent' => $input_name.'[thumbnail]',
                'title'		=> __('Thumbnail size','team'),
                'details'	=> __('Choose thumbnail size.','team'),
                'type'		=> 'select',
                'value'		=> $thumb_size,
                'default'		=> 'large',
                'args'		=> $thumbnail_sizes,
            );

            $settings_tabs_field->generate_field($args);





            $args = array(
                'id'		=> 'thumb_height',
                'title'		=> __('Thumbnail height','team'),
                'details'	=> __('Set thumbnail height.','team'),
                'type'		=> 'option_group',
                'options'		=> array(
                    array(
                        'id'		=> 'large',
                        'parent'		=> $input_name.'[thumbnail][thumb_height]',
                        'title'		=> __('In desktop','team'),
                        'details'	=> __('min-width: 1200px, ex: 280px','team'),
                        'type'		=> 'text',
                        'value'		=> $thumb_height_large,
                        'default'		=> '',
                        'placeholder'   => '280px',
                    ),
                    array(
                        'id'		=> 'medium',
                        'parent'		=> $input_name.'[thumbnail][thumb_height]',
                        'title'		=> __('In tablet & small desktop','team'),
                        'details'	=> __('min-width: 992px, ex: 280px','team'),
                        'type'		=> 'text',
                        'value'		=> $thumb_height_medium,
                        'default'		=> '',
                        'placeholder'   => '280px',
                    ),
                    array(
                        'id'		=> 'small',
                        'parent'		=> $input_name.'[thumbnail][thumb_height]',
                        'title'		=> __('In mobile','team'),
                        'details'	=> __('max-width: 768px, ex: 280px','team'),
                        'type'		=> 'text',
                        'value'		=> $thumb_height_small,
                        'default'		=> '',
                        'placeholder'   => '280px',
                    ),
                ),

            );

            $settings_tabs_field->generate_field($args);



            ob_start();
            ?>
            <code onclick="this.select()">
                .element-<?php echo $element_index?>{}

            </code>
            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'use_css',
                'title'		=> __('Use of CSS','team'),
                'details'	=> __('Use following class selector to add custom CSS for this element.','team'),
                'type'		=> 'custom_html',
                'html'		=> $html,

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
    $read_more_color = isset($element_data['read_more_color']) ? $element_data['read_more_color'] : '';

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

            <span class="expand"><?php echo __('Content','team'); ?></span>
        </div>
        <div class="element-options options">

            <?php

            $args = array(
                'id'		=> 'content_source',
                'css_id'		=> $element_index.'_content_source',
                'parent' => $input_name.'[content]',
                'title'		=> __('Content source','team'),
                'details'	=> __('Choose content source.','team'),
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
                'title'		=> __('Word count','team'),
                'details'	=> __('Set word count.','team'),
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
                'title'		=> __('Read more text','team'),
                'details'	=> __('Set custom read more text.','team'),
                'type'		=> 'text',
                'value'		=> $read_more_text,
                'default'		=> '',
                'placeholder'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'read_more_color',
                'css_id'		=> $element_index.'_read_more_color',
                'parent' => $input_name.'[content]',
                'title'		=> __('Read more color','team'),
                'details'	=> __('Set custom read more color.','team'),
                'type'		=> 'colorpicker',
                'value'		=> $read_more_color,
                'default'		=> '',
                'placeholder'		=> '',
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'color',
                'css_id'		=> $element_index.'_content_color',
                'parent' => $input_name.'[content]',
                'title'		=> __('Color','team'),
                'details'	=> __('Title text color.','team'),
                'type'		=> 'colorpicker',
                'value'		=> $color,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'font_size',
                'css_id'		=> $element_index.'_font_size',
                'parent' => $input_name.'[content]',
                'title'		=> __('Font size','team'),
                'details'	=> __('Set font size.','team'),
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
                'title'		=> __('Font family','team'),
                'details'	=> __('Set font family.','team'),
                'type'		=> 'text',
                'value'		=> $font_family,
                'default'		=> '',
                'placeholder'		=> 'Open Sans',
            );

            $settings_tabs_field->generate_field($args);


            ob_start();
            ?>
            <code onclick="this.select()">
                .element-<?php echo $element_index?>{}

            </code>
            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'use_css',
                'title'		=> __('Use of CSS','team'),
                'details'	=> __('Use following class selector to add custom CSS for this element.','team'),
                'type'		=> 'custom_html',
                'html'		=> $html,

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

            <span class="expand"><?php echo __('Social','team'); ?></span>
        </div>
        <div class="element-options options">

            <?php


            $args = array(
                'id'		=> 'social_icon_type',
                'css_id'		=> $element_index.'_content_source',
                'parent' => $input_name.'[social]',
                'title'		=> __('Social icon type','team'),
                'details'	=> __('Choose icon type.','team'),
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
                'title'		=> __('Icon width','team'),
                'details'	=> __('Set icon width.','team'),
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
                'title'		=> __('Icon height','team'),
                'details'	=> __('Set icon height.','team'),
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
                'title'		=> __('Color','team'),
                'details'	=> __('Title text color.','team'),
                'type'		=> 'colorpicker',
                'value'		=> $color,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'font_size',
                'css_id'		=> $element_index.'_font_size',
                'parent' => $input_name.'[social]',
                'title'		=> __('Font size','team'),
                'details'	=> __('Set font size.','team'),
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
                'title'		=> __('Font family','team'),
                'details'	=> __('Set font family.','team'),
                'type'		=> 'text',
                'value'		=> $font_family,
                'default'		=> '',
                'placeholder'		=> 'Open Sans',
            );

            $settings_tabs_field->generate_field($args);


            ob_start();
            ?>
            <code onclick="this.select()">
                .element-<?php echo $element_index?>{}

            </code>
            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'use_css',
                'title'		=> __('Use of CSS','team'),
                'details'	=> __('Use following class selector to add custom CSS for this element.','team'),
                'type'		=> 'custom_html',
                'html'		=> $html,

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

            <span class="expand"><?php echo __('Meta','team'); ?></span>
        </div>
        <div class="element-options options">

            <?php

            $args = array(
                'id'		=> 'meta_key',
                'css_id'		=> $element_index.'_meta_key',
                'parent' => $input_name.'[meta]',
                'title'		=> __('Meta key','team'),
                'details'	=> __('Write meta key.','team'),
                'type'		=> 'text',
                'value'		=> $meta_key,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'color',
                'css_id'		=> $element_index.'_skill_color',
                'parent' => $input_name.'[meta]',
                'title'		=> __('Color','team'),
                'details'	=> __('Title text color.','team'),
                'type'		=> 'colorpicker',
                'value'		=> $color,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'font_size',
                'css_id'		=> $element_index.'_font_size',
                'parent' => $input_name.'[meta]',
                'title'		=> __('Font size','team'),
                'details'	=> __('Set font size.','team'),
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
                'title'		=> __('Font family','team'),
                'details'	=> __('Set font family.','team'),
                'type'		=> 'text',
                'value'		=> $font_family,
                'default'		=> '',
                'placeholder'		=> 'Open Sans',
            );

            $settings_tabs_field->generate_field($args);


            ob_start();
            ?>
            <code onclick="this.select()">
                .element-<?php echo $element_index?>{}

            </code>
            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'use_css',
                'title'		=> __('Use of CSS','team'),
                'details'	=> __('Use following class selector to add custom CSS for this element.','team'),
                'type'		=> 'custom_html',
                'html'		=> $html,

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

            <span class="expand"><?php echo __('Position','team'); ?></span>
        </div>
        <div class="element-options options">

            <?php
            $args = array(
                'id'		=> 'color',
                'css_id'		=> $element_index.'_position_color',
                'parent' => $input_name.'[position]',
                'title'		=> __('Color','team'),
                'details'	=> __('Title text color.','team'),
                'type'		=> 'colorpicker',
                'value'		=> $color,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'font_size',
                'css_id'		=> $element_index.'_font_size',
                'parent' => $input_name.'[position]',
                'title'		=> __('Font size','team'),
                'details'	=> __('Set font size.','team'),
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
                'title'		=> __('Font family','team'),
                'details'	=> __('Set font family.','team'),
                'type'		=> 'text',
                'value'		=> $font_family,
                'default'		=> '',
                'placeholder'		=> 'Open Sans',
            );

            $settings_tabs_field->generate_field($args);


            ob_start();
            ?>
            <code onclick="this.select()">
                .element-<?php echo $element_index?>{}

            </code>
            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'use_css',
                'title'		=> __('Use of CSS','team'),
                'details'	=> __('Use following class selector to add custom CSS for this element.','team'),
                'type'		=> 'custom_html',
                'html'		=> $html,

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
    $element_index = isset($parameters['index']) ? $parameters['index'] : '';

    $wrapper_id = isset($element_data['wrapper_id']) ? $element_data['wrapper_id'] : '';
    $wrapper_class = isset($element_data['wrapper_class']) ? $element_data['wrapper_class'] : '';
    $css_idle = isset($element_data['css_idle']) ? $element_data['css_idle'] : '';

    ?>
    <div class="item">
        <div class="element-title header ">
            <span class="remove" onclick="jQuery(this).parent().parent().remove()"><i class="fas fa-times"></i></span>
            <span class="sort"><i class="fas fa-sort"></i></span>

            <span class="expand"><?php echo __('Wrapper start','team'); ?></span>

            <span class="handle-start"><i class="fas fa-level-up-alt"></i></span>

        </div>
        <div class="element-options options">

            <?php

            $args = array(
                'id'		=> 'wrapper_id',
                'parent' => $input_name.'[wrapper_start]',
                'title'		=> __('Wrapper id','team'),
                'details'	=> __('Write wrapper id, ex: my-unique-id.','team'),
                'type'		=> 'text',
                'value'		=> $wrapper_id,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'wrapper_class',
                'parent' => $input_name.'[wrapper_start]',
                'title'		=> __('Wrapper class','team'),
                'details'	=> __('Write wrapper class, ex: layer-thumbnail','team'),
                'type'		=> 'text',
                'value'		=> $wrapper_class,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'css_idle',
                'css_id'		=> 'css_idle_'.preg_replace('/\D/', '', $input_name) ,
                'parent' => $input_name.'[wrapper_start]',
                'title'		=> __('Custom CSS','team'),
                'details'	=> __('Write custom CSS. do not use <code>&lt;style>&lt;/style></code>','team'),
                'type'		=> 'scripts_css',
                'value'		=> $css_idle,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            ob_start();
            ?>
            <code onclick="this.select()">
                .element-<?php echo $element_index?>{}

            </code>
            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'use_css',
                'title'		=> __('Use of CSS','breadcrumb'),
                'details'	=> __('Use following class selector to add custom CSS for this element.','breadcrumb'),
                'type'		=> 'custom_html',
                'html'		=> $html,

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







