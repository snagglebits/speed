<?php
class obox_partners_widget extends WP_Widget {
	/** constructor */
	function obox_partners_widget() {
		parent::WP_Widget(false, $name = __("(Obox) Partners Widget", "ocmx"), array("description" => "Display your partners in a multi-column layout on your home page."));
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		global $woocommerce;

		// Turn $args array into variables.
		extract( $args );

		// Turn $instance array into variables
		$instance_defaults = array ( 'excerpt_length' => 80, 'post_thumb' => true);
		$instance_args = wp_parse_args( $instance, $instance_defaults );
		extract( $instance_args, EXTR_SKIP );

		if($post_category != "0") :
			$args = array(
				"post_type" => 'partners',
				"posts_per_page" => $post_count,
				"tax_query" => array(
					array(
						"taxonomy" => 'partners-category',
						"field" => "slug",
						"terms" => $post_category

					)
				)
			);
		else :
			$args = array(
				"post_type" => 'partners',
				"posts_per_page" => $post_count
			);
		endif;

		// Main Post Query
		$loop = new WP_Query($args); ?>

		<li class="content-widget partners-content-widget widget clearfix">

			<?php if(isset($title) && $title != "") : ?>
				<h3 class="widgettitle"><?php echo $title; ?></h3>
			<?php endif; ?>

			<ul class="<?php echo $layout_columns; ?>-column content-widget-item partners clearfix">

				<?php while ( $loop->have_posts() ) : $loop->the_post();
					global $post;
					$width = 200;
					$height = 200;
					$resizer = '4-3-medium-nocrop';
					$link = get_post_meta($post->ID, "link", true);
					$image_args  = array('postid' => $post->ID, 'width' => $width, 'height' => $height, 'hide_href' => true, 'exclude_video' => true, 'wrap' => '', 'wrap_class' => '', 'imglink' => false, 'resizer' => $resizer);
					$image = get_obox_media($image_args); ?>

					<li class="column">

						<?php if($image != ""): ?>
							<div class="post-image">
								<a target="_blank" href="<?php echo $link; ?>"><?php echo $image; ?></a>
							</div>
						<?php endif; ?>

						<?php if(isset($show_title) && $show_title =="on" || isset($show_excerpts) && $show_excerpts =="on") : ?>
							<div class="content">
								<?php if(isset( $show_title ) && $show_title == "on" ) : ?>
									<h4 class="post-title"><a target="_blank" href="<?php echo $link; ?>"><?php the_title(); ?></a></h4>
								<?php endif; ?>

								<?php
								// Excerpts on/off
								if(isset( $show_excerpts ) && $show_excerpts == "on" ) :
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
										endif;

										// Use an ellipsis if the excerpt is longer than the count
										if ( $excerpt_length < $counter )
											$excerpttext .= '&hellip;';
											echo '<p>'.$excerpttext.'</p>';
									endif;

								endif; ?>

							</div>
						<?php endif; ?>

					</li>
				<?php endwhile; ?>
			</ul>
		</li>

<?php
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {

		// Turn $instance array into variables
		$instance_defaults = array ( 'excerpt_length' => 80, 'post_thumb' => 1, 'posttype' => 'post', 'postfilter' => '0', 'post_count' => 4, 'layout_columns' => 2);
		$instance_args = wp_parse_args( $instance, $instance_defaults );
		extract( $instance_args, EXTR_SKIP );

		$post_type_args = array("public" => true, "exclude_from_search" => false, "show_ui" => true);
		$post_types = get_post_types( $post_type_args, "objects");

?>

	<p><em><?php _e("Click Save after selecting a filter from each menu to load the next filter", "ocmx"); ?></em></p>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Title", "ocmx"); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php if(isset($title)) echo $title; ?>" /></label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('title_link'); ?>"><?php _e('Custom Title Link', 'ocmx'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title_link'); ?>" type="text" value="<?php if(isset($title_link)) echo $title_link; ?>" /></label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('post_category'); ?>">Category</label>
		<?php $cat_list = get_terms("partners-category", "orderby=count&hide_empty=0");?>

		<select size="1" class="widefat" id="<?php echo $this->get_field_id("post_category"); ?>" name="<?php echo $this->get_field_name("post_category"); ?>">

			<option <?php if( isset( $post_category ) && $post_category == 0){echo "selected=\"selected\"";} ?> value="0">All</option>

			<?php foreach($cat_list as $tax) :

				$use_value =  $tax->name;

				if($use_value == $post_category)
					{$selected = " selected='selected' ";}
				else
					{$selected = " ";} ?>

				<option <?php echo $selected; ?> value="<?php echo $use_value; ?>"><?php echo $tax->name; ?></option>


			<?php endforeach; ?>

		 </select>
	</p>
	<p>
		<?php $layout_options = array('two' => '2', 'three' => '3', 'four' => '4', 'six' => '6'); ?>
		<label for="<?php echo $this->get_field_id('layout_columns'); ?>"><?php _e("Column Layout", "ocmx"); ?></label>
		<select size="1" class="widefat" id="<?php echo $this->get_field_id('layout_columns'); ?>" name="<?php echo $this->get_field_name('layout_columns'); ?>">
			<?php foreach($layout_options as $value => $label) : ?>
				<option <?php if($layout_columns == $value) : ?>selected="selected"<?php endif; ?> value="<?php echo $value; ?>"><?php echo $label; ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('post_count'); ?>"><?php _e("Post Count", "ocmx"); ?></label>
		<select size="1" class="widefat" id="<?php echo $this->get_field_id('post_count'); ?>" name="<?php echo $this->get_field_name('post_count'); ?>">
			<?php $i = 1;
			while($i < 13) :?>
				<option <?php if($post_count == $i) : ?>selected="selected"<?php endif; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php if($i < 1) :
					$i++;
				else:
					$i=($i+1);
				endif;
			endwhile; ?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('show_title'); ?>">
			<input type="checkbox" <?php if(isset($show_title) && $show_title == "on") : ?>checked="checked"<?php endif; ?> id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>">
			<?php _e("Show Title", "ocmx"); ?>
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('show_excerpts'); ?>">
			<input type="checkbox" <?php if(isset($show_excerpts) && $show_excerpts == "on") : ?>checked="checked"<?php endif; ?> id="<?php echo $this->get_field_id('show_excerpts'); ?>" name="<?php echo $this->get_field_name('show_excerpts'); ?>">
			<?php _e("Show Excerpts", "ocmx"); ?>
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('excerpt_length'); ?>"><?php _e("Excerpt Length (character count)", "ocmx"); ?><input class="shortfat" id="<?php echo $this->get_field_id('excerpt_length'); ?>" name="<?php echo $this->get_field_name('excerpt_length'); ?>" type="text" value="<?php echo $excerpt_length; ?>" /><br /></label>
	</p>
<?php
	} // form

}// class

//This sample widget can then be registered in the widgets_init hook:

// register FooWidget widget
add_action('widgets_init', create_function('', 'return register_widget("obox_partners_widget");'));

?>