<?php
if(!get_option("ocmx_font_support"))
	update_option("ocmx_font_support", true);
add_theme_support( 'woocommerce' );

/*****************/
/* Add Nav Menus */
if (function_exists('register_nav_menus')) :
	register_nav_menus( array(
		'top' => __('Top Navigation', '$obox_themename'),
		'primary' => __('Primary Navigation', '$obox_themename'),
		'secondary' => __('Footer Navigation', '$obox_themename')
	) );
endif;

/************************************************/
/* Fallback Function for WordPress Custom Menus */
if( !function_exists( 'ocmx_fallback' ) ) {
	function ocmx_fallback() {
		echo '<ul id="nav" class="clearfix">';
			wp_list_pages('title_li=&');
		echo '</ul>';
	}
}

/**************************/
/* WP 3.4 Support         */
global $wp_version;
if ( version_compare( $wp_version, '3.4', '>=' ) )
	add_theme_support( 'custom-background' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );

if ( ! isset( $content_width ) ) $content_width = 980;

/************************/
/* Add WP Custom Header */
function ocmx_header_style() { $do = "nothing"; }
function ocmx_admin_header_style() { $do = "nothing"; }

/// Add support for custom headers
$headerargs = array( 'wp-head-callback' => 'ocmx_header_style', 'admin-head-callback' => 'ocmx_admin_header_style', 'width' => '2000', 'height' => '520',  'header-text' => false, 'random-default' => true);
add_theme_support( 'custom-header', $headerargs );


/*********************/
/* Load Localization */
load_theme_textdomain('ocmx', get_template_directory() . '/lang');

/**********************/
/* CUSTOM LOGIN LOGO  */
function ocmx_login_logo() {
	echo '<style type="text/css">
		h1 a { background-image:url('.get_option("ocmx_custom_login", true).') !important; }
	</style>';
}

add_action('login_head', 'ocmx_login_logo');