<?php


// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) 
    $content_width = 700;


/*-----------------------------------------------------------------------------------*/
/*	Images
/*-----------------------------------------------------------------------------------*/
if (function_exists( 'add_theme_support')) {
	add_theme_support( 'post-thumbnails');
	
	if ( function_exists('add_image_size')) {
		add_image_size( 'full-size',  9999, 9999, false );
		add_image_size( 'slider',  980, 9999, false );
		add_image_size( 'small-thumb',  50, 50, true );
		add_image_size( 'grid-thumb',  230, 180, true );
	}
}


/*-----------------------------------------------------------------------------------*/
/*	Javascsript
/*-----------------------------------------------------------------------------------*/

add_action('wp_enqueue_scripts','clarity_scripts_function');
function clarity_scripts_function() {
	//get theme options
	global $options;
	
	wp_enqueue_script('jquery');	
	
	// Site wide js
	wp_enqueue_script('hoverIntent', get_template_directory_uri() . '/js/jquery.hoverIntent.minified.js');
	wp_enqueue_script('superfish', get_template_directory_uri() . '/js/superfish.js');
	wp_enqueue_script('uniform', get_template_directory_uri() . '/js/jquery.uniform.js');
	wp_enqueue_script('responsify', get_template_directory_uri() . '/js/jquery.responsify.init.js');
	wp_enqueue_script('custom', get_template_directory_uri() . '/js/custom.js');
}

/*-----------------------------------------------------------------------------------*/
/*Enqueue CSS
/*-----------------------------------------------------------------------------------*/
add_action('wp_enqueue_scripts', 'clarity_enqueue_css');
function clarity_enqueue_css() {
	
	//responsive
	wp_enqueue_style('responsive', get_template_directory_uri() . '/css/responsive.css', 'style');
	
	//awesome font - icon fonts
	wp_enqueue_style('awesome-font', get_template_directory_uri() . '/css/awesome-font.css', 'style');
	
}

add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );
function mw_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', plugins_url('my-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}


/*-----------------------------------------------------------------------------------*/
/*	Remove Menus
/*-----------------------------------------------------------------------------------*/

function remove_menus () {
global $menu;
	$restricted = array(__('Pages'), __('Comments'),);
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action('admin_menu', 'remove_menus');



// Limit Post Word Count
add_filter('excerpt_length', 'new_excerpt_length');
function new_excerpt_length($length) {
	return 40;
}

//Replace Excerpt Link
add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more) {
       global $post;
	return '...';
}

//custom excerpts
function excerpt($limit) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	}
	$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
	return $excerpt;
}

// Localization Support
load_theme_textdomain( '', TEMPLATEPATH.'/lang' );

//create featured image column
add_filter('manage_posts_columns', 'posts_columns', 5);
add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);
function posts_columns($defaults){
    $defaults['riv_post_thumbs'] = __('Thumbs', 'powered');
    return $defaults;
}
function posts_custom_columns($column_name, $id){
	if($column_name === 'riv_post_thumbs'){
        echo the_post_thumbnail( 'small-thumb' );
    }
}

// functions run on activation --> important flush to clear rewrites
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
	$wp_rewrite->flush_rules();
}

?>