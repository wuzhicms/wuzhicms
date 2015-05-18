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
        <strong>哎~！您真的很任性，很倔强！我也是醉了~ </strong> <a href="http://www.google.cn/intl/zh-CN/chrome/" target="_blank">点击下载谷歌浏览器</a>
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
        <div class="wuzhicmsstep" >
            <div class="col-lg-12">
                <section class="panel">
                    <div class="panel-body">
                        <div class="logo text-center"><a href="http://www.wuzhicms.com/" target="_blank"><img src="img/logo.png" alt=""><span>安装五步曲</span></a></div>
                        <div class="stepy-tab text-center">
                            <ul id="default-titles" class="stepy-titles clearfix">
                                <li id="default-title-0" class="">
                                    <div>安装须知</div>
                                </li>
                                <li id="default-title-1" class="">
                                    <div>环境检测</div>
                                </li>
                                <li id="default-title-2" class="">
                                    <div>账号配置</div>
                                </li>
                                <li id="default-title-3" class="current-step">
                                    <div>正在安装</div>
                                </li>
                                <li id="default-title-4" class="">
                                    <div>安装完成</div>
                                </li>
                            </ul>
                        </div>
                        <fieldset class="step" id="default-step-3" >
                            <legend> </legend>
                            <div class="steping">
                                <div class="stepprocess" id="stepprocess" style="height:280px; overflow:auto;">
                                    <ul id="installmsg">
                                    </ul>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">
    var startid = 1;
    var msg = new Array();
    var startmsg = new Array();

    startmsg[1] = '开始配置数据库文件： www/mysql_config.php';
    startmsg[2] = '开始配置网站信息文件：www/web_config.php';
    startmsg[3] = '开始配置文件：coreframe/configs/wz_config.php';
    startmsg[4] = '开始导入数据库文件 1';
    startmsg[5] = '开始导入数据库文件 2';
    startmsg[6] = '开始导入数据库文件 3';
    startmsg[7] = '开始初始化数据';
    startmsg[8] = '即将完成安装！';

    msg['error'] = '出现错误：';
    msg[1] = '数据库配置文件： www/mysql_config.php 成功';
    msg[2] = '网站信息配置文件：www/web_config.php 写入成功';
    msg[3] = '文件：coreframe/configs/wz_config.php 写入成功';
    msg[4] = '数据库文件 1 导入成功';
    msg[5] = '数据库文件 2 导入成功';
    msg[6] = '数据库文件 3 导入成功';
    msg[7] = '初始化数据完成';
    msg[8] = '完成安装！';
    function isNam(num) {
        var reNum=/^\d*$/;
        return (reNum.test(num))
    }
    function install() {
        if(startid==7) {
            $("#installmsg").append("<li>-------</li>");
        } else if(startid=='error') {
            return false;
        } else if(startid>8) {
            window.location="index.php?step=5";
            return false;
        }
        $("#installmsg").append("<li>第"+startid+"步，"+startmsg[startid]+"</li>");
        document.getElementById('stepprocess').scrollTop = document.getElementById('stepprocess').scrollHeight;

        $.get("index.php?step=4", {startid: startid, time: Math.random()},
            function (data) {
                if(data=='cache_error') {
                    $("#installmsg").append("<li>缓存目录下的所有文件需要设置为可写 <img src='img/error.png'></li>");
                    startid = 'error';
                }else if(data=='error') {
                    $("#installmsg").append("<li>安装出现未知问题 <img src='img/right.png'></li>");
                    startid = 'error';
                } else if(data.length==1) {
                    $("#installmsg").append("<li style='padding-left: 48px;'>"+msg[data]+" <img src='img/right.png'></li>");
                    startid = startid+1;
                } else {
                    $("#installmsg").append("<li>安装遇到问题：<li>"+data+" <img src='img/error.png'></li>");
                    startid='error';
                }
                document.getElementById('stepprocess').scrollTop = document.getElementById('stepprocess').scrollHeight;
                if(isNam(data)) {
                    install();
                } else {
                    alert('发生未知错误！安装失败！');
                }

            });

    }
    install();

</script>
</body>
</html>