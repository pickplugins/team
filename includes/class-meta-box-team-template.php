<?php

if ( ! defined('ABSPATH')) exit;  // if direct access




/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function meta_boxes_team_template(){

    $screens = array( 'team_template' );
    global $post;
    $post_id = $post->ID;




    foreach ( $screens as $screen ){
        add_meta_box('team_template_metabox_new',__('Team Options', 'post-grid'),'meta_boxes_team_template_input', $screen);
    }



}
add_action( 'add_meta_boxes', 'meta_boxes_team_template' );





function meta_boxes_team_template_input( $post ) {

    global $post;
    wp_nonce_field( 'meta_boxes_team_template_input', 'meta_boxes_team_template_input_nonce' );

    $post_id = $post->ID;
    $team_options = get_post_meta($post_id, 'team_options', true);

    $view_type =     $post_types = !empty($team_options['view_type']) ? $team_options['view_type'] : 'grid';

    $team_settings_tab = array();


    $team_settings_tab[] = array(
        'id' => 'layout',
        'title' => sprintf(__('%s Layout','related-post'),'<i class="fas fa-list-ul"></i>'),
        'priority' => 1,
        'active' =>  true,
    );


    $team_settings_tabs = apply_filters('team_template_settings_tabs', $team_settings_tab);


    $tabs_sorted = array();
    foreach ($team_settings_tabs as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
    array_multisort($tabs_sorted, SORT_ASC, $team_settings_tabs);




    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-sortable');
    wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script('jquery-ui-accordion');
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_style('font-awesome-5');
    wp_enqueue_style('settings-tabs');
    wp_enqueue_script('settings-tabs');


    ?>

    <div class="post-grid-meta-box">


        <div class="settings-tabs-loading" style="">Loading...</div>
        <div class="settings-tabs vertical">
            <ul class="tab-navs">
                <?php
                foreach ($team_settings_tabs as $tab){
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
            foreach ($team_settings_tabs as $tab){
                $id = $tab['id'];
                $title = $tab['title'];
                $active = $tab['active'];


                ?>

                <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">
                    <?php
                    do_action('team_template_settings_tabs_content_'.$id, $tab, $post_id);
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



function meta_boxes_team_template_save( $post_id ) {

    /*
     * We need to verify this came from the our screen and with proper authorization,
     * because save_post can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['meta_boxes_team_template_input_nonce'] ) )
        return $post_id;

    $nonce = $_POST['meta_boxes_team_template_input_nonce'];

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'meta_boxes_team_template_input' ) )
        return $post_id;

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;



    /* OK, its safe for us to save the data now. */

    // Sanitize user input.
    //$team_collapsible = sanitize_text_field( $_POST['team_collapsible'] );


    $team_template_options = stripslashes_deep( $_POST['team_template_options'] );
    update_post_meta( $post_id, 'team_template_options', $team_template_options );





}
add_action( 'save_post', 'meta_boxes_team_template_save' );


