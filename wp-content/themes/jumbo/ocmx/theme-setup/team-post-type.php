<?php
add_action('init', 'my_custom_init_team');
function my_custom_init_team() 
{
  $labels = array(
    'name' => _x('Team', 'post type general name', 'ocmx'),
    'singular_name' => _x('Team', 'post type singular name', 'ocmx'),
    'add_new' => _x('Add Team Member', 'team', 'ocmx'),
    'add_new_item' => __('Add New Team Member', 'ocmx'),
    'edit_item' => __('Edit', 'ocmx'),
    'new_item' => __('New Team Member', 'ocmx'),
    'view_item' => __('View Team Member', 'ocmx'),
    'search_items' => __('Search Team', 'ocmx'),
    'not_found' =>  __('No team members found', 'ocmx'),
    'not_found_in_trash' => __('No team members found in Trash', 'ocmx'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/ocmx/images/icons/team-icon-color.png',
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','thumbnail','excerpt', 'page-attributes', 'comments')
  ); 
  register_post_type('team',$args);
	
}

//add filter to insure the text Team, or team, is displayed when user updates a team 
add_filter('post_updated_messages', 'team_updated_messages');
function team_updated_messages( $messages ) {
  $post_ID = "";
  $post = "";
  $messages['team'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Team Item updated. <a href="%s">View team item</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.', 'ocmx'),
    3 => __('Custom field deleted.', 'ocmx'),
    4 => __('Product updated.', 'ocmx'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s', 'ocmx'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Team Item published. <a href="%s">View team item</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Product saved.', 'ocmx'),
    8 => sprintf( __('Team Item submitted. <a target="_blank" href="%s">Preview team item</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Team Item draft updated. <a target="_blank" href="%s">Preview team item</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}