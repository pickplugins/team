<?php

/*
* @Author 		ParaTheme
* @Folder	 	Team/Templates
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


$post_id = get_the_id();

	
?>
<div class="single-team-content"><?php echo  wpautop(do_shortcode(get_the_content($post_id))); ?></div>