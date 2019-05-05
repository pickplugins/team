<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	
	
	
		if($team_masonry_enable == 'yes' && $team_grid_style=='grid' )
			{

				?>
				<script>
                    jQuery(window).load(function(){   jQuery("#team-<?php echo $post_id; ?> .team-items").masonry({isFitWidth: true}); });

				</script>

				<style type="text/css">

					#team-<?php echo $post_id; ?>.team-items {
						                  margin: 0 auto !important;
					                  }
				</style>

				<?php

			}