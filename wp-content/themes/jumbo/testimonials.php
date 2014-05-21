<?php
/*
Template Name: Testimonials 
*/

get_header(); 
$layout = get_post_meta($post->ID, "layout", true);
?>

	<?php get_template_part('/functions/page-title'); ?>
	
	<div id="content" class="non-contained clearfix">
		
		<?php 
		$content = get_the_content();
		if($content !="") : ?>
			<div class="copy page-feature-copy">
				<?php the_content(); ?>
			</div>
		<?php endif; ?>
		
		<ul class="grid <?php echo $layout; ?> testimonials">
		
			<?php $args = array(
				"post_type" => 'testimonials',
				'orderby' => 'menu_order', 
				'order' => 'ASC'
			);
			
			$testimonials = new WP_Query($args);
	
			while ( $testimonials->have_posts() ) : $testimonials->the_post(); 
				global $post;
				$args  = array('postid' => $post->ID, 'width' => 150, 'height' => 150, 'hide_href' => true, 'exclude_video' => true, 'imglink' => false, 'imgnocontainer' => true, 'resizer' => 'thumbnail');
				$image = get_obox_media($args); 
				$link = get_post_meta($post->ID, "link", true);
				?>
		
				<li class="column">
					<?php if(isset($image) && $image !='' ): ?>
						<div class="post-image">
							<?php if(isset($link) && $link !='' ): ?>
								<a target="_blank" href="<?php echo $link; ?>"><?php echo $image; ?></a>
							<?php else : ?>
								<?php echo $image; ?>
							<?php endif;?>
						</div>
					<?php endif;?>
					<div class="copy">
						<?php the_excerpt(); ?>
					</div>
					<h3 class="post-title">
						<?php if(isset($link) && $link !='' ): ?>
							<a target="_blank" href="<?php echo $link; ?>"><?php the_title(); ?></a>
						<?php else : ?>
							<?php the_title(); ?>
						<?php endif;?>
					</h3>
				</li>
				
			<?php endwhile; ?>
			
		</ul>
		
	</div>
	
<?php get_footer(); ?>