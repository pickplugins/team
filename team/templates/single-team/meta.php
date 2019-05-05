<?php
/*
* @Author 		ParaTheme
* @Folder	 	Team/Templates
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

$post_id = get_the_id();


$team_member_meta_fields = get_option( 'team_member_meta_fields' );

?>

    <?php

    ob_start();

    foreach ($team_member_meta_fields as $meta){

        $name = $meta['name'];
        $meta_key = $meta['meta_key'];
        $meta_key_value = get_post_meta( $post_id, $meta_key, true );

        if(!empty($meta_key_value)):


        ?>
        <div class="meta-item">
            <span class="meta-name"><?php echo $name; ?></span>:
            <span class="meta-value"><?php echo $meta_key_value; ?></span>
        </div>
        <?php
        endif;
    }

    $meta_html = ob_get_clean();

    if(!empty($meta_html)):

    ?>
    <div class="single-team-meta">
        <?php

        echo apply_filters('team_filter_team_member_meta',$meta_html);

        ?>
    </div>

    <?php
    endif;