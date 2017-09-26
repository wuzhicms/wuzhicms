<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>

<body class="body pxgridsbody">
<section class="wrapper">
<div class="panel tasks-widget">
<header>
<?php echo $this->menu($GLOBALS['_menuid']);?>
</header>

<style>
    .watermark_pos td{border: 1px solid #e5e1dd; padding: 10px 20px;}
    .watermark_pos label{font-weight: 400;}
</style>
<div class="panel-body">
    <div class="alert alert-success fade in">
        <strong>重要提示:</strong> 上传的所有文件会后，会自动建立md5file，即，您上传重复文件不会保存多份。如果您之前开启了水印功能，现在想去除水印，那么您需要上传一张从未上传过的图片。
        您也可以手动清理索引。UPDATE `wz_attachment` SET `md5file` = ''
    </div>
        <form class="form-horizontal tasi-form" method="post" action="">

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('show_mode');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4"><label class="radio-inline"><input type="radio" name="setting[show_mode]" value="1" <?php echo $setting['show_mode'] == 1 ? 'checked' : '';?>><?php echo L('list_mode');?></label> <label class="radio-inline"><input type="radio" name="setting[show_mode]" value="2" <?php echo $setting['show_mode'] == 2 ? 'checked' : '';?>><?php echo L('thumb_mode');?></label></div>
            </div>
			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">水印设置</label>
                <div class="col-lg-3 col-sm-4 col-xs-4"><label class="radio-inline"><input type="radio" name="setting[watermark_enable]" value="1" <?php echo $setting['watermark_enable'] == 1 ? 'checked' : '';?>>图片水印</label> <label class="radio-inline"><input type="radio" name="setting[watermark_enable]" value="2" <?php echo $setting['watermark_enable'] == 2 ? 'checked' : '';?>>文字水印</label> <label class="radio-inline"><input type="radio" name="setting[watermark_enable]" value="0" <?php echo $setting['watermark_enable'] == 0 ? 'checked' : '';?>>关闭水印</label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">水印位置</label>
                <div class="col-lg-5 col-sm-6 col-xs-8">
                    <table class="watermark_pos">
                        <tr><td colspan="3" align="center">
                                <label><input type="radio" name="setting[watermark_pos]" value="0" <?php echo $setting['watermark_pos'] == 0 ? 'checked' : '';?>> 随机</label></td></tr>
                        <tr>
                            <td><label><input type="radio" name="setting[watermark_pos]" value="1" <?php echo $setting['watermark_pos'] == 1 ? 'checked' : '';?>> 顶端居左</label></td>
                            <td><label><input type="radio" name="setting[watermark_pos]" value="2" <?php echo $setting['watermark_pos'] == 2 ? 'checked' : '';?>> 顶端居中</label></td>
                            <td><label><input type="radio" name="setting[watermark_pos]" value="3" <?php echo $setting['watermark_pos'] == 3 ? 'checked' : '';?>> 顶端居右</label></td>
                        </tr>
                        <tr>
                            <td><label><input type="radio" name="setting[watermark_pos]" value="4" <?php echo $setting['watermark_pos'] == 4 ? 'checked' : '';?>> 中部居左</label></td>
                            <td><label><input type="radio" name="setting[watermark_pos]" value="5" <?php echo $setting['watermark_pos'] == 5 ? 'checked' : '';?>> 中部居中</label></td>
                            <td><label><input type="radio" name="setting[watermark_pos]" value="6" <?php echo $setting['watermark_pos'] == 6 ? 'checked' : '';?>> 中部居右</label></td>
                        </tr>
                        <tr>
                            <td><label><input type="radio" name="setting[watermark_pos]" value="7" <?php echo $setting['watermark_pos'] == 7 ? 'checked' : '';?>> 底端居左</label></td>
                            <td><label><input type="radio" name="setting[watermark_pos]" value="8" <?php echo $setting['watermark_pos'] == 8 ? 'checked' : '';?>> 底端居中</label></td>
                            <td><label><input type="radio" name="setting[watermark_pos]" value="9" <?php echo $setting['watermark_pos'] == 9 ? 'checked' : '';?>> 底端居右</label></td>
                        </tr>
                    </table>

                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">文字水印内容</label>
                <div class="col-lg-3 col-sm-4 col-xs-4"><input type="text" class="form-control " name="setting[watermark_text]" value="<?php echo output($setting,'watermark_text');?>"></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">文字水印字体文件</label>
                <div class="col-lg-3 col-sm-4 col-xs-4"><label class="control-label">/coreframe/app/core/libs/fonts/watermark.ttf
                <?php if(!file_exists(COREFRAME_ROOT.'app/core/libs/fonts/watermark.ttf')) echo '<br><font color="red">字体文件不存在,请上传,或者使用图片水印</font> ';?></label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">图片水印文件地址</label>
                <div class="col-lg-3 col-sm-4 col-xs-4"><label class="control-label">/res/images/watermark.png
                    <?php if(!file_exists(WWW_ROOT.'res/images/watermark.png')) echo '<br><font color="red">图片水印文件不存在,请上传</font> ';?></label></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="<?php echo L('dosubmit');?>">
                </div>
            </div>

        </form>
    </div>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>