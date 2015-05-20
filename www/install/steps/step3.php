<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=no">
    <meta name="description" content="五指CMS程序安装">
    <meta name="author" content="wuzhicms.cn,Pixel grid studio">
    <title>WUZHICMS程序安装</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

    <!--[if IE]> 
    <div id="fuckie" class="text-warning fade in mb_0">
        <button data-dismiss="alert" class="close" type="button">×</button>
        <strong>一般人我不会告诉他第三遍的，亲，换吧！</strong> <a href="http://www.google.cn/intl/zh-CN/chrome/" target="_blank">点击下载谷歌浏览器</a>
    </div>
    <![endif]-->

    <!--[if lte IE 8]>
  <div id="fuckie" class="text-warning fade in mb_0">
      <button data-dismiss="alert" class="close" type="button">×</button>
      <strong>您正在使用低版本浏览器，</strong> 在本页面的显示效果可能有差异。建议您升级到<a href="http://www.google.cn/intl/zh-CN/chrome/" target="_blank">Chrome</a>
      或以下浏览器：<a href="https://www.mozilla.org/zh-CN/firefox/new/" target="_blank">Firefox</a> /<a href="http://www.apple.com.cn/safari/" target="_blank">Safari</a> /<a href="http://www.opera.com/" target="_blank">Opera</a> /<a href="http://windows.microsoft.com/zh-cn/internet-explorer/download-ie" target="_blank">Internet Explorer 11</a>
  </div>
  <![endif]-->
      <script src="js/jquery.js"></script>
  </head>
  <body>
  <section class="container">
      <!--main content start-->
          <section class="wrapper">
              <!-- page start-->
              <div class="wuzhicmsstep">
                  <div class="col-lg-12">
                      <section class="panel">
                          <div class="panel-body">
                          <div class="logo text-center"><a href="http://www.wuzhicms.com/" target="_blank"><img src="img/logo.png" alt=""><span>安装五步曲</span></a></div>
                              <div class="stepy-tab text-center">
                                  <ul id="default-titles" class="stepy-titles clearfix">
                                      <li id="default-title-0" >
                                          <div>安装须知</div>
                                      </li>
                                      <li id="default-title-1" class="">
                                          <div>环境检测</div>
                                      </li>
                                      <li id="default-title-2" class="current-step">
                                          <div>账号配置</div>
                                      </li>
                                      <li id="default-title-3" class="">
                                          <div>正在安装</div>
                                      </li>
                                      <li id="default-title-4" class="">
                                          <div>安装完成</div>
                                      </li>
                                  </ul>
                              </div>
               <form name="myform" action="index.php" method="post" id="myform" onsubmit="return formsubmit();" class="form-horizontal" >
              <fieldset class="step" id="default-step-2" >
                  <legend> </legend>

                  <div class="row">
                    <div class="col-lg-6">
                      <section class="panel">
                        <header class="panel-heading">填写数据库信息</header>
                        <div class="panel-body">

                            <div class="form-group">
                                <label class="col-sm-4 control-label">数据库主机：</label>
                                <div class="col-sm-5">
                                    <input type="text" name="dbhost" id="dbhost" class="form-control" value="localhost">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">数据库帐号：</label>
                                <div class="col-sm-5">
                                    <input type="text" name="username" id="username" value="root" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">数据库密码：</label>
                                <div class="col-sm-5">
                                    <input type="password" name="password" id="password" value="" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">数据库名称：</label>
                                <div class="col-sm-5">
                                    <input type="text"name="dbname" id="dbname" class="form-control" value="wuzhicms">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">数据库前缀：</label>
                                <div class="col-sm-5">
                                    <input type="text" name="tablepre" id="tablepre" class="form-control" value="wz_">
                                </div>
                            </div>


                        </div>
                      </section>
                    </div>

                    <div class="col-lg-6">
                      <section class="panel admin">
                        <header class="panel-heading">填写管理员信息</header>
                        <div class="panel-body">

                            <div class="form-group">
                                <label class="col-sm-4 control-label">管理员帐号：</label>
                                <div class="col-sm-5">
                                    <input type="text" name="admin_username" id="admin_username" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">管理员密码：</label>
                                <div class="col-sm-5">
                                    <input type="password" name="admin_password" id="admin_password" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">重复密码：</label>
                                <div class="col-sm-5">
                                    <input type="password" name="repassword" id="repassword" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">管理员 Email：</label>
                                <div class="col-sm-5">
                                    <input type="input" name="admin_email" id="admin_email" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                      </section>
                    </div>

                  </div>
<div class="text-center stepbtn"><input type="submit" name="submit" class="btn btn-info btn-shadow btn-step" value="开始安装" ></div>
              </fieldset>
           </form>
                          </div>
                      </section>
                  </div>
              </div>
              <!-- page end-->
          </section>
  </section>

  <script type="text/javascript">
      <!--
      var errmsg = new Array();
      errmsg[1] = '您已经安装过wuzhicms，确认安装将会删除老数据！是否继续？';
      errmsg[2] = '数据库信息配置错误！';
      errmsg[3] = '成功连接数据库，数据库名称不存在，请创建';
      errmsg[5] = '管理员用户名不能为空';
      errmsg[6] = '管理员密码不能为空';
      errmsg[7] = '管理员邮箱不能为空';
      errmsg[8] = '管理员密码2次输入不一致';
      errmsg[9] = 'Email格式错误';
      var ischeck=0;
      function formsubmit() {

          var url = '?step=3&rd='+Math.random();
          var dbhost=$('#dbhost').val();
          var username=$('#username').val();
          var password=$('#password').val();
          var dbname=$('#dbname').val();
          var tablepre=$('#tablepre').val();
          var admin_username=$('#admin_username').val();
          var admin_password=$('#admin_password').val();
          var repassword=$('#repassword').val();
          var admin_email=$('#admin_email').val();


          $.post(url,{dbhost:dbhost,username:username,password:password,dbname:dbname,tablepre:tablepre,admin_username:admin_username,admin_password:admin_password,repassowrd:repassword,admin_email:admin_email}, function(data){
              if(data > 1) {
                  alert(errmsg[data]);
                  if(data==5) {
                      $('#admin_username').focus();
                  } else if(data==6 || data==8) {
                      $('#admin_password').focus();
                  } else if(data==7 || data==9) {
                      $('#admin_email').focus();
                  } else if(data==2) {
                      $('#username').focus();
                  }
                  return false;
              }
              else if(data=='ok' || (data == 1 && confirm(errmsg[1]))) {
                  window.location='index.php?step=4';
              } else {
                  return false;
              }
          });
          return false;
      }
     // -->
  </script>
  </body>
</html>
