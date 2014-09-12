<?php function ocmx_gallery_update()
	{
		if(isset($_POST["ocmx_gallery_update"])) :
			/* Marc Perel - OCMX Gallery Update Code */
			global $wpdb, $gallery_added, $no_delete, $changes_done;
			
			$main_table = $wpdb->prefix . "ocmx_gallery";
			$sub_table  = $wpdb->prefix . "ocmx_gallery_dtl";
			$upload_dir = wp_upload_dir();
			$upload_folder = $upload_dir['basedir'];
			
			if(!($_POST["edit_item"])) :
				// Create Insert SQL and Insert the new Data 
				$insert_sql = "
						INSERT INTO ".$main_table."
							(
								`Item`,
								`Description`,
								`dbDate`";
								if(isset($_POST["gallery_effect"])) :
									$insert_sql .= ",`image_effect`";
								endif;
				$insert_sql .= "
							)
						VALUES
							(
								'".$_POST["Item"]."',
								'".$_POST["myEditor"]."',
								'".date("Y/m/d")."'";
								if(isset($_POST["gallery_effect"])) :
									$insert_sql .= ",'".$_POST["gallery_effect"]."'";
								endif;
				$insert_sql .= ")";				
				$wpdb->query($insert_sql);
				
				// Fetch the details of the new Gallery Id
				$new_id_sql = "SELECT * FROM ".$main_table." ORDER BY `MenuId` DESC";		
				$get_newId = $wpdb->get_results($new_id_sql);
				$the_menuId = $get_newId[0]->menuId;	
			
				if(isset($_POST["auto_post"])) :
					$my_post = array();
					$my_post['post_type'] = 'ocmx_gallery';
					$my_post['post_title'] = $_POST["Item"];
					$my_post['post_content'] = '[ocmx-gallery id="'.$the_menuId.'"]';
					$my_post['post_name'] = $_POST["LinkTitle"];
					$my_post['post_status'] = 'publish';
					wp_insert_post( $my_post );
					$latest_post = get_posts("post_type=ocmx_gallery&sort_order=DESC&sort_column=ID&number=1");
					$update_sql = "UPDATE ".$main_table." SET `LinkTitle` = '".$latest_post[0]->ID."' WHERE menuId = ".$the_menuId;
					$wpdb->query($update_sql);
				endif;
			else :
				// Create Update SQL and Insert the new Data 
				$update_sql = "UPDATE ".$main_table."
								SET `Item` = '".$_POST["Item"]."',
									`LinkTitle` = '".$_POST["LinkTitle"]."',
									`Description` = '".$_POST["myEditor"]."',
									`dbDate` = '".date("Y-m-d", strtotime($_POST["dbDate"]))."',
									`Tags` = '".$_POST["tags"]."'";
									if(isset($_POST["gallery_effect"])) :
										$update_sql .= ", `image_effect` = '".$_POST["gallery_effect"]."'";
									endif;
				$update_sql .= "WHERE menuId = ".$_POST["edit_item"];
								
				mysql_query($update_sql);
					
				// Create and Fetch the details of the existing images 
				$fetch_images_sql = "SELECT * FROM ".$sub_table." WHERE GalleryId = ".$_POST["edit_item"];
				$get_images = $wpdb->get_results($fetch_images_sql);
				
				// Loop through the existing images
				$i = 1;
				foreach($_POST as $key => $value) :
					if(substr($key, 0, 4) == "item") :		
						//Load the ID of the image we're dealing with
						$image_id = substr($key, 5, strlen($key)-5);
						
						$image_idtem_element = "item_".$image_id;
						$description_element = "description_".$image_id;
						$order_element = "order_".$image_id;
						$delete_element = "remove_image_".$image_id;		
						if($_POST[$delete_element]) :
							// Delete Gallery Detail 
							$delete_sql = "DELETE FROM ".$sub_table." WHERE `menuId` = ".$image_id. " LIMIT 1";
							$wpdb->query($delete_sql);
							$thumb_File = $upload_folder."/ocmx-gallery/thumbs/".$this_image->Image;
							$small_File = $upload_folder."/ocmx-gallery/small/".$this_image->Image;
							$large_File = $upload_folder."/ocmx-gallery/large/".$this_image->Image;
							if(($thumb_File) === true){unlink($thumb_File);};
							if(($small_File) === true){unlink($small_File);};
							if(($large_File) === true){unlink($large_File);};
						else :
							// Update Gallery Detail 
							$gallery_dtl_update_sql =
							   "UPDATE ".$sub_table."
								SET `Item` = '".$_POST[$image_idtem_element]."',
									`Description` = '".$_POST[$description_element]."',
									`image_order` = '$i',
									`galleryCover` = ";
									
							if($_POST["album_cover"]  == $image_id):
								$gallery_dtl_update_sql .= "1";
							else :
								$gallery_dtl_update_sql .= "0";
							endif;
							
							$gallery_dtl_update_sql .= " WHERE menuId = ".$image_id;
							$wpdb->query($gallery_dtl_update_sql);
							
							$i++;
						endif; 
					endif;
				endforeach;
				
				$the_menuId = $_POST["edit_item"];
			endif;
			
			/* IMAGE UPLOADING */
			$base_File = $upload_folder."/ocmx-gallery/";
			$thumb_File = $upload_folder."/ocmx-gallery/thumbs/";
			$small_File = $upload_folder."/ocmx-gallery/small/";
			$large_File = $upload_folder."/ocmx-gallery/large/";
			
			$file_count = count($_FILES["file"]["name"]);
			for($i = 1; $i < $file_count; $i++)
				{
					/* Upload original first */
					$image_name = strtolower($_FILES["file"]["name"][$i]);
					$final_upload = $base_File.$image_name;
					
					$test = move_uploaded_file($_FILES["file"]["tmp_name"][$i], $final_upload);
					if($test === true) :
						
						/************/
						/*  THUMBS  */
						
						//Set the resize dimensions
						$max_w = 150;
						$max_h = 150;
						$upload_image = $thumb_upload;
						$add_images = ocmx_custom_resize($final_upload, $max_w, $max_h, true, "thumb", $thumb_File, 100);
									
						/***********/
						/*  SMALL  */	
						$max_h = $_POST["small_height"];
						$max_w = $_POST["small_width"];
						
						$add_images = ocmx_custom_resize($final_upload, $max_w, $max_h, true, "small", $small_File, 100);
						
						/***********/
						/*  LARGE  */	
						$max_h = $_POST["large_height"];
						$max_w = $_POST["large_width"];
						
						$add_images = ocmx_custom_resize($final_upload, $max_w, $max_h, false, "large", $large_File, 100);
						
						$check_order = $wpdb->get_row("SELECT * FROM `".$sub_table."` WHERE GalleryId = ".$the_menuId." ORDER BY image_order DESC");
						$image_order = (($check_order->image_order)+1);
						
						if($i == 1 && !($_POST["edit_item"])) :
							$insert_image_sql = "INSERT INTO ".$sub_table."(`GalleryId`,`Image`,`dbDate`, `galleryCover`, `image_order`) VALUES(".$the_menuId.",'".$image_name."','".date("Y-m-d")."', 1, ".$image_order.")";
						else :
							$insert_image_sql = "INSERT INTO ".$sub_table."(`GalleryId`,`Image`,`dbDate`, `galleryCover`, `image_order`) VALUES(".$the_menuId.",'".$image_name."','".date("Y-m-d")."', 0, ".$image_order.")";
						endif;
						
						$wpdb->query($insert_image_sql);
					endif;		
				}
			
			$new_location = str_replace("new=", "edit=1", $_SERVER['REQUEST_URI']);
			if(!isset($_POST["edit_item"])) : $new_location = str_replace("id=", "id=".$the_menuId, $new_location); endif;
			if(!isset($_GET["current_tab"])) : $new_location = $new_location."&current_tab=2"; endif;
			if(!isset($_GET["changes_done"])) : $new_location = $new_location."&changes_done=1"; endif;
			wp_redirect($new_location);
		endif;
	}
add_action("init", "ocmx_gallery_update");
?>