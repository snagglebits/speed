<?php header('Content-type: text/css'); 
wp_reset_postdata();

global $post, $customizer_options;
if(get_option("ocmx_ignore_colours") != "yes"):
	foreach( $customizer_options as $section ){
		foreach ( $section[ 'elements' ] as $element ) { ?>
			<?php if( '' != get_option( $element[ 'slug' ] ) ) { 
				if( is_array( $element['css'] ) ){ 
					foreach( $element['css'] as $css ) { ?>
					<?php echo $element['selectors']; ?> {<?php echo $css; ?>: <?php echo get_option( $element[ 'slug' ] ); ?> }
				<?php } 
				} else { ?>
					<?php echo $element['selectors']; ?> {<?php echo $element['css']; ?>: <?php echo get_option( $element[ 'slug' ] ); ?> }
				<?php }  // if is_array( $element['css']
			} // if get_option( element-slug ) != ''
		} // foreach $section[ 'elements' ]
	} // foreach $customizer_options;

	if( get_option( 'obox_button_background' ) != "" ){ ?> .tabs li a{ border: none; } <?php };

	if( get_option( 'obox_button_background' ) != "" ) { ?> .quantity .input-text{ border-color: <?php echo get_option( 'obox_button_background' ) ?>;} <?php }; 

	if( get_option( 'obox_body_content_borders' ) != "" ) { ?> table th, .copy .cart_totals h2{ background-color: <?php echo get_option( 'obox_body_content_borders' ) ?>; } <?php };

endif;


// If is page don't show post-title-block, duplicate title issue
if(get_option('ocmx_meta_date_page') && get_option('ocmx_meta_author_page') !='true' && is_page()) { ?>
	.post-title-block{display: none;}
<?php }

// Load custom CSS
if(get_option("ocmx_custom_css") != ""): ?>
	<?php echo get_option("ocmx_custom_css"); ?>
<?php endif;

// Load header background
if(get_header_image() != "") : ?>  
	#title-container{background: url(<?php header_image(); ?>) no-repeat top center;}
<?php endif;

// $background is the saved custom image, or the default image.
$background = set_url_scheme( get_background_image() );

// $color is the saved custom color.
// A default has to be specified in style.css. It will not be printed here.
$color = get_theme_mod( 'background_color' );

if ( ! $background && ! $color )
	return;

$style = $color ? "background-color: #$color;" : '';

if ( $background ) {
	$image = " background-image: url('$background');";

	$repeat = get_theme_mod( 'background_repeat', 'repeat' );
	if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
		$repeat = 'repeat';
	$repeat = " background-repeat: $repeat;";

	$position = get_theme_mod( 'background_position_x', 'left' );
	if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
		$position = 'left';
	$position = " background-position: top $position;";

	$attachment = get_theme_mod( 'background_attachment', 'scroll' );
	if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
		$attachment = 'scroll';
	$attachment = " background-attachment: $attachment;";

	$style .= $image . $repeat . $position . $attachment;
} ?>