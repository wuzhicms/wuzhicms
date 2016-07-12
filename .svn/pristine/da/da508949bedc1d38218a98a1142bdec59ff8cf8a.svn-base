<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>

                <div class="panel-body">
                    <form class="form-horizontal tasi-form" method="post" action="">
                        <?php
                        $n=1;
                    foreach($contents as $rs) {?>
                        <div class="msgtype0 form-group"  style="border-top: 2px #F1F2F7 outset;padding-top: 10px;">
                            <label class="col-sm-2 control-label">第<?php echo $n;?>页</label>
                            <div class="col-sm-8">
                                <table class="table">
                                    <tr>
                                        <th width="50">标题</th>
                                        <th><input type="text" name="titles[<?php echo $n;?>]" class="form-control" value="<?php echo $rs['Title'];?>"></th>
                                    </tr>
                                    <tr>
                                        <th>描述</th>
                                        <th><input type="text" name="des[<?php echo $n;?>]" class="form-control" value="<?php echo $rs['Description'];?>"></th>
                                    </tr>
                                    <tr>
                                        <th>图片A</th>
                                        <th><div class="input-group"><?php echo WUZHI_form::attachment('','1','PicUrl['.$n.'][1]',$rs['PicUrl'][1]);?></div></th>
                                    </tr>
                                    <tr>
                                        <th>图片B</th>
                                        <th><div class="input-group"><?php echo WUZHI_form::attachment('','1','PicUrl['.$n.'][2]',$rs['PicUrl'][2]);?></div></th>
                                    </tr>
                                    <tr>
                                        <th>图片C</th>
                                        <th><div class="input-group"><?php echo WUZHI_form::attachment('','1','PicUrl['.$n.'][3]',$rs['PicUrl'][3]);?></div></th>
                                    </tr>
                                    <tr>
                                        <th>链接</th>
                                        <th><input type="text" name="urls[<?php echo $n;?>]" class="form-control" value="<?php echo $rs['Url'];?>"></th>
                                    </tr>

                                </table>
                            </div>
                        </div>
<?php $n++;}?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                <input class="btn btn-info" type="submit" name="submit" value="提交">
                            </div>
                        </div>
                    </form>
                </div>

            </section>
        </div>

    </div>
    <!-- page end--><div class="alert alert-success fade in">
        <strong>使用提示:</strong> 目前自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。一级菜单最多4个汉字，二级菜单最多7个汉字，多出来的部分将会以“...”代替。请注意，创建自定义菜单后，由于微信客户端缓存，需要24小时微信客户端才会展现出来。建议测试时可以尝试取消关注公众账号后再次关注，则可以看到创建后的效果。
        更多开发规则，请参考<a href="http://mp.weixin.qq.com/wiki/13/43de8269be54a0a6f64413e4dfa94f39.html" target="_blank">《微信开发者文档》</a>
    </div>
</section>
<script>
    function set_type(type) {
        if(type==1) {
            $('.msgtype1').removeClass('hide');
            $('.msgtype0').addClass('hide');
        } else {
            $('.msgtype0').removeClass('hide');
            $('.msgtype1').addClass('hide');
        }
    }
</script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>

