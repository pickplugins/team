<?php

/*
* @Author 		ParaTheme
* @Folder	 	Team/Includes
* @version     3.0.5

* Copyright: 	2015 ParaTheme
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 	

class team_class_post_types{
	
	
	public function __construct(){
		add_action( 'init', array( $this, '_posttype_team_member' ), 0 );
		add_action( 'init', array( $this, '_posttype_team' ), 0);
        add_action( 'init', array( $this, '_posttype_team_layout' ), 0);


    }
	
	
	public function _posttype_team_member(){
			
		if ( post_type_exists( "team_member" ) )
		return;
	 
		$singular  = __( 'Team Member', 'team' );
		$plural    = __( 'Team Members', 'team' );
	 
	 	$team_settings = get_option('team_settings');
        $team_member_slug = !empty($team_settings['team_member_slug']) ? $team_settings['team_member_slug'] : 'team_member';
        $is_public = isset($team_settings['team_member']['is_public']) ? $team_settings['team_member']['is_public'] : '';

	 
		register_post_type( "team_member",
			apply_filters( "team_posttype_team_member", array(
				'labels' => array(
					'name' 					=> $plural,
					'singular_name' 		=> $singular,
					'menu_name'             => __( 'Team Member', 'team' ),
					'all_items'             => sprintf( __( 'All %s', 'team' ), $plural ),
					'add_new' 				=> __( 'Add New', 'team' ),
					'add_new_item' 			=> sprintf( __( 'Add %s', 'team' ), $singular ),
					'edit' 					=> __( 'Edit', 'team' ),
					'edit_item' 			=> sprintf( __( 'Edit %s', 'team' ), $singular ),
					'new_item' 				=> sprintf( __( 'New %s', 'team' ), $singular ),
					'view' 					=> sprintf( __( 'View %s', 'team' ), $singular ),
					'view_item' 			=> sprintf( __( 'View %s', 'team' ), $singular ),
					'search_items' 			=> sprintf( __( 'Search %s', 'team' ), $plural ),
					'not_found' 			=> sprintf( __( 'No %s found', 'team' ), $plural ),
					'not_found_in_trash' 	=> sprintf( __( 'No %s found in trash', 'team' ), $plural ),
					'parent' 				=> sprintf( __( 'Parent %s', 'team' ), $singular )
				),
				'description' => sprintf( __( 'This is where you can create and manage %s.', 'team' ), $plural ),
				'public' 				=> true,
				'show_ui' 				=> true,
				'capability_type' 		=> 'post',
				'map_meta_cap'          => true,
				'publicly_queryable' 	=> ($is_public =='yes') ? true: false,
				'exclude_from_search' 	=> false,
				'hierarchical' 			=> false,
				'rewrite' 				=> array( 'slug' => $team_member_slug ),
				'query_var' 			=> true,
				'supports' 				=> array( 'title','editor','custom-fields', 'page-attributes', 'thumbnail' ),
				'show_in_nav_menus' 	=> false,
				//'show_in_menu' 	=> 'edit.php?post_type=team',	
				'menu_icon' => 'dashicons-businessman',

			) )
		); 
	 
			$singular  = __( 'Team Group', 'team' );
			$plural    = __( 'Team Groups', 'team' );
	 
			register_taxonomy( "team_group",
				apply_filters( 'team_taxonomy_team_group_type', array( 'team_member' ) ),
	       	 	apply_filters( 'team_taxonomy_team_group_args', array(
		            'hierarchical' 			=> true,
		            'show_admin_column' 	=> true,					
		            'update_count_callback' => '_update_post_term_count',
		            'label' 				=> $plural,
		            'labels' => array(
						'name'              => $plural,
						'singular_name'     => $singular,
						'menu_name'         => ucwords( $plural ),
						'search_items'      => sprintf( __( 'Search %s', 'team' ), $plural ),
						'all_items'         => sprintf( __( 'All %s', 'team' ), $plural ),
						'parent_item'       => sprintf( __( 'Parent %s', 'team' ), $singular ),
						'parent_item_colon' => sprintf( __( 'Parent %s:', 'team' ), $singular ),
						'edit_item'         => sprintf( __( 'Edit %s', 'team' ), $singular ),
						'update_item'       => sprintf( __( 'Update %s', 'team' ), $singular ),
						'add_new_item'      => sprintf( __( 'Add New %s', 'team' ), $singular ),
						'new_item_name'     => sprintf( __( 'New %s Name', 'team' ),  $singular )
	            	),
		            'show_ui' 				=> true,
		            'public' 	     		=> true,
				    'rewrite' => array(
						'slug' => 'team_group', // This controls the base slug that will display before each term
						'with_front' => false, // Don't display the category base before "/locations/"
						'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
				),
		        ) )
		    );
	 

		

	}



	public function _posttype_team(){
		if ( post_type_exists( "team" ) )
		return;

		$singular  = __( 'Team', 'team' );
		$plural    = __( 'Team', 'team' );
	 
	 
		register_post_type( "team",
			apply_filters( "team_posttype_team", array(
				'labels' => array(
					'name' 					=> $plural,
					'singular_name' 		=> $singular,
					'menu_name'             => __( $singular, 'team' ),
					'all_items'             => sprintf( __( 'All %s', 'team' ), $plural ),
					'add_new' 				=> __( 'Add New', 'team' ),
					'add_new_item' 			=> sprintf( __( 'Add %s', 'team' ), $singular ),
					'edit' 					=> __( 'Edit', 'team' ),
					'edit_item' 			=> sprintf( __( 'Edit %s', 'team' ), $singular ),
					'new_item' 				=> sprintf( __( 'New %s', 'team' ), $singular ),
					'view' 					=> sprintf( __( 'View %s', 'team' ), $singular ),
					'view_item' 			=> sprintf( __( 'View %s', 'team' ), $singular ),
					'search_items' 			=> sprintf( __( 'Search %s', 'team' ), $plural ),
					'not_found' 			=> sprintf( __( 'No %s found', 'team' ), $plural ),
					'not_found_in_trash' 	=> sprintf( __( 'No %s found in trash', 'team' ), $plural ),
					'parent' 				=> sprintf( __( 'Parent %s', 'team' ), $singular )
				),
				'description' => sprintf( __( 'This is where you can create and manage %s.', 'team' ), $plural ),
				'public' 				=> true,
				'show_ui' 				=> true,
				'capability_type' 		=> 'post',
				'map_meta_cap'          => true,
				'publicly_queryable' 	=> true,
				'exclude_from_search' 	=> false,
				'hierarchical' 			=> false,
				'rewrite' 				=> true,
				'query_var' 			=> true,
				'supports' 				=> array( 'title'),
				'show_in_nav_menus' 	=> false,
				'menu_icon' => 'dashicons-groups',
			) )
		);
	}


    public function _posttype_team_layout(){
        if ( post_type_exists( "team_layout" ) )
            return;

        $singular  = __( 'Team layout', 'team' );
        $plural    = __( 'Team layouts', 'team' );


        register_post_type( "team_layout",
            apply_filters( "team_posttype_team_layout", array(
                'labels' => array(
                    'name' 					=> $plural,
                    'singular_name' 		=> $singular,
                    'menu_name'             => __( $singular, 'team' ),
                    'all_items'             => sprintf( __( 'All %s', 'team' ), $plural ),
                    'add_new' 				=> __( 'Add New', 'team' ),
                    'add_new_item' 			=> sprintf( __( 'Add %s', 'team' ), $singular ),
                    'edit' 					=> __( 'Edit', 'team' ),
                    'edit_item' 			=> sprintf( __( 'Edit %s', 'team' ), $singular ),
                    'new_item' 				=> sprintf( __( 'New %s', 'team' ), $singular ),
                    'view' 					=> sprintf( __( 'View %s', 'team' ), $singular ),
                    'view_item' 			=> sprintf( __( 'View %s', 'team' ), $singular ),
                    'search_items' 			=> sprintf( __( 'Search %s', 'team' ), $plural ),
                    'not_found' 			=> sprintf( __( 'No %s found', 'team' ), $plural ),
                    'not_found_in_trash' 	=> sprintf( __( 'No %s found in trash', 'team' ), $plural ),
                    'parent' 				=> sprintf( __( 'Parent %s', 'team' ), $singular )
                ),
                'description' => sprintf( __( 'This is where you can create and manage %s.', 'team' ), $plural ),
                'public' 				=> false,
                'show_ui' 				=> true,
                'capability_type' 		=> 'post',
                'map_meta_cap'          => true,
                'publicly_queryable' 	=> false,
                'exclude_from_search' 	=> false,
                'hierarchical' 			=> false,
                'rewrite' 				=> true,
                'query_var' 			=> true,
                'supports' 				=> array( 'title'),
                'show_in_nav_menus' 	=> false,
                'show_in_menu' 	=> 'edit.php?post_type=team',
                'menu_icon' => 'dashicons-groups',
            ) )
        );
    }
}
	
	new team_class_post_types();