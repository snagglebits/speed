<?php function ocmx_font_form($input){
	global $theme_options, $ocmx_fonts; ?>
	<li class="column">
		<ul class="element-selector">
			<?php $i=0; foreach($input as $font_option) : ?>
				<li><a id="element-selector-<?php echo $font_option["id"]; ?>" rel="<?php echo $font_option["id"]; ?>" <?php if($i == 0): ?>class="element-selected-tab"<?php endif;?> href="#"><?php echo $font_option["label"]; ?></a></li>
			<?php $i++; endforeach; ?>
		</ul>
	</li>
	<?php $i=0; foreach($input as $font_option) : ?>
		<li id="<?php echo $font_option["id"]; ?>_li" class="column <?php if($i == 0): ?>element-selected<?php else : ?>no_display<?php endif; ?>">
			<ul class="font-setting-container">
				<?php create_form($font_option, count($font_option)); ?>
			</ul>
			<ul class="font-list">
				<?php $fontstyle = $font_option["id"]."_style" ?>
				<?php foreach($ocmx_fonts as $font) :
					$font_css = "";
					$option = $font_option["name"];
					$size = $option."_size";
					$style =  $option."_style";
					if(get_option($fontstyle) == ""){$fontstyle .= "_default";}
					if(get_option($size) != "" && get_option($size) != "0") :
						$font_css .= "font-size: ".round(get_option($size), 0)."px !inherent; ";
					endif;

					//Set the selected font
					if(strpos($fontstyle, "_default") == false && get_option($fontstyle) == $font["css"]) :
						$selected_font = true;
					else :
						$selected_font = false;
					endif;

					// If we've selected a font, show it as the first option instead of the "theme default" tab
					if($font["label"] == "Theme Default" && strpos($fontstyle, "_default") == false) : ?>
						<li<?php if(get_option($fontstyle) == $font["css"]) : ?> class="select"<?php endif; ?>>
							<div class="font-item" rel="<?php echo $font_option["id"]; ?>_style">
								<div style="font-family: <?php echo get_option($fontstyle); ?>; <?php echo $font_css; ?>" class="type-display">
									AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVv
								</div>
								<span class="font-name"><?php _e("Current Font",'ocmx'); ?></span>
							</div>
							<input type="radio" class="no_display" name="<?php echo $font_option["id"]; ?>_style" value="<?php echo get_option($fontstyle); ?>" />
						</li>
					<?php else : ?>
						<li<?php if($selected_font == true) : ?> class="select"<?php endif; ?>>
							<div class="font-item" rel="<?php echo $font_option["id"]; ?>_style">
								<div style="font-family: <?php echo $font["css"]; ?>; <?php echo $font_css; ?>" class="type-display">
									AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVv
								</div>
								<span class="font-name"><?php echo $font["label"]; ?></span>
							</div>
							<input type="radio" class="no_display" name="<?php echo $font_option["id"]; ?>_style" value="<?php echo $font["css"]; ?>" <?php if($selected_font == true) : ?>checked="checked"<?php endif; ?> />
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</li>
	<?php $i++; endforeach; ?>
<?php
}
add_action("ocmx_font_form", "ocmx_font_form");
function ocmx_font_overview($input){ ?>
<li class="clearfix">
	<div class="content">
		<p class="settings-message">
			<?php _e("Below is a general overview of how the typography manager affects Personal.
			For further help with the Typography Manager, visit Theme Options > Help and click on Theme Documentation.") ?>
		</p>

		<div class="overview-container">
				<div class="section">
					<h3><?php _e("General:", "ocmx"); ?></h3>
						<p><?php _e("Changes all 'general' text in the theme, such as the tagline, widget text, post meta and post text. Note that some of these elements can be overridden by other typography settings.", "ocmx"); ?>
			  </div>
			   <div class="section">
					<h3><?php _e("Navigation:", "ocmx"); ?></h3>
						<p><?php _e("Affects your main menu only", "ocmx"); ?></p>

				</div>
				 <div class="section">
					<h3><?php _e("Page Title:", "ocmx"); ?></h3>
						<p><?php _e("Affects the title in the title banner", "ocmx"); ?></p>
				 </div>
				 <div class="section">
					<h3><?php _e("Post Meta:", "ocmx"); ?></h3>
						<p><?php _e("Affects the date, author and category shown below the post titles.", "ocmx"); ?></p>
				</div>
				 <div class="section">
					<h3><?php _e("Post titles:", "ocmx"); ?></h3>
						<p><?php _e("Affects post and product titles only. Will not affect pages/portfolio", "ocmx"); ?></p>
				 </div>
				  <div class="section">
					<h3><?php _e("Post Copy:", "ocmx"); ?></h3>
						<p><?php _e("Changes the content text in posts and pages specifically.", "ocmx"); ?></p>
				 </div>
				  <div class="section">
					<h3><?php _e("Widget titles:", "ocmx"); ?></h3>
						<p><?php _e("Affects widgets in the sidebar only", "ocmx"); ?></p>
				</div>
				<div class="section">
					<h3><?php _e("Footer Widget titles:", "ocmx"); ?></h3>
						<p><?php _e("Affects widgets in the footer only", "ocmx"); ?></p>
				</div>
		</div>
	</div>
</li>
<?php }
add_action("ocmx_font_overview", "ocmx_font_overview");  ?>