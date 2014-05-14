<?php /* Template Name: Portfolio List */
get_header();
$layout = get_post_meta($post->ID, "layout", true);
if($layout == '' ) $layout = 'two-column'; 
$show_excerpts = get_post_meta($post->ID, "excerpt_display", true);
$excerpt_length = get_post_meta($post->ID, "excerpt_length", true);

$cat_list = get_terms("portfolio-category", "orderby=count&hide_empty=0");

$orderby = get_post_meta($post->ID, "orderby", true);
$order = get_post_meta($post->ID, "order", true);

$args = array( 
	"post_type" => "portfolio", 
	"orderby" => $orderby, 
	"order" => $order, 
	"post_status" => "publish", 
	"showposts" => "-1"
);

$portfolio = new WP_Query($args);
?>

	<?php get_template_part('/functions/page-title'); ?>

	<div id="content" class="contained clearfix">
		<?php // Query Portfolio Categories
		if ( $cat_list != "" ) : ?>
			<ul class="portfolio-categories">
				<?php foreach($cat_list as $tax) :
					$link = get_term_link($tax->slug, "portfolio-category");
					echo "<li><a href=\"$link\">".$tax->name."</a></li>";
				endforeach; ?>
			</ul>
		<?php endif; ?>
		<ul class="<?php echo $layout ;?> portfolio-list clearfix">
			<?php // Portfolio Query
			while ($portfolio->have_posts() ) : $portfolio->the_post();
				get_template_part("functions/portfolio-list"); ?>
			<?php endwhile; ?>
		</ul>
	</div>

<?php get_footer(); ?>