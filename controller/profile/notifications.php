
<?php

    $notif_count = 0;//so that it doesnt show the dot when we at this link
    $operations->set_seen($my_posts_ids,$user_id);

    usort($notifications_array,function($a,$b){

        return strcmp($b['date'],$a['date']);

    });
?>

<div style="padding-bottom:70px" class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">

    <?php
        //$notifications_array = array();
        if(!empty($notifications_array)){

            foreach($notifications_array as $notification){
                
                if($notification['user_id'] == $user_id) continue;

                $notifier = $fetch_operations->fetch_from_table('All_Users',array('id'),array($notification['user_id']),array('Nickname','Display_Pic_Thumb'));
                $notifier_image = $notifier[0]['Display_Pic_Thumb'];
                $notifier_name = substr($notifier[0]['Nickname'],1);
                
                
                $post = $fetch_operations->fetch_from_table('Posts',array('id'),array($notification['id']),array('Image_or_Vid','Image_or_Vid_Thumb','Description','mime_type'));
                $post_image = $post[0]['Image_or_Vid'];
                $post_desc = $post[0]['Description'];

                $post_desc = ' '.$notification['verb'].' <i>"'.substr($post_desc,0,30).'..."</i>';
                $post_id = $notification['id'];
                // if($notification['like']){
                //     $post_desc = ' liked your post <i>"'.substr($post_desc,0,30).'..."</i>';
                    
                // }
                // else{
                //     $post_desc = ' commented on your post <i>"'.substr($post_desc,0,20).'..."</i>';
                // }

                if($notification['seen'] == 0) $post_desc .= ' <i class="badge" style="background:cornflowerblue;opacity:0.5"><small>New</small></i>' ;

                if(empty($notifier_image)) $post_src = "model/files/img/image.jpg";
                else $post_src = "data:image/jpeg;base64,".base64_encode($notifier_image);


                $mime = substr($post[0]['mime_type'],0,strpos($post[0]['mime_type'],'/'));

                switch($mime){

                    case 'image':
                        $post_image = $post[0]['Image_or_Vid_Thumb'];
                        $src = "data:image/png;base64,".base64_encode($post_image);
                        $page = 'views/body/image_card.php';
                    break;

                    case 'video':
                        $src = "data:".$post[0]['mime_type'].";base64,".base64_encode($post_image);
                        $page = 'views/body/video_card.php';
                    break;

                    case 'audio':
                        $src = "model/files/img/downloaded (1).jpg";
                        $page = 'views/body/image_card.php';
                    break;

                    case 'application':
                        $src = "model/files/img/800859_file_512x512.png";
                        $page = 'views/body/image_card.php';
                    break;

                }
                require 'views/body/notifications_row.php';

            }

        }
        else{
            
            $heading = 'No Notifs Yet';
            $body = 'You have no notifications yet';
            $per = 80;
            echo '<div class="col-xs-11">';
            require 'views/body/empty_view.php';
            echo '</div>';
        }

    ?>
    
</div>