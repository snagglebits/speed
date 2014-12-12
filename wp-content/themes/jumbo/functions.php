<?php  global $obox_themename, $input_prefix;

/*****************/
/* Theme Details */

$obox_themename = "Jumbo";
$obox_themeid = "jumbo";
$obox_productid = "1830";
$obox_presstrendsid = "orwk28wvb12tomi2c6s2zxu5lm377ijgm";

/**********************/
/* Include OCMX files */
$include_folders = array("/ocmx/includes/", "/ocmx/theme-setup/", "/ocmx/widgets/", "/ocmx/front-end/", "/ajax/", "/ocmx/interface/");
include_once (get_template_directory()."/ocmx/folder-class.php");
include_once (get_template_directory()."/ocmx/load-includes.php");

/***********************/
/* Add OCMX Menu Items */

add_action('admin_menu', 'ocmx_add_admin');
function ocmx_add_admin() {
	global $wpdb;

	add_object_page("Theme Options", "Theme Options", "edit_theme_options", basename(__FILE__), "", "//obox-design.com/images/ocmx-favicon.png");
	add_submenu_page(basename(__FILE__), "General Options", "General", "edit_theme_options", basename(__FILE__), "ocmx_general_options");
	add_submenu_page(basename(__FILE__), "Adverts", "Adverts", "administrator",  "ocmx-adverts", "ocmx_advert_options");
	add_submenu_page(basename(__FILE__), "Typography", "Typography", "edit_theme_options", "ocmx-fonts", "ocmx_font_options");
	add_submenu_page(basename(__FILE__), "Customize", "Customize", "edit_theme_options", "customize.php");
	add_submenu_page(basename(__FILE__), "Help", "Help", "edit_theme_options", "obox-help", "ocmx_welcome_page");

}
