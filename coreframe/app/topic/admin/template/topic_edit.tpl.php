<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>

<section class="wrapper">
    <!-- page start-->
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">所属分类</label>
                <div class="col-3">
                    <?php
                    echo $form->select($options, $data['kid'], 'name="form[kid]" class="form-select"');
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">专题名称</label>
                <div class="col-3">
                    <input type="text" class="form-control" name="form[name]" datatype="*2-200" errormsg="名称至少2个字符,最多200个字符！" value="<?php echo $data['name'];?>"></div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">缩略图</label>
                <div class="col-3">
                    <div class="upload-picture-card"><?php echo $form->attachment('','1','form[thumb]',$data['thumb']);?></div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">Banner</label>
                <div class="col-3">
                    <div class="upload-picture-card"><?php echo $form->attachment('','1','form[banner]',$data['banner']);?></div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">组图</label>
                <div class="col-10">
                    <div class="upload-list-picture-card"><?php echo $field_images;?></div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">专题描述</label>
                <div class="col-3">
                    <textarea name="form[remark]" class="form-control" cols="60" rows="5"><?php echo $data['remark'];?></textarea>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">专题页模版</label>
                <div class="col-3">
                    <?php
                    echo $form->templates('topic', $data['index_template'],'name="form[index_template]" class="form-select"','index');
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">专题子分类模版</label>
                <div class="col-3">
                    <?php
                    echo $form->templates('topic', $data['list_template'],'name="form[list_template]" class="form-select"','list');
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">专题页内容页模版</label>
                <div class="col-3">
                    <?php
                    echo $form->templates('topic', $data['show_template'],'name="form[show_template]" class="form-select"','show');
                    ?>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">选择风格（可选）</label>
                <div class="col-3">
                    <?php
                    echo $form->select($style_options, $data['styleid'], 'name="form[styleid]" class="form-select"','--');
                    ?>
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
                        <label class="form-check-label" for="flexRadioDefault1">未发布</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">更新状态</label>
                <div class="col-3 d-flex align-items-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="form[upgrade_status]" id="upgrade_status9" value="9" <?php if($data['upgrade_status']==9) echo 'checked';?>>
                        <label class="form-check-label" for="upgrade_status9">长期更新</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="form[upgrade_status]" id="upgrade_status1" value="0" <?php if($data['upgrade_status']==0) echo 'checked';?>>
                        <label class="form-check-label" for="upgrade_status1">停止更新</label>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end"></label>
                <div class="col-3">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="更新">
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

