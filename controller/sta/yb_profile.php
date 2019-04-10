

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
        $classmate_id = $_GET['s'];
        $classmate = $fetch_operations->fetch_from_table('All_Users',array('id'),array($classmate_id),array('Name','Display_Pic_Thumb','RegNo','Phone','Bio','DofB','Sex','Nickname','Likes','Dislikes','Favourite_Food','Favourite_Colors','Favourite_Quotes'));
        
    }
    else{
        header("Location: ../../home");
    }

    $page_name = $classmate[0]['Name'];
    $hide_more = true;

    require '../../views/head/head_sta.html';
    require '../../views/head/navbar.php';
    


?>

<div style="margin-top:70px">
    <div class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
        <?php

            $classmate_pic = $classmate[0]['Display_Pic_Thumb'];
            $classmate_nick = substr($classmate[0]['Nickname'],1);
            $classmate_name = $classmate[0]['Name'];
            $classmate_bio = $classmate[0]['Bio'];

            $no_of_posts = $fetch_operations->fetch_rows_from_table('Posts',array('user_id'),array($classmate_id));
            $class_mate_posts = $fetch_operations->fetch_by_order_from_table('Posts',array('user_id'),array($classmate_id),array('id','user_id','Type','Image_or_Vid','Image_or_Vid_Thumb','Description','Date','mime_type'),"`id` DESC");

            if(empty($classmate_pic)) $post_src = "../../model/files/img/image.jpg";
            else $post_src = "data:image/jpeg;base64,".base64_encode($classmate_pic);
            
        ?>

        <div>
            <div style="margin: 20px 0">
                <div class="row" style="margin-bottom: 20px">
                    <div class="col-xs-3">
                        <img style="display:block;margin:0px auto" class="img-circle placeholder_img" src="<?php echo $post_src?>" height="45" width="45"/>
                    </div>
                    <div class="col-xs-9">
                        <!--<div><?php echo $classmate_nick; ?></div>-->
                        <div class="yb-list">
                            <ul class="col-xs-12">
                                <li><a href="#"><h4><strong><?php echo $no_of_posts; ?></strong></h4>posts</a></li>
                                <li><a href="#"><h4><strong>0</strong></h4>nominations</a></li>
                                <li><a href="#"><h4><strong>0</strong></h4>won</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div>
                    <strong><?php echo $classmate_name?></strong>
                    <p><?php echo $classmate_bio?></p>
                </div>
            </div>


            <div class="yb-list">
                <ul class="nav nav-tabs" role="tablist">
                    <li  class="active"><a href="#profile" data-toggle="tab" role="tab"><i style="font-size:20px;font-weight:600" class="fa-fx pe-7s-id"></i></a></li>
                    <li><a href="#posts" data-toggle="tab" role="tab"><i style="font-size:20px;font-weight:600" class="fa-fx pe-7s-video"></i></a></li>
                </ul>
                
                
                <div class="tab-content segoe text-left" style="margin-top:10px">
                    <!-- 'RegNo','Phone','Bio','DofB','Sex','Nickname','Likes','Dislikes','Favourite_Food','Favourite_Colors','Favourite_Quotes' -->
                    <div class="tab-pane active" id="profile">
                        <div style="margin:20px 0" class="form-group">
                            <label>Registration Number:</label>
                            <div><?php echo $classmate[0]['RegNo']?></div>
                        </div>


                        <div style="margin:20px 0" class="form-group">
                            <label>Phone:</label>
                            <div><?php echo $classmate[0]['Phone']?></div>
                        </div>

                        <div style="margin:20px 0" class="form-group">
                            <label>Date of Birth:</label>
                            <div><?php echo $classmate[0]['DofB']?></div>
                        </div>

                        <div style="margin:20px 0" class="form-group">
                            <label>Sex:</label>
                            <div><?php echo $classmate[0]['Sex']?></div>
                        </div>

                        <div style="margin:20px 0" class="form-group">
                            <label>Nickname:</label>
                            <div><?php echo $classmate[0]['Nickname']?></div>
                        </div>

                        <div style="margin:20px 0" class="form-group">
                            <label>Likes:</label>
                            <div><?php echo $classmate[0]['Likes']?></div>
                        </div>

                        <div style="margin:20px 0" class="form-group">
                            <label>Dislikes:</label>
                            <div><?php echo $classmate[0]['Dislikes']?></div>
                        </div>

                        <div style="margin:20px 0" class="form-group">
                            <label>Favourite Food:</label>
                            <div><?php echo $classmate[0]['Favourite_Food']?></div>
                        </div>

                        <div style="margin:20px 0" class="form-group">
                            <label>Favourite Colors:</label>
                            <div><?php echo $classmate[0]['Favourite_Colors']?></div>
                        </div>

                        <div style="margin:20px 0" class="form-group">
                            <label>Favourite Quotes:</label>
                            <div><?php echo $classmate[0]['Favourite_Quotes']?></div>
                        </div>

                    </div>
                    <div class="tab-pane" id="posts">
                        <div class="row">
                            <?php
                            
                                if(!empty($class_mate_posts)){

                                    foreach($class_mate_posts as $post){

                                        echo '<div style="margin: 10px 0" class="col-xs-6">
                                            <a href="single_post.php?s='.$post['id'].'">';
                                        $blob_image = $post['Image_or_Vid'];
                                        $mime = substr($post['mime_type'],0,strpos($post['mime_type'],'/'));
                                        $likes = $fetch_operations->fetch_rows_from_table('Likes',array('post_id'),array($post['id']));

                                        switch($mime){

                                            case 'image':
                                                $blob_image = $post['Image_or_Vid_Thumb'];
                                                $src = "data:".$post['mime_type'].";base64,".base64_encode($blob_image);
                                                require '../../views/body/image_card.php';
                                            break;

                                            case 'video':
                                                $src = "data:".$post['mime_type'].";base64,".base64_encode($blob_image);
                                                require '../../views/body/video_card.php';
                                            break;

                                            case 'audio':
                                                $src = "../../model/files/img/downloaded (1).jpg";
                                                require '../../views/body/image_card.php';
                                            break;

                                            case 'application':
                                                $src = "../../model/files/img/800859_file_512x512.png";
                                                require '../../views/body/image_card.php';
                                            break;

                                        }

                                        echo '</a></div>';

                                    }

                                }
                                else{
                                    $cmna = explode(' ', $classmate_name);
                                    $heading = 'No Posts Yet';
                                    $body = $cmna[1].' has not posted anything yet';
                                    $per = 40;
                                    require '../../views/body/empty_view.php';
                                }

                            ?>
                        </div>
                    </div>

                </div>
            </div>

        </div>


        
    </div>
    <!-- 

        //yearbook
        //click of notif and posts.
        //fetching mention notif.
        //tagging and sending notif.
        //limit fetch no for home 
        and notif.
        resolve "Add Post"

    -->
    
    
</div>
