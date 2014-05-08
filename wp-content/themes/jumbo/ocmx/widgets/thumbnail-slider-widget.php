<?php
class obox_video_widget extends WP_Widget {
	/** constructor */
	function obox_video_widget() {
		$widget_ops = array( 'classname' => 'latest-videos', 'description' => __("Display your featured images or videos in a neat fading widget.", "ocmx") );
		$this->WP_Widget( 'obox_video_widget', __("(Obox) Thumbnail Slider", "ocmx"), $widget_ops );
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		global $wpdb;
		$instance_args = wp_parse_args( $instance, array() );
		extract( $instance_args, EXTR_SKIP );

		if($post_category != "0") :
			$args = array(
				"post_type" => 'post',
				"posts_per_page" => $post_count,
				"tax_query" => array(
					array(
						"taxonomy" => 'category',
						"field" => "slug",
						"terms" => $post_category
					)
				)
			);
		else :
			$args = array(
				"post_type" => 'post',
				"posts_per_page" => $post_count
			);
		endif;

		$count = 0;
		$numposts = 0;

		$post_query = new WP_Query($args);

		echo $before_widget; ?>
		<div class="video-slider-buttons">
			<a class="previous" href=""><?php _e("Prev", "ocmx"); ?></a>
			<a class="next" href=""><?php _e("Next", "ocmx"); ?></a>
		</div>
		<h4 class="widgettitle"><?php echo $title; ?></h4>
		<div class="content">
			<?php while ( $post_query->have_posts() ) : $post_query->the_post();
				global $post;
				$args  = array( 'postid' => $post->ID, 'width' => 240, 'height' => 180, 'hide_href' => false, 'imglink' => false, 'imgnocontainer' => true, 'resizer' => '4-3-medium' );
				$image = get_obox_media( $args ); ?>
				<div id="obox_video_widget_<?php echo $count; ?>" class="video-thumb">
					<?php echo $image; ?>
				</div>
			<?php
			$count++;
			endwhile; ?>
		</div>
	<?php echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {
		return $new_instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {
		// Turn $instance array into variables
		$instance_defaults = array ("title" => "Thumbnails", "post_category" => 0, "post_count" => "4", "post_thumb" => 0);
		$instance_args = wp_parse_args( $instance, $instance_defaults );
		extract( $instance_args, EXTR_SKIP );
?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Title","ocmx") ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('post_category'); ?>">Category</label>
		<?php $cat_list = get_terms("category", "orderby=count&hide_empty=0");?>

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

	<p>
		<label for="<?php echo $this->get_field_id('post_count'); ?>">Post Count</label>
		<select size="1" class="widefat" id="<?php echo $this->get_field_id('comment_count'); ?>" name="<?php echo $this->get_field_name('post_count'); ?>">
			<?php for( $i = 1; $i < 21; $i++ ) :?>
				<option <?php if( $post_count == $i ) : ?>selected="selected"<?php endif; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor; ?>
		</select>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('post_thumb'); ?>">Thumbnails</label>
		<select size="1" class="widefat" id="<?php echo $this->get_field_id('post_thumb'); ?>" name="<?php echo $this->get_field_name('post_thumb'); ?>">
				<option <?php if( $post_thumb == "true" ) : ?>selected="selected"<?php endif; ?> value="true">Post Feature Image</option>
				<option <?php if( $post_thumb == "false" ) : ?>selected="selected"<?php endif; ?> value="false">Videos</option>
		</select>
	</p>
<?php
	} // form

}// class

//This sample widget can then be registered in the widgets_init hook:

// register FooWidget widget
add_action( 'widgets_init', create_function( '', 'return register_widget("obox_video_widget");') );

?>