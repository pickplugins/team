<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


			$content = apply_filters('the_content', get_the_content());
			
			
			if($team_items_popup_content=='full')
				{
					$popup_content = $content;
				}
			elseif($team_items_popup_content=='excerpt')
				{
					$popup_content = wp_trim_words( $content , $team_items_popup_excerpt_count, ' <a style="color:'.$team_items_content_color.';" class="read-more" href="'. get_permalink() .'">'.$team_items_popup_excerpt_text.'</a>' );
				}
			else{
				
				$popup_content = $content;
				}

				?>
	<div class="team-popup-box team-popup-box-<?php echo get_the_ID(); ?>">
		<div style="width:<?php echo $team_items_popup_width; ?>; height:<?php echo $team_items_popup_height; ?>" class="team-slide team-slide-<?php echo get_the_ID(); ?>">
			<div class="close"></div>
				<?php


					if ($team_items_popup_thumb_src=='meta_key'){

						$team_popup_thumb_url_meta = get_post_meta(get_the_ID(), $popup_thumb_src_meta_key, true);

						if(!empty($team_popup_thumb_url_meta)){

							$team_popup_thumb_url = $team_popup_thumb_url_meta;
						}
						else{
							$team_popup_thumb_url = $team_popup_thumb_url;
						}

					}
					else{
						$team_popup_thumb_url = $team_popup_thumb_url;
					}


					$html_popup = '';
					$html_popup_thumbnail= '<img src="'.$team_popup_thumb_url.'" />';


					$html_popup_thumbnail = apply_filters( 'team_grid_filter_popup_thumbnail', $html_popup_thumbnail );

					$html_popup.= '<div class="team-slide-thumb ">'.$html_popup_thumbnail.'</div>';


					$html_popup.= '<div class="team-slide-content"><span class="team-slide-title">'.get_the_title().'</span><span class="team-slide-position">'.$team_member_position.'</span><hr />'.$popup_content.'</div>';

					$team_grid_filter_popup = apply_filters('team_grid_filter_popup',$html_popup);

					echo $team_grid_filter_popup;


?>
		</div>
	</div>
<?php
