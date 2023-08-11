/* JavaScript Document
 * Author Aber
 * Sep 2013
 */

document.write("<style type=\"text/css\">.Aberheader,.Aberfooter{clear:both;float:none;font-size:13px;}.Aberheader ul,.Aberheader li,.Aberfooter ul,.Aberfooter li,.sidebar ul,.sidebar li{padding:0;margin:0;list-style:none;}.Aberheader a img,.footer a img{border:none;}.Aberheader a:link,.footer a:link{color:#666;text-decoration:none;}.Aberheader a:visited,.footer a:visited{color:#666;text-decoration:none;}.Aberheader a:hover,.Aberheader a:active,.Aberheader a:focus,.footer a:hover,.footer a:active,.footer a:focus{text-decoration:none;}.Aberheader{background:#f7f7f7;border-bottom:1px solid #eeeeee;height:36px;width:100%;position:fixed;_position:absolute;z-index:9999;top:0;left:0;margin:0 auto;color:#666;}.topBar{width:1000px;margin:0 auto;line-height:36px;}.topH{margin-top:36px;}#Bar_R{}.ABwrap{position:absolute;z-index:1000;background:url(/res/topic/lib/headAndFooter/img/bg.gif);}.boxShadow{box-shadow:0 -4px 3px #000;-webkit-box-shadow:0 -4px 3px #000;-moz-box-shadow:0 -4px 3px #000;-o-box-shadow:0 -4px 3px #000;}.AberuserCenter{height:36px;line-height:36px;}a#signin{display:block;color:#FFF;background:#227777;padding:0 20px;height:36px!important;line-height:36px!important;}.registerLink{display:block;padding:0 15px;}.loginframe_wrap{margin-left:-75px;padding-top:10px;}.loginframe{padding:1px;background:#DDD;border:1px solid #f1f1f1;}.loginbox{width:290px;background:#FFF;padding:10px 40px;}.login_tips{color:#999;}.error_tips{color:#F00;}.loginframe_ipt{width:210px;height:30px;line-height:30px;border:1px solid #DDD;margin:5px 0;}.autologin{float:left;}.loginframe_checkbox{margin:5px 7px 0 0;}.forget{float:right;white-space:nowrap;}.loginframe_btn{background:url(/res/topic/lib/headAndFooter/img/loginSubmit_bg.gif) repeat-x;width:210px;height:32px;line-height:32px;color:#FFF;font-size:14px;font-weight:bold;cursor:pointer;border:1px solid #239438;margin:10px 0;}.userInfo{display:block;height:36px;padding:0 19px 0 15px;cursor:pointer;background:#ccc;border-bottom:3px solid #ddd;position:relative;_width:120px;_overflow:hidden;_white-space:nowrap;}.loginOut{padding:0 15px;}.ABwrap{padding-top:10px;}.ABwrap ul{width:100px;padding:1px;background:#DDD;border:1px solid #f1f1f1;margin:0;list-style:none;}.ABwrap ul li{background:#FFF;}.ABwrap ul li a{padding:0 15px;border-bottom:1px solid #EEE;display:block;}.ABwrap ul li a:hover{background:#EEE;border-bottom:1px solid #ddd;}ul#tools{height:34px;line-height:34px;border-left:1px solid #bfbdbd;border-right:1px solid #fff;}ul#tools li.BT{float:left;}.topButton a.BTLink{display:block;border-left:1px solid #fff;border-right:1px solid #bfbdbd;}.topButton a.BTLink:hover{background:url(/res/topic/lib/headAndFooter/img/topBtn_hover.gif) repeat-x;border:none;padding:0 1px;}.topButton a.BTLink em.BTIcon{background:url(/res/topic/lib/headAndFooter/img/toolsBar.gif) no-repeat;display:block;height:34px;text-indent:-9999px;line-height:34px;margin:0 16px 0 12px;}.topButton .BTLink{position:relative;}#sns{width:37px;background-position:0 0;}#email{width:33px;background-position:0 -34px;}#rss{width:25px;background-position:0 -68px;}#set{width:27px;background-position:0 -102px;}.topButton a:hover em#sns{background-position:0 -136px;}.topButton a:hover em#email{background-position:0 -170px;}.topButton a:hover em#rss{background-position:0 -204px;}.topButton a:hover em#set{background-position:0 -238px;}em.tools_arr{position:absolute;z-index:10;right:4px;top:15px;border-color:#777 transparent transparent;border-style:solid dashed dashed;border-width:4px 4px 0;font-size:0;height:0;width:0;line-height:0;}a:hover em.tools_arr{-webkit-transform:rotate(180deg);-moz-transform:rotate(180deg);-o-transform:rotate(180deg);transform:rotate(180deg);-webkit-transition:all .25s ease 0s;-moz-transition:all .25s ease 0s;-o-transition:all .25s ease 0s;transition:all .25s ease 0s;}.AbertopBar{width:1000px;margin:0 auto;font-size:12px;}.AbertopBar .Bnav{border:1px solid #eee;border-bottom:none;background:#f6f6f6;}.AbertopBar .Bnav ul{list-style:none;padding:0;}.AbertopBar .Bnav ul li{float:left;height:26px;}.AbertopBar .Bnav ul li a{display:inline-block;padding:0 8px;margin-top:6px;text-align:center;line-height:14px;height:14px;overflow:hidden;border-right:1px solid #ddd;}.AbertopBar .Bnav ul li.end_nav a{border:none;}.AbertopBar .Nav_bottom{background:#fff;}.AbertopBar .Nav_bottom ul{width:124px;float:left;background:url(/res/topic/lib/headAndFooter/img/BNav_line.gif) no-repeat right center;padding:0;margin:0;}.AbertopBar .Nav_bottom ul.end_mnav{background:none;}.AbertopBar .Nav_bottom ul li a{padding:0 8px;border:none;}.Aberfooter{color:#333;font-size:12px;line-height:20px;}.ft_warp{width:1000px;margin:0 auto;}.searchBar{padding:6px 0;background-color:#f5f5f5;border-top:1px solid #d6d6d6;border-bottom:1px solid #d6d6d6;}.searchframe{background:url(/res/topic/lib/headAndFooter/img/search_bg.gif) repeat-x;height:26px;width:400px;margin:0 auto;}.searchframe .search_ipt_warp{background:url(/res/topic/lib/headAndFooter/img/search_l.gif) no-repeat;height:26px;}.searchframe .search_ipt{border:none;height:24px;line-height:24px;margin:0;width:345px;background:none;padding:0 5px;}input.search_submit{background:url(/res/topic/lib/headAndFooter/img/search_submit.gif) no-repeat;width:45px;height:26px;border:none;text-indent:-9999px;margin:0;cursor:pointer;}input.search_submit:hover{background:url(/res/topic/lib/headAndFooter/img/search_submit_hover.gif) no-repeat;}.footerNav{height:30px;}.copyrightBar{padding:10px 0;background-color:#227777;color:#fff;}.copyrightBar .copyright{display:block;margin-right:20px;float:right;text-align:right;}.copyrightBar .bottomlink{float:left;}.copyrightBar .bottomlink ul{}.copyrightBar .bottomlink ul li{float:left;color:#fff;}.copyrightBar .bottomlink ul li a{margin:10px;color:#fff;}.sidebar{bottom:300px;left:50%;position:fixed;margin-left:550px;color:#777;font-size:12px;line-height:20px;}.sidebar .SB_warp{width:60px;}.sidebar .SB_warp .SB_nav_btn{display:block;background:url(/res/topic/lib/headAndFooter/img/sidebar_bg_01.gif) no-repeat;width:60px;height:22px;cursor:pointer;text-indent:10px;line-height:22px;}.sidebar .SB_warp .SB_nav .tools_arr{top:10px;right:7px;}.sidebar .SB_warp .SB_nav ul{width:58px;border-left:1px solid #bfbdbd;border-right:1px solid #bfbdbd;background:#f3f3f3;}.sidebar .SB_warp .SB_nav ul li{text-align:center;}.sidebar .SB_warp .SB_nav ul li a{display:block;width:58px;text-decoration:none;color:#666;border-bottom:1px solid #d1d1d1;border-top:1px solid #fff;}.sidebar .SB_warp .SB_nav ul li a:hover{background:#444;color:#FFF;border-bottom:1px solid #000;border-top:1px solid #AAA;}.sidebar .SB_warp .SB_nav ul li.SB_nav_last a{border-bottom:none;}.sidebar .SB_warp .backTop{background:url(/res/topic/lib/headAndFooter/img/sidebar_bg_02.gif) no-repeat;height:28px;cursor:pointer;}.fltrt{float:right;}.fltlft{float:left;}.clearfloat{clear:both;height:0;font-size:1px;line-height:0px;}.redborder{border-color:#F00;}#ie6-warning{background:rgb(255,255,225);font-size:13px;color:#333;width:97%;padding:2px 15px 2px 23px;text-align:center;}#ie6-warning img{vertical-align:middle;}#ie6-warning a{text-decoration:none;}</style>");

document.write('<div id="style_2013_1000px" class="Aberheader">');
document.write('<div class="topBar">');
document.write('<div id="Bar_L" class="fltlft">');
document.write('<div class="Aberlogo">');
document.write('<span>中央军委机关事务管理总局欢迎您！</span>');
document.write('</div>');
document.write('</div>');
document.write('<div id="Bar_R" class="fltrt">');
document.write('<div class="AberuserCenter fltlft">');
document.write('<div id="userLoginBefore" class="fltlft" style="display:block;">');
document.write('<div class="fltlft userLoginedWarp">');
document.write('<a href="http://user.zz/" id="signin" class="">登录</a>');
document.write('<div id="ZGW_Login_Box" class="loginframe_wrap ABwrap" style="display:none;">');
document.write('<div class="loginframe">');
document.write('<div class="loginbox">');
document.write('<span id="ZGW_Login_Tips" class="login_tips">请使用政工网通行证登录网站</span>');
document.write('<br />');
document.write('<input id="js_loginframe_username" type="text" class="loginframe_ipt" placeholder="通行证/邮箱" />');
document.write('<input id="js_loginframe_password" type="password" class="loginframe_ipt" placeholder="请输入密码" />');
document.write('<br />');
document.write('<label class="autologin"><input type="checkbox" id="js_loginframe_autologin" class="loginframe_checkbox" checked="checked" /><span>下次自动登录</span></label>');
document.write('<a href="http://user.zz/usercenter/getpassword.aspx" class="forget">忘记密码？</a>');
document.write('<br />');
document.write('<input type="button" id="zgw_login_btn" class="loginframe_btn" onclick="zgwUserLogin()" value="登  录">');
document.write('</div>');
document.write('</div>');
document.write('</div>');
document.write('</div>');
document.write('<a class="registerLink fltlft" href="http://user.zz/usercenter/userreg.aspx" target="_blank">注册</a>');
document.write('<a class="registerLink fltlft" href="http://user.zz/usercenter/userreg.aspx" target="_blank"><img src="/res/topic/lib/headAndFooter/img/wangpan.png" width="18" style="vertical-align: middle;"> 网盘</a>');
document.write('</div>');
document.write('<div id="userLoginAfter" class="fltlft" style="display:none;">');
document.write('<span class="fltlft">欢迎您，</span>');
document.write('<div class="fltlft topButton boxShadow">');
document.write('<span class="userInfo"><span id="navUserName">USERNAME</span><em class="tools_arr"></em></span>');
document.write('<div class="app_list ABwrap" style="display:none;">');
document.write('<ul>');
document.write('<li><a href="http://user.zz/usercenter/userapp.aspx" target="_blank">用户中心</a></li>');
//document.write('<li><a href="http://int.zz/ishare/">共享资料</a></li>');
//document.write('<li><a href="">军旅微博</a></li>');
document.write('<li><a href="http://netdisk.zz/" target="_blank">网盘</a></li>');
document.write('</ul>');
document.write('</div>');
document.write('</div>');
document.write('<a href="javascript:zgwUserLogout()" class="fltlft loginOut">安全退出</a>');
document.write('</div>');
document.write('</div>');
/*document.write('<ul id="tools" class="fltlft">');*/
/*document.write('<li class="BT">');
document.write('<div class="topButton">');
document.write('<a href="#" class="BTLink">');
document.write('<em id="sns" class="BTIcon">社区</em>');
document.write('<em class="tools_arr"></em>');
document.write('<span class="tools_msg"></span>');
document.write('</a>');
document.write('<div class="ABwrap sns_list" style="display:none;">');
document.write('<ul>');
document.write('<li>');
document.write('<a href="#">');
document.write('<span>查看微博</span>');
document.write('</a>');
document.write('</li>');
document.write('<li>');
document.write('<a href="#">');
document.write('<span>查看评论</span>');
document.write('</a>');
document.write('</li>');
document.write('<li>');
document.write('<a href="#">');
document.write('<span>查看@我</span>');
document.write('</a>');
document.write('</li>');
document.write('<li>');
document.write('<a href="#">');
document.write('<span>查看粉丝</span>');
document.write('</a>');
document.write('</li>');
document.write('<div class="clearfloat"></div>');
document.write('</ul>');
document.write('</div>');
document.write('</div>');
document.write('</li>');*/

/*document.write('<li class="BT">');
document.write('<div class="topButton">');
document.write('<a href="#" class="BTLink">');
document.write('<em id="email" class="BTIcon">邮件</em>');
document.write('<em class="tools_arr"></em>');
document.write('<span class="tools_msg"></span>');
document.write('</a>');
document.write('<div class="ABwrap mail_list" style="display:none;">');
document.write('<ul>');
document.write('<li>');
document.write('<a href="#">');
document.write('<span>收件箱</span>');
document.write('</a>');
document.write('</li>');
document.write('<li>');
document.write('<a href="#">');
document.write('<span>写邮件</span>');
document.write('</a>');
document.write('</li>');
document.write('<li>');
document.write('<a href="#">');
document.write('<span>网盘</span>');
document.write('</a>');
document.write('</li>');
document.write('<div class="clearfloat"></div>');
document.write('</ul>');
document.write('</div>');
document.write('</div>');
document.write('</li>');*/

/*document.write('<li class="BT">');
document.write('<div class="topButton">');
document.write('<a href="#" class="BTLink">');
document.write('<em id="set" class="BTIcon">RSS</em>');
document.write('<span class="tools_msg"></span>');
document.write('</a>');
document.write('</div>');
document.write('</li>');*/

/*document.write('<li class="BT">');
document.write('<div class="topButton">');
document.write('<a href="#" class="BTLink">');
document.write('<em id="rss" class="BTIcon">快速导航</em>');
document.write('<em class="tools_arr"></em>');
document.write('<span class="tools_msg"></span>');
document.write('</a>');
document.write('<div class="ABwrap set_list" style="display:none;">');
document.write('<ul>');
document.write('<li><a href="http://www.zz/bdxx/"><span>部队新闻</span></a></li>');
document.write('<li><a href="http://jyxc.zz/"><span>建言献策</span></a></li>');
document.write('<li><a href="http://xcjb.zz/"><span>宣传简报</span></a></li>');
document.write('<li><a href="http://literature.zz/"><span>军旅文学</span></a></li>');
document.write('<li><a href="http://www.zz/edu/"><span>优秀教案</span></a></li>');
document.write('<div class="clearfloat"></div>');
document.write('</ul>');*/
document.write('</div>');
document.write('</div>');
document.write('</li>');
document.write('</ul>');
document.write('</div>');
document.write('<div class="clearfloat"></div>');
document.write('</div>');
document.write('</div>');
document.write('<div style="height: 36px;">');
document.write('</div>');

