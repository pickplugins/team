<?php

/*
* @Author 		ParaTheme
* @Folder	 	Team/Templates
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
		

		$title_text = apply_filters( 'team_grid_filter_title', get_the_title() );		

		if($team_items_link_to_post == 'yes')
			{
			$html.= '<a href="'.get_permalink(get_the_ID()).'"><div class="team-title" style="color:'.$team_items_title_color.';font-size:'.$team_items_title_font_size.'">'.$title_text.'
			</div></a>';
			}
						
		else
			{
			$html.= '<div class="team-title " style="color:'.$team_items_title_color.';font-size:'.$team_items_title_font_size.'">'.$title_text.'</div>';
			}
			
			

