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



    public function layout_items(){

        $layout_items['name'] = array('title'=>'Name');
        $layout_items['name']['style'] = array(
            array(
                'id'		=> 'font-size',
                'title'		=> __('Font Size','team'),
                'details'	=> __('Choose font size.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '14px',
            ),
            array(
                'id'		=> 'color',
                'title'		=> __('Text color','team'),
                'details'	=> __('Choose name font color','team'),
                'type'		=> 'colorpicker',
                'value'		=> '',
                'default'		=> '#595959',
            ),
            array(
                'id'		=> 'text-align',
                'title'		=> __('Text align','team'),
                'details'	=> __('Choose text align.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'left',
                'args'		=> array(
                    'left'=>__('Left','team'),
                    'right'=>__('Right','team'),
                    'center'=>__('Center','team'),
                    'initial'=>__('Initial','team'),
                    'justify'=>__('Justify','team'),
                ),
            ),
            array(
                'id'		=> 'margin',
                'title'		=> __('Margin','team'),
                'details'	=> __('Set margin, ex: <code>10px</code> or <code>5px 10px</code>.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '10px',
            ),
            array(
                'id'		=> 'padding',
                'title'		=> __('Padding','team'),
                'details'	=> __('Set padding, ex: <code>10px</code> or <code>5px 10px</code>.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '10px',
            ),
            array(
                'id'		=> 'float',
                'title'		=> __('Float','team'),
                'details'	=> __('Choose float.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'none',
                'args'		=> array(
                    'none'=>__('None','team'),
                    'left'=>__('Left','team'),
                    'right'=>__('Right','team'),
                    'inherit'=>__('Inherit','team'),
                )
            ),


        );

        $layout_items['name']['settings'] = array(

            array(
                'id'		=> 'link_to',
                'title'		=> __('Link to','team'),
                'details'	=> __('Choose link to this member.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'left',
                'args'		=> array(
                    'none'=>__('None','team'),
                    'single_page'=>__('Single team page','team'),
                    'custom_url'=>__('Custom URL','team'),
                    'popup_box'=>__('Popup box','team'),
                    'popup_slider'=>__('Popup slider','team'),
                ),
            ),


        );



        $layout_items['position'] = array('title'=>'Position');
        $layout_items['position']['style'] = array(
            array(
                'id'		=> 'font-size',
                'title'		=> __('Font Size','team'),
                'details'	=> __('Choose font size.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '14px',
            ),
            array(
                'id'		=> 'color',
                'title'		=> __('Text color','team'),
                'details'	=> __('Choose name font color','team'),
                'type'		=> 'colorpicker',
                'value'		=> '',
                'default'		=> '#595959',
            ),
            array(
                'id'		=> 'text-align',
                'title'		=> __('Text align','team'),
                'details'	=> __('Choose text align.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'left',
                'args'		=> array(
                    'left'=>__('Left','team'),
                    'right'=>__('Right','team'),
                    'center'=>__('Center','team'),
                    'initial'=>__('Initial','team'),
                    'justify'=>__('Justify','team'),
                ),
            ),
            array(
                'id'		=> 'margin',
                'title'		=> __('Margin','team'),
                'details'	=> __('Set margin, ex: <code>10px</code> or <code>5px 10px</code>.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '10px',
            ),
            array(
                'id'		=> 'padding',
                'title'		=> __('Padding','team'),
                'details'	=> __('Set padding, ex: <code>10px</code> or <code>5px 10px</code>.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '10px',
            ),
            array(
                'id'		=> 'float',
                'title'		=> __('Float','team'),
                'details'	=> __('Choose float.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'none',
                'args'		=> array(
                    'none'=>__('None','team'),
                    'left'=>__('Left','team'),
                    'right'=>__('Right','team'),
                    'inherit'=>__('Inherit','team'),
                )
            ),

        );


        $layout_items['content'] = array('title'=>'Content');
        $layout_items['content']['style'] = array(
            array(
                'id'		=> 'font-size',
                'title'		=> __('Font Size','team'),
                'details'	=> __('Choose font size.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '14px',
            ),
            array(
                'id'		=> 'color',
                'title'		=> __('Text color','team'),
                'details'	=> __('Choose name font color','team'),
                'type'		=> 'colorpicker',
                'value'		=> '',
                'default'		=> '#595959',
            ),
            array(
                'id'		=> 'background-color',
                'title'		=> __('Background color','team'),
                'details'	=> __('Choose name background color','team'),
                'type'		=> 'colorpicker',
                'value'		=> '',
                'default'		=> '#fff',
            ),
            array(
                'id'		=> 'text-align',
                'title'		=> __('Text align','team'),
                'details'	=> __('Choose text align.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'left',
                'args'		=> array(
                    'left'=>__('Left','team'),
                    'right'=>__('Right','team'),
                    'center'=>__('Center','team'),
                    'initial'=>__('Initial','team'),
                    'justify'=>__('Justify','team'),
                ),
            ),
            array(
                'id'		=> 'border-radius',
                'title'		=> __('Border radius','team'),
                'details'	=> __('Set border radius.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'placeholder'		=> '10px',
            ),
            array(
                'id'		=> 'margin',
                'title'		=> __('Margin','team'),
                'details'	=> __('Set margin, ex: <code>10px</code> or <code>5px 10px</code>.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '10px',
            ),
            array(
                'id'		=> 'padding',
                'title'		=> __('Padding','team'),
                'details'	=> __('Set padding, ex: <code>10px</code> or <code>5px 10px</code>.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '10px',
            ),
            array(
                'id'		=> 'float',
                'title'		=> __('Float','team'),
                'details'	=> __('Choose float.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'none',
                'args'		=> array(
                    'none'=>__('None','team'),
                    'left'=>__('Left','team'),
                    'right'=>__('Right','team'),
                    'inherit'=>__('Inherit','team'),
                )
            ),

        );

        $layout_items['content']['settings'] = array(
            array(
                'id'		=> 'word_count',
                'title'		=> __('Word count','team'),
                'details'	=> __('Choose word count for team member content.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '20',
            ),

            array(
                'id'		=> 'read_more_text',
                'title'		=> __('Custom read more text','team'),
                'details'	=> __('Write custom read more text.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> 'Read more',
            ),

            array(
                'id'		=> 'link_to',
                'title'		=> __('Link to','team'),
                'details'	=> __('Choose link to this member.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'left',
                'args'		=> array(
                    'none'=>__('None','team'),
                    'single_page'=>__('Single team page','team'),
                    'custom_url'=>__('Custom URL','team'),
                    'popup_box'=>__('Popup box','team'),
                    'popup_slider'=>__('Popup slider','team'),
                ),
            ),

        );






        $layout_items['thumbnail'] = array('title'=>'Thumbnail');

        $layout_items['thumbnail']['settings'] = array(

            array(
                'id'		=> 'link_to',
                'title'		=> __('Link to','team'),
                'details'	=> __('Choose link to this member.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'left',
                'args'		=> array(
                    'none'=>__('None','team'),
                    'single_page'=>__('Single team page','team'),
                    'custom_url'=>__('Custom URL','team'),
                    'popup_box'=>__('Popup box','team'),
                    'popup_slider'=>__('Popup slider','team'),
                ),
            ),


        );

        $layout_items['thumbnail']['style'] = array(

            array(
                'id'		=> 'width',
                'title'		=> __('Width','team'),
                'details'	=> __('Thumbnail width','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '50px',
            ),
            array(
                'id'		=> 'height',
                'title'		=> __('Height','team'),
                'details'	=> __('Thumbnail height','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '50px',
            ),
            array(
                'id'		=> 'border-radius',
                'title'		=> __('Border radius','team'),
                'details'	=> __('Set border radius.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'placeholder'		=> '30%',
            ),

            array(
                'id'		=> 'float',
                'title'		=> __('Float','team'),
                'details'	=> __('Choose float.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'none',
                'args'		=> array(
                    'none'=>__('None','team'),
                    'left'=>__('Left','team'),
                    'right'=>__('Right','team'),
                    'inherit'=>__('Inherit','team'),
                )
            ),

            array(
                'id'		=> 'margin',
                'title'		=> __('Margin','team'),
                'details'	=> __('Set margin, ex: <code>10px</code> or <code>5px 10px</code>.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '10px',
            ),
            array(
                'id'		=> 'padding',
                'title'		=> __('Padding','team'),
                'details'	=> __('Set padding, ex: <code>10px</code> or <code>5px 10px</code>.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '10px',
            ),
            array(
                'id'		=> 'text-align',
                'title'		=> __('Text align','team'),
                'details'	=> __('Choose text align.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'left',
                'args'		=> array(
                    'left'=>__('Left','team'),
                    'right'=>__('Right','team'),
                    'center'=>__('Center','team'),
                    'initial'=>__('Initial','team'),
                    'justify'=>__('Justify','team'),
                ),
            ),

        );



        $layout_items['skill'] = array('title'=>'Skill');
        $layout_items['skill']['style'] = array(
            array(
                'id'		=> 'font-size',
                'title'		=> __('Font Size','team'),
                'details'	=> __('Choose font size.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '14px',
            ),
            array(
                'id'		=> 'color',
                'title'		=> __('Text color','team'),
                'details'	=> __('Choose name font color','team'),
                'type'		=> 'colorpicker',
                'value'		=> '',
                'default'		=> '#595959',
            ),
            array(
                'id'		=> 'text-align',
                'title'		=> __('Text align','team'),
                'details'	=> __('Choose text align.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'left',
                'args'		=> array(
                    'left'=>__('Left','team'),
                    'right'=>__('Right','team'),
                    'center'=>__('Center','team'),
                    'initial'=>__('Initial','team'),
                    'justify'=>__('Justify','team'),
                ),
            ),
            array(
                'id'		=> 'margin',
                'title'		=> __('Margin','team'),
                'details'	=> __('Set margin, ex: <code>10px</code> or <code>5px 10px</code>.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '10px',
            ),
            array(
                'id'		=> 'padding',
                'title'		=> __('Padding','team'),
                'details'	=> __('Set padding, ex: <code>10px</code> or <code>5px 10px</code>.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '10px',
            ),
            array(
                'id'		=> 'float',
                'title'		=> __('Float','team'),
                'details'	=> __('Choose float.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'none',
                'args'		=> array(
                    'none'=>__('None','team'),
                    'left'=>__('Left','team'),
                    'right'=>__('Right','team'),
                    'inherit'=>__('Inherit','team'),
                )
            ),

        );






        $layout_items['contacts'] = array('title'=>'Contacts');
        $layout_items['contacts']['style'] = array(
            array(
                'id'		=> 'font-size',
                'title'		=> __('Font Size','team'),
                'details'	=> __('Choose font size.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '14px',
            ),
            array(
                'id'		=> 'color',
                'title'		=> __('Text color','team'),
                'details'	=> __('Choose name font color','team'),
                'type'		=> 'colorpicker',
                'value'		=> '',
                'default'		=> '#595959',
            ),
            array(
                'id'		=> 'text-align',
                'title'		=> __('Text align','team'),
                'details'	=> __('Choose text align.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'left',
                'args'		=> array(
                    'left'=>__('Left','team'),
                    'right'=>__('Right','team'),
                    'center'=>__('Center','team'),
                    'initial'=>__('Initial','team'),
                    'justify'=>__('Justify','team'),
                ),
            ),
            array(
                'id'		=> 'margin',
                'title'		=> __('Margin','team'),
                'details'	=> __('Set margin, ex: <code>10px</code> or <code>5px 10px</code>.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '10px',
            ),
            array(
                'id'		=> 'padding',
                'title'		=> __('Padding','team'),
                'details'	=> __('Set padding, ex: <code>10px</code> or <code>5px 10px</code>.','team'),
                'type'		=> 'text',
                'value'		=> '',
                'default'		=> '',
                'placeholder'		=> '10px',
            ),
            array(
                'id'		=> 'float',
                'title'		=> __('Float','team'),
                'details'	=> __('Choose float.','team'),
                'type'		=> 'select',
                'value'		=> '',
                'default'		=> 'none',
                'args'		=> array(
                    'none'=>__('None','team'),
                    'left'=>__('Left','team'),
                    'right'=>__('Right','team'),
                    'inherit'=>__('Inherit','team'),
                )
            ),

        );




        $layout_items = apply_filters('team_layout_items', $layout_items);

        return $layout_items;
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
					'popup'=>__('Pop up','team'),
					'meta'=>__('Meta fields','team'),
					'skill'=>__('Skill bars','team'),
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
										),		
		
						'flip-x'=> array(
										'slug'=>'flip-x',									
										'name'=>'Flip-x',
										'thumb_url'=>'',
										),
						'flip-y'=>array(
										'slug'=>'flip-y',
										'name'=>'Flip-y',
										'thumb_url'=>'',
										),
						'zoomin'=>array(
										'slug'=>'zoomin',
										'name'=>'ZoomIn',
										'thumb_url'=>'',
										),							
						'zoomout'=>array(
										'slug'=>'zoomout',
										'name'=>'ZoomOut',
										'thumb_url'=>'',
										),							
						'spinright'=>array(
										'slug'=>'spinright',
										'name'=>'SpinRight',
										'thumb_url'=>'',
										),
						'spinleft'=>array(
										'slug'=>'spinleft',
										'name'=>'SpinLeft',
										'thumb_url'=>'',
										),
										
						'spinrightzoom'=>array(
										'slug'=>'spinrightzoom',
										'name'=>'SpinRightZoom',
										'thumb_url'=>'',
										),
										
						'spinleftzoom'=>array(
										'slug'=>'spinleftzoom',
										'name'=>'SpinLeftZoom',
										'thumb_url'=>'',
										),										
																			
										
										
						'spinrightfast'=>array(
										'slug'=>'spinrightfast',
										'name'=>'SpinRightFast',
										'thumb_url'=>'',
										),
						'spinleftfast'=>array(
										'slug'=>'spinleftfast',
										'name'=>'SpinLeftFast',
										'thumb_url'=>'',
										),										
										
						'thumbgoleft'=>array(
										'slug'=>'thumbgoleft',
										'name'=>'ThumbGoLeft',
										'thumb_url'=>'',
										),																
							
						'thumbgoright'=>array(
										'slug'=>'thumbgoright',
										'name'=>'ThumbGoRight',
										'thumb_url'=>'',
										),
						'thumbgotop'=>array(
										'slug'=>'thumbgotop',
										'name'=>'ThumbGoTop',
										'thumb_url'=>'',
										),																
							
						'thumbgobottom'=>array(
										'slug'=>'thumbgobottom',
										'name'=>'ThumbGoBottom',
										'thumb_url'=>'',
										),
										
						'thumbgoleftconetntinright'=>array(
										'slug'=>'thumbgoleftconetntinright',
										'name'=>'ThumbGoLeftConetntInRight',
										'thumb_url'=>'',
										),
										
						'thumbgobottomconetntinright'=>array(
										'slug'=>'thumbgobottomconetntinright',
										'name'=>'ThumbGoBottomConetntInRight',
										'thumb_url'=>'',
										),										
						'thumbgotopconetntinright'=>array(
										'slug'=>'thumbgotopconetntinright',
										'name'=>'ThumbGoTopConetntInRight',
										'thumb_url'=>'',
										),																			
						'thumbgorightconetntinright'=>array(
										'slug'=>'thumbgorightconetntinright',
										'name'=>'ThumbGoRightConetntInRight',
										'thumb_url'=>'',
										),										
																			
						'thumbmiddle'=>array(
										'slug'=>'thumbmiddle',
										'name'=>'ThumbMiddle',
										'thumb_url'=>'',
										),
										
						'thumbskew'=>array(
										'slug'=>'thumbskew',
										'name'=>'ThumbSkew',
										'thumb_url'=>'',
										),										
										
										
						'contentbottom'=>array(
										'slug'=>'contentbottom',
										'name'=>'ContentBottom',
										'thumb_url'=>'',
										),
						'contentmiddle'=>array(
										'slug'=>'contentmiddle',
										'name'=>'ContentMiddle',
										'thumb_url'=>'',
										),
										
						'contentinbottom'=>array(
										'slug'=>'contentinbottom',
										'name'=>'ContentInBottom',
										'thumb_url'=>'',
										),										
										
						'contentinleft'=>array(
										'slug'=>'contentinleft',
										'name'=>'ContentInLeft',
										'thumb_url'=>'',
										),
										
						'contentinright'=>array(
										'slug'=>'contentinright',
										'name'=>'ContentInRight',
										'thumb_url'=>'',
										),																												
																													
										
						'contentborder'=>array(
										'slug'=>'contentborder',
										'name'=>'ContentBorder',
										'thumb_url'=>'',
										),										
										
						'contentborderrounded'=>array(
										'slug'=>'contentborderrounded',
										'name'=>'ContentBorderRounded',
										'thumb_url'=>'',
										),	
										
						'halfthumbleft'=>array(
										'slug'=>'halfthumbleft',
										'name'=>'HalfThumbLeft',
										'thumb_url'=>'',
										),
										
						'halfthumbright'=>array(
										'slug'=>'halfthumbright',
										'name'=>'HalfThumbRight',
										'thumb_url'=>'',
										),
										
						'thumbrounded'=>array(
										'slug'=>'thumbrounded',
										'name'=>'ThumbRounded',
										'thumb_url'=>'',
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
	












public function team_get_all_post_ids($postid){
		
		$team_post_ids = get_post_meta( $postid, 'team_post_ids', true );
		
		if(empty($team_post_ids)){$team_post_ids = array();}
		
		$return_string = '';
		$return_string .= '<ul style="margin: 0;">';

		$args_product = array(
		'post_type' => array('team_member'),
		'orderby' => 'post__in',
		'post__in' => $team_post_ids,
		'posts_per_page' => -1,
		);

		$member_query = new WP_Query( $args_product );
	
		if($member_query->have_posts())
		
			{
				while($member_query->have_posts()): $member_query->the_post();
				
		
			   $return_string .= '<li><label ><input class="team_post_ids" type="checkbox" name="team_post_ids[]" value ="'.get_the_ID().'" ';
				
				if ( in_array(get_the_ID(), $team_post_ids ) )
					{
						$return_string .= "checked";
					}
		
				$return_string .= '/>';
		
				$return_string .= get_the_title().'</label ></li>';
					
				endwhile; 
				wp_reset_query();
			}
		

		
		
		else
			{
		$return_string .= '<span style="color:#f00;">'.__('Sorry nothting found.','team');
			}

	
		
		
		$return_string .= '</ul>';
		
		
		return $return_string;
	
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
				$taxonomy = $_POST['taxonomy'];
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

