<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="zh-CN" class="no-js sidebar-large">
<meta http-equiv="content-type" content="text/html;charset=<?php echo CHARSET;?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<head>
    <title>wuzhicms</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta name="author" content="Pixel grid studio"  />
    <link href="<?php echo R;?>libs/bootstrap/css/bootstrap.min.css?<?php echo VERSION;?>" rel="stylesheet" />
    <link href="<?php echo R;?>css/style.css?<?php echo VERSION;?>" rel="stylesheet" />
    <script src="<?php echo R;?>libs/jquery/jquery.min.js?<?php echo VERSION;?>"></script>
</head>
<body>
<section class="wrapper">
    <!--state overview start-->
    <div class="row state-overview">
        <div class="col-lg-3 col-sm-6 mb-3">
            <section class="panel d-flex">
                <div class="align-items-center d-flex justify-content-center symbol userblue">
                    <i class="icon-users"></i>
                </div>
                <div class="value">
                    <a href="?m=member&f=index&v=listing<?php echo $this->su();?>&_menuid=30"><h1 id="count1">0</h1></a>
                    <p>用户总量</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6 mb-3">
            <section class="panel d-flex">
                <div class="align-items-center d-flex justify-content-center symbol commred">
                    <i class="icon-user-add"></i>
                </div>
                <div class="value">
                    <a href="?m=member&f=index&v=listing<?php echo $this->su();?>&_menuid=30&search=&keyType=username&&regTimeStart=<?php echo date('Y-m-d',SYS_TIME);?>&regTimeEnd="><h1 id="count2">0</h1></a>
                    <p>今日注册用户</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6 mb-3">
            <section class="panel d-flex">
                <div class="align-items-center d-flex justify-content-center symbol articlegreen">
                    <i class="icon-file-word-o"></i>
                </div>
                <div class="value">
                    <a href="?m=content&f=content&v=manage<?php echo $this->su();?>&_menuid=26"><h1 id="count3">0</h1></a>
                    <p>文章总数</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6 mb-3">
            <section class="panel d-flex">
                <div class="align-items-center d-flex justify-content-center symbol rsswet">
                    <i class="icon-check-circle"></i>
                </div>
                <div class="value">
                    <a href="?m=content&f=content&v=allcheck&status=10<?php echo $this->su();?>&_menuid=26"><h1 id="count4">0</h1></a>
                    <p>待审文章总数</p>
                </div>
            </section>
        </div>
    </div>
    <!--state overview end-->

    <div class="row">
        <div class="col-lg-6 mb-3">
        <!--系统升级-->
            <section class="panel">
            <header class="panel-heading d-flex justify-content-between border-bottom-0">
                <span>系统信息 </span><span class="badge" style="background-color:#FF3333"><?php if (isset($app['package'])) {?> new <?php }?></span>
                <span class="tools"><a class="icon-chevron-down" href="javascript:"></a></span>
            </header>
            <div class="panel-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-black-50 border-light"><strong>环境信息</strong>：<a href="javascript:void(0);" id="server-info"><?php echo $_SERVER['SERVER_SOFTWARE'];?>【查看基本信息】</a>
                        <a href="index.php?m=core&f=index&v=phpinfo<?php echo $this->su();?>" target="_blank" >【点击查看 phpinfo()】</a><br/>
                        <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 11">
                            <div id="server-Toast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                    <strong class="me-auto">服务器信息：</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body small bg-white">
                                    <p class="mb-1"> 站点路径：<?php echo $_SERVER['DOCUMENT_ROOT']?str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']):str_replace('\\','/',dirname(__FILE__));?> </p>
                                    <p class="mb-1">服务器系统：<?php echo php_uname(); ?> </p>
                                    <p class="mb-1">服务器软件：<?php echo $_SERVER['SERVER_SOFTWARE'];?> </p>
                                    <p class="mb-1">数据库版本：<?php echo $dbversion;?> </p>
                                    <p class="mb-1">PHP 版本： <?php echo PHP_VERSION;?></p>
                                    <p class="mb-1">上传文件最大限制：<?php echo get_cfg_var('upload_max_filesize'); ?></p>
                                    <p class="mb-1">Zend版本：<?php $zend_version = zend_version();if(empty($zend_version)){echo 'X';}else{echo $zend_version;}?></p>
                                </div>
                            </div>
                        </div></li>
                    <li class="list-group-item text-black-50 border-light"><strong>服务器IP</strong>：<?php echo $_SERVER["SERVER_ADDR"];?></li>
                    <li class="list-group-item text-black-50 border-light"><strong>版本信息</strong>： 五指CMS v<?php echo VERSION.' (简体中文'.CHARSET.')';?></li>
                    <li class="list-group-item text-black-50 border-light">
                        <strong>升级信息</strong>：
                        <?php if (isset($app['package'])) {?>
                            下一版本: V<?php echo $app['package']['toVersion']; ?> 最新版本: V<?php echo $app['latestVersion']; ?> <button class="btn btn-primary btn-sm active" role="button" data-toggle="modal" data-backdrop="static" data-target="#wuzhicms-upgrade">升级</button>
                        <?php } else {?>
                            已经是最新版本
                        <?php }?>
                    </li>
                </ul>
            </div>
            </section>
        </div>
        <div class="col-lg-6 mb-3">
            <!-- 版权信息 -->
            <section class="panel">
                <header class="panel-heading d-flex justify-content-between border-bottom-0">
                    <span id="license-tip">版权信息</span>
                    <span class="tools"><a class="icon-chevron-down" href="javascript:"></a></span>
                </header>
                <div class="panel-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php
                        $li1 = 'V5';
                        $li3 = '社区版';
                        $li2 = '';
                        $li5 = '北京五指互联科技有限公司 | 010-82463345';
                        ?>
                        <li class="list-group-item text-black-50 border-light hide" id="license-company"><strong>授权持有单位</strong>：<span style="color: rgb(244, 83, 107);" id="authorized_company"><?php echo $li1;?></span></li>
                        <li class="list-group-item text-black-50 border-light hide" id="license-name"><strong>授权网站名称</strong>：<span style="color: rgb(244, 83, 107);" id="license_domain_name"><?php echo $li1;?></span></li>
                        <li class="list-group-item text-black-50 border-light hide" id="license-protr"><strong>产品型号</strong>：<span style="color: rgb(244, 83, 107);" id="license_product"><?php echo $li1;?></span></li>
                        <li class="list-group-item text-black-50 border-light"><strong>产品服务编号</strong>：<strong id="license_id"><?php echo $li2;?></strong></li>
                        <li class="list-group-item text-black-50 border-light"><strong>授权起止时间</strong>：<span id="license_time"><?php echo $li3;?></span></li>
                        <li class="list-group-item text-black-50 border-light"><strong>联系我们</strong>：<span id="license_time"><?php echo $li5;?></span></li>
                    </ul>
                    <ul class="list-group list-group-flush hide">
                        <li class="list-group-item text-black-50 border-light"><strong>架构设计</strong>： 王参加 <a href="http://www.wuzhicms.com" target="_blank">[北京五指互联科技有限公司版权所有]</a></li>
                        <li class="list-group-item text-black-50 border-light"><strong>开发团队</strong>： 王参加、赵宏伟、张峰、秦兴忠、王冲、屠正武、吴灵辉、汪勇 、渠雁云、翟党伟、郝川 </td></li>
                        <li class="list-group-item text-black-50 border-light"><strong>界面设计</strong>： 张峰(五指CMS首席设计师)、渠雁云<a href="http://www.xiangsuge.com/" target="_blank">(像素格工作室)</a></li>
                    </ul>
                </div>
            </section>
        </div>

        <!-- 版权信息 -->
    </div>
    </div>
</section>

<?php if (isset($app['package'])) {?>
    <script src="<?php echo R;?>js/wuzhicms-upgrade.js"></script>
<?php }?>
<script type="text/javascript">
   /* $.ajax({
        type: "get", //jquey是不支持post方式跨域的
        async: false,
        url: window.location.protocol+"//www.wuzhicms.com/api/?m=license&f=credentials",
        dataType: "jsonp",
        jsonp: "jsoncallback",
        jsonpCallback: "callback",
        success: function (json) {
            if (json.code == 369) {
                $("#license-tip").html('授权信息');
                $("#authorized_company").html(json.data.authorized_company);
                $("#license_domain_name").html(json.data.domain_name);
                $("#license_product").html(json.data.authorized_version);
                $("#license_id").html(json.data.serviceid);
                $("#license_time").html(json.data.buy_time + ' - ' + json.data.end_time);
                $("#license-protr").removeClass('hide');
                $("#license-company").removeClass('hide');
                $("#license-name").removeClass('hide');
            } else if (json.code == 400) {
                $("#license-table").removeClass('hide');
                $("#license-protr").removeClass('hide');
                return false;
            }

        }
    });*/
    function stat_speed(count,id)
    {
        var div_by = 10;
        if(count>10000) {
            div_by = 200;
        } else if(count>1000) {
            div_by = 100;
        } else if(count>100) {
            div_by = 50;
        }
        var speed = Math.round(count / div_by),
            $display = $('#'+id),
            run_count = 1,
            int_speed = 1;

        var int = setInterval(function() {
            if(run_count < div_by){
                $display.text(speed * run_count);
                run_count++;
            } else if(parseInt($display.text()) < count) {
                var curr_count = parseInt($display.text()) + 1;
                $display.text(curr_count);
            } else {
                clearInterval(int);
            }
        }, int_speed);
    }

    stat_speed(<?php echo $total_member;?>,'count1');
    stat_speed(<?php echo $today_member;?>,'count2');
    stat_speed(<?php echo $total_number;?>,'count3');
    stat_speed(<?php echo $status_number;?>,'count4');

    $("#server-info").click(function(){
        $('.toast').toast('show');
    });



</script>
<?php include $this->template('footer','core');?>
