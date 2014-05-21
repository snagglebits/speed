<?php
/**
 * Available variables
 * 	
 * 	$count - current number of views
 *  $max - max views before meter expires
 *  $remaining - remaining number of view before expiration
 *  $position - position class
 *  $onclick - what to do when clicked. 
 *
 * 
 */
?>
<a <?php echo $onclick ?>>
  <div id="tinypass-counter" class="<?php echo $position ?>">
    <div id="inner">
      <div class="num"><?php echo $remaining ?></div>
      <div span class="text">views left </div>
      <div span class="arrow">&rsaquo;</div>
      <div class="clear"></div>
    </div>
  </div>
</a>