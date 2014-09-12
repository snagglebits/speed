<?php
function clean_galleries($order_by = "dbDate")
	{
		global $wpdb;
		$galleries = get_posts("post_type=ocmx_gallery&showposts=-1");
		foreach($galleries as $gallery) :
			$postid = $gallery->ID;
			$use_sql = "SELECT * FROM ".$wpdb->prefix."ocmx_gallery WHERE LinkTitle = '".$postid. "'";
			$get_gallery = $wpdb->get_row($use_sql);
			if(count($get_gallery) == 0)
				wp_delete_post( $postid, true);
		endforeach;
	}
add_action("init", "clean_galleries");

function list_ocmx_galleries($order_by = "dbDate")
	{
		global $wpdb;
		$main_table = $wpdb->prefix . "ocmx_gallery";
		$use_sql = "SELECT *, Description as GalleryDescription, Item as GalleryTitle FROM $main_table ORDER BY ".$order_by." DESC";
		$table_Details =  $wpdb->get_results($use_sql);
		return $table_Details;
	}
function fetch_ocmx_gallery_default($gallery_id = 0)
	{
		global $wpdb, $gallery_id;
		$use_sql = "SELECT * FROM ".$wpdb->prefix."ocmx_gallery_dtl WHERE GalleryId = ".$gallery_id." ORDER BY galleryCover DESC";
		$default_image =  $wpdb->get_results($use_sql);	
		return $default_image;
	}
function fetch_ocmx_gallery($gallery_id = 0, $order_by = "image_order", $order = "ASC")
	{
		global $wpdb;
		$main_table = $wpdb->prefix . "ocmx_gallery";
		$sub_table  = $wpdb->prefix . "ocmx_gallery_dtl";
		$use_sql = 
		"SELECT ".$main_table.".*, ".$sub_table.".*, ".$main_table.".Description as GalleryDescription, ".$main_table.".Item as GalleryTitle, ".$main_table.".menuId as menuId, ".$sub_table.".dbDate as ImageDate, ".$sub_table.".menuId as SubId
		FROM ".$main_table." INNER JOIN ".$sub_table." 
		ON ".$sub_table.".GalleryId = ".$main_table.".menuId";
		if($gallery_id !== 0) :
			$use_sql .= " WHERE ".$main_table.".menuId = '".$gallery_id."'";
		endif;
		$use_sql .= " ORDER BY ".$sub_table.".".$order_by." ".$order.", ".$main_table.".dbDate"; 
		
		$table_Details =  $wpdb->get_results($use_sql);
		return $table_Details;
	}	
function fetch_next_prev_gallery($gallery_id, $gtlt = '>', $class = 'next')
	{
		global $wpdb;
		
		$use_sql = "SELECT * FROM ".$wpdb->prefix."ocmx_gallery WHERE menuId ".$gtlt." ".$gallery_id. " ORDER BY dbDate DESC, menuId";
		if($gtlt == '>') :
			$use_sql .= " ASC";
		else :
			$use_sql .= " DESC";
		endif;
		
		$get_gallery = $wpdb->get_row($use_sql);
		
		if(count($get_gallery) !== 0) :
			$link = get_gallery_link($get_gallery);
			$html = "<a href=\"".$link."\" class=\"".$class."\">&nbsp;</a>";
			return $html;
		else :
			return false;
		endif;
	}
	
function fetch_linked_ocmx_gallery($post_id = 0)
	{
		global $wpdb;
		$main_table = $wpdb->prefix . "ocmx_gallery";
		$use_sql = "SELECT * FROM $main_table WHERE `LinkTitle` = ".$post_id;
		$table_Details =  $wpdb->get_results($use_sql);
		return $table_Details[0]->menuId;
	}
	
function get_gallery_link($gallery_list)
	{
		$post_id = $gallery_list->LinkTitle;
				
		if(is_numeric($post_id)) :
			$link = get_permalink($post_id);
		else :
			$link = get_template_directory_uri()."/view_gallery.php?gallery=".$gallery_list->menuId;
		endif;
		
		return $link;
	}
?>