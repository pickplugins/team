<?php

if ( ! defined('ABSPATH')) exit;  // if direct access



$team_options = get_post_meta( $post_id, 'team_options', true );
$team_template_options = get_post_meta( $template_id, 'team_template_options', true );
$popup_template_options = get_post_meta($template_id, 'popup_template_options', true);


$template_layout_items = isset($team_template_options['layout_items']) ? $team_template_options['layout_items'] : array();
$grid_type = isset($team_options['grid_type']) ? $team_options['grid_type'] : 'grid';
$popup_layout_items = isset($popup_template_options['layout_items']) ? $popup_template_options['layout_items'] : array();



?>


<style type="text/css">
    #team-container-<?php echo $post_id; ?> .thumbnail{}
    #team-container-<?php echo $post_id; ?> .thumbnail img{
        box-shadow: none;
        border-radius: 0;
    }
    #team-container-<?php echo $post_id; ?> .skill-list{}
    #team-container-<?php echo $post_id; ?> .skill-item{
        background: #f3f3f3;
        margin: 5px 0;
        padding: 0;
        font-size: 11px;
    }
    #team-container-<?php echo $post_id; ?> .skill-width{
        background: #eaeaea;
        padding: 0 0;
    }
    #team-container-<?php echo $post_id; ?> .skill-name{
        padding: 0 5px;
    }
    #team-container-<?php echo $post_id; ?> .skill-value{}

    #team-container-<?php echo $post_id; ?> .contacts{}

    #team-container-<?php echo $post_id; ?> .contacts a{
        font-size: 26px;
        margin: 0 6px 0 0;
        text-decoration: none;
    }
    #team-container-<?php echo $post_id; ?> .contacts span{
        font-size: 26px;
        margin: 0 6px 0 0;
    }
    <?php


    if($grid_type == 'grid'):

        ?>
        #team-container-<?php echo $post_id; ?>{}
        #team-container-<?php echo $post_id; ?> .item {
            width: 250px;
            display: inline-block;
            vertical-align: top;
            margin: 15px;
            text-align: <?php echo $item_text_align;?>;
        }
        #team-container-<?php echo $post_id; ?> .item-wrap{}
        #team-container-<?php echo $post_id; ?> .element{
            margin-bottom: 10px;
        }

        @media (max-width: 767.98px) {

            #team-container-<?php echo $post_id; ?> .item{

                width: <?php echo $item_width_mobile;?>;

            }
        }

        @media (min-width: 768px) and (max-width: 1199.98px) {

            #team-container-<?php echo $post_id; ?> .item{

                width: <?php echo $item_width_tablet;?>;

            }
        }

        @media (min-width: 1200px) {

            #team-container-<?php echo $post_id; ?> .item{

                width: <?php echo $item_width_desktop;?>;

            }
        }


    <?php


elseif ($grid_type == 'filterable'):

    ?>
    #team-container-<?php echo $post_id; ?> .mix{
    display: none;
    }
    #team-container-<?php echo $post_id; ?> .item {
        width: 250px;
        vertical-align: top;
        margin: 15px;
    }
    #team-container-<?php echo $post_id; ?> .item-wrap{}
    #team-container-<?php echo $post_id; ?> .element{
        margin-bottom: 10px;
    }
    @media (max-width: 767.98px) {
        #team-container-<?php echo $post_id; ?> .item{
            width: <?php echo $item_width_mobile;?>;
        }
    }

    @media (min-width: 768px) and (max-width: 1199.98px) {
        #team-container-<?php echo $post_id; ?> .item{
            width: <?php echo $item_width_tablet;?>;
        }
    }
    @media (min-width: 1200px) {
        #team-container-<?php echo $post_id; ?> .item{
            width: <?php echo $item_width_desktop;?>;
        }
    }
    .filterable .filterable-navs{
        text-align: center;
    }
    .filterable .navGroup{
        display: inline-block;
        margin: 0 10px;
        padding: 4px 10px;
    }
    .filterable .filter{
        display: inline-block;
        background: <?php echo $filterable_filter_bg_color; ?>;
        padding:<?php echo $filterable_filter_padding; ?>;
        margin:<?php echo $filterable_filter_margin; ?>;
        color: <?php echo $filterable_filter_text_color; ?>;
        cursor: pointer;
    }
    .filterable .filter.active{
        background: <?php echo $filterable_filter_active_bg_color; ?>;
    }
    .pager-list{
        text-align: center;
    }
    .pager-list .pager{
        padding: <?php echo $pagination_item_padding; ?>;
        color: <?php echo $pagination_text_color; ?>;
        background: <?php echo $pagination_bg_color; ?>;
        cursor: pointer;
    }
    .pager-list .pager.active{
        background: <?php echo $pagination_active_bg_color; ?>;
    }
    <?php

elseif ($grid_type == 'slider'):


?>
    #team-container-<?php echo $post_id; ?> .item {
        margin: 15px;
    }

    .owl-nav .owl-prev,.owl-nav .owl-next{
        background: <?php echo $slider_pagination_bg; ?> !important;
        color: <?php echo $slider_pagination_text_color; ?> !important;
    }

    .owl-theme .owl-dots .owl-dot{
        outline: none;
    }

    .owl-theme .owl-dots .owl-dot span{
        background: <?php echo $slider_pagination_bg; ?>;
        color: <?php echo $slider_pagination_text_color; ?>;
    }




    .owl-theme .owl-dots .owl-dot.active span, .owl-theme .owl-dots .owl-dot:hover span{
        background: <?php echo $slider_pagination_bg_active; ?>;
    }

<?php


endif;













foreach ($template_layout_items as $layout_item_key=>$layoutData):

    $layoutStyle = $layoutData['style'];

    if($layout_item_key == 'thumbnail'){
        echo '#team-container-'.$post_id.' .'.$layout_item_key.' img, #team-container-'.$post_id.' .'.$layout_item_key.'{';
    }else{
        echo '#team-container-'.$post_id.' .'.$layout_item_key.'{';
    }



        foreach ($layoutStyle as $styleId=>$styleVal){

            if(!empty($styleVal))
            echo $styleId.':'.$styleVal.';';



        }

    echo '}';
    echo "\r\n";
endforeach;
















?>

    .team-popup-box .item-wrap {
        width: 70%;
        margin: 90px auto;
        background: #fff;
    }



</style>
