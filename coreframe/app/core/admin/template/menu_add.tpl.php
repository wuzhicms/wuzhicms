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
    <header class="panel-heading"><span>添加菜单</span></header>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">上级菜单</label>
                <div class="col-lg-3 col-sm-6 col-xs-6">
                    <?php
                    if($pid) {
                        echo '<input type="hidden" name="form[pid]" value="'.$pid.'"><input class="form-control" id="disabledInput" type="text" placeholder="'.$parentname.'" disabled>';
                    } else {
                        echo $form->select(key_value($menus,'menuid','name'), 0, 'name="form[pid]" class="form-select m-bot15"', '≡ 请选择上级菜单 ≡');
                    }
                    ?>

                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">菜单中文名</label>
                <div class="col-lg-3 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" name="form[name]" color="#000000">
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
                    <input type="text" class="form-control" name="form[v]" value="" title="视图：方法名">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">附加参数</label>
                <div class="col-lg-3 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" name="form[data]">
                    <span class="help-block">例如：type=1&flag=open</span>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                <div class="col-lg-4 col-sm-6 col-xs-6 d-flex align-items-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[display]" id="display1" value="1" checked>
                            <label class="form-check-label" for="display1">显示</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[display]" id="display0" value="0">
                            <label class="form-check-label" for="display0">隐藏</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[display]" id="display2" value="2">
                            <label class="form-check-label" for="display2">特殊菜单</label>
                        </div>
                    </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                <div class="col-lg-3 col-sm-6 col-xs-6">
                    <div class="d-flex">
                        <input class="btn btn-info w-50 me-2" type="submit" name="submit" value="提交">
                        <input class="btn btn-info w-50 ms-2" type="submit" name="submit2" value="提交后继续添加">
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- page end-->
</section>
<?php include $this->template('footer','core');?>
