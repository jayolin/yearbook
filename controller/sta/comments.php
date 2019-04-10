
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
    
    
    $page_name = 'Comments';
    $hide_more = true;

    require '../../views/head/head_sta.html';
    require '../../views/head/navbar.php';
    

    if(isset($_GET['s'])){
        $post_id = $_GET['s'];
        $post = $fetch_operations->fetch_from_table('Posts',array('id'),array($post_id),array('user_id','Description','Date'));
        $comments = $fetch_operations->fetch_by_order_from_table('Comments',array('post_id'),array($post_id),array('user_id','comment','Date')," `id` ASC");
    
    }
    else{
        header("Location: ../../home");
    }

?>

<div style="margin-top:70px">
    <div class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
        <?php

            $poster= $fetch_operations->fetch_from_table('All_Users',array('id'),array($post[0]['user_id']),array('Nickname','Display_Pic_Thumb'));
            $poster_pic = $poster[0]['Display_Pic_Thumb'];
            $poster_name = substr($poster[0]['Nickname'],1);
            $post_desc = $post[0]['Description'];
            $post_time = $operations->get_post_time($post[0]['Date']);

            if(empty($poster_pic)) $post_src = "../../model/files/img/image.jpg";
            else $post_src = "data:image/jpeg;base64,".base64_encode($poster_pic);

            require '../../views/body/comment_row.php';
            
        ?>


        <div id="comments-div" style="margin-top:70px;padding-bottom:70px;overflow-x:hidden;overflow-y:auto;height:50%">

            <?php

                require 'inner_comments.php';

            ?>
            

        </div>
    </div>
    
    
</div>


<!--<form class="comment-form" method="POST" action="">-->
    
    
    <!--<input value="<?php echo $post_id?>" name="post_id" type="hidden"/>-->
    <?php
        require '../../views/foot/comment_bar.html';
        require '../../views/foot/toast.html';
    ?>

    

<!--</form>-->

<script>

    function postStuff(){

        showToast($('.toast'),'Posting Comment...');
        var postId = <?php echo $post_id?>;
        var commentBody = $('input[name="comment_body"]').val();
        ajax_search('post_id='+postId+'&comment_body='+commentBody,populateCommentDiv);

    }


    function populateCommentDiv(result){

        
        $('#comments-div').html(result);
        $('.toast').html('Comment Posted!');
        $('input[name="comment_body"]').val('');

    }

</script>

<script>
    $("input[name='comment_body']").on('keyup',function(){
        var currIndex = $(this).getCursorPosition();
        var valueOfInput = $(this).val();
        var neededSubstr = valueOfInput.substr(0,currIndex);

        var words = neededSubstr.split(' ');
        var currWord = words[words.length - 1];
        var currWordLength = currWord.length;

        if(currWord.includes('@')){
            //search for tag...
            ajax_search('tag='+currWord+'&curr_index='+currIndex+'&curr_word_length='+currWordLength+'&dir=../../',populateTagDiv)
            //alert(currWord);
        }
        else{

            $('.dropup').removeClass("open");
            //$('.tag-div').addClass('hidden');
        }
        
        
    })


    function replaceInInput(tag,currIndex,currWordLength){

        var neededSubstr = $("input[name='comment_body']").val().substr(0,currIndex);
        var unneededSubstr = $("input[name='comment_body']").val().substr(currIndex);
        

        neededSubstr = neededSubstr.substr(0,neededSubstr.length - currWordLength) + ' ' +tag+' ';
        //alert(neededSubstr.length);
        $("input[name='comment_body']").val(neededSubstr + unneededSubstr);
        $('.dropup').removeClass("open");
        //$('.tag-div').addClass('hidden');
        $("input[name='comment_body']").focus();

    }

    function populateTagDiv(result){

        
        $('.tag-div').html(result);
        if(result.trim() != '') $('.dropup').addClass("open");
        else $('.dropup').removeClass("open");

    }
</script>
<!--

<script>
      $(function() {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: '../../plugins/emoji-picker-master/lib/img/',
          popupButtonClasses: 'fa fa-smile-o'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();
      });
    </script>-->