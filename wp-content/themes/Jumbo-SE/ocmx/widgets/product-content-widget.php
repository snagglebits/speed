<?php
class obox_product_content_widget extends WP_Widget {
	/** constructor */
	function obox_product_content_widget() {
		parent::WP_Widget(false, $name = __("(Obox) Product Content Widget", "ocmx"), array("description" => "Display various kinds of content in a multi-column layout on your home page."));
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
		$instance_defaults = array ( 'post_count' => 3, 'layout_columns' => 3);
		$instance_args = wp_parse_args( $instance, $instance_defaults );
		extract( $instance_args, EXTR_SKIP );

		if(isset($product_content) && $product_content =="featured-products") :

			$args = array('posts_per_page' => $post_count, 'post_type' => 'product');
			$args['meta_query'][] = array(
				'key' => '_featured',
				'value' => 'yes'
			);

			$args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
			$args['meta_query'][] = $woocommerce->query->visibility_meta_query();

		elseif(isset($product_content) && $product_content =="sale-items") :

			$meta_query = array();
			$meta_query[] = $woocommerce->query->visibility_meta_query();
			$meta_query[] = $woocommerce->query->stock_status_meta_query();

			$product_ids_on_sale = woocommerce_get_product_ids_on_sale();

			$args = array(
				'posts_per_page' => $post_count,
				'no_found_rows' => 1,
				'post_status' => 'publish',
				'post_type' => 'product',
				'orderby' => 'date',
				'order' => 'ASC',
				'meta_query' => $meta_query,
				'post__in' => $product_ids_on_sale
			);

		elseif( isset($product_content) && $product_content =="recent-products") :
			if(isset($postfilter) && isset($instance[$postfilter]))
				$filterval = esc_attr($instance[$postfilter]);
			else
				$filterval = 0;

			if(isset($instance["post_category"]))
				$use_category = $instance["post_category"];

			$args = array(
				"post_type" => 'product',
				"posts_per_page" => $post_count,
				"order" => "DESC",
			);

			if($use_category != "0") :
				$args["tax_query"] = array(
					array(
						"taxonomy" => 'product_cat',
						"field" => "slug",
						"terms" => $use_category
					)
				);
			endif;
		endif;

		// Set the post order
		if(isset($post_order_by)) :
			$args['order'] = $post_order;
			$args['orderby'] = $post_order_by;
		endif;

		// Main Post Query
		$loop = new WP_Query($args); ?>

		<li class="content-widget product-content-widget widget clearfix">

			<?php if(isset($title) && $title != "") : ?>
				<h3 class="widgettitle">
					<?php if(isset($title_link) && $title_link !="") : ?>
						<a href="<?php if(isset ($title_link)) {echo $title_link;} ?>"><?php echo $title; ?></a>
					<?php else : ?>
						<?php echo $title; ?>
					<?php endif; ?>
				</h3>
			<?php endif; ?>

			<ul class="<?php echo $layout_columns; ?>-column content-widget-item products clearfix">

				<?php while ( $loop->have_posts() ) : $loop->the_post();
					global $post, $product;
					$width = 660;
					$height = 660;

					if( $layout_columns == 'five' || $layout_columns == 'four' || $layout_columns == 'three' ) {
						$resizer = 'shop_catalog';
					} else {
						$resizer = '1-1-medium';
					}

					$link = get_permalink($post->ID);
					$image_args  = array('postid' => $post->ID, 'width' => $width, 'height' => $height, 'hide_href' => false, 'exclude_video' => true, 'wrap' => false, 'imglink' => false, 'resizer' => $resizer);
					$image = get_obox_media($image_args); ?>

					<li class="column">
						<div class="post-image">
							<?php echo $image; ?>
						</div>
						<div class="product-detail">
							<h4 class="post-title"><a href="<?php echo $link; ?>"><?php the_title(); ?></a></h4>
							<?php
								woocommerce_get_template( 'loop/sale-flash.php' );
								do_action( 'woocommerce_after_shop_loop_item_title' );
							?>
							<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
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
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Title", "ocmx"); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php if(isset($title)) echo $title; ?>" /></label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('title_link'); ?>"><?php _e('Custom Title Link', 'ocmx'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title_link'); ?>" type="text" value="<?php if(isset($title_link)) echo $title_link; ?>" /></label>
	</p>

	<?php
	$content_options = array('recent-products' => 'Recent Products', 'sale-items' => 'Sale Items', 'featured-products' => 'Featured Products'); ?>
	<p>
		<label for="<?php echo $this->get_field_id('product_content'); ?>"><?php _e("Product Content Options", "ocmx"); ?></label>
		<select size="1" class="widefat" id="<?php echo $this->get_field_id('product_content'); ?>" name="<?php echo $this->get_field_name('product_content'); ?>">
			<?php foreach($content_options as $value => $label) : ?>
				<option <?php if(isset($product_content) && $product_content == $value) : ?>selected="selected"<?php endif; ?> value="<?php echo $value; ?>"><?php echo $label; ?></option>
			<?php endforeach; ?>
		</select>
	</p>

	<?php if(isset($product_content) && $product_content =="recent-products") : ?>
		<p>
			<label for="<?php echo $this->get_field_id('post_category'); ?>">Category</label>
			<?php $cat_list = get_terms("product_cat", "orderby=count&hide_empty=0");?>
			<select size="1" class="widefat" id="<?php echo $this->get_field_id("post_category"); ?>" name="<?php echo $this->get_field_name("post_category"); ?>">
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
	<?php endif; ?>

	<?php
	// Setup the column layouts
	$layout_options = array('one' => '1', 'two' => '2', 'three' => '3', 'four' => '4', 'five' => '5');?>
	<p>
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
<?php
	} // form

}// class

//This sample widget can then be registered in the widgets_init hook:

// register FooWidget widget
add_action('widgets_init', create_function('', 'return register_widget("obox_product_content_widget");'));

?>