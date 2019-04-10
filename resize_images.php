<?php
    
    session_start();
    require 'controller/create/create_Db.php';
	require 'controller/connectDb/connectDb.php';
	require 'controller/create/create_tables.php';


    require 'controller/classes/operations.php';
	require 'controller/classes/fetch_operations.php';

    $operations = new Operations();
	$fetch_operations = new Fetch();
    
    $all_posts = $fetch_operations->fetch_by_order_from_table('Posts',array(),array(),array('id','user_id','Type','Image_or_Vid','Image_or_Vid_Thumb','Description','Date','mime_type'),"`id` DESC");
    
    foreach($all_posts as $post){

        $mime = $post['mime_type'];
        $blob = $post['Image_or_Vid'];
        $id = $post['id'];

        $new_blob = mysql_real_escape_string($operations->check_image_blob_height($blob,$mime));

        if($new_blob != false){
            echo 'yea';//die();
            $operations->update_user('Posts',array('Image_or_Vid'),array($new_blob),$id);
        }
        

    }


?>


