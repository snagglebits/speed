<?php
$options = get_option( 'clarity_theme_settings' );
?>
<?php get_header(); ?>

<div class="home-wrap clearfix">
    

<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
  'paged' => $paged
);

query_posts($args); 


// The Loop
while ( have_posts() ) : the_post(); ?><br> 

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

    <?php endwhile;
// Reset Query
wp_reset_query();
?>

<div class="home-post-nav">
<?php
global $wp_query;

$big = 999999999; // need an unlikely integer

echo paginate_links( array(
    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var('paged') ),
    'total' => $wp_query->max_num_pages
) );
?>

</div>

</div>
<!-- END home-wrap -->   
<?php get_footer(); ?>