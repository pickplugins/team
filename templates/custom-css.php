<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	
		$html .= '<style type="text/css">';




				$html .= '#team-'.$post_id.'{
						background: '.$team_container_bg_color.' url('.$team_bg_img.') repeat scroll 0 0;
						text-align:'.$team_grid_item_align.';
						}
						';	



				$html .= '#team-'.$post_id.' .item{
						
						text-align:'.$team_item_text_align.';
						margin:'.$team_items_margin.';
						}
						';	

				$html .= '
				@media only screen and (min-width: 1024px ) {
				#team-'.$post_id.' .item{width:'.$team_items_max_width.'}
				
				}
				
				@media only screen and ( min-width: 768px ) and ( max-width: 1023px ) {
				#team-'.$post_id.' .item{width:'.$team_items_width_tablet.'}
				}
				
				@media only screen and ( min-width: 320px ) and ( max-width: 767px ) {
				#team-'.$post_id.' .item{width:'.$team_items_width_mobile.'}
				}';




				$html .= '
				@media only screen and (min-width: 1024px ) {
				#team-'.$post_id.' .item .layer-media .team-thumb{max-height:'.$team_items_thumb_max_hieght.'}
				
				}
				
				@media only screen and ( min-width: 768px ) and ( max-width: 1023px ) {
				#team-'.$post_id.' .item .layer-media .team-thumb{max-height:'.$team_items_thumb_max_hieght_tablet.'}
				}
				
				@media only screen and ( min-width: 0px ) and ( max-width: 767px ) {
				#team-'.$post_id.' .item .layer-media .team-thumb{max-height:'.$team_items_thumb_max_hieght_mobile.'}
				}';












		if(!empty($team_items_social_icon_width) || !empty($team_items_social_icon_height)){
			
			if($team_items_social_icon_type=='image_icon'){
				
				$html .= '#team-'.$post_id.' .team-social span {
						  width: '.$team_items_social_icon_width.' !important;
						  height:'.$team_items_social_icon_height.' !important;
						}';	
				
				}
			else{
				$html .= '#team-'.$post_id.' .team-social span {
						  width: auto !important;
						  height: auto !important;
						}';	
				
				}
			

			}


		if(!empty($team_items_custom_css))
			{
				$html .= $team_items_custom_css;	
			}


		if(!empty($team_pagination_bg_color))
			{
				$html .= '#team-'.$post_id.' .paginate .page-numbers, #team-'.$post_id.' .paginate .pager {
				background: none repeat scroll 0 0 '.$team_pagination_bg_color.' !important;
				}
				';	
			}
			
		if(!empty($team_pagination_active_bg_color))
			{
				$html .= '#team-'.$post_id.' .paginate .current, #team-'.$post_id.' .paginate .page-numbers:hover,#team-'.$post_id.' .paginate .pager.active,#team-'.$post_id.' .paginate .pager:hover  {
				background: none repeat scroll 0 0 '.$team_pagination_active_bg_color.' !important;
				}
				';	
			}			




		if(!empty($team_filter_bg_color))
			{
				$html .= '#team-'.$post_id.' .team-filter .filter{
				background: none repeat scroll 0 0 '.$team_filter_bg_color.' !important;
				}
				';	
			}


		if(!empty($team_filter_active_bg_color))
			{
				$html .= '#team-'.$post_id.' .team-filter .filter.active{
				background: none repeat scroll 0 0 '.$team_filter_active_bg_color.' !important;
				}
				';	
			}

		if(!empty($team_filter_text_color))
			{
				$html .= '#team-'.$post_id.' .team-filter .filter{
				color: '.$team_filter_text_color.' !important;
				}
				';	
			}






		$html .= '</style>';	
		

		
