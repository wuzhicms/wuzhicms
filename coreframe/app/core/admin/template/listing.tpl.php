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
                    <a href="#"><h1 id="count1">0</h1></a>
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
                    <a href="#"><h1 id="count2">0</h1></a>
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
                    <a href="#"><h1 id="count3">0</h1></a>
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
                    <a href="#"><h1 id="count4">0</h1></a>
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
                        $lastlist = get_cache('lastlist','content');
                        $nums = 1;
                        foreach($lastlist as $n=>$r) {
                            if($nums>10) break;
                            if(!isset($categorys[$r['cid']])) continue;
                            $nums++;
                            ?>
                            <tr>
                                <td><?php echo $categorys[$r['cid']]['name'];?></td>
                                <td><?php echo "<a href='".$r['url']."' target='_blank'>".strcut($r['title'],40,'..')."</a>";?></td>
                                <td class="col-md-4">
                                    <?php echo time_format($r['addtime']);?>
                                </td>
                            </tr>
                        <?php }}?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        <!-- 表单 -->

        <!-- 版权信息 -->
        <div class="col-lg-6">
            <section class="panel">
                <header class="panel-heading bm0">
                    <span>团队及版权信息</span>
                            <span class="tools pull-right">
                                <a class="icon-chevron-down" href="javascript:;"></a>
                            </span>
                </header>
                <div class="panel-body" id="panel-bodys">
                    <table class="table table-hover personal-task">
                        <tbody>
                        <tr>
                            <td>
                                <strong>架构设计</strong>： 王参加
                                <a href="http://www.wuzhicms.com" target="_blank">[北京五指互联科技有限公司版权所有]</a>

                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>开发团队</strong>： 屠正武、吴灵辉、汪勇 、王参加、赵宏伟、渠雁云、翟党伟、郝川 </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>界面设计</strong>： <a href="http://www.pxgrids.com/" target="_blank">像素格工作室</a>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>环境信息</strong>：<a data-toggle="modal" href="#chartsetting">【查看基本信息】</a>
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
                        <?php
                        $li1 = '试用型 － <a href="http://www.wuzhicms.com/buy/" target="_blank">点击购买</a>';
                        $li3 = '<a href="http://www.wuzhicms.com/buy/" target="_blank"> 没有技术服务，点击这里购买</a>';
                        $li2 = '';
                        $li5 = '个人用户永久免费，企业用户免费使用30天';
                        ?>
                        <tr>
                            <td>
                                <strong>系统信息</strong>： 五指CMS v<?php echo VERSION.' (简体中文'.CHARSET.')';?>
                                <a href="http://www.wuzhicms.com/update/lastest/" target="_blank">【查看最新版本】</a>
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>
                                <strong>产品型号</strong>：
                                <span style="color: rgb(244, 83, 107);"><?php echo $li1;?></span>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>产品服务编号</strong>：
                                <strong><?php echo $li2;?></strong>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>授权使用年限</strong>：
                                <?php echo $li5;?>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <strong>技术服务年限</strong>：
                                <?php echo $li3;?>
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
<script type="text/javascript">
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