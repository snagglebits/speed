<?php get_header(); ?>

<?php get_template_part('/functions/page-title'); ?>

<?php if (have_posts()) :
	while (have_posts()) : the_post(); setup_postdata($post);
	global $post; 
	$website = get_post_meta($post->ID, "website", true); 
	$terms = get_the_terms($post->ID, 'portfolio-category');
	$social = get_option("ocmx_meta_social_post"); ?>

	<div id="content" class="contained clearfix">
		<ul class="portfolio-content">
			<li id="left-column">    
				<div class="post-title-block">
					<h3 class="post-title"><a href="<?php echo $link; ?>"><?php the_title(); ?></a></h3>
				</div>
				
				<div class="copy clearfix">
					<?php the_content(); ?>
				</div>
				
				<ul class="portfolio-meta">
					<?php if($website !='') : ?>
						<li><a target="_blank" class="portfolio-website" href="<?php echo $website; ?>"><?php _e("View Website", "ocmx"); ?></a></li>
					<?php endif; ?>
					<?php if(!empty($terms)) : 
						foreach($terms as $term) :
							$term_link = get_term_link($term->slug, $term->taxonomy);
							if(!is_wp_error($term_link)) : ?>
								<li><a class="portfolio-category" href="<?php echo get_term_link($term->slug, $term->taxonomy); ?>"><?php echo $term->name; ?></a></li>
							<?php endif; 
						endforeach;
					endif; ?>
				</ul>
				
				<?php 
				$tagterms = get_the_terms($post->ID, 'portfolio-tag'); 
				if(!empty($tagterms)) : ?>
					<ul class="portfolio-tags">
					<?php foreach($tagterms as $tagterm) :
						$tagterm_link = get_term_link($tagterm->slug, $tagterm->taxonomy);
						if(!is_wp_error($tagterm_link)) : ?>
							<li><a class="portfolio-category" href="<?php echo get_term_link($tagterm->slug, $tagterm->taxonomy); ?>"><?php echo $tagterm->name; ?></a></li>
						<?php endif; 
					endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if( get_option("ocmx_social_tag") !="" ) : ?>
					<div class="social"><?php echo get_option("ocmx_social_tag"); ?></div> 
				 <?php elseif( $social != "false" ) : // Show sharing if enabled in Theme Options ?>
					<div class="social">
						<!-- AddThis Button BEGIN : Customize at http://www.addthis.com -->
						<div class="addthis_toolbox addthis_default_style ">
							<a class="addthis_button_facebook_like"></a>
							<a class="addthis_button_tweet"></a>
							<a class="addthis_counter addthis_pill_style"></a>
						</div>
						<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-507462e4620a0fff"></script>
						<!-- AddThis Button END -->
					</div>
				<?php endif; ?> 
			</li>
				
			<li id="right-column">
				<div class="gallery-slider clearfix">
					<?php if(obox_has_video($post->ID)):
						$args  = array('postid' => $post->ID, 'width' => 660, 'height' => 660, 'hide_href' => true, 'exclude_video' => false, 'imglink' => false, 'wrap' => 'div', 'wrap_class' => 'post-image fitvid');
						$image = get_obox_media($args);
						echo $image;
					else : ?>
						<ul class="gallery-container">
							<?php $attach_args = array("post_type" => "attachment", "post_parent" => $post->ID, "numberposts" => "-1", "orderby" => "menu_order", "order" => "ASC");
							$attachments = get_posts($attach_args);
							foreach($attachments as $attachement => $this_attachment) :  
								$image = wp_get_attachment_image_src($this_attachment->ID, "660auto");
								$full = wp_get_attachment_image_src($this_attachment->ID,  "full"); ?>
								<li>
									<a href="<?php echo $full[0]; ?>" rel="lightbox">
										<img src="<?php echo $image[0]; ?>" alt="<?php echo $this_attachment->post_title; ?>" />
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
						<?php if(count($attachments) > 1) : ?>
							<div class="controls"> 
								<a href="#" class="next"><?php _e("Next", "ocmx") ?></a> 
								<a href="#" class="previous"><?php _e("Previous", "ocmx") ?></a>
							</div> 
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</li>
		</ul>
	</div>
<?php endwhile; endif; ?>

<?php get_footer(); ?>