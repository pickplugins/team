<?php
if ( ! defined('ABSPATH')) exit;  // if direct access



add_shortcode('update_team_data', 'update_team_data');


function update_team_data(){



    $args = array(
        'post_type'=>'team',
        'post_status'=>'any',
        'posts_per_page'=> -1,

    );



    $wp_query = new WP_Query($args);


    if ( $wp_query->have_posts() ) :
        while ( $wp_query->have_posts() ) : $wp_query->the_post();

            $team_id = get_the_id();
            $team_options = array();

            echo get_the_title().'<br/>';


            $team_bg_img = get_post_meta( $team_id, 'team_bg_img', true );
            $team_container_bg_color = get_post_meta( $team_id, 'team_container_bg_color', true );
            $team_themes = get_post_meta( $team_id, 'team_themes', true );
            $team_social_icon_style = get_post_meta( $team_id, 'team_social_icon_style', true );
            $team_masonry_enable = get_post_meta( $team_id, 'team_masonry_enable', true );
            $team_grid_item_align = get_post_meta( $team_id, 'team_grid_item_align', true );
            $team_item_text_align = get_post_meta( $team_id, 'team_item_text_align', true );
            $team_total_items = get_post_meta( $team_id, 'team_total_items', true );
            $team_pagination_display = get_post_meta( $team_id, 'team_pagination_display', true );
            $team_query_order = get_post_meta( $team_id, 'team_query_order', true );
            $team_query_orderby = get_post_meta( $team_id, 'team_query_orderby', true );
            $team_query_orderby_meta_key = get_post_meta( $team_id, 'team_query_orderby_meta_key', true );
            $team_content_source = get_post_meta( $team_id, 'team_content_source', true );
            $team_content_year = get_post_meta( $team_id, 'team_content_year', true );
            $team_content_month = get_post_meta( $team_id, 'team_content_month', true );
            $team_content_month_year = get_post_meta( $team_id, 'team_content_month_year', true );
            $team_taxonomy_terms = get_post_meta( $team_id, 'team_taxonomy_terms', true );
            $team_post_ids = get_post_meta( $team_id, 'team_post_ids', true );
            $team_items_title_color = get_post_meta( $team_id, 'team_items_title_color', true );
            $team_items_title_font_size = get_post_meta( $team_id, 'team_items_title_font_size', true );
            $team_items_title_font_family = get_post_meta( $team_id, 'team_items_title_font_family', true );

            $team_items_position_color = get_post_meta( $team_id, 'team_items_position_color', true );
            $team_items_position_font_size = get_post_meta( $team_id, 'team_items_position_font_size', true );
            $team_items_position_font_family = get_post_meta( $team_id, 'team_items_position_font_family', true );
            $team_items_content = get_post_meta( $team_id, 'team_items_content', true );
            $team_items_content_color = get_post_meta( $team_id, 'team_items_content_color', true );
            $team_items_content_font_size = get_post_meta( $team_id, 'team_items_content_font_size', true );
            $team_items_content_font_family = get_post_meta( $team_id, 'team_items_content_font_family', true );
            $team_pagination_bg_color = get_post_meta( $team_id, 'team_pagination_bg_color', true );
            $team_pagination_active_bg_color = get_post_meta( $team_id, 'team_pagination_active_bg_color', true );
            $team_items_excerpt_count = (int)get_post_meta( $team_id, 'team_items_excerpt_count', true );
            $team_items_excerpt_text = get_post_meta( $team_id, 'team_items_excerpt_text', true );
            $team_items_thumb_size = get_post_meta( $team_id, 'team_items_thumb_size', true );
            $team_items_link_to_post = get_post_meta( $team_id, 'team_items_link_to_post', true );
            $team_items_max_width = get_post_meta( $team_id, 'team_items_max_width', true );
            $team_items_width_tablet = get_post_meta( $team_id, 'team_items_width_tablet', true );
            $team_items_width_mobile = get_post_meta( $team_id, 'team_items_width_mobile', true );
            $team_items_thumb_max_hieght = get_post_meta( $team_id, 'team_items_thumb_max_hieght', true );
            $team_items_thumb_max_hieght_tablet = get_post_meta( $team_id, 'team_items_thumb_max_hieght_tablet', true );
            $team_items_thumb_max_hieght_mobile = get_post_meta( $team_id, 'team_items_thumb_max_hieght_mobile', true );
            $team_items_margin = get_post_meta( $team_id, 'team_items_margin', true );
            $team_items_social_icon_type = get_post_meta( $team_id, 'team_items_social_icon_type', true );
            $team_items_social_icon_width = get_post_meta( $team_id, 'team_items_social_icon_width', true );
            $team_items_social_icon_height = get_post_meta( $team_id, 'team_items_social_icon_height', true );
            $team_items_social_font_family = get_post_meta( $team_id, 'team_items_social_font_family', true );
            $team_grid_meta_keys = get_post_meta( $team_id, 'team_grid_meta_keys', true );
            $team_items_meta_font_family = get_post_meta( $team_id, 'team_items_meta_font_family', true );



            $team_items_custom_css = get_post_meta( $team_id, 'team_items_custom_css', true );
            $team_items_popup_content = get_post_meta( $team_id, 'team_items_popup_content', true );
            $team_items_popup_excerpt_count = get_post_meta( $team_id, 'team_items_popup_excerpt_count', true );
            $team_items_popup_excerpt_text = get_post_meta( $team_id, 'team_items_popup_excerpt_text', true );
            $team_items_popup_width = get_post_meta( $team_id, 'team_items_popup_width', true );
            $team_items_popup_height = get_post_meta( $team_id, 'team_items_popup_height', true );
            $team_items_popup_thumb_size = get_post_meta( $team_id, 'team_items_popup_thumb_size', true );
            $team_items_popup_thumb_src = get_post_meta( $team_id, 'team_items_popup_thumb_src', true );
            $popup_thumb_src_meta_key = get_post_meta( $team_id, 'popup_thumb_src_meta_key', true );
            $team_grid_items = get_post_meta( $team_id, 'team_grid_items', true );
            $team_grid_items_hide = get_post_meta( $team_id, 'team_grid_items_hide', true );
            $team_items_post_per_page_mixitup = get_post_meta( $team_id, 'team_items_post_per_page_mixitup', true );
            $team_items_default_filter_mixitup = get_post_meta( $team_id, 'team_items_default_filter_mixitup', true );
            $team_items_skill_bg_color = get_post_meta( $team_id, 'team_items_skill_bg_color', true );
            $team_items_skill_sort = get_post_meta( $team_id, 'team_items_skill_sort', true );
            $team_pagination_prev_text = get_post_meta( $team_id, 'team_pagination_prev_text', true );
            $team_pagination_next_text = get_post_meta( $team_id, 'team_pagination_next_text', true );
            $team_grid_style = get_post_meta( $team_id, 'team_grid_style', true );
            $team_pagination_type = get_post_meta( $team_id, 'team_pagination_type', true );
            $team_pagination_top = get_post_meta( $team_id, 'team_pagination_top', true );
            $team_column_number = get_post_meta( $team_id, 'team_column_number', true );
            $team_column_number_mobile = get_post_meta( $team_id, 'team_column_number_mobile', true );
            $team_column_number_tablet = get_post_meta( $team_id, 'team_column_number_tablet', true );
            $team_auto_play = get_post_meta( $team_id, 'team_auto_play', true );
            $team_slide_autoplaySpeed = get_post_meta( $team_id, 'team_slide_autoplaySpeed', true );
            $team_slide_autoplayTimeout = get_post_meta( $team_id, 'team_slide_autoplayTimeout', true );
            $team_slide_loop = get_post_meta( $team_id, 'team_slide_loop', true );
            $team_slide_rewind = get_post_meta( $team_id, 'team_slide_rewind', true );
            $team_slide_center = get_post_meta( $team_id, 'team_slide_center', true );
            $team_slide_rtl = get_post_meta( $team_id, 'team_slide_rtl', true );
            $team_stop_on_hover = get_post_meta( $team_id, 'team_stop_on_hover', true );
            $team_slider_navigation = get_post_meta( $team_id, 'team_slider_navigation', true );
            $team_slider_navigation_position = get_post_meta( $team_id, 'team_slider_navigation_position', true );
            $team_slide_speed = get_post_meta( $team_id, 'team_slide_speed', true );
            $team_slider_pagination = get_post_meta( $team_id, 'team_slider_pagination', true );
            $team_pagination_slide_speed = get_post_meta( $team_id, 'team_pagination_slide_speed', true );
            $team_slider_pagination_count = get_post_meta( $team_id, 'team_slider_pagination_count', true );
            $team_slider_pagination_bg = get_post_meta( $team_id, 'team_slider_pagination_bg', true );
            $team_slider_pagination_text_color = get_post_meta( $team_id, 'team_slider_pagination_text_color', true );
            $team_slider_touch_drag = get_post_meta( $team_id, 'team_slider_touch_drag', true );
            $team_slider_mouse_drag = get_post_meta( $team_id, 'team_slider_mouse_drag', true );
            $team_filter_bg_color = get_post_meta( $team_id, 'team_filter_bg_color', true );
            $team_filter_active_bg_color = get_post_meta( $team_id, 'team_filter_active_bg_color', true );
            $team_filter_text_color = get_post_meta( $team_id, 'team_filter_text_color', true );
            $team_filter_scroll_top = get_post_meta( $team_id, 'team_filter_scroll_top', true );


            // Slider Options
            $team_options['slider_column_desktop'] = $team_column_number;
            $team_options['slider_column_tablet'] = $team_column_number_tablet;
            $team_options['slider_column_mobile'] = $team_column_number_mobile;
            $team_options['slider_auto_play'] = $team_auto_play;
            $team_options['slider_auto_play_speed'] = $team_slide_autoplaySpeed;
            $team_options['slider_auto_play_timeout'] = $team_slide_autoplayTimeout;
            $team_options['slider_slide_speed'] = $team_slide_speed;
            $team_options['slider_pagination_slide_speed'] = $team_pagination_slide_speed;
            $team_options['slider_slideBy'] = $team_column_number;
            $team_options['slider_rewind'] = $team_slide_rewind;
            $team_options['slider_loop'] = $team_slide_loop;
            $team_options['slider_center'] = $team_slide_center;
            $team_options['slider_stop_on_hover'] = $team_stop_on_hover;
            $team_options['slider_navigation'] = $team_slider_navigation;
            $team_options['slider_navigation_position'] = $team_slider_navigation_position;
            $team_options['slider_nav_theme'] = 'navThemes1';
            $team_options['slider_pagination'] = $team_slider_pagination;
            $team_options['slider_pagination_bg'] = $team_slider_pagination_bg;
            $team_options['slider_pagination_bg_active'] = $team_slider_pagination_bg;
            $team_options['slider_pagination_text_color'] = $team_slider_pagination_text_color;
            $team_options['slider_pagination_theme'] = 'dotsThemes1';
            $team_options['slider_touch_drag'] = $team_slider_touch_drag;
            $team_options['slider_mouse_drag'] = $team_slider_mouse_drag;
            $team_options['slider_rtl'] = $team_slide_rtl;
            $team_options['slider_animateout'] = 'none';
            $team_options['slider_animateIn'] = 'none';


            $team_options['filterable_post_per_page'] = $team_items_post_per_page_mixitup;
            $team_options['filterable_default_filter'] = $team_items_default_filter_mixitup;
            $team_options['filterable_filter_bg_color'] = $team_filter_bg_color;
            $team_options['filterable_filter_active_bg_color'] = $team_filter_active_bg_color;
            $team_options['filterable_filter_text_color'] = $team_filter_text_color;
            $team_options['filterable_filter_scroll_top'] = $team_filter_scroll_top;

            $team_options['pagination_prev_text'] = $team_pagination_prev_text;
            $team_options['pagination_next_text'] = $team_pagination_next_text;
            $team_options['pagination_next_text'] = $team_pagination_next_text;
            $team_options['pagination_bg_color'] = $team_pagination_bg_color;
            $team_options['pagination_active_bg_color'] = $team_pagination_active_bg_color;
            $team_options['pagination_at_top'] = $team_pagination_top;
            $team_options['pagination_type'] = $team_pagination_type;


            $team_options['masonry_enable'] = $team_masonry_enable;

            $team_options['grid_type'] = $team_grid_style;
            $team_options['custom_css'] = $team_items_custom_css;
            $team_options['team_theme'] = $team_themes;
            $team_options['team_items_link_to_post'] = $team_items_link_to_post;

            $team_options['item_width_desktop'] = $team_items_max_width;
            $team_options['item_width_tablet'] = $team_items_width_tablet;
            $team_options['item_width_mobile'] = $team_items_width_mobile;
            $team_options['item_margin'] = $team_items_margin;
            $team_options['item_text_align'] = $team_item_text_align;
            $team_options['container_bg_img'] = $team_bg_img;
            $team_options['container_align'] = $team_grid_item_align;
            $team_options['container_bg_color'] = $team_container_bg_color;










            $team_options['team_query_orderby'] = $team_query_orderby;
            $team_options['team_query_orderby_meta_key'] = $team_query_orderby_meta_key;
            $team_options['team_query_order'] = $team_query_order;
            $team_options['team_total_items'] = $team_total_items;
            $team_options['team_taxonomy_terms'] = $team_taxonomy_terms;
            $team_options['team_post_ids'] = $team_post_ids;


            $team_options['team_items_thumb_size'] = $team_items_thumb_size;
            $team_options['team_items_thumb_max_hieght'] = $team_items_thumb_max_hieght;
            $team_options['team_items_thumb_max_hieght_tablet'] = $team_items_thumb_max_hieght_tablet;
            $team_options['team_items_thumb_max_hieght_mobile'] = $team_items_thumb_max_hieght_mobile;
            $team_options['team_items_title_color'] = $team_items_title_color;
            $team_options['team_items_title_font_size'] = $team_items_title_font_size;
            $team_options['team_items_title_font_family'] = $team_items_title_font_family;
            $team_options['team_items_position_color'] = $team_items_position_color;
            $team_options['team_items_position_font_size'] = $team_items_position_font_size;
            $team_options['team_items_position_font_family'] = $team_items_position_font_family;
            $team_options['team_items_content'] = $team_items_content;
            $team_options['team_items_excerpt_count'] = $team_items_excerpt_count;
            $team_options['team_items_excerpt_text'] = $team_items_excerpt_text;
            $team_options['team_items_content_color'] = $team_items_content_color;
            $team_options['team_items_content_font_size'] = $team_items_content_font_size;
            $team_options['team_items_content_font_family'] = $team_items_content_font_family;
            $team_options['team_items_social_icon_type'] = $team_items_social_icon_type;
            $team_options['team_items_social_icon_width'] = $team_items_social_icon_width;
            $team_options['team_items_social_icon_height'] = $team_items_social_icon_height;
            $team_options['team_social_icon_style'] = $team_social_icon_style;
            $team_options['team_items_social_font_family'] = $team_items_social_font_family;

            $team_options['team_items_popup_content'] = $team_items_popup_content;
            $team_options['team_items_popup_excerpt_count'] = $team_items_popup_excerpt_count;
            $team_options['team_items_popup_excerpt_text'] = $team_items_popup_excerpt_text;

            $team_options['team_items_popup_width'] = $team_items_popup_width;
            $team_options['team_items_popup_height'] = $team_items_popup_height;
            $team_options['team_items_popup_thumb_src'] = $team_items_popup_thumb_src;
            $team_options['popup_thumb_src_meta_key'] = $popup_thumb_src_meta_key;
            $team_options['team_grid_meta_keys'] = $team_grid_meta_keys;
            $team_options['team_items_meta_font_family'] = $team_items_meta_font_family;

            $team_options['team_items_skill_bg_color'] = $team_items_skill_bg_color;
            $team_options['team_items_skill_sort'] = $team_items_skill_sort;


            // Query team members

            $query_args['post_type'] 		= array('team_member');
            $query_args['orderby']  		= $team_query_orderby;
            $query_args['meta_key'] = $team_query_orderby_meta_key;
            $query_args['order']  			= $team_query_order;
            $query_args['posts_per_page'] 	= -1;

            if(!empty($team_post_ids)){

                $query_args['post__in']  		= $team_post_ids;

            }

            if(!empty($team_taxonomy_terms)){



                $query_args['tax_query']  		= array(


                    array(
                        'taxonomy' => 'team_group',
                        'field' => 'id',
                        'terms' => $team_taxonomy_terms,
                    )
                );


            }

            $team_member_query_args = apply_filters('team_filter_query_args', $query_args);

            //var_dump($team_member_query_args);





            $team_member_slug = get_option('team_member_slug');
            $team_member_meta_fields = get_option('team_member_meta_fields');
            $team_member_social_field = get_option('team_member_social_field');
            $team_member_single_skill_sort = get_option('team_member_single_skill_sort');
            $team_member_display_thumbnail = get_option('team_member_display_thumbnail');


            ?>

            <pre><?php echo var_export($team_member_query_args, true); ?></pre>

            <?php

            $team_member_query = new WP_Query($team_member_query_args);

            if ( $team_member_query->have_posts() ) :

                //$team_options = array();

                while ( $team_member_query->have_posts() ) : $team_member_query->the_post();

                    $team_member_id = get_the_id();





                    $team_member_position = get_post_meta( $team_member_id, 'team_member_position', true );
                    $team_member_link_to_post = get_post_meta( $team_member_id, 'team_member_link_to_post', true );
                    $team_member_skill = get_post_meta( $team_member_id, 'team_member_skill', true );
                    $team_address = get_post_meta( $team_member_id, 'team_address', true );
                    $team_member_social_links = get_post_meta( $team_member_id, 'team_member_social_links', true );

                    $post_title = get_the_title();
                    $post_content = get_the_content();
                    $thumbnail_id = get_post_meta( $team_member_id, '_thumbnail_id', true );
                    $menu_order = get_post_field( 'menu_order', $team_member_id);
                    $post_taxonomies = get_post_taxonomies($team_member_id);
                    $team_groups = wp_get_post_terms($team_member_id, 'team_group', array("fields" => "all"));

                    $team_options['team_members'][$team_member_id]['name'] = $post_title;
                    $team_options['team_members'][$team_member_id]['content'] = $post_content;
                    $team_options['team_members'][$team_member_id]['thumbnail'] = $thumbnail_id;
                    $team_options['team_members'][$team_member_id]['position'] = $team_member_position;
                    $team_options['team_members'][$team_member_id]['custom_link'] = $team_member_link_to_post;

                    $classes = '';

                    if(!empty($team_groups)):

                        foreach ($team_groups as $group):
                            $classes .= $group->slug. ' ';
                        endforeach;
                    endif;

                    $team_options['team_members'][$team_member_id]['class'] = $classes;

                    $skill_list = array();

                    if(!empty($team_member_skill)):
                        foreach ($team_member_skill as $skill):

                            $skill_value = isset($skill['value']) ? $skill['value'] : '';
                            $skill_name = isset($skill['name']) ? $skill['name'] : '';

                            if(!empty($skill_name) && !empty($skill_value)):
                            $skill_list[] = $skill_name.'|'.$skill_value;
                            else:

                            endif;
                        endforeach;
                    endif;

                    $team_options['team_members'][$team_member_id]['skill'] = $skill_list;

                    $link_list = array();

                    if(!empty($team_member_social_links)):
                        $i= 0;
                        foreach ($team_member_social_links as $socialId => $social):

                            if(!empty($social)):

                                if($socialId == 'mobile'):
                                    $link_list[$i]['type'] = 'phone';
                                    $link_list[$i]['value'] = $social;
                                    $link_list[$i]['label'] = 'Mobile';
                                    $link_list[$i]['icon'] = '<i class="fas fa-phone-square"></i>';

                                elseif($socialId == 'website'):

                                    $link_list[$i]['type'] = 'link';
                                    $link_list[$i]['value'] = $social;
                                    $link_list[$i]['label'] = 'Website';
                                    $link_list[$i]['icon'] = '<i class="fas fa-external-link-square-alt"></i>';

                                elseif($socialId == 'email'):

                                    $link_list[$i]['type'] = 'email';
                                    $link_list[$i]['value'] = $social;
                                    $link_list[$i]['label'] = 'Email';
                                    $link_list[$i]['icon'] = '<i class="fas fa-envelope-square"></i>';

                                elseif($socialId == 'skype'):

                                    $link_list[$i]['type'] = 'skype';
                                    $link_list[$i]['value'] = $social;
                                    $link_list[$i]['label'] = 'Skype';
                                    $link_list[$i]['icon'] = '<i class="fab fa-skype"></i>';

                                elseif($socialId == 'facebook'):

                                    $link_list[$i]['type'] = 'link';
                                    $link_list[$i]['value'] = $social;
                                    $link_list[$i]['label'] = 'Facebook';
                                    $link_list[$i]['icon'] = '<i class="fab fa-facebook-square"></i>';



                                else:

                                    $link_list[$i]['type'] = 'link';
                                    $link_list[$i]['value'] = $social;
                                    $link_list[$i]['label'] = '';
                                    $link_list[$i]['icon'] = '<i class="fas fa-external-link-square-alt"></i>';

                                endif;

                            endif;



                            $i++;
                        endforeach;
                    endif;

                    $team_options['team_members'][$team_member_id]['contacts'] = $link_list;






                endwhile;
                wp_reset_query();
                wp_reset_postdata();

            else:



            endif;





            $update = update_post_meta( $team_id, 'team_options', $team_options );




            wp_reset_query();
            wp_reset_postdata();
        endwhile;
    endif;



    ?>
    <pre><?php //echo var_export($team_options, true); ?></pre>
    <pre><?php //echo var_export($team_options, true); ?></pre>

    <?php



}



		
		
		
		

		
		