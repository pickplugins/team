<?php
/*
* @Author 		ParaTheme
* @Folder	 	Team/Templates
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$post_id = get_the_id();
$team_member_position = get_post_meta( $post_id, 'team_member_position', true );
			
if(!empty($team_member_position)) {
?>
    <div class="team-position">
        <?php echo apply_filters( 'team_filter_team_member_position', $team_member_position ); ?>
    </div>
<?php
}