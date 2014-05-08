<?php function ocmx_breadcrumbs($container_id = 'crumbs') {
	global $wp_query, $post;

	if(get_option("ocmx_breadcrumbs") == 'no')
		return; ?>

	<ul id="<?php echo $container_id; ?>">

		<?php /* Home */ ?>
		<li><a href="<?php echo home_url(); ?>"><?php _e('Home','ocmx'); ?></a></li>

		<?php

		/* Base Page
			- Shop
			- Search
			- Post type parent page
		*/
		if( is_search() ) { ?>
			<li> / </li>
			<li><?php _e('Search','ocmx'); ?></li>
		<?php } elseif( function_exists('is_shop') && ( is_post_type_archive( 'product' ) || ( get_post_type() == "product") ) ) { ?>
			<li> / </li>
			<?php if( function_exists( 'woocommerce_get_page_id' )  && '' != woocommerce_get_page_id('shop') ) {
				$shop_page = get_post( woocommerce_get_page_id('shop') ); ?>
				<li><a href="<?php echo get_permalink( $shop_page->ID ); ?>"><?php echo $shop_page->post_title; ?></a></li>
			<?php } else { ?>
				<li><a href=""><?php _e( 'Shop' , 'ocmx' ); ?></li>
			<?php }
		} elseif( is_post_type_archive() || is_singular() || is_tax() ) {
			// Get the post type object
			 $post_type = get_post_type_object( get_post_type() );

			// Check if we have the relevant information we need to query the page
			if( !empty( $post_type ) && isset( $post_type->labels->slug ) ) {

				// Query template
				$parentpage = get_template_link( $post_type->labels->slug .".php");

				// Display page if it has been found
				if( !empty( $parentpage ) ) { ?>
					<li> / </li>
					<li><a href="<?php echo get_permalink($parentpage->ID); ?>"><?php echo $parentpage->post_title; ?></a></li>
				<?php }
			};

		}

		/* Categories, Taxonomies & Parent Pages

			- Page parents
			- Category & Taxonomy parents
			- Category for current post
			- Taxonomy for current post
		*/

		if( is_page() ) {

			// Start with this page's parent ID
			$parent_id = $post->post_parent;

			// Loop through parent pages and grab their IDs
			while( $parent_id ) {
				$page = get_page($parent_id);
				$parent_pages[] = $page->ID;
				$parent_id = $page->post_parent;
			}

			// If there are parent pages, output them
			if( isset( $parent_pages ) && is_array($parent_pages) ) {
				$parent_pages = array_reverse($parent_pages);
				foreach ( $parent_pages as $post ) { ?>
					<!-- Parent page title -->
					<li> / </li>
					<li><a href="<?php echo get_permalink($page->ID); ?>"><?php echo get_the_title($page->ID); ?></a></li>
				<?php }
			}

 		} elseif( is_category() || is_tax() ) {

 			// Get the taxonomy object
 			if( is_category() ) {
 				$category_title = single_cat_title( "", false );
				$category_id = get_cat_ID( $category_title );
				$category_object = get_category( $category_id );
 				$term = $category_object->slug;
 				$taxonomy = 'category';
 			} else {
 				$term = get_query_var('term' );
 				$taxonomy = get_query_var( 'taxonomy' );
 			}

			$term = get_term_by( 'slug', $term , $taxonomy );

			// Start with this terms's parent ID
			$parent_id = $term->parent;

			// Loop through parent terms and grab their IDs
			while( $parent_id ) {
				$cat = get_term_by( 'id' , $parent_id , $taxonomy );
				$parent_terms[] = $cat->term_id;
				$parent_id = $cat->parent;
			}

			// If there are parent terms, output them
			if( isset( $parent_terms ) && is_array($parent_terms) ) {
				$parent_terms = array_reverse($parent_terms);

				foreach ( $parent_terms as $term_id ) {
					$term = get_term_by( 'id' , $term_id , $taxonomy ); ?>

					<li> / </li>
					<li><a href="<?php echo get_term_link( $term_id , $taxonomy ); ?>"><?php echo $term->name; ?></a></li>

				<?php }
			}

		} elseif ( is_single() && get_post_type() == 'post' ) {

			// Get all post categories but use the first one in the array
			$category_array = get_the_category();

			foreach ( $category_array as $category ) { ?>

				<li>/</li>
				<li><a href="<?php echo get_category_link( $category->term_id ); ?>"><?php echo get_cat_name( $category->term_id ); ?></a></li>

			<?php }

		} elseif( is_singular() ) {

			// Get the post type object
			$post_type = get_post_type_object( get_post_type() );

			// If this is a product, make sure we're using the right term slug
			if( is_post_type_archive( 'product' ) || ( get_post_type() == "product" ) ) {
				$taxonomy = 'product_cat';
			} elseif( !empty( $post_type ) && isset( $post_type->labels->slug ) ) {
				$taxonomy = $post_type->labels->slug . '-category';
			};

			// Get the terms
			$terms = get_the_terms( $post->ID, $taxonomy );

			// If this term is legal, proceed
			if( is_array( $terms ) ) {

				// Loop over the terms for this post
				foreach ( $terms as $term ) { ?>

					<li> / </li>
					<li><a href="<?php echo get_term_link( $term->slug, $taxonomy ); ?>"><?php echo $term->name; ?></a></li>

				<?php }
			}
		} ?>

		<?php /* Current Page / Post / Post Type

			- Page / Page / Post type title
			- Search term
			- Curreny Taxonomy
			- Current Tag
			- Current Category
		*/

		if( is_singular() ) { ?>

			<li>/</li>
			<li><span class="current"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span></li>

		<?php } elseif ( is_search() ) { ?>

			<li>/</li>
			<li><span class="current">"<?php the_search_query(); ?>"</span></li>

		<?php } elseif( is_tax() ) {

			// Get this term's details
			$term = get_term_by( 'slug', get_query_var('term' ), get_query_var( 'taxonomy' ) ); ?>

			<li>/</li>
			<li><span class="current"><?php echo $term->name; ?></span></li>

		<?php  } elseif( is_tag() ) { ?>

			<li>/</li>
			<li><span class="current"><?php echo single_tag_title(); ?></span></li>

		<?php } elseif( is_category() ) { ?>

			<li>/</li>
			<li><span class="current"><?php echo single_cat_title(); ?></span></li>

		<?php } elseif ( is_archive() && is_month() ) { ?>

			<li>/</li>
			<li><span class="current"><?php echo get_the_date( 'F Y' ); ?></span></li>

		<?php } elseif ( is_archive() && is_year() ) { ?>

			<li>/</li>
			<li><span class="current"><?php echo get_the_date( 'Y' ); ?></span></li>

		<?php } elseif ( is_archive() && is_author() ) { ?>

			<li>/</li>
			<li><span class="current"><?php echo get_the_author(); ?></span></li>

		<?php } ?>
	</ul>
<?php }