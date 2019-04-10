
<div class="lower-links">
    <ul class="col-xs-12">
        <li><a href="home"><i  class=" pe-7s-home"></i></a></li>
        <li><a href="yearbook"><i class="pe-7s-bookmarks"></i></a></li>
        <li><a href="post"><i class="pe-7s-camera"></i></a></li>
        <li><a href="notifications"><i class="pe-7s-like"></i></a>
        
            <?php
                if($notif_count > 0) echo '<i style="color:cornflowerblue;font-size:5px;" class="fa fa-circle text-center"></i>';
            ?>
        
        </li>
        <li><a href="profile"><i class="pe-7s-user"></i></a>

            <?php
                if(!$profile_bool) echo '<i style="color:cornflowerblue;font-size:5px;margin-left:0px" class="fa fa-circle text-center"></i>';
            ?>
            
        </li>
    </ul>
</div>