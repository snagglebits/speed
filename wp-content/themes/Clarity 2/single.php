<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<!--header id="page-heading">	
	<nav id="single-nav" class="clearfix">
	
    	<?php next_post_link('<div id="single-nav-left">%link</div>', '<span class="awesome-icon-chevron-left"></span> '.__('Newer','clarity').'', false); ?>
		<?php previous_post_link('<div id="single-nav-right">%link</div>', ''.__('Older','clarity').' <span class="awesome-icon-chevron-right"></span>', false); ?>
    
    </nav>	
</header-->


<article class="post clearfix">
    <article class="home-entry">
                <div class="home-entry-description">


<?php
if ( has_post_thumbnail() ) {the_post_thumbnail();
} 
 ?>

	<header>

        <h1 class="single-title"><?php the_title(); ?></h1>
        <div class="post-meta">
            <span class="awesome-icon-calendar"></span><?php _e('On','surplus'); ?> <?php the_time('j'); ?> <?php the_time('M'); ?>, <?php the_time('Y'); ?>
            <span class="awesome-icon-user"></span><?php _e('By', 'surplus'); ?> <?php the_author_posts_link(); ?>
        </div>
        <!-- /loop-entry-meta -->
    </header>

    <div class="entry clearfix">
		<?php the_content(); ?>
        <div class="clear"></div>
        
        <?php wp_link_pages(' '); ?>
         
        <div class="post-bottom">
        	<?php the_tags('<div class="post-tags"><span class="awesome-icon-tags"></span>',' , ','</div>'); ?>
        </div>
        <!-- /post-bottom -->


<!-- Twitter Start -->
    <div class="twitterlinks">
    <a title="<?php the_title(); ?>" href="http://twitter.com/share?text=<?php the_title(); ?> - <?php the_permalink(); ?>" target="_blank" rel="nofollow">Tweet This Post</a></div>
    </div>
<!-- Twitter End -->





<div class="navigation">
<div class="alignleft"> <?php previous_post('&laquo; &laquo; %', '', 'yes'); ?></div>
<div class="alignright"> <?php next_post('% &raquo; &raquo; ','', 'yes'); ?></div>
</div> <!-- end navigation -->

        </div>


        </div>
        </div>
        <!-- /entry -->
	
		<!--?php comments_template(); ?-->
   
</article>
<!-- /post -->

<?php endwhile; ?>
<?php endif; ?>
             
<?php get_footer(); ?>