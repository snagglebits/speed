<?php get_header(); ?>
<?php if (have_posts()) : ?>

<div id="page-heading">
		<?php
        if(isset($_GET['author_name'])) :
        $curauth = get_userdatabylogin($author_name);
        else :
        $curauth = get_userdata(intval($author));
        endif;
        ?>
        <h1><?php _e('Posts by',''); ?>: <?php echo $curauth->nickname; ?></h1>		
</div>
<!-- END page-heading -->

<div id="post" class="post clearfix">

	<!--?php get_template_part('loop', 'entry') ?-->


 
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?><br> 

        <header>
        <h1 class="single-title-home"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo the_title(); ?></a></h1>
        <div class="post-meta">
            <span class="awesome-icon-calendar"></span><?php _e('On','surplus'); ?> <?php the_time('j'); ?> <?php the_time('M'); ?>, <?php the_time('Y'); ?>
            <span class="awesome-icon-user"></span><?php _e('By', 'surplus'); ?> <?php the_author_posts_link(); ?>
        </div>
        <!-- /loop-entry-meta -->
        </header>

        <div class="entry clearfix">
        <?php echo excerpt('300'); ?>
        <div class="clear"></div>
        <h4 class="read-more"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Read more</a></h4>
        </div>

    <?php endwhile; else: ?><br>  
    <p><?php _e('Currently No posts by this author.'); ?></p><br>  
    <br>  
    <?php endif; ?><br>
	<?php
    //get pagination
	if (function_exists("pagination")) { pagination(); } ?>
</div>
<!-- END #post -->
<?php endif; ?>   
<?php get_footer(); ?>