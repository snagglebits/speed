<?php
// Meta Arguments
if(!is_page()) :
	$date = get_option("ocmx_meta_date_post");
	$author = get_option("ocmx_meta_author_post");
else :
	$date = get_option("ocmx_meta_date_page");
	$author = get_option("ocmx_meta_author_page");
endif;

if( $date != "false" || $author != "false" )  : ?>
	<h5 class="post-date">
		<?php if( $author != "false" ) {_e("Posted by ", "ocmx"); ?> <?php the_author_posts_link();} // Hide the author unless enabled in Theme Options ?>
		<?php if( $date != "false" && $author != "false" ) {_e(" | ", "ocmx"); } if( $date != "false") { echo the_time(get_option('date_format'));} //Hide the date ?>
	</h5>
<?php endif; ?>
