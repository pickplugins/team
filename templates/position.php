<?php
/*
* @Author 		ParaTheme
* @Folder	 	Team/Templates
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



			
			if(!empty($team_member_position))
				{
					$html.= '<div class="team-position" style="color:'.$team_items_position_color.';font-size:'.$team_items_position_font_size.'">';

					$html .= apply_filters( 'team_grid_filter_position', $team_member_position );		

					$html.= '</div>';					
					
					
					
				}