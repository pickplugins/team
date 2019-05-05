<?php

/*
* @Author 		ParaTheme
* @Folder	 	Team/Templates
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
		

		$title_text = apply_filters( 'team_grid_filter_title', get_the_title() );		
	
	
		if($team_items_link_to_post == 'yes')
			{
				?>
				<a href="<?php echo get_permalink(get_the_ID()); ?>"><div class="team-title" style="color:<?php echo $team_items_title_color;?>;font-size:<?php echo $team_items_title_font_size; ?>"><?php echo $title_text; ?>
					</div></a>
				<?php



			}
		else if($team_items_link_to_post == 'custom')
			{
		
			if(!empty($team_member_link_to_post))
				{

				    ?>
                    <a href="<?php echo $team_member_link_to_post; ?>"><div class="team-title" style="color:<?php echo $team_items_title_color; ?>;font-size:<?php echo $team_items_title_font_size; ?>"><?php echo $title_text; ?>
                        </div></a>
                    <?php



				}
			else
				{
				    ?>
                    <a href="#"><div class="team-title" style="color:<?php echo $team_items_title_color; ?>;font-size:<?php echo $team_items_title_font_size;?>"><?php echo $title_text; ?>
                        </div></a>
                    <?php



				}
			}
			
		else if($team_items_link_to_post == 'popup')
			{

			    ?>
<div class="team-title" ><a teamid="<?php echo get_the_ID(); ?>" class="team-popup" style="color:<?php echo $team_items_title_color; ?>;font-size:<?php echo $team_items_title_font_size; ?>" href="#"><?php echo $title_text; ?></a>
</div>
                <?php


			
			
			
			
			$content = apply_filters('the_content', get_the_content());
			
			
			if($team_items_popup_content=='full')
				{
					$popup_content = $content;
				}
			elseif($team_items_popup_content=='excerpt')
				{
					$popup_content = wp_trim_words( $content , $team_items_popup_excerpt_count, ' <a style="color:'.$team_items_content_color.';" class="read-more" href="'. get_permalink() .'">'.$team_items_popup_excerpt_text.'</a>' );
				}

				
	
			}
			
			
		else if($team_items_link_to_post == 'popup_slider')
			{

			    ?>
                <div class="team-title" ><a team_id="<?php echo $post_id; ?>" class="team-popup-slider" style="color:<?php echo $team_items_title_color; ?>;font-size:<?php echo $team_items_title_font_size; ?>" href="#<?php echo get_the_ID(); ?>"><?php echo $title_text; ?></a>
                </div>
                <?php



			
			
			
			
			$content = apply_filters('the_content', get_the_content());
			
			
			if($team_items_popup_content=='full')
				{
					$popup_content = $content;
				}
			elseif($team_items_popup_content=='excerpt')
				{
					$popup_content = wp_trim_words( $content , $team_items_popup_excerpt_count, ' <a style="color:'.$team_items_content_color.';" class="read-more" href="'. get_permalink() .'">'.$team_items_popup_excerpt_text.'</a>' );
				}

				
	
			}			
			
			
			
						
		else
			{
			    ?>
                <div class="team-title " style="color:<?php echo $team_items_title_color; ?>;font-size:<?php echo $team_items_title_font_size; ?>"><?php echo $title_text; ?></div>
                <?php



			}
			
			

