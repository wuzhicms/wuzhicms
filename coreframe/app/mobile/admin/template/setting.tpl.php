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
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">开启手机适配网站</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <label class="radio-inline">
                                    <input type="radio" name="support_mobile" value="1" <?php if(SUPPORT_MOBILE) echo 'checked';?>>是
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="support_mobile" value="0" <?php if(!SUPPORT_MOBILE) echo 'checked';?>>否
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">手机网站名称</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="form[sitename]" color="#000000" value="<?php echo output($setting,'sitename');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">网站域名</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="weburl" color="#000000" value="<?php echo WEBURL;?>index.php" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">二维码访问</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <?php if($iswrite) {?>
<img src="<?php echo ATTACHMENT_URL.'qr_image/mobile.png';?>">
                                <?php } else {
                                    echo '请设置图片为可写：'.str_replace(WWW_ROOT,'',ATTACHMENT_ROOT)."qr_image/mobile.png";
                                }?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">手机网站logo</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="form[logo]" color="#000000" value="<?php echo output($setting,'logo');?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">SEO关键字</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="form[seo_keyword]" color="#000000" value="<?php echo output($setting,'seo_keyword');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">SEO描述</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="form[seo_description]" color="#000000" value="<?php echo output($setting,'seo_description');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">版权信息</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <textarea name="form[copyright]" class="form-control" cols="60" rows="3"><?php echo output($setting,'copyright');?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                        <label class="col-sm-2 col-xs-4 control-label"></label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                            </div>
                        </div>

                    </form>
                </div>

            </section>
        </div>

    </div>
    <!-- page end--><div class="alert alert-success fade in">
        <strong>使用提示:</strong> 手机访问内容通过手机模版来呈现。只有在使用伪静态或者动态地址时，可自动识别。如果生成静态，则需要通过js代码来判断，实现跳转！
    </div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>

