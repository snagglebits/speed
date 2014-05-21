<div class="header-cart">
	<?php global $woocommerce;
	if (sizeof($woocommerce->cart->get_cart())>0) : ?>
		<ul class="header-products">
			<?php foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) :
				$_product = $cart_item['data'];
				if ($_product->exists() && $cart_item['quantity']>0) : ?>

					<li class="clearfix">
						<div class="product-image">
							<?php echo $_product->get_image(); ?>
						</div>
						<?php
						echo '<h4><a href="'.get_permalink($cart_item['product_id']).'">' . apply_filters('woocommerce_cart_widget_product_title', $_product->get_title(), $_product).'</a></h4>';
						echo '<div class="header-price">'.$cart_item['quantity'].'x '.woocommerce_price($_product->get_price()).'</div>';
						?>
					</li>

				<?php endif; ?>
			<?php endforeach; ?>
		</ul>

		<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>" class="cart-link"><?php _e('View Cart', 'ocmx'); ?></a>
		<a href="<?php echo $woocommerce->cart->get_checkout_url(); ?>" class="checkout-link"><?php _e('Checkout', 'ocmx'); ?></a>

	<?php else:
		echo '<span class="empty">'.__('No products in the cart.', 'woocommerce').'</span>';
	endif; ?>
			</div>