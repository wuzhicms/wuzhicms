/*鼠标悬停 js*/
$(document).ready(function(){
/*    $("span.div").hide();
    $(".sis-li li").hover(function(){
        $("span.div",this).slideToggle(500);
    });*/
    /*显示标题*/
    $(".imgtext").hide();
    $(".pic_Control").hover(function(){
        $(".imgtext",this).slideToggle(300);
    });
    /*显示收藏ico*/
    $(".shoucang_ico").hide();
    $(".pic_Control_g").hover(function () {
        $(".shoucang_ico", this).slideToggle(300);
    });

    $(".imgtext").hide();
    $(".pic_Control_g").hover(function () {
        $(".imgtext", this).slideToggle(300);
    });

});


var current_slide = 0;
$(function(){
    $('#myCarousel').on('slid.bs.carousel', function () {
        $('[id^=carousel-selector-]').removeClass('selected');
        $("#carousel-selector-"+current_slide).addClass('selected');
        $(".pic_items").addClass('hide');
        $("#itemid"+current_slide).removeClass('hide');
    });
});
// 循环轮播到上一个项目
$("#prev-slide").click(function(){
    $("#myCarousel").carousel('prev');
    if(current_slide==0) {
        current_slide = photo_totals-1;
    } else {
        current_slide--;
    }
});
// 循环轮播到下一个项目
$("#next-slide").click(function(){
    $("#myCarousel").carousel('next');
    if(current_slide==photo_totals-1) {
        current_slide = 0;
    } else {
        current_slide++;
    }
});
$('#identifier').carousel('prev')

$('[id^=carousel-selector-]').click( function(){
    var id_selector = $(this).attr("id");

    var id = id_selector.substr(id_selector.length -1);
    id = parseInt(id);
    current_slide = id;
    $('#myCarousel').carousel(id);

    $('[id^=carousel-selector-]').removeClass('selected');
    $(this).addClass('selected');

});





