<?php
if ( ! defined('ABSPATH')) exit;  // if direct access











add_action('team_layout_metabox_content_custom_scripts','team_layout_metabox_content_custom_scripts');

if(!function_exists('team_layout_metabox_content_custom_scripts')){
    function team_layout_metabox_content_custom_scripts($post_id){


        $settings_tabs_field = new settings_tabs_field();
        $custom_scripts = get_post_meta($post_id,'custom_scripts', true);
        $layout_options = get_post_meta($post_id,'layout_options', true);


        $custom_css = isset($custom_scripts['custom_css']) ? $custom_scripts['custom_css'] : '';
        $custom_js = isset($custom_scripts['custom_js']) ? $custom_scripts['custom_js'] : '';
        $layout_preview_img = isset($layout_options['layout_preview_img']) ? $layout_options['layout_preview_img'] : '';




        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Custom scripts', 'team'); ?></div>
            <p class="description section-description"><?php echo __('Write custom scripts to override CSS and scripts.', 'team'); ?></p>


            <?php
            $args = array(
                'id'		=> 'custom_css',
                'parent'		=> 'custom_scripts',
                'title'		=> __('Custom CSS','job-board-manager'),
                'details'	=> __('Write custom CSS to override default style, do not use <code>&lt;style>&lt;/style></code> tag. use <code>__ID__</code> to replace by layout id <code>layout-'.$post_id.'</code>.','job-board-manager'),
                'type'		=> 'scripts_css',
                'value'		=> $custom_css,
                'default'		=> '',
                'placeholder'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'custom_js',
                'parent'		=> 'custom_scripts',
                'title'		=> __('Custom JS','job-board-manager'),
                'details'	=> __('Write custom JS to override default style, do not use <code>&lt;script>&lt;/script></code> tag.','job-board-manager'),
                'type'		=> 'scripts_js',
                'value'		=> $custom_js,
                'default'		=> '',
                'placeholder'		=> '',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'layout_preview_img',
                'parent'		=> 'layout_options',
                'title'		=> __('Preview image','job-board-manager'),
                'details'	=> __('Set layout preview image.','job-board-manager'),
                'type'		=> 'media_url',
                'value'		=> $layout_preview_img,
                'default'		=> '',
                'placeholder'		=> '',
            );

            $settings_tabs_field->generate_field($args);





            ?>
        </div>
        <?php


    }

}








add_action('team_layout_metabox_content_layout_builder','team_layout_metabox_content_layout_builder');

if(!function_exists('team_layout_metabox_content_layout_builder')){

    function team_layout_metabox_content_layout_builder($post_id){


        $settings_tabs_field = new settings_tabs_field();

        $layout_elements_data = get_post_meta($post_id,'layout_elements_data', true);



        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Layout builder', 'team'); ?></div>
            <p class="description section-description"><?php echo __('Customize layout settings.', 'team'); ?></p>


            <?php

            $layout_elements_list = array(
                'thumbnail'=> array('name' =>__('Thumbnail','team')),
                'title'=> array('name' =>__('Title','team')),
                'position'=> array('name' =>__('Position','team')),
                'content'=> array('name' =>__('Content','team')),
                'social'=> array('name' =>__('Social','team')),
                //'popup'=>array('name' =>__('Pop up','team')),
                'meta'=> array('name' =>__('Meta fields','team')),
                //'skill'=>array('name' =>__('Skill','team')),
                'wrapper_start'=> array('name' =>__('Wrapper start','team')),
                'wrapper_end'=> array('name' =>__('Wrapper end','team')),
            );

            $layout_elements_option = array();

            foreach ($layout_elements_list as $elementIndex => $element):

                ob_start();

                do_action('layout_elements_option_'.$elementIndex);

                $layout_elements_option[$elementIndex] = ob_get_clean();

            endforeach;




            //echo '<pre>'.var_export($layout_elements_data, true).'</pre>';




            ob_start();

            ?>

            <script>
                jQuery(document).ready(function($){
                    layout_elements_option = <?php echo json_encode($layout_elements_option); ?>;

                    $(document).on('click','.layout-tags span',function(){
                        tag_id = $(this).attr('tag_id');
                        input_name = $(this).attr('input_name');
                        id = $.now();

                        console.log(id);

                        tag_options_html = layout_elements_option[tag_id];
                        var res = tag_options_html.replace("{input_name}", input_name+'['+id+']');

                        $(this).parent().parent().children('.elements').append(res);

                    })
                })
            </script>

            <div class="layout-builder">
                <div class="layout-tags">
                    <?php

                    foreach ($layout_elements_list as $elementIndex => $element):
                        $element_name = isset($element['name']) ? $element['name'] : '';
                        ?>
                        <span input_name="<?php echo 'layout_elements_data'; ?>"  tag_id="<?php echo $elementIndex; ?>"><?php echo $element_name; ?></span>
                    <?php

                    endforeach;

                    ?>
                </div>

                <div class="elements expandable sortable">

                    <?php

                    if(!empty($layout_elements_data)):
                        foreach ($layout_elements_data as $index => $item_data){
                            foreach ($item_data as $elementIndex => $element_data){

                                $args = array('input_name'=> 'layout_elements_data['.$index.']', 'element_data'=> $element_data, 'index'=>$index);
                                do_action('layout_elements_option_'.$elementIndex, $args);
                            }


                        }
                    else:
                        ?>
                        <div class="empty-element">
                            <?php echo sprintf(__('%s Click to add tags.','breadcrumb'), '<i class="far fa-hand-point-up"></i>') ?>
                        </div>
                    <?php
                    endif;

                    ?>

                </div>


            </div>

            <style type="text/css">
                .layout-builder{}
                .layout-tags{
                    margin-bottom: 20px;
                }
                .layout-tags span{
                    background: #ddd;
                    padding: 4px 10px;
                    display: inline-block;
                    margin: 2px 2px;
                    border-radius: 3px;
                    border: 1px solid #b9b9b9;
                    cursor: pointer;
                }

                .layout-tags span:hover{
                    background: #b9b9b9;

                }

            </style>

            <?php

            $html = ob_get_clean();


            $args = array(
                'id'		=> 'layout_builder',
                //'parent'		=> '',
                'title'		=> __('Layout elements','job-board-manager'),
                'details'	=> __('Customize layout elements.','job-board-manager'),
                'type'		=> 'custom_html',
                'html'		=> $html,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);


            ob_start();



            $item_layout_id = get_the_id();
            ?>
            <div class="layout-preview">

                <div class="elements-wrapper layout-<?php echo $item_layout_id; ?>">
                    <?php
                    foreach ($layout_elements_data as $elementGroupIndex => $elementGroupData){
                        foreach ($elementGroupData as $elementIndex => $elementData){




                            $args['team_member_id'] = team_first_team_member();
                            $args['elementData'] = $elementData;
                            $args['element_index'] = $elementGroupIndex;

                            //echo '<pre>'.var_export($elementIndex, true).'</pre>';

                            //echo $elementIndex;
                            do_action('team_showcase_item_elements_'.$elementIndex, $args);
                        }
                    }
                    ?>
                </div>







            </div>

            <?php

            foreach ($layout_elements_data as $elementGroupIndex => $elementGroupData){
                foreach ($elementGroupData as $elementIndex => $elementData){


                    $args['elementData'] = $elementData;
                    $args['element_index'] = $elementGroupIndex;

                    //echo $elementIndex;
                    do_action('team_showcase_item_elements_css_'.$elementIndex, $args);
                }
            }

            $custom_scripts = get_post_meta($item_layout_id,'custom_scripts', true);
            $custom_css = isset($custom_scripts['custom_css']) ? $custom_scripts['custom_css'] : '';

            ?>

            <style type="text/css">
                .layout-preview{
                    background: url(<?php echo team_plugin_url; ?>assets/admin/css/tile.png);
                    padding: 20px;
                }

                .layout-preview .elements-wrapper{
                    width: 400px;
                    overflow: hidden;
                    margin: 0 auto;
                }

                .layout-preview img{
                    width: 100%;
                }

                <?php

                echo str_replace('__ID__', 'layout-'.$item_layout_id, $custom_css);

                ?>

            </style>
            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'layout_preview',
                //'parent'		=> '',
                'title'		=> __('Layout preview','job-board-manager'),
                'details'	=> '',
                'type'		=> 'custom_html',
                'html'		=> $html,
                'default'		=> '',
            );

            $settings_tabs_field->generate_field($args);



            ?>
        </div>
        <?php


    }



}











add_action('team_layout_meta_box_save_team','team_layout_meta_box_save_team');

function team_layout_meta_box_save_team($job_id){

    $layout_options = isset($_POST['layout_options']) ? stripslashes_deep($_POST['layout_options']) : '';
    update_post_meta($job_id, 'layout_options', $layout_options);

    $layout_elements_data = isset($_POST['layout_elements_data']) ? stripslashes_deep($_POST['layout_elements_data']) : '';
    update_post_meta($job_id, 'layout_elements_data', $layout_elements_data);

    $custom_scripts = isset($_POST['custom_scripts']) ? stripslashes_deep($_POST['custom_scripts']) : '';
    update_post_meta($job_id, 'custom_scripts', $custom_scripts);

}

