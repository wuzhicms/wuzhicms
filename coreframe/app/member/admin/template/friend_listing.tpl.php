<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body class="body pxgridsbody">
<section class="wrapper">
<form name="myform" method="post" action="?m=member&f=group&v=sort<?php echo $this->su();?>">
	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
			<?php echo isset($GLOBALS['_menuid']) ? $this->menu($GLOBALS['_menuid']) : '';?>
				<div class="panel-body" id="panel-bodys">
					<table class="table table-striped table-advance table-hover">
						<thead>
							<tr>
								<th class="tablehead">UID</th>
								<th class="tablehead">会员名</th>
								<th class="tablehead">真实姓名</th>
								<th class="tablehead">所属城市</th>
								<th class="tablehead">操作</th>
							</tr>
						</thead>
						<tbody>
						<?php if(is_array($result))foreach($result as $r) {?>
							<tr id="g_<?php echo $r['groupid'];?>">
								<td><?php echo $r['uid'];?></td>
								<td><?php echo $r['member_info']['username'];?></td>
								<td><?php echo $r['member_info']['truename'];?></td>
								<td><?php if($r['cityid']==0) echo '全国';else echo $categorys[$r['cityid']]['name'];?></td>
								<td>
									<a href="javascript:makedo('?m=member&f=friend&v=delete&id=<?php echo $r['id'];?><?php echo $this->su();?>', '确认删除该记录？')"
									   class="btn btn-danger btn-xs">删除</a>
								</td>
							</tr>
						<?php }	?>
						</tbody>
					</table>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="pull-right">
								<ul class="pagination pagination-sm mr0">
									<?php echo $pages;?>
								</ul>
							</div>
						</div>
					</div>
				</div> 
			</section>
		</div>
	</div>
	
</form>  
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script type="text/javascript">
function edit(groupid){
	top.openiframe('index.php?m=member&f=group&v=edit&groupid='+groupid+'<?php echo $this->su();?>', 'editGroup', '编辑用户组', 800, 500);
}
function del(groupid){
	if(!confirm('您确认要删除吗，该操作不可恢复！'))return false;
	$.getJSON('index.php?m=member&f=group&v=del&groupid='+groupid+'<?php echo $this->su();?>&callback=?', function(data){
		if(data.status == 1){
			alert('删除成功');
			$('#g_'+groupid).remove();
		}else{
			alert('删除失败');
		}
	});
}
</script>
</body>
</html>
