<?php
/**
 * NewPeterLevine functions and descriptions.
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
 
/**
 * Create a login form Shortcode with accompanying Wp-login call - Original tutorial was at - 
 *http://justintadlock.com/archives/2011/08/30/adding-a-login-form-to-a-page
 */
 add_action( 'init', 'my_add_shortcodes' );

function my_add_shortcodes() {

	add_shortcode( 'my-login-form', 'my_login_form_shortcode' );
}
/* This function is tied to my_add_shortcodes() function, in that it actually checks  
 * If the user is already logged in, and if not, calls the wp-login-form.php file. 
 *   
 */
function my_login_form_shortcode() {

	if ( is_user_logged_in() )
		return '<p>You are already logged in!</p>';

	return wp_login_form( array( 'echo' => false ) );
}
/*This is a Sidr widget from Alberto Valero: http://www.berriart.com/sidr/. Taken from another article available here to 
 * Add mobile sidebar. From http://premium.wpmudev.org/blog/how-to-make-twenty-fourteen-or-any-other-wp-theme-super/
 */
function awesome_2014_mobile_widget_area() {
register_sidebar( array(
'name' => __( 'Mobile Sidebar', 'awesome_2014' ),
'id' => 'sidebar-mobile',
'description' => __( 'Slideout sidebar for mobile devices.', 'awesome_2014' ),
'before_widget' => '<aside id="%1$s" class="widget %2$s mobile-widget">',
'after_widget' => '</aside>',
'before_title' => '<h1 class="widget-title">',
'after_title' => '</h1>',
) );
}
add_action( 'widgets_init', 'awesome_2014_mobile_widget_area' );

//add mobile menu
function awesome_2014_setup() {
register_nav_menus( array(
'mobile' => __( 'Mobile menu in left sidebar', 'awesome_2014' ),
) );
}
add_action( 'after_setup_theme', 'awesome_2014_setup' );

