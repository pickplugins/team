<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	


class team_class_settings  {
	
	
    public function __construct()
    {
		
		
		//$this->settings_page = new Team_Settings();
		
		
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );

    }
	
	
	public function admin_menu() {

        $team_plugin_info = get_option('team_plugin_info');
        $team_settings_upgrade = isset($team_plugin_info['settings_upgrade']) ? $team_plugin_info['settings_upgrade'] : '';
        $team_member_upgrade = isset($team_plugin_info['team_member_upgrade']) ? $team_plugin_info['team_member_upgrade'] : '';

        add_submenu_page( 'edit.php?post_type=team', __( 'Settings', 'team' ), __( 'Settings', 'team' ), 'manage_options', 'settings', array( $this, 'settings' ) );


        //if($team_settings_upgrade != 'done'){
            add_submenu_page( 'edit.php?post_type=team', __( 'Update - Settings', 'team' ), __( 'Update - Settings', 'team' ), 'manage_options', 'update_settings', array( $this, 'update_settings' ) );

        //}





	}
	
	public function settings(){
		
		//include( 'menu/settings-old.php' );
        include( 'menu/settings.php' );

    }


    public function update_settings(){

        //include( 'menu/settings-old.php' );
        include( 'menu/update-settings.php' );

    }

    public function team_member_upgrade(){

        //include( 'menu/settings-old.php' );
        include( 'menu/team-member-upgrade.php' );

    }
	

}


new team_class_settings();

