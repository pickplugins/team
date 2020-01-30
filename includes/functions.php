<?php


/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 







	function team_update_team_member_social_field(){
		
		$team_member_social_field = get_option('team_member_social_field');
		if(empty($team_member_social_field)){
			
			$class_team_functions = new class_team_functions();
			$team_member_social_field = $class_team_functions->team_member_social_field();
			update_option('team_member_social_field', $team_member_social_field);
			
			}
	
	}
	
	


	function team_single_team_member_template($single_template) {
		 global $post;
	
		 if ($post->post_type == 'team_member') {
			  $single_template = team_plugin_dir . 'templates/single-team_member.php';
		 }
		 return $single_template;
	}
//add_filter( 'single_template', 'team_single_team_member_template' );




add_image_size( 'team-500px', 500, 500, true  );


function team_term_slug_list($post_id){
	
	$term_slug_list = '';
	$post_taxonomies = get_post_taxonomies($post_id);
	
	foreach($post_taxonomies as $taxonomy){

		$term_list[] = wp_get_post_terms(get_the_ID(), $taxonomy, array("fields" => "all"));
		
		}

	if(!empty($term_list)){
		foreach($term_list as $term_key=>$term) 
			{
				foreach($term as $term_id=>$term){
					$term_slug_list .= $term->slug.' ';
					}
			}
		
		}

	return $term_slug_list;

	}


add_theme_support('post-thumbnails', array('team_member'));



function team_member_content($content){
	
	
	if ( is_singular( 'team_member' ) ) {
		$content = '';
		$content.= '<div class="team-member-container">';
		$content.= do_shortcode('[team_single]');		
		$content.= '</div>';
		
		}

	return $content;
	
	}

//add_filter('the_content','team_member_content');




function single_team_member_content($content){

	if(is_singular('team_member')){

		ob_start();
		include( team_plugin_dir . 'templates/single-team/single-team.php');

		$content =  ob_get_clean();
		return $content;
	}
	else{
		return $content;
	}

}

add_filter('the_content','single_team_member_content');










function team_add_thumb_column( $columns ) {
    return array_merge( $columns, 
        array( 'thumb' => __( 'Thumb', 'team' ) ) );
}
add_filter( 'manage_team_member_posts_columns' , 'team_add_thumb_column' );




function team_member_posts_thumb_display( $column, $post_id ) {
    if ($column == 'thumb'){
		
		$team_thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'thumbnail' );
		$team_thumb_url = $team_thumb['0'];
		if(!empty($team_thumb_url))
        echo '<img width="40px" height="40px" src="'.$team_thumb_url.'">';
    }
}
add_action( 'manage_team_member_posts_custom_column' , 'team_member_posts_thumb_display', 10, 2 );




function team_add_shortcode_column( $columns ) {
    return array_merge( $columns, 
        array( 'shortcode' => __( 'Shortcode', 'team' ) ) );
}
add_filter( 'manage_team_posts_columns' , 'team_add_shortcode_column' );


function team_posts_shortcode_display( $column, $post_id ) {
    if ($column == 'shortcode'){
		?>
        <input style="background:#bfefff" type="text" onClick="this.select();" value="[team <?php echo 'id=&quot;'.$post_id.'&quot;';?>]" /><br />
      <textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[team id='; echo "'".$post_id."']"; echo '"); ?>'; ?></textarea>
        <?php		
		
    }
}
add_action( 'manage_team_posts_custom_column' , 'team_posts_shortcode_display', 10, 2 );












function reset_team_member_social_field(){
		
		if(current_user_can('manage_options')){
			
			$class_team_functions = new class_team_functions();
			$default_social_field = $class_team_functions->team_member_social_field();
			
			update_option('team_member_social_field', $default_social_field);
			
			}

		die();
	}

add_action('wp_ajax_reset_team_member_social_field', 'reset_team_member_social_field');
//add_action('wp_ajax_nopriv_reset_team_member_social_field', 'reset_team_member_social_field');






	
	
