<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

class class_team_post_meta_team{
	
	public function __construct(){

		//meta box action for "team"
		add_action('add_meta_boxes', array($this, 'team_post_meta_team'));
		add_action('save_post', array($this, 'meta_boxes_team_save'));



		}


	public function team_post_meta_team($post_type){

            add_meta_box('metabox-team-data',__('Team data', 'team'), array($this, 'meta_box_team_data'), 'team', 'normal', 'high');

		}






	public function meta_box_team_data($post) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field('team_nonce_check', 'team_nonce_check_value');
 
        // Use get_post_meta to retrieve an existing value from the database.
       // $team_data = get_post_meta($post -> ID, 'team_data', true);

        $post_id = $post->ID;



        $settings_tabs_field = new settings_tabs_field();

        $team_settings_tab = array();
        $team_options = get_post_meta($post_id,'team_options', true);
        $current_tab = isset($team_options['current_tab']) ? $team_options['current_tab'] : 'query_member';


        $team_settings_tab[] = array(
            'id' => 'shortcodes',
            'title' => sprintf(__('%s Shortcodes','team'),'<i class="fas fa-code"></i>'),
            'priority' => 1,
            'active' => ($current_tab == 'shortcodes') ? true : false,
        );

        $team_settings_tab[] = array(
            'id' => 'style',
            'title' => sprintf(__('%s Style','team'),'<i class="far fa-building"></i>'),
            'priority' => 2,
            'active' => ($current_tab == 'style') ? true : false,
        );

        $team_settings_tab[] = array(
            'id' => 'query_member',
            'title' => sprintf(__('%s Query Member','team'),'<i class="fas fa-users"></i>'),
            'priority' => 3,
            'active' => ($current_tab == 'query_member') ? true : false,
        );

        $team_settings_tab[] = array(
            'id' => 'layouts',
            'title' => sprintf(__('%s Layouts','team'),'<i class="fas fa-qrcode"></i>'),
            'priority' => 4,
            'active' => ($current_tab == 'layouts') ? true : false,
        );

        $team_settings_tab[] = array(
            'id' => 'masonry',
            'title' => sprintf(__('%s Masonry','team'),'<i class="fas fa-grip-vertical"></i>'),
            'priority' => 4,
            'active' => ($current_tab == 'masonry') ? true : false,
        );

        $team_settings_tab[] = array(
            'id' => 'pagination',
            'title' => sprintf(__('%s Pagination','team'),'<i class="fas fa-ellipsis-h"></i>'),
            'priority' => 4,
            'active' => ($current_tab == 'pagination') ? true : false,
        );


        $team_settings_tab[] = array(
            'id' => 'custom_scripts',
            'title' => sprintf(__('%s Custom scripts','team'),'<i class="far fa-building"></i>'),
            'priority' => 5,
            'active' => ($current_tab == 'custom_scripts') ? true : false,
        );



        $team_settings_tab = apply_filters('team_metabox_navs', $team_settings_tab);

        $tabs_sorted = array();

        if(!empty($team_settings_tab))
        foreach ($team_settings_tab as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
        array_multisort($tabs_sorted, SORT_ASC, $team_settings_tab);

        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script('jquery-ui-accordion');

        wp_enqueue_style( 'jquery-ui');
        wp_enqueue_style( 'font-awesome-5' );
        wp_enqueue_style( 'settings-tabs' );
        wp_enqueue_script( 'settings-tabs' );


        //$team_options = get_post_meta($post_id,'team_options', true);
        //echo '<pre>'.var_export($team_options, true).'</pre>';
        $team_options = get_post_meta($post_id,'team_options', true);
        $view_type = isset($team_options['view_type']) ? $team_options['view_type'] : 'grid';

		?>



        <div class="settings-tabs vertical">
            <input class="current_tab" type="hidden" name="team_options[current_tab]" value="<?php echo $current_tab; ?>">
            <div class="view-types">

                <?php

                $team_view_types = apply_filters('team_view_types', array('grid'=>'Grid'));

                $args = array(
                    'id'		=> 'view_type',
                    'parent'		=> 'team_options',
                    'title'		=> __('View type','team'),
                    'details'	=> '',
                    'type'		=> 'radio',
                    'value'		=> $view_type,
                    'default'		=> '',
                    'args'		=> $team_view_types,
                );

                $settings_tabs_field->generate_field($args);

                ?>
            </div>


            <ul class="tab-navs">
                <?php
                foreach ($team_settings_tab as $tab){
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
            foreach ($team_settings_tab as $tab){
                $id = $tab['id'];
                $title = $tab['title'];
                $active = $tab['active'];
                ?>

                <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">
                    <?php
                    do_action('team_metabox_content_'.$id, $post_id);
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="clear clearfix"></div>

        <?php






        //do_action('team_metabox_team_data', $post);


   		}




	public function meta_boxes_team_save($post_id){

        /*
         * We need to verify this came from the our screen and with
         * proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if (!isset($_POST['team_nonce_check_value']))
            return $post_id;

        $nonce = $_POST['team_nonce_check_value'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'team_nonce_check'))
            return $post_id;

        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {

            if (!current_user_can('edit_page', $post_id))
                return $post_id;

        } else {

            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }

        /* OK, its safe for us to save the data now. */

        do_action('team_meta_box_save_team', $post_id);


					
		}
	
	}


new class_team_post_meta_team();