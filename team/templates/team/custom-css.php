<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



?>
	<style type="text/css">

		#team-<?php echo $post_id; ?>{
			background: <?php echo $team_container_bg_color; ?> <?php if(!empty($team_bg_img)):?> url(<?php echo $team_bg_img; ?>) <?php endif;?> repeat scroll 0 0;
			text-align:<?php echo $team_grid_item_align; ?>;
		}
		#team-<?php echo $post_id; ?> .item{

			                   text-align:<?php echo $team_item_text_align; ?>;
			                   margin:<?php echo $team_items_margin; ?>;
		                   }

		@media only screen and (min-width: 1024px ) {

        <?php if($team_grid_style=='slider'):  ?>


        <?php elseif ($team_grid_style=='grid' || $team_grid_style=='filterable') :?>
            #team-<?php echo $post_id; ?> .item{width:<?php echo $team_items_max_width; ?>}
        <?php endif;?>
		}

		@media only screen and ( min-width: 768px ) and ( max-width: 1023px ) {
			#team-<?php echo $post_id; ?> .item{width:<?php echo $team_items_width_tablet; ?>}
		}

		@media only screen and ( min-width: 320px ) and ( max-width: 767px ) {
			#team-<?php echo $post_id; ?> .item{width:<?php echo $team_items_width_mobile; ?>}
		}
		@media only screen and (min-width: 1024px ) {
            <?php if(!empty($team_items_thumb_max_hieght)):?>
			#team-<?php echo $post_id; ?> .item .layer-media .team-thumb{max-height:<?php echo $team_items_thumb_max_hieght; ?>}
            <?php endif; ?>
		}

		@media only screen and ( min-width: 768px ) and ( max-width: 1023px ) {
            <?php if(!empty($team_items_thumb_max_hieght_tablet)):?>
                #team-<?php echo $post_id; ?> .item .layer-media .team-thumb{max-height:<?php echo $team_items_thumb_max_hieght_tablet; ?>}
            <?php endif; ?>
		}

		@media only screen and ( min-width: 0px ) and ( max-width: 767px ) {
            <?php if(!empty($team_items_thumb_max_hieght_mobile)):?>
                #team-<?php echo $post_id; ?> .item .layer-media .team-thumb{max-height:<?php echo $team_items_thumb_max_hieght_mobile; ?>}
            <?php endif; ?>
		}
<?php



		if(!empty($team_items_social_icon_width) || !empty($team_items_social_icon_height)){
			
			if($team_items_social_icon_type=='image_icon'){

				?>
#team-<?php echo $post_id; ?> .team-social span {
						  width:<?php echo $team_items_social_icon_width; ?> !important;
						  height:<?php echo $team_items_social_icon_height; ?> !important;
						}

				<?php
				

				
				}
			else{

				?>
				#team-<?php echo $post_id; ?> .team-social span {
						  width: auto !important;
						  height: auto !important;
						}
		<?php

				
				}
			

			}


		if(!empty($team_items_custom_css))
			{
				echo $team_items_custom_css;
			}


		if(!empty($team_pagination_bg_color))
			{
				?>
				#team-<?php echo $post_id; ?> .paginate .page-numbers, #team-<?php echo $post_id; ?> .paginate .pager {
				background: none repeat scroll 0 0 <?php echo $team_pagination_bg_color; ?> !important;
				}
		<?php

			}
			
		if(!empty($team_pagination_active_bg_color))
			{
				?>
				#team-<?php echo $post_id; ?> .paginate .current, #team-<?php echo $post_id; ?> .paginate .page-numbers:hover,#team-<?php echo $post_id; ?> .paginate .pager.active,#team-<?php echo $post_id; ?> .paginate .pager:hover  {
				background: none repeat scroll 0 0 <?php echo $team_pagination_active_bg_color; ?> !important;
				}
		<?php

			}			




		if(!empty($team_filter_bg_color))
			{
				?>
				#team-<?php echo $post_id; ?> .team-filter .filter{
				background: none repeat scroll 0 0 <?php echo $team_filter_bg_color; ?> !important;
				}
		<?php

			}


		if(!empty($team_filter_active_bg_color))
			{
				?>
				#team-<?php echo $post_id; ?> .team-filter .filter.active{
				background: none repeat scroll 0 0 <?php echo $team_filter_active_bg_color; ?> !important;
				}
		<?php

			}

		if(!empty($team_filter_text_color))
			{
				?>
				#team-<?php echo $post_id; ?> .team-filter .filter{
				color: <?php echo $team_filter_text_color; ?> !important;
				}
		<?php

			}




?>
	</style>
		<?php


		

		
