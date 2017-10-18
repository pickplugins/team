<?php

/*
* @Author 		ParaTheme
* @Folder	 	Team/Templates
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
		

		$title_text = apply_filters( 'team_grid_filter_title', get_the_title() );		
	
	?>
	<h1 class="entry-title"><?php echo $title_text; ?></h1>