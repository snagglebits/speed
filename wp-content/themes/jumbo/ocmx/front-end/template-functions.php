<?php
/* Theme Colour Selection */
function theme_colour_styles()
	{
		if(isset($_GET["use_colour"])) :
			add_action('init', 'set_template_colour'); ?>
			<link href="<?php echo get_template_directory_uri(); ?>/color-styles/<?php echo $_GET["use_colour"]; ?>/style.css" rel="stylesheet" type="text/css" />
		<?php elseif(isset($_COOKIE["ocmx_theme_style"])) :?>
			<link href="<?php echo get_template_directory_uri(); ?>/color-styles/<?php echo $_COOKIE["ocmx_theme_style"]; ?>/style.css" rel="stylesheet" type="text/css" />
		<?php elseif(get_option("ocmx_theme_style") !== "") : ?>
			<link href="<?php echo get_template_directory_uri(); ?>/color-styles/<?php echo get_option("ocmx_theme_style"); ?>/style.css" rel="stylesheet" type="text/css" />
		<?php endif;
	}
function set_template_colour()
	{setcookie("ocmx_theme_style", $_GET["use_colour"], 0, COOKIEPATH, COOKIE_DOMAIN);}

if( !function_exists('ocmx_get_sidebar_widgets') ) {
	function ocmx_get_sidebar_widgets( $sidebar_id = '' ) {
		if( '' == $sidebar_id ) return;

		$sidebars = get_option( 'sidebars_widgets' );

		foreach ( $sidebars as $sidebar => $widgets ){
			if( $sidebar == $sidebar_id ) {
				return $widgets;
			}
		}
	}
}

// Disable WooCommerce stylesheet for all themes
if ( defined( 'WOOCOMMERCE_VERSION' ) && version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
	add_filter( 'woocommerce_enqueue_styles', '__return_false' );
} else {
	define( 'WOOCOMMERCE_USE_CSS', false );
}