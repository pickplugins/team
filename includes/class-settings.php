<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 	


class team_class_settings{
	
	
    public function __construct(){

		add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );

    }
	
	
	public function admin_menu() {

        $team_plugin_info = get_option('team_plugin_info');
        $team_upgrade = isset($team_plugin_info['team_upgrade']) ? $team_plugin_info['team_upgrade'] : '';

        add_submenu_page( 'edit.php?post_type=team', __( 'Settings', 'team' ), __( 'Settings', 'team' ), 'manage_options', 'settings', array( $this, 'settings' ) );


        //if($team_upgrade != 'done'){
            add_submenu_page( 'edit.php?post_type=team', __( 'Upgrade status', 'team' ), __( 'Upgrade status', 'team' ), 'manage_options', 'upgrade_status', array( $this, 'upgrade_status' ) );

        //}





	}
	
	public function settings(){
		
		//include( 'menu/settings-old.php' );
        include( 'menu/settings.php' );

    }


    public function upgrade_status(){
        include( 'menu/upgrade-status.php' );

    }


	

}


new team_class_settings();

