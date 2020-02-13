<?php
if ( ! defined('ABSPATH')) exit;  // if direct access
		
add_action('team_showcase_main', 'team_showcase_main_items');

function team_showcase_main_items($args){

    $team_id = isset($args['team_id']) ? $args['team_id'] : '';

    //if(empty($post_id)) return;

    $tax_query = array();

    if ( get_query_var('paged') ) {
        $paged = get_query_var('paged');
    } elseif ( get_query_var('page') ) {
        $paged = get_query_var('page');
    } else {
        $paged = 1;
    }

    $query_args['post_type'] 		= 'team_member';
    $query_args['orderby']  		= get_post_meta( $team_id, 'team_query_orderby', true );;
    //$query_args['meta_key'] = get_post_meta( $team_id, 'team_query_orderby_meta_key', true );
    $query_args['order']  			= get_post_meta( $team_id, 'team_query_order', true );
    $query_args['posts_per_page'] 	= get_post_meta( $team_id, 'team_total_items', true );
    $query_args['paged']  			= $paged;

    $team_taxonomy_terms = get_post_meta( $team_id, 'team_taxonomy_terms', true );

    if(!empty($team_taxonomy_terms)){

        $query_args['tax_query']  	= array(
            array(
                'taxonomy' => 'team_group',
                'field' => 'id',
                'terms' => $team_taxonomy_terms,
            )
        );

    }

    $wp_query = new WP_Query($query_args);


    if ( $wp_query->have_posts() ) :

        $team_items_class = apply_filters('team_items_wrapper_class', 'team-items', $args);

        ?>
        <div class="<?php echo $team_items_class; ?>">
            <?php

            while ( $wp_query->have_posts() ) : $wp_query->the_post();

                $team_member_id = get_the_id();
                //var_dump($team_member_id);
                do_action('team_showcase_item', $args, $team_member_id);

            endwhile;

            ?>
        </div>
        <?php
    else:
        do_action('team_showcase_no_item');
    endif;


}






add_action('team_showcase_item', 'team_showcase_item', 10, 2);

function team_showcase_item($args, $team_member_id){

    $team_id = isset($args['team_id']) ? $args['team_id'] : '';
    $team_themes = get_post_meta( $team_id, 'team_themes', true );
    $team_options = get_post_meta( $team_id, 'team_options', true );
    $item_layout_id = isset($team_options['item_layout_id']) ? $team_options['item_layout_id'] : '';
    $layout_elements_data = get_post_meta( $item_layout_id, 'layout_elements_data', true );


    $grid_item_layout = get_post_meta( $team_id, 'grid_item_layout', true );

    //echo '<pre>'.var_export($layout_elements_data, true).'</pre>';


    ?>
    <div class="item skin <?php echo team_term_slug_list($team_member_id); ?>">

        <?php
        ?>
        <div class="elements-wrapper layout-<?php echo $item_layout_id; ?>">
            <?php

            if(!empty($layout_elements_data))
            foreach ($layout_elements_data as $elementGroupIndex => $elementGroupData){

                if(!empty($elementGroupData))
                foreach ($elementGroupData as $elementIndex => $elementData){




                    $args['team_member_id'] = $team_member_id;
                    $args['elementData'] = $elementData;
                    $args['element_index'] = $elementGroupIndex;

                   // echo '<pre>'.var_export($args, true).'</pre>';

                    //echo $elementIndex;
                    do_action('team_showcase_item_elements_'.$elementIndex, $args);
                }
            }
            ?>
        </div>
        <?php
        ?>

    </div>
    <?php

}




add_action('team_showcase_main', 'team_showcase_main_custom_css');

function team_showcase_main_custom_css($args){

    $team_id = isset($args['team_id']) ? $args['team_id'] : '';

    $team_options = get_post_meta($team_id,'team_options', true);
    $item_width = isset($team_options['item_width']) ? $team_options['item_width'] : array();
    $team_width_large = isset($item_width['large']) ? $item_width['large'] : '';
    $team_width_medium = isset($item_width['medium']) ? $item_width['medium'] : '';
    $team_width_small = isset($item_width['small']) ? $item_width['small'] : '';

    $item_margin = isset($team_options['item_margin']) ? $team_options['item_margin'] : '';
    $item_text_align = isset($team_options['item_text_align']) ? $team_options['item_text_align'] : '';

    $container_background_img_url = isset($team_options['container']['background_img_url']) ? $team_options['container']['background_img_url'] : '';
    $container_background_color = isset($team_options['container']['background_color']) ? $team_options['container']['background_color'] : '';
    $container_text_align = isset($team_options['container']['text_align']) ? $team_options['container']['text_align'] : '';



    $team_container_bg_color = get_post_meta( $team_id, 'team_container_bg_color', true );
    $team_bg_img = get_post_meta( $team_id, 'team_bg_img', true );
    $team_grid_item_align = get_post_meta( $team_id, 'team_grid_item_align', true );
    $team_item_text_align = get_post_meta( $team_id, 'team_item_text_align', true );
    $team_items_margin = get_post_meta( $team_id, 'team_items_margin', true );
    $team_items_max_width = get_post_meta( $team_id, 'team_items_max_width', true );

    $team_items_width_tablet = get_post_meta( $team_id, 'team_items_width_tablet', true );
    $team_items_width_mobile = get_post_meta( $team_id, 'team_items_width_mobile', true );

    $team_options = get_post_meta( $team_id, 'team_options', true );
    $item_layout_id = isset($team_options['item_layout_id']) ? $team_options['item_layout_id'] : '';

    $custom_scripts = get_post_meta($item_layout_id,'custom_scripts', true);
    $custom_css = isset($custom_scripts['custom_css']) ? $custom_scripts['custom_css'] : '';
    $custom_js = isset($custom_scripts['custom_js']) ? $custom_scripts['custom_js'] : '';
    $layout_elements_data = get_post_meta( $item_layout_id, 'layout_elements_data', true );


    ?>
    <style type="text/css">
        #team-<?php echo $team_id; ?>{
            background: <?php echo $container_background_color; ?> url(<?php echo $container_background_img_url; ?>) repeat scroll 0 0;
            text-align: <?php echo $container_text_align; ?>;
        }

        #team-<?php echo $team_id; ?> .item{
            text-align: <?php echo $item_text_align; ?>;
            margin: <?php echo $item_margin; ?>;

        }

        @media only screen and ( min-width: 0px ) and ( max-width: 767px ) {
            #team-<?php echo $team_id; ?> .item{width: <?php echo $team_width_small; ?>}
        }

        @media only screen and ( min-width: 768px ) and ( max-width: 1023px ) {
            #team-<?php echo $team_id; ?> .item{width: <?php echo $team_width_medium; ?>}
        }

        @media only screen and (min-width: 1024px ) {
            #team-<?php echo $team_id; ?> .item{width: <?php echo $team_width_large; ?>}
        }

        <?php

        echo str_replace('__ID__', 'layout-'.$item_layout_id, $custom_css);

        ?>

    </style>

    <?php

    if(!empty($layout_elements_data))
    foreach ($layout_elements_data as $elementGroupIndex => $elementGroupData){

        if(!empty($elementGroupData))
        foreach ($elementGroupData as $elementIndex => $elementData){


            $args['elementData'] = $elementData;
            $args['element_index'] = $elementGroupIndex;

            //echo $elementIndex;
            do_action('team_showcase_item_elements_css_'.$elementIndex, $args);
        }
    }


}










add_action('team_showcase_item_elements_title', 'team_showcase_item_elements_title');
function team_showcase_item_elements_title($args){

    //echo '<pre>'.var_export($args, true).'</pre>';
    $team_member_id = isset($args['team_member_id']) ? $args['team_member_id'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();
    $element_index = isset($args['element_index']) ? $args['element_index'] : '';


    $element_class = !empty($element_index) ? 'element-'.$element_index : '';

    ?>
    <div class="team-title <?php echo $element_class; ?>"><?php echo get_the_title($team_member_id); ?></div>
    <?php

}



add_action('team_showcase_item_elements_thumbnail', 'team_showcase_item_elements_thumbnail');


function team_showcase_item_elements_thumbnail($args){

    $element_index = isset($args['element_index']) ? $args['element_index'] : '';
    $element_class = !empty($element_index) ? 'element-'.$element_index : '';

    //echo '<pre>'.var_export($args, true).'</pre>';
    $team_id = isset($args['team_id']) ? $args['team_id'] : '';
    $team_member_id = isset($args['team_member_id']) ? $args['team_member_id'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();


    $team_member_data = get_post_meta($team_member_id,'team_member_data', true);
    $member_image_id = isset($team_member_data['member_image']) ? $team_member_data['member_image'] : '';
    $member_image_url = wp_get_attachment_url( $member_image_id, 'full' );

    ?>
    <div class="team-thumb <?php echo $element_class; ?>"><a href="<?php echo get_permalink($team_member_id); ?>"><img src="<?php echo $member_image_url; ?>" /></a></div>

    <?php

}






add_action('team_showcase_item_elements_position', 'team_showcase_item_elements_position');


function team_showcase_item_elements_position($args){

    $element_index = isset($args['element_index']) ? $args['element_index'] : '';
    $element_class = !empty($element_index) ? 'element-'.$element_index : '';

    //echo '<pre>'.var_export($args, true).'</pre>';
    $team_member_id = isset($args['team_member_id']) ? $args['team_member_id'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();

    $team_member_position = get_post_meta($team_member_id,'position', true);

    ?>
    <div class="team-position <?php echo $element_class; ?>"><?php echo $team_member_position; ?></div>
    <?php

}


add_action('team_showcase_item_elements_content', 'team_showcase_item_elements_content');


function team_showcase_item_elements_content($args){

    $element_index = isset($args['element_index']) ? $args['element_index'] : '';
    $element_class = !empty($element_index) ? 'element-'.$element_index : '';

    //echo '<pre>'.var_export($args, true).'</pre>';

    $team_id = isset($args['team_id']) ? $args['team_id'] : '';
    $team_member_id = isset($args['team_member_id']) ? $args['team_member_id'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();
    $content_source = isset($elementData['content_source']) ? $elementData['content_source'] : 'excerpt';
    $read_more_text = isset($elementData['read_more_text']) ? $elementData['read_more_text'] : 'excerpt';
    $word_count = isset($elementData['word_count']) ? $elementData['word_count'] : '';

    $post_data= get_post($team_member_id);

    $content = isset($post_data->post_content) ? $post_data->post_content : '';

    $content_html = '';

    if($content_source=='full'){
        $content_html.= do_shortcode($content);
    }
    elseif($content_source=='excerpt'){

        $content_html.= wp_trim_words( $content , $word_count, ' <a class="read-more" href="'. get_permalink() .'">'.$read_more_text.'</a>' );
    }else{
        $content_html.= wp_trim_words( $content , $word_count, ' <a class="read-more" href="'. get_permalink() .'">'.$read_more_text.'</a>' );
    }


    ?>
    <div class="team-content <?php echo $element_class; ?>"><?php echo $content_html; ?></div>
    <?php

}



add_action('team_showcase_item_elements_wrapper_start', 'team_showcase_item_elements_wrapper_start');
function team_showcase_item_elements_wrapper_start($args){

    $element_index = isset($args['element_index']) ? $args['element_index'] : '';
    $element_class = !empty($element_index) ? 'element-'.$element_index : '';

    //echo '<pre>'.var_export($args, true).'</pre>';
    $team_member_id = isset($args['team_member_id']) ? $args['team_member_id'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();
    $wrapper_class = isset($elementData['wrapper_class']) ? $elementData['wrapper_class'] : '';
    $wrapper_id = isset($elementData['wrapper_id']) ? $elementData['wrapper_id'] : '';



    ?>
    <div class="<?php echo $wrapper_class; ?> <?php echo $element_class; ?>" id="<?php echo $wrapper_id; ?>">
    <?php

}


add_action('team_showcase_item_elements_wrapper_end', 'team_showcase_item_elements_wrapper_end');
function team_showcase_item_elements_wrapper_end($args){

//    $element_index = isset($args['element_index']) ? $args['element_index'] : '';
//    $element_class = !empty($element_index) ? 'element-'.$element_index : '';

    //echo '<pre>'.var_export($args, true).'</pre>';
    $team_member_id = isset($args['team_member_id']) ? $args['team_member_id'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();

    ?>
    </div>
    <?php

}



add_action('team_showcase_item_elements_css_title', 'team_showcase_item_elements_css_title');
function team_showcase_item_elements_css_title($args){

    //echo '<pre>'.var_export($args, true).'</pre>';
    $element_index = isset($args['element_index']) ? $args['element_index'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();

    $color = isset($elementData['color']) ? $elementData['color'] : '';
    $font_size = isset($elementData['font_size']) ? $elementData['font_size'] : '';
    $font_family = isset($elementData['font_family']) ? $elementData['font_family'] : '';


    ?>
    <style type="text/css">
        .element-<?php echo $element_index; ?>{
            color: <?php echo $color; ?>;
            font-size: <?php echo $font_size; ?>;
            font-family: <?php echo $font_family; ?>;
        }
    </style>
    <?php
}



add_action('team_showcase_item_elements_css_position', 'team_showcase_item_elements_css_position');
function team_showcase_item_elements_css_position($args){

    //echo '<pre>'.var_export($args, true).'</pre>';
    $element_index = isset($args['element_index']) ? $args['element_index'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();

    $color = isset($elementData['color']) ? $elementData['color'] : '';
    $font_size = isset($elementData['font_size']) ? $elementData['font_size'] : '';
    $font_family = isset($elementData['font_family']) ? $elementData['font_family'] : '';


    ?>
    <style type="text/css">
        .element-<?php echo $element_index; ?>{
            color: <?php echo $color; ?>;
            font-size: <?php echo $font_size; ?>;
            font-family: <?php echo $font_family; ?>;
        }
    </style>
    <?php
}

add_action('team_showcase_item_elements_css_content', 'team_showcase_item_elements_css_content');
function team_showcase_item_elements_css_content($args){

    //echo '<pre>'.var_export($args, true).'</pre>';
    $element_index = isset($args['element_index']) ? $args['element_index'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();
    $read_more_color = isset($elementData['read_more_color']) ? $elementData['read_more_color'] : '';

    $color = isset($elementData['color']) ? $elementData['color'] : '';
    $font_size = isset($elementData['font_size']) ? $elementData['font_size'] : '';
    $font_family = isset($elementData['font_family']) ? $elementData['font_family'] : '';


    ?>
    <style type="text/css">
        .element-<?php echo $element_index; ?>{
            color: <?php echo $color; ?>;
            font-size: <?php echo $font_size; ?>;
            font-family: <?php echo $font_family; ?>;
        }

        .element-<?php echo $element_index; ?> a{
            color: <?php echo $read_more_color; ?>;

        }

    </style>
    <?php
}



add_action('team_showcase_item_elements_css_thumbnail', 'team_showcase_item_elements_css_thumbnail');
function team_showcase_item_elements_css_thumbnail($args){

    //echo '<pre>'.var_export($args, true).'</pre>';
    $element_index = isset($args['element_index']) ? $args['element_index'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();

    $thumb_height = isset($elementData['thumb_height']) ? $elementData['thumb_height'] : '';
    $thumb_height_large = isset($thumb_height['large']) ? $thumb_height['large'] : '';
    $thumb_height_medium = isset($thumb_height['medium']) ? $thumb_height['medium'] : '';
    $thumb_height_small = isset($thumb_height['small']) ? $thumb_height['small'] : '';



    ?>
    <style type="text/css">

        .element-<?php echo $element_index; ?>{
            overflow: hidden;
        }

        @media only screen and (min-width: 1024px ){
            .element-<?php echo $element_index; ?>{
                <?php if(!empty($thumb_height_large)): ?>
                max-height: <?php echo $thumb_height_large; ?>;
                <?php endif; ?>
            }
        }

        @media only screen and ( min-width: 768px ) and ( max-width: 1023px ) {
            .element-<?php echo $element_index; ?>{
                <?php if(!empty($thumb_height_medium)): ?>
                max-height: <?php echo $thumb_height_medium; ?>;
                <?php endif; ?>
            }
        }

        @media only screen and ( min-width: 0px ) and ( max-width: 767px ){
            .element-<?php echo $element_index; ?>{
                <?php if(!empty($thumb_height_small)): ?>
                max-height: <?php echo $thumb_height_small; ?>;
                <?php endif; ?>
            }
        }



    </style>
    <?php
}







