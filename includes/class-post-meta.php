<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	

class team_class_post_meta{
	
	
	public function __construct(){

		add_action('add_meta_boxes', array($this, 'meta_boxes_team_member_meta_fileds'));
		add_action('save_post', array($this, 'meta_boxes_team_member_save_meta_fileds'));	
		
		//meta box action for "team_member"
		add_action('add_meta_boxes', array($this, 'meta_boxes_team_member_social'));
		add_action('save_post', array($this, 'meta_boxes_team_member_social_save'));

		//meta box action for "team"
		add_action('add_meta_boxes', array($this, 'meta_boxes_team'));
		add_action('save_post', array($this, 'meta_boxes_team_save'));
		

		}
	
	
	
	public function meta_boxes_team_member_meta_fileds($post_type) {
			$post_types = array('team_member');
	 
			//limit meta box to certain post types
			if (in_array($post_type, $post_types)) {
				add_meta_box('team_member_metabox_meta_fileds',
				'Team Member Meta Fields',
				array($this, 'team_member_meta_box_function_meta_fileds'),
				$post_type,
				'normal',
				'high');
			}
		}
	
	
	public function team_member_meta_box_function_meta_fileds($post) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field('team_member_nonce_check', 'team_member_nonce_check_value');
 
        // Use get_post_meta to retrieve an existing value from the database.
        $team_member_position = get_post_meta($post -> ID, 'team_member_position', true);		
        $team_member_link_to_post = get_post_meta($post -> ID, 'team_member_link_to_post', true);
        $team_member_skill = get_post_meta($post -> ID, 'team_member_skill', true);		

 
 
		$team_member_meta_fields = get_option('team_member_meta_fields');
		
		if(empty($team_member_meta_fields)){
				$team_member_meta_fields = array(
											'address' => array('name'=>'Address','meta_key'=>'team_address'),
											//'mobile' => array('name'=>'Mobile','meta_key'=>'team_mobile'),											
										);
			
			}
 
 		foreach($team_member_meta_fields as $meta_key=>$meta_info){
			
			${$meta_info['meta_key']} = get_post_meta($post -> ID, $meta_info['meta_key'], true);
			
			}
 
 
        // Display the form, using the current value.
		
		echo '<div class="para-settings">';
		echo '<div class="option-box">';
		echo '<p class="option-title">'.__('Member Position.','team').'</p>';
		echo '<p class="option-info"></p>';
		
		
		
		echo '<input type="text" size="30" placeholder="Team Leader"   name="team_member_position" value="';
		if(!empty($team_member_position)) 
		echo $team_member_position;
		echo '" />';
		echo '</div>';



		echo '<div class="option-box">';
		echo '<p class="option-title">'.__('Custom link to this member.','team').'</p>';
		echo '<p class="option-info"></p>';

		echo '<input type="text" size="30" placeholder="http://hello.com/project-sample"   name="team_member_link_to_post" value="';
		if(!empty($team_member_link_to_post)) 
		echo $team_member_link_to_post;
		echo '" />';
		echo '</div>';
		
		?>
        <div class="option-box">
            <p class="option-title"><?php _e(' Member Skill.','team'); ?></p>
            <p class="option-info"></p>

                <table class="widefat team-member-skills">
                <thead>
                    <tr> 
                    <th>Sorting</th>                   
                    <th>Skill Name</th>
                    <th>Skill Value(%)</th>
                    <th>Remove</th>            
                    </tr>
                    </thead>
                    <tbody>
                    
                    <?php
                    
                    if(empty($team_member_skill)){
                        
                        $team_member_skill = array(
                                                    '' => array('name'=>'','value'=>''),										
                                                );
                        
                        }
                    //var_dump($team_member_skill);
                    
                        foreach ($team_member_skill as $skill_key=>$skill_info) {
                            
                            ?>
                    <tr>
                    <td class="sorting"></td>
                    <td>
                        
                        <?php //var_dump($skill_info); ?>
                    
                        <input type="text" size="30" placeholder="Programming"   name="team_member_skill[<?php echo $skill_key; ?>][name]" value="<?php if(!empty($team_member_skill[$skill_key]['name'])) echo $team_member_skill[$skill_key]['name']; ?>" />
                    
                    </td>
                    <td>
                        <input type="text" size="30" placeholder="80%"   name="team_member_skill[<?php echo $skill_key; ?>][value]" value="<?php if(!empty($team_member_skill[$skill_key]['value'])) echo $team_member_skill[$skill_key]['value']; ?>" />
                    </td>
                    
                    <td>
                    <span class="remove-skill">X</span>
                    </td>            
                    </tr>
                        <?php
                        }
                ?>
                </tbody>
                </table>
                
                <div class="button add_team_member_skill">Add new</div>
            

 <script>
 jQuery(document).ready(function($)
	{
		$(function() {
			$( ".team-member-skills tbody" ).sortable();
			//$( ".items" ).disableSelection();
			});
		
		})

</script>
 
        </div> <!-- option-box -->
        
        <?php
		
		foreach($team_member_meta_fields as $meta_key=>$meta_info){
			

			
			?>
            <div class="option-box">
                <p class="option-title"><?php echo ucfirst($meta_info['name']); ?></p>
                <p class="option-info"></p>
                <input type="text" size="30" placeholder=""   name="<?php echo $meta_info['meta_key']; ?>" value="<?php if(!empty(${$meta_info['meta_key']})) echo ${$meta_info['meta_key']}; ?>" />
            </div>
            <?php
			
			}
		
		
		
        ?>
        
        
        
        
        
        
        
        

        
       </div> <!-- // end of para-settings -->
        
        
		<?php

    }





public function meta_boxes_team_member_save_meta_fileds($post_id) {
 
        /*
         * We need to verify this came from the our screen and with 
         * proper authorization,
         * because save_post can be triggered at other times.
         */
 
        // Check if our nonce is set.
        if (!isset($_POST['team_member_nonce_check_value']))
            return $post_id;
 
        $nonce = $_POST['team_member_nonce_check_value'];
 
        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'team_member_nonce_check'))
            return $post_id;
 
        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;
 
        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {
 
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
 
        } else {
 
            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }
 
        /* OK, its safe for us to save the data now. */
 
        // Sanitize the user input.
        $team_member_position = sanitize_text_field($_POST['team_member_position']); 
        $team_member_link_to_post = sanitize_text_field($_POST['team_member_link_to_post']);
        $team_member_skill = stripslashes_deep($_POST['team_member_skill']);		
 
        // Update the meta field.
        update_post_meta($post_id, 'team_member_position', $team_member_position);		
        update_post_meta($post_id, 'team_member_link_to_post', $team_member_link_to_post);
        update_post_meta($post_id, 'team_member_skill', $team_member_skill);			
		
		$team_member_meta_fields = get_option('team_member_meta_fields');
		
		if(empty($team_member_meta_fields)){
				$team_member_meta_fields = array(
											'address' => array('name'=>'Address','meta_key'=>'team_address'),
											//'mobile' => array('name'=>'Mobile','meta_key'=>'team_mobile'),											
										);
			
			}
		
		foreach($team_member_meta_fields as $meta_key=>$meta_info){
			
				$meta_key = $meta_info['meta_key'];

				$meta_key_value = sanitize_text_field($_POST[$meta_key]); 
				update_post_meta($post_id, $meta_key, $meta_key_value);
				
			}
		
		
		
		
		
		
    }
	





	
	
	
	
	public function meta_boxes_team_member_social($post_type) {
			$post_types = array('team_member');
	 
			//limit meta box to certain post types
			if (in_array($post_type, $post_types)) {
				add_meta_box('team_member_metabox',
				'Team Member Social Info',
				array($this, 'team_member_social_meta_box_function'),
				$post_type,
				'normal',
				'high');
			}
		}
		
		
	public function team_member_social_meta_box_function($post) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field('team_member_nonce_check', 'team_member_nonce_check_value');
 
        // Use get_post_meta to retrieve an existing value from the database.
        $team_member_social_links = get_post_meta($post -> ID, 'team_member_social_links', true);
		
		$team_member_social_field = get_option( 'team_member_social_field' );
		
 		//var_dump($team_member_social_field);
		
		if(empty($team_member_social_field))
			{
				$class_team_functions = new class_team_functions();
				$team_member_social_field = $class_team_functions->team_member_social_field();
				
			}
 
        // Display the form, using the current value.
		
		echo '<div class="para-settings">';

		foreach ($team_member_social_field as $field_key=>$field_info) {
			
			if(!empty($field_key) && !empty($field_info['visibility'])){
					if($field_key == 'skype')
						{
						?>
						
                        <div class="option-box">
                            <p class="option-title"><?php _e(' Member Skype.','team'); ?></p>
                            <p class="option-info"></p>
                            <input type="text" size="30" placeholder="skypeusername"   name="team_member_social_links[<?php echo $field_key; ?>]" value="<?php if(!empty($team_member_social_links[$field_key])) echo $team_member_social_links[$field_key]; ?>" />
                        </div> 
						
						<?php
						}

					else if($field_key == 'mobile')
						{
						?>
						
                        <div class="option-box">
                            <p class="option-title"><?php _e(' Member Mobile .','team'); ?></p>
                            <p class="option-info"></p>
                            <input type="text" size="30" placeholder="+01895632456"   name="team_member_social_links[<?php echo $field_key; ?>]" value="<?php if(!empty($team_member_social_links[$field_key])) echo $team_member_social_links[$field_key]; ?>" />
                        </div> 
						
						<?php
						}						

					else if($field_key == 'phone')
						{
						?>
						
                        <div class="option-box">
                            <p class="option-title"><?php _e(' Member Telephone .','team'); ?></p>
                            <p class="option-info"></p>
                            <input type="text" size="30" placeholder="+01895632456"   name="team_member_social_links[<?php echo $field_key; ?>]" value="<?php if(!empty($team_member_social_links[$field_key])) echo $team_member_social_links[$field_key]; ?>" />
                        </div> 
						
						<?php
						}						

					else if($field_key == 'email')
						{
						?>
						
                        <div class="option-box">
                            <p class="option-title"><?php _e(' Member Email.','team'); ?></p>
                            <p class="option-info"></p>
                            <input type="text" size="30" placeholder="hello@exapmle.com"   name="team_member_social_links[<?php echo $field_key; ?>]" value="<?php if(!empty($team_member_social_links[$field_key])) echo $team_member_social_links[$field_key]; ?>" />
                        </div> 
						
						<?php
						}
					else if($field_key == 'website')
						{
						?>
						
                        <div class="option-box">
                            <p class="option-title"><?php _e(' Member Website.','team'); ?></p>
                            <p class="option-info"></p>
                            <input type="text" size="30" placeholder="http://exapmle.com"   name="team_member_social_links[<?php echo $field_key; ?>]" value="<?php if(!empty($team_member_social_links[$field_key])) echo $team_member_social_links[$field_key]; ?>" />
                        </div> 
						
						<?php
						}
					else
						{
						?>
						
                        <div class="option-box">
                            <p class="option-title"><?php echo ucfirst($field_info['name']); ?></p>
                            <p class="option-info"></p>
                            <input type="text" size="30" placeholder="http://exapmle.com/username"   name="team_member_social_links[<?php echo $field_key; ?>]" value="<?php if(!empty($team_member_social_links[$field_key])) echo $team_member_social_links[$field_key]; ?>" />
                        </div> 
						
						<?php
						}					

                    }
            }



		echo '</div>'; // end of para-settings 

    }




public function meta_boxes_team_member_social_save($post_id) {
 
        /*
         * We need to verify this came from the our screen and with 
         * proper authorization,
         * because save_post can be triggered at other times.
         */
 
        // Check if our nonce is set.
        if (!isset($_POST['team_member_nonce_check_value']))
            return $post_id;
 
        $nonce = $_POST['team_member_nonce_check_value'];
 
        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'team_member_nonce_check'))
            return $post_id;
 
        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;
 
        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {
 
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
 
        } else {
 
            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }
 
        /* OK, its safe for us to save the data now. */
 
        // Sanitize the user input.
        $team_member_social_links = stripslashes_deep($_POST['team_member_social_links']); 
 
        // Update the meta field.

        update_post_meta($post_id, 'team_member_social_links', $team_member_social_links);			
		
    }
	
	
	
	

	
/*
Team Post
*/	
	
	
	public function meta_boxes_team($post_type) {
			$post_types = array('team');
	 
			//limit meta box to certain post types
			if (in_array($post_type, $post_types)) {
				add_meta_box('team_metabox',
				'Team Options',
				array($this, 'team_meta_box_function'),
				$post_type,
				'normal',
				'high');
			}
		}
	public function team_meta_box_function($post) {
 
        // Add an nonce field so we can check for it later.
        wp_nonce_field('team_nonce_check', 'team_nonce_check_value');
 
        // Use get_post_meta to retrieve an existing value from the database.
	$team_bg_img = get_post_meta( $post->ID, 'team_bg_img', true );
	$team_container_bg_color = get_post_meta( $post->ID, 'team_container_bg_color', true );	
	
	$team_themes = get_post_meta( $post->ID, 'team_themes', true );
	$team_social_icon_style = get_post_meta( $post->ID, 'team_social_icon_style', true );	
	$team_masonry_enable = get_post_meta( $post->ID, 'team_masonry_enable', true );	
	
	$team_grid_item_align = get_post_meta( $post->ID, 'team_grid_item_align', true );	
	$team_item_text_align = get_post_meta( $post->ID, 'team_item_text_align', true );	
	$team_total_items = get_post_meta( $post->ID, 'team_total_items', true );	
	//$team_pagination_display = get_post_meta( $post->ID, 'team_pagination_display', true );	

	$team_query_order = get_post_meta( $post->ID, 'team_query_order', true );
	$team_query_orderby = get_post_meta( $post->ID, 'team_query_orderby', true );
	$team_query_orderby_meta_key = get_post_meta( $post->ID, 'team_query_orderby_meta_key', true );


	
	
	//$team_content_year = get_post_meta( $post->ID, 'team_content_year', true );
	//$team_content_month = get_post_meta( $post->ID, 'team_content_month', true );
	//$team_content_month_year = get_post_meta( $post->ID, 'team_content_month_year', true );	


	$team_taxonomy_terms = get_post_meta( $post->ID, 'team_taxonomy_terms', true );
	


	
	
	
	$team_items_title_color = get_post_meta( $post->ID, 'team_items_title_color', true );	
	$team_items_title_font_size = get_post_meta( $post->ID, 'team_items_title_font_size', true );
	$team_items_title_font_family = get_post_meta( $post->ID, 'team_items_title_font_family', true );



	$team_items_position_color = get_post_meta( $post->ID, 'team_items_position_color', true );
	$team_items_position_font_size = get_post_meta( $post->ID, 'team_items_position_font_size', true );

	$team_pagination_bg_color = get_post_meta( $post->ID, 'team_pagination_bg_color', true );
	$team_pagination_active_bg_color = get_post_meta( $post->ID, 'team_pagination_active_bg_color', true );


	$team_items_content = get_post_meta( $post->ID, 'team_items_content', true );
	if(empty($team_items_content))
		{
			$team_items_content = 'excerpt';
		}
	
	$team_items_content_color = get_post_meta( $post->ID, 'team_items_content_color', true );	
	$team_items_content_font_size = get_post_meta( $post->ID, 'team_items_content_font_size', true );		



	$team_items_excerpt_count = get_post_meta( $post->ID, 'team_items_excerpt_count', true );	
	$team_items_excerpt_text = get_post_meta( $post->ID, 'team_items_excerpt_text', true );	
	
	$team_items_thumb_size = get_post_meta( $post->ID, 'team_items_thumb_size', true );
	$team_items_link_to_post = get_post_meta( $post->ID, 'team_items_link_to_post', true );	
	$team_items_max_width = get_post_meta( $post->ID, 'team_items_max_width', true );
	$team_items_width_mobile = get_post_meta( $post->ID, 'team_items_width_mobile', true );	
	$team_items_width_tablet = get_post_meta( $post->ID, 'team_items_width_tablet', true );			
		
	$team_items_thumb_max_hieght = get_post_meta( $post->ID, 'team_items_thumb_max_hieght', true );	
	$team_items_thumb_max_hieght_tablet = get_post_meta( $post->ID, 'team_items_thumb_max_hieght_tablet', true );
	$team_items_thumb_max_hieght_mobile = get_post_meta( $post->ID, 'team_items_thumb_max_hieght_mobile', true );			
	
	
	$team_items_margin = get_post_meta( $post->ID, 'team_items_margin', true );		
	
	$team_items_social_icon_type = get_post_meta( $post->ID, 'team_items_social_icon_type', true );		
	$team_items_social_icon_width = get_post_meta( $post->ID, 'team_items_social_icon_width', true );	
	$team_items_social_icon_height = get_post_meta( $post->ID, 'team_items_social_icon_height', true );	
	
	$team_items_custom_css = get_post_meta( $post->ID, 'team_items_custom_css', true );		
 
	$team_items_popup_content = get_post_meta( $post->ID, 'team_items_popup_content', true );

	$team_items_popup_excerpt_count = get_post_meta( $post->ID, 'team_items_popup_excerpt_count', true );
	$team_items_popup_excerpt_text = get_post_meta( $post->ID, 'team_items_popup_excerpt_text', true );
	$team_items_popup_width = get_post_meta( $post->ID, 'team_items_popup_width', true );
	$team_items_popup_height = get_post_meta( $post->ID, 'team_items_popup_height', true );
	$team_items_popup_thumb_size = get_post_meta( $post->ID, 'team_items_popup_thumb_size', true );


	if(empty($team_items_popup_content))
		{
			$team_items_popup_content = 'full';
		}

	$team_pagination_prev_text = get_post_meta( $post->ID, 'team_pagination_prev_text', true );
	$team_pagination_next_text = get_post_meta( $post->ID, 'team_pagination_next_text', true );	
	$team_items_post_per_page_mixitup = get_post_meta( $post->ID, 'team_items_post_per_page_mixitup', true );
	$team_items_default_filter_mixitup = get_post_meta( $post->ID, 'team_items_default_filter_mixitup', true );

	if(empty($team_items_default_filter_mixitup))
		{
			$team_items_default_filter_mixitup = 'all';
		}	


	$team_grid_items = get_post_meta( $post->ID, 'team_grid_items', true );
	$team_grid_items_hide = get_post_meta( $post->ID, 'team_grid_items_hide', true );		
	$team_grid_meta_keys = get_post_meta( $post->ID, 'team_grid_meta_keys', true );


	$team_items_skill_bg_color = get_post_meta( $post->ID, 'team_items_skill_bg_color', true );	
	
	$team_grid_style = get_post_meta( $post->ID, 'team_grid_style', true );		
	if(empty($team_grid_style)){$team_grid_style = 'grid';}
	
	
	$team_pagination_type = get_post_meta( $post->ID, 'team_pagination_type', true );	
	if(empty($team_pagination_type)){$team_pagination_type = 'none';}

 	
	$team_column_number = get_post_meta( $post->ID, 'team_column_number', true );
	if(empty($team_column_number)){
		$team_column_number = 3;
		}
	$team_column_number_tablet = get_post_meta( $post->ID, 'team_column_number_tablet', true );
	if(empty($team_column_number_tablet)){
		$team_column_number_tablet = 2;
		}
	
	$team_column_number_mobile = get_post_meta( $post->ID, 'team_column_number_mobile', true );
	if(empty($team_column_number_mobile)){
		$team_column_number_mobile = 1;
		}
		
	$team_auto_play = get_post_meta( $post->ID, 'team_auto_play', true );
	if(empty($team_auto_play)){
		$team_auto_play = 'true';
		}	
	
	$team_stop_on_hover = get_post_meta( $post->ID, 'team_stop_on_hover', true );
	if(empty($team_stop_on_hover)){
		$team_stop_on_hover = 'true';
		}	
		
		
	$team_slider_navigation = get_post_meta( $post->ID, 'team_slider_navigation', true );
	if(empty($team_slider_navigation)){
		$team_slider_navigation = 'true';
		}	
	
	
	$team_slider_navigation_position = get_post_meta( $post->ID, 'team_slider_navigation_position', true );	
	if(empty($team_slider_navigation_position)){
		$team_slider_navigation_position = 'topright';
		}



	$team_filter_bg_color = get_post_meta( $post->ID, 'team_filter_bg_color', true );	
	if(empty($team_filter_bg_color)){
		$team_filter_bg_color = '#d6d6d6';
		}

	$team_filter_active_bg_color = get_post_meta( $post->ID, 'team_filter_active_bg_color', true );	
	if(empty($team_filter_active_bg_color)){
		$team_filter_active_bg_color = '#adadad';
		}
		
	$team_filter_text_color = get_post_meta( $post->ID, 'team_filter_text_color', true );	
	if(empty($team_filter_text_color)){
		$team_filter_text_color = '#666666';
		}		
		
	$team_filter_scroll_top = get_post_meta( $post->ID, 'team_filter_scroll_top', true );	
	if(empty($team_filter_scroll_top)){
		$team_filter_scroll_top = 'no';
		}		
		
		
		

	$team_slide_speed = get_post_meta( $post->ID, 'team_slide_speed', true );
	$team_slider_navigation_speed = get_post_meta( $post->ID, 'team_slider_navigation_speed', true );
	$team_slider_pagination = get_post_meta( $post->ID, 'team_slider_pagination', true );
	$team_pagination_slide_speed = get_post_meta( $post->ID, 'team_pagination_slide_speed', true );
	$team_slider_pagination_count = get_post_meta( $post->ID, 'team_slider_pagination_count', true );
	$team_slider_pagination_bg = get_post_meta( $post->ID, 'team_slider_pagination_bg', true );
	$team_slider_pagination_text_color = get_post_meta( $post->ID, 'team_slider_pagination_text_color', true );	
	$team_slider_touch_drag = get_post_meta( $post->ID, 'team_slider_touch_drag', true );
	$team_slider_mouse_drag = get_post_meta( $post->ID, 'team_slider_mouse_drag', true );
 
 
 
 
 
	// Display the form, using the current value.
	$class_team_functions = new class_team_functions();
	
	$team_id = $post->ID;
		
		?>
        
        
        <div class="para-settings">

        <ul class="tab-nav">
        
            <li nav="1" class="nav1 active"><i class="fa fa-code"></i> <?php _e('Shortcode','team'); ?></li>
            <li nav="2" class="nav2"><i class="fa fa-diamond"></i> <?php _e('Style','team'); ?></li>
            <li nav="3" class="nav3"><i class="fa fa-users"></i> <?php _e('Query Member','team'); ?></li>
            <li nav="5" class="nav5"><i class="fa fa-bug"></i> <?php _e('Custom CSS','team'); ?></li>
            <li nav="6" class="nav6"><i class="fa fa-qrcode"></i> <?php _e('Layout Builder','team'); ?></li>
            <li nav="7" class="nav7"><i class="fa fa-qrcode"></i> <?php _e('Slider Options','team'); ?> <span class="team-pro" title="Only available in premium">Pro</span></li>
                       
            
        </ul> <!-- tab-nav end -->
		<ul class="box">
        
            <li style="display: block;" class="box1 tab-box active">
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Shortcode.','team'); ?></p>
                    <p class="option-info"><?php _e('Copy this shortcode and paste on page or post where you want to display Team. <br />Use PHP code to your themes file to display Team.','team'); ?></p>
					<textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" >[team <?php echo 'id="'.$post->ID.'"';?>]</textarea><br />
					<textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[team id='; echo "'".$post->ID."']"; echo '"); ?>'; ?></textarea>  

                    <br /><br />
					Avoid conflict<br />
					<textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" >[team_pickplugins <?php echo 'id="'.$post->ID.'"';?>]</textarea><br />
					<textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[team_pickplugins id='; echo "'".$post->ID."']"; echo '"); ?>'; ?></textarea>  




                </div>
            
            </li>    
        
        
            
			<li style="display: none;" class="box2 tab-box">
				<div class="option-box">
                    <p class="option-title"><?php _e('Skin.','team'); ?></p>
                    <p class="option-info"><?php _e('Skin for Team grid items.','team'); ?></p>
                    <?php
					
					
					
						//$team_themes_list = $class_team_functions->team_themes();


					?>
                    
                    
                    
                    <select name="team_themes"  >

                    
                    <?php
						
						$class_team_functions = new class_team_functions();
						$skins = $class_team_functions->skins();						

						foreach($skins as $skin_key => $skin_data){

						    $disabled = $skin_data['disabled'];


								echo '<option value="'.$skin_key.'"';

							    if($disabled == 'disabled') echo "disabled";
								if($team_themes == $skin_key) echo "selected";
								echo '>'.$skin_data['name'].'</option>';
							}
					?> 

                    </select>
				</div>
            
            
            
            
            
            
            
            
        
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Link to Member.','team'); ?></p>
                    <p class="option-info"><?php _e('Clickable link to post team member.','team'); ?></p>
                    <select name="team_items_link_to_post" >
                   		<option  value="no" <?php if($team_items_link_to_post=="no")echo "selected"; ?>>No</option>
                    	<option value="yes" <?php if($team_items_link_to_post=="yes")echo "selected"; ?>>Team Member Page</option>
                        <option disabled value="">Custom Link (Pro feature)</option>
                        <option disabled value="" >Popup Profile (Pro feature)</option>
                        <option disabled value="" >Popup Slider (Pro feature)</option>
                        
                    </select>
                </div>  
            
            
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Grid item max Width(px).','team'); ?></p>
                    <p class="option-info"><?php _e('Maximum width for grid items.','team'); ?></p>
                    <br>
                    
                    <div>
                    <?php _e('For Destop: (min-width:1024px)','team'); ?> <br/>
					<input type="text" name="team_items_max_width" placeholder="ex:150px, px or %" id="team_items_max_width" value="<?php if(!empty($team_items_max_width)) echo $team_items_max_width; else echo "280px"; ?>" />
                    </div>
					
                    <br>

					<div>
                    <?php _e('For Tablet: ( min-width:768px )','team'); ?> <br/>
					<input type="text" name="team_items_width_tablet" placeholder="ex:150px, px or %" id="team_items_width_tablet" value="<?php if(!empty($team_items_width_tablet)) echo $team_items_width_tablet; else echo "45%"; ?>" />                    
                    </div> 
                    <br>
                    
                    <div>             
                    <?php _e('For Mobile: ( min-width : 320px, )','team'); ?> <br/>
					<input type="text" name="team_items_width_mobile" placeholder="ex:150px, px or %" id="team_items_width_mobile" value="<?php if(!empty($team_items_width_mobile)) echo $team_items_width_mobile; else echo "90%"; ?>" />
                    </div>
                    
                    
                </div> 




				<div class="option-box">
                    <p class="option-title"><?php _e('Grid Items Margin (px).','team'); ?></p>
                    <p class="option-info"><?php _e('You can use general CSS rules for margin, ex:10px, <br /> 10px 10px, <br /> 10px 10px 10px, <br /> 10px 10px 10px 10px.','team'); ?></p>
					<input type="text" name="team_items_margin" placeholder="ex:20px number with px" id="team_items_margin" value="<?php if(!empty($team_items_margin)) echo $team_items_margin; else echo "15px"; ?>" />
				</div>

            
				<div class="option-box">
                    <p class="option-title"><?php _e('Grid Items Text Align.','team'); ?></p>
                    <p class="option-info"></p>
                    <select id="team_item_text_align" name="team_item_text_align"  >
                    <option class="team_item_text_align" value="left" <?php if($team_item_text_align=="left")echo "selected"; ?>><?php _e('Left','team'); ?></option>
                    
                    <option class="team_item_text_align" value="center" <?php if($team_item_text_align=="center")echo "selected"; ?>><?php _e('Center','team'); ?></option>
                    
                    <option class="team_item_text_align" value="right" <?php if($team_item_text_align=="right")echo "selected"; ?>><?php _e('Right','team'); ?></option>
                    </select>
				</div>
            

				<div class="option-box">
                	<p class="option-title"><?php _e('Container Options.','team'); ?></p>
                    <p class="option-info"><?php _e('Background image:','team'); ?></p>
                    <img class="bg_image_src" onClick="bg_img_src(this)" src="<?php echo team_plugin_url; ?>assets/global/images/bg/dark_embroidery.png" />
                    <img class="bg_image_src" onClick="bg_img_src(this)" src="<?php echo team_plugin_url; ?>assets/global/images/bg/dimension.png" />
                    <img class="bg_image_src" onClick="bg_img_src(this)" src="<?php echo team_plugin_url; ?>assets/global/images/bg/eight_horns.png" /> 
                    <br />                    
                    <input type="text" id="team_bg_img" class="team_bg_img" name="team_bg_img" value="<?php echo $team_bg_img; ?>" /> <div onClick="clear_container_bg_image()" class="button clear-container-bg-image"> <?php _e('Clear','team'); ?></div>
                    
                    <script>
					
					function bg_img_src(img){
						
						src =img.src;
						
						document.getElementById('team_bg_img').value  = src;
						
						}
					
					function clear_container_bg_image(){

						document.getElementById('team_bg_img').value  = '';
						
						}					
					
					
					</script>
                    
                    <p class="option-info"><?php _e('Background color:','team'); ?></p>
                    <input type="text" name="team_container_bg_color" class="team_color" value="<?php if(!empty($team_container_bg_color)) echo $team_container_bg_color; ?>" />
                    
                    
                    <p class="option-info"><?php _e('Text align:','team'); ?></p>
                    <select id="team_grid_item_align" name="team_grid_item_align"  >
                    <option class="team_grid_item_align" value="left" <?php if($team_grid_item_align=="left")echo "selected"; ?>><?php _e('Left','team'); ?></option>
                    
                    <option class="team_grid_item_align" value="center" <?php if($team_grid_item_align=="center")echo "selected"; ?>><?php _e('Center','team'); ?></option>
                    
                    <option class="team_grid_item_align" value="right" <?php if($team_grid_item_align=="right")echo "selected"; ?>><?php _e('Right','team'); ?></option>
                    </select>
                    
                </div>
                
                









            
            </li>
			<li style="display: none;" class="box3 tab-box">
            
            
            

            
            
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Query orderby','team'); ?></p>
                    <p class="option-info"></p>
                    <select name="team_query_orderby" >
                        <option value="none" <?php if($team_query_orderby=="none") echo "selected"; ?>><?php _e('none', 'team'); ?></option>
                        <option value="ID" <?php if($team_query_orderby=="ID") echo "selected"; ?>><?php _e('ID', 'team'); ?></option>
                        <option value="author" <?php if($team_query_orderby=="author") echo "selected"; ?>><?php _e('Author', 'team'); ?></option>
                        <option value="title" <?php if($team_query_orderby=="title") echo "selected"; ?>><?php _e('Title', 'team'); ?></option>
                        <option value="name" <?php if($team_query_orderby=="name") echo "selected"; ?>><?php _e('Name', 'team'); ?></option>
                        <option value="type" <?php if($team_query_orderby=="type") echo "selected"; ?>><?php _e('Type', 'team'); ?></option>
                        <option value="date" <?php if($team_query_orderby=="date") echo "selected"; ?>><?php _e('Date', 'team'); ?></option>
                        <option value="post_date" <?php if($team_query_orderby=="post_date") echo "selected"; ?>><?php _e('post_date', 'team'); ?></option>
                        <option value="modified" <?php if($team_query_orderby=="modified") echo "selected"; ?>><?php _e('Modified', 'team'); ?></option>
                        <option value="parent" <?php if($team_query_orderby=="parent") echo "selected"; ?>><?php _e('Parent', 'team'); ?></option>
                        <option value="rand" <?php if($team_query_orderby=="rand") echo "selected"; ?>><?php _e('Random', 'team'); ?></option>
                        <option value="comment_count" <?php if($team_query_orderby=="comment_count") echo "selected"; ?>><?php _e('Comment Count', 'team'); ?></option>
                        <option disabled value="" ><?php _e('Menu order', 'team'); ?> (Pro feature)</option>
                        <option disabled value="" ><?php _e('Meta Value', 'team'); ?> (Pro feature)</option>
                        <option disabled value="" ><?php _e('Meta Value(number)', 'team'); ?> (Pro feature)</option>
                        <option disabled value="" ><?php _e('post__in', 'team'); ?> (Pro feature)</option>
                        <option disabled value="" ><?php _e('post_name__in', 'team'); ?> (Pro feature)</option>
                                                         
                    </select>
                    
                    <br />
                     <p class="option-info">orderby meta value</p>
					<input type="text" placeholder="meta_key" name="team_query_orderby_meta_key" id="team_query_orderby_meta_key" value="<?php if(!empty($team_query_orderby_meta_key)) echo $team_query_orderby_meta_key; ?>" />
                    
                </div> 
            
            
            
            
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Query order','team'); ?></p>
                    <p class="option-info"></p>
                    <select name="team_query_order" >
                    <option value="ASC" <?php if($team_query_order=="ASC") echo "selected"; ?>><?php _e('ASC','team'); ?></option>
                    <option value="DESC" <?php if($team_query_order=="DESC") echo "selected"; ?>><?php _e('DESC','team'); ?></option>

                    </select>
                </div>
            
            
            
            
				<div class="option-box">
                    <p class="option-title"><?php _e('Post per page.','team'); ?></p>
                    <p class="option-info"><?php _e('You can display pagination or total number of member on grid. set -1 to display all.','team'); ?></p>
                    <input type="text" placeholder="ex:5 - Number Only"   name="team_total_items" value="<?php if(!empty($team_total_items))echo $team_total_items; else echo 5; ?>" />
                </div>
                
                
				<div class="option-box">
                    <p class="option-title"><?php _e('Team groups','team'); ?></p>
                    <p class="option-info"><?php _e('Display from member group.','team'); ?></p>

					<?php
    
                        echo $class_team_functions->team_get_taxonomy_category($post->ID);
                    
                    ?>

                </div>                
                

            
            </li>
            
          
            
            <li style="display: none;" class="box5 tab-box">
				<div class="option-box">
                    <p class="option-title"><?php _e('Custom CSS for this Team Grid.','team'); ?></p>
                    <p class="option-info"><?php _e('Do not use &lt;style>&lt;/style> tag, you can use bellow prefix to your css, sometime you need use "!important" to overrid.','team'); ?>
                    <br/>
                    <b>#team-<?php echo $team_id ; ?></b>
                    </p>
                   	<?php
                    
					$empty_css_sample = '.team-container #team-'.$team_id.'{}\n.team-container #team-'.$team_id.' .team-item{}\n.team-container #team-'.$team_id.' .team-thumb{}\n.team-container #team-'.$team_id.' .team-title{}\n.team-container #team-'.$team_id.' .team-content{}';
					
					
					?>

                    <textarea style="width:80%; min-height:150px" name="team_items_custom_css"><?php if(!empty($team_items_custom_css)) echo htmlentities($team_items_custom_css); else echo str_replace('\n', PHP_EOL, $empty_css_sample); ?></textarea>
                    
				</div>
            
            
            </li>
            
                      
            
            <li style="display: none;" class="box6 tab-box">
				<div class="option-box">
                    <p class="option-title"><?php _e('Grid elements','team'); ?></p>
                    <p class="option-info"><?php _e('You can sort grid items from here.','team'); ?></p>
                    
                    <div class="team-grid-builder">
                    
                    <div class="nav-top">
                    
                    <label><input <?php if($team_grid_style=='grid') echo 'checked'; ?> type="radio" name="team_grid_style" class="team_grid_style" value="grid" />Grid</label>
                    <label><input disabled  type="radio" name="team_grid_style" class="team_grid_style" value="" />Filterable <span class="team-pro" title="Only available in premium.">Pro</span> </label>
                    <label><input disabled type="radio" name="team_grid_style" class="team_grid_style" value="" />Slider <span class="team-pro" title="Only available in premium.">Pro</span></label>
                    
                    

                    </div>
                    
                    <div class="expandable">
                  
                    
                    <?php
                    $class_team_functions = new class_team_functions();
					
					if(empty($team_grid_items))
						{

							$team_grid_items = $class_team_functions->team_grid_items();

						}
					else
						{
							
							$team_grid_items = array_merge($team_grid_items,$class_team_functions->team_grid_items());
						}
					
					
					foreach($team_grid_items as $item_key=>$item_name){

							?>
                            <div class="item" title="Click to expand">
                                <div class="header">
                                    <span class="move"><i class="fa fa-bars"></i></span>
                                    <span class="expand"><i class="fa fa-expand"></i><i class="fa fa-compress"></i></span> 
                                    <label title="Checked to Hide on frontend">
                            <?php
							
							
							if(!empty($team_grid_items_hide[$item_key])){
								
									$checked = 'checked';
								}
							else{
									$checked = '';
								}
								
								
								
							echo '<input type="checkbox"  '.$checked.' value="yes" name="team_grid_items_hide['.$item_key.']" />';				
							echo 'Hide on Frontend</label>';
							echo '<input type="hidden" name="team_grid_items['.$item_key.']" value="'.$item_key.'"/>';
							echo $item_name.'</div>';
							
							if($item_key == 'meta'){
									
								if(empty($team_grid_meta_keys))
									{
										$team_grid_meta_keys = array();
									}
								
								?>
								<div class="options">
								<div class="option-box">
									<p class="option-title"><?php _e('Meta key.','team'); ?></p>
									<div class="meta-key-list">
									<?php
									
									//var_dump($team_grid_meta_keys);
									if(is_array($team_grid_meta_keys)){
										
										}
									else{
										
											$meta_keys = explode(',',$team_grid_meta_keys);
											//var_dump($meta_keys);
											
											$team_grid_meta_keys = array();
											
											foreach($meta_keys as $keys){
												
												$team_grid_meta_keys[] = array('key'=>$keys, 'wrapper'=>'%s'
																				
																			);
												
												
												}
											

											
											//var_dump($team_grid_meta_keys);
										}
									
									
									
									foreach($team_grid_meta_keys as $id=>$meta_info){
										
											$wrapper = $meta_info['wrapper'];
											$key = $meta_info['key'];
											
											//var_dump($meta_data);
											
											?>
											<div>
											<span class="remove"><i class="fa fa-times" aria-hidden="true"></i></span>
											<span class="move"><i class="fa fa-bars" aria-hidden="true"></i></span>
											<input placeholder="<div>%s</div>" type="text" name="team_grid_meta_keys[<?php echo $id; ?>][wrapper]" value="<?php echo esc_textarea($wrapper); ?>" />  
											<input placeholder="meta_key" type="text" name="team_grid_meta_keys[<?php echo $id; ?>][key]" value="<?php echo $key; ?>" />
											</div>
											<?php

										
										
										}
									?>
									
									</div>

									<div class="button add-meta-key"><?php _e('Add more', 'team'); ?></div>
									
								</div>
								<div class="option-box">
									<p class="option-title"><?php _e('Font family.','team'); ?></p>
									<p class="option-info"></p>
									<input type="text" name="team_items_meta_font_family" placeholder="Open Sans" id="team_items_meta_font_family" value="<?php if(!empty($team_items_meta_font_family)) echo $team_items_meta_font_family; ?>" />
								</div>
							</div>
                                        
                                        <?php

									
								}
							elseif($item_key == 'thumbnail'){
								
								?>
                                <div class="options">
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Thumbnail Size.','team'); ?></p>
                                        <p class="option-info"><?php _e('Thumbnail size of member on grid.','team'); ?></p>
                                        <select name="team_items_thumb_size" >
										<?php

										$get_intermediate_image_sizes =  get_intermediate_image_sizes();
										foreach($get_intermediate_image_sizes as $size_key){
											
											?>
											<option value="<?php echo $size_key; ?>" <?php if($team_items_thumb_size==$size_key)echo "selected"; ?>>
											<?php 
											
											$size_key = str_replace('_', ' ',$size_key);
											$size_key = str_replace('-', ' ',$size_key);						
											$size_key = ucfirst($size_key);
					
											echo $size_key; 
											
											?>
											</option>

											<?php
											}

											?>      
                                        </select>
                                    </div> 
                                    
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Grid item thumbnail max Height(px).','team'); ?></p>
                                        <p class="option-info"><?php _e('Maximum Height for grid items thumbnail.','team'); ?></p>
                                        

                                            
                                        <div>
                                        <?php _e('For Destop: (min-width:1024px)','team'); ?> <br/>
                                        <input type="text" name="team_items_thumb_max_hieght" placeholder="ex:220px" id="team_items_thumb_max_hieght" value="<?php if(!empty($team_items_thumb_max_hieght)) echo $team_items_thumb_max_hieght; ?>" />
                                        </div>
                                        
                                        <br>
                    
                                        <div>
                                        <?php _e('For Tablet: ( min-width:768px )','team'); ?> <br/>
                                        <input type="text" name="team_items_thumb_max_hieght_tablet" placeholder="ex:1000px" id="team_items_thumb_max_hieght_tablet" value="<?php if(!empty($team_items_thumb_max_hieght_tablet)) echo $team_items_thumb_max_hieght_tablet; ?>" />                    
                                        </div> 
                                        <br>
                                        
                                        <div>             
                                        <?php _e('For Mobile: ( min-width : 320px, )','team'); ?> <br/>
                                        <input type="text" name="team_items_thumb_max_hieght_mobile" placeholder="ex:1000px" id="team_items_thumb_max_hieght_mobile" value="<?php if(!empty($team_items_thumb_max_hieght_mobile)) echo $team_items_thumb_max_hieght_mobile; ?>" />
                                        </div>
                                        
                                        
                                        
                                        
                                        
                                        
                                    </div>
                                    
                                    
    
                                    
                                    
                                    
                                    
                                </div>
                                <?php
								
							}								
								
							elseif($item_key == 'title'){
								
								?>
                                <div class="options">
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Font Color.','team'); ?></p>
                                        <p class="option-info"></p>
                                        <input type="text" name="team_items_title_color" id="team_items_title_color" value="<?php if(!empty($team_items_title_color)) echo $team_items_title_color; else echo "#333"; ?>" />
                                    </div>
                                    
                                    
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Font Size.','team'); ?></p>
                                        <p class="option-info"></p>
                                        <input type="text" name="team_items_title_font_size" placeholder="ex:14px number with px" id="team_items_title_font_size" value="<?php if(!empty($team_items_title_font_size)) echo $team_items_title_font_size; else echo "14px"; ?>" />
                                    </div>
                                    
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Font family.','team'); ?></p>
                                        <p class="option-info"></p>
                                        <input type="text" name="team_items_title_font_family" placeholder="Open Sans" id="team_items_title_font_family" value="<?php if(!empty($team_items_title_font_family)) echo $team_items_title_font_family; ?>" />
                                    </div>                                    
                                    
                                    
                                    
                                </div>
                                <?php
								
							}
								
							elseif($item_key == 'position'){
								
								?>
                                <div class="options">
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Member Position Font Color.','team'); ?></p>
                                        <p class="option-info"></p>
                                        <input type="text" name="team_items_position_color" placeholder="#ffffff" id="team_items_position_color" value="<?php if(!empty($team_items_position_color)) echo $team_items_position_color; else echo "#333"; ?>" />
                                    </div>
                    
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Member Position Font Size.','team'); ?></p>
                                        <p class="option-info"></p>
                                        <input type="text" name="team_items_position_font_size" placeholder="ex:12px number with px" id="team_items_position_font_size" value="<?php if(!empty($team_items_position_font_size)) echo $team_items_position_font_size; else echo "13px"; ?>" />
                                    </div>
                                    
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Font family.','team'); ?></p>
                                        <p class="option-info"></p>
                                        <input type="text" name="team_items_position_font_family" placeholder="Open Sans" id="team_items_position_font_family" value="<?php if(!empty($team_items_position_font_family)) echo $team_items_position_font_family; ?>" />
                                    </div> 
                                    
                                    
                                    
                                    
                                    
                                    
                                </div>
                                <?php
							}		
							
							elseif($item_key == 'social'){
								
								?>

                                
                                
                                <div class="options">
                                
                                
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Social icon type.','team'); ?></p>
                                        <p class="option-info"><?php // _e('','team'); ?></p>
                                        <select name="team_items_social_icon_type"  >
                                        <option  value="image_icon" <?php if($team_items_social_icon_type=="image_icon")echo "selected"; ?>><?php _e('Image icon','team'); ?></option>
                                        <option  value="text_link" <?php if($team_items_social_icon_type=="text_link")echo "selected"; ?>><?php _e('Text link','team'); ?></option>

                                        </select>
                                    </div>
                                
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Social icons size(px).','team'); ?></p>
                                        <p class="option-info"><?php _e('you can change social icons height & width here.','team'); ?></p>					Width:<br />
                                        <input type="text" name="team_items_social_icon_width" placeholder="ex:20px number with px"  value="<?php if(!empty($team_items_social_icon_width)) echo $team_items_social_icon_width; else echo "25px"; ?>" />
                                        <br />
                                        Height:<br/>
                                        <input type="text" name="team_items_social_icon_height" placeholder="ex:20px number with px"  value="<?php if(!empty($team_items_social_icon_height)) echo $team_items_social_icon_height; else echo "25px"; ?>" />
                                    </div>            
                                
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Social icon style.','team'); ?></p>
                                        <p class="option-info"><?php // _e('','team'); ?></p>
                                        <select name="team_social_icon_style"  >
                                        <option  value="flat" <?php if($team_social_icon_style=="flat")echo "selected"; ?>><?php _e('Flat','team'); ?></option>
                                        <option  value="rounded" <?php if($team_social_icon_style=="rounded")echo "selected"; ?>><?php _e('Rounded','team'); ?></option>
                                        <option  value="rounded-border" <?php if($team_social_icon_style=="rounded-border")echo "selected"; ?>><?php _e('Rounded Border','team'); ?></option>
                                        <option  value="semi-rounded" <?php if($team_social_icon_style=="semi-rounded")echo "selected"; ?>><?php _e('Semi Rounded','team'); ?></option>
                                        </select>
                                    </div>
                                    
                                    
                                    
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Font family.','team'); ?></p>
                                        <p class="option-info"></p>
                                        <input type="text" name="team_items_social_font_family" placeholder="Open Sans" id="team_items_social_font_family" value="<?php if(!empty($team_items_social_font_family)) echo $team_items_social_font_family; ?>" />
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                </div>
                                <?php
							}							
							
							
							
							
							
							
							
													
							elseif($item_key == 'content'){
								
								?>
                                <div class="options">

                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Member Bio Content Display.','team'); ?></p>
                                        <p class="option-info"></p>
                                        <ul class="content_source_area" >
                                            <li>
                                                <input class="team_content_source" name="team_items_content" id="team_items_content" type="radio" value="full" <?php if($team_items_content=="full")  echo "checked";?> /> 
                                                <label for="team_items_content"><?php _e('Display full content.','team'); ?></label>
                                                <div class="team_items_content content-source-box">
                                                <?php _e('Member bio content will display from full content.','team'); ?>
                                                </div>
                                            </li>
                                            <li>
                                                <input class="team_content_source" name="team_items_content" id="team_items_excerpt" type="radio" value="excerpt" <?php if($team_items_content=="excerpt")  echo "checked";?> /> 
                                                <label for="team_items_excerpt"><?php _e('Display excerpt','team'); ?></label>
                                                <div class="team_items_excerpt content-source-box">
                                                <?php _e('Member bio content will display from excerpt.','team'); ?><br />
                                                <?php _e('Excrept Length:','team'); ?>
                                                <input type="text" placeholder="25" size="4" name="team_items_excerpt_count" value="<?php if(!empty($team_items_excerpt_count))  echo $team_items_excerpt_count; else echo 30; ?>" />
                                                <br />
                                                <?php _e('Read More Text:','team'); ?>
                                                <input type="text" placeholder="Read More..." size="10" name="team_items_excerpt_text" value="<?php if(!empty($team_items_excerpt_text))  echo $team_items_excerpt_text; else echo 'Read More'; ?>" />
                                                
                                                </div>
                                            </li>                        
                    
                                        </ul>
                                    </div>

                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Font Color.','team'); ?></p>
                                        <p class="option-info"></p>
                                        <input type="text" name="team_items_content_color" id="team_items_content_color" value="<?php if(!empty($team_items_content_color)) echo $team_items_content_color; else echo "#333"; ?>" />
                                    </div>
                    
                    
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Font Size.','team'); ?></p>
                                        <p class="option-info"></p>
                                        <input type="text" placeholder="ex:12px number with px" name="team_items_content_font_size" id="team_items_content_font_size" value="<?php if(!empty($team_items_content_font_size)) echo $team_items_content_font_size; else echo "13px"; ?>" />
                                    </div>
                                    
                                    
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Font family.','team'); ?></p>
                                        <p class="option-info"></p>
                                        <input type="text" name="team_items_content_font_family" placeholder="Open Sans" id="team_items_content_font_family" value="<?php if(!empty($team_items_content_font_family)) echo $team_items_content_font_family; ?>" />
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                </div>
                                <?php
							}									
								
							elseif($item_key == 'popup'){
								?>
                                <div class="options">
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Member Bio Popup Content Display.','team'); ?> </p>
                                        <p class="option-info"></p>
                                        <ul class="content_source_area" >
                                            <li>
                                                <input class="team_content_source" name="team_items_popup_content" id="team_items_popup_content" type="radio" value="full" <?php if($team_items_popup_content=="full")  echo "checked";?> /> 
                                                <label for="team_items_popup_content"><?php _e('Display full content.','team'); ?></label>
                                                <div class="team_items_popup_content content-source-box">
                                                <?php _e('Member bio content will display from full content.','team'); ?>
                                                </div>
                                            </li>
                                            
                                            
                                            <li>
                                                <input class="team_content_source" name="team_items_popup_content" id="team_items_popup_excerpt" type="radio" value="excerpt" <?php if($team_items_popup_content=="excerpt")  echo "checked";?> /> 
                                                <label for="team_items_popup_excerpt"><?php _e('Display excerpt.','team'); ?></label>
                                                <div class="team_items_popup_excerpt content-source-box">
                                                <?php _e('Member bio content will display from excerpt.','team'); ?><br />
                                                <?php _e('Excrept Length:','team'); ?>
                                                <input type="text" placeholder="25" size="4" name="team_items_popup_excerpt_count" value="<?php if(!empty($team_items_popup_excerpt_count))  echo $team_items_popup_excerpt_count; else echo '25'; ?>" />
                                                <br />
                                                <?php _e('Read More Text:','team'); ?>
                                                <input type="text" placeholder="Read More..." size="10" name="team_items_popup_excerpt_text" value="<?php if(!empty($team_items_popup_excerpt_text))  echo $team_items_popup_excerpt_text; else echo 'Read More'; ?>" />
                                                
                                                </div>
                                            </li>                        
                    
                                        </ul>
                                    </div>
                                    
                                    
                                    
                                    
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Popup box width.','team'); ?></p>
                                        <p class="option-info"></p>
                                        <input type="text" placeholder="80%" name="team_items_popup_width" id="team_items_popup_width" value="<?php if(!empty($team_items_popup_width)) echo $team_items_popup_width; else echo "80%"; ?>" />
                                    </div>
                                    
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Popup box height.','team'); ?></p>
                                        <p class="option-info"></p>
                                        <input type="text" placeholder="70%" name="team_items_popup_height" id="team_items_popup_height" value="<?php if(!empty($team_items_popup_height)) echo $team_items_popup_height; else echo "70%"; ?>" />
                                    </div>                                   
                                    
                                    
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Thumbnail Size.','team'); ?></p>
                                        <p class="option-info"><?php _e('Thumbnail size of member on popup.','team'); ?></p>
                                        <select name="team_items_popup_thumb_size" >
										<?php

										$get_intermediate_image_sizes =  get_intermediate_image_sizes();
										foreach($get_intermediate_image_sizes as $size_key){
											
											?>
											<option value="<?php echo $size_key; ?>" <?php if($team_items_popup_thumb_size==$size_key)echo "selected"; ?>>
											<?php 
											
											$size_key = str_replace('_', ' ',$size_key);
											$size_key = str_replace('-', ' ',$size_key);						
											$size_key = ucfirst($size_key);
					
											echo $size_key; 
											
											?>
											</option>

											<?php
											}

											?>      
                                        </select>
                                    </div> 
                                    
                                    
                                    
                                </div>
                                <?php
								
								
								
								
								
								
								
								
								}	
							elseif($item_key == 'skill'){
								?>
                                <div class="options">
                                    <div class="option-box">
                                        <p class="option-title"><?php _e('Font Color.','team'); ?></p>
                                        <p class="option-info"></p>
                                        <input type="text" name="team_items_skill_bg_color" id="team_items_skill_bg_color" value="<?php if(!empty($team_items_skill_bg_color)) echo $team_items_skill_bg_color; else echo "#399fe7"; ?>" />
                                    </div>
                                </div>
                                
                                <?php
								
							}
								
							
							
							echo '</div>';
						}
					
					?>
                    </div>  
                    <div class="nav-bottom">
                    

                    
                    
                    <label><input  <?php if($team_pagination_type=='none'){ echo 'checked'; } ?> type="radio" name="team_pagination_type" value="none" />None</label>
                    <label><input <?php if($team_pagination_type=='pagination'){ echo 'checked'; } ?> type="radio" name="team_pagination_type" value="pagination" />Pagination</label>                    
                    <label><input disabled  type="radio" name="team_pagination_type" value="" />Jquery Pagination <span class="team-pro" title="Only available in premium.">Pro</span></label>
                    
                    </div>  
                        
                    </div>
                    
					 <script>
						 jQuery(document).ready(function($)
							{
								$(function() {
								$( ".team-grid-builder .expandable" ).sortable({ handle: '.move' });
								$( ".meta-key-list" ).sortable({ handle: '.move' });
								//$( ".items-container" ).disableSelection();
								});
						
						})
                    
                    </script>

                    
				</div>
                
				<div class="option-box">
                    <p class="option-title"><?php _e('Active Masonry Grid.','team'); ?></p>
                    <p class="option-info"><?php _e('Masonry Style grid.','team'); ?></p>
                    <select name="team_masonry_enable"  >
                    <option  value="no" <?php if($team_masonry_enable=="no")echo "selected"; ?>><?php _e('No','team'); ?></option>
                    <option  value="yes" <?php if($team_masonry_enable=="yes")echo "selected"; ?>><?php _e('Yes','team'); ?></option>
             
                    </select>
				</div>   
                
                
				<div class="option-box">
                
  
                
                    <p class="option-title"><?php _e('Pagination.','team'); ?></p>
                    
                    
                    <p class="option-info"><?php _e('Pagination Previous text.','team'); ?></p>
                    <input type="text" placeholder="3" name="team_pagination_prev_text" id="team_pagination_prev_text" value="<?php if(!empty($team_pagination_prev_text)) echo $team_pagination_prev_text; else echo "« Previous"; ?>" />
                    
                    <p class="option-info"><?php _e('Pagination Next text.','team'); ?></p>
                        <input type="text" placeholder="3" name="team_pagination_next_text" id="team_pagination_next_text" value="<?php if(!empty($team_pagination_next_text)) echo $team_pagination_next_text; else echo "Next »"; ?>" />  
                    
                    <p class="option-info"><?php _e('Pagination default background color.','team'); ?></p>
                    <input type="text" name="team_pagination_bg_color" id="team_pagination_bg_color" value="<?php if(!empty($team_pagination_bg_color)) echo $team_pagination_bg_color; else echo "#2eb3f8"; ?>" />
                    
                    
                    <p class="option-info"><?php _e('Pagination active background color.','team'); ?></p>
                    <input type="text" name="team_pagination_active_bg_color" id="team_pagination_active_bg_color" value="<?php if(!empty($team_pagination_active_bg_color)) echo $team_pagination_active_bg_color; else echo "#249bd9"; ?>" />
                    
				</div>
                
                
				<div class="option-box">
                    <p class="option-title"><?php _e('Filterable','team'); ?> <span class="team-pro" title="Only available in premium">Pro</span></p>
                    <p class="option-info"><?php _e('Filterable post per page.','team'); ?></p>
                    <input type="text" placeholder="3" name="team_items_post_per_page_mixitup" id="team_items_post_per_page_mixitup" value="<?php if(!empty($team_items_post_per_page_mixitup)) echo $team_items_post_per_page_mixitup; else echo "3"; ?>" />
                    
                    <p class="option-info"><?php _e('Display group of member at first.','team'); ?></p>
                    
                    

                    <?php
                    
					//var_dump($team_taxonomy_terms);
					$team_taxonomy = 'team_group';
					if($team_items_default_filter_mixitup=='all'){
						echo '<label><input checked type="radio" name="team_items_default_filter_mixitup" value="all" />All</label><br />';
						}
					else{
						echo '<label><input type="radio" name="team_items_default_filter_mixitup" value="all" />All</label><br />';
						}
					
					if(!empty($team_taxonomy_terms))
						{
							
							
							
							foreach($team_taxonomy_terms as $term_id)
								{
									$term = get_term( $term_id, $team_taxonomy );
									$term_slug = $term->slug;
									$term_name = $term->name;
									echo '<label><input type="radio" name="team_items_default_filter_mixitup" value="'.$term_slug.'" ';
									
									if($team_items_default_filter_mixitup == $term_slug)
										{
											echo 'checked';
										}
									
									echo '/>'.$term_name.'</label><br />';

								}
						}
					else
						{
							echo __('Please select team group first from <b>Content(tab) > Filter Member > Display from Member Group','team').'</b>.';
						}
					
					?> 
                    
                    
                    <p class="option-info"><?php _e('Filterable navs default background color.','team'); ?></p>
                    <input type="text" class="team_color" name="team_filter_bg_color" id="team_filter_bg_color" value="<?php if(!empty($team_filter_bg_color)) echo $team_filter_bg_color; else echo "#2eb3f8"; ?>" />
                    
                    
                    <p class="option-info"><?php _e('Filterable navs active background color.','team'); ?></p>
                    <input type="text" class="team_color" name="team_filter_active_bg_color" id="team_filter_active_bg_color" value="<?php if(!empty($team_filter_active_bg_color)) echo $team_filter_active_bg_color; else echo "#249bd9"; ?>" />
                    
                    
                    <p class="option-info"><?php _e('Filterable navs text color.','team'); ?></p>
                    <input type="text" class="team_color" name="team_filter_text_color" id="team_filter_text_color" value="<?php if(!empty($team_filter_text_color)) echo $team_filter_text_color; else echo "#666666"; ?>" />                    
                    
                    
                    <p class="option-info"><?php _e('Scroll top when pagination clicked.','team'); ?></p>
                    <select name="team_filter_scroll_top"  >
                    <option  value="no" <?php if($team_filter_scroll_top=="no")echo "selected"; ?>><?php _e('No','team'); ?></option>
                    <option  value="yes" <?php if($team_filter_scroll_top=="yes")echo "selected"; ?>><?php _e('Yes','team'); ?></option>
             
                    </select>    
                    
   
                    
                    
				</div>
                
				
                
                
                
            </li>
            
            
            
            <li style="display: none;" class="box7 tab-box">
				

				<div class="option-box">
                    <p class="option-title"><?php _e('Slider Column Number','team');?></p>
                    
                    <p class="option-info"><?php _e('In Destop: (min:1000px and max)','team');?></p>
					<input type="text" placeholder="4"   name="team_column_number" value="<?php echo $team_column_number;  ?>" />

                    <p class="option-info"><?php _e('In Tablet & Small Desktop: (900px max width)','team');?></p>
                    <input type="text" placeholder="2"  name="team_column_number_tablet" value="<?php echo $team_column_number_tablet;  ?>" />  
                   
                    <p class="option-info"><?php _e('In Mobile: (479px max width)','team');?></p>
                    <input type="text" placeholder="1"  name="team_column_number_mobile" value="<?php echo $team_column_number_mobile;  ?>" />
                    
                  
                               
                </div>   

				<div class="option-box">
                    <p class="option-title"><?php _e('Slider Auto Play','team');?></p>
                    <p class="option-info"></p>
                    
                    
                        <select name="team_auto_play">
                            <option value="true" <?php if(($team_auto_play=="true")) echo "selected"; ?> ><?php _e('True','team');?></option>
                            <option value="false" <?php if(($team_auto_play=="false")) echo "selected"; ?> ><?php _e('False','team');?></option>
                        </select>

                </div>     
				<div class="option-box">
                    <p class="option-title"><?php _e('Slider Stop on Hover','team');?></p>
                    <p class="option-info"></p>
                    
                        <select name="team_stop_on_hover">
                            <option value="true" <?php if(($team_stop_on_hover=="true")) echo "selected"; ?> ><?php _e('True','team');?></option>
                            <option value="false" <?php if(($team_stop_on_hover=="false")) echo "selected"; ?> ><?php _e('False','team');?></option>
                        </select>
                    
                
                </div>   
				<div class="option-box">
                    <p class="option-title"><?php _e('Slider Navigation','team');?></p>
                    <p class="option-info"><?php _e('Slider Navigation at Top','team');?></p>
                    
                        <select name="team_slider_navigation">
                            <option value="true" <?php if(($team_slider_navigation=="true")) echo "selected"; ?> ><?php _e('True','team');?></option>
                            <option value="false" <?php if(($team_slider_navigation=="false")) echo "selected"; ?> ><?php _e('False','team');?></option>
                        </select>

                        
                        <p class="option-info"><?php _e('Slider Navigation Position','team');?></p>
                        <select name="team_slider_navigation_position">
                            <option value="middle" <?php if(($team_slider_navigation_position=="middle")) echo "selected"; ?> ><?php _e('Middle','team');?></option>

                        </select>
                        
                                        
                </div>

                
                
				<div class="option-box">
                    <p class="option-title"><?php _e('Slider Pagination','team');?></p>
                    <p class="option-info"><?php _e('Slider Pagination at Bottom','team');?></p>
                    
                        <select name="team_slider_pagination">
                            <option value="true" <?php if(($team_slider_pagination=="true")) echo "selected"; ?> ><?php _e('True','team');?></option>
                            <option value="false" <?php if(($team_slider_pagination=="false")) echo "selected"; ?> ><?php _e('False','team');?></option>
                        </select>
 
                        
                        
                       <p class="option-info"><?php _e('Pagination Background Color','team');?></p>
                        <input type="text" name="team_slider_pagination_bg" class="team_color" id="team_slider_pagination_bg" value="<?php if(!empty($team_slider_pagination_bg)) echo $team_slider_pagination_bg; else echo "#1eb286"; ?>" />
                        
                        <p class="option-info"><?php _e('Pagination Text Color','team');?></p>
                        <input type="text" name="team_slider_pagination_text_color" class="team_color" id="team_slider_pagination_text_color" value="<?php if(!empty($team_slider_pagination_text_color)) echo $team_slider_pagination_text_color; else echo "#fff"; ?>" /> 
                        
                        <p class="option-info"><?php _e('Pagination Number Counting','team');?></p>
                        <select name="team_slider_pagination_count">
                        	<option value="false" <?php if(($team_slider_pagination_count=="false")) echo "selected"; ?> ><?php _e('False','team');?></option>
                            <option value="true" <?php if(($team_slider_pagination_count=="true")) echo "selected"; ?> ><?php _e('True','team');?></option>
                            
                        </select>
                        
  
                        
                                       
                </div>
                

                
				     
				<div class="option-box">
                    <p class="option-title"><?php _e('Slide Speed','team');?></p>
                    <p class="option-info"></p>
					<input type="text" id="team_slide_speed" name="team_slide_speed" value="<?php if(!empty($team_slide_speed)) echo $team_slide_speed; else echo "1000"; ?>"  />                 
                </div>   
				<div class="option-box">
                    <p class="option-title"><?php _e('Pagination Slide Speed','team');?></p>
                    <p class="option-info"></p>
					<input type="text" id="team_pagination_slide_speed" name="team_pagination_slide_speed" value="<?php if(!empty($team_pagination_slide_speed)) echo $team_pagination_slide_speed; else echo "1000"; ?>"  />                 
                </div>
                
				<div class="option-box">
                    <p class="option-title"><?php _e('Slider Touch Drag Enabled','team');?></p>
                    <p class="option-info"></p>
                    
                    
                        <select name="team_slider_touch_drag">
                            <option value="true" <?php if(($team_slider_touch_drag=="true")) echo "selected"; ?> ><?php _e('True','team');?></option>
                            <option value="false" <?php if(($team_slider_touch_drag=="false")) echo "selected"; ?> ><?php _e('False','team');?></option>
                        </select>
                    
                 
                </div>       
				<div class="option-box">
                    <p class="option-title"><?php _e('Slider Mouse Drag Enabled','team');?></p>
                    <p class="option-info"></p>
                    
                        <select name="team_slider_mouse_drag">
                            <option value="true" <?php if(($team_slider_mouse_drag=="true")) echo "selected"; ?> ><?php _e('True','team');?></option>
                            <option value="false" <?php if(($team_slider_mouse_drag=="false")) echo "selected"; ?> ><?php _e('False','team');?></option>
                        </select>
                    
                
                </div>  
            
            </li>
            
            
            
            
            
            
            
            
		</ul><!-- box end -->
        
    </div>
    

    
			<script>
				jQuery(document).ready(function($){
					$('#team_items_position_color, #team_items_content_color, #team_items_title_color ').wpColorPicker();
				});
			</script>
    
    
    
    <?php
		
		
		
		

    }
	
	
public function meta_boxes_team_save($post_id) {
 
        /*
         * We need to verify this came from the our screen and with 
         * proper authorization,
         * because save_post can be triggered at other times.
         */
 
        // Check if our nonce is set.
        if (!isset($_POST['team_nonce_check_value']))
            return $post_id;
 
        $nonce = $_POST['team_nonce_check_value'];
 
        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'team_nonce_check'))
            return $post_id;
 
        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;
 
        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {
 
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
 
        } else {
 
            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }
 
        /* OK, its safe for us to save the data now. */
 
  // Sanitize user input.
	$team_bg_img = sanitize_text_field( $_POST['team_bg_img'] );
	$team_container_bg_color = sanitize_text_field( $_POST['team_container_bg_color'] );	
	
	$team_themes = sanitize_text_field( $_POST['team_themes'] );
	$team_social_icon_style = sanitize_text_field( $_POST['team_social_icon_style'] );	
	$team_masonry_enable = sanitize_text_field( $_POST['team_masonry_enable'] );	
	
	$team_grid_item_align = sanitize_text_field( $_POST['team_grid_item_align'] );	
	$team_item_text_align = sanitize_text_field( $_POST['team_item_text_align'] );	
	$team_total_items = sanitize_text_field( $_POST['team_total_items'] );		
	//$team_pagination_display = sanitize_text_field( $_POST['team_pagination_display'] );

	$team_items_content = sanitize_text_field( $_POST['team_items_content'] );
	$team_items_excerpt_count = sanitize_text_field( $_POST['team_items_excerpt_count'] );	
	$team_items_excerpt_text = sanitize_text_field( $_POST['team_items_excerpt_text'] );	
	
	$team_query_order = sanitize_text_field( $_POST['team_query_order'] );	
	$team_query_orderby = sanitize_text_field( $_POST['team_query_orderby'] );		
	$team_query_orderby_meta_key = sanitize_text_field( $_POST['team_query_orderby_meta_key'] );	
	

	//$team_content_year = sanitize_text_field( $_POST['team_content_year'] );
	//$team_content_month = sanitize_text_field( $_POST['team_content_month'] );
	//$team_content_month_year = sanitize_text_field( $_POST['team_content_month_year'] );
		
	if(empty($_POST['team_taxonomy_terms']))
		{
			$_POST['team_taxonomy_terms'] = '';
		}
		
	$team_taxonomy_terms = stripslashes_deep( $_POST['team_taxonomy_terms'] );
	


	
	$team_items_title_color = sanitize_text_field( $_POST['team_items_title_color'] );	
	$team_items_title_font_size = sanitize_text_field( $_POST['team_items_title_font_size'] );	
	$team_items_title_font_family = sanitize_text_field( $_POST['team_items_title_font_family'] );	

	$team_items_position_color = sanitize_text_field( $_POST['team_items_position_color'] );
	$team_items_position_font_size = sanitize_text_field( $_POST['team_items_position_font_size'] );	

	$team_items_content_color = sanitize_text_field( $_POST['team_items_content_color'] );	
	$team_items_content_font_size = sanitize_text_field( $_POST['team_items_content_font_size'] );	
	
	$team_pagination_bg_color = sanitize_text_field( $_POST['team_pagination_bg_color'] );	
	$team_pagination_active_bg_color = sanitize_text_field( $_POST['team_pagination_active_bg_color'] );	

	$team_items_thumb_size = sanitize_text_field( $_POST['team_items_thumb_size'] );
	$team_items_link_to_post = sanitize_text_field( $_POST['team_items_link_to_post'] );	
	$team_items_max_width = sanitize_text_field( $_POST['team_items_max_width'] );
	$team_items_width_mobile = sanitize_text_field( $_POST['team_items_width_mobile'] );
	$team_items_width_tablet = sanitize_text_field( $_POST['team_items_width_tablet'] );	
	
	$team_items_thumb_max_hieght = sanitize_text_field( $_POST['team_items_thumb_max_hieght'] );
	$team_items_thumb_max_hieght_tablet = sanitize_text_field( $_POST['team_items_thumb_max_hieght_tablet'] );	
	$team_items_thumb_max_hieght_mobile = sanitize_text_field( $_POST['team_items_thumb_max_hieght_mobile'] );	
		
	
	$team_items_margin = sanitize_text_field( $_POST['team_items_margin'] );	
	
	$team_items_social_icon_type = sanitize_text_field( $_POST['team_items_social_icon_type'] );		
	$team_items_social_icon_width = sanitize_text_field( $_POST['team_items_social_icon_width'] );	
	$team_items_social_icon_height = sanitize_text_field( $_POST['team_items_social_icon_height'] );
				
	$team_items_custom_css = sanitize_text_field( $_POST['team_items_custom_css'] );
	
	
	$team_items_popup_content = sanitize_text_field( $_POST['team_items_popup_content'] );
	$team_items_popup_excerpt_count = sanitize_text_field( $_POST['team_items_popup_excerpt_count'] );
	$team_items_popup_excerpt_text = sanitize_text_field( $_POST['team_items_popup_excerpt_text'] );
	$team_items_popup_width = sanitize_text_field( $_POST['team_items_popup_width'] );
	$team_items_popup_height = sanitize_text_field( $_POST['team_items_popup_height'] );
	$team_items_popup_thumb_size = sanitize_text_field( $_POST['team_items_popup_thumb_size'] );


	$team_items_post_per_page_mixitup = sanitize_text_field( $_POST['team_items_post_per_page_mixitup'] );
	
	
	if(empty($_POST['team_items_default_filter_mixitup']))
		{
			$_POST['team_items_default_filter_mixitup'] = '';
		}
	$team_items_default_filter_mixitup = sanitize_text_field( $_POST['team_items_default_filter_mixitup'] );
 
	$team_grid_items = stripslashes_deep( $_POST['team_grid_items'] ); 
	
	if(!empty($_POST['team_grid_items_hide'])){
		$team_grid_items_hide = stripslashes_deep( $_POST['team_grid_items_hide'] ); 
		}
	else{
		$team_grid_items_hide = array(); 
		}
	
	$team_grid_meta_keys = stripslashes_deep( $_POST['team_grid_meta_keys'] );





 	$team_items_skill_bg_color = sanitize_text_field( $_POST['team_items_skill_bg_color'] ); 
	
   	$team_pagination_prev_text = sanitize_text_field( $_POST['team_pagination_prev_text'] ); 
  	$team_pagination_next_text = sanitize_text_field( $_POST['team_pagination_next_text'] );  
  	$team_grid_style = sanitize_text_field( $_POST['team_grid_style'] );  
  	$team_pagination_type = sanitize_text_field( $_POST['team_pagination_type'] ); 
 
  	$team_filter_active_bg_color = sanitize_text_field( $_POST['team_filter_active_bg_color'] ); 
  	$team_filter_bg_color = sanitize_text_field( $_POST['team_filter_bg_color'] ); 	
  	$team_filter_text_color = sanitize_text_field( $_POST['team_filter_text_color'] );	
   	$team_filter_scroll_top = sanitize_text_field( $_POST['team_filter_scroll_top'] );	
 
		
	$team_column_number = sanitize_text_field( $_POST['team_column_number'] );
	$team_column_number_mobile = sanitize_text_field( $_POST['team_column_number_mobile'] );
	$team_column_number_tablet = sanitize_text_field( $_POST['team_column_number_tablet'] );	
	$team_auto_play = sanitize_text_field( $_POST['team_auto_play'] );
	$team_stop_on_hover = sanitize_text_field( $_POST['team_stop_on_hover'] );
	$team_slider_navigation = sanitize_text_field( $_POST['team_slider_navigation'] );
	$team_slider_navigation_position = sanitize_text_field( $_POST['team_slider_navigation_position'] );		
	$team_slide_speed = sanitize_text_field( $_POST['team_slide_speed'] );
	$team_slider_pagination = sanitize_text_field( $_POST['team_slider_pagination'] );
	$team_pagination_slide_speed = sanitize_text_field( $_POST['team_pagination_slide_speed'] );
	$team_slider_pagination_count = sanitize_text_field( $_POST['team_slider_pagination_count'] );
	$team_slider_pagination_bg = sanitize_text_field( $_POST['team_slider_pagination_bg'] );
	$team_slider_pagination_text_color = sanitize_text_field( $_POST['team_slider_pagination_text_color'] );	
	$team_slider_touch_drag = sanitize_text_field( $_POST['team_slider_touch_drag'] );
	$team_slider_mouse_drag = sanitize_text_field( $_POST['team_slider_mouse_drag'] );
 
 
 
 
 
 
 
 
 
 
  // Update the meta field in the database.
	update_post_meta( $post_id, 'team_bg_img', $team_bg_img );
	update_post_meta( $post_id, 'team_container_bg_color', $team_container_bg_color );	
	
	update_post_meta( $post_id, 'team_themes', $team_themes );
	update_post_meta( $post_id, 'team_social_icon_style', $team_social_icon_style );	
	update_post_meta( $post_id, 'team_masonry_enable', $team_masonry_enable );	
	
	update_post_meta( $post_id, 'team_grid_item_align', $team_grid_item_align );	
	update_post_meta( $post_id, 'team_item_text_align', $team_item_text_align );	
	update_post_meta( $post_id, 'team_total_items', $team_total_items );	
	//update_post_meta( $post_id, 'team_pagination_display', $team_pagination_display );

	update_post_meta( $post_id, 'team_query_order', $team_query_order );
	update_post_meta( $post_id, 'team_query_orderby', $team_query_orderby );
	update_post_meta( $post_id, 'team_query_orderby_meta_key', $team_query_orderby_meta_key );	

	update_post_meta( $post_id, 'team_items_content', $team_items_content );
	update_post_meta( $post_id, 'team_items_excerpt_count', $team_items_excerpt_count );	
	update_post_meta( $post_id, 'team_items_excerpt_text', $team_items_excerpt_text );	

	//update_post_meta( $post_id, 'team_content_source', $team_content_source );
	//update_post_meta( $post_id, 'team_content_year', $team_content_year );
	//update_post_meta( $post_id, 'team_content_month', $team_content_month );
	//update_post_meta( $post_id, 'team_content_month_year', $team_content_month_year );	


	update_post_meta( $post_id, 'team_taxonomy_terms', $team_taxonomy_terms );




	update_post_meta( $post_id, 'team_items_title_color', $team_items_title_color );
	update_post_meta( $post_id, 'team_items_title_font_size', $team_items_title_font_size );
	update_post_meta( $post_id, 'team_items_title_font_family', $team_items_title_font_family );


	update_post_meta( $post_id, 'team_items_position_color', $team_items_position_color );
	update_post_meta( $post_id, 'team_items_position_font_size', $team_items_position_font_size );	

	update_post_meta( $post_id, 'team_items_content_color', $team_items_content_color );
	update_post_meta( $post_id, 'team_items_content_font_size', $team_items_content_font_size );

	update_post_meta( $post_id, 'team_pagination_bg_color', $team_pagination_bg_color );
	update_post_meta( $post_id, 'team_pagination_active_bg_color', $team_pagination_active_bg_color );

	update_post_meta( $post_id, 'team_items_thumb_size', $team_items_thumb_size );
	update_post_meta( $post_id, 'team_items_link_to_post', $team_items_link_to_post );	
	update_post_meta( $post_id, 'team_items_max_width', $team_items_max_width );
	update_post_meta( $post_id, 'team_items_width_mobile', $team_items_width_mobile );
	update_post_meta( $post_id, 'team_items_width_tablet', $team_items_width_tablet );
	
	update_post_meta( $post_id, 'team_items_thumb_max_hieght', $team_items_thumb_max_hieght );
	update_post_meta( $post_id, 'team_items_thumb_max_hieght_tablet', $team_items_thumb_max_hieght_tablet );	
	update_post_meta( $post_id, 'team_items_thumb_max_hieght_mobile', $team_items_thumb_max_hieght_mobile );	
	
	update_post_meta( $post_id, 'team_items_margin', $team_items_margin );
	
	update_post_meta( $post_id, 'team_items_social_icon_type', $team_items_social_icon_type );	
	update_post_meta( $post_id, 'team_items_social_icon_width', $team_items_social_icon_width );	
	update_post_meta( $post_id, 'team_items_social_icon_height', $team_items_social_icon_height );
	
	update_post_meta( $post_id, 'team_items_custom_css', $team_items_custom_css );
	
	
	update_post_meta( $post_id, 'team_items_popup_content', $team_items_popup_content );	
	update_post_meta( $post_id, 'team_items_popup_excerpt_count', $team_items_popup_excerpt_count );	
	update_post_meta( $post_id, 'team_items_popup_excerpt_text', $team_items_popup_excerpt_text );	
	update_post_meta( $post_id, 'team_items_popup_width', $team_items_popup_width );		
	update_post_meta( $post_id, 'team_items_popup_height', $team_items_popup_height );	
	update_post_meta( $post_id, 'team_items_popup_thumb_size', $team_items_popup_thumb_size );	
	
	update_post_meta( $post_id, 'team_items_post_per_page_mixitup', $team_items_post_per_page_mixitup );	
	update_post_meta( $post_id, 'team_items_default_filter_mixitup', $team_items_default_filter_mixitup );
	
	update_post_meta( $post_id, 'team_grid_items', $team_grid_items );
	update_post_meta( $post_id, 'team_grid_items_hide', $team_grid_items_hide );
	update_post_meta( $post_id, 'team_grid_meta_keys', $team_grid_meta_keys );
	
	update_post_meta( $post_id, 'team_items_skill_bg_color', $team_items_skill_bg_color );	
	
	
	update_post_meta( $post_id, 'team_pagination_prev_text', $team_pagination_prev_text );		
	update_post_meta( $post_id, 'team_pagination_next_text', $team_pagination_next_text );		
	update_post_meta( $post_id, 'team_grid_style', $team_grid_style );		
	update_post_meta( $post_id, 'team_pagination_type', $team_pagination_type );		
		
	update_post_meta( $post_id, 'team_filter_bg_color', $team_filter_bg_color );		
	update_post_meta( $post_id, 'team_filter_active_bg_color', $team_filter_active_bg_color );			
	update_post_meta( $post_id, 'team_filter_text_color', $team_filter_text_color );	
	update_post_meta( $post_id, 'team_filter_scroll_top', $team_filter_scroll_top );	
		
	update_post_meta( $post_id, 'team_column_number', $team_column_number );
	update_post_meta( $post_id, 'team_column_number_mobile', $team_column_number_mobile );
	update_post_meta( $post_id, 'team_column_number_tablet', $team_column_number_tablet );		
	update_post_meta( $post_id, 'team_auto_play', $team_auto_play );
	update_post_meta( $post_id, 'team_stop_on_hover', $team_stop_on_hover );	
	update_post_meta( $post_id, 'team_slider_navigation', $team_slider_navigation );
	update_post_meta( $post_id, 'team_slider_navigation_position', $team_slider_navigation_position );	
	update_post_meta( $post_id, 'team_slide_speed', $team_slide_speed );
	update_post_meta( $post_id, 'team_slider_pagination', $team_slider_pagination );
	update_post_meta( $post_id, 'team_pagination_slide_speed', $team_pagination_slide_speed );
	update_post_meta( $post_id, 'team_slider_pagination_count', $team_slider_pagination_count );
	update_post_meta( $post_id, 'team_slider_pagination_bg', $team_slider_pagination_bg );
	update_post_meta( $post_id, 'team_slider_pagination_text_color', $team_slider_pagination_text_color );		
	update_post_meta( $post_id, 'team_slider_touch_drag', $team_slider_touch_drag );
	update_post_meta( $post_id, 'team_slider_mouse_drag', $team_slider_mouse_drag );
		
		
		
		
		
    }	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	}
	
	new team_class_post_meta();