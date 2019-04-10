




<div style="margin: 20px 0" class="row">

    <div class="col-xs-2" style="">
        <img class="img-circle" src="<?php echo $post_src?>" height="30" width="30"/>
    </div>
    <div class="col-xs-7" style="border-bottom: 1px solid #e3e3e3;padding-bottom:20px">
        <strong><?php echo $notifier_name; ?></strong>
        <small style="color:#a0a0a0"><i><?php echo $post_desc ?></i></small>
    </div>
    <div class="col-xs-3">
        <a href="controller/sta/single_post.php?s=<?php echo $post_id?>">
            <?php require $page ?>
        </a>
    </div>


</div>