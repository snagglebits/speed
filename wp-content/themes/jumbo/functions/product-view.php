<?php
global $product;
$_product = $product;
$link = get_permalink($post->ID); ?>

<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action( 'woocommerce_before_single_product', $post, $_product ); ?>

	<div class="product-top clearfix">
		<!-- Show the Images -->
		<div class="product-images">
			<?php do_action( 'woocommerce_before_single_product_summary', $post, $_product ); ?>
		</div>

		<!-- Show the Product Summary -->
		<div class="purchase-options-container">
			<div class="product-price">
				<?php do_action( 'woocommerce_single_product_summary', $post, $_product ); ?>
			</div>
			<?php if( get_option("ocmx_social_tag") !="" ) : ?>
				<span class="social"><?php echo get_option("ocmx_social_tag"); ?></span>
			<?php elseif( get_option("ocmx_meta_social_post") !="false"  ) : // Show sharing if enabled in Theme Options ?>
				<ul class="social">
					<li class="addthis">
						<!-- AddThis Button BEGIN -->
						<div class="addthis_toolbox addthis_default_style ">
							<a class="addthis_button_facebook_like"></a>
							<a class="addthis_button_tweet"></a>
							<a class="addthis_button_pinterest_pinit"></a>
							<a class="addthis_counter addthis_pill_style"></a>
						</div>
						<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-507462e4620a0fff"></script>
						<!-- AddThis Button END -->
					</li>
				</ul>
			<?php endif; ?>
		</div>
	</div>
    
	<?php do_action( 'woocommerce_after_single_product_summary', $post, isset($_product) ); ?>
    
</div>