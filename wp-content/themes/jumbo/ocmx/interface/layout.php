<?php function ocmx_layout_options($input){ 
global $theme_options;

// Set the form value
if((get_option($input["id"])) != '') :
	$layout_value  = get_option($input["id"]);
elseif(isset($input["default"])) :
	$layout_value  = $input["default"];
else :
	$layout_value  = '';
endif;

// Set the layout form to null until we grab it from the layout loop below.
$layout_form = ''; 

// Set the main label & description
if(isset($input["main_section"])) :
	$label = $input["main_section"];
	if(isset($input["main_description"])) { $desc = '<p>'.$input["main_description"].'</p>'; };
else :
	$label = $input["label"];
	if(isset($input["description"])) { $desc = '<p>'.$input["description"].'</p>'; };
endif; ?>
	<li class="admin-block-item">
		<div class="admin-description">
            <h4><?php echo $label;?></h4>
	        <?php if(isset($desc)) echo $desc; ?>
        </div>
		<div class="layout-content">
			<ul class="layout-options">
		    	<?php foreach($input["options"] as $layout_option => $option_list) : ?>
		    		<?php if(get_option($input["id"]) == $layout_option) :
		    			$class = 'class="layout-select"';
		    			if(isset($option_list["load_options"])) { $layout_form = $option_list["load_options"]; };
		    		else :
		    			$class = '';
		    		endif; ?>
		    		<li <?php echo $class;?>>
		                <a href="#" id="ocmx_layout_<?php echo $layout_option; ?>" class="layout-image" data-layout="<?php echo $layout_option; ?>" data-input="<?php echo $input["id"]; ?>" data-options="<?php if(isset($option_list["load_options"])) echo $option_list["load_options"]; ?>">
		                   	<h4><?php echo $option_list["label"]; ?></h4>
		                    <?php if(isset($option_list["description"]) !='') : ?>
		                    	<p><?php echo $option_list["description"]; ?></p>
		                    <?php endif; ?>
						</a>
		            </li>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<!-- Layout Option Value -->
		<input type="hidden" name="<?php echo $input["id"]; ?>" id="<?php echo $input["id"]; ?>" value="<?php echo $layout_value; ?>" />
	
		<ul class="form-options contained-forms <?php if(empty($theme_options[$layout_form])) : ?>no_display<?php endif; ?>" id="<?php echo $input["id"]; ?>_form">
			<?php if($layout_form != '')
				layout_form($theme_options[$layout_form]); ?>
		</ul>
	</li>
<?php        
}

function layout_form($use_form){ 
	foreach($use_form as $form_item) : ?>
        <li>
            <?php if(isset($form_item["main_section"])) : ?>
                <label class="parent-label"><?php echo $form_item["main_section"];?></label>
                <div class="form-wrap">                 	
                    <?php if(is_array($form_item["sub_elements"])) :
							foreach($form_item["sub_elements"] as $sub_input) : ?>
                             <?php if(isset($sub_input["show_if"]) && ( $sub_input["show_if"] && get_option($sub_input["show_if"]["id"]) !== $sub_input["show_if"]["value"]) ) : $class="no_display"; else : $class=""; endif; ?>
							<div id="<?php echo $sub_input["id"]; ?>_div" class="child-form <?php echo $class; ?>">
								<label class="child-label"><?php echo $sub_input["label"]; ?></label>
								
								<?php create_form($sub_input, count($form_item), ""); ?>
                                
								<?php if($sub_input["description"] !== "") : ?>
									<span class="tooltip"><?php echo $sub_input["description"]; ?></span>
								<?php endif; ?>
							</div>
						<?php endforeach; 
					endif;?>
					<?php if(isset($form_item["main_image"])) : ?>
                        <div class="child-form">
                            <label class="child-label"></label>
                            <img src="<?php echo $form_item["main_image"]; ?>" />
                        </div>
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <label class="parent-label"><?php echo $form_item["label"];?></label>
                <div class="form-wrap">
                    <?php if(!isset($label_class)) 
							$label_class = "";
						create_form($form_item, count($form_item), $label_class); ?>
                    <?php if(isset($form_item["description"]) && $form_item["description"] !== "") : ?>
                        <span class="tooltip"><?php $form_item["description"];?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </li>
<?php endforeach; 
}
add_action("ocmx_layout_options", "ocmx_layout_options"); 
add_action("ocmx_sidebar_layout_options", "ocmx_sidebar_layout_options"); 
add_action("ocmx_layout_form", "layout_form");