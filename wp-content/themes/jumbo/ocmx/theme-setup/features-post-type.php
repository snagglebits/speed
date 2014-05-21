<?php
add_action('init', 'my_custom_init_features');
function my_custom_init_features()
{
	$labels = array(
		'name' => _x('Features', 'post type general name', 'ocmx'),
		'singular_name' => _x('Features', 'post type singular name', 'ocmx'),
		'add_new' => _x('Add Features Item', 'features', 'ocmx'),
		'add_new_item' => __('Add New Features Item', 'ocmx'),
		'edit_item' => __('Edit ', 'ocmx'),
		'new_item' => __('New Features Item', 'ocmx'),
		'view_item' => __('View Features Item', 'ocmx'),
		'search_items' => __('Search Features Items', 'ocmx'),
		'not_found' =>  __('No features items found', 'ocmx'),
		'not_found_in_trash' => __('No features items found in Trash', 'ocmx'),
		'parent_item_colon' => '',
		'slug' => 'features'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'menu_icon' => get_stylesheet_directory_uri() . '/ocmx/images/icons/features-icon-color.png',
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail','excerpt', 'page-attributes')
	);
	register_post_type('features',$args);

	/****************************************************************/
	/* Features Post Type Custom Meta, here used to add a category */

	register_taxonomy( 'features-category', 'features', array( 'hierarchical' => true, 'label' => 'Categories', 'query_var' => true, 'rewrite' => true ) );
}

//add filter to insure the text Features, or features, is displayed when user updates a features
add_filter('post_updated_messages', 'features_updated_messages');
function features_updated_messages( $messages ) {
	$post_ID = "";
	$post = "";
	$messages['features'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Features Item updated. <a href="%s">View features item</a>', 'ocmx'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.', 'ocmx'),
		3 => __('Custom field deleted.', 'ocmx'),
		4 => __('Post updated.', 'ocmx'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s', 'ocmx'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Features Item published. <a href="%s">View features item</a>', 'ocmx'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Post saved.', 'ocmx'),
		8 => sprintf( __('Features Item submitted. <a target="_blank" href="%s">Preview features item</a>', 'ocmx'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Features Item draft updated. <a target="_blank" href="%s">Preview features item</a>', 'ocmx'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	);

	return $messages;
}
?>
