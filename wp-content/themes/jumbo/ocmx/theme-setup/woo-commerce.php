<?php
/********************/
/* SHOW META ******/
function show_meta() {
	if ( class_exists( 'Woocommerce' ) ) {
		if ( !( is_cart() || is_checkout() ) ) {
			return TRUE;
		}
	} else {
		 return TRUE;
	}
} // show_meta

/**************************/
/* WOOCOMMERCE  ******/

// Open image wrap
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_product_thumbnail_wrap_open', 5, 2);
add_action( 'woocommerce_before_subcategory_title', 'woocommerce_product_thumbnail_wrap_open', 5, 2);

if (!function_exists('woocommerce_product_thumbnail_wrap_open')) {
	function woocommerce_product_thumbnail_wrap_open() {
		echo '<div class="img-wrap">';
	}
}

// Close image wrap
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_product_thumbnail_wrap_close', 15, 2);
add_action( 'woocommerce_before_subcategory_title', 'woocommerce_product_thumbnail_wrap_close', 15, 2);
if (!function_exists('woocommerce_product_thumbnail_wrap_close')) {
	function woocommerce_product_thumbnail_wrap_close() {
		echo '</div> <!--/.wrap-->';
	}
}

// Redefine wooCommerce related products
function woo_related_products_limit( $args) {
  global $product;

	$args['posts_per_page'] = 3;
	return $args;
}
add_filter( 'woocommerce_related_products_args', 'woo_related_products_limit' );