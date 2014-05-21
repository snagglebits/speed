<?php
class obox_popular_posts_widget extends WP_Widget {
	/** constructor */
	function obox_popular_posts_widget() {
		$widget_ops = array('classname' => 'widget_popular_posts column', 'description' => __( "Popular Posts widget.", 'ocmx') );
		$this->WP_Widget('obox_popular_posts_widget', __('(Obox) Popular Posts', 'ocmx'), $widget_ops);
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {		
		extract( $args );
		global $wpdb;
		if(!($instance["post_category"])) :
			$use_catId = "";
		else :
			$use_catId = "cat=".$instance["post_category"]."&";
		endif;
		
		if(!($instance["display_limit"])) :
			$display_limit = "6";
		else :
			$display_limit = $instance["display_limit"];
		endif;
		
		//Set the post Aguments and Query accordingly
		$count = 1;
		$ocmx_featured = new WP_Query($use_catId."orderby=comment_count&order=DESC&posts_per_page=$display_limit");	
		echo $before_widget; ?>
		<?php echo $before_title; ?>
			<?php echo $instance['title']; ?>
		<?php echo $after_title; ?>
		<ul>
			<?php while ($ocmx_featured->have_posts()) : $ocmx_featured->the_post();
				global $post;
				$link = get_permalink($post->ID); ?>
					<li>
						<a href="<?php echo $link; ?>" title="<?php echo $link; ?>"><?php echo $post->post_title; ?></a>
						<h5 class="dater"><?php echo date_i18n('d M Y', strtotime($post->post_date)); ?></h5>
					</li>
			<?php endwhile ?>
		</ul>
		<?php echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
		if(isset($instance["title"]))
			$title = esc_attr($instance["title"]);
		if(isset($instance["list_by"]))
			$list_by = esc_attr($instance["list_by"]);
		if(isset($instance["post_category"]))
			$post_category = esc_attr($instance["post_category"]);
		if(isset($instance["display_limit"]))
			$display_limit = esc_attr($instance["display_limit"]);

?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php if(isset($title)) : echo $title; endif; ?>" /></label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('display_limit'); ?>">Post Count</label>
			<select size="1" class="widefat" id="<?php echo $this->get_field_id('display_limit'); ?>" name="<?php echo $this->get_field_name('display_limit'); ?>">
				<?php for($i = 1; $i < 11; $i++) : ?>
					<option <?php if(isset($display_limit) && $display_limit == $i) : ?>selected="selected"<?php endif; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
			</select>
		</p>
			
		<p>
			<label for="<?php echo $this->get_field_id('post_category'); ?>">Specific Category</label>
			<select size="1" class="widefat" id="<?php echo $this->get_field_id("post_category"); ?>" name="<?php echo $this->get_field_name("post_category"); ?>">
				<option <?php if(isset($post_count) && $post_count == 0){echo "selected=\"selected\"";} ?> value="0">All</option>
				<?php
				$category_args = array('hide_empty' => false);
				$option_loop = get_categories($category_args);
				foreach($option_loop as $option_label => $value) {
						// Set the $value and $label for the options
						$use_value =  $value->term_id;
						$label =  $value->cat_name;
						//If this option == the value we set above, select it
						if($use_value == $post_category)
							{$selected = " selected='selected' ";}
						else
							{$selected = " ";} ?>

					<option <?php echo $selected; ?> value="<?php echo $use_value; ?>"><?php echo $label; ?></option>
					
					<?php } ?>
			</select>
		</p>
<?php 
	} // form

}// class

//This sample widget can then be registered in the widgets_init hook:

// register FooWidget widget
add_action('widgets_init', create_function('', 'return register_widget("obox_popular_posts_widget");'));

?>