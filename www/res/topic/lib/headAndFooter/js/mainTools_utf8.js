/* JavaScript Document
 * Author Aber
 * Jun 2013
 */

$(function(){
	var $loginBTN = $("#signin"); //顶部登录链接
	var $LoginBox = $("#ZGW_Login_Box"); //登录窗口
	var $topBTN = $(".topButton");	//顶部工具栏鼠标经过样式
    var loginbox_timeout;

	$loginBTN.bind("mouseover",function(e){
        showZgwUserLoginBox(e);
    });
	
	$loginBTN.bind("mouseout",function(){
        loginbox_timeout = setTimeout(hideZgwUserLoginBox,300);
    });

	$LoginBox.bind("mouseover",function(){
		clearTimeout(loginbox_timeout);
    });	
	
	$(document).bind("click",function(e){
	if($("#ZGW_Login_Box").css("display")=="block"){
		var target = $(e.target);
		if(target.closest("#ZGW_Login_Box").length==0 && target.attr("showlogin")!="true"){
			hideZgwUserLoginBox();
		}
	}})
	
	$(document).bind("keyup",function(e){
	if(e.keyCode==13 && $("#ZGW_Login_Box").css("display")=="block"){
		//$("#zgw_login_btn").trigger("click");
		zgwUserLogin();
	}})
		
	$loginBTN.attr("href","javascript:void(0)");
	
	$topBTN.hover(function(){
        $(this).children(".ABwrap").toggle(100);
    });

	//if(getCookie("ZGW_USER_NAME")==null){
	$.ajax({
		type:"get",
		async:false,
		cache:false,
		url:"http://user.zz/usercenter/Json.ashx?a=2",
		dataType:"jsonp",
		jsonp:"callbackparam",
		jsonpCallback:"success_loginfo",
		success:function(json){
            showTips("请使用政工网通行证登录网站");
			//alert(json);
		},
		error:function(){
			showTips("连接验证服务器失败。");
		}
	});
	//}

	
})


//$(document).ready(function(e) {
/*  
	var loginbox_timeout;

	$topBTN.hover(function(){
        $(this).children(".ABwrap").toggle(100);
    });
	

	$loginBTN.attr("href","javascript:void(0)");


	$loginBTN.mouseover(function(){
        $LoginBox.show(100);
    });
	
	
	$loginBTN.mouseout(function(){
        loginbox_timeout = setTimeout(function(){$LoginBox.hide(100)},300);
    });

	$LoginBox.mouseover(function(){
		clearTimeout(loginbox_timeout);
        //$(this).show();
    });
	
	$(document).click(function(){
		$LoginBox.click(function(){
			alert("loginbox clicked!");
			return;
		});
		alert("loginbox to be hide!");
		$LoginBox.hide(100);
	});
	*/
	
	/* 
	var $SB = $(".SB_warp");					//侧边按钮
	var $SBTN = $(".SB_nav_btn");				//侧边导航按钮
	var $BTop = $(".backTop");					//回到顶部按钮
	
	//alert($SB.val());
	var $MTop = 700;							//滚动窗口大于 $MTop 显示侧边按钮
	
	$SB.fadeTo(0,0.0);
	
	$(window).scroll(function(){				//滚动窗口显示隐藏侧边按钮动画
		if ($SB.val()){
		if ($SB.offset().top >= $MTop){
			$SB.fadeTo(100,1.0);
		}else{
			$SB.fadeTo(100,0.0);
		};
		}
	});
	
	$SBTN.click(function(){
		$(".SB_nav").children("ul").slideToggle();		//伸缩动画
	});
		
	$BTop.click(function(){
		$("html, body").animate({scrollTop:0},120);
	});
		
	// 样式调整
	var $LSubmit = $(".loginframe_btn, .backTop, .SB_nav_btn");			//用户登录按钮
	
	$LSubmit.hover(function(e){
		$(this).css("background-position","bottom");
		},function(e){
		$(this).css("background-position","top");
	});
	*/
	

//});