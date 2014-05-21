<?php get_header(); ?>

	<?php get_template_part('/functions/page-title'); ?>

	<div id="content" class="clearfix">
		<ul class="grid three-column services">
			<?php if (have_posts()) : while (have_posts()) : the_post();
				global $post;
				$link = get_permalink($post->ID);
				$args  = array('postid' => $post->ID, 'width' => 400, 'height' => 225, 'hide_href' => true, 'exclude_video' => true, 'imglink' => false, 'imgnocontainer' => true, 'resizer' => '4-3-medium');
				$image = get_obox_media($args);
				$icon = get_post_meta( $post->ID, 'icon', true );
				?>

				<li class="column">
					<a class="post-image" href="<?php the_permalink(); ?>">
						<?php if($icon !='') : ?>
							<img src="<?php echo $icon; ?>" alt="" />
						<?php else: ?>
							<?php echo $image; ?>
						<?php endif; ?>
					</a>
					<div class="content">
						<h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						<div class="copy"><?php the_excerpt(); ?></div>
					</div>
				</li>

				<?php endwhile;
			else :
				get_template_part("/functions/post-empty");
			endif; ?>

		</ul>

	</div>

<?php get_footer(); ?>