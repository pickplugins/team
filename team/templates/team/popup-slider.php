<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 
	
	include team_plugin_dir.'/templates/team/popup-query.php';

	?>
	<div id="popup-slider-<?php echo $post_id; ?>" class="popup-slider">
		<div class="itemsqq">
			<div class="close"></div>
			<div class="owl-carousel owl-theme">
<?php

	
		if ( $wp_query->have_posts() ) :
		
		while ( $wp_query->have_posts() ) : $wp_query->the_post();

			$team_member_position = get_post_meta(get_the_ID(),'team_member_position', true);
            $team_member_social_links = get_post_meta(get_the_ID(),'team_member_social_links', true);




			$team_popup_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $team_items_popup_thumb_size );
			$team_popup_thumb_url = $team_popup_thumb['0'];
			
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
			<div class="item" data-hash="<?php echo get_the_ID(); ?>">
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


			$html_popup_thumbnail= '<img src="'.$team_popup_thumb_url.'" />';
			
			
			$html_popup_thumbnail = apply_filters( 'team_grid_filter_popup_thumbnail', $html_popup_thumbnail );

			?>
			<div class="thumb"><?php echo $html_popup_thumbnail; ?></div>
			<div class="content"><span class="title"><?php echo get_the_title(); ?></span><span class="position"><?php echo $team_member_position; ?></span><hr /><?php echo $popup_content; ?>
				<?php


			if(!empty($team_member_social_links['linkedin'])){

				?>
				<div class="popup-slider-social">

<div class="team-social image_icon flat">
<span class="linkedin">
<a target="_blank" href="<?php echo $team_member_social_links['linkedin']; ?>"> </a>
</span>
</div>

</div>
					<?php


            }
			?>
			</div></div>
					<?php

			
			
		endwhile;
		wp_reset_query();
		
		endif;

		?></div>
		</div>
	</div>

	<script>
        jQuery(document).ready(function($){

            $("#team-<?php echo $post_id; ?> .popup-slider .itemsqq .owl-carousel").owlCarousel({items:1,URLhashListener:true,nav:true,navText:["",""],dots:true});



        });
	</script>
	<?php

	
	
	
	
	
	
	