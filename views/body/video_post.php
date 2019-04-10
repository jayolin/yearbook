
<div style="margin: 20px 0">
    <div style="margin-bottom: 20px">
        <img class="img-circle" src="<?php echo $post_src?>" height="35" width="35"/> &nbsp; <?php echo $post_nick; ?>
    </div>
    <div class="row">
        
        <div style="position:relative;" height="0" width="0">
            <b post="<?php echo $post_id; ?>" style="position:absolute;right:5%;top:8;color:white;cursor:pointer;z-index:99" class="fa fa-2x fa-video-camera pause-play <?php echo $offset?>"></b>
        </div>


        <video loop postbool="<?php echo $post_bool; ?>" post="<?php echo $post_id; ?>" class="img-responsive click-img <?php echo $offset?>" style="border-top:1px solid #e3e3e3;display:block;margin:0 auto;">
            <source src="data:<?php echo $mimeType;?>;base64,<?php echo base64_encode($blob);?>">
        </video>
        <div style="position:relative" height="0" width="0">
            <b post="<?php echo $post_id; ?>" style="position:absolute;bottom:1em;left:42%;color:white;" class="fa fa-heart fa-5x heart hidden <?php echo $offset?>"></b>
        </div>
    </div>
    <div class="post-action" style="margin-top: 10px;">
        <a><i style="<?php if($post_bool == 1) echo 'color:cornflowerblue;font-weight:bold';?>;cursor:pointer" postbool="<?php echo $post_bool; ?>" post="<?php echo $post_id; ?>" class="pe-7s-like <?php echo $offset?>"></i></a> <a href="<?php echo $dir; ?>comments.php?s=<?php echo $post_id; ?>"><i class="pe-7s-comment"></i></a>
        <h6><strong ><span post="<?php echo $post_id; ?>"><?php echo $likes ?></span> likes</strong></h6>
    </div>
    
    <p>
        <strong><?php echo $post_nick; ?>:</strong> <?php echo $desc ?>
        <br/>
        <?php
            if($comments != 0) echo '<a style="color:#a0a0a0" href="'.$dir.'comments.php?s='.$post_id.'"><small>View all '.$comments.' Comment(s)</small></a>';
        ?>
        
        <br/><br/><br/><br/>
    </p>
</div>