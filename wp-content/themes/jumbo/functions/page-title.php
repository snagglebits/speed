<?php if(get_option("ocmx_hide_title") !="no") {
	$parentpage = get_template_link(get_post_type().".php");
	$pagetitle_copy = get_option("ocmx_pagetitle_copy");

	if (class_exists( 'Woocommerce' )) { if(function_exists('is_shop') && ( is_shop() || is_product() ) ) : ?>
		<div id="title-container">
			<div class="title-block">
				<?php 
				$shop_page_id = woocommerce_get_page_id('shop');
				$shop_title = get_post( $shop_page_id ); 
				if( !is_object( $shop_title ) ) { ?>
					<h2><?php _e( 'Shop' , 'ocmx' ); ?></h2>
				<?php } else { ?>
					<h2><?php echo $shop_title->post_title; ?></h2>
				<?php }?>
			</div>
		</div>
	<?php endif; } ?>
	<?php if(!is_page() && get_query_var('term' ) != '' ) :
		$term = get_term_by( 'slug', get_query_var('term' ), get_query_var( 'taxonomy' ) ); ?>
		<div id="title-container">
			<div class="title-block">
				<h2><?php echo $term->name; ?></h2>
				<?php if($pagetitle_copy !="no") :
					if ( !empty( $term->description) ) :
						echo '<p>'.$term->description.'</p>';
					else :
						false;
					endif;
				endif; ?>
			</div>
		</div>
	<?php elseif(!empty($parentpage) && !is_search()) : 
		$parentpage = get_template_link(get_post_type().".php"); 
		$pagetitle_copy = get_option("ocmx_pagetitle_copy"); ?>
		<div id="title-container">
			<div class="title-block">
				<h2><?php echo $parentpage->post_title; ?></h2>
				<?php if($pagetitle_copy !="no") :
					if($parentpage->post_excerpt != '') : echo '<p>'.$parentpage->post_excerpt.'</p>'; endif;
				endif; ?>
			</div>
		</div>
	<?php elseif( get_post_type() == "post" && is_category() || is_search()) : ?>
		<div id="title-container">
			<div class="title-block">
				<h2><?php wp_title(''); ?></h2>
				<?php if($pagetitle_copy !="no") :
					echo category_description();
				endif; ?>
			</div>
		</div>
	<?php elseif(get_post_type() == "post" && is_single()) : ?>
		<div id="title-container">
			<div class="title-block">
				<h2><?php $category = get_the_category(); echo $category[0]->cat_name; ?></h2>
				<?php if($pagetitle_copy !="no") :
					echo category_description();
				endif; ?>
			</div>
		</div>
	<?php else : ?>
		<?php while ( have_posts() ) : the_post(); 
			$header_bg_image = get_post_meta($post->ID, "header_image", true);
			$header_bg_attributes = get_post_meta($post->ID, "header_image_attributes", true);
			if($header_bg_image  != '' || !empty($header_bg_attributes["colour"]) || is_page()) : ?>
			<div id="title-container">
				<div class="title-block">
					<h2><?php the_title(); ?></h2>
					<?php if($pagetitle_copy !="no") :
						// Check if we're using a real excerpt or the content
						if( $post->post_excerpt != "") :
							$excerpt = get_the_excerpt();
							$excerpttext = strip_tags( $excerpt );
						endif;
						
						// If the Excerpt exists, continue
						if(isset($excerpttext) && $excerpttext != "" ) :

						// Use an ellipsis if the excerpt is longer than the count
							echo '<p>'.$excerpttext.'</p>';
						endif;	
					endif; ?>
				</div>
			</div>
		<?php endif;
		endwhile; ?>
	<?php endif; 
} ?>

<div id="crumbs-container">
	<?php ocmx_breadcrumbs(); ?>
</div>