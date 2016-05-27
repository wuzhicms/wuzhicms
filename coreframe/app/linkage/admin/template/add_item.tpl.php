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
            <th class="hidden-phone tablehead">添加选项</th>
        </tr>
        </thead>
    </table>

    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">所属上级</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 ">
                    <input type="text" class="form-control" name="form[pid]" color="#000000" value="<?php echo $r['name'];?>" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">选项名称</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 ">
                    <textarea name="form[names]" class="form-control" cols="60" rows="3" placeholder="一行一个选项"></textarea>                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">描述</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 ">
                    <textarea name="form[remark]" class="form-control" cols="60" rows="3"></textarea>                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label ">缩略图</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <div class="input-group"><?php echo WUZHI_form::attachment('','1','form[thumb]',$r['thumb']);?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label ">更多图片</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <div class="input-group"><?php echo $pictures;?></div>
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

