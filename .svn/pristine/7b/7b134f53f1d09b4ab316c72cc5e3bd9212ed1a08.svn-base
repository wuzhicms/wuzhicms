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
								<th class="tablehead"><input type="checkbox"  id="check_box" onclick="checkall('selectAll',this);"> 全选</th>
								<th class="tablehead">排序</th>
								<th class="tablehead">GID</th>
								<th class="tablehead">组名</th>
								<th class="tablehead">内置组</th>
								<th class="tablehead">自主升级</th>
								<th class="tablehead">操作</th>
							</tr>
						</thead>
						<tbody>
						<?php echo $tree_data;?>
						</tbody>
					</table>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="pull-left">
								<input type="submit" class="btn btn-info btn-sm" name="submit" value="排序" >
								<input type="submit" class="btn btn-default btn-sm" value="删除" onclick="if(confirm('您确认要删除吗，该操作不可恢复！')){ myform.action='?m=member&f=group&v=del<?php echo $this->su();?>'; return true; }else{ return false; }">
							</div>
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
