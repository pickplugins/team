<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	
	
	
		//$team_member_social_icon = get_option( 'team_member_social_icon' );	

		$team_bg_img = get_post_meta( $post_id, 'team_bg_img', true );
		$team_container_bg_color = get_post_meta( $post_id, 'team_container_bg_color', true );		
		
		$team_themes = get_post_meta( $post_id, 'team_themes', true );
		$team_social_icon_style = get_post_meta( $post_id, 'team_social_icon_style', true );		
		$team_masonry_enable = get_post_meta( $post_id, 'team_masonry_enable', true );
		
		$team_grid_item_align = get_post_meta( $post_id, 'team_grid_item_align', true );		
		$team_item_text_align = get_post_meta( $post_id, 'team_item_text_align', true );
	
		$team_total_items = get_post_meta( $post_id, 'team_total_items', true );
		$team_pagination_display = get_post_meta( $post_id, 'team_pagination_display', true );		

		$team_query_order = get_post_meta( $post_id, 'team_query_order', true );
		$team_query_orderby = get_post_meta( $post_id, 'team_query_orderby', true );
		$team_query_orderby_meta_key = get_post_meta( $post_id, 'team_query_orderby_meta_key', true );				
		
		$team_content_source = get_post_meta( $post_id, 'team_content_source', true );
		$team_content_year = get_post_meta( $post_id, 'team_content_year', true );
		$team_content_month = get_post_meta( $post_id, 'team_content_month', true );
		$team_content_month_year = get_post_meta( $post_id, 'team_content_month_year', true );
		
		
		$class_team_functions = new class_team_functions();
		
		$team_posttype = $class_team_functions->team_member_posttype();
		//$team_posttype = 'team_member';		
		$team_taxonomy = $class_team_functions->team_member_taxonomy();
		//$team_taxonomy = 'team_group';
		
		$team_taxonomy_terms = get_post_meta( $post_id, 'team_taxonomy_terms', true );	
		

		$team_post_ids = get_post_meta( $post_id, 'team_post_ids', true );

		$team_items_title_color = get_post_meta( $post_id, 'team_items_title_color', true );			
		$team_items_title_font_size = get_post_meta( $post_id, 'team_items_title_font_size', true );		

		$team_items_position_color = get_post_meta( $post_id, 'team_items_position_color', true );
		$team_items_position_font_size = get_post_meta( $post_id, 'team_items_position_font_size', true );

		$team_items_content = get_post_meta( $post_id, 'team_items_content', true );
		$team_items_content_color = get_post_meta( $post_id, 'team_items_content_color', true );
		$team_items_content_font_size = get_post_meta( $post_id, 'team_items_content_font_size', true );

		$team_pagination_bg_color = get_post_meta( $post_id, 'team_pagination_bg_color', true );
		$team_pagination_active_bg_color = get_post_meta( $post_id, 'team_pagination_active_bg_color', true );

		$team_items_excerpt_count = (int)get_post_meta( $post_id, 'team_items_excerpt_count', true );		
		$team_items_excerpt_text = get_post_meta( $post_id, 'team_items_excerpt_text', true );	

		$team_items_thumb_size = get_post_meta( $post_id, 'team_items_thumb_size', true );
		$team_items_link_to_post = get_post_meta( $post_id, 'team_items_link_to_post', true );
			
		$team_items_max_width = get_post_meta( $post_id, 'team_items_max_width', true );
		
		$team_items_width_tablet = get_post_meta( $post_id, 'team_items_width_tablet', true );	
		$team_items_width_mobile = get_post_meta( $post_id, 'team_items_width_mobile', true );		
		$team_items_thumb_max_hieght = get_post_meta( $post_id, 'team_items_thumb_max_hieght', true );
		$team_items_thumb_max_hieght_tablet = get_post_meta( $post_id, 'team_items_thumb_max_hieght_tablet', true );		
		$team_items_thumb_max_hieght_mobile = get_post_meta( $post_id, 'team_items_thumb_max_hieght_mobile', true );		

		$team_items_margin = get_post_meta( $post_id, 'team_items_margin', true );
		
		$team_items_social_icon_type = get_post_meta( $post_id, 'team_items_social_icon_type', true );		
		$team_items_social_icon_width = get_post_meta( $post_id, 'team_items_social_icon_width', true );		
		$team_items_social_icon_height = get_post_meta( $post_id, 'team_items_social_icon_height', true );

		$team_items_custom_css = get_post_meta( $post_id, 'team_items_custom_css', true );


		$team_items_popup_content = get_post_meta( $post_id, 'team_items_popup_content', true );
		$team_items_popup_excerpt_count = get_post_meta( $post_id, 'team_items_popup_excerpt_count', true );
		$team_items_popup_excerpt_text = get_post_meta( $post_id, 'team_items_popup_excerpt_text', true );
		$team_items_popup_width = get_post_meta( $post_id, 'team_items_popup_width', true );
		$team_items_popup_height = get_post_meta( $post_id, 'team_items_popup_height', true );
		$team_items_popup_thumb_size = get_post_meta( $post_id, 'team_items_popup_thumb_size', true );
		$team_items_popup_thumb_src = get_post_meta( $post_id, 'team_items_popup_thumb_src', true );

		if(empty($team_items_popup_thumb_src)){ $team_items_popup_thumb_src = 'featured_image'; }

		$popup_thumb_src_meta_key = get_post_meta( $post_id, 'popup_thumb_src_meta_key', true );


		$team_grid_items = get_post_meta( $post_id, 'team_grid_items', true );
		$team_grid_items_hide = get_post_meta( $post_id, 'team_grid_items_hide', true );

		$team_items_post_per_page_mixitup = get_post_meta( $post_id, 'team_items_post_per_page_mixitup', true );
		$team_items_default_filter_mixitup = get_post_meta( $post_id, 'team_items_default_filter_mixitup', true );	

		$team_items_skill_bg_color = get_post_meta( $post_id, 'team_items_skill_bg_color', true );	
		










		$team_pagination_prev_text = get_post_meta( $post_id, 'team_pagination_prev_text', true );
		$team_pagination_next_text = get_post_meta( $post_id, 'team_pagination_next_text', true );
		$team_grid_style = get_post_meta( $post_id, 'team_grid_style', true );
		$team_pagination_type = get_post_meta( $post_id, 'team_pagination_type', true );
		$team_pagination_top = get_post_meta( $post_id, 'team_pagination_top', true );


		$team_column_number = get_post_meta( $post_id, 'team_column_number', true );
		$team_column_number_mobile = get_post_meta( $post_id, 'team_column_number_mobile', true );
		$team_column_number_tablet = get_post_meta( $post_id, 'team_column_number_tablet', true );	
			
		$team_auto_play = get_post_meta( $post_id, 'team_auto_play', true );
		$team_stop_on_hover = get_post_meta( $post_id, 'team_stop_on_hover', true );
		$team_slider_navigation = get_post_meta( $post_id, 'team_slider_navigation', true );
		$team_slider_navigation_position = get_post_meta( $post_id, 'team_slider_navigation_position', true );		
		$team_slide_speed = get_post_meta( $post_id, 'team_slide_speed', true );
				
		$team_slider_pagination = get_post_meta( $post_id, 'team_slider_pagination', true );
		$team_pagination_slide_speed = get_post_meta( $post_id, 'team_pagination_slide_speed', true );
		$team_slider_pagination_count = get_post_meta( $post_id, 'team_slider_pagination_count', true );
		
		$team_slider_pagination_bg = get_post_meta( $post_id, 'team_slider_pagination_bg', true );
		$team_slider_pagination_text_color = get_post_meta( $post_id, 'team_slider_pagination_text_color', true );		
		
		$team_slider_touch_drag = get_post_meta( $post_id, 'team_slider_touch_drag', true );
		$team_slider_mouse_drag = get_post_meta( $post_id, 'team_slider_mouse_drag', true );


		$team_filter_bg_color = get_post_meta( $post_id, 'team_filter_bg_color', true );
		$team_filter_active_bg_color = get_post_meta( $post_id, 'team_filter_active_bg_color', true );
		$team_filter_text_color = get_post_meta( $post_id, 'team_filter_text_color', true );		
		$team_filter_scroll_top = get_post_meta( $post_id, 'team_filter_scroll_top', true );		


		if(!isset($team_content_source)){
				$team_content_source = 'latest';
			}

		if(!isset($team_items_content)){
				$team_items_content = 'excerpt';
			}
	
		if(!isset($team_items_excerpt_count)){
				$team_items_excerpt_count = 30;
			}	
	
		if(!isset($team_items_excerpt_text)){
				$team_items_excerpt_text = 'Read More';
			}

		if ( get_query_var('paged') ) {
		
			$paged = get_query_var('paged');
		
		} elseif ( get_query_var('page') ) {
		
			$paged = get_query_var('page');
		
		} else {
		
			$paged = 1;
		
		}

