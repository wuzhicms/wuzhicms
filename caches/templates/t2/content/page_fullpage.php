<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0">
    <title><?php if(isset($seo_title)) { ?><?php echo $seo_title;?><?php } else { ?><?php echo $siteconfigs['sitename'];?><?php } ?></title>
    <meta name="description" content="<?php if(isset($seo_title)) { ?><?php echo $seo_title;?><?php } else { ?><?php echo $siteconfigs['sitename'];?><?php } ?>"/>
    <link href="<?php echo R;?>t2/fullpage/css/donghua.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="front_load">
    <div class="loading loading_bg"></div>
    <div class="mx4_imgs loading loading_img">
        <div class="spinner">
            <div class="spinner-container container1">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
                <div class="circle4"></div>
            </div>
            <div class="spinner-container container2">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
                <div class="circle4"></div>
            </div>
            <div class="spinner-container container3">
                <div class="circle1"></div>
                <div class="circle2"></div>
                <div class="circle3"></div>
                <div class="circle4"></div>
            </div>
        </div>
    </div>
</div>

<?php $fullpage = get_cache('fullpage','weixin');?>

<div id="fullscreen" class="main">

    <div id="home" class="section" style="top:0%;">
        <p class="title"><?php echo $fullpage['0']['Title'];?></p>
        <p class="info"><?php echo $fullpage['0']['Description'];?></p>
        <div class="home_img">
            <img class="mz_img meinv1" src="<?php echo $fullpage['0']['PicUrl']['1'];?>" />
            <img class="mz_img meinv2" src="<?php echo $fullpage['0']['PicUrl']['2'];?>" />
        </div>
        <div class="section_child"></div>
    </div>
    <div id="screen" class="section" style="top:100%;">
        <p class="title"><?php echo $fullpage['1']['Title'];?></p>
        <p class="info"><?php echo $fullpage['1']['Description'];?></p>
        <img class="mz_img" src="<?php echo $fullpage['1']['PicUrl']['1'];?>" />
        <div class="section_child"></div>
    </div>
    <div id="cpu" class="section" style="top:200%;">
        <p class="title"><?php echo $fullpage['2']['Title'];?></p>
        <p class="info"><?php echo $fullpage['2']['Description'];?></p>
        <img class="mz_img" src="<?php echo $fullpage['2']['PicUrl']['1'];?>" />
        <div class="section_child"></div>
    </div>
    <div id="dsds" class="section" style="top:300%;">
        <p class="title"><?php echo $fullpage['3']['Title'];?></p>
        <p class="info"><?php echo $fullpage['3']['Description'];?></p>
        <img class="mz_img p3_1" src="<?php echo $fullpage['3']['PicUrl']['1'];?>" />
        <img class="mz_img p3_2" src="<?php echo $fullpage['3']['PicUrl']['2'];?>" />
        <img class="mz_img p3_3" src="<?php echo $fullpage['3']['PicUrl']['3'];?>" />
        <div class="section_child"></div>
    </div>


    <div id="battery" class="section" style="top:400%;">
        <div class="battery_text">
            <p class="title"><?php echo $fullpage['4']['Title'];?></p>
            <p class="info"><?php echo $fullpage['4']['Description'];?></p>
        </div>
        <img class="mz_img phone1" src="<?php echo $fullpage['4']['PicUrl']['1'];?>" />
        <img class="mz_img phone2" src="<?php echo $fullpage['4']['PicUrl']['2'];?>" />
        <div class="section_child"></div>
    </div>

    <div id="color" class="section" style="top:500%;">
        <p class="title"><?php echo $fullpage['5']['Title'];?></p>
        <p class="info"><?php echo $fullpage['5']['Description'];?></p>
        <div class="color_img">
            <img class="mz_img" src="<?php echo $fullpage['5']['PicUrl']['1'];?>" />
            <img class="mz_img" src="<?php echo $fullpage['5']['PicUrl']['2'];?>" />

        </div>
        <div class="section_child"></div>
    </div>

</div>

<div class="fullpage_option">
    <div class="next_screen on"><img src="<?php echo R;?>t2/fullpage/img/arrow.png" /></div>
    <div class="mx4_music"><img class="music_active" src="<?php echo R;?>t2/fullpage/img/music.png" /></div>
    <div style="display:none;"><audio autoplay src="<?php echo R;?>t2/fullpage/071.mp3"></audio></div>
</div>

</body>


<script type="text/javascript" src="<?php echo R;?>js/jquery.min.js"></script>
<script type="text/javascript">
    function fullscreen(a){this.touchStartY=0;this.callback=a;this.win_H=document.body.clientHeight;this.now_H=0;this.isscrolling=true;this.now_screen=1}fullscreen.prototype.setscreen=function(a){this.now_screen=a;this.now_H=0};fullscreen.prototype.initialize=function(){this.addTouchHandler()};fullscreen.prototype.addTouchHandler=function(){var a=this;$(".section_child").on("touchstart",function(){a.touchStartHandler(arguments)});$(".section_child").on("touchmove",function(){a.touchMoveHandler(arguments)})};fullscreen.prototype.getEventsPage=function(b){var a=new Array();if(window.navigator.msPointerEnabled){a["y"]=b.pageY}else{if(b.originalEvent){a["y"]=b.originalEvent.touches[0].pageY}else{a["y"]=b.touches[0].pageY}}return a};fullscreen.prototype.touchStartHandler=function(b){var c=b[0];var a=this.getEventsPage(c);this.touchStartY=a["y"];a=null};fullscreen.prototype.touchMoveHandler=function(c){var f=c[0];f.preventDefault();var b=this.getEventsPage(f);touchEndY=b["y"];var g=document.body.clientHeight/100*1;var d=navigator.userAgent.match(/(iPhone|iPod|iPad)/);if(d){g=document.body.clientHeight/100*5}if(Math.abs(this.touchStartY-touchEndY)>g){if(this.touchStartY>touchEndY){var a=$("#fullscreen .section").length;if(this.now_screen==a){return false}this.changeScreen("down")}else{if(this.now_screen==1){return false}this.changeScreen("up")}this.touchStartY=touchEndY}};fullscreen.prototype.changeScreen=function(f){if(this.isscrolling){var d=this;var e=setTimeout(function(){d.isscrolling=true},1000);var a=$("#fullscreen .section").length;var b=$(".section").last().height();if(f=="down"){var c=this.now_screen+1==a?-b:-$(window).height();this.now_H+=c}else{if(f=="up"){var c=this.now_screen==a?b:$(window).height();this.now_H+=c}}this.now_screen+=f=="down"?1:-1;var g=navigator.userAgent.match(/(iPhone|iPod|iPad)/);if(g){$("#fullscreen").css({"-webkit-transition":"all 0.3s linear","-webkit-transform":"matrix(1, 0, 0, 1, 0, "+this.now_H+")"})}else{$("#fullscreen").css({"-webkit-transform":"translate3d(0px, "+this.now_H+"px, 0px)","-webkit-transform":"translate3d(0px, "+this.now_H+"px, 0px)"})}this.callback(this.now_screen)}this.isscrolling=false};
</script>
<script type="text/javascript">
    window.onload=function(){$(".front_load").hide();$("#home .home_img img").addClass("on")};~function(){var c=0;var i=true;var f=new fullscreen(function(m){if(i){var n=document.getElementsByTagName("audio")[0];n.addEventListener("ended",function(){this.currentTime=0;$(".mx4_music img").removeClass("music_active");$(".mx4_music img").attr("src","<?php echo R;?>t2/fullpage/img/music-stop.png")},false);document.getElementsByTagName("audio")[0].play();i=false;$(".mx4_music").on("touchstart",function(){var o=$(this).children("img");if(o.hasClass("music_active")){$("audio")[0].pause();o.attr("src","<?php echo R;?>t2/fullpage/img/music-stop.png");o.removeClass("music_active")}else{o.addClass("music_active");$("audio")[0].play();o.attr("src","<?php echo R;?>t2/fullpage/img/music.png")}})}$(".next_screen").addClass("on");switch(m){case 2:$("#screen .mz_img").addClass("on");$("#screen p").addClass("on");break;case 3:$("#cpu p").addClass("on");break;case 4:$("#dsds .mz_img").addClass("on");break;case 5:$("#battery .mz_img")/*.addClass("on");break;case 6:$("#coms p").addClass("on");break;case 7:$("#camera .mz_img")*/.addClass("on");$("#camera p").addClass("on");break;case 6:$("#color .mz_img")/*.addClass("on");break;case 7:$(".weixin_number")*/.addClass("on");$(".next_screen").removeClass("on");break}});f.initialize();}()
</script>

</html>