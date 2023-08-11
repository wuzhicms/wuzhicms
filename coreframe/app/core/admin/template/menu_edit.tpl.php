<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <!-- page start-->
    <?php
    if($readonly) {
        ?>
        <div class="alert alert-block alert-danger fade in">
            <strong>语言包文件只读：</strong> languages/zh-cn/admin_menu.lang.php
        </div>
    <?php }?>
    <section class="panel">
        <header class="panel-heading"><span>修改菜单</span></header>
        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">上级菜单</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <?php
                        echo '<input type="hidden" class="form-control" name="form[pid]" value="'.$r['pid'].'"><input class="form-control" type="text" value="'.$parentname.'" readonly>'
                        ?>
                        
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">菜单中文名</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[name]" value="<?php echo $r['name'];?>" color="#000000">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">模块名</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[m]" value="<?php echo $r['m'];?>" title="模块英文名">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">文件名</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[f]" value="<?php echo $r['f'];?>" title="文件名">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">方法名</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[v]" value="<?php echo $r['v'];?>" title="视图：方法名">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">附加参数</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[data]" value="<?php echo $r['data'];?>">
                        <span class="help-block">例如：type=1&flag=open</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                    <div class="col-lg-4 col-sm-6 col-xs-6 d-flex align-items-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[display]" id="display1" value="1" <?php if($r['display']==1) echo 'checked';?>>
                            <label class="form-check-label" for="display1">显示</label>
                        </div>
                        <?php if($r['pid']) {?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[display]" id="display0" value="0" <?php if($r['display']==0) echo 'checked';?>>
                            <label class="form-check-label" for="display0">隐藏</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[display]" id="display2" value="2" <?php if($r['display']==2) echo 'checked';?>>
                            <label class="form-check-label" for="display2">特殊菜单</label>
                        </div>
                        <?php }?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="hidden" name="forward" value="<?php echo HTTP_REFERER;?>">
                        <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                    </div>
                </div>

                <input type="hidden" name="forward" value="<?php echo HTTP_REFERER?>">
                <input type="hidden" name="id" value="<?php echo $r['menuid'];?>">
            </form>
        </div>
    </section>

    <!-- page end-->
</section>
<?php include $this->template('footer','core');?>