<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <?php echo $this->menu($GLOBALS['_menuid']);?>

                    <div class="panel-body">
                        <form id="myform" name="myfrom" class="form-horizontal tasi-form" method="post" action="">


                            <div class="form-group">
                                <label class="col-sm-2 col-xs-4 control-label">模型别名</label>
                                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                    <input type="text" class="form-control" name="name"  value="<?php echo $r['name'];?>" datatype="s2-20" errormsg="别名至少2个字符,最多20个字符！">
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-xs-4 control-label">主表</label>
                                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                    <input type="text" class="form-control"  value="<?php echo $r['master_table'];?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-xs-4 control-label">附属表</label>
                                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                    <input type="text" class="form-control" value="<?php echo $r['attr_table'];?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-xs-4 control-label">备注</label>
                                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                    <textarea name="remark" class="form-control" cols="60" rows="3"><?php echo p_htmlentities($r['remark']);?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-xs-4 control-label">内容页默认模版</label>
                                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                   <?php echo WUZHI_form::templates('content',$r['template'],'name="template"  class="form-control" style="width:auto;"','show');?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-xs-4 control-label">模型标识图（可选）</label>
                                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                    <input type="text" id="iconcss" name="css" class="form-control" value="<?php echo $r['css'];?>">
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

