<?php function obox_theme_list() {
		$usefeed = "http://www.obox-design.com/theme_rss.xml";
		
		//echo 'not getting cache';
		$string = file_get_contents($usefeed);
		
		//echo $string;
		//echo $myprice["type"]; $ echo $myprice->a;
		$xml = @simplexml_load_string($string) or print ("no file loaded");	
		//$xml = @simplexml_load_file($feed["usefeed"]) or print ("no file loaded");
		foreach ($xml->channel->item as $xml_object => $value) : ?>
            <li class="theme-block-item">
				<!--<p class="tooltip">// echo $value->description;</p>-->
				<a href="" class="screenshot"><img src="<?php echo $value->enclosure["url"]; ?>" /></a>
				
				<h4><?php echo $value->title; ?></h4>
				<?php foreach($value->pricing->price as $myprice) : ?>
                	<?php if($myprice->a == 30) : ?>
						<a href="<?php echo $myprice->a["href"]; ?>" class="pricing">Purchase</a>
					<?php endif; ?>
				<?php endforeach; ?>
				
			</li>
<?php		endforeach;
}
add_action("obox_theme_list", "obox_theme_list");
?>