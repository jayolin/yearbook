<?php

	
	error_reporting(0);
	if(isset($_SESSION['DIGITRON_2017'])){
		
		$user_id = $_SESSION['DIGITRON_2017'];

	}
	else{
		header('Location:login.php');
		die();
	}


	//die();

	if(isset($_POST['delete_id'])){

		$delete_id = $_POST['delete_id'];
		//delete from posts, likes,comments,mentions...
		$operations->delete_from_table('Posts','id',$delete_id);
		$operations->delete_from_table('Likes','post_id',$delete_id);
		$operations->delete_from_table('Comments','post_id',$delete_id);
		$operations->delete_from_table('Mentions','post_id',$delete_id);

		$action = 'Post Deleted!';

	}


	if(isset($_POST['post_caption']) && isset($_POST['post_mimetype'])){

		$post_caption = mysql_real_escape_string($_POST['post_caption']);
		$post_mimetype = mysql_real_escape_string($_POST['post_mimetype']);
		//die();
		if(!empty($_FILES['post_photo']['name'])){

			$tmp_name = $_FILES['post_photo']['tmp_name'];
			if($operations->check_image_height($tmp_name,$post_mimetype) == false){

				$fp = fopen($tmp_name,'r');
				$blob = addslashes(fread($fp,filesize($tmp_name)));
				fclose($fp);

			}
			else{
				$blob = mysql_real_escape_string($operations->check_image_height($tmp_name,$post_mimetype));
			}

			$blob_thumb = $operations->create_thumbnail($tmp_name);
			$blob_thumb = mysql_real_escape_string($blob_thumb);


			$post_id = $operations->insert_user('Posts',array('Image_or_Vid','Image_or_Vid_Thumb','Description','Date','user_id','mime_type'),
			array($blob,$blob_thumb,$post_caption,time(),$user_id,$post_mimetype));

			//check for mentions
			$operations->check_text_for_mentions($user_id,$post_caption,$post_id,$fetch_operations,'Posts',$post_id,'Description','controller/sta/');
			


			$action = 'Post Shared!';

		}

		elseif(isset($_POST['text_on_img']) && isset($_POST['bg_color']) && isset($_POST['color']) && isset($_POST['weight'])){

			//echo 'ghdj';die();
			$text_on_img = mysql_real_escape_string($_POST['text_on_img']);
			$bg_color = mysql_real_escape_string($_POST['bg_color']);
			$color = mysql_real_escape_string($_POST['color']);
			$weight = mysql_real_escape_string($_POST['weight']);


			$img = $operations->create_img($bg_color,$color,$text_on_img,$weight);
			//header("Content-type:image/png");imagepng($img);die();
			
			
			ob_start();
			imagepng($img);
			$blob  = ob_get_contents();
			ob_end_clean();

			//echo $blob.'<br/><br/>';
			$blob = mysql_real_escape_string($blob);
			
			//echo $blob;//die();
			$operations->destroy_img($img);
			//die();

			$post_id = $operations->insert_user('Posts',array('Image_or_Vid','Image_or_Vid_Thumb','Description','Date','user_id','mime_type'),
			array($blob,$blob,$post_caption,time(),$user_id,'image/png'));

			//check for mentions
			$operations->check_text_for_mentions($user_id,$post_caption,$post_id,$fetch_operations,'Posts',$post_id,'Description','controller/sta/');
			

			//die();
			$action = 'Post Shared!';

		}

		else{
			$action = 'Post not Shared!';
		}

	}


	if(isset($_POST['up_name']) && isset($_POST['up_phone']) && isset($_POST['up_nn']) && isset($_POST['up_ff'])
	&&isset($_POST['up_fc']) && isset($_POST['up_fq']) && isset($_POST['up_likes']) && isset($_POST['up_dislikes'])){


		//die();

		$up_name = mysql_real_escape_string($_POST['up_name']);
		$up_phone = mysql_real_escape_string($_POST['up_phone']);
		$up_nn = mysql_real_escape_string($_POST['up_nn']);
		$up_likes = mysql_real_escape_string($_POST['up_likes']);
		$up_dislikes = mysql_real_escape_string($_POST['up_dislikes']);
		$up_ff = mysql_real_escape_string($_POST['up_ff']);
		$up_fc = mysql_real_escape_string($_POST['up_fc']);
		$up_fq = mysql_real_escape_string($_POST['up_fq']);//die();
		$up_bio= mysql_real_escape_string($_POST['up_bio']);//die();

		
		if(!empty($_FILES['up_photo']['name'])){
			$tmp_name = $_FILES['up_photo']['tmp_name'];
			$fp = fopen($tmp_name,'r');
			$blob = addslashes(fread($fp,filesize($tmp_name)));
			$blob_thumb = $operations->create_thumbnail($tmp_name);
			$blob_thumb = mysql_real_escape_string($blob_thumb);
			fclose($fp);
			//die();
		}
		else {
			$blob = $_POST['hidden_dp'];
			$blob_thumb = $_POST['hidden_dp'];
		}
		

		$operations->update_user('All_Users',array('Name','Phone','Nickname','Likes','Dislikes','Favourite_Food','Favourite_Colors','Favourite_Quotes','Display_Pic','Display_Pic_Thumb','Bio'),
		array($up_name,$up_phone,$up_nn,$up_likes,$up_dislikes,$up_ff,$up_fc,$up_fq,$blob,$blob_thumb,$up_bio),$user_id);
		//die();

		$action = 'Profile Updated!';

	}


	if(isset($_POST['post_id']) && isset($_POST['post_bool'])){

		$post_bool = $_POST['post_bool'];
		$post_id = $_POST['post_id'];

		if($post_bool == 1){
			//delete
			$operations->delete_by_id('Likes',$post_id,$user_id);
		}
		else{
			$operations->insert_user('Likes',array('post_id','user_id','Date','seen'),
			array($post_id,$user_id,time(),0));
		}

		die();

	}



	if(isset($_POST['post_id']) && isset($_POST['comment_body'])){

		$comment_body = mysql_real_escape_string($_POST['comment_body']);
		$post_id = $_POST['post_id'];

		$comment_id = $operations->insert_user('Comments',array('post_id','user_id','Date','comment','seen'),
		array($post_id,$user_id,time(),$comment_body,0));

		//check for mentions
		$operations->check_text_for_mentions($user_id,$comment_body,$post_id,$fetch_operations,'Comments',$comment_id,'comment','');
		//die();
		//$action = 'Comment Posted!';
		$post = $fetch_operations->fetch_from_table('Posts',array('id'),array($post_id),array('user_id','Description','Date'));
        $comments = $fetch_operations->fetch_by_order_from_table('Comments',array('post_id'),array($post_id),array('user_id','comment','Date')," `id` ASC");
		
		require 'inner_comments.php';

		die();
		
	}


	if(isset($_POST['table']) && isset($_POST['offset'])){

		$table = $_POST['table'];
		$offset = $_POST['offset'];
		$limit_posts = $fetch_operations->fetch_by_order_from_table($table,array(),array(),array('id','user_id','Type','Image_or_Vid','Image_or_Vid_Thumb','Description','Date','mime_type'),"`id` DESC LIMIT $offset, 5");
		
		$offset_incr = count($limit_posts);
		 
		if($offset_incr > 0){
			echo '<div id="offset">'.$offset_incr.'</div>';
			echo '<div id="content">';

				require 'controller/profile/inner_home.php';

			echo '</div>';
		}
		else{
			if($offset == $_SESSION[$table.'_offset']){

				//has already alerted the user of no posts
				echo '<div id="offset">0</div>';
				echo '<div id="content"></div>';

			}
			else{
				echo '<div id="offset">0</div>';
				echo '<div id="content">
					<div class="text-center" style="color:#a3a3a3">No more content</div>
				</div>';
			}
			
		}
		
		$_SESSION[$table.'_offset'] = $offset;
		die();

	}


	if(isset($_POST['tag']) && isset($_POST['curr_index']) && isset($_POST['curr_word_length']) && isset($_POST['dir'])){

		$tag = $_POST['tag'];
		$dir = $_POST['dir'];
		$curr_index = $_POST['curr_index'];
		$curr_word_length = $_POST['curr_word_length'];

		$tag_results = $fetch_operations->fetch_or_like_from_table('All_Users',array('Nickname'),array($tag),array('Nickname','Display_Pic_Thumb','Name'));
		
		if(!empty($tag_results)){

			foreach($tag_results as $tag_result){

				$tag_pic = $tag_result['Display_Pic_Thumb'];
				$tag_name = $tag_result['Name'];
				$tag_nick = $tag_result['Nickname'];

				if(empty($tag_pic)) $tag_src = $dir."model/files/img/image.jpg";
				else $tag_src = "data:image/jpeg;base64,".base64_encode($tag_pic);

				require $dir.'views/body/tag_row.php';

			}

		}
		
		die();

	}




	// if(isset($_POST['caption']) && isset($_POST['text_on_img']) && isset($_POST['bg_color']) && isset($_POST['color']) && isset($_POST['weight'])){

	// 	$caption = $_POST['caption'];
	// 	$text_on_img = $_POST['text_on_img'];
	// 	$bg_color = $_POST['bg_color'];
	// 	$color = $_POST['color'];
	// 	$weight = $_POST['weight'];


	// 	$img = $operations->create_img($bg_color,$color,$text_on_img,$weight);
	// 	//header("Content-type:image/png");
		
		
	// 	ob_start();
	// 	imagepng($img);
	// 	$image_content = ob_get_contents();
	// 	ob_end_clean();


	// 	$operations->destroy_img($img);
	// 	//die();

	// 	$post_id = $operations->insert_user('Posts',array('Image_or_Vid','Description','Date','user_id','mime_type'),
	// 	array($blob,$caption,time(),$user_id,'image/png'));

	// 	//check for mentions
	// 	$operations->check_text_for_mentions($user_id,$caption,$post_id,$fetch_operations,'Posts',$post_id,'Description','controller/sta/');
		


	// 	$action = 'Post Shared!';

	// }
	


	if(isset($action)){

		//redirect
		$location = '';

		if(isset($_GET['s'])) $location .= $_GET['s'];
		if(isset($_GET['h'])) $location .= '&h='.$_GET['h'];

		header("Location:".$location);
		//start session
		$_SESSION['changes_made'] = $action;
		die();

	}



	


?>