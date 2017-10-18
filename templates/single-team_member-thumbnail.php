<?php

/*
* @Author 		ParaTheme
* @Folder	 	Team/Templates
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
		

	$team_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
	$team_thumb_url = $team_thumb['0'];
	
	$thumb_html = apply_filters( 'team_filter_team_member_thumbnail', '<img src="'.$team_thumb_url.'" />' );

?>
	<div class="team-thumb"><?php echo $thumb_html; ?></div>

	