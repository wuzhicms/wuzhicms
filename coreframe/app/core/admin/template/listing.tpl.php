<?php defined('IN_WZ') or exit('No direct script access allowed');?>
    <!DOCTYPE html>
    <!--[if lt IE 7]>      <html class="no-js sidebar-large lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
    <!--[if IE 7]>         <html class="no-js sidebar-large lt-ie9 lt-ie8"> <![endif]-->
    <!--[if IE 8]>         <html class="no-js sidebar-large lt-ie9"> <![endif]-->
    <!--[if gt IE 8]><!--> <html lang="zh-cn" class="no-js sidebar-large"> <!--<![endif]-->
<meta http-equiv="content-type" content="text/html;charset=<?php echo CHARSET;?>" />
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->
<head>
    <title>wuzhicms</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta name="author" content="Pixel grid studio"  />
    <link href="<?php echo R;?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo R;?>css/bootstrapreset.css" rel="stylesheet">
    <link href="<?php echo R;?>css/pxgridsicons.min.css" rel="stylesheet" />
    <link href="<?php echo R;?>css/style.css" rel="stylesheet">
    <link href="<?php echo R;?>css/responsive.css" rel="stylesheet" />
    <link href="<?php echo R;?>css/animation.css" rel="stylesheet">
    <script src="<?php echo R;?>js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <!--[if lt IE 9]>
    <script src="<?php echo R;?>js/html5shiv.js"></script>
    <script src="<?php echo R;?>js/respond.min.js"></script>
    <![endif]-->
    <!--[if lt IE 8]>
    <link rel="stylesheet" href="<?php echo R;?>css/ie7/ie7.css">
    <!<![endif]-->
</head>
<body>
<section class="wrapper">
    <!--state overview start-->
    <div class="row state-overview">
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol userblue">
                    <i class="icon-users"></i>
                </div>
                <div class="value">
                    <a href="?m=member&f=index&v=listing<?php echo $this->su();?>&_menuid=30"><h1 id="count1">0</h1></a>
                    <p>用户总量</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol commred">
                    <i class="icon-user-add"></i>
                </div>
                <div class="value">
                    <a href="?m=member&f=index&v=listing<?php echo $this->su();?>&_menuid=30&search=&keyType=username&&regTimeStart=<?php echo date('Y-m-d',SYS_TIME);?>&regTimeEnd="><h1 id="count2">0</h1></a>
                    <p>今日注册用户</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol articlegreen">
                    <i class="icon-file-word-o"></i>
                </div>
                <div class="value">
                    <a href="?m=content&f=content&v=manage<?php echo $this->su();?>&_menuid=26"><h1 id="count3">0</h1></a>
                    <p>文章总数</p>
                </div>
            </section>
        </div>
        <div class="col-lg-3 col-sm-6">
            <section class="panel">
                <div class="symbol rsswet">
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
        <!-- 表单 -->
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading bm0">
                    <span>最新发布内容</span>
                            <span class="tools pull-right">
                                <a class="icon-chevron-down" href="javascript:;"></a>
                            </span>

                </header>
                <div class="panel-body" id="panel-bodys">
                    <table class="table table-hover personal-task">
                        <tbody>
                        <?php
                        $categorys = get_cache('category','content');
                        if(!empty($categorys)) {
                            $lastlist = get_cache('lastlist', 'content');
                            $nums = 1;
                            if (is_array($lastlist)) {
                            foreach ($lastlist as $n => $r) {
                                if ($nums > 10) break;
                                if (!isset($categorys[$r['cid']])) continue;
                                $nums++;
                                ?>
                                <tr>
                                    <td><?php echo $categorys[$r['cid']]['name']; ?></td>
                                    <td><?php echo "<a href='" . $r['url'] . "' target='_blank'>" . strcut($r['title'], 40, '..') . "</a>"; ?></td>
                                    <td class="col-md-4">
                                        <?php echo time_format($r['addtime']); ?>
                                    </td>
                                </tr>
                            <?php }
                        }
                        }?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <!-- 表单 -->
        <div class="col-lg-6">
        <!--系统升级-->
            <section class="panel">
            <header class="panel-heading bm0">
                <span>系统信息 </span><span class="badge" style="background-color:#FF3333"><?php if (isset($app['package'])) {?> new <?php }?></span>
                    <span class="tools pull-right">
                        <a class="icon-chevron-down" href="javascript:;"></a>
                    </span>
            </header>
            <div class="panel-body" id="panel-bodys">
                <table class="table table-hover system-upgrade">
                    <tbody>
                    <tr>
                        <td><strong>环境信息</strong>：<a data-toggle="modal" href="#chartsetting"><?php echo $_SERVER['SERVER_SOFTWARE'];?>【查看基本信息】</a>
                            <a href="index.php?m=core&f=index&v=phpinfo<?php echo $this->su();?>" target="_blank" >【点击查看 phpinfo()】</a><br/>
                            <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="chartsetting" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title">服务器基本信息</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                站点路径：<?php echo $_SERVER['DOCUMENT_ROOT']?str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']):str_replace('\\','/',dirname(__FILE__));?> <br/>
                                                服务器系统：<?php echo php_uname(); ?> <br/>
                                                服务器软件：<?php echo $_SERVER['SERVER_SOFTWARE'];?> <br/>
                                                数据库版本：<?php echo $dbversion;?> <br/>
                                                PHP 版本： <?php echo PHP_VERSION;?>

                                                <!--                            上传文件最大限制：--><?php //echo get_cfg_var('upload_max_filesize'); ?><!-- <br/>-->
                                                Zend版本：<?php $zend_version = zend_version();if(empty($zend_version)){echo 'X';}else{echo $zend_version;}?>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-default">隐藏</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <strong>服务器IP</strong>：<?php echo $_SERVER["SERVER_ADDR"];?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <strong>版本信息</strong>： 五指CMS v<?php echo VERSION.' (简体中文'.CHARSET.')';?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>

                            <strong>升级信息</strong>：
                            <?php if (isset($app['package'])) {?>
                                下一版本: V<?php echo $app['package']['toVersion']; ?> 最新版本: V<?php echo $app['latestVersion']; ?> <button class="btn btn-primary btn-sm active" role="button" data-toggle="modal" data-backdrop="static" data-target="#wuzhicms-upgrade">升级</button>
                            <?php } else {?>
                                已经是最新版本: V<?php echo $app['latestVersion']; ?>
                            <?php }?>


                            <?php if (isset($app['package'])) {?>
                                <div class="modal fade" id="wuzhicms-upgrade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="wuzhicms-upgrade">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">系统升级</h4>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th width="50%">应用名称</th>
                                                        <th width="25%">版本</th>
                                                        <th>备份升级文件</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>wuzhicms</td>
                                                        <td>
                                                            <!--  <strong class="text-success">2.0.5</strong> -->
                                                            <strong class="text-muted"> <?php echo $app['package']['fromVersion']; ?></strong> -&gt; <strong class="text-success"><?php echo $app['package']['toVersion']; ?></strong>
                                                        </td>
                                                        <td>是</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div style="background-color: #f5f5f5;padding: 15px 20px;">
                                                    更新日志:</br></br>
                                                    <?php echo nl2br($app['package']['description']);?>
                                                </div>
                                                <div class ="tpl-package-upgrade hidden" style="background-color: #f5f5f5;padding: 15px 20px;">
                                                    更新模版:</br></br>
                                                    <span></span>
                                                    <div>以上模版您编辑过，是否覆盖更新？
                                                        <button type="button" data-update='false' class="btn btn-sm update-tpl-btn">忽略以上模板</button>
                                                        <button type="button" data-update='true' class="active btn btn-default btn-sm update-tpl-btn" >覆盖更新</button>
                                                         <div class="tpl-helper">
                                                        选择覆盖，您的文件的将会自动备份<br/>
                                                        选择忽略，以上更新文件将无法升级
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="package-update-progress" class="package-update-progress hidden">
                                                    <div class="progress progress-striped active">
                                                        <div class="progress-bar progress-bar-success" style="width: 0%"></div>
                                                    </div>
                                                    <div class="text-success progress-text"></div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary btn-wuzhicms-upgrade"
                                                    data-check-environment-url="?m=appupdate&f=index&v=checkEnvironment&_su=<?php  echo _SU;?>"
                                                    data-download-package-url="?m=appupdate&f=index&v=downloadPackage&_su=<?php  echo _SU;?>&packageId=<?php echo $app['package']['id'] ?>"
                                                    data-proccess-template-url="?m=appupdate&f=index&v=proccessTpl&_su=<?php  echo _SU;?>&packageId=<?php echo $app['package']['id'] ?>"
                                                    data-backup-file-url="?m=appupdate&f=index&v=backupUpgradeFile&_su=<?php  echo _SU;?>&packageId=<?php echo $app['package']['id'] ?>"
                                                    data-begin-upgrade-url="?m=appupdate&f=index&v=beginUpgrade&_su=<?php  echo _SU;?>&packageId=<?php echo $app['package']['id'] ?>"
                                                >开始升级</button>
                                                <strong class="text text-danger" id="updating-hint" style="display:none;">正在升级，请不要关闭当前窗口...</strong>

                                                <button id="finish-update-btn" data-loading-text="正在完成升级, 请稍等..." class="btn btn-primary" style="display:none">完成升级</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <!-- 版权信息 -->
            <section class="panel">
                <header class="panel-heading bm0">
                    <span id="license-tip">版权信息</span>
                            <span class="tools pull-right">
                                <a class="icon-chevron-down" href="javascript:;"></a>
                            </span>
                </header>
                <div class="panel-body" id="panel-bodys">
                    <table class="table table-hover personal-task hide" id="license-table">
                        <tbody>
                        <tr>
                            <td>
                                <strong>架构设计</strong>： 王参加
                                <a href="http://www.wuzhicms.com" target="_blank">[北京五指互联科技有限公司版权所有]</a>

                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>开发团队</strong>： 王参加、赵宏伟、张峰、秦兴忠、王冲、屠正武、吴灵辉、汪勇 、渠雁云、翟党伟、郝川 </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>界面设计</strong>： 张峰(五指CMS首席设计师)、<a href="http://www.pxgrids.com/" target="_blank">渠雁云</a>(像素格工作室)
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>免费技术论坛支持</strong>：
                                <a href="http://bbs.wuzhicms.com" target="_blank">点击进入咨询</a>
                            </td>
                            <td></td>
                        </tr>
                        </tbody></table>
                        <table class="table table-hover personal-task">
                            <tbody>

                        <?php
                        $li1 = '免费版 － <a href="http://www.wuzhicms.com/buy/" target="_blank">点击购买</a>';
                        $li3 = '<a href="http://www.wuzhicms.com/buy/" target="_blank"> 没有技术服务，点击这里购买</a>';
                        $li2 = '';
                        $li5 = '';
                        ?>

                        <tr id="license-company" class="hide">
                            <td>
                                <strong>授权持有单位</strong>：
                                <span style="color: rgb(244, 83, 107);" id="authorized_company"><?php echo $li1;?></span>
                            </td>
                            <td></td>
                        </tr>
                        <tr id="license-name" class="hide">
                            <td>
                                <strong>授权网站名称</strong>：
                                <span style="color: rgb(244, 83, 107);" id="license_domain_name"><?php echo $li1;?></span>
                            </td>
                            <td></td>
                        </tr>
                        <tr id="license-protr" class="hide">
                            <td>
                                <strong>产品型号</strong>：
                                <span style="color: rgb(244, 83, 107);" id="license_product"><?php echo $li1;?></span>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>产品服务编号</strong>：
                                <strong id="license_id"><?php echo $li2;?></strong>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>授权起止时间</strong>：
                                <span id="license_time"><?php echo $li3;?></span>
                            </td>
                            <td></td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <!-- 版权信息 -->
    </div>
    </div>
</section>

<script src="<?php echo R;?>js/jquery.min.js"></script>
<script src="<?php echo R;?>js/wuzhicms.js"></script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<?php if (isset($app['package'])) {?>
    <script src="<?php echo R;?>js/wuzhicms-upgrade.js"></script>
<?php }?>
<script type="text/javascript">
    $.ajax({
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
    });
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
</script>
</body>
</html>