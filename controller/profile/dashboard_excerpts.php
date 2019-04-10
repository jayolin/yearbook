<?php

    $me= $fetch_operations->fetch_from_table('All_Users',array('id'),array($user_id),array('Name','RegNo','Nickname','Sex','Phone','Display_Pic_Thumb','Likes','Dislikes','Favourite_Food','Favourite_Colors','Favourite_Quotes','Bio'));

	$all_posts = $fetch_operations->fetch_by_order_from_table('Posts',array(),array(),array('id','user_id','Type','Image_or_Vid','Image_or_Vid_Thumb','Description','Date','mime_type'),"`id` DESC LIMIT 0, 5");
    $all_my_posts = $fetch_operations->fetch_by_order_from_table('Posts',array('user_id'),array($user_id),array('id','user_id','Type','Image_or_Vid','Image_or_Vid_Thumb','Description','Date','mime_type'),"`id` DESC");

    $class_mates = $fetch_operations->fetch_by_order_from_table('All_Users',array(),array(),array('id','Name','RegNo','Nickname','Sex','Phone','Display_Pic_Thumb','Likes','Dislikes','Favourite_Food','Favourite_Colors','Favourite_Quotes','Sex','Bio'),"`Name` ASC");

    $profile_bool = $operations->check_complete_profile(array($me[0]['Bio'],$me[0]['Display_Pic_Thumb'],$me[0]['Likes'],$me[0]['Dislikes'],$me[0]['Favourite_Food'],$me[0]['Favourite_Colors'],$me[0]['Favourite_Quotes']));

    //$all_my_posts = $fetch_operations->fetch_from_table('Posts',array('user_id'),array($user_id),array('id'));
    $my_posts_ids = array();
    foreach($all_my_posts as $my_post){ array_push($my_posts_ids,$my_post['id']); }


    $all_my_likes_notifs = $fetch_operations->fetch_in_from_table('Likes',$my_posts_ids,'post_id',array('id','post_id','Date','user_id','seen'));
    $all_my_comments_notifs = $fetch_operations->fetch_in_from_table('Comments',$my_posts_ids,'post_id',array('id','post_id','Date','user_id','seen','comment'));
    $all_my_mentions_notifs = $fetch_operations->fetch_from_table('Mentions',array('mentionee_id'),array($user_id),array('id','post_id','Date','mentioner_id','seen'));
    
    //die();
    $notifications_array = array();
    $notif_count = 0;

    //print_r($all_my_mentions_notifs);die();
    foreach($all_my_mentions_notifs as $mention_notif){

        $arr_single_notif_item = array();
        $arr_single_notif_item['id'] = $mention_notif['post_id'];
        $arr_single_notif_item['real_id'] = $mention_notif['id'];
        $arr_single_notif_item['date'] = $mention_notif['Date'];
        $arr_single_notif_item['verb'] = 'mentioned you on a post';
        $arr_single_notif_item['flag'] = false;
        $arr_single_notif_item['user_id'] = $mention_notif['mentioner_id'];
        $arr_single_notif_item['seen'] = $mention_notif['seen'];
        array_push($notifications_array,$arr_single_notif_item);

        if($mention_notif['seen'] == 0 && $mention_notif['mentioner_id'] != $user_id) $notif_count++;

    }

    foreach($all_my_likes_notifs as $like_notif){

        $arr_single_notif_item = array();
        $arr_single_notif_item['id'] = $like_notif['post_id'];
        $arr_single_notif_item['real_id'] = $like_notif['id'];
        $arr_single_notif_item['date'] = $like_notif['Date'];
        $arr_single_notif_item['verb'] = 'liked your post';
        $arr_single_notif_item['flag'] = false;
        $arr_single_notif_item['user_id'] = $like_notif['user_id'];
        $arr_single_notif_item['seen'] = $like_notif['seen'];
        array_push($notifications_array,$arr_single_notif_item);

        if($like_notif['seen'] == 0 && $like_notif['user_id'] != $user_id) $notif_count++;

    }

    foreach($all_my_comments_notifs as $comment_notif){

        $arr_single_notif_item = array();
        $arr_single_notif_item['id'] = $comment_notif['post_id'];
        $arr_single_notif_item['real_id'] = $comment_notif['id'];
        $arr_single_notif_item['date'] = $comment_notif['Date'];
        $arr_single_notif_item['verb'] = 'commented on your post';
        $arr_single_notif_item['flag'] = true;
        $arr_single_notif_item['user_id'] = $comment_notif['user_id'];
        $arr_single_notif_item['seen'] = $comment_notif['seen'];
        $arr_single_notif_item['comment'] = $comment_notif['comment'];

        array_push($notifications_array,$arr_single_notif_item);
        if($comment_notif['seen'] == 0 && $comment_notif['user_id'] != $user_id) $notif_count++;

    }
    //$notif_count = count($all_my_likes_notifs) + count($all_my_comments_notifs);//die();
    
    //echo $profile_bool;die();
//die();
?>