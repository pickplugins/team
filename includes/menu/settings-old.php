<?php	

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	



if(empty($_POST['team_hidden'])){
		$team_member_slug = get_option( 'team_member_slug' );		
		$team_member_meta_fields = get_option( 'team_member_meta_fields' );		
		$team_member_social_field = get_option( 'team_member_social_field' );

	}
else{	

		$nonce = $_POST['_wpnonce'];

		if(wp_verify_nonce( $nonce, 'nonce_team' ) &&  $_POST['team_hidden'] == 'Y') {
			//Form data sent

			$team_member_slug = sanitize_text_field($_POST['team_member_slug']);
			update_option('team_member_slug', $team_member_slug);

			$team_member_meta_fields = stripslashes_deep($_POST['team_member_meta_fields']);
			update_option('team_member_meta_fields', $team_member_meta_fields);

			$team_member_social_field = stripslashes_deep($_POST['team_member_social_field']);
			update_option('team_member_social_field', $team_member_social_field);

			?>
			<div class="updated"><p><strong><?php _e('Changes Saved.', 'team' ); ?></strong></p></div>
	
			<?php
			} 
	}
	



	$class_team_functions = new class_team_functions();
	$default_social_field = $class_team_functions->team_member_social_field();

?>


<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".__(team_plugin_name.' Settings', 'team')."</h2>";?>
		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="team_hidden" value="Y">
        <?php settings_fields( 'team_plugin_options' );
				do_settings_sections( 'team_plugin_options' );
			
		?>

    <div class="para-settings team-settings">
    
        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active">Options</li>       
   
        </ul> <!-- tab-nav end --> 
		<ul class="box">
       		<li style="display: block;" class="box1 tab-box active">
            
                <div class="option-box">
                    <p class="option-title"><?php _e('Team member slug.','team'); ?></p>
                    <p class="option-info"><?php _e('ex: volunteers','team'); ?></p>   
					<input type="text" size="30" placeholder="team_member_slug"   name="team_member_slug" value="<?php if(!empty($team_member_slug)) echo $team_member_slug; ?>" />
                              
            	</div>
                <div class="option-box">
                    <p class="option-title"><?php _e('Custom meta fields on team member profile.','team'); ?></p>
                    <p class="option-info"><?php //_e('','team'); ?></p>            
                
                
                
            <div class="">
                <table class="widefat team-member-meta-fields">
                <thead>
                    <tr> 
                    <th>Sorting</th>                   
                    <th>Meta Name</th>
                    <th>Meta Key</th>
                    <th>Remove</th>            
                    </tr>
                    </thead>
                    <tbody>
                    
                    <?php
                    
                    if(empty($team_member_meta_fields)){
                        
                        $team_member_meta_fields = array(
                                                    'address' => array('name'=>'Address','meta_key'=>'team_address'),
                                                    //'mobile' => array('name'=>'Mobile','meta_key'=>'team_mobile'),											
                                                );
                        
                        }
                    //var_dump($team_member_skill);
                    
                        foreach ($team_member_meta_fields as $meta_key=>$meta_info) {
                            
                            ?>
                    <tr>
                    <td class="sorting"></td>
                    <td>
                        
                        <?php //var_dump($skill_info); ?>
                    
                        <input type="text" size="30" placeholder="Meta Name"   name="team_member_meta_fields[<?php echo $meta_key; ?>][name]" value="<?php if(!empty($team_member_meta_fields[$meta_key]['name'])) echo $team_member_meta_fields[$meta_key]['name']; ?>" />
                    
                    </td>
                    <td>
                        <input type="text" size="30" placeholder="meta_key"   name="team_member_meta_fields[<?php echo $meta_key; ?>][meta_key]" value="<?php if(!empty($team_member_meta_fields[$meta_key]['meta_key'])) echo $team_member_meta_fields[$meta_key]['meta_key']; ?>" />
                    </td>
                    
                    <td>
                    <span class="remove-meta"><i class="fa fa-times"></i></span>
                    </td>            
                    </tr>
                        <?php
                        }
                ?>
                </tbody>
                </table>
                
                <div class="button add_team_member_meta">Add new</div>
            </div>
                
                
 <script>
 jQuery(document).ready(function($)
	{
		$(function() {
			$( ".team-member-meta-fields tbody" ).sortable();
			//$( ".items" ).disableSelection();
			});
		
		})

</script>
                
                
                
                </div>
            
            
            
            
            
            
			<div class="option-box">
				<p class="option-title"><?php _e('Display social field on team member profile.','team'); ?></p>
 				<p class="option-info"><?php _e('By adding bellow input you can control extra input field under member page. if you want to remove one profile field then please empty this field and save changes or to add new profile field simply click add new. some default profile fields are mobile, website, email, skype, facebook, twitter, googleplus, pinterest.','team'); ?></p>
                
            <div class="button reset_team_member_social_field">Reset</div>
			<table class="team_member_social_field widefat " id="team_member_social_field">
                <thead><tr><th>Sort</th><th>Meta name</th><th>Meta key</th><th>Icon</th><th>Visibility</th><th>Remove</th>
                
                </tr>  
              </thead>
            <?php 

			
			if(empty($team_member_social_field)){
					$team_member_social_field = $default_social_field;
				}

            foreach ($team_member_social_field as $field_key=>$field_info) {
                if(!empty($field_key))
                    {
                        ?>
                    <tr><td class="sorting"></td>
                    <td>

                    <input name="team_member_social_field[<?php echo $field_key; ?>][name]" type="text" value="<?php if(isset($team_member_social_field[$field_key]['name'])) echo $team_member_social_field[$field_key]['name']; ?>" />
                    </td>                    
                    
                    <td>
                    
					<input name="team_member_social_field[<?php echo $field_key; ?>][meta_key]" type="text" value="<?php if(isset($team_member_social_field[$field_key]['meta_key'])) echo $team_member_social_field[$field_key]['meta_key']; ?>" />
                    
                   
                    </td>
                    
                    <td>
                    <span style=" <?php if(!empty($team_member_social_field[$field_key]['icon'])) echo 'background:url('.$team_member_social_field[$field_key]['icon'].') no-repeat scroll 0 0 rgba(0, 0, 0, 0);';  ?>" title="Icon for this field." class="team_member_social_icon <?php if(empty($team_member_social_field[$field_key]['icon'])) echo 'empty_icon';?>" icon-name="<?php echo $field_key; ?>"> </span>
                    
                    <input class="team_member_social_icon team_member_social_icon_<?php echo $field_key; ?>" name="team_member_social_field[<?php echo $field_key; ?>][icon]" type="hidden" value="<?php if(isset($team_member_social_field[$field_key]['icon'])) echo $team_member_social_field[$field_key]['icon']; ?>" />
                    
                    
                    </td>
                    <td>
                    
                    <?php if(isset($team_member_social_field[$field_key]['visibility'])) $checked = 'checked'; else $checked = ''; ?>
                    
                    
                    <input <?php echo $checked; ?> name="team_member_social_field[<?php echo $field_key; ?>][visibility]" type="checkbox" value="1" />
                    
                    </td>                    
                    <td>
                    
                    <?php
                    if($field_info['can_remove']=='yes'){
					?>
                    
                    <span class="remove_icon"><i class="fa fa-times"></i></span>

                    <?php
					}
					else{
						echo '<span title="Can\'t remove.">...</span>';
						
						}
					
					?>
                    
                    <input name="team_member_social_field[<?php echo $field_key; ?>][can_remove]" type="hidden" value="<?php echo $field_info['can_remove']; ?>" />
                    
                    
                    </td>
                    
                    
                    </tr>
                        <?php
						
						
                    
                    }
            }
            
            ?>

                    
                    </table> 
                    
        
        
 
        
 <script>
 jQuery(document).ready(function($)
	{
		$(function() {
			$( "#team_member_social_field tbody" ).sortable();
			//$( ".items" ).disableSelection();
			});
		
		})

</script>
        
        
        
        
                    <div class="button new_team_member_social_field"><?php _e('Add New','team'); ?></div>
        
                </div>

            
            </li>
          
        </ul>
    
    
		

        
    </div>






				<p class="submit">
                
                	<?php wp_nonce_field( 'nonce_team' ); ?>
                
                    <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes','team' ); ?>" />
                </p>
		</form>


</div>
