<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body>
<section class="wrapper">
	<div class="panel">
		<header class="panel-heading">
			<form class="d-flex align-items-center" role="form">
			<div class="col-auto me-2">
				<div class="input-group">
					<span class="input-group-text p-0 border-0">
						<input type="hidden" name="m" value="<?php echo M;?>" />
						<input type="hidden" name="f" value="<?php echo F;?>" />
						<input type="hidden" name="v" value="<?php echo V;?>" />
						<input type="hidden" name="_su" value="<?php echo _SU;?>" />
						<input type="hidden" name="_menuid" value="<?php echo $GLOBALS['_menuid'];?>" />
						<input type="hidden" name="search" />
						<select name="keyType" class="form-select">
							<?php foreach($keyArr as $k=>$v){?>
							<option value="<?php echo $k;?>" <?php echo $keyType == $k ? 'selected' : ''?>><?php echo $v;?></option>
							<?php }?>
						</select>
					</span>
					<input type="text" name="keyValue" class="usernamekey form-control" value="<?php echo $keyValue?>"/>
				</div>
			</div>

			<div class="col-auto ms-2 d-flex align-items-center">
				<div class="pe-2">注册时间：</div>
				<div><?php echo WUZHI_form::calendar('regTimeStart', $regTimeStart ? date('Y-m-d', $regTimeStart) : '');?></div>
				<div class="px-2">-</div>
				<div><?php echo WUZHI_form::calendar('regTimeEnd', $regTimeEnd ? date('Y-m-d', $regTimeEnd) : '');?></div>
				<button type="submit" class="btn btn-info btn-sm px-4 ms-3">搜索</button>
			</div>
				
			</form>
		</header>
		<form name="myform" method="post" action="?m=member&f=index&v=del<?php echo $this->su();?>">
		<div class="panel-body" id="panel-bodys">
			<table class="table table-striped table-advance table-hover">
				<thead>
					<tr>
						<th class="tablehead"><input class="form-check-input" type="checkbox"  id="check_box" onclick="checkall('selectAll',this);"></th>
						<th class="tablehead">UID</th>
						<th class="tablehead w-50">登录名</th>
						<th class="tablehead">姓名</th>
						<th class="tablehead">Email</th>
						<th class="tablehead">会员组</th>
						<th class="tablehead">模型</th>
						<th class="tablehead">注册时间</th>
						<th class="tablehead">操作</th>
					</tr>
				</thead>
				<tbody>
				<?php if(is_array($result))foreach($result as $r) {?>
					<tr id="u_<?php echo $r['uid'];?>">
						<td><input type="checkbox" name="uid[]" value="<?php echo $r['uid'];?>"></td>
						<td><?php echo $r['uid'];?></td>
						<td><?php echo $r['username'];?></td>
						<td><?php echo $r['fullname']."<br>".$r['fullname_en'];?></td>
						<td><?php echo $r['email'];?></td>
						<td>
							<?php
							echo '<font color="#AD5B0D">'.$group[$r['groupid']]['name']."</font>";
							foreach($r['group_extend'] as $r2) {
								echo ' <br>'.$ext_group[$r2['groupid']]['name'];
							}
							?></td>
						<td>
							<?php
							foreach($r['modelid'] as $r2) {
								echo $models[$r2]['name']."<br>";
							}

							?></td>
						<td><?php echo date('Y-m-d H:i:s', $r['regtime']);?></td>
						<td>
							<a href="index.php?m=member&f=index&v=check&submit=1&uid=<?php echo $r['uid'].$this->su();?>" class="btn btn-primary btn-sm btn-xs">通过审核</a>
							<a href="javascript:void(0)" onclick="del(<?php echo $r['uid'];?>)" class="btn btn-danger btn-sm btn-xs">删除</a>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>

		<div class="panel-foot">
			<div class="d-flex justify-content-between align-items-center">
				<div class="panel-label">
					<button type="button" onClick="checkall()" name="submit2" class="btn btn-default btn-sm">全选/反选</button>
					<button type="submit" class="btn btn-default btn-sm">删除</button>
				</div>
				<div class="panel-label">
					<ul class="pagination pagination-sm">
						<?php echo $pages;?>
					</ul>
				</div>
			</div>
		</div>
		</form>
	</div>
</section>
<script type="text/javascript">
function edit(uid){
	top.openiframe('index.php?m=member&f=index&v=edit&uid='+uid+'<?php echo $this->su();?>', 'editUser', '编辑用户', 800, 500);
}
function del(uid){
	if(!confirm('您确认要删除吗，该操作不可恢复！'))return false;
	$.getJSON('index.php?m=member&f=index&v=del&uid='+uid+'<?php echo $this->su();?>&callback=?', function(data){
		if(data.status == 1){
			toast('删除成功');
			$('#u_'+uid).remove();
		}else{
			toast('删除失败');
		}
	});
}
function setpassword(uid, username, email){
	if(!confirm('您确认要重置该用户的密码吗！'))return false;
	$.getJSON('index.php?m=member&f=index&v=password&uid='+uid+'&username='+username+'&email='+email+'<?php echo $this->su();?>&callback=?', function(data){
		if(data.status == 1){
			toast('重置成功');
			$("#u_'.$uid.' td").css("background-color", "#EFD04C");
		}else{
			toast('重置失败');
		}
	});
}
function toast(msg, time){
	time = time ? time*1000 : 2000;
	var d = top.dialog({
		id: 'toast',
	    content: msg,
	    fixed: true
	}).showModal();
	setTimeout(function () { d.close().remove(); }, time);
}

</script>
<?php include $this->template('footer','core');?>
