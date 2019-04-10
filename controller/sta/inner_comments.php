

<?php

    foreach($comments as $comment){

        $poster= $fetch_operations->fetch_from_table('All_Users',array('id'),array($comment['user_id']),array('Nickname','Display_Pic_Thumb'));
        $poster_pic = $poster[0]['Display_Pic_Thumb'];
        $poster_name = substr($poster[0]['Nickname'],1);

        $post_desc = $comment['comment'];
        $post_time = $operations->get_post_time($comment['Date']);

        if(empty($poster_pic)) $post_src = "../../model/files/img/image.jpg";
        else $post_src = "data:image/jpeg;base64,".base64_encode($poster_pic);

        require '../../views/body/comment_row.php';

    }

?>

<script>
    $('#comments-div').scrollTop($('#comments-div')[0].scrollHeight);
</script>