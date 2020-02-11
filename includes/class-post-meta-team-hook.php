<?php
if ( ! defined('ABSPATH')) exit;  // if direct access



add_action('team_metabox_content_shortcodes','team_metabox_content_shortcodes');


function team_metabox_content_shortcodes($post_id){


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









add_action('team_metabox_content_style','team_metabox_content_style');


function team_metabox_content_style($post_id){


    $settings_tabs_field = new settings_tabs_field();

    $team_options = get_post_meta($post_id,'team_options', true);
    $item_width = isset($team_options['item_width']) ? $team_options['item_width'] : array();

    $team_width_large = isset($item_width['large']) ? $item_width['large'] : '';
    $team_width_medium = isset($item_width['medium']) ? $item_width['medium'] : '';
    $team_width_small = isset($item_width['small']) ? $item_width['small'] : '';

    $item_margin = isset($team_options['item_margin']) ? $team_options['item_margin'] : '';
    $item_text_align = isset($team_options['item_text_align']) ? $team_options['item_text_align'] : '';

    $container_background_img_url = isset($team_options['container']['background_img_url']) ? $team_options['container']['background_img_url'] : '';
    $container_background_color = isset($team_options['container']['background_color']) ? $team_options['container']['background_color'] : '';
    $container_text_align = isset($team_options['container']['text_align']) ? $team_options['container']['text_align'] : '';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Style', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose style settings.', 'team'); ?></p>


        <?php


        $args = array(
            'id'		=> 'item_width',
            'title'		=> __('Item width','team'),
            'details'	=> __('Set item width.','team'),
            'type'		=> 'option_group',
            'options'		=> array(
                array(
                    'id'		=> 'large',
                    'parent'		=> 'team_options[item_width]',
                    'title'		=> __('In desktop','team'),
                    'details'	=> __('min-width: 1200px, ex: 45% or 280px','team'),
                    'type'		=> 'text',
                    'value'		=> $team_width_large,
                    'default'		=> '',
                    'placeholder'   => '45%',
                ),
                array(
                    'id'		=> 'medium',
                    'parent'		=> 'team_options[item_width]',
                    'title'		=> __('In tablet & small desktop','team'),
                    'details'	=> __('min-width: 992px, ex: 90% or 280px','team'),
                    'type'		=> 'text',
                    'value'		=> $team_width_medium,
                    'default'		=> '',
                    'placeholder'   => '90%',
                ),
                array(
                    'id'		=> 'small',
                    'parent'		=> 'team_options[item_width]',
                    'title'		=> __('In mobile','team'),
                    'details'	=> __('max-width: 768px, ex: 90% or 280px','team'),
                    'type'		=> 'text',
                    'value'		=> $team_width_small,
                    'default'		=> '',
                    'placeholder'   => '90%',
                ),
            ),

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'item_margin',
            'parent'		=> 'team_options',
            'title'		=> __('Item margin','job-board-manager'),
            'details'	=> __('Set grid item margin, ex: <code>10px 5px</code>','job-board-manager'),
            'type'		=> 'text',
            'value'		=> $item_margin,
            'default'		=> '',
            'placeholder'		=> '10px 5px',
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'item_text_align',
            'parent'		=> 'team_options',
            'title'		=> __('Item text align','job-board-manager'),
            'details'	=> __('Choose text align for grid items','job-board-manager'),
            'type'		=> 'select',
            'value'		=> $item_text_align,
            'default'		=> '',
            'args'		=> array('left'=>'Left','center'=>'Center', 'right'=>'Right',),
        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'		=> 'item_width',
            'title'		=> __('Container style','team'),
            'details'	=> __('Customize container style.','team'),
            'type'		=> 'option_group',
            'options'		=> array(
                array(
                    'id'		=> 'background_img_url',
                    'parent'		=> 'team_options[container]',
                    'title'		=> __('Background image','team'),
                    'details'	=> __('Container background image','team'),
                    'type'		=> 'media_url',
                    'value'		=> $container_background_img_url,
                    'default'		=> '',
                    'placeholder'   => '',
                ),
                array(
                    'id'		=> 'background_color',
                    'parent'		=> 'team_options[container]',
                    'title'		=> __('Background color','team'),
                    'details'	=> __('Container background color','team'),
                    'type'		=> 'colorpicker',
                    'value'		=> $container_background_color,
                    'default'		=> '',
                    'placeholder'   => '',
                ),
                array(
                    'id'		=> 'text_align',
                    'parent'		=> 'team_options[container]',
                    'title'		=> __('Text align','team'),
                    'details'	=> __('Container text align','team'),
                    'type'		=> 'select',
                    'value'		=> $container_text_align,
                    'default'		=> '',
                    'args'		=> array('left'=>'Left','center'=>'Center', 'right'=>'Right',),
                ),
            ),

        );

        $settings_tabs_field->generate_field($args);




        ?>
    </div>
    <?php


}




add_action('team_metabox_content_query_member','team_metabox_content_query_member');


function team_metabox_content_query_member($post_id){


    $settings_tabs_field = new settings_tabs_field();


    $team_options = get_post_meta($post_id,'team_options', true);
    $query = isset($team_options['query']) ? $team_options['query'] : array();

    $query_orderby = isset($query['orderby']) ? $query['orderby'] : '';
    $query_orderby_meta_key = isset($query['orderby_meta_key']) ? $query['orderby_meta_key'] : '';
    $query_order = isset($query['order']) ? $query['order'] : '';
    $query_post_per_page = isset($query['post_per_page']) ? $query['post_per_page'] : '';
    $query_taxonomy_terms = isset($query['taxonomy_terms']) ? $query['taxonomy_terms'] : '';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Query team members', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose settings to query team members.', 'team'); ?></p>


        <?php

        $args = array(
            'id'		=> 'orderby',
            'parent'		=> 'team_options[query]',
            'title'		=> __('Query orderby','job-board-manager'),
            'details'	=> __('Set query ordeby.','job-board-manager'),
            'type'		=> 'select',
            'value'		=> $query_orderby,
            'default'		=> '',
            'args'		=> array('ID'=>'ID','author'=>'Author','title'=>'Title','name'=>'Name', 'type'=>'Type','date'=>'Date', 'post_date'=>'post_date','modified'=>'modified', 'parent'=>'parent', 'rand'=>'Random','comment_count'=>'Comment Count',  ),
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'orderby_meta_key',
            'parent'		=> 'team_options[query]',
            'title'		=> __('Order-by meta value','job-board-manager'),
            'details'	=> __('Use meta meta key to orderby meta value.','job-board-manager'),
            'type'		=> 'text',
            'value'		=> $query_orderby_meta_key,
            'default'		=> '',
            'placeholder'		=> 'meta_key',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'order',
            'parent'		=> 'team_options[query]',
            'title'		=> __('Query order','job-board-manager'),
            'details'	=> __('Set query order.','job-board-manager'),
            'type'		=> 'select',
            'value'		=> $query_order,
            'default'		=> '',
            'args'		=> array('ASC'=>'Ascending','DESC'=>'Descending'),
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'post_per_page',
            'parent'		=> 'team_options[query]',
            'title'		=> __('Post per page','job-board-manager'),
            'details'	=> __('You can display pagination or total number of member on grid. set -1 to display all.','job-board-manager'),
            'type'		=> 'text',
            'value'		=> $query_post_per_page,
            'default'		=> '',
            'placeholder'		=> '10',
        );

        $settings_tabs_field->generate_field($args);

        $args=array(
            'orderby' => 'name',
            'order' => 'ASC',
            'taxonomy' => array('team_group'),
        );

        $categories = get_categories($args);

        $team_groups = array();

        foreach($categories as $category){
            $cat_ID = $category->cat_ID;
            $cat_name = $category->cat_name;

            $team_groups[$cat_ID] = $cat_name;
        }


        $args = array(
            'id'		=> 'taxonomy_terms',
            'parent'		=> 'team_options[query]',
            'title'		=> __('Team groups','job-board-manager'),
            'details'	=> __('Choose team groups.','job-board-manager'),
            'type'		=> 'checkbox',
            'value'		=> $query_taxonomy_terms,
            'default'		=> '',
            'args'		=> $team_groups,
        );

        $settings_tabs_field->generate_field($args);




        ?>
    </div>
    <?php


}







add_action('team_metabox_content_custom_scripts','team_metabox_content_custom_scripts');


function team_metabox_content_custom_scripts($post_id){


    $settings_tabs_field = new settings_tabs_field();
    $team_options = get_post_meta($post_id,'team_options', true);
    $custom_scripts = isset($team_options['custom_scripts']) ? $team_options['custom_scripts'] : array();

    $custom_css = isset($custom_scripts['custom_css']) ? $custom_scripts['custom_css'] : '';




    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Custom scripts', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Write custom scripts to override CSS and scripts.', 'team'); ?></p>


        <?php
        $args = array(
            'id'		=> 'custom_css',
            'parent'		=> 'team_options[custom_scripts]',
            'title'		=> __('Custom CSS','job-board-manager'),
            'details'	=> __('Write custom CSS to override default style, do not use <code>&lt;style>&lt;/style></code> tag.','job-board-manager'),
            'type'		=> 'scripts_css',
            'value'		=> $custom_css,
            'default'		=> '',
            'placeholder'		=> '',
        );

        $settings_tabs_field->generate_field($args);






        ?>
    </div>
    <?php


}






add_action('team_metabox_content_masonry','team_metabox_content_masonry');


function team_metabox_content_masonry($post_id){


    $settings_tabs_field = new settings_tabs_field();

    $team_options = get_post_meta($post_id,'team_options', true);
    $masonry_enable = isset($team_options['masonry_enable']) ? $team_options['masonry_enable'] : '';


    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Masonry', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Customize masonry settings.', 'team'); ?></p>


        <?php

        $args = array(
            'id'		=> 'masonry_enable',
            'parent' => 'team_options',
            'title'		=> __('Active masonry','job-board-manager'),
            'details'	=> __('Choose masonry style grid.','job-board-manager'),
            'type'		=> 'select',
            'value'		=> $masonry_enable,
            'default'		=> '',
            'args'		=> array('no'=>'No', 'yes'=>'Yes'),
        );

        $settings_tabs_field->generate_field($args);



        ?>
    </div>
    <?php


}






add_action('team_metabox_content_layouts','team_metabox_content_layouts');
function team_metabox_content_layouts($post_id){


    $settings_tabs_field = new settings_tabs_field();
    $team_options = get_post_meta($post_id,'team_options', true);
    $item_layout_id = isset($team_options['item_layout_id']) ? $team_options['item_layout_id'] : '';



    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Layouts', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose item layouts.', 'team'); ?></p>


        <?php

        $query_args['post_type'] 		= array('team_layout');
        $query_args['post_status'] 		= array('publish');
        $query_args['orderby']  		= 'date';
        $query_args['order']  			= 'DESC';
        $query_args['posts_per_page'] 	= -1;
        $wp_query = new WP_Query($query_args);

        if ( $wp_query->have_posts() ) :

            while ( $wp_query->have_posts() ) : $wp_query->the_post();

                $post_id = get_the_id();
                $layout_name = get_the_title();
                $team_thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'full' );
                $team_thumb_url = isset($team_thumb['0']) ? esc_url_raw($team_thumb['0']) : '';

                $layout_options = get_post_meta($post_id,'layout_options', true);
                $layout_preview_img = isset($layout_options['layout_preview_img']) ? $layout_options['layout_preview_img'] : '';

                $team_thumb_url = !empty( $team_thumb_url ) ? $team_thumb_url : $layout_preview_img;

                $item_layout_args[$post_id] = array('name'=>$layout_name, 'link_text'=>'Edit', 'link'=> get_edit_post_link($post_id), 'thumb'=> $team_thumb_url, );

            endwhile;
        endif;





        $args = array(
            'id'		=> 'item_layout_id',
            'parent' => 'team_options',
            'title'		=> __('Item layouts','breadcrumb'),
            'details'	=> __('Choose grid item layout.','breadcrumb'),
            'type'		=> 'radio_image',
            'value'		=> $item_layout_id,
            'default'		=> '',
            'width'		=> '250px',
            'args'		=> $item_layout_args,
        );

        $settings_tabs_field->generate_field($args);



        ?>
    </div>
    <?php


}
















add_action('team_metabox_content_pagination','team_metabox_content_pagination');


function team_metabox_content_pagination($post_id){


    $settings_tabs_field = new settings_tabs_field();
    $team_options = get_post_meta($post_id,'team_options', true);
    $pagination = isset($team_options['pagination']) ? $team_options['pagination'] : array();

    $pagination_type = isset($pagination['type']) ? $pagination['type'] : '';

    $pagination_prev_text = isset($pagination['prev_text']) ? $pagination['prev_text'] : '';
    $pagination_next_text = isset($pagination['next_text']) ? $pagination['next_text'] : '';
    $pagination_background_color = isset($pagination['background_color']) ? $pagination['background_color'] : '';
    $pagination_active_background_color = isset($pagination['active_background_color']) ? $pagination['active_background_color'] : '';

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Pagination', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Customize pagination settings.', 'team'); ?></p>


        <?php


        $args = array(
            'id'		=> 'type',
            'parent' => 'team_options[pagination]',
            'title'		=> __('View type','job-board-manager'),
            'details'	=> '',
            'type'		=> 'radio',
            'value'		=> $pagination_type,
            'default'		=> '',
            'args'		=> array('normal'=>'Normal','jquery'=>'jQuery pagination','ajax'=>'Ajax' ),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'prev_text',
            'parent' => 'team_options[pagination]',
            'title'		=> __('Previous text','job-board-manager'),
            'details'	=> __('Write previous text. ex: <code>« Previous</code>','job-board-manager'),
            'type'		=> 'text',
            'value'		=> $pagination_prev_text,
            'default'		=> '',
            'placeholder'		=> '« Previous',
        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'		=> 'next_text',
            'parent' => 'team_options[pagination]',
            'title'		=> __('Next text','job-board-manager'),
            'details'	=> __('Write next text. ex <code>Next »</code>','job-board-manager'),
            'type'		=> 'text',
            'value'		=> $pagination_next_text,
            'default'		=> '',
            'placeholder'		=> 'Next »',
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'background_color',
            'css_id'		=> 'pagination_background_color',
            'parent' => 'team_options[pagination]',
            'title'		=> __('Background color','job-board-manager'),
            'details'	=> __('Choose background color.','job-board-manager'),
            'type'		=> 'colorpicker',
            'value'		=> $pagination_background_color,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'active_background_color',
            'css_id'		=> 'pagination_active_background_color',
            'parent' => 'team_options[pagination]',
            'title'		=> __('Active background color','job-board-manager'),
            'details'	=> __('Choose active background color.','job-board-manager'),
            'type'		=> 'colorpicker',
            'value'		=> $pagination_active_background_color,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);




        ?>
    </div>
    <?php


}













add_action('team_meta_box_save_team','team_meta_box_save_team');

function team_meta_box_save_team($job_id){

    $team_options = isset($_POST['team_options']) ? stripslashes_deep($_POST['team_options']) : '';
    update_post_meta($job_id, 'team_options', $team_options);


//    $job_bm_total_vacancies = isset($_POST['job_bm_total_vacancies']) ? sanitize_text_field($_POST['job_bm_total_vacancies']) : '';
//    update_post_meta($job_id, 'job_bm_total_vacancies', $job_bm_total_vacancies);


}

