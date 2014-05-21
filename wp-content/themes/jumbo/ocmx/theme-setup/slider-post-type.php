<?php
add_action('init', 'my_custom_init_slider');
function my_custom_init_slider() 
{
  $labels = array(
    'name' => _x('Slider', 'post type general name', 'ocmx'),
    'singular_name' => _x('Slider', 'post type singular name', 'ocmx'),
    'add_new' => _x('Add Slider Item', 'slider', 'ocmx'),
    'add_new_item' => __('Add New Slider Item', 'ocmx'),
    'edit_item' => __('Edit ', 'ocmx'),
    'new_item' => __('New Slider Item', 'ocmx'),
    'view_item' => __('View Slider Item', 'ocmx'),
    'search_items' => __('Search Slider Items', 'ocmx'),
    'not_found' =>  __('No slider items found', 'ocmx'),
    'not_found_in_trash' => __('No slider items found in Trash', 'ocmx'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/ocmx/images/icons/slider-icon.png',
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','thumbnail','excerpt', 'page-attributes')
  ); 
  register_post_type('slider',$args);
	
	/****************************************************************/
	/* Slider Post Type Custom Meta, here used to add a category */
	
	register_taxonomy( 'slider-category', 'slider', array( 'hierarchical' => true, 'label' => 'Slider Categories', 'query_var' => true, 'rewrite' => true ) );

}

//add filter to insure the text Slider, or slider, is displayed when user updates a slider 
add_filter('post_updated_messages', 'slider_updated_messages');
function slider_updated_messages( $messages ) {
  $post_ID = "";
  $post = "";
  $messages['slider'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Slider Item updated. <a href="%s">View slider item</a>', 'ocmx'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.', 'ocmx'),
    3 => __('Custom field deleted.', 'ocmx'),
    4 => __('Post updated.', 'ocmx'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s', 'ocmx'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Slider Item published. <a href="%s">View slider item</a>', 'ocmx'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Product saved.', 'ocmx'),
    8 => sprintf( __('Slider Item submitted. <a target="_blank" href="%s">Preview slider item</a>', 'ocmx'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Slider Item draft updated. <a target="_blank" href="%s">Preview slider item</a>', 'ocmx'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
?>
