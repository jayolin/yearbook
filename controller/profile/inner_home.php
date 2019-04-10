
<?php
    //$limit_posts = array();
    if(!empty($limit_posts)){

        $dir = 'controller/sta/';
        foreach($limit_posts as $post){

            $post_id = $post['id'];
            $blob = $post['Image_or_Vid'];
            //$finfo = new finfo(FILEINFO_MIME);
            $mimeType = $post['mime_type'];
            $mime = substr($mimeType,0,strpos($mimeType,'/'));
            // $file_head = substr($mimeType,0,strpos($mimeType,'/'));
            // $extras = '';


            
            
            $desc = $post['Description'];
            $post_owner = $fetch_operations->fetch_from_table('All_Users',array('id'),array($post['user_id']),array('Nickname','Display_Pic_Thumb'));
            $liked = $fetch_operations->fetch_rows_from_table('Likes',array('user_id','post_id'),array($user_id,$post_id));
            
            if($liked == 0) $post_bool = 0;
            else $post_bool = 1;

            $post_nick = substr($post_owner[0]['Nickname'],1);
            $post_owner_img = $post_owner[0]['Display_Pic_Thumb'];

            if(empty($post_owner_img)) $post_src = "model/files/img/image.jpg";
            else $post_src = "data:image/jpeg;base64,".base64_encode($post_owner_img);


            $likes = $fetch_operations->fetch_rows_from_table('Likes',array('post_id'),array($post['id']));
            $comments = $fetch_operations->fetch_rows_from_table('Comments',array('post_id'),array($post['id']));


            switch($mime){
                case 'image':
                    require 'views/body/image_post.php';
                break;
                case 'video':
                    require 'views/body/video_post.php';
                break;
                case 'audio':
                    require 'views/body/audio_post.php';
                break;

                case 'application'://has to be pdf
                    require 'views/body/doc_post.php';
                break;
                // case 'application':
                //     $file_head = 'audio';
                //     $mimeType = 'audio/mp3';
                //     $extras = 'loop controls';
                    
                // break;
            }

            

        }

    }


    else{
        
        $heading = 'No Posts Yet';
        $body = 'There are no posts yet.<br/> <small><a href="post">Start sharing now!</a></small>';
        $per = 80;
        echo '<div class="col-xs-11">';
        require 'views/body/empty_view.php';
        echo '</div>';
    }



?>

<script>

    
    //alert(offset);
    $('.click-img.'+offset).dblclick(function(){

        var postId = $(this).attr('post');
        var postBool = $(this).attr('postbool');
        likePost(postId,postBool);

    });

    $('.pause-play.'+offset).click(function(){

        var postId = $(this).attr('post');
        pausePlay(postId);

    });

    $('.pe-7s-like.'+offset).click(function(){

        var postId = $(this).attr('post');
        var postBool = $(this).attr('postbool');
        likePost(postId,postBool);

    })

    
    

</script>