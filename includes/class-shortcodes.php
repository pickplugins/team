<?php

/*
* @Author 		pickplugins
* Copyright: 	2016 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	


class class_team_shortcodes  {
	
	
    public function __construct(){
		
		add_shortcode( 'team', array( $this, 'team_showcase_display' ) );
		add_shortcode( 'team_pickplugins', array( $this, 'team_showcase_display' ) ); // To avoid Conflict
        add_shortcode( 'team_showcase', array( $this, 'team_showcase_display' ) );


    }
    public function team_showcase_display($atts, $content = null ) {
        $atts = shortcode_atts(
            array(
                'id' => "",

            ), $atts);

        $html = '';
        $team_id = isset($atts['id']) ? $atts['id'] : '';

        $args = array('team_id'=> $team_id);

        ob_start();
        ?>
        <div id="team-<?php echo $team_id; ?>" class="team-container">
            <?php
            do_action('team_showcase_main', $args);
            ?>
        </div>
        <?php
        return ob_get_clean();
    }


}


new class_team_shortcodes();

