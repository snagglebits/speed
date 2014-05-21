<?php get_header(); ?>

<div id="title-container">
    <div class="title-block">
        <h2><?php _e("(404) The page you are looking for does not exist.", "ocmx"); ?></h2>
    </div>
</div>

<div id="content" class="clearfix">
    <div id="left-column">
        <ul class="post-list">
        	<?php $wpquery = new WP_Query(array('post_type' => 'post')); ?>
			<?php if ($wpquery->have_posts()) :
                while ($wpquery->have_posts()) :
                	$wpquery->the_post(); setup_postdata($post);
					get_template_part("/functions/post-list");
                endwhile;
            else :
                get_template_part("/functions/post-empty");
            endif; ?>
        </ul>
        <?php motionpic_pagination("clearfix", "pagination clearfix"); ?>
    </div>

    <?php if(get_option("ocmx_sidebar_layout") != "sidebarnone"): ?>
        <?php get_sidebar(); ?>
    <?php endif;?>
</div>

<?php get_footer(); ?>