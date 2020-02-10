<?php
if ( ! defined('ABSPATH')) exit;  // if direct access



add_shortcode('update_team_data', 'update_team_data');


function update_team_data(){

    $team_options = array();

    $args = array(
        'post_type'=>'team',
        'post_status'=>'any',
        'posts_per_page'=> -1,

    );



    $wp_query = new WP_Query($args);


    if ( $wp_query->have_posts() ) :
        while ( $wp_query->have_posts() ) : $wp_query->the_post();

            $team_id = get_the_id();
            $team_options = array();

            echo get_the_title().'<br/>';



            $team_themes = get_post_meta( $team_id, 'team_themes', true );
            $team_items_link_to_post = get_post_meta( $team_id, 'team_items_link_to_post', true );


            $team_items_max_width = get_post_meta( $team_id, 'team_items_max_width', true );
            $team_options['item_width']['large'] = $team_items_max_width;

            $team_items_width_tablet = get_post_meta( $team_id, 'team_items_width_tablet', true );
            $team_options['item_width']['medium'] = $team_items_width_tablet;

            $team_items_width_mobile = get_post_meta( $team_id, 'team_items_width_mobile', true );
            $team_options['item_width']['small'] = $team_items_width_mobile;

            $team_items_margin = get_post_meta( $team_id, 'team_items_margin', true );
            $team_options['item_margin'] = $team_items_margin;

            $team_item_text_align = get_post_meta( $team_id, 'team_item_text_align', true );
            $team_options['item_text_align'] = $team_item_text_align;


            $team_bg_img = get_post_meta( $team_id, 'team_bg_img', true );
            $team_options['container']['background_img_url'] = $team_bg_img;

            $team_container_bg_color = get_post_meta( $team_id, 'team_container_bg_color', true );
            $team_options['container']['background_color'] = $team_container_bg_color;

            $team_grid_item_align = get_post_meta( $team_id, 'team_grid_item_align', true );
            $team_options['container']['text_align'] = $team_grid_item_align;



            $team_query_orderby = get_post_meta( $team_id, 'team_query_orderby', true );
            $team_options['query']['orderby'] = $team_query_orderby;

            $team_query_orderby_meta_key = get_post_meta( $team_id, 'team_query_orderby_meta_key', true );
            $team_options['query']['orderby_meta_key'] = $team_query_orderby_meta_key;

            $team_query_order = get_post_meta( $team_id, 'team_query_order', true );
            $team_options['query']['order'] = $team_query_order;

            $team_total_items = get_post_meta( $team_id, 'team_total_items', true );
            $team_options['query']['post_per_page'] = $team_total_items;

            $team_taxonomy_terms = get_post_meta( $team_id, 'team_taxonomy_terms', true );
            $team_options['query']['taxonomy_terms'] = $team_taxonomy_terms;


            $team_items_custom_css = get_post_meta( $team_id, 'team_items_custom_css', true );
            $team_options['custom_scripts']['custom_css'] = $team_items_custom_css;


            $team_grid_style = get_post_meta( $team_id, 'team_grid_style', true );
            $team_options['view_type'] = $team_grid_style;

            $team_masonry_enable = get_post_meta( $team_id, 'team_masonry_enable', true );
            $team_options['masonry_enable'] = $team_masonry_enable;

            $team_pagination_type = get_post_meta( $team_id, 'team_pagination_type', true );
            $team_options['pagination']['type'] = $team_pagination_type;

            $team_pagination_prev_text = get_post_meta( $team_id, 'team_pagination_prev_text', true );
            $team_options['pagination']['prev_text'] = $team_pagination_prev_text;

            $team_pagination_next_text = get_post_meta( $team_id, 'team_pagination_next_text', true );
            $team_options['pagination']['next_text'] = $team_pagination_next_text;

            $team_pagination_bg_color = get_post_meta( $team_id, 'team_pagination_bg_color', true );
            $team_options['pagination']['background_color'] = $team_pagination_bg_color;

            $team_pagination_active_bg_color = get_post_meta( $team_id, 'team_pagination_active_bg_color', true );
            $team_options['pagination']['active_background_color'] = $team_pagination_active_bg_color;

            $team_grid_items = get_post_meta( $team_id, 'team_grid_items', true );
            unset($team_grid_items['popup']);
            unset($team_grid_items['skill']);
            unset($team_grid_items['meta']);

            $team_options['grid_items'] = $team_grid_items;

            $team_grid_items_hide = get_post_meta( $team_id, 'team_grid_items_hide', true );
            unset($team_grid_items_hide['popup']);
            unset($team_grid_items_hide['skill']);
            unset($team_grid_items_hide['meta']);


            $team_options['items_hide'] = $team_grid_items_hide;




            // Slider Options
            //$team_options['slider_column_desktop'] = $team_column_number;





        ?>
            <pre><?php echo var_export($team_options, true); ?></pre>
        <?php




            wp_reset_query();
            wp_reset_postdata();
        endwhile;
    endif;


}



		
		
		
		

		
		