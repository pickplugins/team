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
    $grid_item_layout = get_post_meta( $team_id, 'grid_item_layout', true );



    ?>
    <div class="item skin <?php echo team_term_slug_list($team_member_id); ?> <?php echo $team_themes; ?>">

        <?php

        foreach ($grid_item_layout as $elementGroupIndex => $elementGroupData){
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
    $team_items_thumb_size = get_post_meta( $team_id, 'team_items_thumb_size', true );

    $team_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $team_items_thumb_size );
    $team_thumb_url = $team_thumb['0'];


    ?>
    <div class="team-title "><a href="<?php echo get_permalink($team_member_id); ?>"><img src="<?php echo $team_thumb_url; ?>" /></a></div>

    <?php

}






add_action('team_showcase_item_elements_position', 'team_showcase_item_elements_position');


function team_showcase_item_elements_position($args){

    //echo '<pre>'.var_export($args, true).'</pre>';
    $team_member_id = isset($args['team_member_id']) ? $args['team_member_id'] : '';
    $elementData = isset($args['elementData']) ? $args['elementData'] : array();

    $team_member_position = get_post_meta($team_member_id,'team_member_position', true);

    ?>
    <div class="team-title "><?php echo $team_member_position; ?></div>
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
    <div class="team-title "><?php echo $content_html; ?></div>
    <?php

}





