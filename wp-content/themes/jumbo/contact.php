<?php
/*
Template Name: Contact 
*/

get_header(); 
$contact_header = get_post_meta($post->ID, "map-display", true);

if($contact_header !="title") : ?>

	<div id="map-container">
		<?php $args  = array('postid' => $post->ID, 'width' => 2000, 'height' => 400, 'hide_href' => true, 'exclude_video' => true, 'imglink' => false, 'imgnocontainer' => true, 'resizer' => '2000x400');
		$image = get_obox_media($args);
		$location = get_post_meta($post->ID, "map-location", true);
		$latlong = get_post_meta($post->ID, "map-latlong", true);
		$location_label = get_post_meta($post->ID, "map-location_label", true); ?>
		<div class="map-image">
			<div id="map" rel="<?php echo $location; ?>" <?php if($latlong != "") : ?>data-latlong="<?php echo $latlong; ?>"<?php endif; ?>></div>
			<?php
				$location_label = str_replace(" ", "%20", $location_label);
				$string = file_get_contents("http://maps.googleapis.com/maps/api/geocode/xml?address=$location_label&sensor=true");
				$xml = @simplexml_load_string($string) or print ("no file loaded");
				$addstring = "";
				$added = array();
				
				//Places nearby:
				$url = "http://maps.googleapis.com/maps/api/place/search/xml?type=establishment&location=".$xml[0]->result->geometry->location->lat.",".$xml[0]->result->geometry->location->lng."&radius=7500&sensor=true&key=AIzaSyD3jfeMZK1SWfRFDgMfxn_zrGRSjE7S8Vg";
				$string = file_get_contents($url);
				$xml = @simplexml_load_string($string) or print ("no file loaded"); 
			?>
		</div>
	</div>

	<div id="crumbs-container">
		<?php ocmx_breadcrumbs(); ?>     
	</div>
    
    <?php else : 
		get_template_part('/functions/page-title'); 
	endif; ?>
    
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
	$address_shown =  get_post_meta($post->ID, "address", true); ?>
	<div id="content" class="clearfix">
		<div id="left-column" class="contact-template">
			<div class="post-content">
				<?php if($contact_header !="title") : ?>
                    <div class="page-title-block">
                        <h3 class="page-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    </div>
                <?php endif; ?>
				<div class="copy clearfix">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
		<div id="right-column">
			<ul class="widget-list blog-sidebar">
				<li class="widget">
					<h4 class="widgettitle"><?php _e('Find Us', 'ocmx'); ?></h4>
					<div class="copy">
						<p>
							<?php echo $address_shown; ?>
						</p>
					</div>
				</li>
			</ul>
		</div>
	</div>
<?php endwhile; endif; ?>
	
<?php get_footer(); ?>