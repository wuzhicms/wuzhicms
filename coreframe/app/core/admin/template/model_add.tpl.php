<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
    <section class="wrapper">

<?php
if($share_model) {
    ?>
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <?php echo $this->menu($GLOBALS['_menuid']);?>

                    <div class="panel-body">
                        <form id="myform" name="myfrom" class="form-horizontal tasi-form" method="post" action="">

                            <div class="form-group">
                                <label class="col-sm-2 col-xs-4 control-label">共享表名</label>
                                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                   <input type="text" class="form-control" name="form[name]"  value="<?php echo $master_table;?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-xs-4 control-label">模型别名</label>
                                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                    <input type="text" class="form-control" name="name"  value="" datatype="s2-20" errormsg="别名至少2个字符,最多20个字符！">
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-xs-4 control-label">数据表名</label>
                                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                    <input type="text" class="form-control" name="tablename"  value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-xs-4 control-label">备注</label>
                                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                    <textarea name="remark" class="form-control" cols="60" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-xs-4 control-label">内容页默认模版</label>
                                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                    <?php echo WUZHI_form::templates('content','','name="template"  class="form-control" style="width:auto;"','show');?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-xs-4 control-label">模型标识图（可选）</label>
                                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                    <input type="text" id="iconcss" name="css" class="form-control" value="">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown">选择图标 <span class="caret"></span></button>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a href="javascript:s_icon('icon-file-word-o');"><i class="icon-file-word-o btn-sm"></i>图标 1</a></li>
                                            <li><a href="javascript:s_icon('icon-file-photo-o');"><i class="icon-file-photo-o btn-sm"></i>图标 2</a></li>
                                            <li><a href="javascript:s_icon('icon-file-zip-o');"><i class="icon-file-zip-o btn-sm"></i>图标 3</a></li>
                                            <li><a href="javascript:s_icon('icon-file-movie-o');"><i class="icon-file-movie-o btn-sm"></i>图标 4</a></li>
                                        </ul>
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
                        </form>
                    </div>
                </section>
            </div>
        </div>
<?php
} else {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>

                <div class="panel-body">
                    <form class="form-horizontal tasi-form" method="post" action="">

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">模型别名</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="name" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">数据表名</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="tablename" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">创建表数量</label>

                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                            <label class="radio-inline">
                            <input type="radio" name="att" id="inlineRadio1" value="1" > 1个
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="att" id="inlineRadio2" value="2" checked> 2个
                            </label>
                            <span class="help-block">当信息量预估单表超过100万条时，建议分成2个表。</span>  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">备注</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <textarea name="remark" class="form-control" cols="60" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">内容页默认模版</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" name="template" class="form-control" value="show" style="text-align: right">
                                <span class="input-group-addon">.html</span>
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
<?php
}?>
    <!-- page end-->
    </section>

<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>

    <script type="text/javascript">
        $(function(){
            $(".form-horizontal").Validform({
                tiptype:3
            });
        })
        function s_icon(value) {
            $("#iconcss").val(value);
        }
    </script>

