<?php	
if ( ! defined('ABSPATH')) exit;  // if direct access

$team_plugin_info = get_option('team_plugin_info');

$team_settings_upgrade = isset($team_plugin_info['settings_upgrade']) ? $team_plugin_info['settings_upgrade'] : '';
$team_members_upgrade = isset($team_plugin_info['team_members_upgrade']) ? $team_plugin_info['team_members_upgrade'] : '';
$team_upgrade = isset($team_plugin_info['team_upgrade']) ? $team_plugin_info['team_upgrade'] : '';

?>
<?php

?>
<div class="wrap">
	<div id="icon-tools" class="icon32"><br></div><h2><?php echo sprintf(__('%s Settings - Update', 'team'), team_plugin_name)?></h2>

    <pre><?php echo var_export($team_plugin_info, true); ?></pre>

    <h3>Team settings upgrade status</h3>

    <?php

    if($team_settings_upgrade){
        ?>
        <p>Completed</p>
        <?php
    }else{
        ?>
        <p>Pending</p>
        <?php
    }

    ?>


    <h3>Team members upgrade status</h3>
    <?php

    $meta_query = array();

    $meta_query[] = array(
        'key' => 'team_upgrade_status',
        'value' => 'done',
        'compare' => '='
    );

    $args = array(
        'post_type'=>'team_member',
        'post_status'=>'any',
        'posts_per_page'=> -1,
        'meta_query'=> $meta_query,

    );

    $wp_query = new WP_Query($args);

    if ( $wp_query->have_posts() ) :
        ?>
        <ul>
            <?php
            while ( $wp_query->have_posts() ) : $wp_query->the_post();

                $team_id = get_the_id();
                $team_title = get_the_title();
                ?>
                <li><?php echo $team_title; ?> - Done!</li>
            <?php

            endwhile;
            ?>
        </ul>
    <?php
    else:
        ?>
        <p>Pending</p>
    <?php
    endif;

    ?>




    <h3>Team upgrade status</h3>
    <?php

    $meta_query = array();

    $meta_query[] = array(
        'key' => 'team_upgrade_status',
        'value' => 'done',
        'compare' => '='
    );

    $args = array(
        'post_type'=>'team',
        'post_status'=>'any',
        'posts_per_page'=> -1,
        'meta_query'=> $meta_query,

    );

    $wp_query = new WP_Query($args);

    if ( $wp_query->have_posts() ) :
        ?>
        <ul>
        <?php
        while ( $wp_query->have_posts() ) : $wp_query->the_post();

            $team_id = get_the_id();
            $team_title = get_the_title();
            ?>
            <li><?php echo $team_title; ?> - Done</li>
            <?php

        endwhile;
        ?>
        </ul>
        <?php

    else:
        ?>
        <p>Pending</p>
        <?php
    endif;

    ?>
















</div>