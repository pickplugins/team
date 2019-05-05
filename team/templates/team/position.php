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
					?>
					<div class="team-position" style="color:<?php echo $team_items_position_color; ?>;font-size:<?php echo $team_items_position_font_size; ?>">
						<?php

						echo apply_filters( 'team_grid_filter_position', $team_member_position );

						?>
					</div>
					<?php




				}