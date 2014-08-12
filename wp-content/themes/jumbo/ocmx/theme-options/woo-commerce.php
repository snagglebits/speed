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


// Displays up to 3 related products on product posts (determined by common category/tag)
function woocommerce_output_related_products() {
woocommerce_related_products(3,1); // Display 3 products in rows of 3
}
// Displays up to 3 Upsells on product posts
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );
 
	if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
		function woocommerce_output_upsells() {
		woocommerce_upsell_display( 3,1 ); // Display 3 products in 1 row
	}
}