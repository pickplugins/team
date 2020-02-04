<?php

/*
* @Author 		pickplugins
* Copyright: 	2016 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	


class class_team_shortcodes  {
	
	
    public function __construct(){
		
		add_shortcode( 'team', array( $this, 'team_display' ) );
		add_shortcode( 'team_pickplugins', array( $this, 'team_display' ) ); // To avoid Conflict

    }
	
	public function team_display($atts, $content = null ) {
			$atts = shortcode_atts(
				array(
					'id' => "",
	
					), $atts);
	
				$html = '';
				$post_id = $atts['id'];
	
			//	var_dump('Hello');
	
				include team_plugin_dir.'/templates/variables.php';
				include team_plugin_dir.'/templates/query.php';
				
				include team_plugin_dir.'/templates/custom-css.php';
				
				//var_dump($team_grid_items);
	
				$html .= '<div id="team-'.$post_id.'" class="team-container">';
				
				

				$html .= '<div class="team-items">';
				
				
				if ( $wp_query->have_posts() ) :
				
				while ( $wp_query->have_posts() ) : $wp_query->the_post();
				
					$team_member_position = get_post_meta(get_the_ID(), 'team_member_position', true );
					$team_member_social_links = get_post_meta( get_the_ID(), 'team_member_social_links', true );	
					$team_member_link_to_post = get_post_meta( get_the_ID(), 'team_member_link_to_post', true );
				
					$team_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $team_items_thumb_size );
					$team_thumb_url = $team_thumb['0'];
					
					$team_popup_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $team_items_popup_thumb_size );
					$team_popup_thumb_url = $team_popup_thumb['0'];					
					
					$html.= '<div class="item skin '.team_term_slug_list(get_the_ID()).' '.$team_themes.'" >';
				
				
					$html.=  '<div class="layer-media">';				
				
					foreach($team_grid_items as $key=>$name){
							
							if(empty($team_grid_items_hide[$key]) && $key=='thumbnail')
								{
									include team_plugin_dir.'templates/'.$key.'.php';
								}
							
						}
				
				
					$html.=  '</div>';
				
					$html.=  '<div class="layer-content">';
					foreach($team_grid_items as $key=>$name){
							
							if(empty($team_grid_items_hide[$key]) && $key!='thumbnail'  && $key!='popup' && $key!='meta'  && $key!='skill')
								{
								include team_plugin_dir.'templates/'.$key.'.php';
								}
							
						}
					$html.=  '</div>';
				
					$html.=  '</div>';
				
				
				endwhile;
				
				$html.=  '</div>';
				
				include team_plugin_dir.'/templates/paginate.php';
				
				
				wp_reset_query();
				
				else :
					$html.= __('No Team Member Found','wcps');
			
				endif;

						
				
				include team_plugin_dir.'/templates/scripts.php';				
				
				
				$html.=  '</div>';	

			
	
				return $html;
	
	
	}










}


new class_team_shortcodes();

