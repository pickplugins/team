<?php

if ( ! defined('ABSPATH')) exit;  // if direct access

$team_options = get_post_meta( $post_id, 'team_options', true );

$team_members = isset($team_options['team_members']) ? $team_options['team_members'] : array();



$template = isset($team_options['template']) ? $team_options['template'] : 'templateA';
$template_id = isset($team_options['template_id']) ? $team_options['template_id'] : team_1st_template_id();





$item_width_desktop = isset($team_options['item_width_desktop']) ? $team_options['item_width_desktop'] : '250px';
$item_width_tablet = isset($team_options['item_width_tablet']) ? $team_options['item_width_tablet'] : '250px';
$item_width_mobile = isset($team_options['item_width_mobile']) ? $team_options['item_width_mobile'] : '250px';
$filter_nav_args = isset($team_options['filter_nav_args']) ? $team_options['filter_nav_args'] : '';
$grid_type = isset($team_options['grid_type']) ? $team_options['grid_type'] : 'grid';




$layout_items = isset($team_options['layout_items']) ? $team_options['layout_items'] : array();
$layout_items_sort = isset($team_options['layout_items_sort']) ? $team_options['layout_items_sort'] : array();
$layout_items_hide = isset($team_options['layout_items_hide']) ? $team_options['layout_items_hide'] : array();



$item_text_align = isset($team_options['item_text_align']) ? $team_options['item_text_align'] : 'left';

$masonry_enable = isset($team_options['masonry_enable']) ? $team_options['masonry_enable'] : 'no';
$filterable_post_per_page = isset($team_options['filterable_post_per_page']) ? $team_options['filterable_post_per_page'] : '6';
$filterable_default_filter = isset($team_options['filterable_default_filter']) ? $team_options['filterable_default_filter'] : 'all';
$filterable_filter_bg_color = isset($team_options['filterable_filter_bg_color']) ? $team_options['filterable_filter_bg_color'] : '#ddd';
$filterable_filter_active_bg_color = isset($team_options['filterable_filter_active_bg_color']) ? $team_options['filterable_filter_active_bg_color'] : '#eee';
$filterable_filter_text_color = isset($team_options['filterable_filter_text_color']) ? $team_options['filterable_filter_text_color'] : '#999';
$filterable_filter_padding = isset($team_options['filterable_filter_padding']) ? $team_options['filterable_filter_padding'] : '2px 15px';

$filterable_filter_margin = isset($team_options['filterable_filter_margin']) ? $team_options['filterable_filter_margin'] : '2px';





$pagination_prev_text = isset($team_options['pagination_prev_text']) ? $team_options['pagination_prev_text'] : '6';
$pagination_next_text = isset($team_options['pagination_next_text']) ? $team_options['pagination_next_text'] : '6';
$pagination_bg_color = isset($team_options['pagination_bg_color']) ? $team_options['pagination_bg_color'] : '#ddd';
$pagination_active_bg_color = isset($team_options['pagination_active_bg_color']) ? $team_options['pagination_active_bg_color'] : '#999';
$pagination_item_padding = isset($team_options['pagination_item_padding']) ? $team_options['pagination_item_padding'] : '5px 15px';
$pagination_text_color = isset($team_options['pagination_text_color']) ? $team_options['pagination_text_color'] : '#fff';





$slider_column_desktop = isset($team_options['slider_column_desktop']) ? $team_options['slider_column_desktop'] : '3';
$slider_column_tablet = isset($team_options['slider_column_tablet']) ? $team_options['slider_column_tablet'] : '1';
$slider_column_mobile = isset($team_options['slider_column_mobile']) ? $team_options['slider_column_mobile'] : '1';

$slider_rows_enable = isset($team_options['slider_rows_enable']) ? $team_options['slider_rows_enable'] : 'false';
$slider_rows_desktop = isset($team_options['slider_rows_desktop']) ? $team_options['slider_rows_desktop'] : '2';
$slider_rows_tablet = isset($team_options['slider_rows_tablet']) ? $team_options['slider_rows_tablet'] : '2';
$slider_rows_mobile = isset($team_options['slider_rows_mobile']) ? $team_options['slider_rows_mobile'] : '2';

$slider_auto_play = isset($team_options['slider_auto_play']) ? $team_options['slider_auto_play'] : 'true';
$slider_auto_play_speed = isset($team_options['slider_auto_play_speed']) ? $team_options['slider_auto_play_speed'] : '1200';
$slider_auto_play_timeout = isset($team_options['slider_auto_play_timeout']) ? $team_options['slider_auto_play_timeout'] : '1000';

$slider_slide_speed = isset($team_options['slider_slide_speed']) ? $team_options['slider_slide_speed'] : '1000';
$slider_pagination_slide_speed = isset($team_options['slider_pagination_slide_speed']) ? $team_options['slider_pagination_slide_speed'] : '1000';
$slider_slideBy = isset($team_options['slider_slideBy']) ? $team_options['slider_slideBy'] : '4';


$slider_rewind = isset($team_options['slider_rewind']) ? $team_options['slider_rewind'] : 'true';
$slider_loop = isset($team_options['slider_loop']) ? $team_options['slider_loop'] : 'true';
$slider_center = isset($team_options['slider_center']) ? $team_options['slider_center'] : 'false';
$slider_stop_on_hover = isset($team_options['slider_stop_on_hover']) ? $team_options['slider_stop_on_hover'] : 'true';
$slider_navigation = isset($team_options['slider_navigation']) ? $team_options['slider_navigation'] : 'false';
$slider_navigation_position = isset($team_options['slider_navigation_position']) ? $team_options['slider_navigation_position'] : 'top-right';
$slider_nav_theme = isset($team_options['slider_nav_theme']) ? $team_options['slider_nav_theme'] : 'navThemes1';



$slider_pagination = isset($team_options['slider_pagination']) ? $team_options['slider_pagination'] : 'false';
$slider_pagination_bg = isset($team_options['slider_pagination_bg']) ? $team_options['slider_pagination_bg'] : '';
$slider_pagination_bg_active = isset($team_options['slider_pagination_bg_active']) ? $team_options['slider_pagination_bg_active'] : '';
$slider_pagination_theme = isset($team_options['slider_pagination_theme']) ? $team_options['slider_pagination_theme'] : 'dotsThemes7';


$slider_pagination_text_color = isset($team_options['slider_pagination_text_color']) ? $team_options['slider_pagination_text_color'] : '';
$slider_pagination_count = isset($team_options['slider_pagination_count']) ? $team_options['slider_pagination_count'] : 'false';

$slider_touch_drag = isset($team_options['slider_touch_drag']) ? $team_options['slider_touch_drag'] : 'true';
$slider_mouse_drag = isset($team_options['slider_mouse_drag']) ? $team_options['slider_mouse_drag'] : 'true';
$slider_rtl = isset($team_options['slider_rtl']) ? $team_options['slider_rtl'] : 'false';

$slider_animateout = isset($team_options['slider_animateout']) ? $team_options['slider_animateout'] : '';
$slider_animateIn = isset($team_options['slider_animateIn']) ? $team_options['slider_animateIn'] : '';





