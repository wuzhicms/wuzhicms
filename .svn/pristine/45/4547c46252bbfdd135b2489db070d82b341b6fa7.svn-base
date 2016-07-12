<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body id="body" style="overflow-y :scroll;overflow-x:auto;">
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<section class="panel">
	<div class="panel-body">
		<form id="myform" name="myfrom" class="form-horizontal tasi-form" method="post" action="">
			<div class="form-group">
				<label class="col-sm-2 control-label">用户名</label>
				<div class="col-sm-4 input-group"><input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $member['username']?>" disabled=""></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">邮箱</label>
				<div class="col-sm-4 input-group"><input type="text" name="info[email]" class="form-control" value="<?php echo $member['email'];?>" datatype="e" errormsg="请输入正确的Email" sucmsg="OK" ajaxurl="index.php?m=member&f=index&v=public_check_email&uid=<?php echo $uid;?>" /></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">手机</label>
				<div class="col-sm-4 input-group"><input type="text" name="info[mobile]" class="form-control" value="<?php echo $member['mobile'];?>" datatype="m|*0-0" errormsg="请输入正确的手机号" sucmsg="OK" ajaxurl="index.php?m=member&f=index&v=public_check_mobile&uid=<?php echo $uid;?>" /></div>
			</div>

			
			<?php
			if(is_array($formdata['0']))
			foreach($formdata['0'] as $field=>$info){
				if($info['powerful_field']) continue;
				if($info['formtype']=='powerful_field') {
					foreach($formdata['0'] as $_fm=>$_fm_value) {
						if($_fm_value['powerful_field']) {
							$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
						}
					}
					foreach($formdata['1'] as $_fm=>$_fm_value) {
						if($_fm_value['powerful_field']) {
							$info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
						}
					}
				}
			?>
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php if($info['star']){ ?> <font color="red">*</font><?php } ?> <?php echo $info['name']?></label>
				<div class="col-sm-4 input-group"><?php echo $info['form']?>  <?php echo $info['remark']?></div>
			</div>
			<?php }?>
			<div class="form-group">
				<label class="col-sm-2 control-label">所属体检中心</label>
				<div class="col-sm-4 input-group">
					<div class="input-group">
						<input type="hidden" id="relation" name="mecid" class="form-control" value="<?php echo $member['mecid'];?>" />

						<input type="text" name="search" id="relation_search" class="form-control" style="width: 200px;" readonly datatype="*2-50" errormsg="请选择所属体检中心" nullmsg="请选择所属体检中心">
<span class="input-group-btn pull-left">
<button class="btn btn-white" type="button" onclick="select_content('3');">选择体检中心</button>
</span>
					</div>

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-4 input-group">
					<input type="hidden" name="forward" value="<?php echo HTTP_REFERER;?>">
					<input class="btn btn-info" type="submit" name="submit" value="提交" id="submit"></div>
			</div>
			</div>
		</form>
	</div>
</section>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script type="text/javascript">
	function select_content(modelid) {
		top.dialog({
			id: 'relation',
			fixed: true,
			width: 900,
			height: 530,
			title: '选择内容',
			padding: 5,
			url: '?m=content&f=sundry&v=listing&modelid=' + modelid + "&_su=LSksdkisdjf-.s&_menuid=215&_submenuid=216",
			onclose: function () {
				if (this.returnValue) {
					var text = this.returnValue;
					var htmls = text.split("~wuzhicms~");
					$("#relation").val(htmls[0]);
					$("#relation_search").val(htmls[1]);
				}
			}
		}).showModal(this);
	}
	$(function(){
		$(".form-horizontal").Validform({
			tiptype:1,
            callback:function(form){
                $("#submit").click();
            }

        });


        $("#body").niceScroll({styler:"fb",cursorcolor:"#CAD3D5",cursorwidth: '3', cursorborderradius: '10px', background: '#E2E7E8', cursorborder: '',horizrailenabled:false});

    });
</script>