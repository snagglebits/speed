<?php get_header(); 

if(get_option('ocmx_home_page_layout') != '') $layout = get_option('ocmx_home_page_layout'); else  $layout = 'blog'; 

// Load the home page template according to the user's selection under Theme Options > General > Home Layout
get_template_part('/functions/'.$layout.'-home');

 get_footer(); ?>