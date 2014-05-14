<?php
class obox_page_widget extends WP_Widget {
	/** constructor */
	function obox_page_widget() {
		$control_ops = array('width' => 800, 'height' => 350);
		parent::WP_Widget(false, $name = __("(Obox) Page Widget", "ocmx"), array("description" => "Display image or title links to pages in a multi-column layout on your home page."), $control_ops);
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
	
		// Turn $instance array into variables
		$instance_defaults = array ( 'title' => '', 'columns' => 3, 'post_thumb' => 1, 'excerpt_length' => '120');
		$instance_args = wp_parse_args( $instance, $instance_defaults );
		extract( $instance_args, EXTR_SKIP );
		
		if($columns == 4) :
			$class = 'four';
		elseif($columns == 3) :
			$class = 'three';
		elseif($columns == 2) :
			$class = 'two';
		elseif($columns == 1) :
			$class = 'one';
		endif; ?>
		
	<li class="page-widget widget clearfix">

		<ul class="<?php echo $class; ?>-column  page-widget-item ">
			<?php for ($i = 1; $i <= $columns; $i++) { 
				global $post;

				$page_id = $instance['page_choose'.$i];
				$page_data = get_page($page_id); 
				$link = $instance['page_link_'.$i];
				$image_args  = array('postid' => $page_id, 'width' => '190', 'height' => '190', 'hide_href' => true, 'exclude_video' => $post_thumb, 'wrap' => false, 'imglink' => false, 'resizer' => '1-1-medium');
				$image = get_obox_media($image_args); ?>

				<li class="column">
				<?php if($link !="" && $instance['title_'.$i] !="") { ?> 
					<a href="<?php echo $link; ?>"><h4 class="widgettitle"><?php echo $instance['title_'.$i]; ?></h4></a>
				<?php } else {
					if ($instance['title_'.$i] !="") : ?>
						<h4 class="widgettitle"><?php echo $instance['title_'.$i]; ?></h4>
				<?php endif; } ?>
					<div class="content">
						<?php if($instance['show_images'.$i] == 'on') : ?>
							<?php if(isset($image) && $image != "") : ?>
								<div class="post-image fitvid"> 
									<?php if(isset($link) && $link !="") : ?> 
										<a href="<?php echo $link; ?>"><?php echo $image; ?></a>
									<?php else: ?>
										<?php echo $image; ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						<?php endif; ?>

						<?php if(isset($instance['show_excerpts'.$i]) && $instance['show_excerpts'.$i] == 'on') : ?>

							<div class="copy">  
								<?php
								$morestring = '<!--more-->';
								$explodemore = explode($morestring, $page_data->post_content);
								echo $explodemore[0]; // before the more-tag
								
								if(isset($explodemore[1]) && $explodemore[1] !="" && isset($link) && $link !="") echo "<p><a class='view-more' href='".$link."'>View more</a></p>";
								?>
							</div>

						<?php endif; ?>
					</div>
				</li>
			<?php }; ?>
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
		$instance_defaults = array ('columns' => 3, 'excerpt_length' => '120');
		$instance_args = wp_parse_args( $instance, $instance_defaults );
		extract( $instance_args, EXTR_SKIP ); ?>
		<p><em>Click Save after selecting a Column Layout to load each columns options</em></p>  
		
		<p>
			<label for="<?php echo $this->get_field_id('columns'); ?>">Column Layout</label>
			<select size="1" class="widefat" id="<?php echo $this->get_field_id('columns'); ?>" name="<?php echo $this->get_field_name('columns'); ?>">
				<option <?php if($columns == "1") : ?>selected="selected"<?php endif; ?> value="1">1</option>
				<option <?php if($columns == "2") : ?>selected="selected"<?php endif; ?> value="2">2</option>
				<option <?php if($columns == "3") : ?>selected="selected"<?php endif; ?> value="3">3</option>
				<option <?php if($columns == "4") : ?>selected="selected"<?php endif; ?> value="4">4</option>
			</select>
		</p>
		
		<ul class="page-widget-col-<?php echo $columns; ?>">
			<?php 
			for ($i = 1; $i <= $columns; $i++) { 
				echo "<li>";
					echo "<h4>" . _('Column '. $i ) . "</h4>"; ?>

					<p>
						<label for="<?php echo $this->get_field_id('title_'.$i); ?>">Title
							<input class="widefat" id="<?php echo $this->get_field_id('title_'.$i); ?>" name="<?php echo $this->get_field_name('title_'.$i); ?>" type="text" value="<?php if(isset($instance['title_'.$i])) echo $instance['title_'.$i]; ?>" />
						</label>
					</p>
					<p>
						<label for="<?php echo $this->get_field_id('page_link_'.$i); ?>">Title Link
							<input class="widefat" id="<?php echo $this->get_field_id('page_link_'.$i); ?>" name="<?php echo $this->get_field_name('page_link_'.$i); ?>" type="text" value="<?php if(isset($instance['page_link_'.$i])) echo $instance['page_link_'.$i]; ?>" />
						</label>
					</p>
					<p>
						<label for="<?php echo $this->get_field_id("page_choose" . $i); ?>">
							
							<select size="1" class="widefat" id="<?php echo $this->get_field_id("page_choose" . $i); ?>" name="<?php echo $this->get_field_name("page_choose" . $i); ?>">

								<option <?php if(isset($filterval) && $filterval == 0){echo "selected=\"selected\"";} ?> value="0">Choose a Page</option>
								<?php $pages = get_pages();?>
								
								<?php foreach($pages as $page) :
					
									$use_value = $page->ID;
										 
									if($use_value == $instance['page_choose'.$i])
										{$selected = " selected='selected' ";}
									else
										{$selected = " ";} ?>
										
									<option <?php echo $selected; ?> value="<?php echo $use_value; ?>"><?php echo $page->post_title; ?></option>
									
								<?php endforeach; ?>
						
							</select>
						</label>
					</p>

					<p>
						<label for="<?php echo $this->get_field_id('cat_title' . $i); ?>">
							<input type="checkbox" <?php if(isset($instance['cat_title'.$i]) && $instance['cat_title'.$i] == 'on') : ?>checked="checked"<?php endif; ?> id="<?php echo $this->get_field_id('cat_title' . $i); ?>" name="<?php echo $this->get_field_name('cat_title' . $i); ?>">
							Show Title
						</label>
					</p>
					<p>
						<label for="<?php echo $this->get_field_id('show_images' . $i); ?>">
							<input type="checkbox" <?php if(isset($instance['show_images'.$i]) && $instance['show_images'.$i] == 'on') : ?>checked="checked"<?php endif; ?> id="<?php echo $this->get_field_id('show_images' . $i); ?>" name="<?php echo $this->get_field_name('show_images' . $i); ?>">
							Show Images
						</label>
					</p>
				
					 <p>
						<label for="<?php echo $this->get_field_id('show_excerpts' . $i); ?>">
							<input type="checkbox" <?php if(isset($instance['show_excerpts'.$i]) && $instance['show_excerpts'.$i] == 'on') : ?>checked="checked"<?php endif; ?> id="<?php echo $this->get_field_id('show_excerpts' . $i); ?>" name="<?php echo $this->get_field_name('show_excerpts' . $i); ?>">
							Show Description
						</label>

					</p>

					<p>
						<label for="<?php echo $this->get_field_id('excerpt_length_'.$i); ?>"><?php _e("Excerpt Length (character count)", "ocmx"); ?>
							<input class="widefat" id="<?php echo $this->get_field_id('excerpt_length_'.$i); ?>" name="<?php echo $this->get_field_name('excerpt_length_'.$i); ?>" type="text" value="<?php if(isset($instance['excerpt_length_'.$i])) echo $instance['excerpt_length_'.$i]; ?>" />
						</label>
					</p>

				</li>

			<?php }; ?>
		</ul>
			
		
	<?php } // form

}// class

//This sample widget can then be registered in the widgets_init hook:

// register FooWidget widget
add_action('widgets_init', create_function('', 'return register_widget("obox_page_widget");'));

?>