<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
<!-- page start-->
    <?php
    if($readonly) {
    ?>
    <div class="alert alert-block alert-danger fade in">
        <strong>语言包文件只读：</strong> languages/zh-cn/admin_menu.lang.php
    </div>
    <?php }?>
<div class="row">
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading">
        <span>添加菜单</span>
    </header>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">上级菜单</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <?php
                    if($pid) {
                        echo '<input type="hidden" name="form[pid]" value="'.$pid.'"><input class="form-control" id="disabledInput" type="text" placeholder="'.$parentname.'" disabled>';
                    } else {
                        echo $form->select(key_value($menus,'menuid','name'), 0, 'name="form[pid]" class="form-control m-bot15"', '≡ 请选择上级菜单 ≡');
                    }
                    ?>

                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">菜单中文名</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[name]" color="#000000">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">模块名</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[m]" value="<?php echo $r['m'];?>" title="模块英文名">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">文件名</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[f]" value="<?php echo $r['f'];?>" title="文件名">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">方法名</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[v]" value="" title="视图：方法名">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">附加参数</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[data]">
                    <span class="help-block">例如：type=1&flag=open</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-4 col-sm-6 col-xs-6 input-group">
                    <div class="radioscross">
                        <label for="radio-01">
                            <input name="form[display]" id="radio-01" value="1" type="radio" checked /> 显示
                        </label>
                        <label for="radio-02">
                            <input name="form[display]" id="radio-02" value="0" type="radio" /> 隐藏
                        </label>
                        <label for="radio-03">
                            <input name="form[display]" id="radio-03" value="2" type="radio" /> 特殊菜单
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">使用云端ID</label>
                <div class="col-lg-4 col-sm-6 col-xs-6 input-group">
                    <label style="padding-right: 15px;"><input name="isopenid" type="radio" value="1"> 是</label> （如果需要对外发布该内容，请选择该项，<a href="?m=core&amp;f=set&amp;v=safe&amp;_su=wuzhicms&amp;_menuid=57&amp;_submenuid=94">配置安全识别码</a>）
                    <label style="padding-right: 15px;"><input name="isopenid" type="radio" value="0" checked=""> 否 </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <div class="col-lg-1 col-sm-1 col-xs-1 input-group pull-left">
                        <input class="btn btn-info" type="submit" name="submit" value="提交">
                    </div>
                    <div class="col-lg-1 col-sm-3 col-xs-3">
                        <input class="btn btn-info" type="submit" name="submit2" value="提交后继续添加">
                    </div>
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

<script src="<?php echo R;?>js/bootstrap-switch.js"></script>
<script src="<?php echo R;?>js/jquery.tagsinput.js"></script>
<script src="<?php echo R;?>js/pxform.js"></script>

