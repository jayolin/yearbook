
<?php $offset = 0; ?>
<script> 
    var offset = 0 
</script>
<?php
    
    session_start();
    require '../create/create_Db.php';
	require '../connectDb/connectDb.php';
	require '../create/create_tables.php';


    require '../classes/operations.php';
	require '../classes/fetch_operations.php';

    $operations = new Operations();
	$fetch_operations = new Fetch();

    require '../profile/issets.php';
    require '../profile/dashboard_excerpts.php';
    
    
    
    

    if(isset($_GET['s'])){
        $post_id = $_GET['s'];
        $dir = '';
        $post = $fetch_operations->fetch_from_table('Posts',array('id'),array($post_id),array('id','Image_or_Vid','user_id','Description','Date','mime_type'));
        $poster = $fetch_operations->fetch_from_table('All_Users',array('id'),array($post[0]['user_id']),array('Name'));
        $poster = explode(' ',$poster[0]['Name']);
        if(isset($_GET['h']) && isset($_GET['g'])){

            $table = ucfirst($_GET['h']);
            $comment_id = $_GET['g'];
            $comment = $fetch_operations->fetch_by_order_from_table($table,array('id'),array($comment_id),array('user_id','comment','Date')," `id` ASC");
            $commenter = $fetch_operations->fetch_from_table('All_Users',array('id'),array($comment[0]['user_id']),array('Nickname','Name'));
        
        }
        
    }
    else{
        header("Location: ../../home");
        die();
    }

    
    $page_name = $poster[1].'\'s Post';
    $hide_more = true;

    require '../../views/head/head_sta.html';
    require '../../views/head/navbar.php';

?>
<div style="margin-top:70px">
    <div class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
        <?php

            $blob = $post[0]['Image_or_Vid'];
            //$finfo = new finfo(FILEINFO_MIME);
            $mimeType = $post[0]['mime_type'];
            $mime = substr($mimeType,0,strpos($mimeType,'/'));
            
            $desc = $post[0]['Description'];
            $post_owner = $fetch_operations->fetch_from_table('All_Users',array('id'),array($post[0]['user_id']),array('Nickname','Display_Pic_Thumb'));
            $liked = $fetch_operations->fetch_rows_from_table('Likes',array('user_id','post_id'),array($user_id,$post_id));
            
            if($liked == 0) $post_bool = 0;
            else $post_bool = 1;

            $post_nick = substr($post_owner[0]['Nickname'],1);
            $post_owner_img = $post_owner[0]['Display_Pic_Thumb'];

            if(empty($post_owner_img)) $post_src = "../../model/files/img/image.jpg";
            else $post_src = "data:image/jpeg;base64,".base64_encode($post_owner_img);


            $likes = $fetch_operations->fetch_rows_from_table('Likes',array('post_id'),array($post[0]['id']));
            $comments = $fetch_operations->fetch_rows_from_table('Comments',array('post_id'),array($post[0]['id']));


            switch($mime){
                case 'image':
                    require '../../views/body/image_post.php';
                break;
                case 'video':
                    require '../../views/body/video_post.php';
                break;
                case 'audio':
                    require '../../views/body/audio_post.php';
                break;

                case 'application'://has to be pdf
                    require '../../views/body/doc_post.php';
                break;
            }
            
        ?>
    </div>
</div>
    


<script>

    

    $('.click-img').dblclick(function(){

        var postId = $(this).attr('post');
        var postBool = $(this).attr('postbool');
        likePost(postId,postBool);

    })
    $('.pause-play.'+offset).click(function(){

        var postId = $(this).attr('post');
        pausePlay(postId);

    });

    $('.pe-7s-like').click(function(){

        var postId = $(this).attr('post');
        var postBool = $(this).attr('postbool');
        likePost(postId,postBool);

    })

    $(window).on('resize load',function(){

        resize_heart('.heart');

    }
    )
    
    $(window).on('resize load scroll',function(){

        
        $('video.click-img, audio').each(function(){

            if($(this).isInViewport()){

                //alert($(this).attr('src'));
                $(this).get(0).play();

            }
            else{
                //alert();
                $(this).get(0).pause();
            }

        });
        

    })
    

</script>  


