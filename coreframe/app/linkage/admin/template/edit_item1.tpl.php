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
                <th class="hidden-phone tablehead">修改选项</th>
            </tr>
            </thead>
        </table>
        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">选项名称</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4">
                        <input type="text" class="form-control" name="form[name]" color="#000000" value="<?php echo $r['name'];?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">域名</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4">
                        <input type="text" class="form-control" name="form[letter]" value="<?php echo $r['letter'];?>" placeholder="例如:bj.wuzhicms.com 只填写: bj">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                    <div class="col-lg-3 col-sm-4 col-xs-4">
                        <input type="hidden" name="forward" value="<?php echo HTTP_REFERER;?>">
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

