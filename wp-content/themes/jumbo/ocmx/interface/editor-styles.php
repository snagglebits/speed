<?php 
/**************************/
/* CUSTOM EDITOR STYLES   */

function add_obox_button() {
   // Don't bother doing this stuff if the current user lacks permissions
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
 
   // Add only in Rich Editor mode
   if ( get_user_option('rich_editing') == 'true') {
     add_filter("mce_external_plugins", "add_obox_tinymce_plugin");
     add_filter('mce_buttons', 'register_obox_button');
   }
}
 
function register_obox_button($buttons) {
   array_push($buttons, "|", "oboxbutton");
   return $buttons;
}
 
function add_obox_tinymce_plugin($plugin_array) {
	wp_localize_script( "editor", "template_directory",  get_template_directory_uri() );
	$plugin_array['oboxbutton'] = get_template_directory_uri().'/scripts/editor_styles.js';
	return $plugin_array;
}
add_action('init', 'add_obox_button');

add_editor_style( 'editor-style.css' );