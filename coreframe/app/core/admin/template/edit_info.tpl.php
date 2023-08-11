<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
<div class="row">
<div class="col-lg-12">
<section class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>
 <header class="panel-heading"><span>个人信息</span></header>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">所属角色</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <?php
                    echo $form->select(key_value($roles,'role','name'), $r['role'], 'name="form[role]" class="form-select" disabled');
                    ?>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">管理员账号</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[username]" color="#000000" value="<?php echo $username;?>" readonly="readonly" />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">密码</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[password]" value="" placeholder="留空,则使用前台密码" title="" />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">真实姓名</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[truename]" value="<?php echo $r['truename'];?>" color="#000000" datatype="s2-30" errormsg="至少2个字符,最多20个字符！">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">界面语言</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <?php
                    echo $form->select($langs, $r['lang'], 'name="form[lang]" class="form-select"');
                    ?>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">部门</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[department]" value="<?php echo $r['department'];?>" color="#000000">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">头像</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[face]" value="<?php echo $r['face'];?>" color="#000000" >
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">Email</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[email]" value="<?php echo $r['email'];?>" color="#000000" >
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">电话</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[tel]" value="<?php echo $r['tel'];?>" color="#000000" >
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">手机</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[mobile]" value="<?php echo $r['mobile'];?>" color="#000000" >
                </div>
            </div>


            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">备注</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <textarea name="form[remark]" class="form-control" cols="60" rows="3"><?php echo $r['remark'];?></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
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
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3
        });
    })
</script>
<?php include $this->template('footer','core');?>

