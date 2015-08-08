<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body class="body">
<section class="wrapper">
	<div class="panel mr0">
		<header><?php if(isset($GLOBALS['_menuid']))echo $this->menu($GLOBALS['_menuid']);?></header>
		<header class="panel-heading">
			<form class="form-inline" role="form">
				<input type="hidden" name="m" value="<?php echo M;?>" />
				<input type="hidden" name="f" value="<?php echo F;?>" />
				<input type="hidden" name="v" value="<?php echo V;?>" />
				<input type="hidden" name="_su" value="<?php echo _SU;?>" />
				<input type="hidden" name="_menuid" value="<?php echo $GLOBALS['_menuid'];?>" />
				<input type="hidden" name="search" />
				<div class="input-group">
					<select name="keyType" class="form-control">
						<?php foreach($keyArr as $k=>$v){?>
						<option value="<?php echo $k;?>" <?php echo $keyType == $k ? 'selected' : ''?>><?php echo $v;?></option>
						<?php }?>
					</select>
				</div>
				<input type="text" name="keyValue" class="usernamekey form-control" value="<?php echo $keyValue?>"/>
				<div class="input-group">
					<select name="groupid" class="form-control">
						<option value='' >会员组</option>
						<?php if(is_array($group))foreach($group as $v){?>
						<option value="<?php echo $v['groupid'];?>"<?php echo $v['groupid'] == $groupid ? 'selected' : ''?>><?php echo $v['name'];?></option>
						<?php }?>
					</select>
				</div>
				　　注册时间 <?php echo WUZHI_form::calendar('regTimeStart', $regTimeStart ? date('Y-m-d', $regTimeStart) : '');?>- <?php echo WUZHI_form::calendar('regTimeEnd', $regTimeEnd ? date('Y-m-d', $regTimeEnd) : '');?>
				　　登录时间 <?php echo WUZHI_form::calendar('loginTimeStart', $loginTimeStart ? date('Y-m-d', $loginTimeStart) : '');?>- <?php echo WUZHI_form::calendar('loginTimeEnd', $loginTimeEnd ? date('Y-m-d', $loginTimeEnd) : '');?>
				<button type="submit" class="btn btn-info btn-sm">搜索</button>
			</form>
		</header>
		<form name="myform" method="post" action="?m=member&f=index&v=del<?php echo $this->su();?>">
		<div class="panel-body" id="panel-bodys">
			<table class="table table-striped table-advance table-hover">
				<thead>
					<tr>
						<th class="tablehead"><input type="checkbox"  id="check_box" onclick="checkall('selectAll',this);"> 全选</th>
						<th class="tablehead">UID</th>
						<th class="tablehead">用户名</th>
						<th class="tablehead">Email</th>
						<th class="tablehead">会员组</th>
						<th class="tablehead">余额</th>
						<th class="tablehead">积分</th>
						<th class="tablehead">注册时间</th>
						<th class="tablehead">登录时间</th>
						<th class="tablehead">操作</th>
					</tr>
				</thead>
				<tbody>
				<?php if(is_array($result))foreach($result as $r) {?>
					<tr id="u_<?php echo $r['uid'];?>">
						<td><input type="checkbox" name="uid[]" value="<?php echo $r['uid'];?>"></td>
						<td><?php echo $r['uid'];?></td>
						<td><?php echo $r['username'];?></td>
						<td><?php if(strpos($r['email'],'@h1jk.cn')===false) {echo $r['email'];}?></td>
						<td><?php echo isset($group[$r['groupid']]) ? $group[$r['groupid']]['name'] : '';?></td>
						<td><?php echo $r['money'];?></td>
						<td><?php echo $r['points'];?></td>
						<td><?php echo date('Y-m-d', $r['regtime']);?></td>
						<td><?php echo date('Y-m-d', $r['lasttime']);?></td>
						<td>
							<a href="javascript:void(0)" onclick="setpassword(<?php echo $r['uid'];?>, '<?php echo $r['username'];?>', '<?php echo $r['email'];?>')" class="btn btn-warning btn-xs">置密</a>
							<a href="javascript:void(0)" onclick="edit(<?php echo $r['uid'];?>)" class="btn btn-primary btn-xs">修改</a>
							<a href="javascript:void(0)" onclick="del(<?php echo $r['uid'];?>)" class="btn btn-danger btn-xs">删除</a>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="pull-left">
                            <button type="button" onClick="checkall()" name="submit2" class="btn btn-default btn-sm">全选/反选</button>

                            <button type="submit" name="submit" class="btn btn-default btn-sm">删除</button>
                        </div>
                        <div class="pull-right">
                            <ul class="pagination pagination-sm mr0">
                                <?php echo $pages;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
		</form>
	</div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
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
</body>
</html>