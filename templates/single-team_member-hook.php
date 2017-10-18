<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 





add_action( 'team_action_single_team_member_main', 'team_action_single_team_member_main_title', 0 );
add_action( 'team_action_single_team_member_main', 'team_action_single_team_member_main_thumbnail', 10 );
add_action( 'team_action_single_team_member_main', 'team_action_single_team_member_main_position', 20 );
add_action( 'team_action_single_team_member_main', 'team_action_single_team_member_main_social', 30 );
add_action( 'team_action_single_team_member_main', 'team_action_single_team_member_main_content', 50 );





if ( ! function_exists( 'team_action_single_team_member_main_title' ) ) {

	
	function team_action_single_team_member_main_title() {
				
		require_once( team_plugin_dir. 'templates/single-team_member-title.php');
	}
}


if ( ! function_exists( 'team_action_single_team_member_main_thumbnail' ) ) {

	
	function team_action_single_team_member_main_thumbnail() {
				
		require_once( team_plugin_dir. 'templates/single-team_member-thumbnail.php');
	}
}


if ( ! function_exists( 'team_action_single_team_member_main_position' ) ) {

	
	function team_action_single_team_member_main_position() {
				
		require_once( team_plugin_dir. 'templates/single-team_member-position.php');
	}
}


if ( ! function_exists( 'team_action_single_team_member_main_social' ) ) {

	
	function team_action_single_team_member_main_social() {
				
		require_once( team_plugin_dir. 'templates/single-team_member-social.php');
	}
}





if ( ! function_exists( 'team_action_single_team_member_main_content' ) ) {

	
	function team_action_single_team_member_main_content() {
				
		require_once( team_plugin_dir. 'templates/single-team_member-content.php');
	}
}












