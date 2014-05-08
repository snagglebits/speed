<?php    

function ocmx_deregister_woo_widgets(){
	unregister_widget('WooCommerce_Widget_Layered_Nav');
}
add_action('widgets_init', 'ocmx_deregister_woo_widgets');

?>