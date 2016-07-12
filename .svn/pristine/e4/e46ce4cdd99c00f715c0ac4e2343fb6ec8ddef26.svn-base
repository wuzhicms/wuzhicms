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
                    <span>修改菜单</span>
                </header>
                <div class="panel-body">
                    <form class="form-horizontal tasi-form" method="post" action="">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">上级菜单</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <?php
                                echo '<input type="hidden" name="form[pid]" value="'.$r['pid'].'">'.$parentname;
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">菜单中文名</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="form[name]" value="<?php echo $r['name'];?>" color="#000000">
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
                                <input type="text" class="form-control" name="form[v]" value="<?php echo $r['v'];?>" title="视图：方法名">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">附加参数</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="form[data]" value="<?php echo $r['data'];?>">
                                <span class="help-block">例如：type=1&flag=open</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label"></label>
                            <div class="col-lg-4 col-sm-6 col-xs-6 input-group">
                                <div class="radioscross">
                                    <label class="label_radio" for="radio-01">
                                        <input name="form[display]" id="radio-01" value="1" type="radio" <?php if($r['display']==1) echo 'checked';?> /> 显示
                                    </label>
                                    <?php if($r['pid']) {?>
                                    <label class="label_radio" for="radio-02">
                                        <input name="form[display]" id="radio-02" value="0" type="radio" <?php if($r['display']==0) echo 'checked';?> /> 隐藏
                                    </label>

                                    <label class="label_radio" for="radio-03">
                                        <input name="form[display]" id="radio-03" value="2" type="radio" <?php if($r['display']==2) echo 'checked';?>/> 特殊菜单
                                    </label>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label"></label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="hidden" name="forward" value="<?php echo HTTP_REFERER;?>">
                                <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                            </div>
                        </div>

                        <input type="hidden" name="forward" value="<?php echo HTTP_REFERER?>">
                        <input type="hidden" name="id" value="<?php echo $r['menuid'];?>">
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
