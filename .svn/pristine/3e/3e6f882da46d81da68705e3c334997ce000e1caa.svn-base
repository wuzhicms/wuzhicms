<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<style type="text/css">
    .table_form td{
        padding: 10px;
    }
</style>
<section class="wrapper">
    <!-- page start-->

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>
                <div class="panel-body">
                 <form class="form-horizontal tasi-form" method="post" action="">


      <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">
          <div class="form-group">
              <label class="col-sm-2 col-xs-4 control-label">上级栏目</label>
              <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                  <?php

                  echo $form->tree_select($categorys, $pid, 'name="form[pid]" class="form-control" onchange="check_parent(this.value)"', '≡ 无上级栏目 ≡');

                  ?>
              </div>
          </div>
          <div class="form-group">
              <label class="col-sm-2 col-xs-4 control-label">栏目名称</label>
              <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                  <input type="text" class="form-control" id="name" name="catname[]" value="">
              </div>
          </div>
        <div class="form-group">
            <label class="col-sm-2 col-xs-4 control-label">链接地址</label>
            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                <input type="text" class="form-control" id="url" name="url" value="">
                <span class="help-block"><i class="icon-info-circle"></i> 格式为：http://www.wuzhicms.cn/ </span>
            </div>
        </div>


        <div class="form-group">
            <label class="col-sm-2 col-xs-4 control-label">是否在导航中显示</label>
            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
              <label class="radio-inline"><input type="radio" name="form[ismenu]" value="1" checked=""> 是</label>
              <label class="radio-inline"><input type="radio" name="form[ismenu]" value="0"> 否</label>
            </div>
        </div>
          <div class="form-group">
              <label class="col-sm-2 col-xs-4 control-label"></label>
              <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                  <input type="hidden" name="type" value="2">
                  <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
              </div>
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

</script>
