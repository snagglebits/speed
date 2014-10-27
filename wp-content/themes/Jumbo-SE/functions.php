<?php
/**
 * NewPeterLevine functions and descriptions.
 * @package WordPress
 * @subpackage jumbo
 * @since jumbo
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

/**********************************
/* Includes parent OCMX files */
$folder = get_stylesheet_directory(). '/ocmx/';


/*************
/*Add New User role - Event Coordinator

add_role('event_coordinator', 'Event Coordinator', array(
    'read' => true, // True allows that capability
    'edit_posts' => true,
    'delete_posts' => false, // Use false to explicitly deny
    'upload_files' => true,
    'edit_plugins' => true,
    'delete_event_categories' => true,
    'delete_events' => true,
    'delete_locations' => true,
    'delete_others_events' => true,
    'delete_others_locations' => true,
    'delete_others_recurring_events' => true,
    'delete_recurring_events' => true,
    'edit_event_categories' => true,
    'edit_events' => true,
    'edit_locations' => true,
    'edit_others_events' => true,
    'edit_others_locations' => true,
    'edit_others_recurring_events' => true,
    'edit_recurring_events' => true,
    'manage_bookings' => true,
    'manage_others_bookings' => true,
    'publish_events' => true,
    'publish_locations' => true,
    'publish_recurring_events' => true,
    'read_others_locations' => true,
    'read_private_events' => true,
    'read_private_locations' => true,
    'upload_event_images' => true,
    'manage_options' => true,
));
*/
add_filter ('FHEE_management_capability', 'my_custom_menu_management_capability');

function my_custom_menu_management_capability() {
    return 'edit_posts';
}

/*if ( null !== $result ) {
    echo 'Yay! New role created!';
}
else {
    echo 'Oh... the event_coordinator role already exists.';
} */
?>
