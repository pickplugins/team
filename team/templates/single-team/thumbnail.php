<?php
/*
* @Author 		ParaTheme
* @Folder	 	Team/Templates
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$team_member_display_thumbnail = get_option('team_member_display_thumbnail','no');

if($team_member_display_thumbnail == 'yes'){

	$team_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

	if(!empty($team_thumb['0']))
	{
		$team_thumb_url = $team_thumb['0'];
		$html_thumb = '';


		?>
        <div class="team-thumb">
			<?php

			//$html.= '';

			$html_thumb.= '<img src="'.$team_thumb_url.'" />';

			echo apply_filters( 'team_filter_team_member_thumbnail', $html_thumb );

			?>
        </div>
		<?php

	}

}


