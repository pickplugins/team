<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	


class class_team_functions  {
	
	
    public function __construct(){
		
		
		//$this->settings_page = new Team_Settings();
		
		
		//add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );
       //add_action('admin_menu', array($this, 'create_menu'));
    }
	

		
		
	public function team_member_posttype($posttype = array('team_member'))
		{
			return apply_filters('team_member_posttype', $posttype);
		}
		
	public function team_member_taxonomy($taxonomy = 'team_group')
		{
			return apply_filters('team_member_taxonomy', $taxonomy); //string only
		}		
		
		
		
		
	public function team_member_social_field(){
			
	
			$social_field = array(
									"mobile"=>array('meta_key'=>"mobile",'name'=>"Mobile",'icon'=>'','visibility'=>'1','can_remove'=>'no',),					
									"website"=>array('meta_key'=>"website",'name'=>"Website",'icon'=>'','visibility'=>'1','can_remove'=>'no',),
									"email"=>array('meta_key'=>"email",'name'=>"Email",'icon'=>'','visibility'=>'1','can_remove'=>'no',),						
									"skype"=>array('meta_key'=>"skype",'name'=>"Skype",'icon'=>'','visibility'=>'1','can_remove'=>'no',),					
									"facebook"=>array('meta_key'=>"facebook",'name'=>"Facebook",'icon'=>'','visibility'=>'1','can_remove'=>'yes',),
									"twitter"=>array('meta_key'=>"twitter",'name'=>"Twitter",'icon'=>'','visibility'=>'1','can_remove'=>'yes',),
									"googleplus"=>array('meta_key'=>"googleplus",'name'=>"Google plus",'icon'=>'','visibility'=>'1','can_remove'=>'yes',),
									"pinterest"=>array('meta_key'=>"pinterest",'name'=>"Pinterest",'icon'=>'','visibility'=>'1','can_remove'=>'yes',),
									"linkedin"=>array('meta_key'=>"linkedin",'name'=>"Linkedin",'icon'=>'','visibility'=>'1','can_remove'=>'yes',),
									"vimeo"=>array('meta_key'=>"vimeo",'name'=>"Vimeo",'icon'=>'','visibility'=>'1','can_remove'=>'yes',),
									"instagram"=>array('meta_key'=>"instagram",'name'=>"Instagram",'icon'=>'','visibility'=>'1','can_remove'=>'yes',),																						
					);					
					
			return apply_filters( 'team_member_social_field', $social_field );

			}		
		
		
		
		
		
	public function team_grid_items()
		{

			$team_grid_items = array(
					'thumbnail'=>__('Thumbnail','team'),
					'title'=>__('Title','team'),
					'position'=>__('Position','team'),
					'content'=>__('Content','team'),
					'social'=>__('Social','team'),
					'popup'=>__('Pop up <span class="team-pro" title="Only available in premium">Pro</span>','team'),
					'meta'=>__('Meta fields <span class="team-pro" title="Only available in premium">Pro</span>','team'),
					'skill'=>__('Skill bars <span class="team-pro" title="Only available in premium">Pro</span>','team'),
					);

			$team_grid_items = apply_filters('team_grid_items',$team_grid_items);


			return $team_grid_items;

			}


	
	
	public function skins(){
		
		$skins = array(
		
						'flat'=> array(
										'slug'=>'flat',									
										'name'=>'Flat',
										'thumb_url'=>'',
										'disabled'=>'',
										),

						'zoomout'=>array(
							'slug'=>'zoomout',
							'name'=>'ZoomOut',
							'thumb_url'=>'',
							'disabled'=>'',
						),

						'thumbrounded'=>array(
							'slug'=>'thumbrounded',
							'name'=>'ThumbRounded',
							'thumb_url'=>'',
							'disabled'=>'',
						),


						'flip-x'=> array(
										'slug'=>'flip-x',									
										'name'=>'Flip-x (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),
						'flip-y'=>array(
										'slug'=>'flip-y',
										'name'=>'Flip-y (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),
						'zoomin'=>array(
										'slug'=>'zoomin',
										'name'=>'ZoomIn (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),							

						'spinright'=>array(
										'slug'=>'spinright',
										'name'=>'SpinRight (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),
						'spinleft'=>array(
										'slug'=>'spinleft',
										'name'=>'SpinLeft (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),
										
						'spinrightzoom'=>array(
										'slug'=>'spinrightzoom',
										'name'=>'SpinRightZoom (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),
										
						'spinleftzoom'=>array(
										'slug'=>'spinleftzoom',
										'name'=>'SpinLeftZoom (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),										
																			
										
										
						'spinrightfast'=>array(
										'slug'=>'spinrightfast',
										'name'=>'SpinRightFast (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),
						'spinleftfast'=>array(
										'slug'=>'spinleftfast',
										'name'=>'SpinLeftFast (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),										
										
						'thumbgoleft'=>array(
										'slug'=>'thumbgoleft',
										'name'=>'ThumbGoLeft (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),																
							
						'thumbgoright'=>array(
										'slug'=>'thumbgoright',
										'name'=>'ThumbGoRight (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),
						'thumbgotop'=>array(
										'slug'=>'thumbgotop',
										'name'=>'ThumbGoTop (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),																
							
						'thumbgobottom'=>array(
										'slug'=>'thumbgobottom',
										'name'=>'ThumbGoBottom (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),
										
						'thumbgoleftconetntinright'=>array(
										'slug'=>'thumbgoleftconetntinright',
										'name'=>'ThumbGoLeftConetntInRight (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),
										
						'thumbgobottomconetntinright'=>array(
										'slug'=>'thumbgobottomconetntinright',
										'name'=>'ThumbGoBottomConetntInRight (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),										
						'thumbgotopconetntinright'=>array(
										'slug'=>'thumbgotopconetntinright',
										'name'=>'ThumbGoTopConetntInRight (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),																			
						'thumbgorightconetntinright'=>array(
										'slug'=>'thumbgorightconetntinright',
										'name'=>'ThumbGoRightConetntInRight (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),										
																			
						'thumbmiddle'=>array(
										'slug'=>'thumbmiddle',
										'name'=>'ThumbMiddle (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),
										
						'thumbskew'=>array(
										'slug'=>'thumbskew',
										'name'=>'ThumbSkew (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),										
										
										
						'contentbottom'=>array(
										'slug'=>'contentbottom',
										'name'=>'ContentBottom (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),
						'contentmiddle'=>array(
										'slug'=>'contentmiddle',
										'name'=>'ContentMiddle (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),
										
						'contentinbottom'=>array(
										'slug'=>'contentinbottom',
										'name'=>'ContentInBottom (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),										
										
						'contentinleft'=>array(
										'slug'=>'contentinleft',
										'name'=>'ContentInLeft (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),
										
						'contentinright'=>array(
										'slug'=>'contentinright',
										'name'=>'ContentInRight (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),																												
																													
										
						'contentborder'=>array(
										'slug'=>'contentborder',
										'name'=>'ContentBorder (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),										
										
						'contentborderrounded'=>array(
										'slug'=>'contentborderrounded',
										'name'=>'ContentBorderRounded (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),	
										
						'halfthumbleft'=>array(
										'slug'=>'halfthumbleft',
										'name'=>'HalfThumbLeft (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),
										
						'halfthumbright'=>array(
										'slug'=>'halfthumbright',
										'name'=>'HalfThumbRight (Pro feature)',
										'thumb_url'=>'',
										'disabled'=>'disabled',
										),
										


						
						);
		
		$skins = apply_filters('team_filter_skins', $skins);	
		
		return $skins;
		
		}
	







	
	public function faq(){



		$faq['core'] = array(
							'title'=>__('Core', 'team'),
							'items'=>array(

											array(
												'question'=>__('How to upgrade to premium ?', 'team'),
												'answer_url'=>'https://goo.gl/51pEHd',
												),	

											array(
												'question'=>__('How to activate license ?', 'team'),
												'answer_url'=>'https://goo.gl/jd1P5H',
												),	

											array(
												'question'=>__('How to create team ?', 'team'),
												'answer_url'=>'https://goo.gl/t5AYSC',
												),	

											array(
												'question'=>__('How to add custom profile fields ?', 'team'),
												'answer_url'=>'https://goo.gl/BmvA2u',
												),	

											array(
												'question'=>__('Team member page 404 not found.', 'team'),
												'answer_url'=>'https://goo.gl/OCjEKl',
												),

											array(
												'question'=>__('Team member page full width/broken', 'team'),
												'answer_url'=>'https://goo.gl/WHWu8p',
												),


											array(
												'question'=>__('How to change team member slug ?', 'team'),
												'answer_url'=>'https://goo.gl/xgXzVC',
												),

											array(
												'question'=>__('How to display team member by group ?', 'team'),
												'answer_url'=>'https://goo.gl/dUA40n',
												),


											array(
												'question'=>__('How to display team member by id’s ?', 'team'),
												'answer_url'=>'https://goo.gl/kKwh3Y',
												),




											),

								
							);

					
		
		
		$faq = apply_filters('team_filters_faq', $faq);		

		return $faq;

		}		
	


	
	
	public function team_get_taxonomy_category($postid)
		{
	
		$team_taxonomy = array('team_group');
		
		if(empty($team_taxonomy))
			{
				$team_taxonomy= "";
			}
		$team_taxonomy_terms = get_post_meta( $postid, 'team_taxonomy_terms', true );
		
			
			if(empty($team_taxonomy_terms))
				{
					$team_taxonomy_terms =array('none'); // an empty array when no category element selected
	
				}
	
			if(!isset($_POST['taxonomy']))
				{
				$taxonomy =$team_taxonomy;
				}
			else
				{
				$taxonomy = sanitize_text_field($_POST['taxonomy']);
				}
			
			
			$args=array(
			  'orderby' => 'name',
			  'order' => 'ASC',
			  'taxonomy' => $taxonomy,
			  );
		
		$categories = get_categories($args);
		
		
		if(empty($categories))
			{
			echo __("No Items Found!",'team');
			}
		
		
			$return_string = '';
			$return_string .= '<ul style="margin: 0;">';
		
		foreach($categories as $category){
			
			if(array_search($category->cat_ID, $team_taxonomy_terms))
			{
		   $return_string .= '<li class='.$category->cat_ID.'><label ><input class="team_taxonomy_terms" checked type="checkbox" name="team_taxonomy_terms['.$category->cat_ID.']" value ="'.$category->cat_ID.'" />'.$category->cat_name.'</label ></li>';
			}
			
			else
				{
					   $return_string .= '<li class='.$category->cat_ID.'><label ><input class="team_taxonomy_terms" type="checkbox" name="team_taxonomy_terms['.$category->cat_ID.']" value ="'.$category->cat_ID.'" />'.$category->cat_name.'</label ></li>';			
				}
			
			}
		
			$return_string .= '</ul>';
			
			return $return_string;
		
		if(isset($_POST['taxonomy']))
			{
				die();
			}
		
			
		}
		
	public function team_share_plugin()
		{
			
			?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=652982311485932";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-like" data-href="http://paratheme.com/items/team-responsive-meet-the-team-grid-for-wordpress" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
            
            <br /><br />
            <!-- Place this tag in your head or just before your close body tag. -->
            <script src="https://apis.google.com/js/platform.js" async defer></script>
            
            <!-- Place this tag where you want the +1 button to render. -->
            <div class="g-plusone" data-size="medium" data-annotation="inline" data-width="300" data-href="<?php echo team_share_url; ?>"></div>
            
            <br />
            <br />
            <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo team_share_url; ?>" data-text="<?php echo team_plugin_name; ?>" data-via="ParaTheme" data-hashtags="WordPress">Tweet</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>



            <?php
			
			
			
		
		
		}






}


new class_team_functions();

