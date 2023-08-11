<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
<section class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">所属组（角色）</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <?php
                    echo $form->select(key_value($roles,'role','name'), $r['role'], 'name="form[role][]" class="form-control" multiple="multiple" style="height:200px;"');
                    ?>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">管理员账号</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[username]" color="#000000" value="<?php echo $username;?>" readonly>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">密码</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[password]" value="" title="" placeholder="留空，则使用前台密码">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">真实姓名</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="form[truename]" value="<?php echo $r['truename'];?>" color="#000000" datatype="s2-30" errormsg="至少2个字符,最多20个字符！">
                </div>
            </div>
			<div class="mb-3 row">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">设置组长</label>
				<div class="col-lg-3 col-sm-4 col-xs-4">
					<?php
					$teamleader = array('--','组长','副组长');
					echo $form->select($teamleader, $r['teamleader'], 'name="form[teamleader]" class="form-select"');
					?>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">签发稿件</label>
				<div class="col-lg-3 col-sm-4 col-xs-4">
					<?php
					$qf_priv = array('无签发权限','有签发权限');

					echo $form->select($qf_priv, $r['qf_priv'], 'name="form[qf_priv]" class="form-select"');
					?>
				</div>
			</div>
            <div class="mb-3 row">
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

