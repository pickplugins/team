<?php
if ( ! defined('ABSPATH')) exit;  // if direct access



add_action('team_metabox_content_shortcodes','team_metabox_content_shortcodes');


function team_metabox_content_shortcodes($post_id){


    $settings_tabs_field = new settings_tabs_field();


    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Shortcodes','team'); ?></div>
        <p class="description section-description"><?php echo __('Simply copy these shortcode and user under content','team'); ?></p>


        <?php


        ob_start();

        ?>

        <div class="copy-to-clipboard">
            <input type="text" value="[team id='<?php echo $post_id;  ?>']"> <span class="copied"><?php echo __('Copied','team'); ?></span>
            <p class="description"><?php echo __('You can use this shortcode under post content','team'); ?></p>
        </div>


        <div class="copy-to-clipboard">
            <textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[team id='; echo "'".$post_id."']"; echo '"); ?>'; ?></textarea> <span class="copied"><?php echo __('Copied','team'); ?></span>
            <p class="description"><?php echo __('PHP Code, you can use under theme .php files.','team'); ?></p>
        </div>

        <div class="copy-to-clipboard">
            To avoid conflict:<br>
            <input type="text" value="[team_pickplugins id='<?php echo $post_id;  ?>']"> <span class="copied"><?php echo __('Copied','team'); ?></span>
            <p class="description"><?php echo __('To avoid conflict with 3rd party shortcode also used same <code>[team]</code>You can use this shortcode under post content','team'); ?></p>
        </div>


        <div class="copy-to-clipboard">
            <textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[team_pickplugins id='; echo "'".$post_id."']"; echo '"); ?>'; ?></textarea> <span class="copied"><?php echo __('Copied','team'); ?></span>
            <p class="description"><?php echo __('To avoid conflict, PHP code you can use under theme .php files.','team'); ?></p>
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
            'title'		=> __('Shortcodes','team'),
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

    $team_width_large = isset($item_width['large']) ? $item_width['large'] : '30%';
    $team_width_medium = isset($item_width['medium']) ? $item_width['medium'] : '45%';
    $team_width_small = isset($item_width['small']) ? $item_width['small'] : '95%';

    $item_margin = isset($team_options['item_margin']) ? $team_options['item_margin'] : '5px';
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
            'title'		=> __('Item margin','team'),
            'details'	=> __('Set grid item margin, ex: <code>10px 5px</code>','team'),
            'type'		=> 'text',
            'value'		=> $item_margin,
            'default'		=> '',
            'placeholder'		=> '10px 5px',
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'item_text_align',
            'parent'		=> 'team_options',
            'title'		=> __('Item text align','team'),
            'details'	=> __('Choose text align for grid items','team'),
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

    $team_post_ids = get_post_meta($post_id,'team_post_ids', true);

    $team_options = get_post_meta($post_id,'team_options', true);
    $query = isset($team_options['query']) ? $team_options['query'] : array();

    $query_orderby = isset($query['orderby']) ? $query['orderby'] : 'date';
    $query_orderby_meta_key = isset($query['orderby_meta_key']) ? $query['orderby_meta_key'] : '';
    $query_order = isset($query['order']) ? $query['order'] : 'DESC';
    $query_post_per_page = isset($query['post_per_page']) ? $query['post_per_page'] : 10;
    $query_taxonomy_terms = isset($query['taxonomy_terms']) ? $query['taxonomy_terms'] : '';




    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Query team members', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose settings to query team members.', 'team'); ?></p>


        <?php

        ob_start();

        ?>
        <p><a target="_blank" class="button" href="<?php echo admin_url().'post-new.php?post_type=team_member'; ?>"><?php echo __('Create new team members','team'); ?></a> </p>
        <p><a target="_blank" class="button" href="<?php echo admin_url().'edit.php?post_type=team_member'; ?>"><?php echo __('Manage team members','team'); ?></a> </p>

        <?php


        $html = ob_get_clean();

        $args = array(
            'id'		=> 'create_team_members',
            'parent'		=> 'team_options[query]',
            'title'		=> __('Create team members','team'),
            'details'	=> __('Please follow the links to create team members or manage.','team'),
            'type'		=> 'custom_html',
            'html'		=> $html,
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'orderby',
            'parent'		=> 'team_options[query]',
            'title'		=> __('Query orderby','team'),
            'details'	=> __('Set query ordeby.','team'),
            'type'		=> 'select',
            'value'		=> $query_orderby,
            'default'		=> '',
            'args'		=> array('ID'=>'ID','author'=>'Author','title'=>'Title','name'=>'Name', 'type'=>'Type','date'=>'Date', 'post_date'=>'post_date','modified'=>'modified', 'parent'=>'parent', 'rand'=>'Random','comment_count'=>'Comment Count','menu_order'=>'Menu order','meta_value'=>'Meta Value','meta_value_num'=>'Meta Value(number)','post__in'=>'post__in',  'post_name__in'=>'post_name__in', ),
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'orderby_meta_key',
            'parent'		=> 'team_options[query]',
            'title'		=> __('Order-by meta value','team'),
            'details'	=> __('Use meta meta key to orderby meta value.','team'),
            'type'		=> 'text',
            'value'		=> $query_orderby_meta_key,
            'default'		=> '',
            'placeholder'		=> 'meta_key',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'order',
            'parent'		=> 'team_options[query]',
            'title'		=> __('Query order','team'),
            'details'	=> __('Set query order.','team'),
            'type'		=> 'select',
            'value'		=> $query_order,
            'default'		=> 'DESC',
            'args'		=> array('ASC'=>'Ascending','DESC'=>'Descending'),
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'post_per_page',
            'parent'		=> 'team_options[query]',
            'title'		=> __('Post per page','team'),
            'details'	=> __('You can display pagination or total number of member on grid. set -1 to display all.','team'),
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

        if(!empty($categories))
        foreach($categories as $category){
            $cat_ID = $category->cat_ID;
            $cat_name = $category->cat_name;
            $cat_count = $category->count;

            $team_groups[$cat_ID] = $cat_name.'('.$cat_count.')';
        }


        $args = array(
            'id'		=> 'taxonomy_terms',
            'parent'		=> 'team_options[query]',
            'title'		=> __('Team groups','team'),
            'details'	=> __('Choose team groups.','team'),
            'type'		=> 'checkbox',
            'value'		=> $query_taxonomy_terms,
            'default'		=> array(),
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
    $custom_js = isset($custom_scripts['custom_js']) ? $custom_scripts['custom_js'] : '';




    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Custom scripts', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Write custom scripts to override CSS and scripts.', 'team'); ?></p>


        <?php
        $args = array(
            'id'		=> 'custom_css',
            'parent'		=> 'team_options[custom_scripts]',
            'title'		=> __('Custom CSS','team'),
            'details'	=> __('Write custom CSS to override default style, do not use <code>&lt;style>&lt;/style></code> tag.','team'),
            'type'		=> 'scripts_css',
            'value'		=> $custom_css,
            'default'		=> '',
            'placeholder'		=> '',
        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'		=> 'custom_js',
            'parent'		=> 'team_options[custom_scripts]',
            'title'		=> __('Custom JS','team'),
            'details'	=> __('Write custom js to override default style, do not use <code>&lt;script>&lt;/script></code> tag.','team'),
            'type'		=> 'scripts_js',
            'value'		=> $custom_js,
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
            'title'		=> __('Active masonry','team'),
            'details'	=> __('Choose masonry style grid.','team'),
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
    $item_layout_id = !empty($team_options['item_layout_id']) ? $team_options['item_layout_id'] : team_first_team_layout();



    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Layouts', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose item layouts.', 'team'); ?></p>


        <?php



        ob_start();

        ?>
        <p><a target="_blank" class="button" href="<?php echo admin_url().'post-new.php?post_type=team_layout'; ?>"><?php echo __('Create new team layout','team'); ?></a> </p>
        <p><a target="_blank" class="button" href="<?php echo admin_url().'edit.php?post_type=team_layout'; ?>"><?php echo __('Manage team layout','team'); ?></a> </p>

        <?php


        $html = ob_get_clean();

        $args = array(
            'id'		=> 'create_team_layout',
            'parent'		=> 'team_options[query]',
            'title'		=> __('Create team layout','team'),
            'details'	=> __('Please follow the links to create team layouts or manage.','team'),
            'type'		=> 'custom_html',
            'html'		=> $html,
        );

        $settings_tabs_field->generate_field($args);


        $item_layout_args = array();

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
                $layout_preview_img = !empty($layout_options['layout_preview_img']) ? $layout_options['layout_preview_img'] : 'https://i.imgur.com/JyurCtY.jpg';

                $team_thumb_url = !empty( $team_thumb_url ) ? $team_thumb_url : $layout_preview_img;

                $item_layout_args[$post_id] = array('name'=>$layout_name, 'link_text'=>'Edit', 'link'=> get_edit_post_link($post_id), 'thumb'=> $team_thumb_url, );

            endwhile;
        endif;





        $args = array(
            'id'		=> 'item_layout_id',
            'parent' => 'team_options',
            'title'		=> __('Item layouts','team'),
            'details'	=> __('Choose grid item layout.','team'),
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

    $pagination_type = isset($pagination['type']) ? $pagination['type'] : 'pagination';

    $pagination_prev_text = isset($pagination['prev_text']) ? $pagination['prev_text'] : '';
    $pagination_next_text = isset($pagination['next_text']) ? $pagination['next_text'] : '';
    $pagination_background_color = isset($pagination['background_color']) ? $pagination['background_color'] : '';
    $pagination_active_background_color = isset($pagination['active_background_color']) ? $pagination['active_background_color'] : '';
    $pagination_on_top = isset($pagination['on_top']) ? $pagination['on_top'] : '';


    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Pagination', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Customize pagination settings.', 'team'); ?></p>


        <?php


        $args = array(
            'id'		=> 'type',
            'parent' => 'team_options[pagination]',
            'title'		=> __('Pagination type','team'),
            'details'	=> __('Choose pagination type','team'),
            'type'		=> 'radio',
            'value'		=> $pagination_type,
            'default'		=> '',
            'args'		=> apply_filters('team_pagination_types', array('none'=>'None','pagination'=>'Normal' )),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'		=> 'prev_text',
            'parent' => 'team_options[pagination]',
            'title'		=> __('Previous text','team'),
            'details'	=> __('Write previous text. ex: <code>« Previous</code>','team'),
            'type'		=> 'text',
            'value'		=> $pagination_prev_text,
            'default'		=> '',
            'placeholder'		=> '« Previous',
        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'		=> 'next_text',
            'parent' => 'team_options[pagination]',
            'title'		=> __('Next text','team'),
            'details'	=> __('Write next text. ex <code>Next »</code>','team'),
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
            'title'		=> __('Background color','team'),
            'details'	=> __('Choose background color.','team'),
            'type'		=> 'colorpicker',
            'value'		=> $pagination_background_color,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'active_background_color',
            'css_id'		=> 'pagination_active_background_color',
            'parent' => 'team_options[pagination]',
            'title'		=> __('Active background color','team'),
            'details'	=> __('Choose active background color.','team'),
            'type'		=> 'colorpicker',
            'value'		=> $pagination_active_background_color,
            'default'		=> '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'		=> 'on_top',
            'parent'		=> 'team_options[pagination]',
            'title'		=> __('Pagination on top','team'),
            'details'	=> __('Display pagination on top.','team'),
            'type'		=> 'select',
            'value'		=> $pagination_on_top,
            'default'		=> 'no',
            'args'		=> array(
                'yes'=>__('Yes','team'),
                'no'=>__('No','team'),
            ),
        );

        $settings_tabs_field->generate_field($args, $post_id);




        ?>
    </div>
    <?php


}







add_action('team_metabox_content_help_support', 'team_metabox_content_help_support');

if(!function_exists('team_metabox_content_help_support')) {
    function team_metabox_content_help_support($tab){

        $settings_tabs_field = new settings_tabs_field();

        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Get support', 'team'); ?></div>
            <p class="description section-description"><?php echo __('Use following to get help and support from our expert team.', 'team'); ?></p>

            <?php


            ob_start();
            ?>

            <p><?php echo __('Ask question for free on our forum and get quick reply from our expert team members.', 'team'); ?></p>
            <a class="button" href="https://www.pickplugins.com/create-support-ticket/"><?php echo __('Create support ticket', 'team'); ?></a>

            <p><?php echo __('Read our documentation before asking your question.', 'team'); ?></p>
            <a class="button" href="https://www.pickplugins.com/documentation/team/"><?php echo __('Documentation', 'team'); ?></a>

            <p><?php echo __('Watch video tutorials.', 'team'); ?></p>
            <a class="button" href="https://www.youtube.com/playlist?list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy"><i class="fab fa-youtube"></i> <?php echo __('All tutorials', 'team'); ?></a>

            <ul>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=SOe0D-Og3nQ&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=1">How to install plugin & setup</a></li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=zdaRmH_KGCI&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=2">How to create team showcase</a></li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=T2LyT-K4TF8&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=3">Display team showcase slider</a> [pro]</li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=zcWP-rB1xG0&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=4">Create filterable style grid</a> [pro]</li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=HjrePb90ToA&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=5">Add custom filter</a> [pro]</li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=8AWlEOLmgA4&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=6">Create glossary grid</a> [pro]</li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=n1aiPFL7QoM&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=7">Team showcase masonry style</a></li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=zDGM9KQxQbg&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=8">Team showcase pagination</a></li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=0YBEhSOXSeI&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=9">Team showcase customize layouts</a></li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=A5ARR__VimA&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=10">Query team members ids</a> [pro]</li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=TtwkAKgYG-M&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=11">Customize team member page</a></li>
            </ul>



            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'get_support',
                //'parent'		=> '',
                'title'		=> __('Ask question','team'),
                'details'	=> '',
                'type'		=> 'custom_html',
                'html'		=> $html,

            );

            $settings_tabs_field->generate_field($args);


            ob_start();
            ?>

            <p class="">We wish your 2 minutes to write your feedback about the team plugin. give us <span style="color: #ffae19"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>

            <a target="_blank" href="https://wordpress.org/plugins/team/#reviews" class="button"><i class="fab fa-wordpress"></i> Write a review</a>


            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'reviews',
                //'parent'		=> '',
                'title'		=> __('Submit reviews','team'),
                'details'	=> '',
                'type'		=> 'custom_html',
                'html'		=> $html,

            );

            $settings_tabs_field->generate_field($args);

            ?>


        </div>
        <?php


    }
}




add_action('team_metabox_content_buy_pro', 'team_metabox_content_buy_pro');

if(!function_exists('team_metabox_content_buy_pro')) {
    function team_metabox_content_buy_pro($tab){

        $settings_tabs_field = new settings_tabs_field();


        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Get Premium', 'team'); ?></div>
            <p class="description section-description"><?php echo __('Thanks for using our plugin, if you looking for some advance feature please buy premium version.', 'team'); ?></p>

            <?php


            ob_start();
            ?>

            <p><?php echo __('If you love our plugin and want more feature please consider to buy pro version.', 'team'); ?></p>
            <a class="button" href="https://www.pickplugins.com/item/team-responsive-meet-the-team-grid-for-wordpress/?ref=dashobard"><?php echo __('Buy premium', 'team'); ?></a>

            <h2><?php echo __('See the differences','team'); ?></h2>

            <table class="pro-features">

                <thead>
                <tr>
                    <th class="col-features"><?php echo __('Features','team'); ?></th>
                    <th class="col-free"><?php echo __('Free','team'); ?></th>
                    <th class="col-pro"><?php echo __('Premium','team'); ?></th>
                </tr>
                </thead>

                <tr>
                    <td class="col-features"><?php echo __('View type - Slider','team'); ?> <a href="https://www.pickplugins.com/demo/team/slider/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('View type - Filterable','team'); ?> <a href="https://www.pickplugins.com/demo/team/filterable/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('View type - Glossary','team'); ?> <a href="https://www.pickplugins.com/demo/team/glossary-custom-index/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Access to layout library(30+ ready layout)','team'); ?> <a href="https://www.pickplugins.com/demo/team/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Query by team members id','team'); ?></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Pagination type - jQuery','team'); ?> <a href="https://www.pickplugins.com/demo/team/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Pagination type - Ajax','team'); ?> <a href="https://www.pickplugins.com/demo/team/ajax-pagination/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Pagination type - Load more','team'); ?> <a href="https://www.pickplugins.com/demo/team/load-more/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Layout element - Skill','team'); ?> <a href="https://www.pickplugins.com/demo/team/skill-bars/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Team members link to - Popup box','team'); ?></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Team members link to - Popup slider','team'); ?></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Team members custom class','team'); ?></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('View type - Grid','team'); ?> <a href="https://www.pickplugins.com/demo/team/view-type-grid/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Masonry style grid','team'); ?> <a href="https://www.pickplugins.com/demo/team/masonry/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Item custom width','team'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Item margin','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Item text align','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Container style','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Layout builder','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Layout element - Wrapper start','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Layout element - Wrapper end','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Layout element - Thumbnail','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Layout element - Title','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Layout element - Position','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Layout element - Content','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Layout element - Social','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Layout element - Meta fields','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Pagination type - Normal','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Hide Pagination','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Custom CSS','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Custom JS','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>



                <tr>
                    <td class="col-features"><?php echo __('Hide featured image(Team member page)','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Hide post title(Team member page)','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Custom team member slug','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Custom meta fields','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Custom social fields','team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <th class="col-features"><?php echo __('Features','team'); ?></th>
                    <th class="col-free"><?php echo __('Free','team'); ?></th>
                    <th class="col-pro"><?php echo __('Premium','team'); ?></th>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Buy now','team'); ?></td>
                    <td> </td>
                    <td><a class="button" href="https://www.pickplugins.com/item/team-responsive-meet-the-team-grid-for-wordpress/?ref=dashobard"><?php echo __('Buy premium', 'team'); ?></a></td>
                </tr>


            </table>



            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'get_pro',
//                'parent'		=> 'related_post_settings',
                'title'		=> __('Get pro version','team'),
                'details'	=> '',
                'type'		=> 'custom_html',
                'html'		=> $html,

            );

            $settings_tabs_field->generate_field($args);


            ?>


        </div>

        <style type="text/css">
            .pro-features{
                margin: 30px 0;
                border-collapse: collapse;
                border: 1px solid #ddd;
            }
            .pro-features th{
                width: 120px;
                background: #ddd;
                padding: 10px;
            }
            .pro-features tr{
            }
            .pro-features td{
                border-bottom: 1px solid #ddd;
                padding: 10px 10px;
                text-align: center;
            }
            .pro-features .col-features{
                width: 230px;
                text-align: left;
            }

            .pro-features .col-free{
            }
            .pro-features .col-pro{
            }

            .pro-features i.fas.fa-check {
                color: #139e3e;
                font-size: 16px;
            }
            .pro-features i.fas.fa-times {
                color: #f00;
                font-size: 17px;
            }
        </style>
        <?php


    }
}







add_action('team_meta_box_save_team','team_meta_box_save_team');

function team_meta_box_save_team($job_id){

    $team_options = isset($_POST['team_options']) ? stripslashes_deep($_POST['team_options']) : '';
    update_post_meta($job_id, 'team_options', $team_options);


//    $job_bm_total_vacancies = isset($_POST['job_bm_total_vacancies']) ? sanitize_text_field($_POST['job_bm_total_vacancies']) : '';
//    update_post_meta($job_id, 'job_bm_total_vacancies', $job_bm_total_vacancies);


}

