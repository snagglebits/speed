<?php  
/* 
Obox Custom Styles 1.0
Based on the excellent TinyMCE Kit plug-in for WordPress 
http://plugins.svn.wordpress.org/tinymce-advanced/branches/tinymce-kit/tinymce-kit.php 
*/  

/** Let's rock this:
//  Apply styles to the visual editor */

add_filter('mce_css', 'obox_mcekit_editor_style');  
function obox_mcekit_editor_style($url) {  
    if ( !empty($url) )  
        $url .= ',';  
    // Retrieves the plugin directory URL  
    // Change the path here if using different directories  
    $url .= trailingslashit( get_stylesheet_directory_uri() ) . '/editor-styles.css';  
    return $url;  
}  

/** Add "Styles" drop-down */  
add_filter( 'mce_buttons_2', 'obox_mce_editor_buttons' );  
function obox_mce_editor_buttons( $buttons ) {  
    array_unshift( $buttons, 'styleselect' );  
    return $buttons;  
}  

/**  Add styles/classes to the "Styles" drop-down */  
add_filter( 'tiny_mce_before_init', 'obox_mce_before_init' );  
function obox_mce_before_init( $settings ) {  
    $style_formats = array(  
		array(  
            'title' => 'Fancy Title',  
            'block' => 'h3',  
            'classes' => 'fancy-title'     
        ),
		array(  
            'title' => 'Section Title',  
            'block' => 'h4',  
            'classes' => 'copy-section-title'     
        ),   
        array(  
            'title' => 'Tool-Tip',  
            'block' => 'div',  
            'classes' => 'tool-tip', 
			'wrapper' => true  
        ),  
		array(  
            'title' => 'Note',  
            'block' => 'div',  
            'classes' => 'note',  
            'wrapper' => true  
        ),
		 array(  
            'title' => 'Quote',  
            'block' => 'div',  
            'classes' => 'quote',  
            'wrapper' => true  
        ),
		array(  
            'title' => 'Divider',  
            'block' => 'div',  
            'classes' => 'divider',  
            'wrapper' => true  
        ),
		array(  
            'title' => 'Highlight',  
            'block' => 'span',  
            'classes' => 'highlight',  
            'wrapper' => true  
        ),
		array(  
            'title' => 'Column (4/4)',  
            'inline' => 'span',  
            'classes' => 'column-1-4',  
            'wrapper' => true  
        ),
		
		array(  
            'title' => 'Column (3/3)',  
            'inline' => 'span',  
            'classes' => 'column-1-3',  
            'wrapper' => true  
        ),
		array(  
            'title' => 'Column (2/2)',  
            'inline' => 'span',  
            'classes' => 'column-1-2',  
            'wrapper' => true  
        ),
		array(  
            'title' => 'Clear',  
            'block' => 'div',  
            'classes' => 'clear',  
            'wrapper' => false  
        ),
		array(  
            'title' => 'Small Button',  
            'selector' => 'a',  
            'classes' => 'download'  
		),	
		array(  
            'title' => 'Large Button',  
            'block' => 'span',  
            'classes' => 'button',  
            'wrapper' => true  
        ),
		array(  
            'title' => 'Dropcap',  
            'inline' => 'span',  
            'classes' => 'dropcap dropcap-style-1',  
            'wrapper' => true  
        )
    );  
    $settings['style_formats'] = json_encode( $style_formats );  
    return $settings;  
}  
/* Learn TinyMCE style format options at http://www.tinymce.com/wiki.php/Configuration:formats */  
/* 
 * Add custom stylesheet to the website front-end with hook 'wp_enqueue_scripts' 
 */  
add_action('wp_enqueue_scripts', 'obox_mcekit_editor_enqueue');  
/* 
 * Enqueue stylesheet, if it exists. 
 */  
function obox_mcekit_editor_enqueue() {  
	$editor_style =  get_stylesheet_directory_uri().'/editor-styles.css'; // Customstyle.css is relative to the current file  
	if(is_admin())
		wp_enqueue_style( 'editor-styles', $editor_style );  
}