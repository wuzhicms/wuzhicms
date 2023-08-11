<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
$menu_r = $this->db->get_one('menu',array('m'=>'topic','f'=>'index','v'=>'list_manage'));
$submenuid = $menu_r['menuid'];
?>
<body>
<section class="wrapper">
    <!-- page start-->
    <section class="panel">
        <?php echo $this->menu($submenuid,'&tid='.$tid);?>
        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="row mb-3">
                    <label class="col-2 control-label col-form-label">所属分类</label>
                    <div class="col-3">
                        <?php
                        echo $form->select($options, 1, 'name="form[kid2]" class="form-select"');
                        ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-2 control-label col-form-label">标题</label>
                    <div class="col-3">
                        <input type="text" class="form-control" name="form[title]" datatype="*2-200" errormsg="名称至少2个字符,最多200个字符！"></div>
                </div>
                <div class="row mb-3">
                    <label class="col-2 control-label col-form-label">缩略图</label>
                    <div class="col-3">
                        <div class="upload-picture-card"><?php echo $form->attachment('','1','form[thumb]','');?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-2 control-label col-form-label">描述</label>
                    <div class="col-3">
                        <textarea name="form[remark]" class="form-control" cols="60" rows="5"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-2 control-label col-form-label">正文</label>
                    <div class="col-6">
                        <?php
                        echo WUZHI_form::editor('form[content]','content','','basic');?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-2 control-label col-form-label">发布状态</label>
                    <div class="col-3 d-flex align-items-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[status]" id="flexRadioDefault9" value="9" <?php if($data['status']==9) echo 'checked';?>>
                            <label class="form-check-label" for="flexRadioDefault9">已发布</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[status]" id="flexRadioDefault1" value="1" checked>
                            <label class="form-check-label" for="flexRadioDefault1">待审核</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-2 control-label col-form-label"></label>
                    <div class="col-3">
                       <input type="hidden" name="form[kid1]" value="<?php echo $kid1;?>">
                        <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="添加内容">
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
    function edit(kid){
        top.openiframe('index.php?m=core&f=kind&v=edit&kid='+kid+'<?php echo $this->su();?>', 'edit', '编辑分类', 500, 300);
    }
</script>
<?php include $this->template('footer','core');?>

