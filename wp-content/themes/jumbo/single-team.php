<?php get_header();
global $post;
?>
	
	<?php get_template_part('/functions/page-title'); ?>
  
	<div id="content" class="clearfix">
		<div id="left-column">
			<ul class="post-list">
			<?php if (have_posts()) : while (have_posts()) : the_post(); setup_postdata($post); 
				$args  = array('postid' => $post->ID, 'width' => 320, 'hide_href' => false, 'exclude_video' => true, 'imglink' => false, 'imgnocontainer' => true, 'resizer' => '660auto');
				$image = get_obox_media($args); 
				$position = get_post_meta($post->ID, "position", true);
				$facebook = get_post_meta($post->ID, "facebook", true);
				$twitter = get_post_meta($post->ID, "twitter", true);
				$linkedin = get_post_meta($post->ID, "linkedin", true); 
				$parentpage = get_template_link("team.php"); ?>

				<li id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
					<div class="post-content clearfix">

						<div class="post-image">
							<?php echo $image;?>
						</div>
                        
                        <div class="team-content">
                            <div class="team-title-block">
                                <h3 class="team-title">
                                    <?php the_title(); ?>
                                </h3>
                                <?php if($position !='') : ?>
                                    <p class="position"><?php echo $position; ?></p>
                                <?php endif; ?>
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
                            
                            <div class="copy">
                                <?php the_content(); ?>
                            </div>
                        </div>
					</div>
				</li>
			<?php endwhile;
			else :
				ocmx_no_posts();
			endif; ?>
			</ul>
		
		</div><!--End  Left Column -->

		<?php if(get_option("ocmx_sidebar_layout") != "sidebarnone"): ?>
		
			<div id="right-column">
				<div class="team-members-container">
					<h4 class="widgettitle"><?php echo $parentpage->post_title; ?></h4>
					<ul class="team-members">
						<?php 
						$args = array( 'post_type' => 'team', 'post_status' => 'publish', 'orderby' => 'menu_order',  'order' => 'ASC', "posts_per_page" => '-1',
							'post__not_in' => array( $post->ID ) // $post *should* be the featured review, since it was the last post queried/worked on 
						);
					   
						$team_members = new WP_Query($args);
		
						while ( $team_members->have_posts() ) : $team_members->the_post(); 
							$args  = array('postid' => $post->ID, 'width' => 50, 'height' => 38, 'hide_href' => true, 'exclude_video' => true, 'imglink' => false, 'imgnocontainer' => true, 'resizer' => '50x38');
							$image = get_obox_media($args); 
							$position = get_post_meta($post->ID, "position", true); ?>
							<li>
								<?php echo $image; ?>
								<div class="team-member">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									<?php if($position !='') : ?>
										<span class="team-position"><?php echo $position; ?></span>
									<?php endif; ?>
								</div>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
			</div> <!-- END #right-column -->

		<?php endif;?>
		
	</div><!--End Content -->
	
<?php get_footer(); ?>