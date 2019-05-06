<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 












add_action('testimonial_template_meta_tabs_content_templates', 'testimonial_template_meta_tabs_content_templates',10, 2);

if(!function_exists('testimonial_template_meta_tabs_content_templates')) {
    function testimonial_template_meta_tabs_content_templates($tab, $post_id){

        $class_team_functions = new class_team_functions();
        $settings_tabs_field = new settings_tabs_field();
        //$layout_templates = $class_team_functions->layout_templates();
        $layout_items = $class_team_functions->layout_items();




        $team_template_options = get_post_meta( $post_id, 'team_template_options', true );
        $template_layout_items = isset($team_template_options['layout_items']) ? $team_template_options['layout_items'] : array();
        $layout_items_sort = isset($team_template_options['layout_items_sort']) ? $team_template_options['layout_items_sort'] : array();
        $template = isset($team_template_options['template']) ? $team_template_options['template'] : 'templateA';

        //$template_layout_items = isset($layout_templates[$template]) ? $layout_templates[$template] : $template_layout_items;

        //$layout_items_sort = !empty($layout_items_sort) ? $layout_templates[$template] : $layout_items_sort;

        $template_html = isset($team_template_options['template_html']) ? $team_template_options['template_html'] : '';
        $template_css = isset($team_template_options['template_css']) ? $team_template_options['template_css'] : '';


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




                        ?>
                        <div class="item">
                            <div class="header">
<!--                                <span class="move"><i class="fa fa-bars"></i></span>-->
                                <span class="expand"><i class="fa fa-expand"></i><i class="fa fa-compress"></i></span>
                                <span class="name"><?php echo $title; ?>(<?php echo $layout_item_key; ?> dfsdf) </span>
                                <input type="hidden" name="team_template_options[layout_items_sort][<?php echo $layout_item_key; ?>]" value="">

                            </div>
                            <div class="options">

                                <?php

                                if(!empty($element_settings)):
                                    foreach ($element_settings as $option){

                                        $option['css_id'] = $layout_item_key.'-'.$option['id'];
                                        $option['parent'] = 'team_template_options[layout_items]['.$layout_item_key.'][settings]';
                                        $option['value'] = isset($template_layout_items[$layout_item_key]['settings'][$option['id']]) ? $template_layout_items[$layout_item_key]['settings'][$option['id']] : '';

                                        $settings_tabs_field->generate_field($option);
                                    }
                                endif;



                                if(!empty($options_style)):
                                    foreach ($options_style as $option){

                                        $option['css_id'] = $layout_item_key.'-'.$option['id'];
                                        $option['parent'] = 'team_template_options[layout_items]['.$layout_item_key.'][style]';
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
                                    <span class="name"><?php echo $title; ?> (<?php echo $layout_item_key; ?>)</span>

                                    <input type="hidden" name="team_template_options[layout_items_sort][<?php echo $layout_item_key; ?>]" value="">

                                </div>
                                <div class="options">

                                    <?php

                                    if(!empty($options_style)):
                                        foreach ($options_style as $option){

                                            $option['css_id'] = $layout_item_key.'-'.$option['id'];
                                            $option['parent'] = 'team_template_options[layout_items]['.$layout_item_key.'][style]';

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
                // jQuery(document).ready(function($)
                // {
                //     $(function() {
                //         $( ".expandable" ).sortable({ handle: '.move' });
                //         //$( ".items" ).disableSelection();
                //     });
                //
                // })

            </script>
            <?php



            $html = ob_get_clean();

            //var_dump($template);


                $args = array(
                    'id' => 'elements',
                    'parent' => 'team_template_options',
                    'title' => __('Elements options', 'testimonial'),
                    'details' => '',
                    'type' => 'custom_html',
                    'html' => $html,
                );
                $settings_tabs_field->generate_field($args);



            $details = '<div class="item-wrap">
            <div class="element thumbnail">{{thumbnail}}</div>
            <div class="element name">{{name}}</div>
            <div class="element position">{{position}}</div>
            <div class="element company_name">{{company_name}}</div>
            <div class="element rating">{{rating}}</div>
            <div class="element arrow-top-left content">{{content}}</div>
            </div>';

            $args = array(
                'id' => 'template_html',
                'parent' => 'team_template_options',
                'title' => __('Template HTML', 'testimonial'),
                'details' => 'you can use custom html for item output, <code>'.esc_html($details).'</code>',
                'type' => 'textarea',
                'value' => $template_html,
                'default' => '',

            );
            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'template_css',
                'parent' => 'team_template_options',
                'title'		=> __('Custom CSS','testimonial'),
                'details'	=> __('Add your own CSS..','testimonial'),
                'type'		=> 'scripts_css',
                'value'		=> $template_css,
                'default'		=> '.item-wrap{}&#10;.item-wrap .element.thumbnail{}&#10;.item-wrap .element.name{}&#10;.item-wrap .element.position{}&#10;.item-wrap .element.company_name{}&#10;.item-wrap .element.rating{}&#10;',
            );

            $settings_tabs_field->generate_field($args);






            $testimonial = array (
                'name' => 'Lorem Ipsum',
                'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,',
                'thumbnail' => team_plugin_url.'assets/admin/images/profile.png',
                'company_name' => 'PickPlugins',
                'position' => 'Founder',
                'rating' => '4',
            );



            ob_start();

            $vars = array();

            if(!empty($testimonial))
                foreach ($testimonial as $element_key => $elementValue):

                    if($element_key == 'thumbnail'){

                        $elementHTML = '<img alt="'.$element_key.'" src="'.$elementValue.'">';

                    }
                    elseif($element_key == 'rating'){
                        $ratingHTML = '';
                        $ratingCount = intval($elementValue);

                        for($i=1; $i<= $ratingCount; $i++){
                            $ratingHTML .= '<i class="fas fa-star"></i>';
                        }

                        $elementHTML = $ratingHTML;

                    }

                    else{
                        $elementHTML = $elementValue;
                    }

                    //$filterArgs= array('elementValue'=>$elementValue,'elementKey'=>$element_key, 'testimonialId'=>$post_id, 'templateId'=>$template_id);


                    $vars['{{'.$element_key.'}}'] = $elementHTML;

                endforeach;






            ?>

            <div class="testimonial-container">
                <div class="testi-preview">

                    <?php echo strtr($template_html,$vars); ?>
                </div>

            </div>
            <style type="text/css"><?php


                echo $template_css;



                foreach ($template_layout_items as $layout_item_key=>$layoutData):

                    $layoutStyle = $layoutData['style'];

                    if($layout_item_key == 'thumbnail'){
                        echo '.testimonial-container .'.$layout_item_key.' img, .testimonial-container .'.$layout_item_key.'{';
                    }else{
                        echo '.testimonial-container .'.$layout_item_key.'{';
                    }



                        foreach ($layoutStyle as $styleId=>$styleVal){

                            if(!empty($styleVal))
                            echo $styleId.':'.$styleVal.';';



                        }

                    echo '}';
                    echo "\r\n";
                endforeach;





            ?></style>
            <?php

            $html = ob_get_clean();

            //var_dump($template);


            $args = array(
                'id' => 'preview',
                //'parent' => 'team_template_options',
                'title' => __('Preview', 'testimonial'),
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





