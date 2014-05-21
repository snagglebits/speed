<?php get_header(); ?>

<div class="post full-width clearfix">

<div id="fourohhfour-page">
	<h1>404 error!!!</h1>			
	<p>
	<?php _e('Sorry, the page you were looking for could not be found. <br> <br> Try either checking the URL for errors or visiting the'); ?> <a href="<?php echo home_url() ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php _e('homepage'); ?></a>.
    </p> 
</div>

</div>

<?php get_footer(); ?>