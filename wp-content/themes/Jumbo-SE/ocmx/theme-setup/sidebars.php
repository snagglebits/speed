<?php
// Create Dynamic Sidebars
if (function_exists('register_sidebar')) :
 	register_sidebar(array("name" => "Sidebar", "id" => "sidebar", "description" => "Place the Blue (Obox) widgets here.", "before_title" => '<h4 class="widgettitle">', "after_title" => '</h4>', 'before_widget' => '<li id="%1$s" class="widget %2$s">', 'after_widget' => '</li>'));
 	register_sidebar(array("name" => "Slider", "id" => "slider", "description" => "Place the Red (Obox) widget here."));
 	register_sidebar(array("name" => "Home Page", "id" => "homepage", "description" => "Place the Orange (Obox) widgets here.", "before_title" => '<h4 class="widgettitle">', "after_title" => '</h4>', 'before_widget' => '<li id="%1$s" class="widget %2$s"><div class="content">', 'after_widget' => '</div></li>'));
 	register_sidebar(array("name" => "Home Page - Side by side", "id" => "homepage-secondary", "description" => "Place the (Obox) Content Widget and (Obox) Testimonial widgets here and then set the (Obox) Content Widget to display either Posts or Portfolio items.", "before_title" => '<h4 class="widgettitle">', "after_title" => '</h4>', 'before_widget' => '<li id="%1$s" class="widget %2$s"><div class="content">', 'after_widget' => '</div></li>'));
 	register_sidebar(array("name" => "Home Page - Three Column", "id" => "homepage-threecol", "description" => "Place the Blue (Obox) widgets and / or (WordPress) default widgets here.", "before_title" => '<h4 class="widgettitle">', "after_title" => '</h4>', 'before_widget' => '<li id="%1$s" class="widget %2$s"><div class="content">', 'after_widget' => '</div></li>'));
 	register_sidebar(array("name" => "Shop Sidebar", "id" => "shopsidebar", "description" => "Place the (WooCommerce) widgets here.", "before_title" => '<h4 class="widgettitle">', "after_title" => '</h4>', 'before_widget' => '<li id="%1$s" class="widget %2$s"><div class="content">', 'after_widget' => '</div></li>'));
 	register_sidebar(array("name" => "Footer", "id" => "footer-sidebar", "description" => "Place the Blue (Obox) widgets or grey (Standard) here widgets.", "before_title" => '<h4 class="widgettitle">', "after_title" => '</h4>', 'before_widget' => '<li id="%1$s" class="widget %2$s column">', 'after_widget' => '</li>'));
endif;

/*******************/
/* Widgetized Page */
function add_widgetized_pages(){
	global $wpdb;
	$get_widget_pages = $wpdb->get_results("SELECT * FROM ".$wpdb->postmeta." WHERE `meta_key` = '_wp_page_template' AND  `meta_value` = 'widget-page.php'");
	foreach($get_widget_pages as $pages) :
		$post = get_post($pages->post_id);
		register_sidebar(array("name" => $post->post_title." Slider", "id" => $post->post_name . "-slider", "description" => "Place the Slider Widget here, or leave blank."));
		register_sidebar(array("name" => $post->post_title." Body", "id" => $post->post_name . "-body", "description" => "Place all Orange or full-width widgets here.", "before_title" => '<h4 class="widgettitle">', "after_title" => '</h4><div class="content">', 'before_widget' => '<li id="%1$s" class="widget %2$s">', 'after_widget' => '</div></li>'));
		register_sidebar(array("name" => $post->post_title." - Side by side", "id" => $post->post_name . "-secondary", "description" => "Place any two widgets here.", "before_title" => '<h4 class="widgettitle">', "after_title" => '</h4>', 'before_widget' => '<li id="%1$s" class="widget %2$s"><div class="content">', 'after_widget' => '</div></li>'));
		register_sidebar(array("name" => $post->post_title." - Three Column", "id" => $post->post_name . "-threecol", "description" => "Place the Blue (Obox) widgets and / or (WordPress) default widgets here.", "before_title" => '<h4 class="widgettitle">', "after_title" => '</h4>', 'before_widget' => '<li id="%1$s" class="widget %2$s"><div class="content">', 'after_widget' => '</div></li>'));
	endforeach;
}
add_action("init", "add_widgetized_pages");