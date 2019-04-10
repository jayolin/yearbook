


<div style="padding-bottom:70px" class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">

    <?php

        if(!empty($class_mates)){

            foreach($class_mates as $class_mate){

                $blob_image = $class_mate['Display_Pic_Thumb'];
                $class_mate_id = $class_mate['id'];
                $class_mate_name = $class_mate['Name'];
                $class_mate_bio = $class_mate['Bio'];

                if(empty($blob_image)) $post_src = "model/files/img/image.jpg";
                else $post_src = "data:image/jpeg;base64,".base64_encode($blob_image);

                require 'views/body/yearbook_row.php';

            }

        }

    ?>
    
</div>