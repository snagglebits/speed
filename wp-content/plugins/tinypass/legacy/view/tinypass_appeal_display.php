<?php
/**
 * Available variables
 * 	
 * 	$header - header text message
 *  $body - body text message
 *  $link - url to the subscription page
 *
 * 
 */
?>
<div>
  <div class="row-head"><?php echo $header ?></div>
  <div class="row-body"><?php echo $body ?></div>
  <div class="row-footer">
    <a href="<?php echo $link ?>">
    <img src="http://buy.tinypass.com/tpbutton?type=standard&txt=Get%20Access&size=2"/>
    </a>
  </div>
</div>