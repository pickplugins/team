<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	
	
	
		if($team_masonry_enable == 'yes' && $team_grid_style=='grid' ){
				$html .= '<script>
								jQuery(window).load(function(){   jQuery("#team-'.$post_id.' .team-items").masonry({isFitWidth: true}); });
	
					</script>';		

				// masonry css to center align
				$html .= '<style type="text/css">
				
						#team-'.$post_id.'.team-items {
						  margin: 0 auto !important;
						}
						</style>
						';
			}