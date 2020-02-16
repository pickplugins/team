<?php
/*
Plugin Name: Team Showcase by PickPlugins
Plugin URI: http://www.pickplugins.com/item/team-responsive-meet-the-team-grid-for-wordpress/?ref=dashboard
Description: Fully responsive and mobile ready meet the team showcase plugin for wordpress.
Version: 1.22.0
Author: PickPlugins
Author URI: http://pickplugins.com
Text Domain: team
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


*/

if ( ! defined('ABSPATH')) exit;  // if direct access 

if( ! class_exists( 'Team' ) ) {
    class Team{

        public function __construct(){

            define('team_plugin_url', plugins_url('/', __FILE__));
            define('team_plugin_dir', plugin_dir_path(__FILE__));
            define('team_plugin_name', 'Team');
            define('team_plugin_version', '1.22.0');

            include('includes/functions-data-upgrade.php');

            include('includes/class-post-meta-team.php');
            include('includes/class-post-meta-team-hook.php');

            include('includes/class-post-types.php');
            include('includes/class-settings.php');
            include('includes/class-functions.php');
            include('includes/class-shortcodes.php');

            include('includes/class-settings-tabs.php');
            include('includes/functions-settings-hook.php');
            include('includes/functions-layout-hook.php');

            include('includes/class-post-meta-team-layout.php');
            include('includes/class-post-meta-team-layout-hook.php');
            include('includes/class-post-meta-team-member.php');
            include('includes/class-post-meta-team-member-hook.php');
            include('includes/class-admin-notices.php');


            include_once team_plugin_dir . '/templates/team-showcase/team-showcase-hook.php';
            include_once team_plugin_dir . '/templates/single-team-member/team-member-hook.php';

            include('includes/functions-layout-element.php');

            include('includes/functions.php');

            add_action('wp_enqueue_scripts', array($this, '_front_scripts'));
            add_action('admin_enqueue_scripts', array($this, '_admin_scripts'));
            add_action('plugins_loaded', array($this, '_textdomain'));
            add_filter('widget_text', 'do_shortcode');
            register_activation_hook(__FILE__, array($this, '_activation'));
            register_deactivation_hook(__FILE__, array($this, '_deactivation'));
            add_filter('cron_schedules', array($this, 'cron_recurrence_interval'));


        }


        public function _textdomain(){

            $locale = apply_filters('plugin_locale', get_locale(), 'team');
            load_textdomain('team', WP_LANG_DIR . '/team/team-' . $locale . '.mo');

            load_plugin_textdomain('team', false, plugin_basename(dirname(__FILE__)) . '/languages/');
        }


        public function _activation(){

            // Reset permalink
            $team_class_post_types = new team_class_post_types();
            $team_class_post_types->_posttype_team_member();
            flush_rewrite_rules();


            do_action('team_activation');

        }


        public function team_uninstall(){

            do_action('team_uninstall');
        }

        public function _deactivation(){

            wp_clear_scheduled_hook('team_cron_upgrade_settings');
            wp_clear_scheduled_hook('team_cron_upgrade_team_members');
            wp_clear_scheduled_hook('team_cron_upgrade_team');

            do_action('team_deactivation');
        }


        function cron_recurrence_interval($schedules){

            $schedules['2minute'] = array(
                'interval' => 120,
                'display' => __('2 Minute', 'team')
            );

            $schedules['5minute'] = array(
                'interval' => 300,
                'display' => __('5 Minute', 'team')
            );


            return $schedules;
        }


        public function _front_scripts(){

            wp_enqueue_script('jquery');

            wp_register_style('single-team-member', plugins_url('assets/front/css/single-team-member.css', __FILE__));
            wp_register_script('masonry', plugins_url('/assets/front/js/masonry.js', __FILE__), array('jquery'));
            wp_register_script('imagesloaded', plugins_url('/assets/front/js/imagesloaded.js', __FILE__), array('jquery'));
            wp_register_style('font-awesome-5', team_plugin_url . 'assets/admin/css/fontawesome.css');

            do_action('team_front_scripts');
        }

        public function _admin_scripts(){

            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery-ui-sortable');



            wp_enqueue_script('wp-color-picker');
            wp_enqueue_style('wp-color-picker');

            wp_register_script('settings-tabs', team_plugin_url . 'assets/admin/js/settings-tabs.js', array('jquery'));
            wp_register_style('settings-tabs', team_plugin_url . 'assets/admin/css/settings-tabs.css');
            wp_register_style('font-awesome-5', team_plugin_url . 'assets/admin/css/fontawesome.css');

            $cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));

            wp_localize_script('jquery', 'cm_settings', $cm_settings);

            wp_enqueue_script('wp-theme-plugin-editor');
            //wp_enqueue_style('wp-codemirror');

            do_action('team_admin_scripts');
        }

    }
}
	

new Team();
	

	
	