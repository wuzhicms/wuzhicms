$(function(){
    
    $('.commentBtn').click(function(){
        $('body,html').animate({scrollTop: $('#comments').offset().top}, 500);
        return false;
    });
    $('.fontBig').click(function(){
        $('.detail').find('p').css({fontSize:'16px'});
    });
    $('.fontSmall').click(function(){
        $('.detail').find('p').css({fontSize:'14px'});
    });
    
    $('.printPage').click(function(){ 
        $('.mainCon').jqprint();
});
    
});
