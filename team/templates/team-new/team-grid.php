<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


include team_plugin_dir.'/templates/team-new/variables.php';

$class_team_functions = new class_team_functions();

$template_data = get_post_meta($template_id, 'team_template_options', true);


$template_html = isset($template_data['template_html']) ? ($template_data['template_html']) : '';
$template_css = isset($template_data['template_css']) ? ($template_data['template_css']) : '';

$layout_items = isset($template_data['layout_items']) ? ($template_data['layout_items']) : '';
$popup_layout_items = isset($template_data['popup_layout_items']) ? ($template_data['popup_layout_items']) : '';



$popup_template_html = isset($template_data['popup_template_html']) ? ($template_data['popup_template_html']) : '';
$popup_template_css = isset($template_data['popup_template_css']) ? ($template_data['popup_template_css']) : '';



//var_dump($layout_items);




?>



<div class="team-container <?php echo $grid_type; ?> <?php if($grid_type=='slider') echo 'nav-'.$slider_navigation_position; ?>" id="team-container-<?php echo $post_id; ?>">

    <?php

    if(!empty($filter_nav_args) && $grid_type =='filterable'):
        ?>
        <div class="filterable-navs">
        <?php
        foreach ( $filter_nav_args as $navGroupIndex=>$navGroup):

            ?>
            <div class="navGroup">
                <span class="filter filter-all" data-filter="all">All</span>
                <?php
                if(!empty($navGroup)):

                    //foreach ($navGroup as $navList):

                        $navsItems = explode(',', $navGroup);



                        //var_dump($navsItems);

                        foreach ($navsItems as $navItem):

                            $navsItem = explode('|', $navItem);

                            $navName = isset($navsItem[0]) ? $navsItem[0] : '';
                            $navId = isset($navsItem[1]) ? $navsItem[1] : '';

                            $navId = str_replace(' ', '', $navId);


                            ?>
                            <span class="filter filter-<?php echo $navId; ?>" data-filter=".<?php echo $navId; ?>"><?php echo $navName; ?></span>
                        <?php
                        endforeach;




                    //endforeach;

                endif;
                ?>

            </div>
            <?php

        endforeach;

        ?>
        </div>
        <?php
    endif;


    ?>

    <div class="item-list <?php if($grid_type=='slider') echo 'owl-carousel owl-theme'; ?>"> <?php // owl-carousel owl-theme ?>
        <?php

        if(!empty($team_members))
        foreach ($team_members as $team_memberIndex => $team_member):
            $class = $team_member['class'];

            $vars = array();
            $elementHTML = '';

            $vars = apply_filters('team_custom_parameter', $vars);
            ?>

            <div class="item <?php if($grid_type=='filterable') echo 'mix'; ?> <?php echo $class; ?>">

                <?php


                if(!empty($team_member))
                foreach ($team_member as $element_key => $elementValue):

                    $link_to = '';

                    if(!empty($elementValue)):

                        if($element_key == 'thumbnail'){

                            $link_to = isset($layout_items['thumbnail']['settings']['link_to']) ? $layout_items['thumbnail']['settings']['link_to'] : 'none';

                            if($link_to == 'popup_box'):
                                $element_class = 'team-popup';
                                $element_link = '?teamid='.$post_id.'&teamMember='.$team_memberIndex;

                            elseif ($link_to == 'popup_slider'):
                                $element_class = 'team-popup-slider';
                                $element_link = '#'.$team_memberIndex;

                            elseif ($link_to == 'single_page'):
                                $element_link = '?teamid='.$post_id.'&teamMember='.$team_memberIndex;

                            elseif ($link_to == 'custom_url'):
                                $element_link = '?teamid='.$post_id.'&teamMember='.$team_memberIndex;

                            endif;


                            $media_url	= wp_get_attachment_url( $elementValue );
                            $elementHTML = '<img teamid="'.$team_memberIndex.'" class="'.$element_class.'" alt="'.$element_key.'" src="'.$media_url.'">';

                        }
                        elseif($element_key == 'name'){

                            $link_to = isset($layout_items['name']['settings']['link_to']) ? $layout_items['name']['settings']['link_to'] : 'none';
                            $element_class = '';


                            if($link_to == 'popup_box'):
                                $element_class = 'team-popup';
                                $element_link = '?teamid='.$post_id.'&teamMember='.$team_memberIndex;

                            elseif ($link_to == 'popup_slider'):
                                $element_class = 'team-popup-slider';
                                $element_link = '#'.$team_memberIndex;

                            elseif ($link_to == 'single_page'):
                                $element_link = '?teamid='.$post_id.'&teamMember='.$team_memberIndex;

                            elseif ($link_to == 'custom_url'):
                                $element_link = '?teamid='.$post_id.'&teamMember='.$team_memberIndex;

                            endif;


                            $elementHTML = '<a teamid="'.$team_memberIndex.'" class="'.$element_class.'" href="'.$element_link.'" >'.$elementValue.'</a>';

                        }

                        elseif($element_key == 'content'){


                            $word_count = isset($layout_items['content']['settings']['word_count']) ? $layout_items['content']['settings']['word_count'] : 0;
                            $read_more_text = isset($layout_items['content']['settings']['read_more_text']) ? $layout_items['content']['settings']['read_more_text'] : '';
                            $link_to = isset($layout_items['name']['settings']['link_to']) ? $layout_items['name']['settings']['link_to'] : 'none';

                            //$media_url	= wp_get_attachment_url( $elementValue );

                            if($link_to == 'popup_box'):
                                $element_class = 'team-popup';
                                $element_link = '?teamid='.$post_id.'&teamMember='.$team_memberIndex;

                            elseif ($link_to == 'popup_slider'):
                                $element_class = 'team-popup-slider';
                                $element_link = '#'.$team_memberIndex;

                            elseif ($link_to == 'single_page'):
                                $element_link = '?teamid='.$post_id.'&teamMember='.$team_memberIndex;

                            elseif ($link_to == 'custom_url'):
                                $element_link = '?teamid='.$post_id.'&teamMember='.$team_memberIndex;

                            endif;



                            $elementHTML = wp_trim_words($elementValue, $word_count, '<a teamid="'.$team_memberIndex.'" class="'.$element_class.'" href="'.$element_link.'" class="read-more">'.$read_more_text.'</a>');

                        }


                        elseif($element_key == 'skill'){


                            $skillHTML = '';



                            if(!empty($elementValue)):

                                $skillHTML .= '<div class="skill-list">';
                                foreach ($elementValue as $skillData):

                                    $skillData = explode('|', $skillData);
                                    $skillName = isset($skillData[0]) ? $skillData[0] : '';
                                    $skillValue = isset($skillData[1]) ? $skillData[1] : '';


                                    if(!empty($skillValue))
                                        $skillHTML .= '<div class="skill-item"><div style="width: '.$skillValue.'" class="skill-width"><span class="skill-name">'.$skillName.'</span><span class="skill-value">'.$skillValue.'</span></div></div>';


                                endforeach;
                                $skillHTML .= '</div>';
                            endif;



                            $elementHTML = $skillHTML;

                        }

                        elseif($element_key == 'contacts'){



                            $contactsHTML = '';

                            foreach ($elementValue as $contactData):



                                $type = $contactData['type'];
                                $value = $contactData['value'];
                                $label = $contactData['label'];
                                $icon = $contactData['icon'];

                                //var_dump($type);

                                if(!empty($value)):
                                    if($type == 'link'):
                                        $contactsHTML .= '<a href="'.$value.'">'.$icon.'</a>';

                                    elseif ($type == 'email'):
                                        $contactsHTML .= '<a  href="mailto:'.$value.'">'.$icon.'</a>';

                                    elseif ($type == 'phone'):
                                        $contactsHTML .= '<a href="tel:'.$value.'">'.$icon.'</a>';

                                    elseif ($type == 'text'):
                                        $contactsHTML .= '<span>'.$value.'</span>';

                                    elseif ($type == 'skype'):
                                        $contactsHTML .= '<a href="skype:'.$value.'">'.$icon.'</a>';

                                    endif;

                                endif;




                            endforeach;

                            $elementHTML = $contactsHTML;

                        }
                        else{
                            $elementHTML = $elementValue;
                        }

                    else:

                        $elementHTML = '';

                    endif;



                    $filterArgs= array('elementValue'=>$elementValue,'elementKey'=>$element_key, 'teamId'=>$post_id, 'templateId'=>$template_id);
                    $elementHTML = !empty($elementHTML) ? $elementHTML : '';

                    //var_dump($element_key);

                    $vars['{{'.$element_key.'}}'] = apply_filters('team_parameter_html', $elementHTML, $filterArgs);

                endforeach;




                //var_dump($vars);



                echo strtr($template_html, $vars);



                ?>

            </div>
            <?php
        endforeach;



        ?>

    </div>




    <?php if($grid_type=='filterable'): ?>
    <div class="paginate pager-list"></div >
    <?php endif; ?>



    <div class="team-popup-box-wrap">
        <?php

        if(!empty($team_members))
            foreach ($team_members as $team_memberIndex => $team_member):
                $class = $team_member['class'];

                $vars = array();
                $elementHTML = '';

                $vars = apply_filters('team_custom_parameter', $vars);
                ?>

                <div class="team-popup-box team-popup-box-<?php  echo $team_memberIndex; ?> ">


                    <?php


                    if(!empty($team_member))
                        foreach ($team_member as $element_key => $elementValue):

                            if(!empty($elementValue)):

                                if($element_key == 'thumbnail'){
                                    $media_url	= wp_get_attachment_url( $elementValue );
                                    $elementHTML = '<img alt="'.$element_key.'" src="'.$media_url.'">';

                                }
                                elseif($element_key == 'name'){

                                    $link_to = isset($popup_layout_items['name']['settings']['link_to']) ? $popup_layout_items['name']['settings']['link_to'] : 'none';
                                    $element_class = '';


                                    if($link_to == 'popup_box'):
                                        $element_class = 'team-popup';

                                    elseif ($link_to == 'popup_slider'):
                                        $element_class = 'team-popup-slider';
                                    elseif ($link_to == 'single_page'):
                                    elseif ($link_to == 'custom_url'):

                                    endif;


                                    $elementHTML = '<a teamid="'.$team_memberIndex.'" class="'.$element_class.'" href="?teamid='.$post_id.'&teamMember='.$team_memberIndex.'" >'.$elementValue.'</a>';

                                }

                                elseif($element_key == 'content'){

                                    $word_count = isset($popup_layout_items['content']['settings']['word_count']) ? $popup_layout_items['content']['settings']['word_count'] : 0;
                                    $read_more_text = isset($popup_layout_items['content']['settings']['read_more_text']) ? $popup_layout_items['content']['settings']['read_more_text'] : '';


                                    //$media_url	= wp_get_attachment_url( $elementValue );




                                    $elementHTML = wp_trim_words($elementValue, $word_count, '<a href="#" class="read-more">'.$read_more_text.'</a>');

                                }


                                elseif($element_key == 'skill'){


                                    $skillHTML = '';



                                    if(!empty($elementValue)):

                                        $skillHTML .= '<div class="skill-list">';
                                        foreach ($elementValue as $skillData):

                                            $skillData = explode('|', $skillData);
                                            $skillName = isset($skillData[0]) ? $skillData[0] : '';
                                            $skillValue = isset($skillData[1]) ? $skillData[1] : '';


                                            if(!empty($skillValue))
                                                $skillHTML .= '<div class="skill-item"><div style="width: '.$skillValue.'" class="skill-width"><span class="skill-name">'.$skillName.'</span><span class="skill-value">'.$skillValue.'</span></div></div>';


                                        endforeach;
                                        $skillHTML .= '</div>';
                                    endif;



                                    $elementHTML = $skillHTML;

                                }

                                elseif($element_key == 'contacts'){



                                    $contactsHTML = '';

                                    foreach ($elementValue as $contactData):



                                        $type = $contactData['type'];
                                        $value = $contactData['value'];
                                        $label = $contactData['label'];
                                        $icon = $contactData['icon'];

                                        //var_dump($type);

                                        if(!empty($value)):
                                            if($type == 'link'):
                                                $contactsHTML .= '<a href="'.$value.'">'.$icon.'</a>';

                                            elseif ($type == 'email'):
                                                $contactsHTML .= '<a  href="mailto:'.$value.'">'.$icon.'</a>';

                                            elseif ($type == 'phone'):
                                                $contactsHTML .= '<a href="tel:'.$value.'">'.$icon.'</a>';

                                            elseif ($type == 'text'):
                                                $contactsHTML .= '<span>'.$value.'</span>';

                                            elseif ($type == 'skype'):
                                                $contactsHTML .= '<a href="skype:'.$value.'">'.$icon.'</a>';

                                            endif;

                                        endif;




                                    endforeach;

                                    $elementHTML = $contactsHTML;

                                }
                                else{
                                    $elementHTML = $elementValue;
                                }

                            else:

                                $elementHTML = '';

                            endif;



                            $filterArgs= array('elementValue'=>$elementValue,'elementKey'=>$element_key, 'teamId'=>$post_id, 'templateId'=>$template_id);
                            $elementHTML = !empty($elementHTML) ? $elementHTML : '';

                            //var_dump($element_key);

                            $vars['{{'.$element_key.'}}'] = apply_filters('team_parameter_html', $elementHTML, $filterArgs);

                        endforeach;




                    //var_dump($vars);



                    echo strtr($popup_template_html, $vars);



                    ?>

                </div>
            <?php
            endforeach;



        ?>

    </div>


    <div class="team-popup-slider-wrap">

        <div class="popup-slider">
            <div class="owl-carousel owl-theme">

        <?php

        if(!empty($team_members))
            foreach ($team_members as $team_memberIndex => $team_member):
                $class = $team_member['class'];

                $vars = array();
                $elementHTML = '';

                $vars = apply_filters('team_custom_parameter', $vars);
                ?>

                <div class="item" data-hash="<?php  echo $team_memberIndex; ?>">


                    <?php


                    if(!empty($team_member))
                        foreach ($team_member as $element_key => $elementValue):

                            if(!empty($elementValue)):

                                if($element_key == 'thumbnail'){
                                    $media_url	= wp_get_attachment_url( $elementValue );
                                    $elementHTML = '<img alt="'.$element_key.'" src="'.$media_url.'">';

                                }
                                elseif($element_key == 'name'){

                                    $link_to = isset($popup_layout_items['name']['settings']['link_to']) ? $popup_layout_items['name']['settings']['link_to'] : 'none';
                                    $element_class = '';


                                    if($link_to == 'popup_box'):
                                        $element_class = 'team-popup';

                                    elseif ($link_to == 'popup_slider'):
                                        $element_class = 'team-popup-slider';
                                    elseif ($link_to == 'single_page'):
                                    elseif ($link_to == 'custom_url'):

                                    endif;


                                    $elementHTML = '<a teamid="'.$team_memberIndex.'" class="'.$element_class.'" href="?teamid='.$post_id.'&teamMember='.$team_memberIndex.'" >'.$elementValue.'</a>';

                                }

                                elseif($element_key == 'content'){

                                    $word_count = isset($popup_layout_items['content']['settings']['word_count']) ? $popup_layout_items['content']['settings']['word_count'] : 0;
                                    $read_more_text = isset($popup_layout_items['content']['settings']['read_more_text']) ? $popup_layout_items['content']['settings']['read_more_text'] : '';


                                    //$media_url	= wp_get_attachment_url( $elementValue );




                                    $elementHTML = wp_trim_words($elementValue, $word_count, '<a href="#" class="read-more">'.$read_more_text.'</a>');

                                }


                                elseif($element_key == 'skill'){


                                    $skillHTML = '';



                                    if(!empty($elementValue)):

                                        $skillHTML .= '<div class="skill-list">';
                                        foreach ($elementValue as $skillData):

                                            $skillData = explode('|', $skillData);
                                            $skillName = isset($skillData[0]) ? $skillData[0] : '';
                                            $skillValue = isset($skillData[1]) ? $skillData[1] : '';


                                            if(!empty($skillValue))
                                                $skillHTML .= '<div class="skill-item"><div style="width: '.$skillValue.'" class="skill-width"><span class="skill-name">'.$skillName.'</span><span class="skill-value">'.$skillValue.'</span></div></div>';


                                        endforeach;
                                        $skillHTML .= '</div>';
                                    endif;



                                    $elementHTML = $skillHTML;

                                }

                                elseif($element_key == 'contacts'){



                                    $contactsHTML = '';

                                    foreach ($elementValue as $contactData):



                                        $type = $contactData['type'];
                                        $value = $contactData['value'];
                                        $label = $contactData['label'];
                                        $icon = $contactData['icon'];

                                        //var_dump($type);

                                        if(!empty($value)):
                                            if($type == 'link'):
                                                $contactsHTML .= '<a href="'.$value.'">'.$icon.'</a>';

                                            elseif ($type == 'email'):
                                                $contactsHTML .= '<a  href="mailto:'.$value.'">'.$icon.'</a>';

                                            elseif ($type == 'phone'):
                                                $contactsHTML .= '<a href="tel:'.$value.'">'.$icon.'</a>';

                                            elseif ($type == 'text'):
                                                $contactsHTML .= '<span>'.$value.'</span>';

                                            elseif ($type == 'skype'):
                                                $contactsHTML .= '<a href="skype:'.$value.'">'.$icon.'</a>';

                                            endif;

                                        endif;




                                    endforeach;

                                    $elementHTML = $contactsHTML;

                                }
                                else{
                                    $elementHTML = $elementValue;
                                }

                            else:

                                $elementHTML = '';

                            endif;



                            $filterArgs= array('elementValue'=>$elementValue,'elementKey'=>$element_key, 'teamId'=>$post_id, 'templateId'=>$template_id);
                            $elementHTML = !empty($elementHTML) ? $elementHTML : '';

                            //var_dump($element_key);

                            $vars['{{'.$element_key.'}}'] = apply_filters('team_parameter_html', $elementHTML, $filterArgs);

                        endforeach;




                    //var_dump($vars);



                    echo strtr($popup_template_html, $vars);



                    ?>

                </div>
            <?php
            endforeach;



        ?>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="<?php echo team_plugin_url.'assets/front/css/owl.carousel.min.css'; ?>" >
    <link rel="stylesheet" href="<?php echo team_plugin_url.'assets/front/css/owl.theme.default.css'; ?>" >
    <link rel="stylesheet" href="<?php echo team_plugin_url.'assets/front/css/style-slider.css'; ?>" >

    <script rel="script" src="<?php echo team_plugin_url.'assets/front/js/owl.carousel.min.js'; ?>"></script>


    <script>
        jQuery(document).ready(function($){

            $(".popup-slider .owl-carousel").owlCarousel({items:1,URLhashListener:true,nav:true,navText:["",""],dots:true});



        });
    </script>



</div>
















<?php

if($grid_type=='slider'):



    ?>
    <link rel="stylesheet" href="<?php echo team_plugin_url.'assets/front/css/owl.carousel.min.css'; ?>" >
    <link rel="stylesheet" href="<?php echo team_plugin_url.'assets/front/css/owl.theme.default.css'; ?>" >
    <link rel="stylesheet" href="<?php echo team_plugin_url.'assets/front/css/style-slider.css'; ?>" >

    <script rel="script" src="<?php echo team_plugin_url.'assets/front/js/owl.carousel.min.js'; ?>"></script>
    <?php

    include team_plugin_dir.'/templates/team-new/scripts.php';

elseif($grid_type=='filterable'):

    ?>
    <link rel="stylesheet" href="<?php echo team_plugin_url.'assets/front/css/style-slider.css'; ?>" >

    <script rel="script" src="<?php echo team_plugin_url.'assets/front/js/jquery.mixitup.min.js'; ?>"></script>
    <script rel="script" src="<?php echo team_plugin_url.'assets/front/js/jquery.mixitup-pagination.js'; ?>"></script>


<script>
    jQuery(function(){

        jQuery("#team-container-<?php echo $post_id; ?>").mixItUp({
            pagination: {
                limit: <?php echo $filterable_post_per_page; ?>,
                prevButtonHTML: "<?php echo $pagination_prev_text; ?>",
                nextButtonHTML: "<?php echo $pagination_next_text; ?>",
            },
            selectors: {
                filter: ".filter"
            },
            <?php
            if(!empty($filterable_default_filter)){

            $filterable_default_filter = ($filterable_default_filter == 'all') ? $filterable_default_filter : '.'.$filterable_default_filter;
            ?>
            load: {
                filter: "<?php echo $filterable_default_filter; ?>"
            },
            <?php
            }
            ?>
            controls: {
                enable: true
            }

        });

    });

</script>


<?php


endif;

?>


<!--    <link rel="stylesheet" href="--><?php //echo team_plugin_url.'assets/frontend/css/style.css'; ?><!--" >-->
<!---->
<!---->
    <script rel="script" src="<?php echo team_plugin_url.'assets/front/js/imagesloaded.pkgd.js'; ?>"></script>
<!--    <script rel="script" src="--><?php //echo team_plugin_url.'assets/frontend/js/scripts.js'; ?><!--"></script>-->

<style type="text/css">

    <?php echo $template_css; ?>
    <?php echo $popup_template_css; ?>

</style>






    <script>





        <?php

        if($masonry_enable=='yes' && $grid_type == 'grid'):
        ?>
        jQuery("#team-container-<?php echo $post_id; ?> .item-list").ready(function($){

            var $container = $('#team-container-<?php echo $post_id; ?> .item-list');

            $container.masonry({
                itemSelector: '.item',
                columnWidth: '.item', //as you wish , you can use numeric
                isAnimated: true,
                isFitWidth: true,
                horizontalOrder: true,
            });


            $container.imagesLoaded().done( function() {
                $container.masonry('layout');
            });



        })
        <?php
        endif;
        ?>

    </script>






<?php

//
include team_plugin_dir.'/templates/team-new/style-css.php';
