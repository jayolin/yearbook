<?php

    ini_set('post_max_size','30M');
    ini_set('upload_max_filesize','64M');

    // so, i changed the max_allowed_packets on the ny.ini file

?>
<div style="padding-bottom:70px" class="col-xs-12 col-xs-offset-0 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">

    <form id="thisForm" style="margin-top:30px" action="home" method="POST" enctype="multipart/form-data">

        <input style="margin-bottom:0;display:none" id="upload_form"  type="file" class="" name="post_photo" />
        <input type="hidden" class="" name="post_mimetype" />
        
        <div class="col-xs-12">
            
            <div class="form-group col-xs-10">
                <textarea  name="post_caption" rows="5" class="form-control cus-inp">Add Caption...</textarea>
            </div>
            <div class="form-group col-xs-2">
                <div id="up">
                    <img style="cursor:pointer" onclick="$('#upload_form').click();$('.create-img').remove();" title="Upload File" class="placeholder_img img-circle" style="" src="model/files/img/111upload.png" height="50" width="50"/>
                    <br/><br/>
                </div>
                <div class="create-img">
                    <img style="cursor:pointer" onclick="$('.create-img').removeClass('hidden');$('#up').hide();$('input[name=\'post_photo\']').val('');" title="Create Image" class="img-circle" style="" src="model/files/img/image.jpg" height="50" width="50"/>
                </div>
            </div>

        </div>
        <div class="col-xs-12 dropup" style="margin-top:30px">

            <i class="toggle-drop dropdown-toggle hidden" data-toggle="dropdown"></i>
            <div class="dropdown-menu tag-div col-xs-12 col-sm-10 col-md-8 col-lg-6">
            </div>

        </div>



        <div class="hidden create-img col-xs-12">
            
            <div class="form-group">
                <textarea  name="text_on_img" rows="1" class="form-control cus-inp">Text...</textarea>
            </div>

            <div class="form-group">
                <select name="weight" class="form-control cus-inp">
                    <option value="Thin">Weight</option>
                    <option value="Hairline">Extra-Light</option>
                    <option value="Light">Light</option>
                    <option value="Medium">Medium</option>
                    <option value="Bold">Bold</option>
                </select>
            </div>

            <div class="" style="margin-top:50px">
                <div class="col-xs-6">
                    <input class="hidden" name="bg_color" type="color" value="#FFFFFF"/>
                    <div style="background:#FFFFFF;border:1px solid #a3a3a3;height:20px;width:20px;display:inline;padding:5px 10px;color:#FFF;cursor:pointer" class="color_div">O</div><div style="margin-top:-50px;display:inline"> Background</div>
                </div>

                <div class="col-xs-6">
                    <input class="hidden" name="color" type="color" value="#000000"/>
                    <div style="background:#000000;border:1px solid #a3a3a3;height:20px;width:20px;display:inline;padding:5px 10px;color:#000;cursor:pointer" class="color_div">O</div> <span>Color</span>
                </div>
            </div>

        </div>




        <div class="col-xs-12" style="margin-top:30px">
            <div class="">
                <button class="btn form-control btn-submit" style="background:cornflowerblue;color:#FFF">Share</button>
            </div>
        </div>
    </form>
    
</div>





<script>
    $("textarea[name='post_caption']").on('keyup',function(){
        var currIndex = $(this).getCursorPosition();
        var valueOfInput = $(this).val();
        var neededSubstr = valueOfInput.substr(0,currIndex);

        var words = neededSubstr.split(' ');
        var currWord = words[words.length - 1];
        var currWordLength = currWord.length;

        if(currWord.includes('@')){
            //search for tag...
            ajax_search('tag='+currWord+'&curr_index='+currIndex+'&curr_word_length='+currWordLength+'&dir=',populateTagDiv)
            //alert(currWord);
        }
        else{
            //$('.tag-div').addClass('hidden');
            $('.dropup').removeClass("open");
        }
        
        
    })


    function replaceInInput(tag,currIndex,currWordLength){

        var neededSubstr = $("textarea[name='post_caption']").val().substr(0,currIndex);
        var unneededSubstr = $("textarea[name='post_caption']").val().substr(currIndex);
        

        neededSubstr = neededSubstr.substr(0,neededSubstr.length - currWordLength) + ' ' +tag+' ';
        //alert(neededSubstr.length);
        $("textarea[name='post_caption']").val(neededSubstr + unneededSubstr);
        $('.dropup').removeClass("open");
        //$('.tag-div').addClass('hidden');
        $("textarea[name='post_caption']").focus();

    }

    function populateTagDiv(result){

        
        $('.tag-div').html(result);
        if(result.trim() != '') $('.dropup').addClass("open");
        else $('.dropup').removeClass("open");
        //$('.tag-div').removeClass('hidden');
        //alert(result);
    }
</script>





<script>

    $('#upload_form').on( "change", function(event) {
        
        if($(this).val() == ''){
            $('.placeholder_img').replaceWith($('<img style="cursor:pointer" onclick="$(\'#upload_form\').click()" class="placeholder_img" style="" src="model/files/img/111upload.png" height="50" width="50"/>'));
            showToast($('.toast'),'Please choose file!');
        }
        else{
            var _file = document.getElementById('upload_form');

            if(!window.File && window.FileReader && window.FileList && window.Blob){ //if browser doesn't supports File API
                error.push("Your browser does not support new File API! Please upgrade."); //push error text
            }else{
            //
                    //enable submit button once ajax is done
                    //alert(res+offi+'.jpg');
                var reader = new FileReader();
                if(typeof FileReader !== undefined){

                    //check for allowable mimes
                    var size = _file.files[0].size;
                    if(size<= 20480000){//less than 50MB
                        reader.readAsDataURL(_file.files[0]);
                    }
                    else{
                        //toast
                        $('input[name="post_photo"]').val('');
                        showToast($('.toast'),'File too large!');
                    }

                }
                //
                reader.onloadend = function(e){
                    //alert(e.target.result);

                    var mimeType = e.target.result.split(",")[0].split(":")[1].split(";")[0];
                    
                    switch(mimeType.substr(0,mimeType.indexOf('/'))){

                        case 'image':
                            $('.placeholder_img').replaceWith($('<img style="cursor:pointer" onclick="$(\'#upload_form\').click()" class="placeholder_img" style="" src="'+e.target.result+'" height="50" width="50"/>'));
                            $('input[name="post_mimetype"]').val(mimeType);
                        break;

                        case 'video':
                            $('.placeholder_img').replaceWith($('<video style="cursor:pointer" onclick="$(\'#upload_form\').click()" class="placeholder_img" style="" src="'+e.target.result+'" height="50" width="50"/>'));
                            $('input[name="post_mimetype"]').val(mimeType);
                        break;

                        case 'audio':
                            $('.placeholder_img').replaceWith($('<img style="cursor:pointer" onclick="$(\'#upload_form\').click()" class="placeholder_img" style="" src="model/files/img/1454055343_icon-headphone.png" height="50" width="50"/>'));
                            $('input[name="post_mimetype"]').val(mimeType);
                        break;

                        
                        // case 'application':

                        //     if(mimeType.split('/')[1] == 'pdf'){
                        //         $('.placeholder_img').replaceWith($('<img style="cursor:pointer" onclick="$(\'#upload_form\').click()" class="placeholder_img" style="" src="model/files/img/800859_file_512x512.png" height="50" width="50"/>'));
                        //         $('input[name="post_mimetype"]').val(mimeType);
                        //     }
                        //     else{
                        //         $('input[name="post_photo"]').val('');
                        //         //remove file
                        //         showToast($('.toast'),'Unsupported!');
                        //         //show toast
                        //     }
                        //     //document of some
                        // break;

                        default:
                            $('input[name="post_photo"]').val('');
                            //remove file
                            showToast($('.toast'),'Unsupported!');
                            //show toast
                        break;

                    }
                }
                    
                            
                        
            }
        }
                    
    });
</script>

<script>
    
    $(document).ready(function(){
        $('#upload_form').click();
    });
    

</script>

<script>

    $('.color_div').click(function(){

        $(this).prev().click();

    });

    $('input[type="color"]').on('change',function(){

        var color = $(this).val();
        $(this).next().css({'background':""+color+"",'color':""+color+""});

    })

</script>