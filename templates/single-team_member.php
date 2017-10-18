<?php
/*
* @Author 		PickPlugins
* Copyright: 	2015 PickPlugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

		get_header();

		do_action('team_action_before_single_team_member');

		while ( have_posts() ) : the_post(); 
		?>
        <div id="team-member-<?php the_ID(); ?>" <?php post_class('team-container team-meamber-single entry-content'); ?>>
        
        
        <?php
			do_action('team_action_single_team_member_main');
		?>
        <div class="clear"></div>
        </div>
		<?php
		endwhile;
		
        do_action('team_action_after_single_team_member');
		
		//get_sidebar( 'content-bottom' );
		get_footer();
		
