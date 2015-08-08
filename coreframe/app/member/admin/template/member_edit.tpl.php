<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body id="body" style="overflow-y :scroll;overflow-x:auto;background:#fff;">
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<section class="panel" style="box-shadow: none;">
	<div class="panel-body" id="panel-bodys">
	<form id="myform" name="myfrom" class="form-horizontal tasi-form" method="post" action="index.php?m=member&f=index&v=edit&uid=<?php echo $uid.$this->su();?>">

		<table class="table table-striped table-advance table-hover">
		   <tbody>
		    <tr>
		    	<td class="text-right"><label class="control-label">用户名</label></td>
		    	<td><div class="col-sm-8 col-xs-8"><input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $member['username']?>" disabled=""></div></td>
		    </tr>
		    <tr>
		    	<td class="text-right"><label class="control-label">密码</label></td>
		    	<td><div class="col-sm-8 col-xs-8"><input type="password" name="info[password]" id="password" class="form-control" /></div></td>
		    </tr>
		    <tr>
		    	<td class="text-right"><label class="control-label">确认密码</label></td>
		    	<td><div class="col-sm-8 col-xs-8"><input type="password" name="info[pwdconfirm]" class="form-control" recheck="password" errormsg="您两次输入的账号密码不一致！" sucmsg="OK" /></div></td>
		    </tr>
		    <tr>
		    	<td class="text-right"><label class="control-label">邮箱</label></td>
		    	<td><div class="col-sm-8 col-xs-8"><input type="text" name="info[email]" class="form-control" value="<?php if(strpos($member['email'],'@h1jk.cn')===false) {echo $member['email'];};?>" datatype="e" errormsg="请输入正确的Email" sucmsg="OK" ajaxurl="index.php?m=member&f=index&v=public_check_email&uid=<?php echo $uid;?>" /></div></td>
		    </tr>
		    <tr>
		    	<td class="text-right"><label class="control-label">手机</label></td>
		    	<td><div class="col-sm-8 col-xs-8"><input type="text" name="info[mobile]" class="form-control" value="<?php echo $member['mobile'];?>" datatype="m|*0-0" errormsg="请输入正确的手机号" sucmsg="OK" ajaxurl="index.php?m=member&f=index&v=public_check_mobile&uid=<?php echo $uid;?>" /></div></td>
		    </tr>
		    <tr>
		    	<td class="text-right"><label class="control-label">会员组</label></td>
		    	<td><div class="col-sm-8 col-xs-8">
						<select name="info[groupid]" class="form-control">
							<?php if(is_array($group))foreach($group as $v){?>
							<option value="<?php echo $v['groupid']?>" <?php echo $v['groupid'] == $member['groupid'] ? 'selected' : ''?> ><?php echo $v['name']?></option>
							<?php }?>
						</select>
					</div>
				</td>
		    </tr>
		    <tr>
		    	<td class="text-right"><label class="control-label">用户模型</label></td>
		    	<td><div class="col-sm-8 col-xs-8">
						<select name="info[modelid]" class="form-control" onchange="makedo('index.php?m=member&f=index&v=edit&modelid='+this.value+'&uid=<?php echo $uid.$this->su();?>', '更改模型将会清除当前模型下的数据')">
						<?php if($this->model)foreach($this->model as $k=>$t){?>
							<option value="<?php echo $t['modelid']?>" <?php echo $t['modelid'] == $modelid ? 'selected' : '';?>><?php echo $t['name'];?></option>
		                <?php } ?>
		                </select>
		            </div>
		        </td>
		    </tr>
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
		    <tr>
		    	<td class="text-right"><label class="control-label"><?php if($info['star']){ ?> <font color="red">*</font><?php } ?> <?php echo $info['name']?></label></td>
		    	<td>
		    		<div class="col-sm-8 col-xs-8"><?php echo $info['form']?>  <?php echo $info['remark']?></div>
		    	</td>
		    </tr>
			<?php }?>
		    <tr>
		    	<td class="text-right"><label class="control-label">VIP</label></td>
		    	<td><div class="col-sm-8 col-xs-8"><?php echo WUZHI_form::calendar('info[viptime]', date('Y-m-d H:i:s', $member['viptime']), 1);?></div></td>
		    </tr>
		    <tr>
		    	<td class="text-right"><label class="control-label">锁定</label></td>
		    	<td><div class="col-sm-8 col-xs-8"><?php echo WUZHI_form::calendar('info[locktime]', date('Y-m-d H:i:s', $member['locktime']), 1);?></div></td>
		    </tr>
		    <tr>
		    	<td class="text-right"><label class="control-label"></label></td>
		    	<td><div class="col-sm-8 col-xs-8 panel-footer">
		            <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交"></div>
		        </td>
		    </tr>
		   </tbody>
		</table>

			</div>
		</form>
	</div>
</section>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
		$(".form-horizontal").Validform({
			tiptype:3,
            callback:function(form){
                $("#submit").click();
            }

        });
        $("#body").niceScroll({styler:"fb",horizrailenabled:false,cursorcolor:"#c4c8d2",cursorwidth: '6', cursorborderradius: '10px', background: '#E2E7E8', cursorborder: ''});

    });
</script>