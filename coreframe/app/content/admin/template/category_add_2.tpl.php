<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<section class="wrapper">
    <!-- page start-->
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <div class="panel-body">
         <form class="form-horizontal tasi-form" method="post" action="">
            <div class="row mb-3">
              <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">上级栏目</label>
              <div class="col-3">
                  <?php
                  echo $form->tree_select($categorys, $pid, 'name="form[pid]" class="form-select" onchange="check_parent(this.value)"', '≡ 无上级栏目 ≡');
                  ?>
              </div>
          </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">栏目名称</label>
              <div class="col-3">
                  <input type="text" class="form-control" id="name" name="catname[]" value="">
              </div>
          </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">链接地址</label>
                <div class="col-3">
                    <input type="text" class="form-control" id="url" name="url" value="">
                </div>
                <div class="col"><small class="help-block"><i class="icon-info-circle"></i>格式为：http://www.wuzhicms.com/ </small></div>
        </div>
            <div class="row mb-3">
            <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">是否在导航中显示</label>
            <div class="col-3">
                <div class="col-auto d-flex align-items-center pt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="form[ismenu]" id="ismenu1" value="1" checked="">
                        <label class="form-check-label" for="ismenu1">是</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="form[ismenu]" id="ismenu0" value="0">
                        <label class="form-check-label" for="ismenu0">否 </label>
                    </div>
                </div>
            </div>
        </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-xs-4 control-label col-form-label text-end"></label>
              <div class="col-3">
                  <input type="hidden" name="type" value="2">
                  <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
              </div>
          </div>
         </form>
        </div>
    </section>
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
