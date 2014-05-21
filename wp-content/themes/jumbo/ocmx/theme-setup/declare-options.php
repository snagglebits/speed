<?php
function ocmx_install_options (){
	$ocmx_tabs = array(
						array(
							  "option_header" => "Install OCMX",
							  "use_function" => "ocmx_show_install" ,
							  "function_args" => array("OCMX General Options", "OCMX Social Media Widgets and Links", "Advert Management", "OCMX Like/Unlike", "Advances Comment Functionality and Storage"),
							  "ul_class" => "form-options clearfix"
						  )
					);

	$ocmx_container = new OCMX_Container();
	$ocmx_container->load_container("Welcome to OCMX", $ocmx_tabs);
};

function ocmx_general_options (){	
	$ocmx_tabs = array(
					array(
						  "option_header" => "General Options",
						  "use_function" => "ocmx_fetch_options",
						  "function_args" => "general_site_options",
						  "ul_class" => "admin-block-list clearfix"
					  ),
					array(
						  "option_header" => "Site Layout",
						  "use_function" => "ocmx_layout_options",
						  "function_args" => "layout_options",
						  "ul_class" => "admin-block-list clearfix"
					  ),
					array(
						  "option_header" => "Header",
						  "use_function" => "ocmx_fetch_options",
						  "function_args" => "header_options",
						  "ul_class" => "admin-block-list clearfix"
					  ),
					array(
						  "option_header" => "Footer",
						  "use_function" => "ocmx_fetch_options",
						  "function_args" => "footer_options",
						  "ul_class" => "admin-block-list clearfix"
					  )
				);
	$ocmx_container = new OCMX_Container();
	$ocmx_container->load_container("General Options", $ocmx_tabs);
};

function ocmx_advert_options (){	
	$ocmx_tabs = array(
					array(
						  "option_header" => "125 x 125 Blocks",
						  "use_function" => "ocmx_ad_options",
						  "function_args" => "small_ad_options",
						  "ul_class" => "form-options clearfix",
						  "base_button" => array("id" => "add_ad_ocmx_small_ads", "rel" => "ocmx_small_ad", "href" => "#add_ad_ocmx_small_ads", "id" => "add_ad_ocmx_small_ads", "html" => "+ Add Another Block")
					  ),
					array(
						  "option_header" => "300 x 250 blocks",
						  "use_function" => "ocmx_ad_options",
						  "function_args" => "medium_ad_options",
						  "ul_class" => "form-options clearfix",
						  "base_button" => array("id" => "add_ad_ocmx_medium_ads", "rel" => "ocmx_medium_ad", "href" => "#add_ad_ocmx_medium_ads", "id" => "add_ad_ocmx_medium_ads", "html" => "+ Add Another Block")
					  )
					
				);
	
	$ocmx_container = new OCMX_Container();
	$ocmx_container->load_container("Adverts", $ocmx_tabs);
};
function ocmx_seo_options(){	
	$ocmx_tabs = array(
					array(
						"option_header" => "Theme SEO",
						"use_function" => "ocmx_fetch_options",
						"function_args" => "seo_options",
						"ul_class" => "admin-block-list clearfix"
					  )
				);

	$ocmx_container = new OCMX_Container();
	$ocmx_container->load_container("SEO", $ocmx_tabs);
};
function ocmx_more_theme_options(){	
	$ocmx_tabs = array(
					array(
						"option_header" => "More Themes from Obox",
						"use_function" => "obox_theme_list",
						"function_args" => "",
						"ul_class" => "clearfix"
					  )
				);
	
	$ocmx_container = new OCMX_Container();
	$ocmx_container->load_container("Themes", $ocmx_tabs, "");
};