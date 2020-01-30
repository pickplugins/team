<?php

/*
* @Author 		ParaTheme
* @Folder	 	Team/Templates
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/
if ( ! defined('ABSPATH')) exit; // if direct access  

	
	//var_dump($team_grid_style);


		//global $wp_query;
		
		$tax_query = array();
		
		$query_args['post_type'] 		= $team_posttype;
		$query_args['orderby']  		= $team_query_orderby;
		
		if(!empty($team_query_orderby_meta_key)){
			$query_args['meta_key'] = $team_query_orderby_meta_key;	
			}
		
			
		$query_args['order']  			= $team_query_order;
		$query_args['posts_per_page'] 	= $team_total_items;	
		$query_args['paged']  			= $paged;	

		if(!empty($team_taxonomy_terms)){
			
			$query_args['tax_query']  	= array(
				array(
				   'taxonomy' => $team_taxonomy,
				   'field' => 'id',
				   'terms' => $team_taxonomy_terms,
					)
				);
			
		}

			
		
		//echo '<pre>'.var_export($query_args, true).'</pre>';
			
			
		$query_merge = apply_filters('team_filter_query_args', $query_args);	
		
		$wp_query = new WP_Query($query_args);
			

