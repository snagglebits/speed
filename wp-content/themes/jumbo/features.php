<?php
/*
	Template Name: Features
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

	<div id="content" class="contained clearfix">
		<div class="features-content">
			<div id="left-column">
				<ul class="post-content">
					<?php while ( $features->have_posts() ) : $features->the_post();
						if(is_single()) :
							$selected = $wp_query->get_queried_object_id();
						elseif(!isset($_GET["view-service"]) && !isset($j)) :
							$selected = $post->ID;
						elseif (isset($_GET["view-service"]) && $_GET["view-service"] == $post->post_name) :
							$selected = $post->ID;
						endif;

						$args  = array('postid' => $features->post->ID, 'width' => 400, 'height' => 225, 'hide_href' => true, 'exclude_video' => true, 'imglink' => false, 'imgnocontainer' => true, 'resizer' => '4-3-medium');
						$image = get_obox_media($args); ?>
							<li class="feature-block <?php if($selected != $post->ID) : ?>no_display<?php endif; ?>">
							<div class="service-title-block">
								<h3 class="service-title">
									<?php the_title(); ?>
								</h3>
							</div>
							<div class="post-image">
								<?php echo $image; ?>
							</div>
							<div class="copy">
								<?php the_content(); ?>
							</div>
						</li>

						<?php $j=0; ?>
					<?php endwhile; ?>
				</ul>
			</div>
			<div id="right-column">
				<div class="related-features-container">
					<ul class="related-features features-title-list">
						<?php while ( $features->have_posts() ) : $features->the_post();
							$icon = get_post_meta( $post->ID, 'icon', true ); ?>

							<li <?php if( isset ( $selected ) && $selected == $post->ID ) : ?>class="active"<?php endif; ?>>
								<?php if($icon !="") : ?>
									<span class="features-list-icon">
										<img src="<?php echo $icon; ?>" alt="" />
									</span>
								<?php endif; ?>
								<a href="#"><?php the_title(); ?></a>
							</li>
						<?php $i=0; endwhile; ?>
					</ul>
				</div>
			</div> <!-- END #right-column -->
		</div>
	</div> <!-- END #content -->
<?php get_footer(); ?>