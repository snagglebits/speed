<?php
/* Template Functions */
function ocmx_page_header($before = "<h2>", $after = "</h2>"){
	global $is_archive, $gallery_title, $wp, $post;

	if($gallery_title) : ?>
		<?php echo $before.$gallery_title.$after; ?>

	<?php elseif($is_archive) :?>
		<?php echo $before._("Archives", "ocmx").$after; ?>

	<?php elseif(is_404()) : ?>
		<?php echo $before._("Page Not Found", "ocmx").$after; ?>

	<?php elseif(is_category()) : ?>
		<?php $cat_id = get_query_var("cat"); ?>
		<?php $category = get_category($cat_id); ?>
			<?php echo $before; ?><a href="<?php echo get_category_link($category->cat_ID); ?>"><?php single_cat_title(); ?></a><?php echo $after; ?>

	<?php elseif (is_search()) : ?>
		<?php echo $before._("Your Search Results for:", "ocmx"); ?> "<em><?php the_search_query(); ?></em>"<?php echo $after; ?>

	<?php elseif(is_tag()):
		single_tag_title();

	elseif(is_page()) :
		if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php echo $before; ?>
				<a href="<?php the_permalink(); ?>">
					<?php the_title(); ?>
				</a>
			<?php echo $after;
		endwhile; endif;

	elseif(get_post_type($post) == "portfolio") :
		echo $before._("Portfolio", "ocmx").$after;

	elseif(get_post_type($post) == "quotes") :
	elseif(get_post_type($post) == "feature") :
		echo $before._("Features", "ocmx").$after;

	elseif(get_post_type($post) == "quotes") :
	elseif(get_post_type($post) == "services") :
		echo $before._("Services", "ocmx").$after;

	elseif(get_post_type($post) == "quotes") :
		echo $before.get_option("ocmx_home_quotes_title").$after;

	elseif(is_single()) :
		$category = get_the_category();
		if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php echo $before; ?>
				<a href="<?php echo get_category_link($category[0]->cat_ID); ?>"><?php echo $category[0]->cat_name; ?></a>
			<?php echo $after; ?>
	<?php endwhile; endif;

	elseif(get_post_type($post) == "feature") :
		echo $before._("Features", "ocmx").$after;
	elseif(get_post_type($post) == "portfolio") :
		echo $before._("Portfolio", "ocmx").$after;
	elseif(is_archive()) : ?>
		<?php echo $before.get_query_var("y"). " - ".get_query_var("m").$after; ?>
	<?php endif; ?>

<?php }
function fetch_post_image($use_id, $width, $height)
	{
		$attach_args = array("post_type" => "attachment", "post_parent" => $use_id);
		$attachments = get_posts($attach_args);
		$attach_id = $attachments[0]->ID;
		return  wp_get_attachment_image($attach_id, array($width, $height));
	}

function fetch_post_tags($post_id)
	{
		global $wpdb;
		$tags = $wpdb->get_results("SELECT $wpdb->term_relationships.*, $wpdb->terms.* FROM $wpdb->terms INNER JOIN $wpdb->term_relationships ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->terms.term_id WHERE $wpdb->term_relationships.object_id = ".$post_id);
		foreach($tags as $posttag) :
			if(!isset($tag_list)) :
				$tag_list = $posttag->name;
			else :
				$tag_list .= ", ".$posttag->name;
			endif;
		endforeach;
		return isset($tag_list);
	}

function ocmx_pagination($container_class = "clearfix", $ul_class = "clearfix")
	{
		global $wp_query;
		$request = $wp_query->request;
		$showpages = 12;
		$numposts = $wp_query->found_posts;
		$pagenum = (ceil($numposts/get_option("posts_per_page")));
		$currentpage = get_query_var('paged');

		if($pagenum < $showpages) :
			$maxpages = $pagenum;
		elseif($currentpage > $showpages) :
			$startrow = ($currentpage-1);
			$maxpages = ($startrow + $showpages - 1);
			if($maxpages > $pagenum) :
				$startrow = ($startrow - ($maxpages - $pagenum));
				$maxpages = ($maxpages - ($maxpages - $pagenum));
			endif;
		else :
			$startrow = 1;
			$maxpages  = $showpages;
		endif;

		if((get_option("posts_per_page") && $numposts !== 0) && $numposts > get_option("posts_per_page")) :
?>
	 <div class="<?php echo $container_class; ?>">
		<ul class="<?php echo $ul_class; ?>">
			<?php if($currentpage !== 0) : ?>
				<li class="previous-page"><?php previous_posts_link("Previous", "ocmx"); ?></li>
			<?php endif;

			for($i = $startrow; $i <= $maxpages; $i++) : ?>
				<li><a href="<?php echo esc_url(get_pagenum_link($i)); ?>" class="<?php if($i == $currentpage || ($i == 1 && $currentpage == "")) :?>selected-page<?php else : ?>other-page<?php endif; ?>"><?php echo $i; ?></a></li>
			<?php endfor;

			if($maxpages < $pagenum) : ?>
				<li><a href="<?php echo esc_url(get_pagenum_link($pagenum)); ?>" class="other-page"><?php echo $pagenum; ?></a></li>
			<?php endif;

			if($currentpage !== ceil($numposts/get_option("posts_per_page"))) : ?>
				<li class="next-page"><?php next_posts_link("Next", "ocmx"); ?></li>
			<?php endif; ?>
		</ul>
	</div>
<?php
		endif;
	}

if(!function_exists("fetch_related_posts")) :
	function fetch_related_posts(){
		//Gets category and author info
		global $wp_query,$post;
		$cats = get_the_category();
		$postAuthor = $post->post_author;
		$currentId = $post->ID;
		// related category posts
		$catlist = "";
		foreach ( $cats as $c ) :
			if( $catlist != "" ) :
				$catlist .= ",";
			endif;
			$catlist .= $c->cat_ID;
		endforeach;
		$newQuery = "posts_per_page=5&cat=" . $catlist."&exclude=".$currentId;
		$catQuery = get_posts( $newQuery );
		$categoryPosts = "";
		$count = 0;
		$original_post = $post;
		foreach($catQuery as $related_post) :
			//Set the post ID for the image
			$post = $related_post;
			$image = get_obox_image(60, 40, '', '', '');

			echo "<li>".
				$image.
				"<a href=\"".get_permalink($related_post->ID)."\">".
					$related_post->post_title.
				"</a>
			</li>";
		endforeach;
		$post = $original_post;
	}
endif;

if(!function_exists("get_template_link")) :

	/*****************************************************************************/
	/* This Function Fetches the Post associated to the speciofied Page Template */
	function get_template_link($page){
		global $wpdb;

		$get_meta = $wpdb->get_row("SELECT * FROM ".$wpdb->postmeta." WHERE `meta_key` = '_wp_page_template' AND  `meta_value` = '".$page."'");
		if(isset($get_meta->post_id))
			$post = get_post($get_meta->post_id);
		else
			$post = null;
		return $post;
	}
endif;

if( !function_exists( 'get_fbimage' )) {
	function get_fbimage() {
		global $post;
		if( ! isset( $post ) )
			return;

		$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '', '' );
		$fbimage = null;

		if ( has_post_thumbnail($post->ID) ) {
			$fbimage = $src[0];
		} else {
			global $post, $posts;
			$fbimage = '';
			$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i',
			$post->post_content, $matches);
			if(!empty($matches[1]))
				$fbimage = $matches [1] [0];
		}
		if(empty($fbimage)) {
			$fbimage = get_the_post_thumbnail($post->ID);
		}
		return $fbimage;
	}
}; // if function_exists get_fb_image