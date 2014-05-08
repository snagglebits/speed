<?php
class obox_hero_widget extends WP_Widget {
	/** constructor */
	function obox_hero_widget() {

		$control_ops = array('width' => 800, 'height' => 350);
		parent::WP_Widget(false, $name = __("(Obox) Hero Widget", "ocmx"), array("description" => "Display various kinds of content in a multi-column layout on your home page."), $control_ops);
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		global $woocommerce;

		// Turn $args array into variables.
		extract( $args );

		// Turn $instance array into variables
		$instance_defaults = array ( 'excerpt_length' => 80, 'post_thumb' => 1, 'posttype' => 'post', 'postfilter' => '0', 'post_count' => 4, 'layout_columns' => 2);
		$instance_args = wp_parse_args( $instance, $instance_defaults );
		extract( $instance_args, EXTR_SKIP );
		?>

		<li class="widget hero-content-widget clearfix">
			<div class="left-col">
				<?php for ($i = 1; $i < 3; $i++) {
					// Setup variables for this column
					if(isset($instance["left_title_".$i]))
						$title = $instance["left_title_".$i];
					if(isset($instance['left_post_count_'.$i]))
						$post_count = $instance['left_post_count_'.$i];
					if( isset( $instance['left_post_category_'.$i] ) )
						$post_category = $instance['left_post_category_'.$i];
					if( isset( $instance['left_post_order_'.$i] ) )
						$post_order = $instance['left_post_order_'.$i];
					if( isset( $instance['left_post_order_by_'.$i] ) )
						$post_order_by = $instance['left_post_order_by_'.$i];


					if( $post_category != "0" ) :
						$args = array(
							"post_type" => "product",
							"posts_per_page" => $post_count,
							"tax_query" => array(
								array(
									"taxonomy" => "product_cat",
									"field" => "slug",
									"terms" => $post_category
								)
							)
						);
					else :
						$args = array(
							"post_type" => "product",
							"posts_per_page" => $post_count
						);
					endif;

					// Set the post order
					if(isset($post_order_by)) :
						$args['order'] = $post_order;
						$args['orderby'] = $post_order_by;
					endif;

					//Set the post Aguments and Query accordingly
					$left_posts = new WP_Query( $args ); ?>

					<h3 class="widgettitle"><?php echo $title; ?></h3>
					<ul>
						<?php
						while ( $left_posts->have_posts() ) : $left_posts->the_post(); ?>
							<li>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</li>
						<?php endwhile; ?>
					</ul>

				<?php } // End For ?>
			</div>


			<div class="middle-col">
				<?php
				if(isset($instance["middle_title"]))
					$title = $instance["middle_title"];
				if(isset($instance['middle_post_count']))
					$post_count = $instance['middle_post_count'];
				if( isset( $instance['middle_post_category'] ) )
					$post_category = $instance['middle_post_category'];
				if( isset( $instance['middle_post_thumb'] ) )
					$post_thumb = $instance['middle_post_thumb'];
				if( isset( $instance['middle_add_cart'] ) )
					$add_cart = $instance['middle_add_cart'];
				if( isset( $instance['middle_show_excerpts'] ) )
					$show_excerpts = $instance['middle_show_excerpts'];
				if( isset( $instance['middle_excerpt_length'] ) )
					$excerpt_length = $instance['middle_excerpt_length'];

				if( isset( $instance['middle_post_order_'.$i] ) )
					$post_order = $instance['middle_post_order_'.$i];
				if( isset( $instance['middle_post_order_by_'.$i] ) )
					$post_order_by = $instance['middle_post_order_by_'.$i];

				if( $post_category != "0" ) :
					$args = array(
						"post_type" => "product",
						"posts_per_page" => $post_count,
						"tax_query" => array(
							array(
								"taxonomy" => "product_cat",
								"field" => "slug",
								"terms" => $post_category
							)
						)
					);
				else :
					$args = array(
						"post_type" => "product",
						"posts_per_page" => $post_count
					);
				endif;

				// Set the post order
				if(isset($post_order_by)) :
					$args['order'] = $post_order;
					$args['orderby'] = $post_order_by;
				endif;

				//Set the post Aguments and Query accordingly
				$middle_posts = new WP_Query( $args );
				?>

				<h3 class="widgettitle"><?php echo $title; ?></h3>
				<ul>
					<?php
					while ( $middle_posts->have_posts() ) : $middle_posts->the_post();
						global $post;
						$image_args  = array('postid' => $post->ID, 'width' => '190', 'height' => '190', 'hide_href' => false, 'exclude_video' => $post_thumb, 'wrap' => false, 'imglink' => false, 'resizer' => 'shop_catalog');
						$image = get_obox_media($image_args); ?>
						<li class="column">
							<?php if(isset($post_thumb) && $post_thumb !="none") : ?>
								<div class="post-image fitvid">
									<?php echo $image; ?>
								</div>
							<?php endif; ?>
							<div class="product-detail">
								<h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								<?php
									woocommerce_get_template( 'loop/sale-flash.php' );
									do_action( 'woocommerce_after_shop_loop_item_title' );
								?>
								<?php if(isset($add_cart) && $add_cart =='on')
									do_action( 'woocommerce_after_shop_loop_item' ); ?>
							</div>
						</li>
					<?php endwhile; ?>
				</ul>
			</div>


			<div class="right-col">
				<?php for ($i = 1; $i < 3; $i++) {
					// Setup variables for this column
					if(isset($instance["right_title_".$i]))
						$title = $instance["right_title_".$i];
					if(isset($instance['right_post_count_'.$i]))
						$post_count = $instance['right_post_count_'.$i];
					if( isset( $instance['right_post_category_'.$i] ) )
						$post_category = $instance['right_post_category_'.$i];
					if( isset( $instance['right_post_order_'.$i] ) )
						$post_order = $instance['right_post_order_'.$i];
					if( isset( $instance['right_post_order_by_'.$i] ) )
						$post_order_by = $instance['right_post_order_by_'.$i];

					if( $post_category != "0" ) :
						$args = array(
							"post_type" => "product",
							"posts_per_page" => $post_count,
							"tax_query" => array(
								array(
									"taxonomy" => "product_cat",
									"field" => "slug",
									"terms" => $post_category
								)
							)
						);
					else :
						$args = array(
							"post_type" => "product",
							"posts_per_page" => $post_count
						);
					endif;

					// Set the post order
					if(isset($post_order_by)) :
						$args['order'] = $post_order;
						$args['orderby'] = $post_order_by;
					endif;

					//Set the post Aguments and Query accordingly
					$count = 0;
					$numposts = 0;
					$right_posts = new WP_Query( $args ); ?>

					<h3 class="widgettitle"><?php echo $title; ?></h3>
					<ul>
						<?php
						while ( $right_posts->have_posts() ) : $right_posts->the_post(); ?>
							<li>
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</li>
						<?php endwhile; ?>
					</ul>

				<?php } // End For ?>
			</div>
		</li>

<?php }

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {

	echo '<div class="hero-column left">';

		for ($i = 1; $i < 3; $i++) {
			if(isset($instance["left_title_".$i]))
				$title = $instance["left_title_".$i];
			if(isset($instance['left_post_count_'.$i]))
				$post_count = $instance['left_post_count_'.$i];
			if( isset( $instance['left_post_category_'.$i] ) )
				$post_category = $instance['left_post_category_'.$i];
			if( isset( $instance["left_postfilter_".$i] ) ){
				$postfilter = $instance["left_postfilter_".$i];
				$filtername = $postfilter."_".$i;
				if( isset( $instance[$filtername] ) ){
					$filterval = $instance[$filtername];
				}
			}
			if( isset( $instance['left_post_order_'.$i] ) )
				$post_order = $instance['left_post_order_'.$i];
			if( isset( $instance['left_post_order_by_'.$i] ) )
				$post_order_by = $instance['left_post_order_by_'.$i];

			?>

			<h3><?php _e("Left Column $i","ocmx"); ?></h3>
			<p>
				<label for="<?php echo $this->get_field_id('left_title_'.$i); ?>">Title<input class="widefat" id="<?php echo $this->get_field_id('left_title_'.$i); ?>" name="<?php echo $this->get_field_name('left_title_'.$i); ?>" type="text" value="<?php if(isset($instance['left_title_'.$i])) echo $instance['left_title_'.$i]; ?>" /></label>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('left_post_category_'.$i); ?>">Category</label>
				<?php $cat_list = get_terms("product_cat", "orderby=count&hide_empty=0");?>
				<select size="1" class="widefat" id="<?php echo $this->get_field_id('left_post_category_'.$i); ?>" name="<?php echo $this->get_field_name('left_post_category_'.$i); ?>">
					<option <?php if(isset($filterval) && $filterval == 0){echo "selected=\"selected\"";} ?> value="0">All</option>
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
				<label for="<?php echo $this->get_field_id('left_post_count_'.$i); ?>">Post Count</label>
				<select size="1" class="widefat" id="<?php echo $this->get_field_id('left_post_count_'.$i); ?>" name="<?php echo $this->get_field_name('left_post_count_'.$i); ?>">
					<?php for($counter = 1; $counter <= 12; $counter++) : ?>
						<option <?php if(isset($post_count) && $post_count == $counter) : ?>selected="selected"<?php endif; ?> value="<?php echo $counter; ?>"><?php echo $counter; ?></option>
					<?php endfor; ?>
				</select>
			</p>

			<?php  // Setup the order values
			$order_params = array("date" => "Post Date", "title" => "Post Title", "rand" => "Random",  "comment_count" => "Comment Count",  "menu_order" => "Menu Order"); ?>
			<p>
				<label for="<?php echo $this->get_field_id('left_post_order_by_'.$i); ?>"><?php _e("Order By", "ocmx"); ?></label>
				<select size="1" class="widefat" id="<?php echo $this->get_field_id('left_post_order_by_'.$i); ?>" name="<?php echo $this->get_field_name('left_post_order_by_'.$i); ?>">
					<?php foreach($order_params as $value => $label) :?>
						<option  <?php if(isset($post_order_by) && $post_order_by == $value){echo "selected=\"selected\"";} ?> value="<?php echo $value; ?>"><?php echo $label; ?></option>
					<?php endforeach;?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('left_post_order_'.$i); ?>"><?php _e("Order", "ocmx"); ?></label>
				<select size="1" class="widefat" id="<?php echo $this->get_field_id('left_post_order_'.$i); ?>" name="<?php echo $this->get_field_name('left_post_order_'.$i); ?>">
					<option <?php if(!isset($post_order) || isset($post_order) && $post_order == "DESC") : ?>selected="selected"<?php endif; ?> value="DESC"><?php _e("Descending", 'ocmx'); ?></option>
					<option <?php if(isset($post_order) && $post_order == "ASC") : ?>selected="selected"<?php endif; ?> value="ASC"><?php _e("Ascending", 'ocmx'); ?></option>
				</select>
			</p>


		<?php } // End FOR ?>

	</div>

	<div class="middle-column">
		<?php
		if(isset($instance["middle_title"]))
			$title = $instance["middle_title"];
		if(isset($instance['middle_post_count']))
			$post_count = $instance['middle_post_count'];
		if( isset( $instance['middle_post_category'] ) )
			$post_category = $instance['middle_post_category'];

		if( isset( $instance["middle_postfilter"] ) ){
			$postfilter = $instance["middle_postfilter"];
			$filtername = $postfilter;
			if( isset( $instance[$filtername] ) ){
				$filterval = $instance[$filtername];
			}
		}

		if( isset( $instance['middle_post_thumb'] ) )
			$post_thumb = $instance['middle_post_thumb'];
		if( isset( $instance['middle_add_cart'] ) )
			$add_cart = $instance['middle_add_cart'];
		if( isset( $instance['middle_show_excerpts'] ) )
			$show_excerpts = $instance['middle_show_excerpts'];
		if( isset( $instance['middle_excerpt_length'] ) )
			$excerpt_length = $instance['middle_excerpt_length'];

		if( isset( $instance['middle_post_order_'.$i] ) )
			$post_order = $instance['middle_post_order_'.$i];
		if( isset( $instance['middle_post_order_by_'.$i] ) )
			$post_order_by = $instance['middle_post_order_by_'.$i];
		?>

		<h3><?php _e("Middle Column","ocmx"); ?></h3>
		<p>
			<label for="<?php echo $this->get_field_id('middle_title'); ?>">Title<input class="widefat" id="<?php echo $this->get_field_id('middle_title'); ?>" name="<?php echo $this->get_field_name('middle_title'); ?>" type="text" value="<?php if(isset($instance['middle_title'])) echo $instance['middle_title']; ?>" /></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('middle_post_category'); ?>">Category</label>
			<?php $cat_list = get_terms("product_cat", "orderby=count&hide_empty=0");?>
			<select size="1" class="widefat" id="<?php echo $this->get_field_id('middle_post_category'); ?>" name="<?php echo $this->get_field_name('middle_post_category'); ?>">
				<option <?php if(isset($filterval) && $filterval == 0){echo "selected=\"selected\"";} ?> value="0">All</option>
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
			<label for="<?php echo $this->get_field_id('middle_post_count'); ?>">Post Count</label>
			<select size="1" class="widefat" id="<?php echo $this->get_field_id('middle_post_count'); ?>" name="<?php echo $this->get_field_name('middle_post_count'); ?>">
				<?php for($counter = 1; $counter <= 12; $counter++) : ?>
					<option <?php if(isset($post_count) && $post_count == $counter) : ?>selected="selected"<?php endif; ?> value="<?php echo $counter; ?>"><?php echo $counter; ?></option>
				<?php endfor; ?>
			</select>
		</p>

		<?php  // Setup the order values
		$order_params = array("date" => "Post Date", "title" => "Post Title", "rand" => "Random",  "comment_count" => "Comment Count",  "menu_order" => "Menu Order"); ?>
		<p>
			<label for="<?php echo $this->get_field_id('middle_post_order_by_'.$i); ?>"><?php _e("Order By", "ocmx"); ?></label>
			<select size="1" class="widefat" id="<?php echo $this->get_field_id('middle_post_order_by_'.$i); ?>" name="<?php echo $this->get_field_name('middle_post_order_by_'.$i); ?>">
				<?php foreach($order_params as $value => $label) :?>
					<option  <?php if(isset($post_order_by) && $post_order_by == $value){echo "selected=\"selected\"";} ?> value="<?php echo $value; ?>"><?php echo $label; ?></option>
				<?php endforeach;?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('middle_post_order_'.$i); ?>"><?php _e("Order", "ocmx"); ?></label>
			<select size="1" class="widefat" id="<?php echo $this->get_field_id('middle_post_order_'.$i); ?>" name="<?php echo $this->get_field_name('middle_post_order_'.$i); ?>">
				<option <?php if(!isset($post_order) || isset($post_order) && $post_order == "DESC") : ?>selected="selected"<?php endif; ?> value="DESC"><?php _e("Descending", 'ocmx'); ?></option>
				<option <?php if(isset($post_order) && $post_order == "ASC") : ?>selected="selected"<?php endif; ?> value="ASC"><?php _e("Ascending", 'ocmx'); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('middle_post_thumb'); ?>"><?php _e("Show Images or Videos?", "ocmx"); ?></label>
			<select size="1" class="widefat" id="<?php echo $this->get_field_id('middle_post_thumb'); ?>" name="<?php echo $this->get_field_name('middle_post_thumb'); ?>">
					<option <?php if(isset($post_thumb) && $post_thumb == "none") : ?>selected="selected"<?php endif; ?> value="none"><?php _e("None", "ocmx"); ?></option>
					<option <?php if(isset($post_thumb) && $post_thumb == "1") : ?>selected="selected"<?php endif; ?> value="1"><?php _e("Featured Thumbnails", "ocmx"); ?></option>
					<option <?php if(isset($post_thumb) && $post_thumb == "0") : ?>selected="selected"<?php endif; ?> value="0"><?php _e("Videos", "ocmx"); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('middle_add_cart'); ?>">
				<input type="checkbox" <?php if(isset($add_cart) && $add_cart == "on") : ?>checked="checked"<?php endif; ?> id="<?php echo $this->get_field_id('middle_add_cart'); ?>" name="<?php echo $this->get_field_name('middle_add_cart'); ?>">
				<?php _e("Show 'Add to Cart' button", "ocmx"); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('middle_show_excerpts'); ?>">
				<input type="checkbox" <?php if(isset($show_excerpts) && $show_excerpts == "on") : ?>checked="checked"<?php endif; ?> id="<?php echo $this->get_field_id('middle_show_excerpts'); ?>" name="<?php echo $this->get_field_name('middle_show_excerpts'); ?>">
				<?php _e("Show Excerpts", "ocmx"); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('middle_excerpt_length'); ?>"><?php _e("Excerpt Length (character count)", "ocmx"); ?><input class="widefat" id="<?php echo $this->get_field_id('middle_excerpt_length'); ?>" name="<?php echo $this->get_field_name('middle_excerpt_length'); ?>" type="text" value="<?php if(isset($instance['middle_excerpt_length'])) echo $instance['middle_excerpt_length']; ?>" /></label>
		</p>

	</div>

	<div class="hero-column right">

		<?php for ($i = 1; $i < 3; $i++) {
			if(isset($instance["right_title_".$i]))
				$title = $instance["right_title_".$i];
			if(isset($instance['right_post_count_'.$i]))
				$post_count = $instance['right_post_count_'.$i];
			if( isset( $instance['right_post_category_'.$i] ) )
				$post_category = $instance['right_post_category_'.$i];

			if( isset( $instance["right_postfilter_".$i] ) ){
				$postfilter = $instance["right_postfilter_".$i];
				$filtername = $postfilter."_".$i;
				if( isset( $instance[$filtername] ) ){
					$filterval = $instance[$filtername];
				}
			}

			if( isset( $instance['right_post_order_'.$i] ) )
				$post_order = $instance['right_post_order_'.$i];
			if( isset( $instance['right_post_order_by_'.$i] ) )
				$post_order_by = $instance['right_post_order_by_'.$i];

			?>

			<h3><?php _e("Right Column $i","ocmx"); ?></h3>
			<p>
				<label for="<?php echo $this->get_field_id('right_title_'.$i); ?>">Title<input class="widefat" id="<?php echo $this->get_field_id('right_title_'.$i); ?>" name="<?php echo $this->get_field_name('right_title_'.$i); ?>" type="text" value="<?php if(isset($instance['right_title_'.$i])) echo $instance['right_title_'.$i]; ?>" /></label>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('right_post_category_'.$i); ?>">Category</label>
				<?php $cat_list = get_terms("product_cat", "orderby=count&hide_empty=0");?>
				<select size="1" class="widefat" id="<?php echo $this->get_field_id('right_post_category_'.$i); ?>" name="<?php echo $this->get_field_name('right_post_category_'.$i); ?>">
					<option <?php if(isset($filterval) && $filterval == 0){echo "selected=\"selected\"";} ?> value="0">All</option>
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
				<label for="<?php echo $this->get_field_id('right_post_count_'.$i); ?>">Post Count</label>
				<select size="1" class="widefat" id="<?php echo $this->get_field_id('right_post_count_'.$i); ?>" name="<?php echo $this->get_field_name('right_post_count_'.$i); ?>">
					<?php for($counter = 1; $counter <= 12; $counter++) : ?>
						<option <?php if(isset($post_count) && $post_count == $counter) : ?>selected="selected"<?php endif; ?> value="<?php echo $counter; ?>"><?php echo $counter; ?></option>
					<?php endfor; ?>
				</select>
			</p>

			<?php  // Setup the order values
			$order_params = array("date" => "Post Date", "title" => "Post Title", "rand" => "Random",  "comment_count" => "Comment Count",  "menu_order" => "Menu Order"); ?>
			<p>
				<label for="<?php echo $this->get_field_id('right_post_order_by_'.$i); ?>"><?php _e("Order By", "ocmx"); ?></label>
				<select size="1" class="widefat" id="<?php echo $this->get_field_id('right_post_order_by_'.$i); ?>" name="<?php echo $this->get_field_name('right_post_order_by_'.$i); ?>">
					<?php foreach($order_params as $value => $label) :?>
						<option  <?php if(isset($post_order_by) && $post_order_by == $value){echo "selected=\"selected\"";} ?> value="<?php echo $value; ?>"><?php echo $label; ?></option>
					<?php endforeach;?>
				</select>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('right_post_order_'.$i); ?>"><?php _e("Order", "ocmx"); ?></label>
				<select size="1" class="widefat" id="<?php echo $this->get_field_id('right_post_order_'.$i); ?>" name="<?php echo $this->get_field_name('right_post_order_'.$i); ?>">
					<option <?php if(!isset($post_order) || isset($post_order) && $post_order == "DESC") : ?>selected="selected"<?php endif; ?> value="DESC"><?php _e("Descending", 'ocmx'); ?></option>
					<option <?php if(isset($post_order) && $post_order == "ASC") : ?>selected="selected"<?php endif; ?> value="ASC"><?php _e("Ascending", 'ocmx'); ?></option>
				</select>
			</p>


		<?php } // End FOR

	echo '</div>';


	} // form

}// class

//This sample widget can then be registered in the widgets_init hook:

// register FooWidget widget
add_action('widgets_init', create_function('', 'return register_widget("obox_hero_widget");'));

?>