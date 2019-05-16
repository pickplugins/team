<?php
if ( ! defined('ABSPATH')) exit;  // if direct access



//include team_plugin_dir.'/templates/team-new/variables.php';

//var_dump($teamMember);

$template_data = get_post_meta($template_id, 'team_template_options', true);


$template_html = isset($template_data['template_html']) ? ($template_data['template_html']) : '';
$template_css = isset($template_data['template_css']) ? ($template_data['template_css']) : '';

$layout_items = isset($template_data['layout_items']) ? ($template_data['layout_items']) : '';
$single_team_layout_items = isset($template_data['single_team_layout_items']) ? ($template_data['single_team_layout_items']) : '';

$single_team_template_html = isset($template_data['single_team_template_html']) ? ($template_data['single_team_template_html']) : '';
$single_team_template_css = isset($template_data['single_team_template_css']) ? ($template_data['single_team_template_css']) : '';
?>

<!--<pre>--><?php ////echo var_export($team_members, true); ?><!--</pre>-->

<div class="team-single" id="team-container-<?php echo $post_id; ?>">
    <div class="back-to-team"><a href="<?php echo get_permalink(get_the_id()); ?>">Back to Team</a> </div>

    <div class="team-single-wrap">
        <?php

        if(!empty($team_members))
            foreach ($team_members as $team_memberIndex => $team_member):

                //var_dump($team_memberIndex);

                if($teamMember != $team_memberIndex){

                    continue;

                }

                $class = $team_member['class'];

                $vars = array();
                $elementHTML = '';

                $vars = apply_filters('team_custom_parameter', $vars);
                ?>

                <div class="team-single-box team-single-box-<?php  echo $team_memberIndex; ?> ">


                    <?php


                    if(!empty($team_member))
                        foreach ($team_member as $element_key => $elementValue):

                            if(!empty($elementValue)):

                                if($element_key == 'thumbnail'){
                                    $media_url	= wp_get_attachment_url( $elementValue );
                                    $elementHTML = '<img alt="'.$element_key.'" src="'.$media_url.'">';

                                }
                                elseif($element_key == 'name'){

                                    $link_to = isset($single_team_layout_items['name']['settings']['link_to']) ? $single_team_layout_items['name']['settings']['link_to'] : 'none';
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

                                    $word_count = isset($single_team_layout_items['content']['settings']['word_count']) ? $single_team_layout_items['content']['settings']['word_count'] : 9999999;
                                    $read_more_text = isset($single_team_layout_items['content']['settings']['read_more_text']) ? $single_team_layout_items['content']['settings']['read_more_text'] : '';


                                    //$media_url	= wp_get_attachment_url( $elementValue );


                                    //var_dump($elementValue);


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



                    echo strtr($single_team_template_html, $vars);



                    ?>

                </div>
            <?php
            endforeach;



        ?>

    </div>

</div>

















<?php

//
include team_plugin_dir.'/templates/team-new/style-css.php';











