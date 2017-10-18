<?php	

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	







	$class_team_functions = new class_team_functions();
	$default_social_field = $class_team_functions->team_member_social_field();

?>


<div class="wrap">

	<div id="icon-tools" class="icon32"><br></div><?php echo "<h2>".__(team_plugin_name.' Settings', 'team')."</h2>";?>

        <div class="para-settings team-settings">

            <ul class="tab-nav">
                <li nav="1" class="nav1 active">Help & Support</li>

            </ul> <!-- tab-nav end -->
            <ul class="box">


                <li style="display: block;" class="box1 tab-box active">

                    <div class="option-box">
                        <p class="option-title">Plugin info ?</p>
                        <p class="option-info">
                        <?php

                        if(team_customer_type=="free")
                            {

                                echo 'You are using <strong> '.team_customer_type.' version  '.team_plugin_version.'</strong> of <strong>'.team_plugin_name.'</strong>, To get more feature you could try our premium version. ';
                                echo '<br /><a href="'.team_pro_url.'">'.team_pro_url.'</a>';

                            }
                        else
                            {

                                echo 'Thanks for using <strong> premium version  '.team_plugin_version.'</strong> of <strong>'.team_plugin_name.'</strong> ';


                            }

                         ?>


                        </p>

                    </div>

                    <div class="option-box">
                        <p class="option-title">Need Help ?</p>
                        <p class="option-info">Feel free to contact with any issue for this plugin, Ask any question via forum <a href="<?php echo team_qa_url; ?>"><?php echo team_qa_url; ?></a> <strong style="color:#139b50;">(free)</strong><br /> please read <strong>documentation</strong> here <a href="<?php echo team_tutorial_doc_url; ?>"><?php echo team_tutorial_doc_url; ?></a>

                        </p>

                    </div>

                    <div class="option-box">
                        <p class="option-title">Submit Reviews...</p>
                        <p class="option-info">We are working hard to build some awesome plugins for you and spend thousand hour for plugins. we wish your three(3) minute by submitting five star reviews at wordpress.org. if you have any issue please submit at forum.</p>
                        <img class="team-pro-pricing" src="<?php echo team_plugin_url."assets/admin/css/five-star.png";?>" /><br />
                        <a target="_blank" href="<?php echo team_wp_reviews; ?>">
                            <?php echo team_wp_reviews; ?>
                        </a>

                    </div>


                    <div class="option-box">
                        <p class="option-title"><?php _e('FAQ','team'); ?></p>
                        <p class="option-info"></p>


                        <div class="faq">
                        <?php
                        $class_team_functions = new class_team_functions();
                        $faq =  $class_team_functions->faq();

                        echo '<ul>';
                        foreach($faq as $faq_data){
                            echo '<li>';
                            $title = $faq_data['title'];
                            $items = $faq_data['items'];

                            echo '<span class="group-title">'.$title.'</span>';

                                echo '<ul>';
                                foreach($items as $item){

                                        echo '<li class="item">';
                                        echo '<a href="'.$item['answer_url'].'"><i class="fa fa-question-circle-o"></i> '.$item['question'].'</a>';


                                        echo '</li>';

                                }
                                echo '</ul>';

                            echo '</li>';
                            }

                            echo '</ul>';
                        ?>

                        </div>

                    </div>



                </li>
            </ul>





        </div>



</div>
