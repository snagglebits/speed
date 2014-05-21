<?php function obox_widgets_style() {
global $pagenow;
    if ( $pagenow == 'widgets.php' ) {

echo <<<EOF
<style type="text/css">

/*---------------------------------------*/
/*- HERO WIDGET -------------------------*/
.widget-control-actions, .widget-content{overflow:hidden;}

.hero-column{width: 200px;}
.hero-column.left{float: left; margin-right: 20px;}
.hero-column.right{float: right;}

.middle-column{width: 365px; float: left;}
.clear{display: block; clear: both; overflow: hidden;}



.obox-widget-tip{display: block; padding: 0px; margin: 0px 0px 6px; font-size: 10px; color: #999;}

div.widget[id*=_obox_] .widget-top{
	color: #fff;
	text-shadow: 1px 1px rgba(0,0,0,0.4);
	background: #3D556C !important;
	border: 1px solid transparent !important;
	box-shadow: none !important;}
div.widget[id*=_obox_] .widget-top .in-widget-title{color: #f0f0f0;}

div.widget[id*=_obox_feature_] .widget-top{
	color: #fff;
	text-shadow: 1px 1px rgba(0,0,0,0.4);
	background: #F47E81 !important;
	border: 1px solid transparent !important;
	box-shadow: none !important;}

div.widget[id*=_obox_content_] .widget-top, div.widget[id*=_obox_category_widget] .widget-top, div.widget[id*=_obox_product_content_] .widget-top, div.widget[id*=_obox_features_widget] .widget-top, div.widget[id*=_obox_partners_] .widget-top, div.widget[id*=_obox_hero_] .widget-top, div.widget[id*=_obox_page_] .widget-top{
	color: #fff;
	text-shadow: 1px 1px rgba(0,0,0,0.4);
	background: #f96 !important;
	border: 1px solid transparent !important;
	box-shadow: none !important;}

.widget-liquid-right .widget .widget-top, .widget-liquid-right .postbox h3, .widget-liquid-right .stuffbox h3 {margin: 0px !important; border-bottom: none !important;}


.wrap div.updated, .wrap div.error, .media-upload-form div.error {margin: 5px 0px 5px !important;}
.widget .widget-top {overflow: visible !important;}

.theme-widgets {display: none; position: absolute; top: 80px; background: #fff; padding: 20px; width: 280px; margin-left: auto; margin-right: auto; left: 0; right: 0; z-index: 99; box-shadow: 0px 0px 10px rgba(0,0,0,0.4); border-radius: 8px;}
.theme-widgets h2 {margin-top: 0px;}
.theme-widgets h3 {margin-bottom: 8px !important;}

.widget-blue {padding-bottom: 10px; border-bottom: 1px dotted #ccc;}
.widget-blue span {padding: 5px 10px; background: #6784bf; border: 1px solid #365dac; color: #fff; font-weight: bold; text-shadow: 1px 1px rgba(0,0,0,0.4); clear: both; display: block;}
.widget-panel {border-bottom: 1px dotted #ccc;}

.widget-panel span.suggested-widget{display: block; padding: 5px 8px; margin: 0px 0px 5px; color: #fff; font-weight: bold; text-shadow: 1px 1px rgba(0,0,0,0.4); border: 1px solid transparent !important; box-shadow: none !important; border-radius: 3px;}
	.widget-panel span.blue {background: #3D556C;}
	.widget-panel span.orange {background: #f96;}
	.widget-panel span.purple {background: #96c;}
	.widget-panel span.red {background: #F47E81;}
	.widget-panel span.white {background: #f0f0f0; color: #333; text-shadow: 1px 1px rgba(255, 255, 255, 0.4);}

.widget .widget-top {overflow: visible !important;}

.button_close {margin-bottom: 0px;}
.button_close a {padding: 5px 10px; margin: 0px; color: #fff; text-decoration: none; background: #c10000; border-radius: 2px; font-weight: bold;}
.button_close a:hover {color: #fff; background: #8d0202;}


</style>
EOF;
}

}

add_action('admin_print_styles-widgets.php', 'obox_widgets_style');

function ocmx_recommended_setup() {
global $pagenow;
    if ( $pagenow == 'widgets.php' ) {

    	echo '<script type="text/javascript">
			  	jQuery(document).ready(function(){
				 	jQuery(".button_widget").click(function() {
				     	jQuery(".theme-widgets").fadeIn("slow");
				 	});

				 	jQuery(".button_close").click(function() {
				  		jQuery(".theme-widgets").fadeOut("slow");
				  	});
			 	});
			 </script>';

  		echo '<div class="theme-widgets">
 				<h2>Suggested Widget Setup</h2>
  				<div class="widget-panel">
  					<h3>Slider</h3>
  					<span class="suggested-widget red">(Obox) Slider</span>
  					<h3>Home Page</h3>
  					<span class="suggested-widget orange">(Obox) Product Category Widget</span>
					<span class="suggested-widget white">(WordPress) Text</span>
  					<span class="suggested-widget orange">(Obox) Hero Widget</span>
  					<span class="suggested-widget orange">(Obox) Content Widget: Services</span>
					<span class="suggested-widget orange">(Obox) Content Widget: Testimonials</span>
					<h3>Home Page-Side-by-Side</h3>
  					<span class="suggested-widget orange">(Obox) Content Widget: Posts</span>
  					<span class="suggested-widget blue">Any BLUE Obox Widget</span>
					<h3>Home Page-Three Column</h3>
  					<span class="suggested-widget blue">Any BLUE Obox Widget</span>
					<span class="suggested-widget blue">(WooCommerce) Featured Products</span>
					<span class="suggested-widget blue">(Obox) Twitter Stream</span>
  					<h3>Footer</h3>
  					<span class="suggested-widget white">(WordPress) Text</span>
					<span class="suggested-widget white">(Obox) Social Links</span>
					<span class="suggested-widget blue">(WordPress) Recent Posts</span>
  					<span class="suggested-widget white">(Obox) Popular Posts</span>
  					
  					
  				</div>
  				<p class="button_close"><a href="#">Close</a></p>
  			  </div>';

	}
}

add_action( 'admin_head', 'ocmx_recommended_setup' );

function ocmx_admin_notice(){
    global $pagenow;
    if ( $pagenow == 'widgets.php' ) {
         echo '<div class="updated">
             		<p>To view the recommended widget setup for this theme <a class="button_widget" href="#">Click Here</a>.</p>
         		</div>';
    }
}
add_action('admin_notices', 'ocmx_admin_notice');

?>