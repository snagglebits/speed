<script type="text/javascript">
	if(typeof tinypass_reloader != 'function') {
		function tinypass_reloader(status){
			if(status.state == 'granted'){ window.location.reload(); }
		}
	}
</script>
<?php
/**
 * Available variables
 * 	
 * 	$button1 - the Tinypass button that must be embedded so users can make a purchase
 *  $message1 - header message provided in Tinypass settings
 * 	$sub1 - sub header message provided in Tinypass settings
 *  $resource1 - name of post/tag the user is buying
 *
 *  The following will only be present on Upsells PerPost + Tag 
 * 	$button2 - the Tinypass button that must be embedded so users can make a purchase
 *  $message2 - header message provided in Tinypass settings
 * 	$sub2 - sub header message provided in Tinypass settings
 *  $resource2 - name of post/tag the user is buying
 * 
 */
?>
<div id="tinypass_button_holder">
	<div id="tp-outer">
		<div id="tp-inner">
			<div class="tp-row">
				<div class="tp-col">
					<h1><?php echo $message1 ?></h1>
					<?php echo $sub1 ?>
				</div>
				<div class="tp-col right">
					<?php echo $button1 ?>
				</div>
			</div>
			<?php if ($button2): ?>
				<hr>
				<div class="tp-row">
					<div class="tp-col">
						<h1><?php echo $message2 ?></h1>
						<?php echo $sub2 ?>
					</div>
					<div class="tp-col right">
						<?php echo $button2 ?>
					</div>
				</div>
			<?php endif; ?>
    </div>
	</div>
</div>