<?php
add_action('init', 'my_custom_init_partners');
function my_custom_init_partners() 
{
  $labels = array(
    'name' => _x('Partners', 'post type general name', 'ocmx'),
    'singular_name' => _x('Partners', 'post type singular name', 'ocmx'),
    'add_new' => _x('Add Partners Item', 'partners', 'ocmx'),
    'add_new_item' => __('Add New Partners Item', 'ocmx'),
    'edit_item' => __('Edit', 'ocmx'),
    'new_item' => __('New Partners Item', 'ocmx'),
    'view_item' => __('View Partners Item', 'ocmx'),
    'search_items' => __('Search Partners Items', 'ocmx'),
    'not_found' =>  __('No partners items found', 'ocmx'),
    'not_found_in_trash' => __('No partners items found in Trash', 'ocmx'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/ocmx/images/icons/partners-icon-color.png',
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title', 'thumbnail', 'excerpt', 'page-attributes')
  ); 
  register_post_type('partners',$args);
  
  	/****************************************************************/
	/* Portfolio Post Type Custom Meta, here used to add a category */
	
	register_taxonomy( 'partners-category', 'partners', array( 'hierarchical' => true, 'label' => 'Categories', 'query_var' => true, 'rewrite' => true ) );  
	
 
}

//add filter to insure the text Partners, or partners, is displayed when user updates a partners 
add_filter('post_updated_messages', 'partners_updated_messages');
function partners_updated_messages( $messages ) {
  $post_ID = "";
  $post = "";
  $messages['partners'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Partners Item updated. <a href="%s">View partners item</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.', 'ocmx'),
    3 => __('Custom field deleted.', 'ocmx'),
    4 => __('Product updated.', 'ocmx'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s', 'ocmx'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Partners Item published. <a href="%s">View partners item</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Product saved.', 'ocmx'),
    8 => sprintf( __('Partners Item submitted. <a target="_blank" href="%s">Preview partners item</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Partners Item draft updated. <a target="_blank" href="%s">Preview partners item</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
?>
