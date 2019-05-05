<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


function testimonial_posttype_register() {
 
        $labels = array(
                'name' => _x('Testimonial', 'testimonial'),
                'singular_name' => _x('Testimonial', 'testimonial'),
                'add_new' => _x('New Testimonial', 'testimonial'),
                'add_new_item' => __('New Testimonial'),
                'edit_item' => __('Edit Testimonial'),
                'new_item' => __('New Testimonial'),
                'view_item' => __('View Testimonial'),
                'search_items' => __('Search Testimonial'),
                'not_found' =>  __('Nothing found'),
                'not_found_in_trash' => __('Nothing found in Trash'),
                'parent_item_colon' => ''
        );
 
        $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'menu_icon' => null,
                'rewrite' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title'),
				'menu_icon' => 'dashicons-star-half',
				
          );
 
        register_post_type( 'testimonial' , $args );




}

add_action('init', 'testimonial_posttype_register');




$testimonial_data_update = get_option('testimonial_data_update');


if($testimonial_data_update != 'yes'){
    function testimonial_showcase_posttype_register() {

        $labels = array(
            'name' => _x('Testimonial showcase', 'testimonial_sc'),
            'singular_name' => _x('Testimonial showcase', 'testimonial_sc'),
            'add_new' => _x('New Testimonial showcase', 'testimonial_sc'),
            'add_new_item' => __('New Testimonial showcase'),
            'edit_item' => __('Edit Testimonial showcase'),
            'new_item' => __('New Testimonial showcase'),
            'view_item' => __('View Testimonial showcase'),
            'search_items' => __('Search Testimonial showcase'),
            'not_found' =>  __('Nothing found'),
            'not_found_in_trash' => __('Nothing found in Trash'),
            'parent_item_colon' => ''
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            'menu_icon' => null,
            'rewrite' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array('title'),
            'menu_icon' => 'dashicons-groups',

        );

        register_post_type( 'testimonial_showcase' , $args );

    }

    add_action('init', 'testimonial_showcase_posttype_register');

}


















































/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function meta_boxes_testimonial(){

    $screens = array( 'testimonial' );
    global $post;
    $post_id = $post->ID;




    foreach ( $screens as $screen ){
        add_meta_box('testimonial_metabox',__('Testimonial Options', 'testimonial'),'meta_boxes_testimonial_input', $screen);
        //add_meta_box('testimonial_metabox_side',__('Post Grid Information', 'testimonial'),'meta_boxes_testimonial_side', $screen,'side');
        //add_meta_box('testimonial_metabox_side',__('Testimonial Information', 'testimonial'),'meta_boxes_testimonial_side', $screen,'side');

    }



}
add_action( 'add_meta_boxes', 'meta_boxes_testimonial' );



function meta_boxes_testimonial_input( $post ) {

    global $post;
    wp_nonce_field( 'meta_boxes_testimonial_input', 'meta_boxes_testimonial_input_nonce' );

    $post_id = $post->ID;
    $team_options = get_post_meta($post_id, 'team_options', true);
    $grid_type = !empty($team_options['grid_type']) ? $team_options['grid_type'] : 'grid';

    $testimonial_settings_tab = array();


    $testimonial_settings_tab[] = array(
        'id' => 'shortcode',
        'title' => __('<i class="fas fa-laptop-code"></i> Shortcode','testimonial'),
        'priority' => 1,
        'active' => false,
    );

    $testimonial_settings_tab[] = array(
        'id' => 'templates',
        'title' => __('<i class="fas fa-palette"></i> Templates','testimonial'),
        'priority' => 2,
        'active' => false,
    );

    $testimonial_settings_tab[] = array(
        'id' => 'team_members',
        'title' => __('<i class="fas fa-users"></i> Team Members','testimonial'),
        'priority' => 2,
        'active' => true,
    );

    $testimonial_settings_tab[] = array(
        'id' => 'slider_settings',
        'title' => __('<i class="fas fa-map"></i> Slider Settings','testimonial'),
        'priority' => 3,
        'active' => false,
        'data_visible' => 'slider',
        'hidden' => ($grid_type == 'slider')? false : true ,
    );

    $testimonial_settings_tab[] = array(
        'id' => 'filterable',
        'title' => __('<i class="fas fa-th-large"></i> Filterable','testimonial'),
        'priority' => 4,
        'active' => false,
        'data_visible' => 'filterable',
        'hidden' => ($grid_type == 'filterable')? false : true ,
    );

    $testimonial_settings_tab[] = array(
        'id' => 'grid',
        'title' => __('<i class="fas fa-th-large"></i> Grid','testimonial'),
        'priority' => 4,
        'active' => false,
        'data_visible' => 'grid',
        'hidden' => ($grid_type == 'grid')? false : true ,
    );


    $testimonial_settings_tab[] = array(
        'id' => 'pagination',
        'title' => __('<i class="fas fa-th-large"></i> Pagination','testimonial'),
        'priority' => 4,
        'active' => false,
        'data_visible' => 'grid filterable',
    );

    $testimonial_settings_tab[] = array(
        'id' => 'masonry',
        'title' => __('<i class="fas fa-th-large"></i> Masonry','testimonial'),
        'priority' => 4,
        'active' => false,
        'data_visible' => 'grid filterable',
    );



//    $testimonial_settings_tab[] = array(
//        'id' => 'custom_scripts',
//        'title' => __('<i class="far fa-file-code"></i> Custom CSS','testimonial'),
//        'priority' => 6,
//        'active' => false,
//    );




    $testimonial_settings_tabs = apply_filters('testimonial_settings_tabs', $testimonial_settings_tab);


    $tabs_sorted = array();
    foreach ($testimonial_settings_tabs as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
    array_multisort($tabs_sorted, SORT_ASC, $testimonial_settings_tabs);







    ?>

    <div class="testimonial-meta-box">
        <div class="grid-type-wrap">
            <span>View Type: </span>
            <label>
                <input name="team_options[grid_type]" <?php if($grid_type == 'grid') echo 'checked'; ?>  type="radio" value="grid">Normal grid
            </label>

            <label title="Only in pro">
                <input  name="team_options[grid_type]" <?php if($grid_type == 'filterable') echo 'checked'; ?> type="radio" value="filterable">Filterable
            </label>


            <label title="Only in pro">
                <input  name="team_options[grid_type]" <?php if($grid_type == 'slider') echo 'checked'; ?> type="radio" value="slider">Slider
            </label>


        </div>

        <div class="settings-tabs vertical">
            <ul class="tab-navs">
                <?php
                foreach ($testimonial_settings_tabs as $tab){
                    $id = $tab['id'];
                    $title = $tab['title'];
                    $active = $tab['active'];
                    $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                    $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;

                    ?>
                    <li <?php if(!empty($data_visible)):  ?> data_visible="<?php echo $data_visible; ?>" <?php endif; ?> class="tab-nav <?php if($hidden) echo 'hidden'; ?> <?php if($active) echo 'active';?>" data-id="<?php echo $id; ?>"><?php echo $title; ?></li>
                    <?php
                }
                ?>
            </ul>
            <?php
            foreach ($testimonial_settings_tabs as $tab){
                $id = $tab['id'];
                $title = $tab['title'];
                $active = $tab['active'];


                ?>

                <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">
                    <?php
                    do_action('testimonial_meta_tabs_content_'.$id, $tab, $post_id);
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="clear clearfix"></div>

    </div>





    <script>

        jQuery(document).ready(function($){

            $(document).on('click', '.testimonial-meta-box .grid-type-wrap input[name="team_options[grid_type]"]', function(){
                var val = $(this).val();

                $('.testimonial-meta-box .tab-navs li').each(function( index ) {
                    data_visible = $( this ).attr('data_visible');

                    if(typeof data_visible != 'undefined'){
                        //console.log('undefined '+ data_visible );

                        n = data_visible.indexOf(val);
                        if(n<0){
                            $( this ).hide();
                        }else{
                            $( this ).show();
                        }
                    }else{
                        //console.log('Not undefined '+ data_visible );


                    }
                });


            })






        });

    </script>





    <?php



}



function meta_boxes_testimonial_side( $post ) {

    ?>
    <div class="post-grid-meta-box">

        <ul>
            <li>Version: <?php echo testimonial_version; ?></li>
            <li>Tested WP: 5.1</li>
            <li>
                <?php

                if(testimonial_customer_type=="free"){

                    //echo 'You are using <strong> '.testimonial_customer_type.' version  '.testimonial_version.'</strong> of <strong>'.testimonial_plugin_name.'</strong>, To get more feature you could try our premium version. ';
                    //echo '<br /><a class="button" href="'.testimonial_pro_url.'?ref=dashboard">Buy now</a>';

                }
                else{

                    ?>
                    <p>Thanks for using <strong> premium version</strong></p>
                    <?php


                }

                ?>
            </li>
        </ul>

        <h3>Documentation</h3>
        <a class="button" href="https://www.pickplugins.com/documentation/testimonial/?ref=dashboard" target="_blank">Documentation</a><p class="description">Before asking, submitting reviews please take a look on our documentation, may help your issue fast.</p>

        <h3>Looking for support?</h3>
        <a class="button" href="https://www.pickplugins.com/forum/?ref=dashboard" target="_blank">Create Ticket</a><p class="description">Its free and you can ask any question about our plugins and get support fast.</p>


        <h3>Provide your feedback</h3>

        <a class="button" href="https://wordpress.org/support/plugin/testimonial/reviews/?filter=5" target="_blank">Submit Reviews</a> <a class="button" href="https://wordpress.org/support/plugin/testimonial/#new-topic-0" target="_blank">Ask wordpress.org</a><p>We spent thousand+ hours to development on this plugin, please submit your reviews wisely.</p><p>If you have any issue with this plugin please submit our forums or contact our support first.</p><p class="description">Your feedback and reviews are most important things to keep our development on track. If you have time please submit us five star <a href="https://wordpress.org/support/plugin/testimonial/reviews/?filter=5"> <span style="color: orange"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></a> reviews.</p>




        <?php
        $class_testimonial_support = new class_testimonial_support();

        ?>



        <?php
        $video_tutorials =  $class_testimonial_support->faq();
        if(!empty($video_tutorials)):
            ?>
            <div class="faq">
                <h3>FAQ</h3>
                <ul>
                    <?php
                    foreach($video_tutorials as $item){
                        ?>
                        <li class="item">
                            <a target="_blank" href="<?php echo $item['url']; ?>"><i class="fa fa-question"></i> <?php echo $item['title']; ?></a>

                        </li>
                        <?php
                    }

                    ?>
                </ul>
            </div>
        <?php

        endif;
        ?>



        <?php
        $video_tutorials =  $class_testimonial_support->video_tutorials();
        if(!empty($video_tutorials)):
            ?>
            <div class="video-tutorials">
                <h3>Video Tutorials</h3>
                <ul>
                    <?php
                    foreach($video_tutorials as $item){
                        ?>
                        <li class="item">
                            <a target="_blank" href="<?php echo $item['video_url']; ?>"><i class="far fa-dot-circle"></i> <?php echo $item['title']; ?></a>

                        </li>
                        <?php
                    }

                    ?>
                </ul>
            </div>
        <?php

        endif;
        ?>











    </div>
    <?php

}





/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */



function meta_boxes_testimonial_save( $post_id ) {

    /*
     * We need to verify this came from the our screen and with proper authorization,
     * because save_post can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['meta_boxes_testimonial_input_nonce'] ) )
        return $post_id;

    $nonce = $_POST['meta_boxes_testimonial_input_nonce'];

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'meta_boxes_testimonial_input' ) )
        return $post_id;

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;



    /* OK, its safe for us to save the data now. */

    // Sanitize user input.
    //$testimonial_collapsible = sanitize_text_field( $_POST['testimonial_collapsible'] );





    /* OK, its safe for us to save the data now. */

    // Sanitize user input.
    $team_options =  $_POST['team_options'] ;


    // Update the meta field in the database.
    update_post_meta( $post_id, 'team_options', $team_options );



}
add_action( 'save_post', 'meta_boxes_testimonial_save' );




