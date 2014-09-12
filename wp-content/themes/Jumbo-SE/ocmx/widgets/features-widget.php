<?php
class obox_features_widget extends WP_Widget {
	/** constructor */
	function obox_features_widget() {
		parent::WP_Widget(false, $name = __("(Obox) Features Widget", "ocmx"), array("description" => "Display various kinds of content in a multi-column layout on your home page."));
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		global $woocommerce;

		// Turn $args array into variables.
		extract( $args );

		// If there is a custom link or title set, use them
		if( isset( $title ) && $title != '' )
			$the_cat_title = $title;
		if( isset( $title_link ) && $title_link != '' )
			$catlink = $title_link;

		// Turn $instance array into variables
		$instance_defaults = array ( 'excerpt_length' => 80, 'post_thumb' => true);
		$instance_args = wp_parse_args( $instance, $instance_defaults );
		extract( $instance_args, EXTR_SKIP );

		// Filter by the chosen taxonomy
		if($post_category != "0" && $post_category != "") :
			$args = array(
				"post_type" => 'features',
				"posts_per_page" => $post_count,
				"tax_query" => array(
					array(
						"taxonomy" => 'features-category',
						"field" => "slug",
						"terms" => $post_category
					)
				)
			);
		else :
			$args = array(
				"post_type" => 'features',
				"posts_per_page" => $post_count,

			);
		endif;

		// Set the post order
		if(isset($post_order_by)) :
			$args['order'] = $post_order;
			$args['orderby'] = $post_order_by;
		endif;

		// Main Post Query
		$loop = new WP_Query($args); ?>

		<li class="features-widget widget clearfix">

			<?php if(isset($title) && $title != "") : ?>
				<h3 class="widgettitle">
					<?php if(isset($title_link) && $title_link !="") : ?>
						<a href="<?php if(isset ($title_link)) {echo $title_link;} ?>"><?php echo $title; ?></a>
					<?php else : ?>
						<?php echo $title; ?>
					<?php endif; ?>
				</h3>
			<?php endif; ?>

			<ul class="features-widget-item clearfix">

				<?php while ( $loop->have_posts() ) : $loop->the_post();
					global $post;
					$image_position  = get_post_meta($post->ID, "image_position", true);
					if($image_position == '') $image_position = 'image-right';

					$width = 490;
					$height = 368;

					if($image_position == 'image-only' || $image_position == 'image-title' )
						$resizer = 'large';
					else
						$resizer = '4-3-medium';

					$link = get_post_meta($post->ID, "link", true);
					$buttontext = get_post_meta($post->ID, "button", true);
					$buttoncolour = get_post_meta($post->ID, "button_colour", true);

					$image_args  = array('postid' => $post->ID, 'width' => $width, 'height' => $height, 'hide_href' => false, 'exclude_video' => $post_thumb, 'wrap' => 'div', 'wrap_class' => 'post-image fitvid', 'imglink' => false, 'resizer' => $resizer);
					$image = get_obox_media($image_args); ?>

					<li class="column <?php echo $image_position; ?>">

							<div class="content">
								<?php if($image_position != "image-only") : ?>
									<div class="feature-content">
										<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
										<?php if(isset( $show_excerpts ) && $show_excerpts == "on" ) : ?>
											<h5><?php echo $post->post_excerpt; ?></h5>
										<?php endif; ?>

										<?php if(isset( $show_content ) && $show_content == "on" ) : ?>
											<div class="copy">
												<?php the_content(); ?>
											</div>
										<?php endif; ?>

										<?php if($link !='') : ?>
											<a class="action-link" href="<?php echo $link; ?>" <?php if($buttoncolour != '') : ?>style="background: <?php echo $buttoncolour; ?>;"<?php endif; ?>><?php echo $buttontext; ?></a>
										<?php endif; ?>
									</div>
								<?php endif; ?>

								<?php if($image != ""):
									echo $image;
								endif; ?>
							</div>

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
		<label for="<?php echo $this->get_field_id('title'); ?>">Title<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php if( isset( $title ) ) echo $title; ?>" /></label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('title_link'); ?>"><?php _e('Custom Title Link', 'ocmx'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title_link'); ?>" type="text" value="<?php if(isset($title_link)) echo $title_link; ?>" /></label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('post_category'); ?>">Category</label>
		<?php $cat_list = get_terms("features-category", "orderby=count&hide_empty=0");?>

		<select size="1" class="widefat" id="<?php echo $this->get_field_id("post_category"); ?>" name="<?php echo $this->get_field_name("post_category"); ?>">

			<option value="0">All</option>

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
	<?php  // Setup the order values
	$order_params = array("date" => "Post Date", "title" => "Post Title", "rand" => "Random",  "comment_count" => "Comment Count",  "menu_order" => "Menu Order"); ?> 
	<p>
		<label for="<?php echo $this->get_field_id('post_order_by'); ?>"><?php _e("Order By", "ocmx"); ?></label>
		<select size="1" class="widefat" id="<?php echo $this->get_field_id('post_order_by'); ?>" name="<?php echo $this->get_field_name('post_order_by'); ?>">
			<?php foreach($order_params as $value => $label) :?>
				<option  <?php if(isset($post_order_by) && $post_order_by == $value){echo "selected=\"selected\"";} ?> value="<?php echo $value; ?>"><?php echo $label; ?></option>
			<?php endforeach;?>
		</select>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('post_order'); ?>"><?php _e("Order", "ocmx"); ?></label>
		<select size="1" class="widefat" id="<?php echo $this->get_field_id('post_order'); ?>" name="<?php echo $this->get_field_name('post_order'); ?>">
			<option <?php if(!isset($post_order) || isset($post_order) && $post_order == "DESC") : ?>selected="selected"<?php endif; ?> value="DESC"><?php _e("Descending", 'ocmx'); ?></option>
			<option <?php if(isset($post_order) && $post_order == "ASC") : ?>selected="selected"<?php endif; ?> value="ASC"><?php _e("Ascending", 'ocmx'); ?></option>
		</select>
	</p>
	 <p>
		<label for="<?php echo $this->get_field_id('post_thumb'); ?>"><?php _e("Show Images or Videos?", "ocmx"); ?></label>
		<select size="1" class="widefat" id="<?php echo $this->get_field_id('post_thumb'); ?>" name="<?php echo $this->get_field_name('post_thumb'); ?>">
				<option <?php if($post_thumb == "none") : ?>selected="selected"<?php endif; ?> value="none"><?php _e("None", "ocmx"); ?></option>
				<option <?php if($post_thumb == "1") : ?>selected="selected"<?php endif; ?> value="1"><?php _e("Featured Thumbnails", "ocmx"); ?></option>
				<option <?php if($post_thumb == "0") : ?>selected="selected"<?php endif; ?> value="0"><?php _e("Videos", "ocmx"); ?></option>
		</select>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('show_excerpts'); ?>">
			<input type="checkbox" <?php if(isset($show_excerpts) && $show_excerpts == "on") : ?>checked="checked"<?php endif; ?> id="<?php echo $this->get_field_id('show_excerpts'); ?>" name="<?php echo $this->get_field_name('show_excerpts'); ?>">
			<?php _e("Show Excerpts", "ocmx"); ?>
		</label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('show_content'); ?>">
			<input type="checkbox" <?php if(isset($show_content) && $show_content == "on") : ?>checked="checked"<?php endif; ?> id="<?php echo $this->get_field_id('show_content'); ?>" name="<?php echo $this->get_field_name('show_content'); ?>">
			<?php _e("Show Content", "ocmx"); ?>
		</label>
	</p>

<?php
	} // form

}// class

//This sample widget can then be registered in the widgets_init hook:

// register FooWidget widget
add_action('widgets_init', create_function('', 'return register_widget("obox_features_widget");'));

?>