<?php
add_action('init', 'my_custom_init_testimonials');
function my_custom_init_testimonials() 
{
  $labels = array(
    'name' => _x('Testimonials', 'post type general name', 'ocmx'),
    'singular_name' => _x('Testimonial', 'post type singular name', 'ocmx'),
    'add_new' => _x('Add Testimonials', 'testimonials', 'ocmx'),
    'add_new_item' => __('Add New Testimonials', 'ocmx'),
    'edit_item' => __('Edit', 'ocmx'),
    'new_item' => __('New Testimonial', 'ocmx'),
    'view_item' => __('View Testimonial', 'ocmx'),
    'search_items' => __('Search Testimonials', 'ocmx'),
    'not_found' =>  __('No testimonials', 'ocmx'),
    'not_found_in_trash' => __('No testimonials found in Trash', 'ocmx'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/ocmx/images/icons/testimonials-icon.png',
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','excerpt', 'thumbnail')
  ); 
  register_post_type('testimonials',$args);
	
	/****************************************************************/
	/* Testimonials Post Type Custom Meta, here used to add a category */
	
	register_taxonomy( 'testimonials-category', 'testimonials', array( 'hierarchical' => true, 'label' => 'Categories', 'query_var' => true, 'rewrite' => true ) );  
}

//add filter to insure the text Testimonials, or testimonials, is displayed when user updates a testimonials 
add_filter('post_updated_messages', 'testimonials_updated_messages');
function testimonials_updated_messages( $messages ) {
  $post_ID = "";
  $post = "";
  $messages['testimonials'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Testimonials Item updated. <a href="%s">View testimonials item</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.', 'ocmx'),
    3 => __('Custom field deleted.', 'ocmx'),
    4 => __('Product updated.', 'ocmx'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s', 'ocmx'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Testimonials Item published. <a href="%s">View testimonials item</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Product saved.', 'ocmx'),
    8 => sprintf( __('Testimonials Item submitted. <a target="_blank" href="%s">Preview testimonials item</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Testimonials Item draft updated. <a target="_blank" href="%s">Preview testimonials item</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
?>
