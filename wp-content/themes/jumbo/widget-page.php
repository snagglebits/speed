<?php 
/* Template Name: Widgetized Page */
get_header();
global $post; 
$widgetpageslug = $post->post_name; 
$title_display = get_post_meta($post->ID, "title-display", true);
?>
<!--Display Slider unless Title is set in Page Options -->
<?php if(isset($title_display) && $title_display == 'slider') {
		dynamic_sidebar($widgetpageslug." Slider"); }
	else {  
		get_template_part('/functions/page-title'); ?>
<?php } ?>

<div id="<?php if(isset($title_display) && $title_display == 'slider') {echo 'widget-block'; } else{ echo 'widgetized-widget-block';} ?>" class="clearfix">
	<!--Display Widgetized Home Widgets -->
	<ul class="widget-list clearfix" id="home_page_downs">
		<?php dynamic_sidebar( $widgetpageslug."-body" ); ?>
	</ul>
	
	<?php if(is_active_sidebar( $widgetpageslug."-secondary" )) : // Sidebar 2 Column ?>
		<ul class="widget-list clearfix" id="home_page_sides">
			<?php dynamic_sidebar( $widgetpageslug."-secondary" ); ?>
		</ul>
	<?php endif;

	if(is_active_sidebar( $widgetpageslug."-threecol" ) ) : // Sidebar 3 Column ?>
		<ul class="widget-list clearfix" id="home_page_three_column">
			<?php dynamic_sidebar( $widgetpageslug."-threecol" ); ?>
		</ul>
	<?php endif; ?>
</div>

<?php get_footer(); ?>