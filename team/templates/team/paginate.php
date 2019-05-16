<?php

/*
* @Author 		ParaTheme

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



		if($team_grid_style=='filterable'){
			$team_pagination_type = 'jquery_pagination';
			}




		if($team_pagination_type == 'pagination'){

			?>
			<div class="paginate">
			<?php


				$big = 999999999; // need an unlikely integer
				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, $paged ),
					'total' => $wp_query->max_num_pages
					) );

				?>
			</div >
			<?php

				
			}
		elseif($team_pagination_type == 'jquery_pagination'){

			?>
			<div class="paginate pager-list"></div >
			<?php
			

		
				?>
			<script>
                jQuery(document).ready(function($) {

                    $(function(){

                        $("#team-<?php echo $post_id; ?>").mixItUp({
                                pagination: {
                                    limit: <?php echo $team_items_post_per_page_mixitup; ?>,
                                    prevButtonHTML: "<?php echo $team_pagination_prev_text; ?>",
                                    nextButtonHTML: "<?php echo $team_pagination_next_text; ?>",

                                },

                                selectors: {
                                    filter: ".filter"
                                },
						<?php
	

		
	if(!empty($team_items_default_filter_mixitup) && $team_items_default_filter_mixitup!= 'all')
		{

			?>
                                load: {
                                    filter: ".<?php echo $team_items_default_filter_mixitup; ?>"
                                },

                            <?php


		}
		
		
		
		
		
		
		?>
                            controls: {
                                enable: true
                            }

                        });

                    });




                });
			</script>
	                        <?php



	?>
			<style type="text/css">

				#team-<?php echo $post_id; ?> .mix{
					                   display: none;
				                   }


			</style>
<?php
		


			
			
			
			}