<?php


/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 





add_action('settings_tabs_field_team_social_input', 'settings_tabs_field_team_social_input');

if(!function_exists('settings_tabs_field_team_social_input')) {
    function settings_tabs_field_team_social_input($option){

        $parent 		= isset( $option['parent'] ) ? $option['parent'] : "";
        $value 		= isset( $option['value'] ) ? $option['value'] : "";


        $post_id = get_the_id();

        $team_options = get_post_meta( $post_id, 'team_options', true );


        $unique_id = time();

        ?>
        <div class="setting-field">
            <div class="field-lable">Contact</div>
            <div class="field-input">

                <span class="button add-contact" data-name="<?php echo $parent; ?>">Add</span><br><br>
                <div class="sortable contact-list">


                    <?php

                    if(!empty($value)):

                        foreach ($value as $index => $contactData):

                            $type = isset($contactData['type']) ? $contactData['type'] :'';
                            $value = isset($contactData['value']) ? $contactData['value'] :'';
                            $label = isset($contactData['label']) ? $contactData['label'] :'';
                            $icon = isset($contactData['icon']) ? $contactData['icon'] :'';


                            ?>
                            <div class="item">

                                <div>Type:</div>
                                <select name="<?php echo $parent; ?>[contacts][<?php echo $index; ?>][type]">
                                    <option <?php selected($type, 'email'); ?> value="email">Email</option>
                                    <option <?php selected($type, 'phone'); ?> value="phone">Phone</option>
                                    <option <?php selected($type, 'link'); ?> value="link">Link</option>
                                    <option <?php selected($type, 'text'); ?> value="text">Text</option>
                                    <option <?php selected($type, 'skype'); ?> value="skype">Skype</option>
                                </select>

                                <div>Link or Value:</div>
                                <input type="text" name="<?php echo $parent; ?>[contacts][<?php echo $index; ?>][value]" placeholder="Write username, link, phone number or skype" value="<?php echo $value; ?>">

                                <div>Label:</div>
                                <input type="text" name="<?php echo $parent; ?>[contacts][<?php echo $index; ?>][label]" placeholder="Twitter" value="<?php echo $label; ?>">

                                <div>Icon:</div>
                                <input type="text" name="<?php echo $parent; ?>[contacts][<?php echo $index; ?>][icon]" placeholder="" value="<?php echo esc_html($icon); ?>">

                                <span class="button sort"><i class="fas fa-arrows-alt"></i></span>

                                <span class="button remove" onclick="jQuery(this).parent().remove()"><i class="fas fa-times"></i></span>
                                <hr/>
                            </div>
                        <?php
                        endforeach;


                    else:
                        ?>
                        <div class="item">

                            <div>Type: </div>
                            <select name="<?php echo $parent; ?>[contacts][<?php echo $unique_id; ?>][type]">
                                <option value="email">Email</option>
                                <option value="phone">Phone</option>
                                <option value="link">Link</option>
                                <option value="text">Text</option>
                                <option value="skype">Skype</option>
                            </select>

                            <div>Link or Value:</div>
                            <input type="text" name="<?php echo $parent; ?>[contacts][<?php echo $unique_id; ?>][value]" placeholder="Write username, link, phone number or skype" value="">

                            <div>Label:</div>
                            <input type="text" name="<?php echo $parent; ?>[contacts][<?php echo $unique_id; ?>][label]" placeholder="Twitter" value="">

                            <div>Icon:</div>
                            <input type="text" name="<?php echo $parent; ?>[contacts][<?php echo $unique_id; ?>][icon]" placeholder="" value="">

                            <span class="button sort"><i class="fas fa-arrows-alt"></i></span>

                            <span class="button remove" onclick="jQuery(this).parent().remove()"><i class="fas fa-times"></i></span>
                        </div>
                    <?php

                    endif;

                    ?>




                </div>
            </div>
        </div>

        <?php

    }
}









function team_1st_template_id(){

    $args = array(
        'post_type'=>'team_template',
        'post_status'=>'publish',
        'posts_per_page'=> 1,

    );



    $wp_query = new WP_Query($args);

    $post_id = '';


    if ( $wp_query->have_posts() ) :
        while ( $wp_query->have_posts() ) : $wp_query->the_post();

            $post_id = get_the_id();


        endwhile;
    endif;

    return $post_id;

}















function team_update_team_member_social_field(){
		
		$team_member_social_field = get_option('team_member_social_field');
		if(empty($team_member_social_field)){
			
			$class_team_functions = new class_team_functions();
			$team_member_social_field = $class_team_functions->team_member_social_field();
			update_option('team_member_social_field', $team_member_social_field);
			
			}
	
	}
	


	function team_get_all_post_ids($postid){
		
		if(current_user_can('manage_options')){
			
				
			if(isset($_POST['update_yes'])){
				$update_yes = sanitize_text_field($_POST['update_yes']);
				}
			else{
				$update_yes = '';
				}
			
			if(!empty($update_yes)){
				
					$args_product = array(
					'post_type' => array('team_member'),
					'posts_per_page' => -1,
					);
				}
			else{
				
					$team_post_ids = get_post_meta( $postid, 'team_post_ids', true );
					$args_product = array(
					'post_type' => array('team_member'),
					'orderby' => 'post__in',
					'post__in' => $team_post_ids,
					'posts_per_page' => -1,
					);

				}

			
			if(empty($team_post_ids)){$team_post_ids = array();}
			
			$return_string = '';
			$return_string .= '<ul style="margin: 0;">';

			$member_query = new WP_Query( $args_product );
		
			if($member_query->have_posts()){
				
					while($member_query->have_posts()): $member_query->the_post();
					$return_string .= '<li><label ><input class="team_post_ids" type="checkbox" name="team_post_ids[]" value ="'.get_the_ID().'" ';
					
					if ( in_array(get_the_ID(), $team_post_ids ) ){
						
							$return_string .= "checked";
						}
			
					$return_string .= '/>';
			
					$return_string .= get_the_title().'</label ></li>';
						
					endwhile; 
					wp_reset_query();
				}			
			else{
					$return_string .= '<span style="color:#f00;">'.__('Sorry nothting found.', 'team');
				}

				$return_string .= '</ul>';

				echo $return_string;

			}

		if(isset($_POST['update_yes'])){
			die();
			}	
	
	
		
	}

add_action('wp_ajax_team_get_all_post_ids', 'team_get_all_post_ids');
//add_action('wp_ajax_nopriv_team_get_all_post_ids', 'team_get_all_post_ids');



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





	
	function team_admin_notices(){
		
		if(current_user_can('manage_options')){
			
			$team_license_key = get_option('team_license_key');
			
			$html= '';
	
			if(empty($team_license_key))
				{
					$admin_url = get_admin_url();
					
					$html.= '<div class="update-nag">';
					$html.= __('Please activate your license for','team').' <b>'.team_plugin_name.' &raquo; <a href="'.$admin_url.'edit.php?post_type=team&page=license">'.__('License','team').'</a></b>';
					$html.= '</div>';	
				}
	
			echo $html;

			}
				
		}
	
	//add_action('admin_notices', 'team_admin_notices');
	
	
