<?php
$options = get_option( 'clarity_theme_settings' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<!-- Mobile Specific
================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->

<!-- Meta Tags -->
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<!-- Title Tag
================================================== -->
<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' |'; } ?> <?php bloginfo('name'); ?></title>
    
<?php if(!empty($options['favicon'])) { ?>
<!-- Favicon
================================================== -->
<link rel="icon" type="image/png" href="<?php echo $options['favicon']; ?>" />
<?php } ?>

<!-- Main CSS
================================================== -->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />

<?php $content_text_color = get_option('content_text_color'); ?>
<style> #single-title-home { color:  <?php echo $content_text_color; ?>; } </style>

<!-- WP Head
================================================== -->
<?php if ( is_single() || is_page() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

	<div class="clearfix"></div>    
        	
    <!-- Start Header-->
    <header id="masterhead" class="clearfix">  

    		<!-- Start logo -->   
            <div id="logo" id="fittext1">
                <?php
                    if($options['upload_mainlogo'] !='') { ?>
                        <a href="<?php bloginfo( 'url' ); ?>/" title="<?php bloginfo( 'name' ); ?>"><img src="<?php echo $options['upload_mainlogo']; ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
                    <?php } else { ?>
                    <a href="<?php bloginfo( 'url' ); ?>/" title="<?php bloginfo( 'name' ) ?>"><?php bloginfo( 'name' ); ?></a>
                <?php } ?>
            </div>
           <!-- END logo -->
           
            <div id="site-description">
            <?php echo get_bloginfo ( 'description' );  ?><br />
               </div>

           <!-- Start Nav -->
            <!--
            <nav id="masternav" class="clearfix">
                <?php wp_nav_menu( array(
                    'theme_location' => 'menu',
                    'sort_column' => 'menu_order',
                    'menu_class' => 'sf-menu',
                    'fallback_cb' => 'default_menu'
                )); ?>
            </nav>
            -->
            <!-- End Nav -->
            
    </header>
    <!-- End Header -->
<div id="wrap" class="clearfix">
<div id="main" class="clearfix">


