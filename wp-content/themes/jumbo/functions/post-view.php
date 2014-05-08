<?php global $post, $post_type, $fullwidth;
$layout = get_option( "ocmx_sidebar_layout" );
if($fullwidth =1 || isset($layout) && $layout == 'sidebarnone') :
	$resizer = '1000auto';
	$width = '1000';
else :
	$resizer = '660auto';
	$width = '660';
endif;


$args  = array('postid' => $post->ID, 'width' => $width, 'hide_href' => true, 'exclude_video' => false, 'imglink' => false, 'wrap' => 'div', 'wrap_class' => 'post-image fitvid', 'resizer' => $resizer);
$image = get_obox_media($args);

?>
<li id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
	<div class="post-content clearfix">
		<div class="post-title-block">
			<?php
			if ( show_meta() ) {
				get_template_part("/functions/post-title-meta");
			} // if can_show_meta
			?>

			<?php if(!is_page()) : ?>
				<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php endif; ?>
		</div>

		<?php echo $image; ?>

		<div class="copy">
			<?php the_content(); ?>
			<?php wp_link_pages(); ?>
		</div>

		<?php
		if ( show_meta() ) {
			get_template_part( "/functions/post-meta" );
		} // if can_show_meta
		?>
	</div>
</li>