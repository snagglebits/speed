<?php
/*
	Template Name: Features Alternate
*/

get_header();

	get_template_part('/functions/page-title'); 

	$feature_cat = get_post_meta( $post->ID, 'features-category', true );

	if(isset($feature_cat) && $feature_cat =="") :
		$feature_cat = 0;
	endif;

	// Features Query

	if(isset($feature_cat) && $feature_cat != "0") :
		$args = array(
			"post_type" => 'features',
			"posts_per_page" => -1,
			"orderby" => "menu_order",
			"order" => "ASC",
			"tax_query" => array(
				array(
					"taxonomy" => 'features-category',
					"field" => "slug",
					"terms" => $feature_cat

				)
			)
		);
	else :
		$args = array(
			"post_type" => 'features',
			"posts_per_page" => -1,
			"orderby" => "menu_order",
			"order" => "ASC",
		);
	endif;

	$features = new WP_Query($args); ?>
	
	<div id="content" class="features-widget widget clearfix">

		<ul class="features-widget-item clearfix">

			<?php while ( $features->have_posts() ) : $features->the_post();
				global $post;
				$image_position  = get_post_meta($post->ID, "image_position", true);
				if($image_position == '') $image_position = 'image-right';

				$width = 490;
				$height = 368;

				if($image_position == 'image-only' || $image_position == 'image-title' )
					$resizer = 'large';
				else
					$resizer = '4-3-medium';

				$link = get_post_meta($post->ID, "link", true);
				$buttontext = get_post_meta($post->ID, "button", true);
				$buttoncolour = get_post_meta($post->ID, "button_colour", true);

				$image_args  = array('postid' => $post->ID, 'width' => $width, 'height' => $height, 'hide_href' => false, 'exclude_video' => true, 'wrap' => 'div', 'wrap_class' => 'post-image fitvid', 'imglink' => false, 'resizer' => $resizer);
				$image = get_obox_media($image_args); ?>

				<li class="column <?php echo $image_position; ?>">

					<div class="content">
						<?php if($image_position != "image-only") : ?>
							<div class="feature-content">
								<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

								<h5><?php echo $post->post_excerpt; ?></h5>

								<div class="copy">
									<?php the_content(); ?>
								</div>

								<?php if($link !='') : ?>
									<a class="action-link" href="<?php echo $link; ?>" <?php if($buttoncolour != '') : ?>style="background: <?php echo $buttoncolour; ?>;"<?php endif; ?>><?php echo $buttontext; ?></a>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if($image != ""):
							echo $image;
						endif; ?>
					</div>

				</li>
			<?php endwhile; ?>
		</ul>
	</div>

<?php get_footer(); ?>