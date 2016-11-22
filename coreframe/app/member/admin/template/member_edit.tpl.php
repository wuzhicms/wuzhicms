<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<style type="text/css">
    .table_form td{
        padding: 10px;
    }
	.trbg{background-color: #b2d8e4;}
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    line-height: 0.8;
}
	.opheight>option{
		height:26px;}
</style>
<section class="wrapper">
    <!-- page start-->

    <div class="row">
        <div class="col-lg-12">

            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>
				<form id="myform" name="myfrom" class="form-horizontal tasi-form" method="post" action="index.php?m=member&f=index&v=edit&uid=<?php echo $uid.$this->su();?>">
                <div class="panel-body">
    <ul id="myTab" class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#tabs1" id="1tab" role="tab" data-toggle="tab" aria-controls="tabs1" aria-expanded="true">基本信息</a></li>
      <li role="presentation" class=""><a href="#tabs2" role="tab" id="2tab" data-toggle="tab" aria-controls="tabs2" aria-expanded="false">中文信息</a></li>
        </ul>
      </li>
    </ul>

    <div id="myTabContent" class="tab-content">
      <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">

		<table class="table table-advance table-hover">
		   <tbody>
		    <tr>
		    	<td class="text-right" width="150"><label class="control-label">用户名</label></td>
		    	<td><div class="col-sm-8 col-xs-8"><input class="form-control" id="disabledInput" type="text" name="info[username]" value="<?php echo $member['username']?>"></div></td>
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
		    	<td><div class="col-sm-8 col-xs-8"><input type="text" name="info[email]" class="form-control" value="<?php echo $member['email'];?>" datatype="e" errormsg="请输入正确的Email" sucmsg="OK" /></div></td>
		    </tr>
		    <tr>
		    	<td class="text-right"><label class="control-label">手机</label></td>
		    	<td><div class="col-sm-8 col-xs-8"><input type="text" name="info[mobile]" class="form-control" value="<?php echo $member['mobile'];?>" datatype="m|*0-0" errormsg="请输入正确的手机号" sucmsg="OK"/></div></td>
		    </tr>
			<tr>
				<td class="text-right"><label class="control-label">用户模型</label></td>
				<td><div class="col-sm-4 col-xs-4" style="height: 100px;">
						<select name="modelids[]" class="form-control opheight" style="height: 100px;" multiple="multiple">
							<?php if($this->model)foreach($this->model as $k=>$t){?>
								<option value="<?php echo $t['modelid']?>" <?php echo in_array($t['modelid'],$modelids) ? 'selected' : '';?>><?php echo $t['name'];?></option>
							<?php } ?>
						</select>
					</div>

				</td>
			</tr>
		    <tr>
		    	<td class="text-right"><label class="control-label">会员组</label></td>
		    	<td><div class="col-sm-4 col-xs-4">
						<select name="info[groupid]" class="form-control">
							<?php if(is_array($group))foreach($group as $v){?>
							<option value="<?php echo $v['groupid']?>" <?php echo $v['groupid'] == $member['groupid'] ? 'selected' : ''?> ><?php echo $v['name']?></option>
							<?php }?>
						</select>
					</div>
				</td>
		    </tr>

			<tr>
		    	<td class="text-right"><label class="control-label">扩展会员组</label></td>
		    	<td><div class="col-sm-6 col-xs-6" style="height: 200px;overflow-y: scroll;">
						 <table class="table table-advance ">
                            <thead>
                            <tr>
                                <th class="tablehead">选择</th>
                                <th class="tablehead">GID</th>
                                <th class="tablehead">组名称</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            echo $tree_data;
                            ?>
                            </tbody>
                        </table>
					</div>
				</td>
		    </tr>
			<tr>
				<td class="text-right"><label class="control-label">头像</label></td>
				<td><div class="col-sm-4 col-xs-4"><div class="input-group"><?php echo $form->attachment('','1','avatar',$avatar);?></div></div></td>
			</tr>
			<tr>
				<td class="text-right" width="150"><label class="control-label"> 生日</label></td>
				<td>
					<div class="col-sm-8 col-xs-8"><link rel="stylesheet" type="text/css" href="<?php echo R;?>js/calendar/css/jscal2.css"/>
						<link rel="stylesheet" type="text/css" href="<?php echo R;?>js/calendar/css/border-radius.css"/>
						<script type="text/javascript" src="<?php echo R;?>js/calendar/jscal2.js"></script>
						<script type="text/javascript" src="<?php echo R;?>js/calendar/lang/cn.js"></script><input type="text" name="info[birthday]" id="birthday" value="<?php echo $member['birthday'];?>" class="date" >&nbsp;<script type="text/javascript">
							Calendar.setup({
								weekNumbers: 0,
								inputField : "birthday",
								trigger    : "birthday",
								dateFormat: "%Y-%m-%d",
								showTime: false,
								minuteStep: 1,
								onSelect   : function() {this.hide();}
							});
						</script></div>
				</td>
			</tr>
			<tr>
				<td class="text-right" width="150"><label class="control-label"> 真实姓名</label></td>
				<td>
					<div class="col-sm-4 col-xs-4"><input type="text" name="info[truename]" id="truename" size="" placeholder="" value="<?php echo $member['truename'];?>" class="form-control"  ></div>
				</td>
			</tr>
			<tr>
				<td class="text-right" width="150"><label class="control-label"> 性别</label></td>
				<td>
					<div class="col-sm-8 col-xs-8"> <label class="radio-inline"><input type="radio" name='info[sex]'  value="1" <?php if($member['sex']==1) echo 'checked';?>> 男</label> <label class="radio-inline"><input type="radio" name='info[sex]'  value="0" <?php if(!$member['sex']) echo 'checked';?>> 女</label></div>
				</td>
			</tr>
			<tr>
				<td class="text-right" width="150"><label class="control-label"> 婚姻</label></td>
				<td>
					<div class="col-sm-8 col-xs-8"> <label class="radio-inline"><input type="radio" name='info[marriage]'  value="1" <?php if($member['marriage']) echo 'checked';?>> 已婚</label> <label class="radio-inline"><input type="radio" name='info[marriage]'  value="0" <?php if(!$member['marriage']) echo 'checked';?>> 未婚</label></div>
				</td>
			</tr>
		   </tbody>
		</table>
      </div>
		<div role="tabpanel" class="tab-pane fade" id="tabs2" aria-labelledby="2tab">
       <table class="table table-striped table-advance table-hover">
		   <tbody>

		    <?php
			foreach($modelids as $modelid) {
				echo '<tr><td colspan="2" style="background-color: #F9F3D7;color: #060000;text-align: center;">'.$models[$modelid]['name'].'</td></tr>';
				$formdata = 'formdata_'.$modelid;
				$data = $$formdata;
				foreach ($data[0] as $field => $info) {
					if ($info['powerful_field'] || $field=='email_10') continue;
					if ($info['formtype'] == 'powerful_field') {
						foreach ($formdata['0'] as $_fm => $_fm_value) {
							if ($_fm_value['powerful_field']) {
								$info['form'] = str_replace('{' . $_fm . '}', $_fm_value['form'], $info['form']);
							}
						}
						foreach ($formdata['1'] as $_fm => $_fm_value) {
							if ($_fm_value['powerful_field']) {
								$info['form'] = str_replace('{' . $_fm . '}', $_fm_value['form'], $info['form']);
							}
						}
					}
					?>
					<tr>
						<td class="text-right" width="150"><label class="control-label"><?php if ($info['star']) { ?>
									<font color="red">*</font><?php } ?> <?php echo $info['name'] ?></label></td>
						<td>
							<div class="col-sm-8 col-xs-8"><?php echo $info['form'] ?><?php echo $info['remark'] ?></div>
						</td>
					</tr>
				<?php }

			}?>


		   </tbody>
		</table>

      </div>


    </div>



                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label"></label>
                            <div class="col-lg-5 col-sm-5 col-xs-5 input-group">
                                <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                            </div>
                        </div>

                </div>
				</form>
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
			tiptype:3,
            callback:function(form){
                $("#submit").click();
            }

        });
        $("#body").niceScroll({styler:"fb",horizrailenabled:false,cursorcolor:"#c4c8d2",cursorwidth: '6', cursorborderradius: '10px', background: '#E2E7E8', cursorborder: ''});

    });
	function set_gp(gid,pid) {
		//$('#gid'+pid).addClass('trbg');
		var istrue = $('#box'+gid).is(':checked');
		if(istrue) {
			$('#gid'+gid).addClass('trbg');
		} else {
			$('#gid'+gid).removeClass('trbg');
		}
		set_parents(gid,istrue);
	}
	function set_parents(gid,istrue) {
		var hgid = $("#hgid"+gid).val();
		if(hgid!=0) {
			if(istrue) {
				$('#gid'+hgid).addClass('trbg');
				$('#box'+hgid).prop('checked','checked');
			} else {
				$('#gid'+hgid).removeClass('trbg');
				$('#box'+hgid).prop('checked','');
			}

			set_parents(hgid,istrue);
		} else {
			if(istrue) {
				$('#gid'+gid).addClass('trbg');
				$('#box'+gid).prop('checked','checked');
			} else {
				$('#gid'+gid).removeClass('trbg');
				$('#box'+gid).prop('checked','');
			}
		}

	}
</script>