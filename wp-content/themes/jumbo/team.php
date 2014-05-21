<?php /* Template Name: Team */
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
		
		<ul class="grid <?php echo $layout; ?> team">
			<?php // Team Query
			$args = array( "post_type" => 'team', 'orderby' => 'menu_order', 'order' => 'ASC', 'post_status' => 'publish', 'showposts' => '-1' );
			$team = new WP_Query($args);
	
			while ( $team->have_posts() ) : $team->the_post(); 
				global $post;
				$args  = array('postid' => $post->ID, 'width' => 150, 'height' => 150, 'hide_href' => true, 'exclude_video' => true, 'imglink' => false, 'imgnocontainer' => true, 'resizer' => '1-1-medium');
				$image = get_obox_media($args); 
				$position = get_post_meta($post->ID, "position", true);
				$facebook = get_post_meta($post->ID, "facebook", true);
				$twitter = get_post_meta($post->ID, "twitter", true);
				$linkedin = get_post_meta($post->ID, "linkedin", true); ?>
				<li class="column">
					<?php if($image != '') : ?>
						<!--Show the Photo -->
						<div class="post-image">
							<a href="<?php the_permalink(); ?>"><?php echo $image; ?></a>
						</div>
					<?php endif; ?>
					<!--Show the Post Title -->
					<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<!--Show the Position, if it exists -->
					<?php if($position !='') : ?>
						<h5 class="position"><?php echo $position; ?></h5>
					<?php endif; ?>
					
					<div class="copy">
						<?php the_excerpt(); ?>
					</div>
					
					<?php if($facebook !='' || $twitter !='' || $linkedin !='') : ?>
						<!--Show Social Links -->                   
						<ul class="team-social clearfix">
							<?php if($facebook !='') : ?>
								<li>
									<a class="team-facebook" href="<?php echo $facebook; ?>">Facebook</a>
								</li>
							<?php endif; ?>
							<?php if($twitter !='') : ?>
								<li>
									<a class="team-twitter" href="<?php echo $twitter; ?>">Twitter</a>
								</li>
							<?php endif; ?>
							<?php if($linkedin !='') : ?>
								<li>
									<a class="team-linkedin" href="<?php echo $linkedin; ?>">Linkedin</a>
								</li>
							<?php endif; ?>
						</ul>
					<?php endif; ?>
                    
				</li>
				
			<?php endwhile; ?>
			
		</ul>
		
	</div>
	

<?php get_footer(); ?>