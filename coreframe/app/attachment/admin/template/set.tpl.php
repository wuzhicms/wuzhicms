<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
<div class="panel tasks-widget">
    <header>
    <?php echo $this->menu($GLOBALS['_menuid']);?>
    </header>
<div class="panel-body">
    <div class="alert alert-warning">
        <strong>重要提示:</strong> 上传的所有文件会后，会自动建立md5file，即，您上传重复文件不会保存多份。如果您之前开启了水印功能，现在想去除水印，那么您需要上传一张从未上传过的图片。
        您也可以手动清理索引。UPDATE `wz_attachment` SET `md5file` = ''
    </div>
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end">是否开启远程附件</label>
                <div class="col-5 d-flex align-items-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="setting[ftp]" id="ftp1" value="1" <?php echo $setting['ftp'] == 1 ? 'checked' : '';?>>
                        <label class="form-check-label" for="ftp1">是</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="setting[ftp]" id="ftp0" value="0" <?php echo $setting['ftp'] == 0 ? 'checked' : '';?>>
                        <label class="form-check-label" for="ftp0">否</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end"><?php echo L('show_mode');?></label>
                <div class="col-5 d-flex align-items-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="setting[show_mode]" id="show_mode1" value="1" <?php echo $setting['show_mode'] == 1 ? 'checked' : '';?>>
                        <label class="form-check-label" for="show_mode1"><?php echo L('list_mode');?></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="setting[show_mode]" id="show_mode2" value="2" <?php echo $setting['show_mode'] == 2 ? 'checked' : '';?>>
                        <label class="form-check-label" for="show_mode2"><?php echo L('thumb_mode');?></label>
                    </div>
                </div>
            </div>
			<div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end">水印设置</label>
                <div class="col-5 d-flex align-items-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="setting[watermark_enable]" id="watermark1" value="1" <?php echo $setting['watermark_enable'] == 1 ? 'checked' : '';?>>
                        <label class="form-check-label" for="watermark1">图片水印</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="setting[watermark_enable]" id="watermark2" value="2" <?php echo $setting['watermark_enable'] == 2 ? 'checked' : '';?>>
                        <label class="form-check-label" for="watermark2">文字水印</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="setting[watermark_enable]" id="watermark0" value="0" <?php echo $setting['watermark_enable'] ==0 ? 'checked' : '';?>>
                        <label class="form-check-label" for="watermark0">关闭水印</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end">水印位置</label>
                <div class="col-5">
                    <table class="table table-striped table-bordered table-hover">
                        <tr><td colspan="3" align="center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="setting[watermark_pos]" id="watermark_pos0" value="0" <?php echo $setting['watermark_pos'] ==0 ? 'checked' : '';?>>
                                    <label class="form-check-label" for="watermark_pos0">随机</label>
                                </div>
                            </td></tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="setting[watermark_pos]" id="watermark_pos1" value="1" <?php echo $setting['watermark_pos'] ==1 ? 'checked' : '';?>>
                                    <label class="form-check-label" for="watermark_pos1">顶端居左</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="setting[watermark_pos]" id="watermark_pos2" value="2" <?php echo $setting['watermark_pos'] ==2 ? 'checked' : '';?>>
                                    <label class="form-check-label" for="watermark_pos2">顶端居中</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="setting[watermark_pos]" id="watermark_pos3" value="3" <?php echo $setting['watermark_pos'] ==3 ? 'checked' : '';?>>
                                    <label class="form-check-label" for="watermark_pos3">顶端居右</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="setting[watermark_pos]" id="watermark_pos4" value="4" <?php echo $setting['watermark_pos'] ==4 ? 'checked' : '';?>>
                                    <label class="form-check-label" for="watermark_pos4">中部居左</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="setting[watermark_pos]" id="watermark_pos5" value="5" <?php echo $setting['watermark_pos'] ==5 ? 'checked' : '';?>>
                                    <label class="form-check-label" for="watermark_pos5">中部居中</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="setting[watermark_pos]" id="watermark_pos6" value="6" <?php echo $setting['watermark_pos'] ==6 ? 'checked' : '';?>>
                                    <label class="form-check-label" for="watermark_pos6">中部居右</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="setting[watermark_pos]" id="watermark_pos7" value="7" <?php echo $setting['watermark_pos'] ==7 ? 'checked' : '';?>>
                                    <label class="form-check-label" for="watermark_pos7">底端居左</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="setting[watermark_pos]" id="watermark_pos8" value="8" <?php echo $setting['watermark_pos'] ==8 ? 'checked' : '';?>>
                                    <label class="form-check-label" for="watermark_pos8">底端居中</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="setting[watermark_pos]" id="watermark_pos9" value="9" <?php echo $setting['watermark_pos'] ==9 ? 'checked' : '';?>>
                                    <label class="form-check-label" for="watermark_pos9">底端居右</label>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end">文字水印内容</label>
                <div class="col-3"><input type="text" class="form-control " name="setting[watermark_text]" value="<?php echo output($setting,'watermark_text');?>"></div>
            </div>
            <div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end">文字水印字体文件</label>
                <div class="col-3"><label class="control-label">/coreframe/app/core/libs/fonts/watermark.ttf
                <?php if(!file_exists(COREFRAME_ROOT.'app/core/libs/fonts/watermark.ttf')) echo '<br><font color="red">字体文件不存在,请上传,或者使用图片水印</font> ';?></label></div>
            </div>
            <div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end">图片水印文件地址</label>
                <div class="col-3"><label class="control-label">/res/images/watermark.png
                    <?php if(!file_exists(WWW_ROOT.'res/images/watermark.png')) echo '<br><font color="red">图片水印文件不存在,请上传</font> ';?></label></div>
            </div>
            <div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end"></label>
                <div class="col-3">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="<?php echo L('dosubmit');?>">
                </div>
            </div>
        </form>
    </div>
<?php include $this->template('footer','core');?>
