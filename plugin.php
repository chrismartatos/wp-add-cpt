<?php

/*

Plugin Name: Add Custom Post Type
Description: Custom Post Type
Author: Chris Martatos
Version: 3.1
Author URI: http://www.chrismartatos.com/

 */


class add_custom_post_type {


	public function __construct(  ) 
	{

		// Disable plugin updates
		add_filter( 'http_request_args', array( $this, 'prevent_update_check'), 10, 2 );		
		
		add_action( 'init', array( &$this, 'create_cpt' ) );	
		add_action( 'init', array( &$this, 'cpt_image_sizes' ) );	
		add_action( 'wp_enqueue_scripts', array( &$this, 'load_assets') );


	}


	/*----------------------------------------------------------------------------------------
	 			Disable updates for plugin
	----------------------------------------------------------------------------------------*/
	function prevent_update_check( $r, $url ) 
	{
		if ( 0 === strpos( $url, 'http://api.wordpress.org/plugins/update-check/' ) ) {
			$my_plugin = plugin_basename( __FILE__ );
			$plugins = unserialize( $r['body']['plugins'] );
			unset( $plugins->plugins[$my_plugin] );
			unset( $plugins->active[array_search( $my_plugin, $plugins->active )] );
			$r['body']['plugins'] = serialize( $plugins );
		}
		return $r;
	}
	
	

	/*----------------------------------------------------------------------------------------
	 	Create Event post type
		@link http://codex.wordpress.org/Function_Reference/register_post_type
		*Change Variables values
	----------------------------------------------------------------------------------------*/
	function create_cpt() 
	{
	  $singular = 'CPT'; /*Change Variables values*/
	  
	  $plural = 'CPT Posts'; /*Change Variables values*/
	  
	  $slug = 'cpt'; /*Change Variables values*/
	  
	  $post_type = 'cpt_post'; /*Change Variables values*/
	  
	  $supports = array('title', 'editor', 'thumbnail', 'page-attributes'); 
	  
	  
	  $labels = array(
		'name' => _x( $plural, 'post type general name'),
		'singular_name' => _x( $singular, 'post type singular name'),
		'add_new' => _x('Add New', strtolower( $singular ) ),
		'add_new_item' => __('Add New '. $singular),
		'edit_item' => __('Edit '. $singular ),
		'new_item' => __('New '. $singular ),
		'view_item' => __('View '. $singular),
		'search_items' => __('Search '. $plural),
		'not_found' =>  __('No '. $plural .' found'),
		'not_found_in_trash' => __('No '. $plural .' found in Trash'), 
		'parent_item_colon' => '',
		'menu_name' => $plural
	
	  );
	  $args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => false,
		'query_var' => true,
		'rewrite' => Array('slug'=> $slug ),
		'capability_type' => 'post',
		'has_archive' => false, 
		'hierarchical' => false,
		'supports' => $supports
		
	  );
	  
	  register_post_type( $post_type, $args );
	}
	
	function cpt_image_sizes() 
	{
		add_image_size( 'cpt-thumbnail', 160, 160, TRUE ); //mobile	
	}

	function load_assets()
	{
		wp_enqueue_style('custom-post-type-css', plugins_url( 'style.css', __FILE__)	);	
	}



}

new add_custom_post_type();