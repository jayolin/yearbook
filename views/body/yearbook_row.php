

<div style="margin: 20px 0" class="row">

    <div class="col-xs-2" style="">
        <img class="img-circle" src="<?php echo $post_src?>" height="30" width="30"/>
    </div>
    <div class="col-xs-7" style="border-bottom: 1px solid #e3e3e3;padding-bottom:20px">
        <strong><?php echo $class_mate_name; ?></strong>
        <small style="color:#a0a0a0"><i><?php echo substr($class_mate_bio,0,40).'...' ?></i></small>
    </div>
    <div class="col-xs-3"><a href="controller/sta/yb_profile.php?s=<?php echo $class_mate_id;?>" style="" class="btn btn-sm btn-primary">View</a></div>


</div>