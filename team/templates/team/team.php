<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 




include team_plugin_dir.'/templates/team/variables.php';
include team_plugin_dir.'/templates/team/query.php';

include team_plugin_dir.'/templates/team/custom-css.php';



?>
    <div id="team-<?php echo $post_id; ?>" class="team-container">
		<?php




		$team_grid_slider_class = '';
		$team_grid_filterable_class = '';

		if($team_grid_style=='filterable'){

			$team_grid_filterable_class = 'mix';

			?>
            <div class="team-filter" >
                <div class="filter" data-filter="all"><?php echo __('All','team');?></div>
				<?php




				if(!empty($team_taxonomy_terms))
					foreach($team_taxonomy_terms as $id)
					{
						$term = get_term( $id, $team_taxonomy );
						$term_slug = $term->slug;
						$term_name = $term->name;
						?>
                        <div class="filter" data-filter=".<?php echo $term_slug; ?>" ><?php echo $term_name; ?></div>
						<?php


					}
				?>
            </div >
		<?php




		if($team_filter_scroll_top=='yes'){

		?>
            <script>

                jQuery(document).ready(function($)
                {

                    $(document).on("click", "span.pager", function(event)
                    {

                        $("html, body").animate({scrollTop:$("#team-<?php echo $post_id; ?>").position().top}, "fast");

                    })

                })
            </script>
		<?php






		}


		}


        elseif($team_grid_style=='slider'){

		$team_grid_slider_class = 'owl-carousel owl-theme';

		?>
            <script>
                jQuery(document).ready(function($){

                    $("#team-<?php echo $post_id; ?> .team-items").owlCarousel({



                        items : <?php echo $team_column_number; ?>, //10 items above 1000px browser width

                        autoHeight:true,
                        responsiveClass:true,
                        responsive:{
                            0:{
                                items:<?php echo $team_column_number_mobile; ?>,
                                nav:true
                            },
                            600:{
                                items:<?php echo $team_column_number_tablet; ?>,
                                nav:true
                            },

                            900:{
                                items:<?php echo $team_column_number_tablet; ?>,
                                nav:true
                            },

                            1000:{
                                items:<?php echo $team_column_number; ?>,
                                nav:true,

                            }
                        },

                        autoplay:<?php echo $team_auto_play; ?>,
                        autoplaySpeed:<?php echo $team_slide_autoplaySpeed; ?>,
                        autoplayTimeout:<?php echo $team_slide_autoplayTimeout; ?>,
                        autoplayHoverPause:<?php echo $team_stop_on_hover; ?>,

                        loop:<?php echo $team_slide_loop; ?>,
                        rewind:<?php echo $team_slide_rewind; ?>,
                        center:<?php echo $team_slide_center; ?>,
                        rtl:<?php echo $team_slide_rtl; ?>,



                        navText : ["",""],
                        nav:<?php echo $team_slider_navigation; ?>,

                        navSpeed:<?php echo $team_slide_speed; ?>,
                        dotsSpeed:<?php echo $team_pagination_slide_speed; ?>,



                    });

                });
            </script>
			<?php







		}

		if($team_pagination_type == 'jquery_pagination'){
			$team_grid_filterable_class = 'mix';

		}

		?>

		<?php

		include team_plugin_dir.'/templates/team/paginate.php';

		?>

        <div class="team-items <?php echo $team_grid_slider_class; ?>">
			<?php




			if ( $wp_query->have_posts() ) :

			while ( $wp_query->have_posts() ) : $wp_query->the_post();

				$team_member_position = get_post_meta(get_the_ID(), 'team_member_position', true );
				$team_member_social_links = get_post_meta( get_the_ID(), 'team_member_social_links', true );
				$team_member_link_to_post = get_post_meta( get_the_ID(), 'team_member_link_to_post', true );

				$team_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $team_items_thumb_size );
				$team_thumb_url = $team_thumb['0'];

				$team_popup_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $team_items_popup_thumb_size );
				$team_popup_thumb_url = $team_popup_thumb['0'];


				?><div class="item <?php echo $team_grid_filterable_class; ?> skin <?php echo team_term_slug_list(get_the_ID()); ?> <?php echo $team_themes; ?>" >

                <div class="layer-media">
					<?php



					foreach($team_grid_items as $key=>$name){

						if(empty($team_grid_items_hide[$key]) && $key=='thumbnail')
						{
							include team_plugin_dir.'templates/team/'.$key.'.php';
						}

					}

					?>
                </div>

                <div class="layer-content">
					<?php


					foreach($team_grid_items as $key=>$name){

						if(empty($team_grid_items_hide[$key]) && $key!='thumbnail')
						{
							include team_plugin_dir.'templates/team/'.$key.'.php';
						}

					}


					?>
                </div>
                </div><?php





				$current_nth_postion = $wp_query->current_post;

				do_action('team_grid_nth_item', $current_nth_postion);

				//var_dump($wp_query->current_post);

			endwhile;

			?>
        </div>
	<?php



	include team_plugin_dir.'/templates/team/paginate.php';


	wp_reset_query();

	else :

		echo __('No Team Member Found','wcps');



	endif;

	if($team_items_link_to_post == 'popup_slider'){

		include team_plugin_dir.'/templates/team/popup-slider.php';
	}


	include team_plugin_dir.'/templates/team/scripts.php';


	?>
    </div>
<?php
