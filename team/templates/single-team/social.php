<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$post_id = get_the_id();

$team_member_social_field = get_option( 'team_member_social_field' );


$team_social_icon_style = get_post_meta( $post_id, 'team_social_icon_style', true );
$team_member_social_links = get_post_meta( $post_id, 'team_member_social_links', true );
$team_items_social_icon_type = 'image_icon';
$team_items_social_icon_width = get_post_meta( $post_id, 'team_items_social_icon_width', true );
$team_items_social_icon_height = get_post_meta( $post_id, 'team_items_social_icon_height', true );




if(empty($team_member_social_field))
{
	$team_member_social_field = array("skype"=>"skype","email"=>"email","website"=>"website", "facebook"=>"facebook","twitter"=>"twitter","googleplus"=>"googleplus","pinterest"=>"pinterest");

}

$html_social = '';

?>

    <?php

    foreach ($team_member_social_field as $field_key=>$field_info) {

        $visibility = isset($field_info['visibility']) ? $field_info['visibility'] : '';
        $name = isset($field_info['name']) ? $field_info['name'] : '';

        if(!empty($field_key) && !empty($team_member_social_links[$field_key]) && !empty($field_info['visibility'])){

                if(!empty($team_member_social_field[$field_key]['icon']))
                    {
                    $icon_bg = 'style="background-image:url('.$team_member_social_field[$field_key]['icon'].')"';
                    }
                else
                    {
                    $icon_bg = '';
                    }


            if($team_items_social_icon_type=='image_icon'):


                if($field_key == 'website'){

                        $html_social.= '<span '.$icon_bg.' class="website">
                            <a target="_blank" href="'.$team_member_social_links[$field_key].'"></a>
                        </span>';
                    }
                elseif($field_key == 'email'){

                        $html_social.= '<span '.$icon_bg.' class="email">
                            <a href="mailto:'.$team_member_social_links[$field_key].'"></a>
                        </span>';
                    }

                elseif($field_key == 'skype'){

                        $html_social.= '<span '.$icon_bg.' class="skype">
                            <a  title="'.$field_key.'" href="skype:'.$team_member_social_links[$field_key].'"></a>
                        </span>';
                    }

                elseif($field_key == 'mobile'){

                        $html_social.= '<span '.$icon_bg.' class="mobile">
                            <a  title="'.$field_key.'" href="tel:'.$team_member_social_links[$field_key].'"></a>
                        </span>';
                    }


                elseif($field_key == 'phone'){

                        $html_social.= '<span '.$icon_bg.' class="mobile">
                            <a  title="'.$field_key.'" href="tel:'.$team_member_social_links[$field_key].'"></a>
                        </span>';
                    }


                else{
                        $html_social.= '<span '.$icon_bg.' class="'.$field_key.'" >
                            <a target="_blank" href="'.$team_member_social_links[$field_key].'"> </a>
                        </span>';
                    }

            elseif($team_items_social_icon_type=='text_link'):

                if(!empty($team_member_social_field[$field_key]['icon'])){

                    $icon_link_ = $team_member_social_field[$field_key]['icon'];

                    }



                if($field_key == 'website'){

                        $html_social.= '<span  class="text-website">
                            <a target="_blank" href="'.$team_member_social_links[$field_key].'">'.$name.'</a>
                        </span>';
                    }
                elseif($field_key == 'email'){

                        $html_social.= '<span  class="text-email">
                            <a href="mailto:'.$team_member_social_links[$field_key].'">'.$name.'</a>
                        </span>';
                    }

                elseif($field_key == 'skype'){

                        $html_social.= '<span  class="text-skype">
                            <a  title="'.$field_key.'" href="skype:'.$team_member_social_links[$field_key].'">'.$name.'</a>
                        </span>';
                    }

                elseif($field_key == 'mobile'){

                        $html_social.= '<span  class="text-mobile">
                            <a  title="'.$field_key.'" href="tel:'.$team_member_social_links[$field_key].'">'.$name.'</a>
                        </span>';
                    }

                elseif($field_key == 'phone'){

                        $html_social.= '<span  class="text-mobile">
                            <a  title="'.$field_key.'" href="tel:'.$team_member_social_links[$field_key].'">'.$name.'</a>
                        </span>';
                    }

                else{
                        $html_social.= '<span  class="text-'.$field_key.'" >
                            <a target="_blank" href="'.$team_member_social_links[$field_key].'">'.$name.'</a>
                        </span>';
                    }



            endif;



            }
    }


    if(!empty($html_social)):


    ?>
    <div class="team-social <?php echo $team_items_social_icon_type; ?> <?php echo $team_social_icon_style; ?>" >

	    <?php
	    echo apply_filters( 'team_filter_team_member_social', $html_social );
	    ?>

    </div>


<?php
    endif;
			