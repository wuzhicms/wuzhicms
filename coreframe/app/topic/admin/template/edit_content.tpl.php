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
                        <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">所属分类</label>
                        <div class="col-3">
                            <?php
                            echo $form->select($options, $data['kid2'], 'name="form[kid2]" class="form-control"');
                            ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">标题</label>
                        <div class="col-3">
                            <input type="text" class="form-control" name="form[title]" datatype="*2-200" errormsg="名称至少2个字符,最多200个字符！" value="<?php echo $data['title'];?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">缩略图</label>
                        <div class="col-3">
                            <div class="upload-picture-card"><?php echo $form->attachment('','1','form[thumb]',$data['thumb']);?></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">描述</label>
                        <div class="col-lg-8 col-sm-8 col-xs-8 input-group">
                            <textarea name="form[remark]" class="form-control" cols="60" rows="5"><?php echo $data['remark'];?></textarea>    </div>
                    </div>
					<div class="row mb-3">
						<label class="col-sm-2 col-xs-4 control-label col-form-label text-end">正文</label>
						<div class="col-6">
							<?php
							echo WUZHI_form::editor('form[content]','content',$data['content'],'basic');?>
						</div>
					</div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">发布状态</label>
                        <div class="col-3 d-flex align-items-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="form[status]" id="flexRadioDefault9" value="9" <?php if($data['status']==9) echo 'checked';?>>
                                <label class="form-check-label" for="flexRadioDefault9">已发布</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="form[status]" id="flexRadioDefault1" value="1" <?php if($data['status']==1) echo 'checked';?>>
                                <label class="form-check-label" for="flexRadioDefault1">待审核</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-xs-4 control-label col-form-label text-end"></label>
                        <div class="col-3">
                           <input type="hidden" name="form[kid1]" value="<?php echo $kid1;?>">
                           <input type="hidden" name="forward" value="<?php echo HTTP_REFERER;?>">
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