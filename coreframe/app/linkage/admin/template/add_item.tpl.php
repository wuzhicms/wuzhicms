<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
$menu_r = $this->db->get_one('menu',array('m'=>'linkage','f'=>'index','v'=>'item_listing'));
$submenuid = $menu_r['menuid'];
?>
<body>
<section class="wrapper">
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
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">所属上级</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[pid]" color="#000000" value="<?php echo $r['name'];?>" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">选项名称</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <textarea name="form[names]" class="form-control" cols="60" rows="3" placeholder="一行一个选项"></textarea>                </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">描述</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <textarea name="form[remark]" class="form-control" cols="60" rows="3"></textarea>                </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end ">缩略图</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4">
                        <div class="upload-picture-card"><?php echo WUZHI_form::attachment('','1','form[thumb]',$r['thumb']);?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">更多图片</label>
                    <div class="col-10">
                        <div class="upload-list-picture-card"><?php echo $pictures;?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                    </div>
                </div>
            </form>
        </div>
    </section>
<!-- page end-->
</section>
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3
        });
    })
</script>
<?php include $this->template('footer','core');?>
