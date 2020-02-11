<?php
/*
Plugin Name: Team
Plugin URI: http://www.pickplugins.com/item/team-responsive-meet-the-team-grid-for-wordpress/?ref=dashboard
Description: Fully responsive and mobile ready meet the team showcase plugin for wordpress.
Version: 1.22.0
Author: pickplugins
Author URI: http://pickplugins.com
Text Domain: team
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class Team{
	
	public function __construct(){
	
        define('team_plugin_url', plugins_url('/', __FILE__) );
        define('team_plugin_dir', plugin_dir_path( __FILE__ ) );
        define('team_wp_url', 'http://wordpress.org/plugins/team/' );
        define('team_wp_reviews', 'https://wordpress.org/plugins/team/#reviews' );
        define('team_pro_url', 'https://www.pickplugins.com/item/team-responsive-meet-the-team-grid-for-wordpress/?ref=dashboard' );
        define('team_demo_url', 'http://www.pickplugins.com/demo/team/?ref=dashboard' );
        define('team_conatct_url', 'http://www.pickplugins.com/contact/?ref=dashboard' );
        define('team_qa_url', 'http://www.pickplugins.com/support/?ref=dashboard' );
        define('team_plugin_name', 'Team' );
        define('team_plugin_version', '1.22.0' );
        define('team_customer_type', 'free' );	 // pro & free
        define('team_tutorial_doc_url', 'http://pickplugins.com/docs/documentation/team/' );

        include( 'includes/functions-data-upgrade.php' );

        include( 'includes/class-post-meta-team.php' );
        include( 'includes/class-post-meta-team-hook.php' );

        include( 'includes/class-post-types.php' );
        include( 'includes/class-post-meta.php' );
        include( 'includes/class-settings.php' );
        include( 'includes/class-functions.php' );
        include( 'includes/class-shortcodes.php' );

        include( 'includes/class-settings-tabs.php' );
        include( 'includes/functions-settings-hook.php' );
        include( 'includes/functions-layout-hook.php' );

        include( 'includes/class-post-meta-team-layout.php' );
        include( 'includes/class-post-meta-team-layout-hook.php' );
        include( 'includes/class-post-meta-team-member.php' );
        include( 'includes/class-post-meta-team-member-hook.php' );


        include_once team_plugin_dir.'/templates/team-showcase/team-showcase-hook.php';

    
        include( 'templates/single-team/single-team_member-hook.php' );
        include( 'includes/functions.php' );

        add_action( 'wp_enqueue_scripts', array( $this, 'team_front_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'team_admin_scripts' ) );
        add_action( 'plugins_loaded', array( $this, '_textdomain' ));
        add_filter('widget_text', 'do_shortcode');
        register_activation_hook( __FILE__, array( $this, '_activation' ) );
        register_deactivation_hook(__FILE__, array( $this, '_deactivation' ));
        add_filter( 'cron_schedules', array( $this, 'cron_recurrence_interval' ) );


    }
		
		
	public function _textdomain() {
	  load_plugin_textdomain( 'team', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
	}

		
	public function _activation(){
		
		// Update social fields in option
		team_update_team_member_social_field();
		
		// Reset permalink
		$team_class_post_types= new team_class_post_types();
		$team_class_post_types->_posttype_team_member();
		flush_rewrite_rules();

        wp_schedule_event(time(), '5minute', 'team_cron_upgrade_team_members');
        wp_schedule_event(time(), '5minute', 'team_cron_upgrade_team');


        do_action( 'team_action_install' );
		
		}		


	public function team_uninstall(){
		
		do_action( 'team_action_uninstall' );
		}		
		
	public function _deactivation(){

        wp_clear_scheduled_hook('team_cron_upgrade_team_members');
        wp_clear_scheduled_hook('team_cron_upgrade_team');

        do_action( 'team_action_deactivation' );
		}




    function cron_recurrence_interval( $schedules ){

        $schedules['5minute'] = array(
            'interval'  => 300,
            'display'   => __( '5 Minute', 'textdomain' )
        );




        return $schedules;
    }







    public function team_front_scripts(){
			
		wp_enqueue_script('jquery');
		wp_enqueue_script('team_front_js', plugins_url( '/assets/front/js/scripts.js' , __FILE__ ) , array( 'jquery' ));	
		wp_localize_script('team_front_js', 'team_ajax', array( 'team_ajaxurl' => admin_url( 'admin-ajax.php')));

		wp_enqueue_style('team-style', plugins_url( 'assets/front/css/style.css', __FILE__ ));	
		wp_enqueue_style('single-team-member', plugins_url( 'assets/front/css/single-team-member.css', __FILE__ ));			

		wp_enqueue_style('team-style.skins', plugins_url( 'assets/global/css/style.skins.css', __FILE__ ));			
		wp_enqueue_style('team-style.layout', plugins_url( 'assets/global/css/style.layout.css', __FILE__ ));				

		wp_enqueue_script('masonry.pkgd.min', plugins_url( '/assets/front/js/masonry.pkgd.min.js' , __FILE__ ) , array( 'jquery' ));


		do_action('team_action_front_scripts');
		}		
		
	public function team_admin_scripts(){
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
		
		wp_enqueue_script('team_admin_js', plugins_url( '/assets/admin/js/scripts.js' , __FILE__ ) , array( 'jquery' ));			
		wp_localize_script('team_admin_js', 'team_admin_ajax', array( 'team_admin_ajaxurl' => admin_url( 'admin-ajax.php')));
		
		wp_localize_script( 'team_admin_js', 'L10n_team', array(
							'confirm_text' => __( 'Confirm', 'team' ),
							'done_text' => __( 'Done', 'team' ),
							
							));
		
		
		wp_enqueue_style('team_admin_style', plugins_url( 'assets/admin/css/style.css', __FILE__ ));
		//wp_enqueue_style('font-awesome.min', plugins_url( 'assets/global/css/font-awesome.min.css', __FILE__ ));

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'color-picker', plugins_url('/assets/admin/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), true, true );
		
		
		//ParaAdmin
		wp_enqueue_style('ParaAdmin', plugins_url( 'assets/admin/ParaAdmin/css/ParaAdmin.css', __FILE__ ));
		wp_enqueue_script('ParaAdmin', plugins_url( 'assets/admin/ParaAdmin/js/ParaAdmin.js' , __FILE__ ) , array( 'jquery' ));

        wp_register_script('settings-tabs', team_plugin_url.'assets/admin/js/settings-tabs.js', array( 'jquery' ));
        wp_register_style('settings-tabs', team_plugin_url.'assets/admin/css/settings-tabs.css');
        wp_register_style('font-awesome-5', team_plugin_url.'assets/admin/css/fontawesome.css');

        $cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));

        wp_localize_script('jquery', 'cm_settings', $cm_settings);

        wp_enqueue_script('wp-theme-plugin-editor');
        //wp_enqueue_style('wp-codemirror');

		do_action('team_action_admin_scripts');
		}		
		





	}
	
	new Team();
	

	
	