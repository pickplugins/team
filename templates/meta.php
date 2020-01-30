<?php

/*
* @Author 		ParaTheme
* @Folder	 	Team/Templates
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

			
			$html.= '<div class="team-meta" >';
				
			$meta_keys = get_post_meta($post_id, 'team_grid_meta_keys', true );
			//$meta_keys = explode(',',$meta_keys);
			
			$html_meta = '';
			
			//var_dump($meta_keys);
			
			if(is_array($meta_keys))
			foreach($meta_keys as $meta_info){
				
				$wrapper = $meta_info['wrapper'];
				$key = $meta_info['key'];
				$meta_value = do_shortcode(get_post_meta(get_the_ID(), $key, true ));
				//var_dump($wrapper);		
				
				if(!empty($meta_value)):
				
					$html_meta.= '<div class="meta-single" >';
					$html_meta.= str_replace('%s', $meta_value,$wrapper);			
					$html_meta.= '</div>';
				
				endif;

				}		
				
			$html .= apply_filters( 'team_grid_filter_meta', $html_meta );	
				
			$html.= '</div>';
	

