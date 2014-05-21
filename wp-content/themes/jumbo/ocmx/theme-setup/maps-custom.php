<?php
function create_map_meta() {
	global $post, $events_meta;
	foreach($events_meta as $meta=>$value) :
		$meta_value= get_post_meta($post->ID,$value["name"],true);
		if($meta_value == "") :
			$meta_value= $value["default"];
		endif; ?>
		<p>
        	<label for="<?php echo $value["name"]; ?>">
				<?php echo $value["label"]; ?>
	        	<input name="<?php echo $value["name"]; ?>" id="<?php echo $value["name"]; ?>" value="<?php echo $meta_value; ?>" class="widefat" />
            </label>
		</p>
	<?php endforeach; ?>
<?php }
function insert_map_meta($pID) {
	global $port_meta_added, $events_meta;
	if(!isset($port_meta_added)) :
		if( !empty( $events_meta ) ) :
			foreach($events_meta as $meta=>$value) :
				$var = $value["name"];
				if(isset($_POST[$var])) :
					add_post_meta($pID,$value["name"],$_POST[$var],true) or update_post_meta($pID,$value["name"],$_POST[$var]);
				endif;
			endforeach;
		endif;
		$port_meta_added = 1;
	endif;
}
add_action('admin_menu', 'insert_map_meta');
add_action('save_post', 'insert_map_meta'); ?>