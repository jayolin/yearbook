<?php
    
    session_start();
    require 'controller/create/create_Db.php';
	require 'controller/connectDb/connectDb.php';
	require 'controller/create/create_tables.php';


    require 'controller/classes/operations.php';
	require 'controller/classes/fetch_operations.php';

    $operations = new Operations();
	$fetch_operations = new Fetch();

    require 'controller/profile/issets.php';
    require 'controller/profile/dashboard_excerpts.php';
    
    $allowed_pages = array('home','yearbook','post','notifications','profile');
    if(isset($_GET['s'])){
        if(in_array($_GET['s'],$allowed_pages)) $page_name = ucfirst($_GET['s']);
        else $page_name = 'Home';
    }
    require 'views/head/head.html';
    require 'views/head/navbar.php';
    

?>

<div style="margin-top:70px">
    <?php
		
        if(isset($_GET['s'])){
            $allowed_pages = array('home','yearbook','post','notifications','profile');
            $s = $_GET['s'];
            if(in_array($s,$allowed_pages)){
                require 'controller/profile/'.$s.'.php';
            }
            elseif($s == 'logout'){

                unset($_SESSION['DIGITRON_2017']);
                header('Location:login.php');
                die();

            }
            else{
                require 'controller/profile/home.php';
            }
            
        }
        else{
            require 'controller/profile/home.php';
        }

    ?>
</div>

<?php
    require 'views/foot/links.php';
    require 'views/foot/toast.html';

    if(isset($_SESSION['changes_made'])){
        $changes = $_SESSION['changes_made'];
        echo '
            <script>showToast($(".toast"),"'.$changes.'")</script>
        ';
        unset($_SESSION['changes_made']);
    }
?>

<script type="text/javascript">
    $(document).ready(function(){
        $('.lower-links ul li a').each(function(index){
            var windowLocation = window.location.toString();
            //alert(this.href.trim());
            if(windowLocation.includes(this.href.trim().toString()) /*== window.location*/){
                //alert();
                //alert($(this).attr('href'));
                $(this).find('i').css({'font-weight':'bold','color':'cornflowerblue'});

            }
        });
    });
</script>


<script>
    offset = 5;
    //alert(offset);
    $(window).bind('scroll',function(){
        //alert();
        if($(window).scrollTop() >= $('#flux').offset().top + $('#flux').outerHeight() - window.innerHeight){
            
            //alert();
            var table = '<?php echo $flux_table ?>';
            $('#flux .loader').css('opacity',1);
            ajax_search("table="+table+"&offset="+offset,appendToDiv);

        }
        //alert($(window).scrollTop()+'/'+($('#flux').outerHeight()));
    });


    function appendToDiv(result){

        //alert(offset);
        var $response = $(result);
        var content = $response.filter("#content").html();

        $('#flux .loader').css('opacity',0);
        $('#inner_flux').append(content);

        offset = parseInt($response.filter("#offset").html()) + offset;
        //resize_heart('.heart');

    }
</script>

