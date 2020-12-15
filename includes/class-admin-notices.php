<?php
if ( ! defined('ABSPATH')) exit; // if direct access 

class class_team_notices{

    public function __construct(){

        add_action('admin_notices', array( $this, 'data_upgrade' ));
        add_action('admin_notices', array( $this, 'import_layouts' ));

    }

    public function import_layouts(){

        $team_plugin_info = get_option('team_plugin_info');
        $import_layouts = isset($team_plugin_info['import_layouts']) ? $team_plugin_info['import_layouts'] : '';

        $team_layout_count = wp_count_posts('team_layout');

        //delete_option('team_plugin_info');

      //var_dump($team_layout_count->publish);

        ob_start();

        //if( $team_layout_count->publish == 0):
            ?>
            <div class="updated notice">
                <p>
                  <?php
                  echo sprintf(__('You haven\'t created any layouts, please create first layout or import free layouts, please <a href="%s">click here</a> to go import page', 'team'), admin_url().'edit.php?post_type=team&page=settings&tab=help_support')
                  ?>
                </p>

            </div>
        <?php
        //endif;


        echo ob_get_clean();
    }


    public function data_upgrade(){

        $team_plugin_info = get_option('team_plugin_info');
        $team_settings_upgrade = isset($team_plugin_info['settings_upgrade']) ? $team_plugin_info['settings_upgrade'] : '';

        $actionurl = admin_url().'edit.php?post_type=team&page=upgrade_status';
        $actionurl = wp_nonce_url( $actionurl,  'team_upgrade' );

        $nonce = isset($_REQUEST['_wpnonce']) ? $_REQUEST['_wpnonce'] : '';

        if ( wp_verify_nonce( $nonce, 'team_upgrade' )  ){
            $team_plugin_info['team_upgrade'] = 'processing';
            update_option('team_plugin_info', $team_plugin_info);
            wp_schedule_event(time(), '1minute', 'team_cron_upgrade_settings');

            return;
        }


        if(empty($team_settings_upgrade)){

            $tutorial_link = 'https://www.youtube.com/watch?v=iiH8FjNPGFw';

            ?>
            <div class="updated notice">
                <p>
                  <?php
                  echo sprintf(__('Data migration required for team plugin, please <a class="button button-primary" href="%s">click to start</a> migration. watch this <a target="_blank" href="%s">video</a> first.', 'team'), $actionurl, $tutorial_link)
                  ?>
                </p>

            </div>
            <?php


        }

    }

}

new class_team_notices();