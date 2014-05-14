<?php function ocmx_comment_post()
	{
		global $header_class, $main_class, $footer_class, $comment, $wpdb, $comment_post_ID;
		if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
			header('Allow: POST');
			header('HTTP/1.1 405 Method Not Allowed');
			header('Content-Type: text/plain');
			exit;
		}
		
		nocache_headers();
		
		$comment_post_ID = (int) $_REQUEST['comment_post_id'];
		
		$status = $wpdb->get_row( $wpdb->prepare("SELECT post_status, comment_status FROM $wpdb->posts WHERE ID = %d", $comment_post_ID) );
		if ( empty($status->comment_status) ) : ?>
			<p><?php _e("Comment I.D. not found.", "ocmx"); ?></p>
		<?php
			exit;
		elseif ( !comments_open($comment_post_ID) ) : ?>
			<p class="error"><?php _e("Sorry, comments are closed for this item.", "ocmx"); ?></p>
		<?php
			exit;
		
		elseif ( in_array($status->post_status, array('draft', 'pending') ) ) : ?>
			<p class="error"><?php _e("Comment on Draft", "ocmx"); ?></p>
		<?php 
			exit;
		endif;
		
		global $comment_twitter , $comment_subscribe;
		$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
		$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
		$comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
		$comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;
		$comment_twitter      = ( isset($_POST['twitter']) ) ? trim($_POST['twitter']) : null;
		$comment_subscribe      = ( isset($_POST['email_subscribe']) ) ? trim($_POST['email_subscribe']) : null;
		
		$comment_meta_table = $wpdb->prefix . "ocmx_comment_meta";	
		
		$check_blocked = $wpdb->get_row( $wpdb->prepare("SELECT $wpdb->comments.*, $comment_meta_table.* FROM $wpdb->comments INNER JOIN $comment_meta_table ON $wpdb->comments.comment_ID = $comment_meta_table.commentId WHERE $wpdb->comments.comment_author_email = %s AND $comment_meta_table.block_user = 1", $comment_author_email) );
		
		if(count($check_blocked) !== 0) : ?>
			<p class="error"><?php _e("Your email address has been blocked from commenting on this blog.", "ocmx"); ?></p>
		<?php 
			exit;
		endif;
		// If the user is logged in
		$user = wp_get_current_user();
		if ( $user->ID ) {
			if ( empty( $user->display_name ) )
				$user->display_name=$user->user_login;
			$comment_author       = $wpdb->escape($user->display_name);
			$comment_author_email = $wpdb->escape($user->user_email);
			$comment_author_url   = $wpdb->escape($user->user_url);
			if ( current_user_can('unfiltered_html') ) {
				if ( isset($_POST['_wp_unfiltered_html_comment']) && wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment'] ) {
					kses_remove_filters(); // start with a clean slate
					kses_init_filters(); // set up the filters
				}
			}
		} else {
			if ( get_option('comment_registration') )
				die( __('Sorry, you must be logged in to post a comment.','ocmx') );
		}
		
		$comment_type = '';
		
		if ( get_option('require_name_email') && !$user->ID ) {
			if ( 6 > strlen($comment_author_email) || '' == $comment_author )
				die( __('Error: please fill the required fields (name, email).','ocmx') );
			elseif ( !is_email($comment_author_email))
				die( __('Error: please enter a valid email address.','ocmx') );
		}
		
		if ( '' == $comment_content )
			die( __('Error: please type a comment.','ocmx') );
		
		$comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;
		
		$commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');
		
		$comment_id = wp_new_comment( $commentdata );
		
		$comment = get_comment($comment_id);
		if ( !$user->ID ) {
			setcookie('comment_author_' . COOKIEHASH, $comment->comment_author, time() + 30000000, COOKIEPATH, COOKIE_DOMAIN);
			setcookie('comment_author_email_' . COOKIEHASH, $comment->comment_author_email, time() + 30000000, COOKIEPATH, COOKIE_DOMAIN);
			setcookie('comment_author_url_' . COOKIEHASH, esc_url($comment->comment_author_url), time() + 30000000, COOKIEPATH, COOKIE_DOMAIN);
		}
	show_comments($comment);
	die("");
} ?>