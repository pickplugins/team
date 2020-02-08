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
		add_submenu_page( 'edit.php?post_type=team', __( 'Settings', 'team' ), __( 'Settings', 'team' ), 'manage_options', 'settings', array( $this, 'settings' ) );

	}
	
	public function settings(){
		
		include( 'menu/settings.php' );	
		
		}
	

	
	

}


new team_class_settings();

