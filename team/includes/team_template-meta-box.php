<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


function testimonial_template_posttype_register() {



    $labels = array(
        'name' => _x('Templates', 'testimonial'),
        'singular_name' => _x('Templates', 'testimonial'),
        'add_new' => _x('New Templates', 'testimonial'),
        'add_new_item' => __('New Templates'),
        'edit_item' => __('Edit Templates'),
        'new_item' => __('New Templates'),
        'view_item' => __('View Templates'),
        'search_items' => __('Search Templates'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => null,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','thumbnail'),
        'show_in_menu' 	=> 'edit.php?post_type=testimonial',
        'menu_icon' => 'dashicons-media-spreadsheet',

    );

    register_post_type( 'testimonial_template' , $args );








}

add_action('init', 'testimonial_template_posttype_register');


/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function meta_boxes_testimonial_template(){

    $screens = array( 'testimonial_template' );
    global $post;
    $post_id = $post->ID;




    foreach ( $screens as $screen ){
        add_meta_box('testimonial_template_metabox',__('Template Options', 'testimonial'),'meta_boxes_testimonial_template_input', $screen);
        //add_meta_box('testimonial_template_metabox_side',__('Post Grid Information', 'testimonial'),'meta_boxes_testimonial_template_side', $screen,'side');
        //add_meta_box('testimonial_template_metabox_side',__('PickPlugins WooCommerce Products Slider Information', 'testimonial'),'meta_boxes_testimonial_template_side', $screen,'side');

    }



}
add_action( 'add_meta_boxes', 'meta_boxes_testimonial_template' );



function meta_boxes_testimonial_template_input( $post ) {

    global $post;
    wp_nonce_field( 'meta_boxes_testimonial_template_input', 'meta_boxes_testimonial_template_input_nonce' );

    $post_id = $post->ID;


    $testimonial_settings_tab = array();



    $testimonial_settings_tab[] = array(
        'id' => 'templates',
        'title' => __('<i class="fas fa-palette"></i> Edit Template','testimonial'),
        'priority' => 2,
        'active' => true,
    );


    $testimonial_settings_tabs = apply_filters('testimonial_settings_tabs', $testimonial_settings_tab);


    $tabs_sorted = array();
    foreach ($testimonial_settings_tabs as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
    array_multisort($tabs_sorted, SORT_ASC, $testimonial_settings_tabs);







    ?>

    <div class="testimonial_template-meta-box">
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
                    <li <?php if(!empty($data_visible)):  ?> data_visible="<?php echo $data_visible; ?>" <?php endif; ?> class="tab-nav <?php if($hidden) echo 'hidden';?> <?php if($active) echo 'active';?>" data-id="<?php echo $id; ?>"><?php echo $title; ?></li>
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
                    do_action('testimonial_template_meta_tabs_content_'.$id, $tab, $post_id);
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="clear clearfix"></div>

    </div>










    <?php



}






/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */



function meta_boxes_testimonial_template_save( $post_id ) {

    /*
     * We need to verify this came from the our screen and with proper authorization,
     * because save_post can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['meta_boxes_testimonial_template_input_nonce'] ) )
        return $post_id;

    $nonce = $_POST['meta_boxes_testimonial_template_input_nonce'];

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'meta_boxes_testimonial_template_input' ) )
        return $post_id;

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;



    /* OK, its safe for us to save the data now. */

    // Sanitize user input.
    //$testimonial_template_collapsible = sanitize_text_field( $_POST['testimonial_template_collapsible'] );





    /* OK, its safe for us to save the data now. */

    // Sanitize user input.
    $team_options = ( $_POST['team_options'] );


    // Update the meta field in the database.
    update_post_meta( $post_id, 'team_options', $team_options );



}
add_action( 'save_post', 'meta_boxes_testimonial_template_save' );




