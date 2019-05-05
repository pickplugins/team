<?php

/*
* @Author 		ParaTheme
* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$post_id = get_the_id();

$team_member_single_skill_sort = get_option( 'team_member_single_skill_sort' );

$team_member_skill = get_post_meta($post_id, 'team_member_skill', true );
$team_items_skill_bg_color = get_post_meta( $post_id, 'team_items_skill_bg_color', true );


	if(!empty($team_member_skill)){
		
		$html_skill = '';
		$html_skill_sort = array();
		
		foreach($team_member_skill as $skill_key=>$skill_info){

			$html_skill_sort_ = '';
			if(!empty($skill_info['value'])){

				$html_skill_sort_.= '<div class="skill">';
				$html_skill_sort_.= $skill_info['name'].'('.$skill_info['value'].')';
				$html_skill_sort_.= '<div style=" background:'.$team_items_skill_bg_color.';width:'.$skill_info['value'].';" class="bars">&nbsp;</div>';
				$html_skill_sort_.= '</div>';

				$html_skill_sort[str_replace('%','',$skill_info['value'])] = $html_skill_sort_;

//				$html_skill.= '<div class="skill">';
//				$html_skill.= $skill_info['name'].'('.$skill_info['value'].')';
//				$html_skill.= '<div style=" background:'.$team_items_skill_bg_color.';width:'.$skill_info['value'].';" class="bars">&nbsp;</div>';
//				$html_skill.= '</div>';

			}

			}





		if($team_member_single_skill_sort=='ASC'){
			ksort($html_skill_sort);
		}
        elseif ($team_member_single_skill_sort=='DESC'){

			krsort($html_skill_sort);
		}


		//var_dump($html_skill_sort);


        if(!empty($html_skill_sort))
		foreach($html_skill_sort as $skill){

			$html_skill.= $skill;

		}



		    $html_skill = apply_filters('team_filter_team_member_skill',$html_skill);

        if(!empty($html_skill)):
	        ?>
            <div class="team-skill"><?php echo $html_skill; ?></div>
	        <?php
        endif;

			

		}

	

		
	
			
