<?php
add_action('init', 'my_custom_init_portfolio');
function my_custom_init_portfolio() 
{
  $labels = array(
    'name' => _x('Portfolio', 'post type general name', 'ocmx'),
    'singular_name' => _x('Portfolio', 'post type singular name', 'ocmx'),
    'add_new' => _x('Add Portfolio Item', 'portfolio', 'ocmx'),
    'add_new_item' => __('Add New Portfolio Item', 'ocmx'),
    'edit_item' => __('Edit ', 'ocmx'),
    'new_item' => __('New Portfolio Item', 'ocmx'),
    'view_item' => __('View Portfolio Item', 'ocmx'),
    'search_items' => __('Search Portfolio Items', 'ocmx'),
    'not_found' =>  __('No portfolio items found', 'ocmx'),
    'not_found_in_trash' => __('No portfolio items found in Trash', 'ocmx'), 
    'parent_item_colon' => '',
    'slug' => 'portfolio'
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/ocmx/images/icons/portfolio-icon.png',
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author','thumbnail','excerpt','comments', 'page-attributes')
  ); 
  register_post_type('portfolio',$args);
	
	/****************************************************************/
	/* Portfolio Post Type Custom Meta, here used to add a category */
	
	register_taxonomy( 'portfolio-category', 'portfolio', array( 'hierarchical' => true, 'label' => 'Categories', 'query_var' => true, 'rewrite' => true ) );  
	
	register_taxonomy('portfolio-tag', array('portfolio'),
    array
	    (
	        'hierarchical' => false,
	        'labels' => array
	        (
	            'name' => _x( 'Portofolio Tags', 'taxonomy general name', 'ocmx'),
	            'singular_name' => _x( 'Portofolio Tag', 'taxonomy singular name', 'ocmx'),
	            'search_items' =>  __( 'Search Portofolio Tags', 'ocmx'),
	            'all_items' => __( 'All Portofolio Tags', 'ocmx'),
	            'edit_item' => __( 'Edit Portofolio Tag', 'ocmx'), 
	            'update_item' => __( 'Update Portofolio Tag', 'ocmx'),
	            'add_new_item' => __( 'Add New Portofolio Tag', 'ocmx'),
	            'new_item_name' => __( 'New Portofolio Tag Name', 'ocmx'),
	            'menu_name' => __( 'Portofolio Tags', 'ocmx'),
	        ),
	        'show_ui' => true,
	        'query_var' => true,
	        'rewrite' => array('slug' => 'portfolio-tag', 'with_front' => true),
	    )
	);
}

//add filter to insure the text Portfolio, or portfolio, is displayed when user updates a portfolio 
add_filter('post_updated_messages', 'portfolio_updated_messages');
function portfolio_updated_messages( $messages ) {
  $post_ID = "";
  $post = "";
  $messages['portfolio'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Portfolio Item updated. <a href="%s">View portfolio item</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.','ocmx'),
    3 => __('Custom field deleted.','ocmx'),
    4 => __('Product updated.', 'ocmx'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s','ocmx'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Portfolio Item published. <a href="%s">View portfolio item</a>','ocmx'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Product saved.','ocmx'),
    8 => sprintf( __('Portfolio Item submitted. <a target="_blank" href="%s">Preview portfolio item</a>','ocmx'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Portfolio Item draft updated. <a target="_blank" href="%s">Preview portfolio item</a>','ocmx'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}
?>
