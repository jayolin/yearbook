
<!--<h4>&#x1F61A;</h4>-->
<?php $offset = 0; //die()?>
<script> 
    var offset = 0 
</script>


<div id="flux" style="padding-bottom:70px" class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
    <div id="inner_flux">
        <?php
            $flux_table = 'Posts';
            $limit_posts = $all_posts;
            
            require 'inner_home.php';

        ?>
    </div>
    <div style="opacity:0" class="text-center loader">
        <i style="color:#a3a3a3" class="fa fa-spinner fa-spin fa-2x"></i>
   </div>
</div>


<script>

    $(window).on('resize load',function(){

        resize_heart('.heart');

    }
    )
    
    $(window).on('resize load scroll',function(){

        
        $("video.click-img, audio").each(function(){
            //alert();
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


