/* JavaScript Document
 * Author Aber
 * Sep 2013
 */
 
document.write('<div class="Aberfooter">');
/*document.write('<div class="searchBar">');
document.write('<div class="ft_warp">');
document.write('<div class="searchframe">');
document.write('<form name="ZGW_Search" action="http://search.zz/outline" method="post" target="_blank"><input type="hidden" name="channelid" value="12727">');
document.write('<div class="search_ipt_warp fltlft">');
document.write('<input class="search_ipt" name="searchword" maxLength="80" placeholder="请输入您要搜索的内容" />');
document.write('</div>');
document.write('<input type="submit" class="search_submit fltrt" value="搜索" />');
document.write('</form>');
document.write('</div>');
document.write('<div class="clearfloat"></div>');
document.write('</div>');
document.write('</div>');*/
document.write('<div class="footerNav">');
document.write('<div class="ft_warp">');
document.write('<div class="blacklogo"></div>');
document.write('</div>');
document.write('</div>');
document.write('<div class="copyrightBar">');
document.write('<div class="ft_warp">');
document.write('<div class="copyright"><span class="copyright_icon">&copy; </span> 2018 中央军委机关事务管理总局</div>');
document.write('<div class="bottomlink">');
document.write('<ul>');
/*document.write('<li><a href="#" onclick="this.style.behavior=&quot;url(#default#homepage)&quot;;this.setHomePage(&quot;http://www.zz&quot;)" target="_self">设为首页</a>|</li>');
document.write('<li><a href="javascript:window.external.addFavorite(&quot;http://www.zz&quot;,&quot;全军政工网&quot;);" target="_self">加入收藏</a>|</li>');*/
document.write('<li><a href="http://www.zz/map/index.html">部门概况</a>|</li>');
document.write('<li><a href="http://www.zz/map/index.html">联系我们</a>|</li>');
document.write('<li><a href="http://ejb.zz/admin$/adminlogin.aspx">隐私政策</a></li>');
//document.write('<li>推荐使用<a href="http://www.zz/download/article/2010/05/18/10942.html">IE8.0</a>，<a href="http://www.zz/download/article/2013/10/24/11207.html">Flash Player 11.0</a>以上版本浏览本站</li>');
document.write('</ul>');
document.write('</div>');
document.write('<div class="clearfloat"></div>');
document.write('</div>');
document.write('</div>');
document.write('</div>');

//(function(){try{var userAgent=navigator.userAgent.toLowerCase();var env=null;var ver=0;env=userAgent.match(/msie ([\d.]+)/);ver=env?parseInt(env[1],10):0;if(ver==6){try{document.execCommand("BackgroundImageCache",false,true);}catch(e){}}}catch(e){}})();

var ZGW_USER;


/*
function setCookie(name,value)//两个参数，一个是cookie的名子，一个是值 
{ 
//var Days = 30; //此 cookie 将被保存 30 天 
//var exp = new Date(); //new Date("December 31, 9998"); 
//exp.setTime(exp.getTime() + Days*24*60*60*1000); 
//document.cookie = name + "="+ value + ";expires=" + exp.toGMTString();
document.cookie = name + "="+ value + ";path=/";
} 
function getCookie(name)//取cookies函数 
{ 
var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)")); 
if(arr != null) return arr[2]; return null; 
} 
function delCookie(name)//删除cookie 
{ 
var exp = new Date(); 
exp.setTime(exp.getTime() - 1); 
var cval=getCookie(name); 
if(cval!=null) document.cookie= name + "="+cval+";expires="+exp.toGMTString(); 
}
*/

function zgwUserLogin(){
	var txt_username = $("#js_loginframe_username");
	var txt_password = $("#js_loginframe_password");
	var autologin = $("#js_loginframe_autologin").attr("checked")?1:0;
	
	txt_username.removeClass("redborder");
	txt_password.removeClass("redborder");
	
	if(txt_username.val()==""){
		showTips("请输入用户名。","#F00");
		txt_username.addClass("redborder");
		txt_username.focus();
		return;
	}
	if(txt_password.val()==""){
		showTips("请输入密码。","#F00");
		txt_password.addClass("redborder");
		txt_password.focus();
		return;
	}

	$("#zgw_login_btn").attr("disabled",true);
	$("#zgw_login_btn").attr("value","正在登录...");
	
	var uname = $.trim(txt_username.val());
	var pwd = txt_password.val();
	
	//Ajax登录验证
	$.ajax({
		type:"get",
		async:false,
		cache:false,
		url:"http://user.zz/usercenter/Json.ashx?a=1&u="+escape(uname)+"&p="+escape(pwd)+"&k="+autologin,
		dataType:"jsonp",
		jsonp:"callbackparam",
		jsonpCallback:"success_login",
		success:function(json){
			//alert(json);
		},
		error:function(){
			showTips("连接验证服务器失败。");
		}
	});
	
}

function zgwUserLogout(){
	//清空session、cookie
	$.ajax({
		type:"get",
		async:false,
		cache:false,
		url:"http://user.zz/usercenter/Json.ashx?a=0",
		dataType:"jsonp",
		jsonp:"callbackparam",
		jsonpCallback:"success_logout",
		success:function(json){
		},
		error:function(){
			showTips("连接验证服务器失败。");
		}
	});
}


function success_login(json){
  ZGW_USER = json;
  if(json.status == 1){
	$("#userLoginBefore").hide();
	$("#userLoginAfter").show();
	$("#navUserName").html(json.username);
	
	//setCookie("ZGW_USER_NAME",json.username);	//设置cookie
	
  	if(typeof(ZGW_USER_Callback)=="function"){
	  ZGW_USER_Callback(1);
  	}
  }else{
	  showTips("用户名或密码错误。","#F00");
	  $("#js_loginframe_password").val("");
	  tobeLogin();
  }
}

function success_logout(json){
  ZGW_USER = json;
  if(json.status == 0){
	showTips("请使用政工网通行证登录网站","#999");
	$("#js_loginframe_username").val("");
	$("#js_loginframe_password").val("");
	tobeLogin();
	$("#userLoginBefore").show();
	$("#userLoginAfter").hide();
	$("#navUserName").html("");
	
	//delCookie("ZGW_USER_NAME");	//删除cookie
	
  	if(typeof(ZGW_USER_Callback)=="function"){
	  ZGW_USER_Callback(0);
  	}
  }else{
	  alert("注销失败。");
  }
}

function success_loginfo(json){
  ZGW_USER = json;
  if(json.status == 1){
	$("#userLoginBefore").hide();
	$("#userLoginAfter").show();
	$("#navUserName").html(json.username);
	
	/*
	if(getCookie("ZGW_USER_NAME")!=json.username){
		//通过接口设置指定的其他域cookie
		setCookie("ZGW_USER_NAME",json.username);
	}*/
	
  }else{
	$("#userLoginBefore").show();
	$("#userLoginAfter").hide();
	$("#navUserName").html("");
	
	/*
	if(getCookie("ZGW_USER_NAME")!=null){
		//通过接口删除所有已有Cookie域的cookie
		
		delCookie("ZGW_USER_NAME");
	}
	*/
	
	
  }
  if(typeof(ZGW_USER_Callback)=="function"){
	  ZGW_USER_Callback(2);
  }
}

function showZgwUserLoginBox(){
	$("#ZGW_Login_Box").show(100);
	$("#js_loginframe_username").focus();
}

function hideZgwUserLoginBox(){
	$("#ZGW_Login_Box").hide(100);
}

function showTips(tips,color){
	$("#ZGW_Login_Tips").html(tips);
	$("#ZGW_Login_Tips").css("color",color);
}

function tobeLogin(){
	$("#zgw_login_btn").attr("disabled",false);
	$("#zgw_login_btn").attr("value","登  录");
}

document.write("<script type=\"text/javascript\" src=\"../lib/headAndFooter/js/mainTools_utf8.js\"></scr"+"ipt>");
//document.write("<script type=\"text/javascript\" src=\"http://int.zz/zzmain/mainTools.js\"></scr"+"ipt>");
