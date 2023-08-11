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
        <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>
                <div class="panel-body">
                    <form id="myform" name="myfrom" class="form-horizontal tasi-form" method="post" action="">
                        
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">共享表名</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4">
                               <input type="text" class="form-control" name="form[name]"  value="<?php echo $master_table;?>" disabled>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">模型别名</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4">
                                <input type="text" class="form-control" name="name"  value="" datatype="*2-20" errormsg="别名至少2个字符,最多20个字符！">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">数据表名</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4">
                                <input type="text" class="form-control" name="tablename" value="<?php echo $pre;?>" datatype="dbtable" errormsg="数据表名至少1个字符,最多20个字符！且必须为，数字，字母，下划线" placeholder="必须为，数字，字母，下划线">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">备注</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4">
                                <textarea name="remark" class="form-control" cols="60" rows="3"></textarea>
                            </div>
                        </div>
                        <?php
                        if($module_config['show_content_tpl']) {
                            ?>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">内容页默认模版</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4">
                                <?php echo WUZHI_form::templates('content','','name="template"  class="form-select"','show');?>
                            </div>
                        </div>
                        <?php }?>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">模型标识图（可选）</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4">
                                <div class="input-group">
                                    <input type="text" id="iconcss" name="css" class="form-control" value="">
                                    <button type="button" class="btn btn-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">选择图标 </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="javascript:s_icon('icon-file-word-o');"><i class="icon-file-word-o btn-sm"></i>图标 1</a></li>
                                        <li><a class="dropdown-item" href="javascript:s_icon('icon-file-photo-o');"><i class="icon-file-photo-o btn-sm"></i>图标 2</a></li>
                                        <li><a class="dropdown-item" href="javascript:s_icon('icon-file-zip-o');"><i class="icon-file-zip-o btn-sm"></i>图标 3</a></li>
                                        <li><a class="dropdown-item" href="javascript:s_icon('icon-file-movie-o');"><i class="icon-file-movie-o btn-sm"></i>图标 4</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">自定义后台列表模版</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4">
                                <input type="text" id="iconcss" name="manage_template" class="form-control" value="" placeholder="例如：company_listing，手动创建：company_listing.tpl.php">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                            <div class="col-lg-3 col-sm-4 col-xs-4">
                                <input type="hidden" name="forward" value="<?php echo HTTP_REFERER;?>">
                                <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                            </div>
                        </div>
                    </form>
                </div>
       </section>
    <?php
    } else {
        ?>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>

                <div class="panel-body">
                    <form class="form-horizontal tasi-form" method="post" action="">

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">模型别名</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4">
                                <input type="text" class="form-control" name="name" datatype="*2-20" errormsg="别名至少2个字符,最多20个字符！">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">数据表名</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4">
                                <input type="text" class="form-control" name="tablename" value="<?php echo $pre;?>" datatype="dbtable" errormsg="数据表名至少1个字符,最多20个字符！且必须为，数字，字母，下划线" placeholder="必须为，数字，字母，下划线">
                            </div>
                        </div>
                        <?php
                        if(!isset($module_config['attr_table']) || $module_config['attr_table']==2) {
                        ?>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">创建表数量</label>
                            <div class="col-lg-4 col-sm-4 col-xs-4 d-flex align-items-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="att" id="inlineRadio1" value="1" checked>
                                    <label class="form-check-label" for="flexRadioDefault3">1个</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="att" id="inlineRadio2" value="2">
                                    <label class="form-check-label" for="flexRadioDefault3">2个</label>
                                </div>
                                <small class="col help-block"><i class="icon-info-circle"></i>当信息量预估单表超过100万条时，建议分成2个表。</small>
                            </div>
                        </div>
                        <?php } else {?>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">创建表数量</label>
                                <div class="col-lg-3 col-sm-4 col-xs-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="att" id="inlineRadio1" value="1">
                                        <label class="form-check-label" for="flexRadioDefault3">1个</label>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">备注</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4">
                                <textarea name="remark" class="form-control" cols="60" rows="3"></textarea>
                            </div>
                        </div>
                        <?php
                        if($module_config['show_content_tpl']) {
                            ?>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">内容页默认模版</label>
                                <div class="col-lg-3 col-sm-4 col-xs-4">
                                    <div class="input-group">
                                        <input type="text" name="template" class="form-control" value="show" style="text-align: right">
                                        <span class="input-group-text">.html</span>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">自定义后台列表模版</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4">
                                <input type="text" id="iconcss" name="manage_template" class="form-control" value="" placeholder="例如：company_listing，手动创建：company_listing.tpl.php">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                            <div class="col-lg-3 col-sm-4 col-xs-4">
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
    <script type="text/javascript">
        $(function(){
            $(".form-horizontal").Validform({
                tiptype:3,
                datatype:{
                    "dbtable":/^[0-9a-z_]{1,20}$/
                }
            });
        })
        function s_icon(value) {
            $("#iconcss").val(value);
        }
    </script>
<?php include $this->template('footer','core');?>

