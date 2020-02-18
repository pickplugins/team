<?php
if ( ! defined('ABSPATH')) exit;  // if direct access
		
add_action('team_showcase_main', 'team_showcase_main_items');

function team_showcase_main_items($args){

    $team_id = isset($args['team_id']) ? $args['team_id'] : '';

    $team_options       = get_post_meta( $team_id, 'team_options', true );
    $query              = isset($team_options['query']) ? $team_options['query'] : '';
    $query_orderby      = isset($query['orderby']) ? $query['orderby'] : '';
    $query_orderby_meta_key = isset($query['orderby_meta_key']) ? $query['orderby_meta_key'] : '';
    $query_order        = isset($query['order']) ? $query['order'] : '';
    $query_post_per_page = isset($query['post_per_page']) ? $query['post_per_page'] : '';
    $query_taxonomy_terms        = isset($query['taxonomy_terms']) ? $query['taxonomy_terms'] : '';

    wp_enqueue_style( 'font-awesome-5' );

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
    $query_args['orderby']  		= $query_orderby;

    if(!empty($query_orderby_meta_key))
    $query_args['meta_key']         = $query_orderby_meta_key;

    $query_args['order']  			= $query_order;
    $query_args['posts_per_page'] 	= $query_post_per_page;
    $query_args['paged']  			= $paged;


    if(!empty($query_taxonomy_terms)){

        $query_args['tax_query']  	= array(
            array(
                'taxonomy' => 'team_group',
                'field' => 'id',
                'terms' => $query_taxonomy_terms,
            )
        );

    }

    $query_args = apply_filters('team_showcase_query_args', $query_args, $team_id);


    $wp_query = new WP_Query($query_args);


    if ( $wp_query->have_posts() ) :

        $team_items_class = apply_filters('team_items_wrapper_class', 'team-items ', $args);

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
        $args['paged'] = $paged;

        do_action('team_showcase_after_items', $wp_query, $args);

        ?>

        <?php
    else:
        do_action('team_showcase_no_item');
    endif;


}






add_action('team_showcase_item', 'team_showcase_item', 10, 2);

function team_showcase_item($args, $team_member_id){

    $team_id = isset($args['team_id']) ? $args['team_id'] : '';

    $args['team_member_id'] = $team_member_id;

    $team_options = get_post_meta( $team_id, 'team_options', true );
    $item_layout_id = isset($team_options['item_layout_id']) ? $team_options['item_layout_id'] : '';
    $layout_elements_data = get_post_meta( $item_layout_id, 'layout_elements_data', true );

    $team_item_class = apply_filters('team_showcase_item_class', 'item ', $args);


    ?>
    <div class="<?php echo $team_item_class; ?>">
        <div class="elements-wrapper layout-<?php echo $item_layout_id; ?>">
            <?php
            if(!empty($layout_elements_data))
            foreach ($layout_elements_data as $elementGroupIndex => $elementGroupData){

                if(!empty($elementGroupData))
                foreach ($elementGroupData as $elementIndex => $elementData){
                    $args['team_member_id'] = $team_member_id;
                    $args['elementData'] = $elementData;
                    $args['element_index'] = $elementGroupIndex;

                    do_action('team_layout_element_'.$elementIndex, $args);
                }
            }
            ?>
        </div>
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

    $item_layout_id = isset($team_options['item_layout_id']) ? $team_options['item_layout_id'] : '';

    $custom_scripts = get_post_meta($item_layout_id,'custom_scripts', true);
    $custom_css = isset($custom_scripts['custom_css']) ? $custom_scripts['custom_css'] : '';
    $custom_js = isset($custom_scripts['custom_js']) ? $custom_scripts['custom_js'] : '';
    $layout_elements_data = get_post_meta( $item_layout_id, 'layout_elements_data', true );


    ?>
    <style type="text/css">
        .team-container {
            width: 100%
        }
        #team-<?php echo $team_id; ?>{
            background: <?php echo $container_background_color; ?> url(<?php echo $container_background_img_url; ?>) repeat scroll 0 0;
            text-align: <?php echo $container_text_align; ?>;
        }
        #team-<?php echo $team_id; ?> .item{
            text-align: <?php echo $item_text_align; ?>;
            margin: <?php echo $item_margin; ?>;
            display: inline-block;
            vertical-align: top;
        }
        #team-<?php echo $team_id; ?> .layer-media .team-thumb {
            overflow: hidden;
        }
        #team-<?php echo $team_id; ?> .layer-media img {
            border-radius: 0;
            box-shadow: none;
            width:100%;
            margin:0;
            padding:0;
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
            do_action('team_layout_element_css_'.$elementIndex, $args);
        }
    }


}



add_action('team_showcase_main', 'team_showcase_main_masonry', 99);

function team_showcase_main_masonry($args){
    $team_id = isset($args['team_id']) ? $args['team_id'] : '';

    $team_options = get_post_meta($team_id, 'team_options', true);
    $view_type = isset($team_options['view_type']) ? $team_options['view_type'] : '';
    $masonry_enable = isset($team_options['masonry_enable']) ? $team_options['masonry_enable'] : 'no';

    if ($view_type != 'grid') return;
    if ($masonry_enable != 'yes') return;

    wp_enqueue_script('masonry');
    wp_enqueue_script('imagesloaded');

    ?>
    <script>
        jQuery('#team-<?php echo $team_id; ?>').ready(function($){

            var $container = $('#team-<?php echo $team_id; ?> .team-items');

            $container.masonry({
                itemSelector: '.item',
                columnWidth: '.item', //as you wish , you can use numeric
                isAnimated: true,
                isFitWidth: true,
                horizontalOrder: true,
            });


            $container.imagesLoaded().done( function() {
                $container.masonry('layout');
            });



        })


    </script>
    <?php

}




add_action('team_showcase_after_items', 'team_showcase_after_items_pagination', 10, 2);

function team_showcase_after_items_pagination($wp_query, $args){
    $team_id = isset($args['team_id']) ? $args['team_id'] : '';
    $paged = isset($args['paged']) ? $args['paged'] : 1;


    $team_options = get_post_meta($team_id, 'team_options', true);
    $view_type = isset($team_options['view_type']) ? $team_options['view_type'] : '';
    $pagination = isset($team_options['pagination']) ? $team_options['pagination'] : '';
    $pagination_type = isset($pagination['type']) ? $pagination['type'] : '';

    if ($view_type != 'grid' ) return;
    if ($pagination_type != 'pagination' ) return;



    $pagination_prev_text = isset($pagination['prev_text']) ? $pagination['prev_text'] : '';
    $pagination_next_text = isset($pagination['next_text']) ? $pagination['next_text'] : '';
    $pagination_background_color = isset($pagination['background_color']) ? $pagination['background_color'] : '';
    $pagination_active_background_color = isset($pagination['active_background_color']) ? $pagination['active_background_color'] : '';

    //var_dump($paged);


    ?>
    <div class="paginate">
        <?php

        $big = 999999999; // need an unlikely integer
        echo paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, $paged ),
            'total' => $wp_query->max_num_pages
        ) );

        ?>
    </div>

    <style type="text/css">

        #team-<?php echo $team_id; ?> .paginate {
            padding: 30px;
            text-align: center;
        }

        #team-<?php echo $team_id; ?> .paginate .page-numbers {
            background-color: <?php echo $pagination_background_color; ?>;
            color: rgb(255, 255, 255);
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            line-height: 1em;
            margin: 3px 0;
            padding: 10px 15px;
            text-decoration: none;
        }

        #team-<?php echo $team_id; ?> .paginate .current{
            background-color: <?php echo $pagination_active_background_color; ?>;
        }


        .popupbox-wrapper{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999999;
            background: #3e3e3ec7;
            height: 100%;
            display: none;
        }
        .popupbox-wrapper .elements-wrapper{
            width: 700px;
            margin: 70px auto;
            padding: 15px;
            background: #fff;
            position: relative;
        }
        .close-popupbox {
            position: absolute;
            top: 0;
            right: 0;
            padding: 3px 10px;
            background: #e42525;
            color: #fff;
            cursor: pointer;
        }


    </style>

    <script>
        jQuery(document).ready(function($){

            $(document).on('click','.team-container a',function(event){
                //event.preventDefault()

                url = $(this).attr('href');
                var hash = url.substr(1);
                $('.'+hash).fadeIn();


                //console.log(url);

            })

            $(document).on('click','.popupbox-wrapper .close-popupbox',function(event){

                $(this).parent().parent().fadeOut();

            })


        })


    </script>


    <?php

}


//add_action('team_showcase_item', 'team_showcase_item_popupbox', 10, 2);

function team_showcase_item_popupbox($args, $team_member_id){

    $team_id = isset($args['team_id']) ? $args['team_id'] : '';

    $args['team_member_id'] = $team_member_id;

    $team_options = get_post_meta( $team_id, 'team_options', true );
    $item_layout_id = isset($team_options['item_layout_id']) ? $team_options['item_layout_id'] : '';
    $layout_elements_data = get_post_meta( $item_layout_id, 'layout_elements_data', true );

    $team_item_class = apply_filters('team_showcase_item_class', 'item ', $args);


    ?>
    <div class="popupbox-wrapper popupbox<?php echo $team_member_id; ?>">
        <div class="elements-wrapper layout-<?php echo $item_layout_id; ?>">
            <span class="close-popupbox"><i class="fas fa-times"></i></span>
            <?php
            if(!empty($layout_elements_data))
                foreach ($layout_elements_data as $elementGroupIndex => $elementGroupData){

                    if(!empty($elementGroupData))
                        foreach ($elementGroupData as $elementIndex => $elementData){
                            $args['team_member_id'] = $team_member_id;
                            $args['elementData'] = $elementData;
                            $args['element_index'] = $elementGroupIndex;

                            do_action('team_layout_element_'.$elementIndex, $args);
                        }
                }
            ?>
        </div>
    </div>














    <?php

}

