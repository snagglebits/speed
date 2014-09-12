<?php
function ocmx_add_custom_meta(){
	global $obox_meta, $services_meta, $features_meta, $partners_meta, $features_category, $services_category, $partners_category, $testimonials_meta, $team_meta, $portfolio_meta, $slider_meta, $layout, $portfolio_excerpt, $maps, $order;
	$obox_meta = array(
		"media" => array (
			"name"		=> "other_media",
			"default"	=> "",
			"label"		=> "Image",
			"desc"		=> "Select a feature image to use for your post. This will set the WordPress Featured Image automatically.",
			"input_type"	=> "image",
			"input_size"	=> "50",
			"img_width"	=> "535",
			"img_height"	=> "255"
		),
		"video" => array (
			"name"		=> "video_link",
			"default"	=> "",
			"label"		=> "Video Link",
			"desc"		=> "Provide your video link instead of the embed code and we'll use <a href='http://codex.wordpress.org/Embeds' target='_blank'>oEmbed</a> to translate that into a video.",
			"input_type"	=> "text"
		),
		"embed" => array (
			"name"		=> "main_video",
			"default"	=> "",
			"label"		=> "Embed Code",
			"desc"		=> "Input the embed code of your video here.",
			"input_type"	=> "textarea"
		)
	);

	$services_meta = array(
		"icon" => array (
			"name"		=> "icon",
			"default"	=> "",
			"label"		=> "Icon",
			"desc"		=> "Select an icon for your service.",
			"input_type"	=> "image",
			"input_size"	=> "50",
			"img_width"	=> "535",
			"img_height"	=> "255"
		),
		"media" => array (
			"name"		=> "other_media",
			"default"	=> "",
			"label"		=> "Image",
			"desc"		=> "Select a feature image to use for your post. This will set the WordPress Featured Image automatically.",
			"input_type"	=> "image",
			"input_size"	=> "50",
			"img_width"	=> "535",
			"img_height"	=> "255"
		),
		"video" => array (
			"name"		=> "video_link",
			"default"	=> "",
			"label"		=> "Video Link",
			"desc"		=> "Provide your video link instead of the embed code and we'll use <a href='http://codex.wordpress.org/Embeds' target='_blank'>oEmbed</a> to translate that into a video.",
			"input_type"	=> "text"
		),
		"embed" => array (
			"name"		=> "main_video",
			"default"	=> "",
			"label"		=> "Embed Code",
			"desc"		=> "Input the embed code of your video here.",
			"input_type"	=> "textarea"
		)
	);

	$features_meta = array(
		"icon" => array (
			"name"		=> "icon",
			"default"	=> "",
			"label"		=> "Icon",
			"desc"		=> "Select an icon for your feature.",
			"input_type"	=> "image",
			"input_size"	=> "50",
			"img_width"	=> "535",
			"img_height"	=> "255"
		),
		"media" => array (
			"name"		=> "other_media",
			"default"	=> "",
			"label"		=> "Image",
			"desc"		=> "Select a feature image to use for your post. This will set the WordPress Featured Image automatically.",
			"input_type"	=> "image",
			"input_size"	=> "50",
			"img_width"	=> "535",
			"img_height"	=> "255"
		),
		"image_position" => array (
			"name"		=> "image_position",
			"default"	=> "image-right",
			"label"		=> "Features Layout",
			"desc"		=> "Determine how you would like this feature to be laid out. Choose between five different options.",
			"input_type"	=> "image-select",
			"image-folder"	=> "/images/slider-positions/",
			"options" => array("image-left", "image-right", "image-only", "image-title", "text-only")
		),
	);

	$partners_meta = array(
		"media" => array (
			"name"		=> "other_media",
			"default"	=> "",
			"label"		=> "Image",
			"desc"		=> "Select a feature image to use for your post. This will set the WordPress Featured Image automatically.",
			"input_type"	=> "image",
			"input_size"	=> "50",
			"img_width"	=> "535",
			"img_height"	=> "255"
		),
		"link" => array (
			"name"		=> "link",
			"default"	=> "",
			"label"		=> "Link",
			"desc"		=> "eg. http://nike.com",
			"input_type"	=> "text"
		),
	);

	$testimonials_meta = array(
		"media" => array (
			"name"		=> "other_media",
			"default"	=> "",
			"label"		=> "Avatar",
			"desc"		=> "Select a feature image to use for your post. For best results, use square images at least 300x300 pixels with the subject centered",
			"input_type"	=> "image",
			"input_size"	=> "50",
			"img_width"	=> "535",
			"img_height"	=> "255"
		),
		"link" => array (
			"name"		=> "link",
			"default"	=> "",
			"label"		=> "Link",
			"desc"		=> "eg. http://www.brainyquote.com",
			"input_type"	=> "text"
		),
	);

	$team_meta = array(
		"media" => array (
			"name"		=> "other_media",
			"default"	=> "",
			"label"		=> "Image / Logo",
			"desc"		=> "Select a feature image to use for your post.",
			"input_type"	=> "image",
			"input_size"	=> "50",
			"img_width"	=> "535",
			"img_height"	=> "255"
		),
		"position" => array (
			"name"		=> "position",
			"default"	=> "",
			"label"		=> "Position",
			"desc"		=> "eg. CEO, Co-founder.",
			"input_type"	=> "text"
		),
		"facebook" => array (
			"name"		=> "facebook",
			"default"	=> "",
			"label"		=> "Facebook",
			"desc"		=> "eg. http://facebook.com/mark",
			"input_type"	=> "text"
		),
		"twitter" => array (
			"name"		=> "twitter",
			"default"	=> "",
			"label"		=> "Twitter",
			"desc"		=> "eg. http://twitter.com/jack",
			"input_type"	=> "text"
		),
		"linkedin" => array (
			"name"		=> "linkedin",
			"default"	=> "",
			"label"		=> "LinkedIn",
			"desc"		=> "eg. http://www.linkedin.com/profile/view?id=48580712",
			"input_type"	=> "text"
		)
	);

	$portfolio_meta = array(
		"media" => array (
			"name"		=> "other_media",
			"default"	=> "",
			"label"		=> "Image",
			"desc"		=> "Select a feature image to use for your post.",
			"input_type"	=> "image",
			"input_size"	=> "50",
			"img_width"	=> "535",
			"img_height"	=> "255"
		),
		"video" => array (
			"name"		=> "video_link",
			"default"	=> "",
			"label"		=> "Video Link",
			"desc"		=> "Provide your video link instead of the embed code and we'll use <a href='http://codex.wordpress.org/Embeds' target='_blank'>oEmbed</a> to translate that into a video.",
			"input_type"	=> "text"
		),
		"embed" => array (
			"name"		=> "main_video",
			"default"	=> "",
			"label"		=> "Embed Code",
			"desc"		=> "Input the embed code of your video here.",
			"input_type"	=> "textarea"
		),
		"client" => array (
			"name"		=> "client",
			"default"	=> "",
			"label"		=> "Client",
			"desc"		=> "eg. Samsung",
			"input_type"	=> "text"
		),
		"website" => array (
			"name"		=> "website",
			"default"	=> "",
			"label"		=> "Website External Link",
			"desc"		=> "eg. http://www.samsung.com",
			"input_type"	=> "text"
		)
	);

	$slider_meta = array(
		"media" => array (
			"name"		=> "other_media",
			"default"	=> "",
			"label"		=> "Image / Logo",
			"desc"		=> "Select a feature image to use for your post.",
			"input_type"	=> "image",
			"input_size"	=> "50",
			"img_width"	=> "535",
			"img_height"	=> "255"
		),
		"video" => array (
			"name"		=> "video_link",
			"default"	=> "",
			"label"		=> "Video Link",
			"desc"		=> "Provide your video link instead of the embed code and we'll use <a href='http://codex.wordpress.org/Embeds' target='_blank'>oEmbed</a> to translate that into a video.",
			"input_type"	=> "text"
		),
		"embed" => array (
			"name"		=> "main_video",
			"default"	=> "",
			"label"		=> "Embed Code",
			"desc"		=> "Input the embed code of your video here.",
			"input_type"	=> "textarea"
		),
		"image_position" => array (
			"name"		=> "image_position",
			"default"	=> "image-right",
			"label"		=> "Slider Layout",
			"desc"		=> "Determine how you would like this slide to be laid out. Choose between five different options.",
			"input_type"	=> "image-select",
			"image-folder"	=> "/images/slider-positions/",
			"options" 	=> array("image-left", "image-right", "image-only", "image-title", "text-only")
		),
		"text_colour" => array (
			"name"		=> "text_colour",
			"default"	=> "",
			"label"		=> "Slider Text Colour",
			"desc"		=> "Select a text colour for your slider text.",
			"input_type"	=> "color"
		),
		"link" => array (
			"name"		=> "link",
			"default"	=> "",
			"label"		=> "Button Link",
			"desc"		=> "Provide a link. (Once a link is provided the button will show on the slide)",
			"input_type"	=> "text"
		),
		"button" => array (
			"name"		=> "button",
			"default"	=> "",
			"label"		=> "Button Text",
			"desc"		=> "Provide text for your button.",
			"input_type"	=> "text"
		),
		"button_colour" => array (
			"name"		=> "button_colour",
			"default"	=> "",
			"label"		=> "Button Background Colour",
			"desc"		=> "Select a background for your button.",
			"input_type"	=> "color"
		),
		"sliderbg" => array (
			"name"		=> "sliderbg",
			"default"	=> "",
			"default_colour" => "ffffff",
			"label"		=> "Slider Image Background",
			"desc"		=> "Select a background for your slide (at least 1920px by 520px)",
			"input_type"	=> "background"
		),
		"videobg" => array (
			"name"		=> "videobg",
			"default"	=> "",
			"default_colour" => "ffffff",
			"label"		=> "Slider Video Background",
			"desc"		=> "Enter a selfhosted video to use as your slider background. View detailed instructions <a href='http://kb.oboxsites.com/themedocs/flatpack-how-to-use-video-slider-backgrounds/'>here.</a>",
			"input_type"	=> "selfhosted"
		)
	);

	$layout = array(
		"layout" => array (
			"name"		=> __("layout",'ocmx'),
			"default"	=> __("two-column",'ocmx'),
			"label"		=> __("Layout",'ocmx'),
			"desc"		=> __("Select the layout of your page. (Affects Portfolio, Team, Testimonials, Services, and Partners",'ocmx'),
			"input_type"	=> "image-select",
			"image-folder"	=> "/images/page-layouts/",
			"options" 	=> array("two-column", "three-column", "four-column")
		),
		"header_image" => array (
			"name"		=> __("header_image",'ocmx'),
			"default"	=> __("",'ocmx'),
			"label"		=> __("Custom Header Image",'ocmx'),
			"desc"		=> __("Select an image to carry through this post type.",'ocmx'),
			"input_type"	=> __("background",'ocmx')
		),
		"title-display" => array (
			"name"		=> "title-display",
			"default"	=> 'slider',
			"label"		=> "Display Slider or Title?",
			"desc"		=> "Choose whether to enable the Slider or the standard title bar on Widgetized Pages.",
			"input_type"	=> "select",
			"options" 	=> array("Slider" => "slider", "Title" => "title")
		)
	);

	$order = array(
		"orderby" => array (
			"name" 		=> __("orderby",'ocmx'),
			"default" 	=> __("",'ocmx'),
			"label" 		=> __("Order By",'ocmx'),
			"desc" 		=> __("Select the 'order by' of your Portfolio list.",'ocmx'),
			"input_type" 	=> __("select",'ocmx'),
			"options" 	=> array(__("Post Date",'ocmx') => "date", __("Post Title",'ocmx') => "title", __("Random",'ocmx') => "rand", __("Comment Count",'ocmx') => "comment_count")
		),
		"order" => array (
			"name" 		=> __("order",'ocmx'),
			"default" 	=> __("",'ocmx'),
			"label" 		=> __("Order",'ocmx'),
			"desc" 		=> __("Select the order of your Portfolio list.",'ocmx'),
			"input_type" 	=> __("select",'ocmx'),
			"options" 	=> array(__("Descending",'ocmx') => "desc", __("Ascending",'ocmx') => "asc")
		)
	);

	$portfolio_excerpt = array(
		"excerpt_display" => array (
			"name"		=> "excerpt_display",
			"default"	=> false,
			"label"		=> "Portfolio Excerpt",
			"desc"		=> "Choose whether to enable the Excerpt on the Portfolio List page.",
			"input_type"	=> "select",
			"options" 	=> array("Enable" => "yes", "Disabled" => "no")
		),
		"excerpt_length" => array (
			"name"		=> "excerpt_length",
			"default"	=> "",
			"label"		=> "Portfolio Excerpt Length",
			"desc"		=> "Enter the Excerpt character count",
			"input_type"	=> "text"
		),
	);

	$maps = array(
		"map-display" => array (
			"name"		=> "map-display",
			"default"	=> false,
			"label"		=> "Display Map or Title?",
			"desc"		=> "Choose whether to enable the Google Map or the standard title bar.",
			"input_type"	=> "select",
			"options" 	=> array("Map" => "map", "Title" => "title")
		),
		"location" => array (
			"name"		=> "map-location",
			"default"	=> "",
			"label"		=> "Google Maps Location",
			"desc"		=> "Provide a specific address <br /> i.e. (79 Sample Road, Cape Town, Western Cape, South Africa) <br /> <a href='http://maps.google.com' target='_blank'>Check on Google Maps</a> ",
			"input_type"	=> "text"
		),
		"latlong" => array (
			"name"		=> "map-latlong",
			"default"	=> "",
			"label"		=> "Google Maps Latitude & Longitude (Optional)",
			"desc"		=> "Provide specific GPS co-ordinates for Google Maps. Use this if your location does not have a valid Google Maps Location<br /> i.e. (-34.397, 150.644)",
			"input_type"	=> "text"
		),
		"zoom-level" => array (
			"name"		=> "zoom-level",
			"default"	=> "Default",
			"label"		=> "Zoom Level",
			"desc"		=> "Choose the zoom level for your Google map",
			"input_type"	=> "select",
			"options" 	=> array("Close" => 18, "Default" => 15, "Far" => 12)
		),
		"address" => array (
			"name"		=> "address",
			"default"	=> "",
			"label"		=> "Address Shown",
			"desc"		=> "Provide an Address shown to the public.",
			"input_type"	=> "textarea"
		)
	);

	$features_cats = get_terms("features-category", "orderby=count&hide_empty=0");
	$features_cat_list["All"] = 0;
	foreach($features_cats as $category) :
		if(isset($category->name))
			$features_cat_list[$category->name] = $category->slug;
	endforeach;

	$features_category = array(
		"features-category" => array (
			"name" => "features-category",
			"default" => "",
			"label" => "Features Category",
			"desc" => "Choose which category you'd like to display on the page.",
			"input_type" => "select",
			"options" => $features_cat_list
		)
	);

	$services_cats = get_terms("services-category", "orderby=count&hide_empty=0");
	$services_cat_list["All"] = 0;
	foreach($services_cats as $category) :
		if(isset($category->name))
			$services_cat_list[$category->name] = $category->slug;
	endforeach;

	$services_category = array(
		"services-category" => array (
			"name" => "services-category",
			"default" => "",
			"label" => "Services Category",
			"desc" => "Choose which category you'd like to display on the page.",
			"input_type" => "select",
			"options" => $services_cat_list
		)
	);

	$partners_cats = get_terms("partners-category", "orderby=count&hide_empty=0");
	$partners_cat_list["All"] = 0;
	foreach($partners_cats as $category) :
		if(isset($category->name))
			$partners_cat_list[$category->name] = $category->slug;
	endforeach;

	$partners_category = array(
		"partners-category" => array (
			"name" => "partners-category",
			"default" => "",
			"label" => "Partners Category",
			"desc" => "Choose which category you'd like to display on the page.",
			"input_type" => "select",
			"options" => $partners_cat_list
		)
	);

	
}
add_action( 'admin_menu', 'ocmx_add_custom_meta' );

function create_meta_box_ui() {
	global $post, $layout, $portfolio_excerpt, $maps, $features_category, $services_category, $partners_category, $order, $obox_meta;
	if(get_post_type($post->ID) == "page") :
		$obox_meta = array_merge($layout, $obox_meta);
	endif;
	if(strpos(get_page_template(), 'portfolio.php')) :
		$obox_meta = array_merge($portfolio_excerpt, $order, $obox_meta);
	endif;
	if(strpos(get_page_template(), 'features.php')) :
		$obox_meta = array_merge($features_category, $obox_meta);
	endif;
	if(strpos(get_page_template(), 'services.php')) :
		$obox_meta = array_merge($services_category, $obox_meta);
	endif;
	if(strpos(get_page_template(), 'partners.php')) :
		$obox_meta = array_merge($partners_category, $obox_meta);
	endif;
	if(strpos(get_page_template(), 'features-alternate.php')) :
		$obox_meta = array_merge($features_category, $obox_meta);
	endif;
	if(strpos(get_page_template(), 'contact.php')) :
		$obox_meta = array_merge($maps, $obox_meta);
	endif;

	post_meta_panel($post->ID, $obox_meta);
}

function create_meta_box_ui_services() {
	global $post, $services_meta;
	post_meta_panel($post->ID, $services_meta);
}

function create_meta_box_ui_features() {
	global $post, $features_meta;
	post_meta_panel($post->ID, $features_meta);
}

function create_meta_box_ui_partners() {
	global $post, $partners_meta;
	post_meta_panel($post->ID, $partners_meta);
}

function create_meta_box_ui_testimonials() {
	global $post, $testimonials_meta;
	post_meta_panel($post->ID, $testimonials_meta);
}

function create_meta_box_ui_portfolio() {
	global $post, $portfolio_meta;
	post_meta_panel($post->ID, $portfolio_meta);
}

function create_meta_box_ui_team() {
	global $post, $team_meta;
	post_meta_panel($post->ID, $team_meta);
}

function create_meta_box_ui_slider() {
	global $post, $slider_meta;
	post_meta_panel($post->ID, $slider_meta);
}

function insert_obox_metabox($pID) {
	global $post, $maps, $features_category, $services_category, $partners_category, $obox_meta, $services_meta, $features_meta, $testimonials_meta, $portfolio_meta, $partners_meta, $team_meta, $slider_meta, $meta_added, $layout, $portfolio_excerpt, $order;

	wp_reset_postdata();
	if(get_post_type($post) == "page") :
		$obox_meta = array_merge($obox_meta, $layout);
	endif;
	if( isset( $post ) && strpos(get_page_template(), 'portfolio.php')) :
		$obox_meta = array_merge($obox_meta, $portfolio_excerpt, $order);
	endif;
	if( isset( $post ) && strpos(get_page_template(), 'contact.php')) :
		$obox_meta = array_merge($obox_meta, $maps);
	endif;
	if( isset( $post ) && strpos(get_page_template(), 'features.php')) :
		$obox_meta = array_merge($obox_meta, $features_category);
	endif;
	if( isset( $post ) && strpos(get_page_template(), 'services.php')) :
		$obox_meta = array_merge($obox_meta, $services_category);
	endif;
	if( isset( $post ) && strpos(get_page_template(), 'partners.php')) :
		$obox_meta = array_merge($obox_meta, $partners_category);
	endif;
	if( isset( $post ) && strpos(get_page_template(), 'features-alternate.php')) :
		$obox_meta = array_merge($obox_meta, $features_category);
	endif;

	if(!isset($meta_added) && !empty($post)):
		if(get_post_type() == "services") :
			post_meta_update($post->ID, $services_meta);
			post_type_meta_update($post->ID, "services");
		elseif(get_post_type() == "partners") :
			post_meta_update($post->ID, $partners_meta);
		elseif(get_post_type() == "features") :
			post_meta_update($post->ID, $features_meta);
		elseif(get_post_type() == "portfolio") :
			post_meta_update($post->ID, $portfolio_meta);
		elseif(get_post_type() == "testimonials") :
			post_meta_update($post->ID, $testimonials_meta);
		elseif(get_post_type() == "team") :
			post_meta_update($post->ID, $team_meta);
		elseif(get_post_type() == "slider") :
			post_meta_update($post->ID, $slider_meta);
		else :
			post_meta_update($post->ID, $obox_meta);
		endif;
	endif;
	$meta_added = 1;
}

function add_obox_meta_box() {
	if (function_exists('add_meta_box') ) {
		add_meta_box('obox-meta-box',$GLOBALS['obox_themename'].' Options','create_meta_box_ui','post','normal','high');
		add_meta_box('obox-meta-box',$GLOBALS['obox_themename'].' Options','create_meta_box_ui','page','normal','high');

		add_meta_box('obox-meta-box','Services Options','create_meta_box_ui_services','services','normal','high');
		add_meta_box('obox-meta-box','Features Options','create_meta_box_ui_features','features','normal','high');
		add_meta_box('obox-meta-box','Partners Options','create_meta_box_ui_partners','partners','normal','high');
		add_meta_box('obox-meta-box','Testimonials Options','create_meta_box_ui_testimonials','testimonials','normal','high');
		add_meta_box('obox-meta-box','Portfolio Options','create_meta_box_ui_portfolio','portfolio','normal','high');
		add_meta_box('obox-meta-box','Team Options','create_meta_box_ui_team','team','normal','high');
		add_meta_box('obox-meta-box','Slider Options','create_meta_box_ui_slider','slider','normal','high');
	}
}

function my_page_excerpt_meta_box() {
	add_meta_box( 'postexcerpt', __('Excerpt', 'ocmx'), 'post_excerpt_meta_box', 'page', 'normal', 'core' );
}

add_action('admin_menu', 'add_obox_meta_box');
add_action('admin_menu', 'my_page_excerpt_meta_box');
add_action('admin_head-post-new.php', 'ocmx_change_metatype');
add_action('admin_head-post.php', 'ocmx_change_metatype');
add_action('save_post', 'insert_obox_metabox');
add_action('publish_post', 'insert_obox_metabox');  ?>