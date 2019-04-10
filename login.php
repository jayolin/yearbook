<?php

    session_start();
    if(isset($_SESSION['DIGITRON_2017'])){
		
		header("Location:home");

	}

    require 'controller/create/create_Db.php';
	require 'controller/connectDb/connectDb.php';
	require 'controller/create/create_tables.php';



    require 'controller/classes/operations.php';
	require 'controller/classes/fetch_operations.php';

    $operations = new Operations();
	$fetch_operations = new Fetch();

    if(isset($_POST['reg_no']) && isset($_POST['password'])){

        $reg_no = $_POST['reg_no'];
        $password = $_POST['password'];

        //check our table
        $user = $fetch_operations->fetch_from_table('All_Users',array('RegNo','Password'),array($reg_no,hash('sha512',$password)),array('id'));
        //print_r($user);die();
        if(!empty($user)){
            $_SESSION['DIGITRON_2017'] = $user[0]['id'];
            echo true;
        }
        else{
            //echo 'fuck';die();
            $unn_api_details = $operations->unn_api($reg_no,$password);
            //print_r($unn_api_details);die();

            if($unn_api_details->message == 'success'){
                //reg user
                if($unn_api_details->student->department == 'ELECTRONIC ENGINEERING' && $unn_api_details->student->level == '500 LEVEL'){

                    $student = $unn_api_details->student;

                    $student_name = ucfirst(strtolower($student->surname)).' '.ucfirst(strtolower($student->first_name)).' '.ucfirst(strtolower($student->middle_name));
                    $student_phone = $student->mobile;
                    $student_sex = $student->sex;
                    $student_nick = '@'.strtolower(str_replace(' ','',$student_name));




                    //Name RegNo Password Phone Sex Nickname
                    $user_id = $operations->insert_user('All_Users',array('Name','RegNo','Password','Phone','Sex','Nickname'),
                    array($student_name,$reg_no,hash('sha512',$password),$student_phone,$student_sex,$student_nick));

                    $_SESSION['DIGITRON_2017'] = $user_id;
                    echo true;

                }
                else{
                    echo false;
                }

                
            }
            else{
                echo false;
            }
        }

        die();
    }

    $page_name = 'Sign In';
    require 'views/head/head.html';
    require 'views/head/navbar.php';
?>

<div class="">
    <div class="">
        <div class="">
            <form>
                <div style="display:table;position:absolute;height:100%;width:100%;">
                    <div style="display:table-cell;vertical-align:middle">
                        <div class="text-center col-xs-12 col-xs-offset-0 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">

                            <h2 class="yb-title">YearBook</h2>

                            <p style="color:#a3a3a3"><small>University Of Nigeria | ECE '017</small></p>
                            <div class="form-group col-xs-12">
                                <input name="reg_no" class="form-control" placeholder="Registration Number"/>
                            </div>
                            <div class="form-group col-xs-12">
                                <input type="password" name="password" class="form-control" placeholder="Password"/>
                            </div>
                            <div class="form-group col-xs-12">
                                <a onclick="disableInput(this,true,'Checking...');ajax_search('reg_no='+$('input[name=\'reg_no\']').val()+'&password='+$('input[name=\'password\']').val(),alertUser)" class="btn form-control btn-submit" style="background:cornflowerblue;color:#FFF">Sign In</a>
                            </div>

                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
    
    require 'views/foot/footer.html';
    require 'views/foot/toast.html';
?>

<script>
    function alertUser(msg){

        //alert(msg);
        if(msg == true){
            disableInput($('.btn-submit'),true,'Signing In...');
            window.location.href = 'home';
        }
        else{
            disableInput($('.btn-submit'),false,'Sign In');
            showToast($('.toast'),'User not found!');
        }

    }
</script>