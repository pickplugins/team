<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 





//add_action( 'team_action_single_team_member_main', 'team_action_single_team_member_main_title', 0 );
//add_action( 'team_action_single_team_member_main', 'team_action_single_team_member_main_thumbnail', 10 );

add_action( 'team_action_single_team_member', 'team_action_single_team_member_main_position', 10 );
add_action( 'team_action_single_team_member', 'team_action_single_team_member_main_social', 10 );
//add_action( 'team_action_single_team_member', 'team_action_single_team_member_main_skill', 10 );
add_action( 'team_action_single_team_member', 'team_action_single_team_member_meta', 10 );
add_action( 'team_action_single_team_member', 'team_action_single_team_member_main_content', 20 );





if ( ! function_exists( 'team_action_single_team_member_main_title' ) ) {

	
	function team_action_single_team_member_main_title() {

		include( team_plugin_dir. 'templates/single-team/title.php');
	}
}


if ( ! function_exists( 'team_action_single_team_member_main_thumbnail' ) ) {

	
	function team_action_single_team_member_main_thumbnail() {

		include( team_plugin_dir. 'templates/single-team/thumbnail.php');
	}
}


if ( ! function_exists( 'team_action_single_team_member_main_position' ) ) {

	
	function team_action_single_team_member_main_position() {

		include( team_plugin_dir. 'templates/single-team/position.php');
	}
}


if ( ! function_exists( 'team_action_single_team_member_main_social' ) ) {

	
	function team_action_single_team_member_main_social() {

		include( team_plugin_dir. 'templates/single-team/social.php');
	}
}

if ( ! function_exists( 'team_action_single_team_member_main_skill' ) ) {

	
	function team_action_single_team_member_main_skill() {

		include( team_plugin_dir. 'templates/single-team/skill.php');
	}
}



if ( ! function_exists( 'team_action_single_team_member_main_content' ) ) {

	
	function team_action_single_team_member_main_content() {

		include( team_plugin_dir. 'templates/single-team/content.php');
	}
}


if ( ! function_exists( 'team_action_single_team_member_meta' ) ) {


	function team_action_single_team_member_meta() {

		include( team_plugin_dir. 'templates/single-team/meta.php');
	}
}









