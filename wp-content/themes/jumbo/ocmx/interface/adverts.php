<?php function ocmx_ad_options($input){ ?>
    <div id="<?php echo $input["name"]."_div"; ?>">
        <ul class="form-options-<?php echo $input["args"]["width"]; ?> sortable-ads" rel="<?php echo $input["prefix"]; ?>">
            <input type="hidden" name="<?php echo $input["name"]; ?>" id="<?php echo $input["id"]; ?>" value="<?php echo get_option($input["name"]); ?>" />
            <?php ocmx_ad_loop($input["name"], $input["prefix"], $input["args"]["width"]); ?>
        </ul>
        <div class="no_display" id="ad_width_<?php echo $input["name"]; ?>"><?php echo $input["args"]["width"]; ?></div>
    </div>
<?php 
}

function ocmx_ad_loop($input_name, $input_prefix, $width = 0){
	if(get_option($input_name) == 0 ||  !get_option($input_name)) : ?>
		<li id="<?php echo $input_name; ?>_no_ads"><?php _e("You have not set any adverts.", "ocmx"); ?></li>
	<?php endif;
	for($i = 1; $i <= get_option($input_name); $i++) : ?>
	<li><?php ocmx_ad_form($input_prefix, $i, $width); ?></li>
<?php endfor; ?>
<?php
}

// Loop over each Advert
function ocmx_ad_form($input_prefix, $i, $width = 125, $empty = false){
		$ad_title_id = $input_prefix."_title_".$i;
		$ad_link_id = $input_prefix."_link_".$i;
		$ad_img_id = $input_prefix."_img_".$i;
		$ad_href_id = $input_prefix."_href_".$i;
		$ad_remove_href_id = "remove_ad_".$input_prefix."_".$i;
		$ad_script_id = $input_prefix."_script_".$i; ?>
        
        <div class="advert-block advert-<?php echo $width; ?>" id="ad-block-<?php echo $i; ?>">
            <a href="<?php echo get_option($ad_link_id); ?>" class="ad-image" rel="lightbox" target="_blank">
                <?php if(strlen(get_option($ad_img_id))) : ?>
                    <img id="<?php echo $ad_href_id; ?>" src="<?php if(!($empty)){echo get_option($ad_img_id);}; ?>" />
                <?php endif; ?>
            </a>
			<div class="ad-forms">
				<label class="parent-label">Advert Link</label>
				<div class="form-wrap">
					<input type="text" name="<?php echo $ad_link_id ?>" id="<?php echo $ad_link_id ?>" value="<?php if(!($empty)){echo get_option($ad_link_id);}; ?>" />
				</div>
				<label class="parent-label">Image URL</label>
				<div class="form-wrap">
					<input type="text" name="<?php echo $ad_img_id ?>" id="<?php echo $ad_img_id ?>" value="<?php if(!($empty)){echo get_option($ad_img_id);}; ?>" />
				</div>
				<label class="parent-label">Image Title</label>
				<div class="form-wrap">
					<input type="text" name="<?php echo $ad_title_id ?>" id="<?php echo $ad_title_id ?>" value="<?php if(!($empty)){echo get_option($ad_title_id);}; ?>" />
				</div>
				<label class="parent-label">3<sup>rd</sup> Party Script</label>
				<div class="form-wrap">
					<textarea type="text" name="<?php echo $ad_script_id ?>" id="<?php echo $ad_script_id ?>"><?php if(!($empty)){echo stripslashes(get_option($ad_script_id));}; ?></textarea>
					<a href="#" id="<?php echo $ad_remove_href_id; ?>" rel="<?php echo $input_prefix; ?>" class="del-link">Delete</a>
				</div>
			</div>
		</div>
<?php
}
	
add_action("ocmx_ad_options", "ocmx_ad_options"); ?>