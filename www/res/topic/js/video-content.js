$(function(){
 
    //热播列表位脚本
    $('.media').hover(function(){
       $(this).stop().animate({boxShadow:'0 3px 9px rgba(0,0,0,0.5)',backgroundColor:'rgba(255,255,255,1)'}); 
    },function(){
        $(this).stop().animate({boxShadow:'0 0 0 rgba(0,0,0,0)',backgroundColor:'rgba(214, 224, 226, 0.2)'}); 
    });
});
