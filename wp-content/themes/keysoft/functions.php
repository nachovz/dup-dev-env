<?php

// ------------------------------------------------------------------------
// Add Redux Framework & extras
// ------------------------------------------------------------------------

require get_template_directory() . '/themetek/themetek-init.php';
$redux_ThemeTek = get_option( 'redux_ThemeTek' );

// ------------------------------------------------------------------------
// Theme includes
// ------------------------------------------------------------------------

// Wordpress Bootstrap Menu
require_once ( get_template_directory() . '/themetek/assets/extra/wp_bootstrap_navwalker.php');

// ------------------------------------------------------------------------
// Enqueue scripts and styles front and admin
// ------------------------------------------------------------------------
	if( !function_exists('themetek_enqueue_front') ) {
		function themetek_enqueue_front() {	

			$redux_ThemeTek = get_option( 'redux_ThemeTek' );
			// Bootstrap CSS
			wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/themetek/assets/css/bootstrap.min.css', '', '' );
			// Theme main style CSS
			wp_enqueue_style( 'themetek-style', get_stylesheet_uri() );
			// Dynamic Styles
			wp_enqueue_style( 'themetek-dynamic-styles', get_template_directory_uri() . '/themetek/dynamic-keysoft.css', '', '' );
			// Font Awesome
			wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/themetek/font-awesome.min.css', '', '' );
			// Dynamic colors CSS
			wp_enqueue_style( 'themetek-dynamic-colors', get_template_directory_uri() . '/themetek/colors-keysoft.css.php', '', '' );						
			// Bootstrap JS
			wp_enqueue_script( 'bootstrapjs', get_template_directory_uri() . '/themetek/assets/js/bootstrap.min.js', array('jquery'), '', true );
			// Theme video background scripts
			if ($redux_ThemeTek['tek-bgvideo']['url']) {
			wp_enqueue_script( 'themetek-video-bg', get_template_directory_uri() . '/js/video.js', array(), '', true );
			}
			// Particles Background 
			if ($redux_ThemeTek['tek-particles']) {
			wp_enqueue_script( 'themetek-particles', get_template_directory_uri() . '/js/particles.js', array(), '', true );
			}		
			// Google Map Script
			if ($redux_ThemeTek['tek-google-api']) {
			wp_enqueue_script('tt_google_map', 'https://maps.googleapis.com/maps/api/js?key=' . $redux_ThemeTek['tek-google-api'], array(), null, true);
			wp_enqueue_script( 'tt_google_map_script', get_template_directory_uri() . '/js/map.js', array(), '', true );
			}
			// SmoothScroll
			wp_enqueue_script( 'themetek-scroll', get_template_directory_uri() . '/js/SmoothScroll.js', array(), '', true );
			// Theme main scripts
			wp_enqueue_script( 'themetek-scripts', get_template_directory_uri() . '/js/scripts.js', array(), '', true );
		}
	}
	add_action( 'wp_enqueue_scripts', 'themetek_enqueue_front' );
	
	if( !function_exists('themetek_enqueue_admin') ) {
		function themetek_enqueue_admin() {	      
	        wp_enqueue_script( 'themetek_wp_admin_js', get_template_directory_uri() . '/js/admin-scripts.js', '', '1.0.0' );
		}
	}
	add_action( 'admin_enqueue_scripts', 'themetek_enqueue_admin' );

// ------------------------------------------------------------------------
// Theme Setup
// ------------------------------------------------------------------------
	function themetek_setup(){
		if ( function_exists( 'add_theme_support' ) ) {
			// Add multilanguage support
			load_theme_textdomain( 'keysoft', get_template_directory() . '/themetek/languages' );		
			// Add theme support for feed links
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support( 'custom-header', array() );
			add_theme_support( 'custom-background', array() );			
			// Add theme support for menus
			if ( function_exists( 'register_nav_menus' ) ) {
				register_nav_menus(
					array(
					  'keysoft-header-menu' => 'Header Menu'
					)
				);
			}
			// Enable support for Blog Posts Thumbnails
			add_theme_support( 'post-thumbnails' );
			}
	}
	add_action( 'after_setup_theme', 'themetek_setup' );
		

// ------------------------------------------------------------------------
// Include plugin check, meta boxes, widgets, custom posts
// ------------------------------------------------------------------------	
	
	// Theme activation and plugin check
	include( get_template_directory() . '/themetek/theme-activation.php');
	include( get_template_directory() . '/themetek/theme-pagemeta.php');

	function themetek_widgets_register() {		
		register_sidebar( array(
            'name' => esc_html__( 'Sidebar', 'keysoft' ),
            'id' => 'themetek-sidebar-widget-area',
            'description' => esc_html__( 'Add widgets for the blog sidebar area. If none added, default sidebar widgets will be used.', 'keysoft' ),
            'before_widget' => '<div class="blog_widget">',
            'after_widget' => '</div>',
            'before_title' => '<h5 class="widget-title"><span>',
            'after_title' => '</span></h5>',
        ) );     	
    }
    add_action( 'widgets_init', 'themetek_widgets_register' );



// ------------------------------------------------------------------------
// Content Width
// ------------------------------------------------------------------------	
 
if ( ! isset( $content_width ) ) $content_width = 1400;
 
// ------------------------------------------------------------------------
// Custom Blog Navigation
// ------------------------------------------------------------------------	
function themetek_link_attributes_1($themetek_output) {
    return str_replace('<a href=', '<a class="next" href=', $themetek_output);
}
function themetek_link_attributes_2($themetek_output) {
    return str_replace('<a href=', '<a class="prev" href=', $themetek_output);
}

add_filter('next_post_link', 'themetek_link_attributes_1');
add_filter('previous_post_link', 'themetek_link_attributes_2');

// ------------------------------------------------------------------------
// Comment reply script enqueued
// ------------------------------------------------------------------------

function themetek_enqueue_comments_reply() {
	if( get_option( 'thread_comments' ) )  {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'comment_form_before', 'themetek_enqueue_comments_reply' );

// ------------------------------------------------------------------------
// Output Visual Composer custom CSS
// ------------------------------------------------------------------------

add_action('wp_head', 'keydesign_vc_custom_css');
function keydesign_vc_custom_css() {
   $keydesign_homePageID=get_the_ID();
   $keydesign_args=array('post_type'=>'page','posts_per_page'=>-1,'post_parent'=>$keydesign_homePageID,'post__not_in'=>array($keydesign_homePageID),'order'=>'ASC','orderby'=>'menu_order');
   $keydesign_parent=new WP_Query($keydesign_args);
   while($keydesign_parent->have_posts()) {
   $keydesign_parent->the_post();
   $current_id = get_the_ID();
   wp_reset_postdata();
        if  ( $current_id ) {
            $shortcodes_custom_css = get_post_meta( $current_id, '_wpb_shortcodes_custom_css', true );
            if ( ! empty( $shortcodes_custom_css ) ) {
                echo '<style type="text/css" data-type="vc_shortcodes-custom-css-'.$current_id.'">';
                echo esc_html($shortcodes_custom_css);
                echo '</style>';
            }
		}
	}
}


  
// ------------------------------------------------------------------------
// Main menu custom child pages attribute
// ------------------------------------------------------------------------
 
	function themetek_special_nav_class($classes, $item){
    	$themetek_menu_locations = get_nav_menu_locations();  
		$themetek_pageid = get_post_meta( $item->ID, '_menu_item_object_id', true );		
        $themetek_parrent_bool = get_page( $themetek_pageid );            
        if ( ! empty($themetek_parrent_bool) && is_a($themetek_parrent_bool, 'WP_Post') ) {
		if($themetek_parrent_bool->post_parent) {			
			$classes[] = 'one-page-link';
		}
  	 }
    
    	return $classes;
	}
	add_filter('nav_menu_css_class' , 'themetek_special_nav_class' , 10 , 2);

// ------------------------------------------------------------------------
// Search only blog posts
// ------------------------------------------------------------------------
	
	function themetek_search_filter($query) {
	    if ($query->is_search) {
	        $query->set('post_type', 'post');
	    }
	    return $query;
	}
	add_filter('pre_get_posts','themetek_search_filter');
	
// ------------------------------------------------------------------------
// Custom Body Class
// ------------------------------------------------------------------------
		
	function themetek_class_names($classes) {
	$redux_ThemeTek = get_option( 'redux_ThemeTek' );
	$classes[] = esc_attr( $redux_ThemeTek['tek-header-type'] );
	return $classes;
	}
	add_filter('body_class','themetek_class_names');

// ------------------------------------------------------------------------
// One Click Demo Importer
// ------------------------------------------------------------------------

function keysoft_importer() {
	add_theme_page('import-demo-full-custom', 'import-demo-full-custom', 'manage_options', 'import-demo', 'keysoft_import_demo' );
}
add_action( 'admin_menu', 'keysoft_importer' );

function keysoft_import_demo() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.','keysoft' ) );
	}
	require get_template_directory() . '/import.php';
}

function keysoft_check_import_files($keysoft_demo_content) {
	$keysoft_response = array();

	$keysoft_file_headers = @get_headers( $keysoft_demo_content );
	if( !strpos( $keysoft_file_headers[0], '200' ) ) {
	    $keysoft_response['errors'][] = 'demo_content.xml';
	}
	$keysoft_file_headers = @get_headers( $rev_slider );
	if( !strpos( $keysoft_file_headers[0], '200' ) ) {
	    $keysoft_response['errors'][] = 'revolution_slider.zip';
	}
	return $keysoft_response;
}

function keysoft_import_theme_files($keysoft_upload_dir, $keysoft_demo_content) {

file_put_contents( $keysoft_upload_dir.'/demo_content.xml_.txt', fopen( str_replace( " ", "%20",$keysoft_demo_content ), 'r' ) );

	return array(	
		'demo' => $keysoft_upload_dir.'/demo_content.xml_.txt', 
		'slider' => $keysoft_upload_dir.'/revolution_slider.zip'
	);
}

