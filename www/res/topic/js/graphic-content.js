$(function(){
  
    //推荐内容列表位脚本
    $('.media').hover(function(){
       $(this).stop().animate({boxShadow:'0 3px 9px rgba(0,0,0,0.5)'}); 
    },function(){
        $(this).stop().animate({boxShadow:'0 0 0 rgba(0,0,0,0)'}); 
    });
});
