<?php

if ( ! defined('ABSPATH')) exit;  // if direct access




/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function meta_boxes_team(){

    $screens = array( 'team' );
    global $post;
    $post_id = $post->ID;




    foreach ( $screens as $screen ){
        add_meta_box('team_metabox_new',__('Team Options', 'post-grid'),'meta_boxes_team_input', $screen);
        add_meta_box('team_metabox_side',__('Team Information', 'post-grid'),'meta_boxes_team_side', $screen,'side');
    }



}
add_action( 'add_meta_boxes', 'meta_boxes_team' );





function meta_boxes_team_input( $post ) {

    global $post;
    wp_nonce_field( 'meta_boxes_team_input', 'meta_boxes_team_input_nonce' );

    $post_id = $post->ID;
    $team_options = get_post_meta($post_id, 'team_options', true);

    $view_type =     $post_types = !empty($team_options['view_type']) ? $team_options['view_type'] : 'grid';

    $team_settings_tab = array();


    $team_settings_tab[] = array(
        'id' => 'shortcode',
        'title' => sprintf(__('%s Shortcode','related-post'),'<i class="fas fa-list-ul"></i>'),
        'priority' => 1,
        'active' =>  false,
    );


    $team_settings_tab[] = array(
        'id' => 'style',
        'title' => sprintf(__('%s Style','related-post'),'<i class="fas fa-list-ul"></i>'),
        'priority' => 2,
        'active' =>  true,
    );

    $team_settings_tab[] = array(
        'id' => 'team_members',
        'title' => sprintf(__('%s Team member','related-post'),'<i class="fas fa-list-ul"></i>'),
        'priority' => 3,
        'active' =>  false,
    );

    $team_settings_tab[] = array(
        'id' => 'layouts',
        'title' => sprintf(__('%s Layouts','related-post'),'<i class="fas fa-list-ul"></i>'),
        'priority' => 4,
        'active' =>  false,
    );

    $team_settings_tab[] = array(
        'id' => 'slider',
        'title' => sprintf(__('%s Slider','related-post'),'<i class="fas fa-list-ul"></i>'),
        'priority' => 5,
        'active' =>  false,
    );

    $team_settings_tab[] = array(
        'id' => 'filterable',
        'title' => sprintf(__('%s Filterable','related-post'),'<i class="fas fa-list-ul"></i>'),
        'priority' => 5,
        'active' =>  false,
    );
    $team_settings_tab[] = array(
        'id' => 'pagination',
        'title' => sprintf(__('%s Pagination','related-post'),'<i class="fas fa-list-ul"></i>'),
        'priority' => 5,
        'active' =>  false,
    );

    $team_settings_tab[] = array(
        'id' => 'masonry',
        'title' => sprintf(__('%s Masonry','related-post'),'<i class="fas fa-list-ul"></i>'),
        'priority' => 5,
        'active' =>  false,
    );


    $team_settings_tab[] = array(
        'id' => 'custom_scripts',
        'title' => sprintf(__('%s Custom scripts','related-post'),'<i class="fas fa-list-ul"></i>'),
        'priority' => 10,
        'active' =>  false,
    );

    $team_settings_tabs = apply_filters('team_settings_tabs', $team_settings_tab);


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

        <div class="grid-type-wrap">
            <span>Grid Type: </span>
            <label>
                <input name="team_options[view_type]" <?php if($view_type == 'grid') echo 'checked'; ?>  type="radio" value="grid">Normal grid
            </label>

            <label>
                <input name="team_options[view_type]" <?php if($view_type == 'filterable') echo 'checked'; ?> type="radio" value="filterable">Filterable
            </label>
            <label>
                <input name="team_options[view_type]" <?php if($view_type == 'slider') echo 'checked'; ?> type="radio" value="slider">Slider
            </label>
            <label>
                <input name="team_options[view_type]" <?php if($view_type == 'glossary') echo 'checked'; ?> type="radio" value="glossary">Glossary
            </label>
        </div>

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
                    do_action('team_settings_tabs_content_'.$id, $tab, $post_id);
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



function meta_boxes_team_side( $post ) {

    ?>
    <div class="post-grid-meta-box">

        <ul>
            <li>Post Grid Version: <?php echo team_version; ?></li>
            <li>Tested WP: 5.1</li>
            <li>Thanks for using <strong> premium version</strong></li>
        </ul>


        <h3>Documentation</h3>
        <a class="button" href="https://www.pickplugins.com/documentation/post-grid/?ref=dashboard" target="_blank">Documentation</a><p class="description">Before asking, submitting reviews please take a look on our documentation, may help your issue fast.</p>

        <h3>Looking for support?</h3>
        <a class="button" href="https://www.pickplugins.com/forum/?ref=dashboard" target="_blank">Create Support Ticket</a><p class="description">Its free and you can ask any question about our plugins and get support fast.</p>

        <h3>Provide your feedback</h3>

        <a class="button" href="https://wordpress.org/support/plugin/post-grid/reviews/?filter=5" target="_blank">Submit Reviews</a> <a class="button" href="https://wordpress.org/support/plugin/post-grid/#new-topic-0" target="_blank">Ask wordpress.org</a><p>We spent thousand+ hours to development on this plugin, please submit your reviews wisely.</p><p>If you have any issue with this plugin please submit our forums or contact our support first.</p><p class="description">Your feedback and reviews are most important things to keep our development on track. If you have time please submit us five star <a href="https://wordpress.org/support/plugin/post-grid/reviews/?filter=5"><span style="color: orange"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></a> reviews.</p>




    </div>
    <?php

}








/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */



function meta_boxes_team_save( $post_id ) {

    /*
     * We need to verify this came from the our screen and with proper authorization,
     * because save_post can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['meta_boxes_team_input_nonce'] ) )
        return $post_id;

    $nonce = $_POST['meta_boxes_team_input_nonce'];

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $nonce, 'meta_boxes_team_input' ) )
        return $post_id;

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;



    /* OK, its safe for us to save the data now. */

    // Sanitize user input.
    //$team_collapsible = sanitize_text_field( $_POST['team_collapsible'] );


    $team_options = stripslashes_deep( $_POST['team_options'] );
    update_post_meta( $post_id, 'team_options', $team_options );





}
add_action( 'save_post', 'meta_boxes_team_save' );



