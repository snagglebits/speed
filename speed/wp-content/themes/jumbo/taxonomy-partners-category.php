<?php get_header(); ?>

	<?php get_template_part('/functions/page-title'); ?>

	<div id="content" class="clearfix">
		<ul class="grid three-column partners">

			<?php if (have_posts()) : while (have_posts()) : the_post();
				global $post;
				$args  = array('postid' => $post->ID, 'width' => 490, 'height' => 368, 'hide_href' => true, 'exclude_video' => true, 'imglink' => false, 'imgnocontainer' => true, 'resizer' => '4-3-medium');
				$image = get_obox_media($args); 
				$link = get_post_meta($post->ID, "link", true); ?>
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
					<h3 class="post-title">
						<?php if(isset($link) && $link !='' ): ?>
							<a target="_blank" href="<?php echo $link; ?>"><?php the_title(); ?></a>
						<?php else : ?>
							<?php the_title(); ?>
						<?php endif;?>
					</h3>
					<div class="copy">
						<?php the_excerpt(); ?>
					</div>
				</li>

				<?php endwhile;
			else :
				get_template_part("/functions/post-empty");
			endif; ?>

		</ul>

	</div>

<?php get_footer(); ?>