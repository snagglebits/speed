<?php 
/* Template Name: Full Width */
get_header(); 
$fullwidth = 1;
?>
	
<?php get_template_part('/functions/page-title'); ?>

<div id="content" class="clearfix">
	<ul id="full-width" class="clearfix">                    
		<?php if (have_posts()) :
			global $post;
			while (have_posts()) : the_post(); setup_postdata($post);
				get_template_part("/functions/post-view");
			endwhile;
		else :
			ocmx_no_posts();
		endif; ?> 
			<?php if(comments_open()) { comments_template(); }?>
	</ul>
</div>
<?php get_footer(); ?>