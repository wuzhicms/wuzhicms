<?php
/**
 * @author     haochuan <haochuan6868@163.com>
 * @created    2020/1/13 22:17
 * @version    1.0.1
 */
?>
<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body class="body pxgridsbody">
<link href="<?php echo R;?>libs/colorpicker/style.css" rel="stylesheet">

<script src="<?php echo R;?>libs/colorpicker/color.js"></script>
<section class="wrapper">
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">认证名称</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4">
                        <input type="text" name="form[name]" id="name" maxlength="80" class="form-control" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">是否启用</label>
                    <div class="col-lg-4 col-sm-6 col-xs-6 d-flex align-items-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[status]" id="status0" value="0">
                            <label class="form-check-label" for="status0">否</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[status]" id="status1" value="1" checked>
                            <label class="form-check-label" for="status1">是</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">显示认证图标</label>
                    <div class="col-lg-4 col-sm-6 col-xs-6 d-flex align-items-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[icon_status]" id="icon_status0" value="0">
                            <label class="form-check-label" for="icon_status0">否</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[icon_status]" id="icon_status1" value="1" checked>
                            <label class="form-check-label" for="icon_status1">是</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">上传图标</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4">
                        <div class="upload-picture-card"><?php echo $form->attachment('gif|jpg|png','1','form[icon_img]','');?></div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">认证模型</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4">
                        <?php
                        echo $form->select(key_value($models,'modelid','name'), $modelid, 'name="form[modelid]" class="form-select" datatype="*" errormsg="请选择模型！"',"≡ 请选择模型 ≡");
                        ?>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                    <div class="col-lg-3 col-sm-4 col-xs-4">
                        <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- page end-->
</section>
<?php include $this->template('footer','core');?>
