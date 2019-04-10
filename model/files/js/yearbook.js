


(function ($, undefined) {
    $.fn.getCursorPosition = function() {
        var el = $(this).get(0);
        var pos = 0;
        if('selectionStart' in el) {
            pos = el.selectionStart;
        } else if('selection' in document) {
            el.focus();
            var Sel = document.selection.createRange();
            var SelLength = document.selection.createRange().text.length;
            Sel.moveStart('character', -el.value.length);
            pos = Sel.text.length - SelLength;
        }
        return pos;
    }
})(jQuery);






function ajax_search(data,callback){

    //alert(data);
    $.ajax({
                
        url:'',
        type:'POST',
        data: data,
        success:function(found){
            
            callback(found);
            
        }

    });

}


function resize_heart(heart){
    
    $(heart).each(function(){
        var mediaHeight = $(this).parent().prev().height();
        var bottom = mediaHeight/3;
        var fontSize = mediaHeight/3;
        //alert(bottom);
    $(this).css({'bottom':bottom+'px','font-size':fontSize+'px'});
        //alert(mediaHeight);
    });
    

}


$.fn.isInViewport = function(){

    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();

    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + window.innerHeight;

    //alert(viewportTop+'/'+viewportBottom);
    return elementBottom < viewportBottom && elementTop > viewportTop;

}


function ajax_modify(postId,postBool){

    //alert(postBool);
    $.ajax({
                
        url:'',
        type:'POST',
        data: 'post_id='+postId+'&post_bool='+postBool,
        success:function(f){
            
            //alert(f);
            
        }

    });

}

function disableInput(input,load,text){
    var selectedInput = $(input);
    if(load){
        //alert();
        selectedInput.attr('disabled',true);
        selectedInput.html('<i class="fa fa-spinner fa-spin"></i> &nbsp;'+text);
    }
    else{
        selectedInput.attr('disabled',false);
        selectedInput.html(text);
    }
}


function showToast(ctx,msg){
    //alert();
    $(ctx).html(msg).fadeIn(400).delay(3000).fadeOut(400);

}


function likePost(postId,postBool){

    ephemeral(postId,postBool);
    ajax_modify(postId,postBool);

}

function ephemeral(postId,postBool){

    //alert(postBool);
    var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
		
    if(postBool == 1){
        $('span[post="'+postId+'"]').html(parseInt($('span[post="'+postId+'"]').html()) - 1);
        $('i[post="'+postId+'"]').css({'font-weight':'light','color':'#333'});
        $('img[post="'+postId+'"], video[post="'+postId+'"]').attr('postBool',0);
        $('i.pe-7s-like[post="'+postId+'"]').attr('postBool',0);
    }
    else{
        $('span[post="'+postId+'"]').html(parseInt($('span[post="'+postId+'"]').html()) + 1);
        $('i[post="'+postId+'"]').css({'font-weight':'bold','color':'cornflowerblue'});
        $('img[post="'+postId+'"], video[post="'+postId+'"]').attr('postBool',1);
        $('i.pe-7s-like[post="'+postId+'"]').attr('postBool',1);

        $('.heart[post="'+postId+'"]').addClass('animated zoomIn').removeClass('hidden');
        $('.heart[post="'+postId+'"]').one(animationEnd,function(){

            //var timeout = setInterval(function(){ 
                $('.heart[post="'+postId+'"]').removeClass('animated zoomIn').addClass('animated fadeOut');
                $('.heart[post="'+postId+'"]').one(animationEnd,function(){

                    $('.heart[post="'+postId+'"]').removeClass('animated fadeOut').addClass('hidden');
                    //clearTimeout(timeout);

                });
            //},1000);
			//$(this).removeClass('hidden animated zoomIn');
		});
    }
    

}

function pausePlay(postId){

    var video = $('video[post="'+postId+'"], audio[post="'+postId+'"]');
    if(video.get(0).paused){
        video.get(0).play();
        //alert('played');
    }
    else{
        video.get(0).pause();
        //alert('paused');
    }

}
