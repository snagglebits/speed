<?php function ocmx_theme_options(){
	global $obox_meta, $theme_options, $obox_themename, $obox_themeid, $customizer_options;
	if(!isset($theme_options))
		$theme_options = array();
	$theme_options["general_site_options"] =
			array(
				array("label" => "Custom Logo", "description" => "Full URL or folder path to your custom logo.", "name" => "ocmx_custom_logo", "default" => "", "id" => "upload_button", "input_type" => "file", "args" => array("width" => 90, "height" => 75)),
				array("label" => "Favicon", "description" => "Select a favicon for your site", "name" => "ocmx_custom_favicon", "default" => "", "id" => "upload_button_favicon", "input_type" => "file", "sub_title" => "favicon", "args" => array("width" => 16, "height" => 16)),
				array("label" => "Custom Login Logo", "description" => "Select a custom login logo, recommended dimensions (326px x 82px)", "name" => "ocmx_custom_login", "default" => "", "id" => "upload_button_login", "input_type" => "file", "sub_title" => "login logo", "args" => array("width" => 326, "height" => 82)),
				array(
					"main_section" => "Facebook Sharing Options",
					"main_description" => "Set a default image URL to appear on Facebook shares if no featured image is found. Recommended size 200x200.",
					"sub_elements" =>
						array(
							array("label" => "Disable OpenGraph?", "description" => "Select No if you want to disable the theme's OpenGraph support(do this only if using a conflicting plugin)", "name" => "ocmx_open_graph", "default" => "no", "id" => "ocmx_open_graph", "input_type" => 'select', 'options' => array('Yes' => 'yes', 'No' => 'no')
							),

							array("label" => "Image URL", "description" => "", "name" => "ocmx_site_thumbnail", "sub_title" => "Open Graph image", "default" => "", "id" => "upload_button_ocmx_site_thumbnail", "input_type" => "file", "args" => array("width" => 80, "height" => 80)
							)
						)
				),
				array("label" => "Breadcrumbs", "description" => "Select whether or not to display breadcrumbs throughout the site.","name" => "ocmx_breadcrumbs", "default" => "yes", "id" => "ocmx_breadcrumbs", "input_type" => 'select', 'options' => array('Enabled' => 'yes', 'Disabled' => 'no')),

				array(
					"main_section" => "Post Meta &amp; Content Display",
					"main_description" => "These settings control which post meta is displayed in posts and lists.",
					"sub_elements" =>
						array(
							array("label" => "Show Date", "name" => "ocmx_meta_date_post", "", "default" => "true", "id" => "ocmx_meta_date_post", "input_type" => "checkbox"),
							array("label" => "Show Author", "name" => "ocmx_meta_author_post", "", "default" => "true", "id" => "ocmx_meta_author_post", "input_type" => "checkbox"),
							array("label" => "Show Category", "name" => "ocmx_meta_category", "", "default" => "true", "id" => "ocmx_meta_category", "input_type" => "checkbox"),
							array("label" => "Show Tags", "name" => "ocmx_meta_tags", "default" => "true", "id" => "ocmx_meta_tags", "input_type" => "checkbox"),
							array("label" => "Show Social Sharing", "name" => "ocmx_meta_social_post", "default" => "true", "id" => "ocmx_meta_social_post", "input_type" => "checkbox"),
							array("label" => "Show Next & Previous Posts", "description" => "Uncheck to hide Next and Previous post links in posts and gallery items", "name" => "ocmx_meta_post_links", "default" => "false", "id" => "ocmx_meta_post_links", "input_type" => "checkbox"),
							array("label" => "Content Length on List Pages", "description" => "Selecting excerpts will show the Read More link.","name" => "ocmx_content_length", "default" => "yes", "id" => "ocmx_content_length", "input_type" => 'select', 'options' => array('Show Excerpts' => 'yes', 'Show Full Post Content' => 'no')),
						)
					),
				array(
					"main_section" => "Page Meta",
					"main_description" => "These settings control which post meta is displayed in pages.",
					"sub_elements" =>
						array(
							array("label" => "Show Date", "name" => "ocmx_meta_date_page", "", "default" => "true", "id" => "ocmx_meta_date_page", "input_type" => "checkbox"),
							array("label" => "Show Author", "name" => "ocmx_meta_author_page", "", "default" => "true", "id" => "ocmx_meta_author_page", "input_type" => "checkbox"),
							array("label" => "Show Social Sharing", "name" => "ocmx_meta_social_page", "default" => "true", "id" => "ocmx_meta_social", "input_type" => "checkbox"),
						)
					),
								array(
					"main_section" => "Custom Styling",
					"main_description" => "Set your own custom social buttons and CSS for any element you wish to restyle.",
					"sub_elements" =>
						array(

							array("label" => "Custom CSS", "description" => "Enter changed classes from the theme stylesheet, or custom CSS here.", "name" => "ocmx_custom_css", "default" => "", "id" => "ocmx_custom_css", "input_type" => "memo"),
							array("label" => "Social Widget Code", "description" => "Paste the template tag or code for your social sharing plugin here.", "name" => "ocmx_social_tag", "default" => "", "id" => "", "input_type" => "memo"),
							 )
					),
				array("label" => "Custom RSS URL", "description" => "Paste the URL to your custom RSS feed, such as Feedburner.", "name" => "ocmx_rss_url", "default" => "", "id" => "", "input_type" => "text"),
				array(
					"main_section" => "Press Trends Analytics",
					"main_description" => "Select Yes Opt out. No personal data is collected.",
					"sub_elements" =>
					array(
						array("label" => "Disable Press Trends?", "description" => "PressTrends helps Obox build better themes and provide awesome support by retrieving aggregated stats. PressTrends also provides a <a href='http://wordpress.org/extend/plugins/presstrends/' title='PressTrends Plugin for WordPress' target='_blank'>plugin for you</a> that delivers stats on how your site is performing against similar sites like yours. <a href='http://www.presstrends.me' title='PressTrends' target='_blank'>Learn more&hellip;</a>","name" => "ocmx_disable_press_trends", "default" => "no", "id" => "ocmx_disable_press_trends", "input_type" => 'select', 'options' => array('Yes' => 'yes', 'No' => 'no'))
						 )
					 )
			);

	$theme_options["header_options"] = array(
		array(
			"main_section" => "Top Header Block",
			"main_description" => "These settings control the header block at the top of the website.",
			"sub_elements" =>
				array(
					array("label" => "Top Header Block", "name" => "ocmx_header_contact_show", "default" => "true", "id" => "ocmx_header_contact_show", "input_type" => 'select', 'options' => array('Enabled' => 'true', 'Disabled' => 'false')),
					array("label" => "Header Search", "description" => "Select whether or not to display a search field in the header.","name" => "ocmx_header_search", "default" => "yes", "id" => "ocmx_header_search", "input_type" => 'select', 'options' => array('Enabled' => 'yes', 'Disabled' => 'no')),
					array("label" => "Phone Number", "name" => "ocmx_header_contact_phone", "", "default" => "", "id" => "ocmx_header_contact_phone", "input_type" => "input"),
					array("label" => "Email", "name" => "ocmx_header_contact_email", "", "default" => "", "id" => "ocmx_header_contact_email", "input_type" => "input"),
					array("label" => "Facebook Link", "name" => "ocmx_header_contact_facebook", "", "default" => "", "id" => "ocmx_header_contact_facebook", "input_type" => "input"),
					array("label" => "Twitter Link", "name" => "ocmx_header_contact_twitter", "", "default" => "", "id" => "ocmx_header_contact_twitter", "input_type" => "input"),
					array("label" => "LinkedIn Link", "name" => "ocmx_header_contact_linkedin", "", "default" => "", "id" => "ocmx_header_contact_linkedin", "input_type" => "input"),
					array("label" => "Google Plus Link", "name" => "ocmx_header_contact_gplus", "", "default" => "", "id" => "ocmx_header_contact_gplus", "input_type" => "input"),
					array("label" => "Pinterest Link", "name" => "ocmx_header_contact_pinterest", "", "default" => "", "id" => "ocmx_header_contact_pinterest", "input_type" => "input"),
				)
		),
		array("label" => "eCommerce", "description" => "Select whether or not to display the header cart throughout the site.","name" => "ocmx_headercart", "default" => "yes", "id" => "ocmx_headercart", "input_type" => 'select', 'options' => array('Enabled' => 'yes', 'Disabled' => 'no')),
		array("label" => "Title Banner Display", "description" => "Select whether or not to display the title banner.","name" => "ocmx_hide_title", "default" => "yes", "id" => "ocmx_hide_title", "input_type" => 'select', 'options' => array('Show Title' => 'yes', 'Hide Title' => 'no')),
		array("label" => "Page Title Description", "description" => "Select whether or not to display a description below the page titles throughout the site.","name" => "ocmx_pagetitle_copy", "default" => "yes", "id" => "ocmx_pagetitle_copy", "input_type" => 'select', 'options' => array('Enabled' => 'yes', 'Disabled' => 'no')),
		array(
			"main_section" => "Navigation",
			"main_description" => "",
			"sub_elements" => array(
				array(
					"label" => "Menu Style", 
					"description" => "Select whether to display an expanded or compact menu.",
					"name" => "ocmx_menu_style", 
					"default" => "compact", 
					"id" => "ocmx_menu_style", 
					"input_type" => 'select', 
					'options' => array('Compact' => 'compact', 'Expanded' => 'expanded')
				),
				array(
					"label" => "Menu Label",
					"description" => "","name" => "ocmx_menu_button_label",
					"default" => "Menu",
					"id" => "ocmx_menu_button_label",
					"input_type" => "text"
				)
			)
		)

	);

	$theme_options["footer_options"] = array(
				array(
						"main_section" => "Site Wide Call to Action",
						"main_description" => "These settings control the site wide call to action at the bottom of the website.",
						"sub_elements" =>
							array(
								array("label" => "Show Site Wide Call to Action", "name" => "ocmx_footer_cta_show", "", "default" => "true", "id" => "ocmx_footer_cta_show", "input_type" => "checkbox"),
								array("label" => "Text", "name" => "ocmx_footer_cta_text", "", "default" => "", "id" => "ocmx_footer_cta_text", "input_type" => "input"),
								array("label" => "Button Text", "name" => "ocmx_footer_cta_button_text", "", "default" => "", "id" => "ocmx_footer_cta_button_text", "input_type" => "input"),
								array("label" => "Button Link", "name" => "ocmx_footer_cta_button_link", "", "default" => "", "id" => "ocmx_footer_cta_button_link", "input_type" => "input"),
							)
						),

				array("label" => "Custom Footer Text", "description" => "", "name" => "ocmx_custom_footer", "default" => "Copyright ".date("Y")."&nbsp;". $obox_themename." was created in WordPress by Obox Themes."	, "id" => "ocmx_custom_footer", "input_type" => "memo"),
				array("label" => "Hide Back to Top", "description" => "Hide the Back to Top button.", "name" => "ocmx_backtop", "default" => "false", "id" => "ocmx_backtop", "input_type" => 'select', 'options' => array('Yes' => 'true', 'No' => 'false')),
				array("label" => "Hide Obox Logo", "description" => "Hide the Obox Logo from the footer.", "name" => "ocmx_logo_hide", "default" => "false", "id" => "ocmx_logo_hide", "input_type" => 'select', 'options' => array('Yes' => 'true', 'No' => 'false')),
				array("label" => "Site Analytics", "description" => "Enter in the Google Analytics Script here.","name" => "ocmx_googleAnalytics", "default" => "", "id" => "","input_type" => "memo")
	);

	$theme_options["layout_options"] = array(
		array(
				"label" => "Site Layout",
				"description" => "Would you like your site to be contained or span the full width of your web page?",
				"name" => "ocmx_site_layout", "default" => "fullwidth",
				"id" => "ocmx_site_layout",
				"input_type" => "hidden",
				"default" => "fullwidth",
				"options" =>
					array(
							"fullwidth" => array("label" => "Wide", "description" => ""),
							"boxed" => array("label" => "Boxed", "description" => "")
						)
				),
		array(
				"label" => "Home Page Layout",
				"description" => "Set your home page to either display as a blog, mimic our theme demo or take full control by using widgets.",
				"name" => "ocmx_home_page_layout", "default" => "blog",
				"id" => "ocmx_home_page_layout",
				"input_type" => "hidden",
				"default" => "blog",
				"options" =>
					array(
							"blog" => array("label" => "Blog", "description" => "Set your home page to display like a normal blog.", "load_options" => "widget_home_options"),
							"preset" => array("label" => "Preset", "description" => "Mimic the exact layout of our theme demo.", "load_options" => "preset_home_options"),
							"widget" => array("label" => "Widget Driven", "description" => "Take control by setting up your home page with widgets.")
						)
				),
		array(
				"label" => "Sidebar Layout",
				"description" => "Choose which side you would like your site sidebar to display on posts and pages. Alternatively hide it completely on all pages.",
				"name" => "ocmx_sidebar_layout", "default" => "sidebarright",
				"id" => "ocmx_sidebar_layout",
				"input_type" => "hidden",
				"default" => "sidebarright",
				"options" =>
					array(
							"sidebarright" => array("label" => "Sidebar Right", "description" => ""),
							"sidebarleft" => array("label" => "Sidebar Left", "description" => ""),
							"sidebarnone" => array("label" => "No Sidebar", "description" => "")
						)
				),
		array(
			"label" => "Shop Sidebar Layout",
			"description" => "Choose which side you would like your shop sidebar to display on posts and pages. Alternatively hide it completely on all shoppages.",
			"name" => "ocmx_shop_sidebar_layout", "default" => "sidebarright",
			"id" => "ocmx_shop_sidebar_layout",
			"input_type" => "hidden",
			"default" => "sidebarright",
			"options" =>
				array(
					"sidebarright" => array("label" => "Sidebar Right", "description" => ""),
					"sidebarleft" => array("label" => "Sidebar Left", "description" => ""),
					"sidebarnone" => array("label" => "No Sidebar", "description" => "")
				)
		)
	);

$slider_cats = get_terms("slider-category", "orderby=count&hide_empty=0");
$slider_cat_list["Exclude This Widget"] = 1;
$slider_cat_list["All"] = 0;
foreach($slider_cats as $category) :
	if(isset($category->name))
		$slider_cat_list[$category->name] = $category->slug;
endforeach;

$services_cats = get_terms("services-category", "orderby=count&hide_empty=0");
$services_cat_list["Exclude This Widget"] = 1;
$services_cat_list["All"] = 0;
foreach($services_cats as $category) :
	if(isset($category->name))
		$services_cat_list[$category->name] = $category->slug;
endforeach;

$products_cats = get_terms("product_cat", "orderby=count&hide_empty=0");
$products_cat_list["Exclude This Widget"] = 1;
$products_cat_list["All"] = 0;
foreach($products_cats as $category) :
	if(isset($category->name))
		$products_cat_list[$category->name] = $category->slug;
endforeach;

$posts_cats = get_terms("category", "orderby=count&hide_empty=0");
$posts_cat_list["Exclude This Widget"] = 1;
$posts_cat_list["All"] = 0;
foreach($posts_cats as $category) :
	if(isset($category->name))
		$posts_cat_list[$category->name] = $category->slug;
endforeach;

$partners_cats = get_terms("partners-category", "orderby=count&hide_empty=0");
$partners_cat_list["Exclude This Widget"] = 1;
$partners_cat_list["All"] = 0;
foreach($partners_cats as $category) :
	if(isset($category->name))
		$partners_cat_list[$category->name] = $category->slug;
endforeach;

$posts_cats = get_terms("category", "orderby=count&hide_empty=0");
$posts_cat_list["Exclude This Widget"] = 1;
$posts_cat_list["All"] = 0;
foreach($posts_cats as $category) :
	if(isset($category->name))
		$posts_cat_list[$category->name] = $category->slug;
endforeach;

$theme_options["preset_home_options"] =
	array(
		array(
			"main_section" => "Feature Slider",
			"main_description" => "Select which posts will be used for the Homepage Post Slider.",
			"sub_elements" =>
				array(
					array("label" => "Category", "description" => "", "name" => "ocmx_slider_cat", "default" => "0", "zero_wording" => "Exclude This Widget", "id" => "ocmx_slider_cat", "input_type" => "select", "options" => $slider_cat_list),
					array("label" => "Post Count", "description" => "", "name" => "ocmx_feature_post_count", "default" => "0", "id" => "ocmx_feature_post_count", "input_type" => "select", "options" => array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10")),
					array("label" => "Auto Slide Interval (seconds)", "description" => "(Set to 0 for no auto-sliding)", "name" => "ocmx_feature_post_interval", "id" => "", "input_type" => "input"),
			)
		),

		array(
			"main_section" => "Product Categories Four Column (Requires the WooCommerce plugin.)",
			"main_description" => "Select a category for the Four Column products on the home page.",
			"sub_elements" =>
				array(
					array("label" => "Title", "description" => "", "name" => "ocmx_products_four_col_cat_title", "id" => "", "input_type" => "input"),

					array("label" => "Column 1 Category", "description" => "", "name" => "ocmx_products_four_col_cat_one", "default" => "0", "zero_wording" => "Exclude this Widget", "id" => "ocmx_products_four_col_cat_one", "input_type" => "select", "options" => $products_cat_list),

					array("label" => "Column 2 Category", "description" => "", "name" => "ocmx_products_four_col_cat_two", "default" => "0", "zero_wording" => "Exclude this Widget", "id" => "ocmx_products_four_col_cat_two", "input_type" => "select", "options" => $products_cat_list),

					array("label" => "Column 3 Category", "description" => "", "name" => "ocmx_products_four_col_cat_three", "default" => "0", "zero_wording" => "Exclude this Widget", "id" => "ocmx_products_four_col_cat_three", "input_type" => "select", "options" => $products_cat_list),
					array("label" => "Column 4 Category", "description" => "", "name" => "ocmx_products_four_col_cat_four", "default" => "0", "zero_wording" => "Exclude this Widget", "id" => "ocmx_products_four_col_cat_four", "input_type" => "select", "options" => $products_cat_list)
				)
		),
	
		array(
			"main_section" => "Products Four Column (Requires the WooCommerce plugin.)",
			"main_description" => "Select a category for the Four Column products on the home page.",
			"sub_elements" =>
				array(
					array("label" => "Title", "description" => "", "name" => "ocmx_products_four_col_title", "id" => "", "input_type" => "input"),
					array("label" => "Category", "description" => "", "name" => "ocmx_products_four_col_cat", "default" => "0", "zero_wording" => "Exclude this Widget", "id" => "ocmx_products_four_col_cat", "input_type" => "select", "options" => $products_cat_list),
					array("label" => "Post Count", "description" => "", "name" => "ocmx_products_four_col_post_count", "default" => "0", "id" => "", "input_type" => "select", "options" => array("4" => "4", "8" => "8", "12" => "12"))
				)
		),
		
		array(
			"main_section" => "Text Widget",
			"main_description" => "Select a category for the Two Column posts on the home page..",
			"sub_elements" =>
				array(
					array("label" => "Title", "description" => "", "name" => "ocmx_text_widget_title", "id" => "", "input_type" => "input"),
					array("label" => "Text", "description" => "", "name" => "ocmx_text_widget_text", "id" => "", "input_type" => "memo"),
				)
		),

		array(
			"main_section" => "Products Four Column (Requires the WooCommerce plugin.)",
			"main_description" => "Select a category for the Four Column products on the home page.",
			"sub_elements" =>
				array(
					array("label" => "Title", "description" => "", "name" => "ocmx_products_four_col_two_title", "id" => "", "input_type" => "input"),
					array("label" => "Category", "description" => "", "name" => "ocmx_products_four_col_two_cat", "default" => "0", "zero_wording" => "Exclude this Widget", "id" => "ocmx_products_four_col_two_cat", "input_type" => "select", "options" => $products_cat_list),
					array("label" => "Post Count", "description" => "", "name" => "ocmx_products_four_col_two_post_count", "default" => "0", "id" => "", "input_type" => "select", "options" => array("4" => "4", "8" => "8", "12" => "12"))
				)
		),
		
		array(
			"main_section" => "Services Three Column",
			"main_description" => "Select options for your services.",
			"sub_elements" =>
				array(
					array("label" => "Title", "description" => "", "name" => "ocmx_services_three_col_title", "id" => "", "input_type" => "input"),
					array("label" => "Category", "description" => "", "name" => "ocmx_services_three_col_cat", "default" => "0", "zero_wording" => "Exclude this Widget", "id" => "ocmx_feature_post_cat", "input_type" => "select", "options" => $services_cat_list),

					array("label" => "Post Count", "description" => "", "name" => "ocmx_services_three_col_post_count", "default" => "0", "id" => "", "input_type" => "select", "options" => array("3" => "3", "6" => "6", "9" => "9", "12" => "12")),

					array("label" => "Show Excerpt", "description" => "", "name" => "ocmx_services_three_col_excerpt", "default" => "0", "zero_wording" => "Yes", "id" => "", "input_type" => "select", "options" => array("Yes" => "on", "No" => "off")),

					array("label" => "Excerpt Length (character count)", "description" => "", "name" => "ocmx_services_three_col_excerpt_length", "id" => "", "input_type" => "input")

				)
		),

		array(
			"main_section" => "Partners Six Column",
			"main_description" => "",
			"sub_elements" =>
				array(
					array("label" => "Title", "description" => "", "name" => "ocmx_partners_six_col_title", "id" => "", "input_type" => "input"),
					array("label" => "Category", "description" => "", "name" => "ocmx_partners_six_col_cat", "default" => "0", "zero_wording" => "Exclude this Widget", "id" => "ocmx_partners_six_col_cat", "input_type" => "select", "options" => $partners_cat_list),
					array("label" => "Post Count", "description" => "", "name" => "ocmx_partners_six_col_post_count", "default" => "6", "id" => "", "input_type" => "select", "options" => array("6" => "6", "12" => "12", "18" => "18"))
				)
		),

		array(
			"main_section" => "Posts Three Column",
			"main_description" => "Select a category for the Three Column posts on the home page.",
			"sub_elements" =>
				array(
					array("label" => "Title", "description" => "", "name" => "ocmx_posts_three_col_title", "id" => "", "input_type" => "input"),

					array("label" => "Category", "description" => "", "name" => "ocmx_posts_three_col_cat", "default" => "", "zero_wording" => "Exclude this Widget", "id" => "ocmx_posts_three_col_cat", "input_type" => "select", "options" => $posts_cat_list),

					array("label" => "Post Count", "description" => "", "name" => "ocmx_posts_three_col_post_count", "default" => "0", "id" => "", "input_type" => "select", "options" => array("3" => "3", "6" => "6", "9" => "9")),

					array("label" => "Show Images/Video?", "description" => "", "name" => "ocmx_posts_three_col_images", "default" => "0", "id" => "", "input_type" => "select", "options" => array("Images" => "1", "Videos" => "0", "None" => "none")),

					array("label" => "Show Date", "description" => "", "name" => "ocmx_posts_three_col_date", "default" => "0", "zero_wording" => "Yes", "id" => "", "input_type" => "select", "options" => array("Yes" => "on", "No" => "off")),

					array("label" => "Show Excerpt", "description" => "", "name" => "ocmx_posts_three_col_excerpt", "default" => "0", "zero_wording" => "Yes", "id" => "", "input_type" => "select", "options" => array("Yes" => "on", "No" => "off")),

					array("label" => "Excerpt Length (character count)", "description" => "", "name" => "ocmx_posts_three_col_excerpt_length", "id" => "", "input_type" => "input"),

					array("label" => "Show Read More", "description" => "", "name" => "ocmx_posts_three_col_readmore", "default" => "0", "zero_wording" => "Yes", "id" => "", "input_type" => "select", "options" => array("Yes" => "on", "No" => "off"))
				)
		),

		array(
			"main_section" => "Text Widget",
			"main_description" => "Select a category for the Two Column posts on the home page..",
			"sub_elements" =>
				array(
					array("label" => "Title", "description" => "", "name" => "ocmx_text_widget_title_two", "id" => "", "input_type" => "input"),
					array("label" => "Text", "description" => "", "name" => "ocmx_text_widget_text_two", "id" => "", "input_type" => "memo"),
				)
		)
	);
	$theme_options["small_ad_options"] = array(
		array(
				"label" => "Number of Small Ads",
				"description" => "When using the select box, you must click \"Save Changes\" before the blocks are added or removed.",
				"name" => "ocmx_small_ads",
				"id" =>  "ocmx_small_ads",
				"prefix" => "ocmx_small_ad",
				"default" => "0",
				"input_type" => "select",
				"options" => array("None" => "0", "1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10"),
				"args" => array("width" => 125, "height" => "125")
			)
	  );

	$theme_options["medium_ad_options"] = array(
		array(
				"label" => "Number of Medium Ads",
				"description" => "",
				"name" => "ocmx_medium_ads",
				"id" =>  "ocmx_medium_ads",
				"prefix" => "ocmx_medium_ad",
				"default" => "0",
				"input_type" => "select",
				"options" => array("None" => "0", "1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10"),
				"args" => array("width" => 300, "height" => "250")
			)
		);

	// CUSTOMIZER SETTINGS
	$customizer_options[] = array(
			'section_title' => 'Header - Menu',
			'section_slug' => 'obox_header_menu',
			'elements' => array(
					array(
						'slug' => 'obox_contact_header_background',
						'label' => 'Contact Header Background',
						'default' => '#fff',
						'selectors' => '#header-contact-container, .header-search .search_button, .icon-search',
						'css'	=> 'background-color',
						'jquery'	=> 'backgroundColor'
					),
					array(
						'slug' => 'obox_contact_header_text',
						'label' => 'Contact Header Text',
						'default' => '#999',
						'selectors' => '#header-contacts, #header-contacts a, .header-number, #top-nav li a',
						'css'	=> 'color',
						'jquery'	=> 'color'
					),
					array(
						'slug' => 'obox_header_cart',
						'label' => 'Header Cart Background',
						'default' => '#fff',
						'selectors' => '.header-cart',
						'css'	=> 'background',
						'jquery'	=> 'background'
					),
					array(
						'slug' => 'obox_header_cart_divide',
						'label' => 'Header Cart Dividers',
						'default' => '#e0e0e0',
						'selectors' => '.header-cart li',
						'css'	=> 'border-color',
						'jquery'	=> 'borderColor'
					),
					array(
						'slug' => 'obox_header_background',
						'label' => 'Header Background',
						'default' => '#000',
						'selectors' => '#header-container, .header-shrink #header-container',
						'css'	=> 'background-color',
						'jquery'	=> 'backgroundColor'
					),
					array(
						'slug' => 'obox_navigation_font_color',
						'label' => 'Link',
						'default' => '#fff',
						'selectors' => '.expanded ul#nav li a',
						'css'	=> 'color',
						'jquery'	=> 'color'
					),
					array(
						'slug' => 'obox_navigation_hover',
						'label' => 'Link Hover',
						'default' => '#fc0',
						'selectors' => '.expanded ul#nav li a:hover',
						'css'	=> 'color',
						'jquery'	=> 'color'
					),
					array(
						'slug' => 'obox_nav_background',
						'label' => 'Drop Menu Background',
						'default' => '#fff',
						'selectors' => '.compact ul#nav, .compact ul#nav ul.sub-menu, .compact ul#nav .children, .expanded ul#nav ul.sub-menu, .expanded ul#nav .children',
						'css'	=> 'background-color',
						'jquery'	=> 'backgroundColor'
					),
					array(
						'slug' => 'obox_nav_borders',
						'label' => 'Drop Menu Borders',
						'default' => '#000',
						'selectors' => '.compact ul#nav, .compact ul#nav li, .compact ul#nav ul.sub-menu, .compact ul#nav .children, .expanded ul#nav ul.sub-menu, .expanded ul#nav .children, .expanded ul#nav ul.sub-menu li, .expanded ul#nav .children li',
						'css'	=> 'border-color',
						'jquery'	=> 'borderColor'
					),
					array(
						'slug' => 'obox_drop_navigation_font_color',
						'label' => 'Drop Menu Link',
						'default' => '#000',
						'selectors' => '.compact ul#nav li a, .expanded ul#nav ul.sub-menu li a, .expanded ul#nav .children li a',
						'css'	=> 'color',
						'jquery'	=> 'color'
					),
					array(
						'slug' => 'obox_drop_navigation_font_hover',
						'label' => 'Drop Menu Link Hover',
						'default' => '#fff',
						'selectors' => '.expanded ul#nav ul.sub-menu li a:hover, .expanded ul#nav .children li a:hover',
						'css'	=> 'color',
						'jquery'	=> 'color'
					),
					array(
						'slug' => 'obox_navigation_background_hover',
						'label' => 'Drop Menu Background Hover',
						'default' => '#000',
						'selectors' => '.expanded ul#nav ul.sub-menu li a:hover, .expanded ul#nav .children li a:hover',
						'css'	=> 'background-color',
						'jquery'	=> 'backgroundColor'
					)
				),
		);

	$customizer_options[] = array(
		'section_title' => 'Header - Page Title',
		'section_slug' => 'obox_header_pagetitle',
		'elements' => array(
				array(
					'slug' => 'obox_header_pagetitle_text',
					'label' => 'Title',
					'default' => '#000',
					'selectors' => '.title-block h2',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_header_pagetitle_blurb',
					'label' => 'Blurb',
					'default' => '#777',
					'selectors' => '.title-block p',
					'css'	=> 'color',
					'jquery'	=> 'color'
				)
			),
	);

	$customizer_options[] = array(
			'section_title' => 'Header - Breadcrumbs',
			'section_slug' => 'obox_header_breadcrumbs',
			'elements' => array(
					array(
						'slug' => 'obox_header_breadcrumbs_text',
						'label' => 'Text',
						'default' => '#000',
						'selectors' => '#crumbs li, #crumbs .current a',
						'css'	=> 'color',
						'jquery'	=> 'color'
					),
					array(
						'slug' => 'obox_header_breadcrumbs_link',
						'label' => 'Link',
						'default' => '#000',
						'selectors' => '#crumbs li a',
						'css'	=> 'color',
						'jquery'	=> 'color'
					),
					array(
						'slug' => 'obox_header_breadcrumbs_link_hover',
						'label' => 'Link Hover',
						'default' => '#fc0',
						'selectors' => '#crumbs li a:hover',
						'css'	=> 'color',
						'jquery'	=> 'color'
					)
				),
		);

	$customizer_options[] = array(
		'section_title' => 'Body',
		'section_slug' => 'obox_body_content',
		'elements' => array(
				array(
					'slug' => 'obox_body_content_background',
					'label' => 'Background',
					'default' => '#fff',
					'selectors' => '#content-container, #widget-block, #site-wide-container, #wrapper.boxed #widget-block, .woocommerce-tabs, .copy #payment .payment_box, .copy #order_review table tbody strong, .cart_totals table, .woocommerce-info, .next-prev-post-nav, .pagination li.page-count, .shipping_calculator',
					'css'	=> 'background-color',
					'jquery'	=> 'backgroundColor'
				),
				array(
					'slug' => 'obox_content_contained_text',
					'label' => 'Text',
					'default' => '#696969',
					'selectors' => 'body, #widget-block .widget_text .textwidget, .copy #order_review table tfoot th, #payment .payment_methods label, label, .cart_totals th, .woocommerce_message, .woocommerce-message, .related h2, .upsells h2',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_content_contained_link',
					'label' => 'All Links',
					'default' => '#fc0',
					'selectors' => 'a, .copy a, #respond .logged-in-as a, .hero-content-widget .left-col a, .hero-content-widget .right-col a:hover',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_content_contained_link_hover',
					'label' => 'All Links Hover',
					'default' => '#000',
					'selectors' => 'a:hover, .copy a:hover, #respond .logged-in-as a:hover, .hero-content-widget .left-col a:hover, .hero-content-widget .right-col a:hover',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_body_content_borders',
					'label' => 'Borders',
					'default' => '#000',
					'selectors' => '.slider, #widget-block .column, #widget-block .post-image, #footer-container, #footer-base-container, #content, .products .product .img-wrap, .product-images .zoom, .related, .upsells, .comment, .header-cart, table, table td, table tfoot, #payment, .products .product, table tfoot th, input[type=text], input[type=password], .orderby, .shipping_calculator select, .country_select, .state_select, textarea, #payment .payment_methods li, .woocommerce_message, .woocommerce-message, .team .column, .team .post-image, .portfolio-list .column, .portfolio-list .post-image, .portfolio-content #right-column, .single .team .post-image, td .coupon input.input-text, .features-content .related-features-container li, .features-content .related-features-container',
					'css'	=> 'border-color',
					'jquery'	=> 'borderColor'
				),
				array(
					'slug' => 'obox_content_contained_posttitle',
					'label' => 'Post Title',
					'default' => '#000',
					'selectors' => '.content-widget .post-title a, post-title a, .post-title, .post-title-block .post-title a, .products .product a h3, .product_title, .post-title a',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_content_contained_posttitle_hover',
					'label' => 'Post Title Hover',
					'default' => '#fc0',
					'selectors' => '.content-widget .post-title a:hover, post-title a:hover, .post-title-block .post-title a:hover, .products .product a:hover h3, .product_title:hover, .post-title a:hover',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_content_contained_sectiontitle',
					'label' => 'Section Title',
					'default' => '#fff',
					'selectors' => '#widget-block .content-widget .widgettitle',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_content_contained_sectiontitle_background',
					'label' => 'Section Title Background',
					'default' => '#000',
					'selectors' => '#widget-block .content-widget .widgettitle',
					'css'	=> 'background',
					'jquery'	=> 'background'
				),
				array(
					'slug' => 'obox_content_contained_meta',
					'label' => 'Meta',
					'default' => '#777',
					'selectors' => '.post-date, .content-widget .post-date, .product_meta span, .product_meta a, .product_meta span.sku, .woocommerce-result-count',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_content_contained_nextprev_text',
					'label' => 'Next &amp; Previous Post Text',
					'default' => '#000',
					'selectors' => '.next-prev-post-nav, .next-prev-post-nav a',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_content_ecommerce_price',
					'label' => 'Price',
					'default' => '#777',
					'selectors' => '.price, .product-content-widget .price, .products .product .price, .price_slider_amount .price_label',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_content_ecommerce_sale',
					'label' => 'Sale',
					'default' => '#e74c3c',
					'selectors' => '.onsale',
					'css'	=> 'background-color',
					'jquery'	=> 'backgroundColor'
				),
				array(
					'slug' => 'obox_content_ecommerce_sale_text',
					'label' => 'Sale Text',
					'default' => '#fff',
					'selectors' => '.onsale',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_button_background',
					'label' => 'Button Background',
					'default' => '#000',
					'selectors' => '.content-widget .read-more, .post-content .read-more, #respond #submit, input[type=submit], #searchform input[type=submit], .comment .reply a, button, .button, .added_to_cart, input[type=submit], .cart-link, .checkout-link, .quantity .plus, .quantity .minus, #back-top a, .copy .button, #payment .place-order input[type=submit], .tabs li a, .portfolio-meta a, .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .pagination .next a, .copy .shipping_calculator h2 a, .features-content .related-features-container .active, .portfolio-categories a',
					'css'	=> 'background-color',
					'jquery'	=> 'backgroundColor'
				),
				array(
					'slug' => 'obox_button_text',
					'label' => 'Button Text',
					'default' => '#fff',
					'selectors' => '.content-widget .read-more, .post-content .read-more, #respond #submit, input[type=submit], #searchform input[type=submit], .comment .reply a, button, .button, .added_to_cart, input[type=submit], .cart-link, .checkout-link, .quantity .plus, .quantity .minus, .copy .button, #payment .place-order input[type=submit], .tabs li a, .portfolio-meta a, .pagination .next a, .copy .shipping_calculator h2 a, .features-content .related-features-container .active, .portfolio-categories a',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_button_background_hover',
					'label' => 'Button Background Hover',
					'default' => '#fc0',
					'selectors' => '.content-widget .read-more:hover, .post-content .read-more:hover, #respond #submit:hover, input[type=submit]:hover, #searchform input[type=submit]:hover, .comment .reply a:hover, button:hover, .button:hover, .added_to_cart:hover, input[type=submit]:hover, .cart-link:hover, .checkout-link:hover, .quantity .plus:hover, .quantity .minus:hover, #back-top a:hover, .copy .button:hover, #payment .place-order input[type=submit]:hover, .tabs li.active a, .portfolio-meta a:hover, .pagination .next a:hover, .copy .shipping_calculator h2 a:hover, .features-content .related-features-container .active:hover, .portfolio-categories a:hover',
					'css'	=> 'background-color',
					'jquery'	=> 'backgroundColor'
				),
				array(
					'slug' => 'obox_button_text_hover',
					'label' => 'Button Text Hover',
					'default' => '#fff',
					'selectors' => '.content-widget .read-more:hover, .post-content .read-more:hover, #respond #submit:hover, input[type=submit]:hover, #searchform input[type=submit]:hover, .comment .reply a:hover, button:hover, .button:hover, .added_to_cart:hover, input[type=submit]:hover, .cart-link:hover, .checkout-link:hover, .quantity .plus:hover, .quantity .minus:hover, .copy .button:hover, #payment .place-order input[type=submit]:hover, .tabs li.active a, .portfolio-meta a:hover, .pagination .next a:hover, .copy .shipping_calculator h2 a:hover, .features-content .related-features-container .active:hover, .portfolio-categories a:hover',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_body_input_background',
					'label' => 'Input Background',
					'default' => '#fff',
					'selectors' => 'textarea, input, .orderby, .shipping_calculator select, .country_select, .state_select',
					'css'	=> 'background',
					'jquery'	=> 'background'
				),
				array(
					'slug' => 'obox_body_input_text',
					'label' => 'Input Text',
					'default' => '#595959',
					'selectors' => 'textarea, input, .orderby, .shipping_calculator select, .country_select, .state_select',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_body_table_text',
					'label' => 'Table Head Text',
					'default' => '#000',
					'selectors' => 'table th',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_sidebar_widgettitle',
					'label' => 'Sidebar Widget Title',
					'default' => '#000',
					'selectors' => '#right-column .widgettitle',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_sidebar_link',
					'label' => 'Sidebar Link',
					'default' => '#000',
					'selectors' => '#right-column li a',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_sidebar_link_hover',
					'label' => 'Sidebar Link Hover',
					'default' => '#fc0',
					'selectors' => '#right-column li a:hover',
					'css'	=> 'color',
					'jquery'	=> 'color'
				),
				array(
					'slug' => 'obox_sidebar_divider',
					'label' => 'Sidebar Dividers',
					'default' => '#e0e0e0',
					'selectors' => '#right-column .widget li',
					'css'	=> 'border-color',
					'jquery'	=> 'borderColor'
				),
			)
	);

	$customizer_options[] = array(
			'section_title' => 'Site Wide - Call to Action',
			'section_slug' => 'obox_sitewide_cta',
			'elements' => array(
					array(
						'slug' => 'obox_sitewide_cta_background',
						'label' => 'Background',
						'default' => '#000',
						'selectors' => '.site-wide-cta',
						'css'	=> 'background-color',
						'jquery'	=> 'backgroundColor'
					),
					array(
						'slug' => 'obox_sitewide_cta_text',
						'label' => 'Text',
						'default' => '#fff',
						'selectors' => '.site-wide-cta span',
						'css'	=> 'color',
						'jquery'	=> 'color'
					),
					array(
						'slug' => 'obox_sitewide_cta_button_border',
						'label' => 'Button Border',
						'default' => '#fff',
						'selectors' => '.site-wide-cta .action-link',
						'css'	=> 'border-color',
						'jquery'	=> 'borderColor'
					),
					array(
						'slug' => 'obox_sitewide_cta_button_text',
						'label' => 'Button Text',
						'default' => '#fff',
						'selectors' => '.site-wide-cta .action-link',
						'css'	=> 'color',
						'jquery'	=> 'color'
					),
					array(
						'slug' => 'obox_sitewide_cta_button_background_hover',
						'label' => 'Button Background Hover',
						'default' => '#000',
						'selectors' => '.site-wide-cta .action-link',
						'css'	=> 'background-color',
						'jquery'	=> 'backgroundColor'
					),
					array(
						'slug' => 'obox_sitewide_cta_button_text_hover',
						'label' => 'Button Text Hover',
						'default' => '#fff',
						'selectors' => '.site-wide-cta .action-link',
						'css'	=> 'color',
						'jquery'	=> 'color'
					)
				),
		);

	$customizer_options[] = array(
			'section_title' => 'Footer',
			'section_slug' => 'obox_footer_widgets',
			'elements' => array(
					array(
						'slug' => 'obox_footer_background',
						'label' => 'Background',
						'default' => '#fff',
						'selectors' => '#footer-container, #footer-base-container',
						'css'	=> 'background',
						'jquery'	=> 'background'
					),
					array(
						'slug' => 'obox_footer_widgets_widgettitle',
						'label' => 'Widget Title',
						'default' => '#000',
						'selectors' => '.footer-widgets .widgettitle, .footer-widgets a.widgettitle, .footer-widgets .widgettitle a',
						'css'	=> 'color',
						'jquery'	=> 'color'
					),
					array(
						'slug' => 'obox_footer_widgets_text',
						'label' => 'Text',
						'default' => '#595959',
						'selectors' => '.footer-widgets, .footer-text',
						'css'	=> 'color',
						'jquery'	=> 'color'
					),
					array(
						'slug' => 'obox_footer_widgets_link',
						'label' => 'Link',
						'default' => '#000',
						'selectors' => '.footer-widgets a',
						'css'	=> 'color',
						'jquery'	=> 'color'
					),
					array(
						'slug' => 'obox_footer_widgets_link_hover',
						'label' => 'Link Hover',
						'default' => '#fc0',
						'selectors' => '.footer-widgets a:hover',
						'css'	=> 'color',
						'jquery'	=> 'color'
					),
					array(
						'slug' => 'obox_footer_widgets_divider',
						'label' => 'Footer Widget Dividers',
						'default' => '#e4e4e4',
						'selectors' => '.footer-widgets .widget li',
						'css'	=> 'border-color',
						'jquery'	=> 'borderColor'
					),
					array(
						'slug' => 'obox_footer_base_link',
						'label' => 'Footer Navigation Link',
						'default' => '#000',
						'selectors' => '.footer-text a, ul#footer-nav li a',
						'css'	=> 'color',
						'jquery'	=> 'color'
					),
					array(
						'slug' => 'obox_footer_base_link_hover',
						'label' => 'Footer Navigation Link Hover',
						'default' => '#999',
						'selectors' => '.footer-text a:hover, ul#footer-nav li a:hover',
						'css'	=> 'color',
						'jquery'	=> 'color'
					)
				),
		);


	/***************************************************************************/
	/* Setup Defaults for this theme for options which aren't set in this page */
	if(is_admin() && !get_option($obox_themeid."-defaults")) :
		update_option("ocmx_general_font_style_default",
						"'proxima-nova', 'Proxima Nova', 'Helvetica Neue'");
		update_option("ocmx_navigation_font_style_default",
						"'proxima-nova', 'Proxima Nova', 'Helvetica Neue'");
		update_option("ocmx_sub_navigation_font_style_default",
						"'proxima-nova', 'Proxima Nova', 'Helvetica Neue'");
		update_option("ocmx_post_font_titles_style_default",
						"'proxima-nova', 'Proxima Nova', 'Helvetica Neue'");
		update_option("ocmx_post_font_meta_style_default",
						"'proxima-nova', 'Proxima Nova', 'Helvetica Neue'");
		update_option("ocmx_post_font_copy_font_style_default",
						"'proxima-nova', 'Proxima Nova', 'Helvetica Neue'");
		update_option("ocmx_widget_font_titles_font_style_default",
						"'proxima-nova', 'Proxima Nova', 'Helvetica Neue'");
		update_option("ocmx_widget_footer_titles_font_size_default",
						"'proxima-nova', 'Proxima Nova', 'Helvetica Neue'");


		update_option("ocmx_general_font_color_default",
						"#333");
		update_option("ocmx_navigation_font_color_default",
						"#777");
		update_option("ocmx_sub_navigation_font_color_default",
						"#333");
		update_option("ocmx_post_titles_font_color_default",
						"#333");
		update_option("ocmx_post_meta_font_color_default",
						"#999");
		update_option("ocmx_post_copy_font_color_default",
						"#333");
		update_option("ocmx_widget_titles_font_color_default",
						"#999");
		update_option("ocmx_widget_footer_titles_font_color_default",
						"#999");

		update_option("ocmx_general_font_size_default",
						"17");
		update_option("ocmx_navigation_font_size_default",
						"12");
		update_option("ocmx_sub_navigation_font_size_default",
						"12");
		update_option("ocmx_post_titles_font_size_default",
						"10");
		update_option("ocmx_post_meta_font_size_default",
						"13");
		update_option("ocmx_post_copy_font_size_default",
						"17");
		update_option("ocmx_widget_titles_font_size_default",
						"15");
		update_option("ocmx_widget_footer_titles_font_size_default",
						"15");
		update_option($obox_themeid."-defaults", 1);
	endif;
}
add_action ( 'init' , 'ocmx_theme_options' );