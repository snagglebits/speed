	<?php global $obox_themeid; ?>
	</div><!--End Content Container -->

	<?php
	$show_cta = get_option("ocmx_footer_cta_show");
	$cta_text = get_option("ocmx_footer_cta_text");
	$cta_button = get_option("ocmx_footer_cta_button_text");
	$cta_link = get_option("ocmx_footer_cta_button_link");

	if( $show_cta == 'true' && ( $cta_button !="" || $cta_link !="" || $cta_text != "" ) ) : ?>
		<div id="site-wide-container">
			<div class="site-wide-cta">
				<?php if( $cta_text !="" ) : ?>
					<span><?php echo $cta_text; ?></span>
				<?php endif; ?>
				<?php if( $cta_button !="" || $cta_link !="" ) : ?>
					<a class="action-link" href="<?php echo $cta_link; ?>"><?php echo $cta_button; ?></a>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<div id="footer-container">

		<div id="footer" class="clearfix">
			<ul class="footer-widgets four-column clearfix">
				<?php dynamic_sidebar('footer-sidebar'); ?>
			</ul>
		</div> <!--End footer -->

	</div> <!--end Footer Container -->

	<div id="footer-base-container">
		<div class="footer-text">
			<div id="footer-navigation-container">
				<?php wp_nav_menu(array(
					'menu' => 'Footer Nav',
					'menu_id' => 'footer-nav',
					'menu_class' => 'clearfix',
					'sort_column' 	=> 'menu_order',
					'theme_location' => 'secondary',
					'container' => 'ul',
					'fallback_cb' => 'ocmx_fallback_secondary')
				); ?>
			</div>

			<p><?php echo get_option("ocmx_custom_footer"); ?></p>
			<?php if(get_option("ocmx_logo_hide") != "true") : ?>
				<div class="obox-credit">
				   <p><a href="http://oboxthemes.com/ecommerce">WordPress eCommerce Theme</a> by <a href="http://oboxthemes.com"><img src="<?php echo get_template_directory_uri(); ?>/images/obox-logo.png" alt="Theme created by Obox" /></a></p>
				</div>
			<?php endif; ?>
		</div>
	</div> <!--end Footer Base Container -->

</div><!--end Wrapper -->

<?php if(get_option("ocmx_backtop") != "true") : ?>
	<div id="back-top">
		<a href="#top"></a>
	</div>
<?php endif; ?>

<!--Get Google Analytics -->
<?php
	if(get_option("ocmx_googleAnalytics")) :
		echo stripslashes(get_option("ocmx_googleAnalytics"));
	endif;
?>

<?php wp_footer(); ?>
</body>
</html>

