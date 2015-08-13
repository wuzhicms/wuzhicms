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
    <header class="panel-heading"><span>基本设置</span></header>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">网站名称</label>
                <div class="col-lg-4 col-sm-6 col-xs-6 input-group pull-left">
                    <input type="text" class="form-control" name="form[sitename]" color="#000000" value="<?php echo output($setting,'sitename');?>">
                </div>
                <div class="col-sm-4 col-xs-10"><span class="help-block"><i class="icon-info-circle"></i>一般不超过80个字符</span></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">网站域名</label>
                <div class="col-lg-4 col-sm-6 col-xs-6 input-group">
                    <input type="text" class="form-control" name="weburl" color="#000000" value="<?php echo WEBURL;?>" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">网站logo</label>
                <div class="col-lg-4 col-sm-6 col-xs-6 input-group">
                    <div class="input-group"><?php echo WUZHI_form::attachment('','1','form[logo]',output($setting,'logo'));?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">SEO关键字</label>
                <div class="col-lg-4 col-sm-6 col-xs-6 input-group pull-left">
                    <input type="text" class="form-control" name="form[seo_keywords]" color="#000000" value="<?php echo output($setting,'seo_keywords');?>">
                </div>
                <div class="col-sm-4 col-xs-10"><span class="help-block"><i class="icon-info-circle"></i>一般不超过100个字符，关键词用英文逗号隔开</span></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">SEO描述</label>
                <div class="col-lg-4 col-sm-6 col-xs-6 input-group pull-left">
                    <input type="text" class="form-control" name="form[seo_description]" color="#000000" value="<?php echo output($setting,'seo_description');?>">
                </div>
                <div class="col-sm-4 col-xs-10"><span class="help-block"><i class="icon-info-circle"></i>一般不超过200个字符</span></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">版权信息</label>
                <div class="col-lg-4 col-sm-6 col-xs-6 input-group">
                    <textarea name="form[copyright]" class="form-control" cols="60" rows="3"><?php echo output($setting,'copyright');?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">访问统计代码</label>
                <div class="col-lg-4 col-sm-6 col-xs-6 input-group">
                    <textarea name="form[statcode]" class="form-control" cols="60" rows="3"><?php echo output($setting,'statcode');?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">关闭网站</label>
                <div class="col-lg-4 col-sm-6 col-xs-6 input-group">
                    <label class="radio-inline">
                        <input type="radio" name="form[close]" value="1" <?php if(output($setting,'close')) echo 'checked';?>>是
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="form[close]" value="0" <?php if(!output($setting,'close')) echo 'checked';?>>否
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">关闭原因</label>
                <div class="col-lg-4 col-sm-6 col-xs-6 input-group">
                    <textarea name="form[close_reason]" class="form-control" cols="60" rows="3"><?php echo output($setting,'close_reason');?></textarea>

                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-4 col-sm-6 col-xs-6 input-group">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                </div>
            </div>
        </form>
    </div>
</section>
</div>
</div>
<!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>

