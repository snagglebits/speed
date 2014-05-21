<?php
class obox_category_widget extends WP_Widget {
	/** constructor */
	function obox_category_widget() {
		parent::WP_Widget(false, $name = "(Obox) Product Category Widget", array("description" => "Home Page Widget - This widget displays your Product categories in a 3 or 4 column layout"));	
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		// Turn $instance array into variables
		$instance_defaults = array ( 'title' => 'Product Categories', 'columns' => 3);
		$instance_args = wp_parse_args( $instance, $instance_defaults );
		extract( $instance_args, EXTR_SKIP );
		
		if($columns == 5) :
			$class = 'five';
		elseif($columns == 4) :
			$class = 'four';
		elseif($columns == 3) :
			$class = 'three';
		endif; ?>
		
		<li class="content-widget product-category-widget widget clearfix">
			
			<?php if(isset($title) && $title != "") : ?>
				<h3 class="widgettitle">
					<?php if(isset($title_link) && $title_link !="") : ?>
						<a href="<?php if(isset ($title_link)) {echo $title_link;} ?>"><?php echo $title; ?></a>
					<?php else : ?>
						<?php echo $title; ?>
					<?php endif; ?>
				</h3>
			<?php endif; ?>

			<ul class="<?php echo $class; ?>-column  content-widget-item ">
				<?php for ($i = 1; $i <= $columns; $i++) {
				
					// Term ID
					$term_id = $instance['cat' . $i];
					if( !is_numeric( $term_id ) ) {
						$cat = get_term_by( 'slug', $term_id, 'product_cat');
					} else {
						$cat = get_term($term_id, 'product_cat');
					}
		
					if(!is_wp_error($cat)) :
					
					if(function_exists('get_woocommerce_term_meta')) :
						$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
						$image = wp_get_attachment_image_src($thumbnail_id, '4-3-medium');
					endif;
					$link = get_term_link($cat); 
					?>

					<li class="column">
						<div class="content">
							<?php if(isset($show_images) && $show_images == 'on') : ?>
								<?php if(isset($image) && $image != "") : ?>
									<div class="post-image fitvid"> 
										<a href="<?php echo $link; ?>" class="thumbnail" title="<?php echo $cat->name; ?>"><img src="<?php echo $image[0]; ?>" alt="<?php echo $cat->name; ?>" /></a>
									</div>
								<?php endif; ?>
							<?php endif; ?>

							<?php if(isset($cat_title) && $cat_title == 'on') : ?>
								<h4 class="post-title"><a href="<?php echo $link; ?>"><?php echo $cat->name; ?></a></h4>
							<?php endif; ?>

							<?php if(isset($show_excerpts) && $show_excerpts == 'on') : ?>
								<div class="copy">
									<?php if(isset($show_excerpts) && $show_excerpts == 'on') : ?>
										<p><?php echo $cat->description; ?></p>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</li>
				<?php endif;
				}; ?>
			</ul>
		</li>
	<?php }
	
	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
		// Turn $instance array into variables
		$instance_defaults = array ( 'title' => 'Product Categories', 'columns' => 3);
		$instance_args = wp_parse_args( $instance, $instance_defaults );
		extract( $instance_args, EXTR_SKIP ); ?>
		<p><em>Click Save after selecting a Column Layout to load each columns options</em></p>  
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
		</p>  
		<p>
			<label for="<?php echo $this->get_field_id('title_link'); ?>"><?php _e('Custom Title Link', 'ocmx'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title_link'); ?>" type="text" value="<?php if(isset($title_link)) echo $title_link; ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('columns'); ?>">Column Layout</label>
			<select size="1" class="widefat" id="<?php echo $this->get_field_id('columns'); ?>" name="<?php echo $this->get_field_name('columns'); ?>">
				<option <?php if($columns == "3") : ?>selected="selected"<?php endif; ?> value="3">3</option>
				<option <?php if($columns == "4") : ?>selected="selected"<?php endif; ?> value="4">4</option>
				<option <?php if($columns == "5") : ?>selected="selected"<?php endif; ?> value="5">5</option>
			</select>
		</p>
		

		<?php 
		for ($i = 1; $i <= $columns; $i++) { 
			echo "<h4>" . _('Column '. $i ) . "</h4>"; ?>
			
			<?php 
				$terms = get_terms('product_cat', "orderby=count&hide_empty=0"); ?>
				<p><label for="<?php echo $this->get_field_id('cat' . $i); ?>"><?php echo isset($tax->labels->singular_name); ?></label>
				   <select size="1" class="widefat" id="<?php echo $this->get_field_id('cat' . $i); ?>" name="<?php echo $this->get_field_name('cat' . $i); ?>">
						<?php foreach($terms as $term => $details) :?>
							<option  <?php if(isset($instance['cat' . $i]) && $instance['cat' . $i] == $details->term_id){echo "selected=\"selected\"";} ?> value="<?php echo $details->term_id; ?>"><?php echo $details->name; ?></option>
						<?php endforeach;?>
					</select>
				</p>

		<?php }; ?>
			<p>
				<label for="<?php echo $this->get_field_id('cat_title'); ?>">
					<input type="checkbox" <?php if(isset($cat_title) && isset($cat_title) && $cat_title == 'on') : ?>checked="checked"<?php endif; ?> id="<?php echo $this->get_field_id('cat_title'); ?>" name="<?php echo $this->get_field_name('cat_title'); ?>">
					Show Category Title
				</label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('show_images'); ?>">
					<input type="checkbox" <?php if(isset($show_images) && $show_images == "on") : ?>checked="checked"<?php endif; ?> id="<?php echo $this->get_field_id('show_images'); ?>" name="<?php echo $this->get_field_name('show_images'); ?>">
					Show Images
				</label>
			</p>
		
			 <p>
				<label for="<?php echo $this->get_field_id('show_excerpts'); ?>">
					<input type="checkbox" <?php if(isset($show_excerpts) && $show_excerpts == "on") : ?>checked="checked"<?php endif; ?> id="<?php echo $this->get_field_id('show_excerpts'); ?>" name="<?php echo $this->get_field_name('show_excerpts'); ?>">
					Show Description
				</label>
			</p>
		
	<?php } // form

}// class

//This sample widget can then be registered in the widgets_init hook:

// register FooWidget widget
add_action('widgets_init', create_function('', 'return register_widget("obox_category_widget");'));

?>