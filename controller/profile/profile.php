<?php

    if(empty($me[0]['Display_Pic_Thumb'])) $post_src = "model/files/img/image.jpg";
    else $post_src = "data:image/jpeg;base64,".base64_encode($me[0]['Display_Pic_Thumb']);

?>
<div style="padding-bottom:70px" class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
    <div>
        <div style="margin: 20px 0">
            <div class="row" style="margin-bottom: 20px">
                <div class="col-xs-3">
                    <img onclick="$('#upload_form').click()" style="display:block;margin:0px auto" class="img-circle placeholder_img" src="<?php echo $post_src?>" height="55" width="55"/>
                </div>
                <div class="col-xs-9">
                    <div><?php echo $me[0]['Nickname']; ?></div>
                    <a onclick="$('.posts').toggle()" data-toggle="collapse" data-target="#edit_profile" class="btn btn-default btn-sm" style="padding:4px;margin:3px 0">Edit Profile</a>
                </div>
            </div>
        </div>

    </div>
    

    <div id="edit_profile" class="collapse">
        <form style="margin-top:30px" action="" method="POST" enctype="multipart/form-data">
            <input style="margin-bottom:0;display:none" id="upload_form"  type="file" class="" name="up_photo" />
            <div class="form-group">
                <label>Name</label>
                <input name="up_name" value="<?php echo $me[0]['Name']; ?>" class="form-control"/>
            </div>


            <div class="form-group">
                <label>Phone</label>
                <input name="up_phone" type="number" value="<?php echo $me[0]['Phone']; ?>" class="form-control"/>
            </div>

            <div class="form-group">
                <label>Bio</label>
                <textarea name="up_bio" rows="3" class="form-control"><?php echo $me[0]['Bio']; ?></textarea>
            </div>


            <div class="form-group">
                <label>Nickname</label>
                <input name="up_nn" value="<?php echo $me[0]['Nickname']; ?>" class="form-control"/>
            </div>


            <div class="form-group">
                <label>Likes</label>
                <input name="up_likes" value="<?php echo $me[0]['Likes']; ?>" class="form-control"/>
            </div>


            <div class="form-group">
                <label>Dislikes</label>
                <input name="up_dislikes" value="<?php echo $me[0]['Dislikes']; ?>" class="form-control"/>
            </div>


            <div class="form-group">
                <label>Favourite Food</label>
                <input name="up_ff" value="<?php echo $me[0]['Favourite_Food']; ?>" class="form-control"/>
            </div>

            <div class="form-group">
                <label>Favourite Colors</label>
                <input name="up_fc" value="<?php echo $me[0]['Favourite_Colors']; ?>" class="form-control"/>
            </div>

            <div class="form-group">
                <label>Favourite Quote</label>
                <textarea name="up_fq" rows="3" class="form-control"><?php echo $me[0]['Favourite_Quotes']; ?></textarea>
            </div>

            <div class="form-group">
                <button class="btn form-control btn-submit" style="background:cornflowerblue;color:#FFF">Save</button>
            </div>
        </form>
    </div>


    <div class="posts" style="border-top:1px solid #e3e3e3;margin-top:50px">
        <div class="col-xs-12">
            <?php
            
                if(!empty($all_my_posts)){

                    foreach($all_my_posts as $post){

                        echo '<div style="margin: 10px 0" class="col-xs-6 dropup dropdown-right">

                                <form class="form-'.$post['id'].'" action="" method="POST">
                                    <input name="delete_id" type="hidden" value="'.$post['id'].'"/>
                                </form>
                                    
                                <i class="dropdown-toggle hidden" data-toggle="dropdown">ghj</i>
                                <ul class="dropdown-menu">
                                    <li><a onclick="$(\'.form-'.$post['id'].'\').submit()" href="#"> Delete Post</a></li>
                                </ul>
                                    

                            <a href="controller/sta/single_post.php?s='.$post['id'].'">';
                        $blob_image = $post['Image_or_Vid'];
                        $mime = substr($post['mime_type'],0,strpos($post['mime_type'],'/'));
                        $likes = $fetch_operations->fetch_rows_from_table('Likes',array('post_id'),array($post['id']));

                        switch($mime){

                            case 'image':
                                $blob_image = $post['Image_or_Vid_Thumb'];
                                $src = "data:image/png;base64,".base64_encode($blob_image);//since its thumb
                                require 'views/body/image_card.php';
                            break;

                            case 'video':
                                $src = "data:".$post['mime_type'].";base64,".base64_encode($blob_image);
                                 require 'views/body/video_card.php';
                            break;

                            case 'audio':
                                $src = "model/files/img/downloaded (1).jpg";
                                 require 'views/body/image_card.php';
                            break;

                            case 'application':
                                $src = "model/files/img/800859_file_512x512.png";
                                 require 'views/body/image_card.php';
                            break;

                        }

                        echo '</a></div>';

                    }

                }

            ?>
        </div>
    </div>
    
</div>


<script>

    $('#upload_form').on( "change", function(event) {
        
        var _file = document.getElementById('upload_form');

        if(!window.File && window.FileReader && window.FileList && window.Blob){ //if browser doesn't supports File API
            error.push("Your browser does not support new File API! Please upgrade."); //push error text
        }else{
        //
                //enable submit button once ajax is done
                //alert(res+offi+'.jpg');
            var reader = new FileReader();
            reader.readAsDataURL(_file.files[0]);
            reader.onloadend = function(e){

                var mimeType = e.target.result.split(",")[0].split(":")[1].split(";")[0];
                if(mimeType.substr(0,mimeType.indexOf('/')) != 'image'){
                    showToast($('.toast'),'Unsupported!');
                    $('input[name="post_photo"]').val('');
                }
                else{
                    showToast($('.toast'),'Now Click "Edit Profile"->"Save"');
                    $('.placeholder_img').attr('src',e.target.result);
                }
                
            }
                
                        
                    
        }
                    
    });
</script>

<script>

    $('.dropup').on('contextmenu',function(){
        $('.dropup').removeClass("open");
        $(this).addClass("open");
        //alert();
        return false;
    })

</script>