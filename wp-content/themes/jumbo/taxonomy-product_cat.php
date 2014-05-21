<?php get_header();
global $product;
global $post;
$_product = $product;?>

<?php get_template_part('/functions/page-title'); ?>

<div id="content" class="clearfix">
	<div id="left-column" class="three-column">
		<?php do_action('woocommerce_before_single_product', $post, $_product); ?>
		<div class="shop-block">
			<?php  do_action('woocommerce_before_shop_loop'); ?>
		</div>
		<ul class="products">
			<?php if (have_posts()) :
				woocommerce_product_subcategories();
				while (have_posts()) :	the_post(); setup_postdata($post);
					woocommerce_get_template_part( 'content', 'product' );
				endwhile;
				woocommerce_product_loop_end();
			else :
				get_template_part("/functions/post-empty");
			endif; ?>
		</ul>
		<?php motionpic_pagination("clearfix", "pagination clearfix"); ?>
	</div>
	<?php if(get_option("ocmx_shop_sidebar_layout") != "sidebarnone"): ?>
		<?php get_sidebar(); ?>
	<?php endif;?>
</div>

<?php get_footer(); ?>