<?php

if ( ! defined('ABSPATH')) exit;  // if direct access


?>

<script>
    jQuery(document).ready(function($){
        $("#team-container-<?php echo $post_id; ?> .item-list").owlCarousel({
            items : 3,
            responsiveClass:true,
            responsive:{
                320:{
                    items:<?php echo $slider_column_mobile; ?>,
                },
                768:{
                    items:<?php echo $slider_column_tablet; ?>,
                },
                1024:{
                    items:<?php echo $slider_column_desktop; ?>,
                }
            },
            loop: <?php echo $slider_loop; ?>,
            rewind: <?php echo $slider_rewind; ?>,
            center: <?php echo $slider_center; ?>,
            autoplay: <?php echo $slider_auto_play; ?>,
            autoplaySpeed: <?php echo $slider_auto_play_speed; ?>,
            autoplayTimeout: <?php echo $slider_auto_play_timeout; ?>,
            autoplayHoverPause: <?php echo $slider_stop_on_hover; ?>,
            nav: <?php echo $slider_navigation; ?>,
            navText : ["<i class='fas fa-angle-left'></i>","<i class='fas fa-angle-right'></i>"],
            dots: <?php echo $slider_pagination; ?>,
            navSpeed: <?php echo $slider_slide_speed; ?>,
            dotsSpeed: <?php echo $slider_pagination_slide_speed; ?>,
            touchDrag : <?php echo $slider_touch_drag; ?>,
            mouseDrag  : <?php echo $slider_mouse_drag; ?>,
            autoHeight: true,
        });



        $("#team-container-<?php echo $post_id; ?> .owl-dots").addClass('<?php echo $slider_pagination_theme; ?>');
        $("#team-container-<?php echo $post_id; ?> .owl-nav").addClass('<?php echo $slider_navigation_position; ?>');
        $("#team-container-<?php echo $post_id; ?> .owl-nav").addClass('<?php echo $slider_nav_theme; ?>');




    });
</script>
