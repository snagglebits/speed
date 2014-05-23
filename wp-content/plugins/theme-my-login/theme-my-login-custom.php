<?php
/*
Plugin Name: Theme My Login
Plugin URI: http://www.jfarthing.com/extend/wordpress-plugins/theme-my-login/
Description: Themes the WordPress login, registration and forgot password pages according to your theme.
Version: 6.3.9
Author: Jeff Farthing
Author URI: http://www.jfarthing.com
Text Domain: theme-my-login
Domain Path: /language/
*/

// Allow custom functions file
if ( file_exists( WP_PLUGIN_DIR . '/theme-my-login-custom.php' ) )
	include_once( WP_PLUGIN_DIR . '/theme-my-login-custom.php' );

// Require a few needed files
require_once( WP_PLUGIN_DIR . '/theme-my-login/includes/class-theme-my-login-common.php' );
require_once( WP_PLUGIN_DIR . '/theme-my-login/includes/class-theme-my-login-abstract.php' );
require_once( WP_PLUGIN_DIR . '/theme-my-login/includes/class-theme-my-login.php' );
require_once( WP_PLUGIN_DIR . '/theme-my-login/includes/class-theme-my-login-template.php' );
require_once( WP_PLUGIN_DIR . '/theme-my-login/includes/class-theme-my-login-widget.php' );

// Instantiate Theme_My_Login singleton
Theme_My_Login::get_object();

if ( is_admin() ) {
	require_once( WP_PLUGIN_DIR . '/theme-my-login/admin/class-theme-my-login-admin.php' );

	// Instantiate Theme_My_Login_Admin singleton
	Theme_My_Login_Admin::get_object();
}

if ( is_multisite() ) {
	require_once( WP_PLUGIN_DIR . '/theme-my-login/includes/class-theme-my-login-ms-signup.php' );

	// Instantiate Theme_My_Login_MS_Signup singleton
	Theme_My_Login_MS_Signup::get_object();
}

if ( ! function_exists( 'theme_my_login' ) ) :
/**
 * Displays a TML instance
 *
 * @see Theme_My_Login::shortcode() for $args parameters
 * @since 6.0
 *
 * @param string|array $args Template tag arguments
 */
function theme_my_login( $args = '' ) {
	echo Theme_My_Login::get_object()->shortcode( wp_parse_args( $args ) );
}
endif;

function tml_registration_errors( $errors ) {
	if ( empty( $_POST['first_name'] ) )
		$errors->add( 'empty_first_name', '<strong>ERROR</strong>: Please enter your first name.' );
	if ( empty( $_POST['last_name'] ) )
		$errors->add( 'empty_last_name', '<strong>ERROR</strong>: Please enter your last name.' );
	return $errors;
}
add_filter( 'registration_errors', 'tml_registration_errors' );
function tml_user_register( $user_id ) {
	if ( !empty( $_POST['first_name'] ) )
		update_user_meta( $user_id, 'first_name', $_POST['first_name'] );
	if ( !empty( $_POST['last_name'] ) )
		update_user_meta( $user_id, 'last_name', $_POST['last_name'] );
}
add_action( 'user_register', 'tml_user_register' );

?>
