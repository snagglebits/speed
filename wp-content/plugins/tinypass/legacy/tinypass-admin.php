<?php

define('TINYPASS_FAVICON', 'http://www.tinypass.com/favicon.ico');

tinypass_include();

require_once (dirname(__FILE__) . '/tinypass-mode-settings.php');
require_once (dirname(__FILE__) . '/tinypass-site-settings.php');
require_once (dirname(__FILE__) . '/tinypass-paywalls.php');

add_action("admin_menu", 'tinypass_add_admin_pages');

function tinypass_add_admin_pages() {
	add_menu_page('Tinypass', 'Tinypass', 'manage_options', 'tinypass.php', 'tinypass_paywalls_list', TINYPASS_FAVICON);
	add_submenu_page('tinypass.php', 'Paywalls', 'Paywalls', 'manage_options', 'tinypass.php', 'tinypass_paywalls_list');
	add_submenu_page('tinypass.php', 'General', 'General', 'manage_options', 'TinyPassSiteSettings', 'tinypass_site_settings');

	add_submenu_page('tinypass.php', 'Edit Paywall', '', 'manage_options', 'TinyPassEditPaywall', 'tinypass_mode_settings');

	wp_enqueue_script('suggest');
}

/* Post/Page edit forms meta boxes */
add_action('add_meta_boxes', 'tinypass_add_meta_boxes');

function tinypass_add_meta_boxes() {

	$ss = tinypass_load_settings();

	if (!$ss->isPPPEnabled()) {
		return;
	}

	$types = get_post_types();
	unset($types['attachment']);
	unset($types['revision']);
	unset($types['nav_menu_item']);

	foreach ($types as $type) {
		add_meta_box(
						'tinypass_post_options', '<img src="' . TINYPASS_FAVICON . '">&nbsp;' . __('Tinypass Options'), 'tinypass_meta_box_display', $type, 'side'
		);
	}
}

function tinypass_meta_box_display($post) {
	$storage = new TPStorage();
	$postSettings = $storage->getPostSettings($post->ID);
	tinypass_post_header_form($postSettings);
}

/* Adding scripts to admin pages */
add_action('admin_enqueue_scripts', 'tinypass_add_admin_scripts');

function tinypass_add_admin_scripts() {
	wp_enqueue_script("jquery");
	wp_enqueue_script("jquery-ui");
	wp_enqueue_script('jquery-ui-dialog');
	wp_enqueue_script('tinypass_admin', TINYPASS_PLUGIN_PATH . 'js/tinypass_admin.js', array('jquery'), false, false);
	wp_enqueue_style('tinypass.css', TINYPASS_PLUGIN_PATH . 'css/tinypass.css');
	wp_enqueue_style('jquery-ui-1.8.2.custom.css', TINYPASS_PLUGIN_PATH . 'css/jquery-ui-1.8.2.custom.css');
}

?>