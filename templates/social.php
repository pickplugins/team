<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
		
			$html.= '<div class="team-social '.$team_items_social_icon_type.' '.$team_social_icon_style.'" >';
			
			
			$team_member_social_field = get_option( 'team_member_social_field' );
			
			if(empty($team_member_social_field))
				{
					$team_member_social_field = array("skype"=>"skype","email"=>"email","website"=>"website", "facebook"=>"facebook","twitter"=>"twitter","googleplus"=>"googleplus","pinterest"=>"pinterest");
					
				}
			
			$html_social = '';
			
            foreach ($team_member_social_field as $field_key=>$field_info) {
				
				$visibility = $field_info['visibility'];
				$name = $field_info['name'];				

                if(!empty($field_key) && !empty($team_member_social_links[$field_key]) && !empty($field_info['visibility'])){
						
						if(!empty($team_member_social_field[$field_key]['icon']))
							{
							$icon_bg = 'style="background-image:url('.$team_member_social_field[$field_key]['icon'].')"';
							}
						else
							{
							$icon_bg = '';
							}
						
						
					if($team_items_social_icon_type=='image_icon'):
					
					
						if($field_key == 'website'){
	
								$html_social.= '<span '.$icon_bg.' class="website">
									<a title="'.$name.'" target="_blank" href="'.$team_member_social_links[$field_key].'"></a>
								</span>';	
							}
						elseif($field_key == 'email'){
							
								$html_social.= '<span '.$icon_bg.' class="email">
									<a title="'.$name.'" href="mailto:'.$team_member_social_links[$field_key].'"></a>
								</span>';
							}
							
						elseif($field_key == 'skype'){
							
								$html_social.= '<span '.$icon_bg.' class="skype">
									<a  title="'.$name.'" href="skype:'.$team_member_social_links[$field_key].'"></a>
								</span>';
							}
							
						elseif($field_key == 'mobile'){
							
								$html_social.= '<span '.$icon_bg.' class="mobile">
									<a  title="'.$name.'" href="tel:'.$team_member_social_links[$field_key].'"></a>
								</span>';
							}
							
							
						elseif($field_key == 'phone'){
							
								$html_social.= '<span '.$icon_bg.' class="mobile">
									<a  title="'.$name.'" href="tel:'.$team_member_social_links[$field_key].'"></a>
								</span>';
							}						
												
							
						else{
								$html_social.= '<span '.$icon_bg.' class="'.$field_key.'" >
									<a title="'.$name.'" target="_blank" href="'.$team_member_social_links[$field_key].'"> </a>
								</span>';
							}					
				
					elseif($team_items_social_icon_type=='text_link'):
					
						if(!empty($team_member_social_field[$field_key]['icon'])){
							
							$icon_link_ = $team_member_social_field[$field_key]['icon'];
							
							}
						
						
						
						if($field_key == 'website'){
	
								$html_social.= '<span  class="text-website">
									<a title="'.$name.'" target="_blank" href="'.$team_member_social_links[$field_key].'">'.$name.'</a>
								</span>';	
							}
						elseif($field_key == 'email'){
							
								$html_social.= '<span  class="text-email">
									<a title="'.$name.'" href="mailto:'.$team_member_social_links[$field_key].'">'.$name.'</a>
								</span>';
							}
							
						elseif($field_key == 'skype'){
							
								$html_social.= '<span  class="text-skype">
									<a title="'.$name.'" title="'.$field_key.'" href="skype:'.$team_member_social_links[$field_key].'">'.$name.'</a>
								</span>';
							}
							
						elseif($field_key == 'mobile'){
							
								$html_social.= '<span  class="text-mobile">
									<a  title="'.$name.'" href="tel:'.$team_member_social_links[$field_key].'">'.$name.'</a>
								</span>';
							}

						elseif($field_key == 'phone'){
							
								$html_social.= '<span  class="text-mobile">
									<a  title="'.$name.'" href="tel:'.$team_member_social_links[$field_key].'">'.$name.'</a>
								</span>';
							}						

						else{
								$html_social.= '<span  class="text-'.$field_key.'" >
									<a title="'.$name.'" target="_blank" href="'.$team_member_social_links[$field_key].'">'.$name.'</a>
								</span>';
							}					
				
					
					
					endif;
			

                    
                    }
            }

			$html .= apply_filters( 'team_grid_filter_social', $html_social );

			$html.= '</div>';
			