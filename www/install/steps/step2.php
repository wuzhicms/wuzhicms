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
        <strong>您就是这么任性，换个浏览器您将获得更好的体验和流畅性！</strong> <a href="http://www.google.cn/intl/zh-CN/chrome/" target="_blank">点击下载谷歌浏览器</a>
    </div>
    <![endif]-->

    <!--[if lte IE 8]>
  <div id="fuckie" class="text-warning fade in mb_0">
      <button data-dismiss="alert" class="close" type="button">×</button>
      <strong>您正在使用低版本浏览器，</strong> 在本页面的显示效果可能有差异。建议您升级到<a href="http://www.google.cn/intl/zh-CN/chrome/" target="_blank">Chrome</a>
      或以下浏览器：<a href="https://www.mozilla.org/zh-CN/firefox/new/" target="_blank">Firefox</a> /<a href="http://www.apple.com.cn/safari/" target="_blank">Safari</a> /<a href="http://www.opera.com/" target="_blank">Opera</a> /<a href="http://windows.microsoft.com/zh-cn/internet-explorer/download-ie" target="_blank">Internet Explorer 11</a>
  </div>
  <![endif]-->
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
                                      <li id="default-title-0" class="">
                                          <div>安装须知</div>
                                      </li>
                                      <li id="default-title-1" class="current-step">
                                          <div>环境检测</div>
                                      </li>
                                      <li id="default-title-2" class="">
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
                              <form class="form-horizontal" id="default">

              <fieldset class="step" id="default-step-1" >
               <legend> </legend>


                  <div class="row">
                      <div class="col-lg-12">
                          <section class="panel">
                              <header class="panel-heading">系统部署检测</header>
                              <table class="table table-striped table-advance table-hover">
                                  <thead>
                                  <tr>
                                      <th>架构目录名</th>
                                      <th class="hidden-phone">最佳配置</th>
                                      <th ></th>
                                      <th>当前配置</th>
                                      <th>环境状态</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <tr>
                                      <td>核心框架目录</td>
                                      <td class="hidden-phone"><?php echo $best_iframe;?></td>
                                      <td ><?php echo $best_iframe_status;?></td>
                                      <td><?php echo $current_iframe;?></td>
                                      <td><?php echo $iframe_status;?></td>
                                  </tr>
                                  <tr>
                                      <td>缓存目录</td>
                                      <td class="hidden-phone"><?php echo $best_cache;?></td>
                                      <td><?php echo $best_cache_status;?></td>
                                      <td><?php echo $current_cache;?></td>
                                      <td><?php echo $cache_status;?></td>
                                  </tr>

                                  </tbody>
                              </table>
                          </section>
                      </div>
                  </div>
                <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">环境检测</header>
                          <table class="table table-striped table-advance table-hover">
                              <thead>
                              <tr>
                                  <th>检测项目</th>
                                  <th class="hidden-phone">所需配置</th>
                                  <th>最佳环境</th>
                                  <th>当前环境</th>
                                  <th>环境状态</th>
                              </tr>
                              </thead>
                              <tbody>
                              <tr>
                                  <td>操作系统</td>
                                  <td class="hidden-phone">不限制</td>
                                  <td>Unix 内核</td>
                                  <td><?php $os = explode(" ", php_uname()); if($os[0]=='Darwin'){ echo 'Mac OS X';} else {echo $os[0];}?></td>
                                  <td><div class="right"></div></td>
                              </tr>
                              <tr>
                                  <td>WEB 服务器</td>
                                  <td class="hidden-phone">Apache/Nginx/IIS</td>
                                  <td>apache 2.4 / Nginx 1.7 / IIS8.0</td>
                                  <td><?php $soft_ware = explode(" ",$_SERVER["SERVER_SOFTWARE"]); echo $soft_ware[0];?></td>
                                  <td><div class="right"></div></td>
                              </tr>
                              <tr>
                                  <td>PHP 版本</td>
                                  <td class="hidden-phone">5.2/5.3/5.4</td>
                                  <td>5.4</td>
                                  <td><?php echo PHP_VERSION;?></td>
                                  <td><div class="right"></div></td>
                              </tr>
                              <tr>
                                  <td>附件上传 </td>
                                  <td class="hidden-phone">不限制</td>
                                  <td>20M</td>
                                  <td><?php echo get_cfg("upload_max_filesize");?></td>
                                  <td><div class="right"></div></td>
                              </tr>

                              <tr>
                                  <td>MYSQL 扩展</td>
                                  <td class="hidden-phone">支持</td>
                                  <td>支持</td>
                                  <td><?php echo get_func('mysql_connect',1,1);?></td>
                                  <td><?php echo get_func('mysql_connect');?></td>
                              </tr>
                              <tr>
                                  <td>MCrypt 扩展</td>
                                  <td class="hidden-phone">可选</td>
                                  <td>支持</td>
                                  <td><?php echo get_func('mcrypt_cbc',1);?></td>
                                  <td><?php echo get_func('mcrypt_cbc');?></td>
                              </tr>
                              <tr>
                                  <td>GD库</td>
                                  <td class="hidden-phone">支持</td>
                                  <td>支持</td>
                                  <td><?php echo get_func('gd_info',1,1);?></td>
                                  <td><?php echo get_func('gd_info');?></td>
                              </tr>
                              <tr>
                                  <td>mbstring 扩展</td>
                                  <td class="hidden-phone">可选</td>
                                  <td>支持</td>
                                  <td><?php echo get_func('mcrypt_cbc',1);?></td>
                                  <td><?php echo get_func('mcrypt_cbc');?></td>
                              </tr>

                              <tr>
                                  <td>Curl 扩展</td>
                                  <td class="hidden-phone">可选</td>
                                  <td>支持</td>
                                  <td><?php echo get_func('curl_init',1);?></td>
                                  <td><?php echo get_func('curl_init');?></td>
                              </tr>
                              <tr>
                                  <td>脚本占用最大内存（memory_limit）</td>
                                  <td class="hidden-phone">128M</td>
                                  <td>512M</td>
                                  <td><?php echo get_cfg("memory_limit");?></td>
                                  <td><div class="right"></div></td>
                              </tr>
                              <tr>
                                  <td>显示错误信息（display_errors）</td>
                                  <td class="hidden-phone">可选</td>
                                  <td>开启</td>
                                  <td><?php echo get_cfg("display_errors");?></td>
                                  <td><div class="right"></div></td>
                              </tr>


                              </tbody>
                          </table>
                      </section>
                  </div>
              </div>

<?php if(!empty($filelist)) {?>
                <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">目录文件权限检测</header>
                          <table class="table table-striped table-advance table-hover">
                              <thead>

                              <tr>
                                  <th>有问题的（文件/目录）</th>
                                  <th class="hidden-phone">所需状态</th>
                                  <th>当前状态</th>
                              </tr>

                              </thead>
                              <tbody>
                              <?php
                              foreach($filelist as $file) {
                              ?>
                              <tr>
                                  <td><?php echo $file;?></td>
                                  <td class="hidden-phone">不可写</td>
                                  <td><div class="error"></div></td>
                              </tr>
                              <?php }?>

                              </tbody>
                          </table>
                      </section>
                  </div>
              </div>
                  <?php }?>
    <div class="stepbtn"><a href="index.php?step=1" class="btn btn-info btn-shadow btn-step pull-left">上一步</a>
        <?php if($support) {?>
        <a href="index.php?step=3" class="btn btn-info btn-shadow btn-step pull-right">下一步</a>
        <?php } else {?>
            <a href="javascript:window.location='index.php?step=2&time=<?php echo time();?>';" class="btn btn-info btn-shadow btn-step pull-right">环境检测不通过，请配置后刷新本页面</a>
        <?php }?>
    </div>
              </fieldset>

                              </form>
                          </div>
                      </section>
                  </div>
              </div>
              <!-- page end-->
          </section>
  </section>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
  </body>
</html>
