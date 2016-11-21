<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
$menu_r = $this->db->get_one('menu',array('m'=>'linkage','f'=>'index','v'=>'item_listing'));
$submenuid = $menu_r['menuid'];
?>
<body class="body pxgridsbody">
<link href="<?php echo R; ?>js/jquery-ui/jquery-ui.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo R;?>js/dialog/ui-dialog.css" />

<script src="<?php echo R; ?>js/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo R; ?>js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="<?php echo R; ?>js/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
<section class="wrapper">
<div class="row">
<div class="col-lg-12">
<section class="panel">
    <?php echo $this->menu($submenuid,'&pid='.$GLOBALS['pid']);?>
    <table class="table table-striped table-advance table-hover">
        <thead>
        <tr>
            <th class="hidden-phone tablehead">修改选项</th>
        </tr>
        </thead>
    </table>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">选项名称</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 ">
                    <input type="text" class="form-control" name="form[name]" color="#000000" value="<?php echo $r['name'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">域名</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 ">
                    <input type="text" class="form-control" name="form[letter]" value="<?php echo $r['letter'];?>" placeholder="例如:bj.wuzhicms.com 只填写: bj">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 ">
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

</script>

