<?php
/*
Plugin Name: WP RelatedPosts
Description: Display related posts by taxonomy, and increasing your pageviews by user
Version: 1.1.2
Author: Darko Atanasovski
Author URI: http://atanasovsky.wordperss.com
*/

if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if(class_exists('RelatedPosts'))
{
    
    register_activation_hook(__FILE__, array('RelatedPosts', 'activate'));
    register_deactivation_hook(__FILE__, array('RelatedPosts', 'deactivate'));
	
    new RelatedPosts();
}
class RelatedPosts{
	var $apc_enabled = false;
	public function __construct() {
		
		add_action('wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action('wp_footer', array( $this, 'htmlbox' ) );
		add_action('admin_menu', array( $this, 'admin_page' ) );
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'plugin_links' ) );

		if( is_admin() === true )
		{
			wp_enqueue_style('rp-admin-css', plugins_url( 'css/rpadmin.css', __FILE__ ));
			wp_enqueue_style('rp-frontend-css', plugins_url( 'css/rpstyle.css', __FILE__ ));
			wp_enqueue_script('jquery');
			wp_enqueue_script( 'jquery-form' );
			wp_enqueue_script( 'rp-admin-js', plugins_url( 'js/relatedposts-admin.js', __FILE__ ), array('jquery','jquery-form') );
			wp_enqueue_script('notifyjs', plugins_url( 'js/notify.min.js', __FILE__ ));
			add_action( 'wp_ajax_update_options', array( $this, 'update_options' ) );
			add_action( 'wp_ajax_reset_options', array( $this, 'activate' ) );
		}
	}
	function plugin_links( $links ) {
	   $links[] = '<a href="'. esc_url( get_admin_url(null, 'admin.php?page=wp-related-posts') ) .'">Settings</a>';
	   return $links;
	}
	public function admin_page() {
		if( is_admin() === true )
		{
			add_menu_page( 'RelatedPosts', 'RelatedPosts', 'manage_options', 'wp-related-posts', array($this,'render_admin_page'), 'dashicons-feedback', 6 );
		}
	}
	public function render_admin_page() {
		if( is_admin() === true )
		{
			include( 'inc/admin.php');
		}
	}
	public function htmlbox() {
		global $post;
		$tags = wp_get_post_tags( $post->ID, array( 'fields' => 'names' ) );
		$args = array(
			'posts_per_page'   => 3,
			'offset'           => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'include'          => '',
			'exclude'          => '',
			'post__not_in'	   => array($post->ID),
			'post_type'        => 'post',
			'post_status'      => 'publish',
			'tag'			   => implode(',', $tags),
			'suppress_filters' => true 
		);

		$relatedposts 	= get_posts( $args );
		$posts_num		= count( $relatedposts );
		if( is_single() )
		{	
			if( get_option('rp-show-random') == 1 && $posts_num < 3 )
			{
				$excluded_ids = array($post->ID);
				foreach( $relatedposts as $relatedpost )
				{
					$excluded_ids[] = $relatedpost->ID;
				}
				$args = array(
					'posts_per_page'   => (3-$posts_num),
					'offset'           => 0,
					'orderby'          => 'RAND()',
					'order'            => 'DESC',
					'include'          => '',
					'exclude'          => '',
					'post__not_in'	   => $excluded_ids,
					'post_type'        => 'post',
					'post_status'      => 'publish',
					'suppress_filters' => true 
				);
				$random_related 	= get_posts( $args );
				$relatedposts = array_merge( $relatedposts, $random_related );
			}
			if( count( $relatedposts ) == 3 )
			{
				include('templates/default.php');
			}
		}
	}
	public function enqueue_assets() {
		wp_enqueue_style( "wprp-style",  plugins_url( 'css/rpstyle.css', __FILE__ ));
		wp_enqueue_script( "wprp-script",  plugins_url( 'js/relatedposts.js', __FILE__ ), array(), '1.0', true  );
	}
	public function update_options() {
		
		check_ajax_referer( 'wprelatedpost-s', 'rpnonce' );
		foreach( $_POST as $key => $value )
		{
			if( substr($key,0,3) === 'rp-' && $key != 'rp-show-random' )
			{
				update_option( $key, esc_attr( $value ) );
			}
		}
		if( isset( $_POST[ 'rp-show-random' ] ) )
		{
			update_option( 'rp-show-random', 1 );
		}else{
			update_option( 'rp-show-random', 0 );
		}
		if( isset( $_POST[ 'rp-gatracking' ] ) )
		{
			update_option( 'rp-gatracking', 1 );
		}else{
			update_option( 'rp-gatracking', 0 );
		}
		if( isset( $_POST[ 'rp-show-excerpt' ] ) )
		{
			update_option( 'rp-show-excerpt', 1 );
		}else{
			update_option( 'rp-show-excerpt', 0 );
		}
		wp_die();
	}
	public function activate() {
	
		$config[ 'rp-mode' ] 				= 'scrolldown';
		$config[ 'rp-scrollpercent' ] 		= 80;
		$config[ 'rp-timeoutms' ] 			= 7000;
		$config[ 'rp-title' ] 				= 'Related Posts';
		$config[ 'rp-effect' ] 				= 'fadeInDown';
		$config[ 'rp-read-more-text' ] 		= 'Read more';
		$config[ 'rp-gatracking' ] 			= 1;
		$config[ 'rp-show-random' ] 		= 1;
		$config[ 'rp-show-excerpt' ]		= 1;
		
		foreach( $config as $key => $value )
		{
			delete_option( $key );
			add_option($key, $value);
		}
	}
	public function deactivate() {
		$config = array('rp-mode','rp-scrollpercent','rp-timeoutms','rp-title','rp-gatracking','rp-show-random','rp-effect','rp-show-excerpt');
		foreach( $config as $key )
		{
			delete_option( $key );
		}
	}
}