<?php

/*
* @Author 		ParaTheme
* @Folder	 	Team/Includes
* @version   	3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit; // if direct access 

class class_team_version_update  {
	
	
    public function __construct(){
		
		//add_shortcode( 'team', array( $this, 'team_display' ) );
		//add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );
    	//add_action('admin_menu', array($this, 'create_menu'));
    }
	
	public function team_member_meta_update(){
		
		$team_version = get_option('team_version');
		


		}
	
	
	
	public function team_options_update(){
		
		$team_version = get_option('team_version');
		$team_member_social_field = get_option( 'team_member_social_field' );
		
		
		if(empty($team_member_social_field))
			{
				$team_member_social_field =		array(
													"facebook"=>"facebook",						
													"twitter"=>"twitter",						
													"googleplus"=>"googleplus",
													"pinterest"=>"pinterest",												
													);	
			}
			
		$team_member_social_field_new_field =array(
													"website"=>"website",						
													"email"=>"email",						
													"skype"=>"skype"
													);
		
		
		$team_member_social_field = array_merge($team_member_social_field,$team_member_social_field_new_field);
		update_option('team_member_social_field', $team_member_social_field);

		}
		
		
		
	public function team_update_by_version_3_0_5(){
			
			
			
			delete_option( 'team_themes_list' );
			
			
		}	
		
	
	
}

new class_team_version_update();