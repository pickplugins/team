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


				?>
				<div class="team-thumb">
				<?php

			//$html.= '';
			
			if($team_items_link_to_post == 'yes')
				{
				$html_thumb.= '<a href="'.get_permalink(get_the_ID()).'"><img src="'.$team_thumb_url.'" /></a>';
				}
			else if($team_items_link_to_post == 'custom')
				{
					if(!empty($team_member_link_to_post))
						{
						$html_thumb.= '<a href="'.$team_member_link_to_post.'"><img src="'.$team_thumb_url.'" /></a>';
						}
					else
						{
						$html_thumb.= '<a href="#"><img src="'.$team_thumb_url.'" /></a>';
						}
					
				}
				
			else if($team_items_link_to_post == 'popup')
				{
				$html_thumb.= '<img teamid="'.get_the_ID().'" class="team-popup" src="'.$team_thumb_url.'" />';
					
				}	
				
			else if($team_items_link_to_post == 'popup_slider')
				{
				$html_thumb.= '<a href="#'.get_the_ID().'"><img team_id="'.$post_id.'" class="team-popup-slider" src="'.$team_thumb_url.'" /></a>';
					
				}				
							
				
			else
				{
				$html_thumb.= '<img src="'.$team_thumb_url.'" />';
				}
			
			echo apply_filters( 'team_grid_filter_thumbnail', $html_thumb );

			?>
				</div>
			<?php



			}
