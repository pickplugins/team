<?php
/*
Plugin Name: Team Showcase by PickPlugins
Plugin URI: https://pickplugins.com/team/
Description: Fully responsive and mobile ready meet the team showcase plugin for wordpress.
Version: 1.22.26
Author: PickPlugins
Author URI: http://pickplugins.com
Text Domain: team
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


*/

if (!defined('ABSPATH')) exit;  // if direct access 

if (!class_exists('team')) {
    class Team
    {

        public function __construct()
        {

            define('team_plugin_url', plugins_url('/', __FILE__));
            define('team_plugin_dir', plugin_dir_path(__FILE__));
            define('team_plugin_name', 'Team');
            define('team_plugin_version', '1.22.26');


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
            include('includes/class-settings-tabs-reviews.php');


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



            //            $args = array(
            //                'title' => 'Hope you enjoy <b>Team Showcase</b> plugin ',
            //                'option' => 'team_plugin_info',
            //                'review_link' => 'https://wordpress.org/support/plugin/team/reviews/#new-post',
            //                'support_link' => 'https://www.pickplugins.com/forum/',
            //                'documentation_link' => 'https://www.pickplugins.com/documentation/team/',
            //                'tutorials_link' => 'https://www.youtube.com/watch?v=SOe0D-Og3nQ&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy',
            //            );
            //
            //            new settings_tabs_reviews($args);


        }


        public function _textdomain()
        {

            $locale = apply_filters('plugin_locale', get_locale(), 'team');
            load_textdomain('team', WP_LANG_DIR . '/team/team-' . $locale . '.mo');

            load_plugin_textdomain('team', false, plugin_basename(dirname(__FILE__)) . '/languages/');
        }


        public function _activation()
        {

            // Reset permalink
            $team_class_post_types = new team_class_post_types();
            $team_class_post_types->_posttype_team_member();
            $team_class_post_types->_posttype_team();

            flush_rewrite_rules();

            $xml_source = team_plugin_url . '/sample-data/team-layouts.json';
            team_import_xml_layouts($xml_source);

            do_action('team_activation');
        }


        public function team_uninstall()
        {

            do_action('team_uninstall');
        }

        public function _deactivation()
        {

            wp_clear_scheduled_hook('team_cron_upgrade_settings');
            wp_clear_scheduled_hook('team_cron_upgrade_team_members');
            wp_clear_scheduled_hook('team_cron_upgrade_team');

            do_action('team_deactivation');
        }


        function cron_recurrence_interval($schedules)
        {

            $schedules['1minute'] = array(
                'interval' => 40,
                'display' => __('1 Minute', 'team')
            );



            return $schedules;
        }


        public function _front_scripts()
        {

            wp_enqueue_script('jquery');

            wp_register_script('masonry', plugins_url('/assets/front/js/masonry.js', __FILE__), array('jquery'));
            wp_register_script('imagesloaded', plugins_url('/assets/front/js/imagesloaded.js', __FILE__), array('jquery'));
            wp_register_style('font-awesome-5', team_plugin_url . 'assets/admin/css/fontawesome.css');

            do_action('team_front_scripts');
        }

        public function _admin_scripts()
        {
            $screen = get_current_screen();

            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery-ui-sortable');

            wp_enqueue_script('team_scripts', team_plugin_url . 'assets/admin/js/scripts.js', array('jquery'));
            //wp_localize_script('team_scripts', 'team_ajax', array('team_ajaxurl' => admin_url('admin-ajax.php')));

            wp_localize_script(
                'team_scripts',
                'team_ajax',
                array(
                    'team_ajaxurl' => admin_url('admin-ajax.php'),
                    'ajax_nonce' => wp_create_nonce('team_ajax_nonce'),
                )
            );



            //wp_enqueue_script('wp-color-picker');
            //wp_enqueue_style('wp-color-picker');

            wp_register_script('settings-tabs', team_plugin_url . 'assets/settings-tabs/settings-tabs.js', array('jquery'));
            wp_register_style('settings-tabs', team_plugin_url . 'assets/settings-tabs/settings-tabs.css');
            wp_register_style('font-awesome-5', team_plugin_url . 'assets/admin/css/fontawesome.css');

            wp_register_script('jquery.lazy', team_plugin_url . 'assets/admin/js/jquery.lazy.js', array('jquery'));
            wp_enqueue_script('jquery.lazy');

            //wp_enqueue_script( 'team_scripts' );


            //$cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));

            //wp_localize_script('jquery', 'cm_settings', $cm_settings);

            //wp_enqueue_script('wp-theme-plugin-editor');
            //wp_enqueue_style('wp-codemirror');


            if ($screen->id == 'team_member' || $screen->id == 'team'  || $screen->id == 'team_layout') {


                $settings_tabs_field = new settings_tabs_field();
                $settings_tabs_field->admin_scripts();
            }







            do_action('team_admin_scripts');
        }
    }
}


new Team();
