<?php function ocmx_check_welcome(){
	global $pagenow, $obox_themeid;
	if(isset($obox_themeid) && !get_option($obox_themeid."_welcome") && isset($_GET["activated"]) && $pagenow = "themes.php") :
	update_option($obox_themeid."_welcome", 1);
	wp_redirect(admin_url('admin.php?page=obox-help'));
	endif;
}
add_action("init", "ocmx_check_welcome");

function ocmx_welcome_page(){
	global $pagenow, $wp_version, $obox_productid, $obox_themename, $obox_themeid, $current_theme;
	$themes = wp_get_themes();
	$current_theme =  wp_get_theme();

function ocmx_admin_tabs( $current = 'step1' ) {
	global $obox_themename, $current_theme;
	$tabs = array(
	'step1' => 'Step 1',
	'step2' => 'Step 2',
	'step3' => 'Step 3' );
	echo '<div id="obox-wrapper">';
	echo'<h2 class="obox-theme-name">';
		echo $obox_themename." ".$current_theme->Version;
	echo '</h2>';
	echo '<h2 class="nav-tab-wrapper">';
		foreach( $tabs as $tab => $name ){
			$class = ( $tab == $current ) ? ' nav-tab-active' : '';
			echo "<a class='nav-tab$class' href='?page=obox-help&tab=$tab'>$name</a>";

		}
	echo '</h2>';
}
	if ( isset ( $_GET['tab'] ) ) ocmx_admin_tabs($_GET['tab']); else ocmx_admin_tabs('step1');
	if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab'];
	else $tab = 'step1'; ?>
	<div class="obox-content">
			  <div class="section">
				<div class="columns-1 grid">
					<div class="column">
						<div class="obox-help-buttons">
							<a href="http://kb.oboxsites.com/wp-content/uploads/2013/11/department-demo-content.zip" class="demo-content"><span>Demo Content</span></a>
							<a href="http://kb.oboxsites.com/documentation/<?php echo $obox_themeid; ?>-docs/" class="documentation" target="_blank"><span>Documentation</span></a>
							<a href="http://oboxthemes.com/forum/post/" class="support-forums" target="_blank"><span>Get Support</span></a>
						</div>
						<h2 class="settings-title">Welcome to <?php echo $obox_themename; ?> by Obox Themes</h2>
						<p class="settings-intro">If you need step-by-step instructions for setting up and using the theme, check out our <a href="http://kb.oboxsites.com/documentation/<?php echo $obox_themeid; ?>-docs" target="_blank"><?php echo $obox_themename; ?> Theme documentation</a>. If know your way around WordPress, you can use our Quick Setup steps below.</p>
					</div>
				</div>
			</div>
  <?php switch ( $tab ){
	  case 'step2' :
		 ?>
		   <div class="section">

					<div class="instructions">
						<h3 class="instruction-title">Step 2. Add Your Content</h3>
						<p class="instruction-intro">Before we can really get started, you first need to add content to WordPress. There are a number of different content types that you can create with <?php echo $obox_themename; ?>. Be sure to read through the theme documentation for details about using each conten type.</p>
					<p class="instruction-intro">If you prefer to pre-load our demo content into your theme to get a head start, you may use our demo content file linked from the first icon above. Note that this file cannot setup widgets or Theme Options – continue with the documentation or this quick guide even after loading this file to learn how to use the theme.</p>

						<ul class="columns-4 action-list">
						<li class="column"><a href="<?php echo admin_url('post-new.php'); ?>" class="to-do" target="blank">Add Some Posts</a></li>
						<li class="column"><a href="<?php echo admin_url('post-new.php?post_type=portfolio'); ?>" class="to-do" target="blank">Add Some Portfolios</a></li>
						<li class="column"><a href="<?php echo admin_url('post-new.php?post_type=services'); ?>" class="to-do" target="blank">Add Some Services</a></li>
						<li class="column"><a href="<?php echo admin_url('post-new.php?post_type=partners'); ?>" class="to-do" target="blank">Add Some Partners</a></li>
						<li class="column"><a href="<?php echo admin_url('post-new.php?post_type=team'); ?>" class="to-do" target="blank">Add Team Members</a></li>
						<li class="column"><a href="<?php echo admin_url('post-new.php?post_type=page'); ?>" class="to-do" target="blank">Setup the Page Templates</a></li>
						<li class="column"><a href="<?php echo admin_url('options-permalink.php'); ?>" class="to-do" target="blank">Enable Permalinks</a></li>
						<li class="column"><a href="<?php echo admin_url('nav-menus.php'); ?>" class="to-do" target="blank">Setup Your Menus</a></li>
						<li class="column"><a href="?page=obox-help&tab=step3" class="next-step">Next Step &rarr;</a></li>
						</ul>
					</div>
			</div>
		 <?php
	  break;
	  case 'step3' :
		 ?>
			<div class="section">
				<div class="instructions">
					<h3 class="instruction-title">Step 3. Final step! Setup Home Page & Widgets</h3>
					<p class="instruction-intro">Now that you’ve added your content and configured the theme,  you will be able to setup your Home page and sidebars.</p>
						<p class="instruction-intro">The Theme Options panel allows you to customize several aspects of your theme, including your logo, button text or styes.</p>
						<p class="instruction-intro">At the top of the Widgets page you will find a yellow ribbon containing a handy “Click Here” link, which will display the recommended widget setup if you get lost. The Theme Customizer lets you take it to the next level with a full array of color options.</p>
				</div>
				<ul class="columns-4 action-list">
					<li class="column"><a href="<?php echo admin_url('post-new.php?post_type=slider'); ?>" target="blank" class="to-do">Add Some Sliders</a></li>
					<li class="column"><a href="<?php echo admin_url('post-new.php?post_type=testimonials'); ?>" target="blank" class="to-do">Add Some Testimonials</a></li>
					<li class="column"><a href="<?php echo admin_url('widgets.php'); ?>" target="blank" class="to-do">Setup Your Widgets</a></li>
					<li class="column"><a href="<?php echo admin_url('admin.php?page=functions.php'); ?>" class="to-do" target="blank">Configure Theme Options</a></li>
					<li class="column"><a href="<?php echo admin_url('customize.php'); ?>" class="next-step" target="blank">Customize!</a></li>
				</ul>
			</div>
		 <?php
	  break;
	  case 'step1' :
		 ?>
			<div class="section">
				<div class="instructions">
					<h3 class="instruction-title">Step 1. Setup WooCommerce</h3>
					<p class="instruction-intro">The shopping cart and products posts are driven by the WooCommmerce plugin, which you can download and install free through the WordPress plugin repository.</p>
				</div>
				<ul class="columns-3 action-list">
					<li class="column"><a href="<?php echo admin_url('plugin-install.php'); ?>" class="to-do" target="blank">Install WooCommerce</a></li>
					<li class="column"><a href="<?php echo admin_url('admin.php?page=woocommerce_settings.php'); ?>" class="to-do" target="blank">Configure Your Shop</a></li>
					<li class="column"><a href="<?php echo admin_url('post-new.php?post_type=product'); ?>" class="to-do" target="blank">Create Some Products</a></li>
					<li class="column"><a href="?page=obox-help&tab=step2" class="next-step">Next Step &rarr;</a></li>
				</ul>
			</div>
	<?php
	break;
	}?>
	</div>
<?php } ?>