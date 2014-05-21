<?php global $layout, $show_excerpts, $excerpt_length;
	$link = get_permalink($post->ID); 
	if($layout == "one-column") :
		$width = 980;
		$height = 735;
		$resizer = '1000auto';
	else :
		$width = 480;
		$height = 460;
		$resizer = '4-3-medium';
	endif;
	
	if($layout == 'one-column' || $layout == 'two-column')
		$exclude_video = 0;
	else
		$exclude_video = 1;
		
	$args  = array( 'postid' => $post->ID, 'width' => $width, 'height' => $height, 'hide_href' => false, 'exclude_video' => $exclude_video, 'wrap' => 'div', 'wrap_class' => 'post-image fitvid', 'resizer' => $resizer );
	$image = get_obox_media($args); 

	?>
	
<li class="column">
	<?php if($image !="")
		echo $image; ?>   
	<div class="content">
		<h4 class="post-title"><a href="<?php echo $link; ?>"><?php the_title(); ?></a></h4>
		<?php if(isset( $show_excerpts ) && $show_excerpts == "yes" ) :
			// Check if we're using a real excerpt or the content
			if( $post->post_excerpt != "") :
				$excerpt = get_the_excerpt();
				$excerpttext = strip_tags( $excerpt );
			else :
				$content = get_the_content();
				$excerpttext = strip_tags($content);
			endif;
				
			// If the Excerpt exists, continue
			if( $excerpttext != "" ) :
				// Check how long the excerpt is
				$counter = strlen( $excerpttext );
				
				// If we've set a limit on the excerpt, put it into play
				if( !isset( $excerpt_length ) || ( isset ($excerpt_length ) && $excerpt_length == '' ) ) :
					$excerpttext = $excerpttext;
				else :
					$excerpttext = substr( $excerpttext, 0, $excerpt_length );
				endif; ?>
			
				<div class="copy">  
					<?php // Use an ellipsis if the excerpt is longer than the count
					if ( $excerpt_length < $counter ):
						$excerpttext .= '&hellip;';
						echo '<p>'.$excerpttext.'</p>';
					else: 
						echo '<p>'.$excerpttext.'</p>';
					endif;	?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</div>    
</li>