<?php

/*
* @Author 		pickplugins
* Copyright: 	2016 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	


class class_team_shortcodes  {
	
	
    public function __construct(){
		
		add_shortcode( 'team', array( $this, 'team_display' ) );
		add_shortcode( 'team_pickplugins', array( $this, 'team_display' ) ); // To avoid Conflict

        add_shortcode( 'team_new', array( $this, 'team_new_display' ) );

		//add_shortcode( 'team_single', array( $this, 'team_single_display' ) );


    }
	
	public function team_display($atts, $content = null ){

        $atts = shortcode_atts(
            array(
                'id' => "",

                ), $atts);

        $post_id = $atts['id'];

		ob_start();
		include( team_plugin_dir . 'templates/team/team.php');
		return ob_get_clean();

	}


    public function team_new_display($atts, $content = null ){

        $atts = shortcode_atts(
            array(
                'id' => "",

            ), $atts);

        $post_id = $atts['id'];

        ob_start();
        include( team_plugin_dir . 'templates/team-new/team.php');
        return ob_get_clean();

    }







}


new class_team_shortcodes();

