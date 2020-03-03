<?php
if ( ! defined('ABSPATH')) exit; // if direct access 

class class_team_notices{

    public function __construct(){

        add_action('admin_notices', array( $this, 'data_upgrade' ));

    }

    public function data_upgrade(){

        $team_plugin_info = get_option('team_plugin_info');
        $team_settings_upgrade = isset($team_plugin_info['settings_upgrade']) ? $team_plugin_info['settings_upgrade'] : '';

        $actionurl = admin_url().'edit.php?post_type=team&page=upgrade_status';
        $actionurl = wp_nonce_url( $actionurl,  'team_upgrade' );

        $nonce = isset($_REQUEST['_wpnonce']) ? $_REQUEST['_wpnonce'] : '';

        if ( wp_verify_nonce( $nonce, 'team_upgrade' )  ){
            wp_schedule_event(time(), '2minute', 'team_cron_upgrade_settings');

            return;
        }


        if(empty($team_settings_upgrade)){

            $tutorial_link = 'https://www.youtube.com/watch?v=iiH8FjNPGFw';

            ?>
            <div class="update-nag">
                <?php
                echo sprintf(__('Data migration required for team plugin, please <a class="button button-primary" href="%s">click to start</a> migration. watch this <a target="_blank" href="%s">video</a> first.', 'team-pro'), $actionurl, $tutorial_link)
                ?>
            </div>
            <?php


        }

    }

}

new class_team_notices();