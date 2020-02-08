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

    $team_themes = get_post_meta($post_id,'team_themes', true);
    $team_skins = array('flat'=>'Flat', 'zoomout'=>'ZoomOut','thumbrounded'=>'ThumbRounded',  );
    $team_items_link_to_post = get_post_meta($post_id,'team_items_link_to_post', true);
    $team_items_max_width = get_post_meta($post_id,'team_items_max_width', true);
    $team_items_width_tablet = get_post_meta($post_id,'team_items_width_tablet', true);
    $team_items_width_mobile = get_post_meta($post_id,'team_items_width_mobile', true);

    $team_items_margin = get_post_meta($post_id,'team_items_margin', true);
    $team_item_text_align = get_post_meta($post_id,'team_item_text_align', true);

    $team_bg_img = get_post_meta($post_id,'team_bg_img', true);
    $team_container_bg_color = get_post_meta($post_id,'team_container_bg_color', true);
    $team_grid_item_align = get_post_meta($post_id,'team_grid_item_align', true);

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Style', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose style settings.', 'team'); ?></p>


        <?php

        $args = array(
            'id'		=> 'job_bm_job_type',
            //'parent'		=> '',
            'title'		=> __('Skin','job-board-manager'),
            'details'	=> __('Select team item skin','job-board-manager'),
            'type'		=> 'select',
            'value'		=> $team_themes,
            'default'		=> '',
            'args'		=> $team_skins,
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'team_items_link_to_post',
            //'parent'		=> '',
            'title'		=> __('Link to member','job-board-manager'),
            'details'	=> __('Clickable link to post team member.','job-board-manager'),
            'type'		=> 'select',
            'value'		=> $team_items_link_to_post,
            'default'		=> '',
            'args'		=> array('no'=>'No','yes'=>'Yes'),
        );

        $settings_tabs_field->generate_field($args);




        $args = array(
            'id'		=> 'item_width',
            'title'		=> __('Item width','related-post'),
            'details'	=> __('Set item width.','related-post'),
            'type'		=> 'option_group',
            'options'		=> array(
                array(
                    'id'		=> 'team_items_max_width',
                    //'parent'		=> 'team_options[item_width]',
                    'title'		=> __('In desktop','related-post'),
                    'details'	=> __('min-width: 1200px, ex: 45% or 280px','related-post'),
                    'type'		=> 'text',
                    'value'		=> $team_items_max_width,
                    'default'		=> '',
                    'placeholder'   => '45%',
                ),
                array(
                    'id'		=> 'team_items_width_tablet',
                    //'parent'		=> 'team_options[item_width]',
                    'title'		=> __('In tablet & small desktop','related-post'),
                    'details'	=> __('min-width: 992px, ex: 90% or 280px','related-post'),
                    'type'		=> 'text',
                    'value'		=> $team_items_width_tablet,
                    'default'		=> '',
                    'placeholder'   => '90%',
                ),
                array(
                    'id'		=> 'team_items_width_mobile',
                    //'parent'		=> 'team_options[item_width]',
                    'title'		=> __('In mobile','related-post'),
                    'details'	=> __('max-width: 768px, ex: 90% or 280px','related-post'),
                    'type'		=> 'text',
                    'value'		=> $team_items_width_mobile,
                    'default'		=> '',
                    'placeholder'   => '90%',
                ),
            ),

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'team_items_margin',
            //'parent'		=> '',
            'title'		=> __('Grid items margin','job-board-manager'),
            'details'	=> __('Set grid item margin, ex: <code>10px 5px</code>','job-board-manager'),
            'type'		=> 'text',
            'value'		=> $team_items_margin,
            'default'		=> '',
            'placeholder'		=> '10px 5px',
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'team_item_text_align',
            //'parent'		=> '',
            'title'		=> __('Items text align','job-board-manager'),
            'details'	=> __('Choose text align for grid items','job-board-manager'),
            'type'		=> 'select',
            'value'		=> $team_item_text_align,
            'default'		=> '',
            'args'		=> array('left'=>'Left','center'=>'Center', 'right'=>'Right',),
        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'		=> 'item_width',
            'title'		=> __('Container style','related-post'),
            'details'	=> __('Customize container style.','related-post'),
            'type'		=> 'option_group',
            'options'		=> array(
                array(
                    'id'		=> 'team_bg_img',
                    //'parent'		=> 'team_options[item_width]',
                    'title'		=> __('Background image','related-post'),
                    'details'	=> __('Container background image','related-post'),
                    'type'		=> 'media_url',
                    'value'		=> $team_bg_img,
                    'default'		=> '',
                    'placeholder'   => '',
                ),
                array(
                    'id'		=> 'team_container_bg_color',
                    //'parent'		=> 'team_options[item_width]',
                    'title'		=> __('Background colo','related-post'),
                    'details'	=> __('Container background color','related-post'),
                    'type'		=> 'colorpicker',
                    'value'		=> $team_container_bg_color,
                    'default'		=> '',
                    'placeholder'   => '',
                ),
                array(
                    'id'		=> 'team_grid_item_align',
                    //'parent'		=> 'team_options[item_width]',
                    'title'		=> __('Text align','related-post'),
                    'details'	=> __('Container text align','related-post'),
                    'type'		=> 'select',
                    'value'		=> $team_grid_item_align,
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

    $team_query_orderby = get_post_meta($post_id,'team_query_orderby', true);
    $team_query_orderby_meta_key = get_post_meta($post_id,'team_query_orderby_meta_key', true);
    $team_query_order = get_post_meta($post_id,'team_query_order', true);
    $team_total_items = get_post_meta($post_id,'team_total_items', true);
    $team_taxonomy_terms = get_post_meta($post_id,'team_taxonomy_terms', true);

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Query team members', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose settings to query team members.', 'team'); ?></p>


        <?php

        $args = array(
            'id'		=> 'team_query_orderby',
            //'parent'		=> '',
            'title'		=> __('Query orderby','job-board-manager'),
            'details'	=> __('Set query ordeby.','job-board-manager'),
            'type'		=> 'select',
            'value'		=> $team_query_orderby,
            'default'		=> '',
            'args'		=> array('ID'=>'ID','author'=>'Author','title'=>'Title','name'=>'Name', 'type'=>'Type','date'=>'Date', 'post_date'=>'post_date','modified'=>'modified', 'parent'=>'parent', 'rand'=>'Random','comment_count'=>'Comment Count',  ),
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'team_query_orderby_meta_key',
            //'parent'		=> '',
            'title'		=> __('orderby meta value','job-board-manager'),
            'details'	=> __('Use meta meta key to orderby meta value.','job-board-manager'),
            'type'		=> 'text',
            'value'		=> $team_query_orderby_meta_key,
            'default'		=> '',
            'placeholder'		=> 'meta_key',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'team_query_order',
            //'parent'		=> '',
            'title'		=> __('Query order','job-board-manager'),
            'details'	=> __('Set query order.','job-board-manager'),
            'type'		=> 'select',
            'value'		=> $team_query_order,
            'default'		=> '',
            'args'		=> array('ASC'=>'Ascending','DESC'=>'Descending'),
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'team_total_items',
            //'parent'		=> '',
            'title'		=> __('Post per page','job-board-manager'),
            'details'	=> __('You can display pagination or total number of member on grid. set -1 to display all.','job-board-manager'),
            'type'		=> 'text',
            'value'		=> $team_total_items,
            'default'		=> '',
            'placeholder'		=> '',
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
            'id'		=> 'team_taxonomy_terms',
            //'parent'		=> '',
            'title'		=> __('Team groups','job-board-manager'),
            'details'	=> __('Choose team groups.','job-board-manager'),
            'type'		=> 'checkbox',
            'value'		=> $team_taxonomy_terms,
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
    $team_items_custom_css = get_post_meta($post_id,'team_items_custom_css', true);


    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Custom scripts', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Write custom scripts to override CSS and scripts.', 'team'); ?></p>


        <?php
        $args = array(
            'id'		=> 'team_items_custom_css',
            //'parent'		=> '',
            'title'		=> __('Custom CSS','job-board-manager'),
            'details'	=> __('Write custom CSS to override default style, do not use <code>&lt;style>&lt;/style></code> tag.','job-board-manager'),
            'type'		=> 'scripts_css',
            'value'		=> $team_items_custom_css,
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

    $team_masonry_enable = get_post_meta($post_id,'team_masonry_enable', true);

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Masonry', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Customize masonry settings.', 'team'); ?></p>


        <?php

        $args = array(
            'id'		=> 'team_masonry_enable',
            //'parent'		=> '',
            'title'		=> __('Active masonry','job-board-manager'),
            'details'	=> __('Choose masonry style grid.','job-board-manager'),
            'type'		=> 'select',
            'value'		=> $team_masonry_enable,
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

    echo '<pre>'.var_export($team_options, true).'</pre>';


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
                $item_layout_args[$post_id] = array('name'=>$layout_name,'thumb'=> $team_thumb_url);

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
            'width'		=> '350px',
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

    $team_pagination_prev_text = get_post_meta($post_id,'team_pagination_prev_text', true);
    $team_pagination_next_text = get_post_meta($post_id,'team_pagination_next_text', true);
    $team_pagination_bg_color = get_post_meta($post_id,'team_pagination_bg_color', true);
    $team_pagination_active_bg_color = get_post_meta($post_id,'team_pagination_active_bg_color', true);

    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Masonry', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Customize masonry settings.', 'team'); ?></p>


        <?php

        $args = array(
            'id'		=> 'team_pagination_prev_text',
            //'parent'		=> '',
            'title'		=> __('Previous text','job-board-manager'),
            'details'	=> __('Write previous text.','job-board-manager'),
            'type'		=> 'text',
            'value'		=> $team_pagination_prev_text,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'		=> 'team_pagination_next_text',
            //'parent'		=> '',
            'title'		=> __('Next text','job-board-manager'),
            'details'	=> __('Write next text.','job-board-manager'),
            'type'		=> 'text',
            'value'		=> $team_pagination_next_text,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'team_pagination_bg_color',
            //'parent'		=> '',
            'title'		=> __('Background color','job-board-manager'),
            'details'	=> __('Choose background color.','job-board-manager'),
            'type'		=> 'colorpicker',
            'value'		=> $team_pagination_bg_color,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'team_pagination_active_bg_color',
            //'parent'		=> '',
            'title'		=> __('active background color','job-board-manager'),
            'details'	=> __('Choose active background color.','job-board-manager'),
            'type'		=> 'colorpicker',
            'value'		=> $team_pagination_active_bg_color,
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

