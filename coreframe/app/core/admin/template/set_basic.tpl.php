<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<style>
    .transparent img{background-color: #0093D8;}
</style>
<section class="wrapper">
<section class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>
    <header class="panel-heading"><span>【<?php echo $r['name'];?>】基本设置</span></header>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">SEO标题</label>
                <div class="col-lg-4 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" name="form[sitename]" color="#000000" value="<?php echo output($setting,'sitename');?>">
                </div>
                <div class="col-sm-4 col-xs-10"><span class="help-block"><i class="icon-info-circle"></i>一般不超过80个字符</span></div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">SEO关键字</label>
                <div class="col-lg-4 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" name="form[seo_keywords]" color="#000000" value="<?php echo output($setting,'seo_keywords');?>">
                </div>
                <div class="col-sm-4 col-xs-10"><span class="help-block"><i class="icon-info-circle"></i>一般不超过100个字符，关键词用英文逗号隔开</span></div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">SEO描述</label>
                <div class="col-lg-4 col-sm-6 col-xs-6">
                    <textarea name="form[seo_description]" class="form-control" cols="60" rows="3"><?php echo output($setting,'seo_description');?></textarea>
                </div>
                <div class="col-sm-4 col-xs-10"><span class="help-block"><i class="icon-info-circle"></i>一般不超过200个字符</span></div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">网站域名</label>
                <div class="col-lg-4 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" name="weburl" color="#000000" value="<?php echo $r['url'];?>" readonly>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">网站logo</label>
                <div class="col-lg-4 col-sm-6 col-xs-6">
                    <div class="upload-picture-card"><?php echo WUZHI_form::attachment('','1','form[logo]',output($setting,'logo'));?></div>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">透明logo</label>
                <div class="col-lg-4 col-sm-6 col-xs-6">
                    <div class="upload-picture-card transparent"><?php echo WUZHI_form::attachment('','1','form[logo2]',output($setting,'logo2'));?></div>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">版权信息</label>
                <div class="col-lg-4 col-sm-6 col-xs-6">
                    <textarea name="form[copyright]" class="form-control" cols="60" rows="3"><?php echo output($setting,'copyright');?></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">访问统计代码</label>
                <div class="col-lg-4 col-sm-6 col-xs-6">
                    <textarea name="form[statcode]" class="form-control" cols="60" rows="3"><?php echo output($setting,'statcode');?></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">栏目访问权限和内容访问权限-提醒模式</label>
                <div class="col-lg-6 col-sm-6 col-xs-6 d-flex align-items-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="form[access_authority]" id="flexRadioDefault0" value="0" <?php if(!output($setting,'access_authority')) echo 'checked';?>>
                        <label class="form-check-label" for="flexRadioDefault0">系统模式（直接退出）</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="form[access_authority]" id="flexRadioDefault1" value="1" <?php if(!output($setting,'access_authority')) echo 'checked';?>>
                        <label class="form-check-label" for="flexRadioDefault1">手动模式（在模版中添加要隐藏的内容）<i class="icon-info-circle"></i><a href="https://www.wuzhicms.com/item-34-70-1.html" target="_blank"> 在线查看帮助</a></label>
                    </div>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">关闭网站</label>
                <div class="col-lg-4 col-sm-6 col-xs-6 d-flex align-items-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="form[close]" id="flexRadioDefault3" value="1" <?php if(!output($setting,'close')) echo 'checked';?>>
                        <label class="form-check-label" for="flexRadioDefault3">是</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="form[close]" id="flexRadioDefault4" value="0" <?php if(!output($setting,'close')) echo 'checked';?>>
                        <label class="form-check-label" for="flexRadioDefault4">否</label>
                    </div>
                </div>
            </div>


            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">关闭原因</label>
                <div class="col-lg-4 col-sm-6 col-xs-6">
                    <textarea name="form[close_reason]" class="form-control" cols="60" rows="3"><?php echo output($setting,'close_reason');?></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                <div class="col-lg-4 col-sm-6 col-xs-6">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                </div>
            </div>
        </form>
    </div>
</section>
<!-- page end-->
</section>
<?php include $this->template('footer','core');?>

