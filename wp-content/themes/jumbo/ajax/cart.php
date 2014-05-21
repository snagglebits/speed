<?php function ocmx_cart_display(){
	get_template_part('functions/header-cart');
	if(isset($_REQUEST['action']))
	die();
}
function ocmx_cart_button_display(){
	global $woocommerce; ?>
	<a class="header-cart-button" href="#">
		<?php _e("Shopping Bag", "ocmx"); ?>
		<?php echo sprintf(_n('(%d)', '(%d)', $woocommerce->cart->cart_contents_count), $woocommerce->cart->cart_contents_count); ?>
	</a>
<?php 	if(isset($_REQUEST['action']))
		die();
}