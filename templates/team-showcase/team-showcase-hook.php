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
        ?>
        <div class="team-items">
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
    <div class="item skin <?php echo team_term_slug_list($team_member_id); ?> <?php echo $team_themes; ?>">

        <?php

        foreach ($layout_elements_data as $elementGroupIndex => $elementGroupData){
            foreach ($elementGroupData as $elementIndex => $elementData){

                $args['team_member_id'] = $team_member_id;
                $args['elementData'] = $elementData;


                //echo $elementIndex;
                do_action('team_showcase_item_elements_'.$elementIndex, $args);
            }
        }

        ?>

    </div>
    <?php

}




add_action('team_showcase_main', 'team_showcase_main_custom_css');

function team_showcase_main_custom_css($args){

    $team_id = isset($args['team_id']) ? $args['team_id'] : '';

    $team_container_bg_color = get_post_meta( $team_id, 'team_container_bg_color', true );
    $team_bg_img = get_post_meta( $team_id, 'team_bg_img', true );
    $team_grid_item_align = get_post_meta( $team_id, 'team_grid_item_align', true );
    $team_item_text_align = get_post_meta( $team_id, 'team_item_text_align', true );
    $team_items_margin = get_post_meta( $team_id, 'team_items_margin', true );
    $team_items_max_width = get_post_meta( $team_id, 'team_items_max_width', true );

    $team_items_width_tablet = get_post_meta( $team_id, 'team_items_width_tablet', true );
    $team_items_width_mobile = get_post_meta( $team_id, 'team_items_width_mobile', true );


    ?>
    <style type="text/css">
        #team-<?php echo $team_id; ?>{
            background: <?php echo $team_container_bg_color; ?> url(<?php echo $team_bg_img; ?>) repeat scroll 0 0;
            text-align: <?php echo $team_grid_item_align; ?>;
        }

        #team-<?php echo $team_id; ?> .item{
            text-align: <?php echo $team_item_text_align; ?>;
            margin: <?php echo $team_items_margin; ?>;
        }

        @media only screen and ( min-width: 0px ) and ( max-width: 767px ) {
            #team-<?php echo $team_id; ?> .item{width: <?php echo $team_items_width_mobile; ?>}
        }

        @media only screen and ( min-width: 768px ) and ( max-width: 1023px ) {
            #team-<?php echo $team_id; ?> .item{width: <?php echo $team_items_width_tablet; ?>}
        }

        @media only screen and (min-width: 1024px ) {
            #team-<?php echo $team_id; ?> .item{width: <?php echo $team_items_max_width; ?>}
        }

    </style>
    <?php
}










add_action('team_showcase_item_elements_title', 'team_showcase_item_elements_title');
function team_showcase_item_elements_title($args){

    //echo '<pre>'.var_export($args, true).'</pre>';
    $team_member_id = isset($args['team_member_id']) ? $args['team_member_id'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();

    ?>
    <div class="team-title "><?php echo get_the_title($team_member_id); ?></div>
    <?php

}



add_action('team_showcase_item_elements_thumbnail', 'team_showcase_item_elements_thumbnail');


function team_showcase_item_elements_thumbnail($args){

    //echo '<pre>'.var_export($args, true).'</pre>';
    $team_id = isset($args['team_id']) ? $args['team_id'] : '';
    $team_member_id = isset($args['team_member_id']) ? $args['team_member_id'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();

    $thumb_size = isset($args['thumb_size']) ? $args['thumb_size'] : 'full';

    $team_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $thumb_size );
    $team_thumb_url = $team_thumb['0'];


    ?>
    <div class="team-thumb "><a href="<?php echo get_permalink($team_member_id); ?>"><img src="<?php echo $team_thumb_url; ?>" /></a></div>

    <?php

}






add_action('team_showcase_item_elements_position', 'team_showcase_item_elements_position');


function team_showcase_item_elements_position($args){

    //echo '<pre>'.var_export($args, true).'</pre>';
    $team_member_id = isset($args['team_member_id']) ? $args['team_member_id'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();

    $team_member_position = get_post_meta($team_member_id,'team_member_position', true);

    ?>
    <div class="team-position "><?php echo $team_member_position; ?></div>
    <?php

}


add_action('team_showcase_item_elements_content', 'team_showcase_item_elements_content');


function team_showcase_item_elements_content($args){

    //echo '<pre>'.var_export($args, true).'</pre>';

    $team_id = isset($args['team_id']) ? $args['team_id'] : '';
    $team_member_id = isset($args['team_member_id']) ? $args['team_member_id'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();
    $content = get_the_content($team_member_id);
    $team_items_content = get_post_meta( $team_id, 'team_items_content', true );
    $team_items_link_to_post = get_post_meta( $team_id, 'team_items_link_to_post', true );
    $team_items_excerpt_count = (int)get_post_meta( $team_id, 'team_items_excerpt_count', true );
    $team_items_excerpt_text = get_post_meta( $team_id, 'team_items_excerpt_text', true );

    $content_html = '';

    if($team_items_content=='full'){
        $content_html.= do_shortcode($content);
    }
    elseif($team_items_content=='excerpt'){

        if($team_items_link_to_post == 'yes'){
            $content_html.= wp_trim_words( $content , $team_items_excerpt_count, ' <a  class="read-more"  href="'. get_permalink() .'">'.$team_items_excerpt_text.'</a>' );
        }
        else{
            $content_html.= wp_trim_words( $content , $team_items_excerpt_count, ' <a class="read-more" href="'. get_permalink() .'">'.$team_items_excerpt_text.'</a>' );
        }
    }else{
        $content_html.= wp_trim_words( $content , $team_items_excerpt_count, ' <a class="read-more" href="'. get_permalink() .'">'.$team_items_excerpt_text.'</a>' );
    }


    ?>
    <div class="team-content"><?php echo $content_html; ?></div>
    <?php

}



add_action('team_showcase_item_elements_wrapper_start', 'team_showcase_item_elements_wrapper_start');
function team_showcase_item_elements_wrapper_start($args){

    //echo '<pre>'.var_export($args, true).'</pre>';
    $team_member_id = isset($args['team_member_id']) ? $args['team_member_id'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();
    $wrapper_class = isset($elementData['wrapper_class']) ? $elementData['wrapper_class'] : '';
    $wrapper_id = isset($elementData['wrapper_id']) ? $elementData['wrapper_id'] : '';



    ?>
    <div class="<?php echo $wrapper_class; ?>" id="<?php echo $wrapper_id; ?>">
    <?php

}


add_action('team_showcase_item_elements_wrapper_end', 'team_showcase_item_elements_wrapper_end');
function team_showcase_item_elements_wrapper_end($args){

    //echo '<pre>'.var_export($args, true).'</pre>';
    $team_member_id = isset($args['team_member_id']) ? $args['team_member_id'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();

    ?>
    </div>
    <?php

}