<?php
add_action('init', 'my_custom_init_services');
function my_custom_init_services() 
{
  $labels = array(
    'name' => _x('Services', 'post type general name', 'ocmx'),
    'singular_name' => _x('Services', 'post type singular name', 'ocmx'),
    'add_new' => _x('Add Services Item', 'services', 'ocmx'),
    'add_new_item' => __('Add New Services Item', 'ocmx'),
    'edit_item' => __('Edit ', 'ocmx'),
    'new_item' => __('New Services Item', 'ocmx'),
    'view_item' => __('View Services Item', 'ocmx'),
    'search_items' => __('Search Services Items', 'ocmx'),
    'not_found' =>  __('No services items found', 'ocmx'),
    'not_found_in_trash' => __('No services items found in Trash', 'ocmx'), 
    'parent_item_colon' => '',
    'slug' => 'services'
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/ocmx/images/icons/services-icon.png',
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','thumbnail','excerpt', 'page-attributes')
  ); 
  register_post_type('services',$args);
	
	/****************************************************************/
	/* Services Post Type Custom Meta, here used to add a category */
	
	register_taxonomy( 'services-category', 'services', array( 'hierarchical' => true, 'label' => 'Categories', 'query_var' => true, 'rewrite' => true ) );  
}

//add filter to insure the text Services, or services, is displayed when user updates a services 
add_filter('post_updated_messages', 'services_updated_messages');
function services_updated_messages( $messages ) {
  $post_ID = "";
  $post = "";
  $messages['services'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Services Item updated. <a href="%s">View services item</a>', 'ocmx'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.', 'ocmx'),
    3 => __('Custom field deleted.', 'ocmx'),
    4 => __('Post updated.', 'ocmx'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s', 'ocmx'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Services Item published. <a href="%s">View services item</a>', 'ocmx'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Post saved.', 'ocmx'),
    8 => sprintf( __('Services Item submitted. <a target="_blank" href="%s">Preview services item</a>', 'ocmx'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Services Item draft updated. <a target="_blank" href="%s">Preview services item</a>', 'ocmx'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
?>
