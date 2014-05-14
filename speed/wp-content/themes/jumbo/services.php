<?php /* Template Name: Services  */
get_header();
$layout = get_post_meta($post->ID, "layout", true);
if($layout == '' ) $layout = 'two-column'; ?>

	<?php get_template_part('/functions/page-title'); ?>
	
	<div id="content" class="non-contained clearfix">
		
		<?php 
		$content = get_the_content();
		if($content !="") : ?>
			<div class="copy page-feature-copy">
				<?php the_content(); ?>
			</div>
		<?php endif; ?>
		
		<ul class="grid <?php echo $layout; ?> services">
			
			<?php
			$service_cat = get_post_meta( $post->ID, 'services-category', true );

			if(isset($service_cat) && $service_cat =="") :
				$service_cat = 0;
			endif;

			// Services Query

			if(isset($service_cat) && $service_cat != "0") :
				$args = array(
					"post_type" => 'services',
					"posts_per_page" => -1,
					"orderby" => "menu_order",
					"order" => "ASC",
					"tax_query" => array(
						array(
							"taxonomy" => 'services-category',
							"field" => "slug",
							"terms" => $service_cat

						)
					)
				);
			else :
				$args = array(
					"post_type" => 'services',
					"posts_per_page" => -1,
					"orderby" => "menu_order",
					"order" => "ASC",
				);
			endif;

			$services = new WP_Query($args);
	
			while ( $services->have_posts() ) : $services->the_post(); 
				global $post;
				$icon = get_post_meta( $post->ID, 'icon', true );
				if($icon == '') :
					$args  = array('postid' => $post->ID, 'width' => 400, 'height' => 225, 'hide_href' => true, 'exclude_video' => true, 'imglink' => false, 'imgnocontainer' => true, 'resizer' => '4-3-medium');
					$image = get_obox_media($args); 
				endif; ?>
		
				<li class="column">
					<a class="post-image" href="<?php echo get_permalink($post->ID); ?>">
						<?php if(isset($image)): ?>
							<?php echo $image; ?>
						<?php elseif($icon != '') : ?>
							<img src="<?php echo $icon; ?>" alt="<?php the_title(); ?>" /> 
						<?php endif; ?>
					</a>
					<div class="content">
						<h4 class="post-title"><a href="<?php echo get_permalink($post->ID); ?>"><?php the_title(); ?></a></h4>
						<div class="copy">
							<?php the_excerpt(); ?>
						</div>
					</div>
				</li>
			<?php endwhile; ?>
		</ul>
	</div>
	
<?php get_footer(); ?>