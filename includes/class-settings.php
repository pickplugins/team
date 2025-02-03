<?php
if (!defined('ABSPATH')) exit;  // if direct access 	


class team_class_settings
{


    public function __construct()
    {

        add_action('admin_menu', array($this, 'admin_menu'), 12);
    }


    public function admin_menu()
    {

        add_submenu_page('edit.php?post_type=team', __('Settings', 'team'), __('Settings', 'team'), 'manage_options', 'team-settings', array($this, 'settings'));
        add_submenu_page('edit.php?post_type=team', __('team Builder', 'team'), __('Builder', 'team'), 'manage_options', 'team-builder', array($this, 'builder'));
    }

    public function settings()
    {

        //include( 'menu/settings-old.php' );
        include('menu/settings.php');
    }

    public function builder()
    {
        include('menu/builder.php');
    }
}


new team_class_settings();
