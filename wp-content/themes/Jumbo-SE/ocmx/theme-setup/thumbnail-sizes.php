<?php
/**************************/
/* Set Up Thumbnails */
function ocmx_setup_image_sizes() {
	//image info: (name, width, height, force-crop)
	add_image_size('4-3-large', 1000, 750, true);
	add_image_size('4-3-medium', 660, 495, true);
	add_image_size('4-3-medium-nocrop', 660, 495, false);
	add_image_size('1-1-medium', 660, 660, true);
	add_image_size('1000auto', 1000);
	add_image_size('660auto', 660);
}

add_action( 'after_setup_theme', 'ocmx_setup_image_sizes' );