<?php
/*
* @Author 		ParaTheme
* @Folder	 	Team/Templates
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


		if(!empty($team_thumb_url))
			{
				$html_thumb = '';
				
			$html.= '<div class="team-thumb">';
			
			if($team_items_link_to_post == 'yes')
				{
				$html_thumb.= '<a href="'.get_permalink(get_the_ID()).'"><img src="'.$team_thumb_url.'" /></a>';
				}

			else
				{
				$html_thumb.= '<img src="'.$team_thumb_url.'" />';
				}
			
			$html .= apply_filters( 'team_grid_filter_thumbnail', $html_thumb );
			$html.= '</div>';
			}
