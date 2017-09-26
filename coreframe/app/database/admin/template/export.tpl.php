<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
				<header>
					<?php echo $this->menu($GLOBALS['_menuid']);?>
				</header>
				<form method="POST" name="myform" id="myform" action="?m=database&f=index&v=export<?php echo $this->su();?>">
					<div class="panel-body" id="panel-bodys">

					<table width="100%" class="table table-striped table-advance table-hover">
					<thead>
					<tr>
						<th class="tablehead" colspan=2>分卷备份设置</th>
					</tr>
					</thead>
					<tr>
						<td class="col-sm-4 col-xs-4">每个分卷文件大小</td>
						<td><input type="text" name="sizelimit" value="2048" size=5> K</td>
					</tr>
					<tr>
						<td class="col-sm-4 col-xs-4">建表语句格式</td>
						<td><input type="radio" name="sqlcompat" value="" checked> 默认&nbsp; <input type="radio" name="sqlcompat" value="MYSQL41"> 5.x</td>
					</tr>
					<tr>
						<td class="col-sm-4 col-xs-4">强制字符集</td>
						<td><input type="radio" name="sqlcharset" value="" checked> 默认&nbsp; <input type="radio" name="sqlcharset" value="latin1"> LATIN1 &nbsp; <input type="radio" name="sqlcharset" value='utf8'> UTF-8</td>
					</tr>
					<tr>
						<td class="col-sm-4 col-xs-4">请先选择备份的数据表，再点击备份按钮！</td>
						<td><input type="submit" name="dosubmit" class="btn btn-info btn-sm" value="备 份"></td>
					</tr>
					</table>
						<br>
						<div class="alert alert-success fade in">
							<strong>文件备份所在目录:</strong> <?php echo CACHE_ROOT;?>db_bak
						</div>
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <thead>
							<tr>
								<th class="tablehead"><input type="checkbox"  id="check_box" onclick="checkall('selectAll',this);"> 全选</th>
								<th class="tablehead">表名</th>
                                <th class="tablehead">类型</th>
                                <th class="tablehead">编码</th>
                                <th class="tablehead">记录数</th>
                                <th class="tablehead">使用空间</th>
                                <th class="tablehead">碎片</th>
								<th class="tablehead">操作</th>
							</tr>
							</thead>
                            <tbody>
							<?php
							foreach($infos['wz_cmstables'] as $info){
							?>
							<tr>
								<td><input type="checkbox" name="tables[]" value="<?php echo $info['name']?>"></td>
								<td><?php echo $info['name'];?></td>
								<td><?php echo $info['engine'];?></td>
								<td><?php echo $info['collation'];?></td>
								<td><?php echo $info['rows'];?></td>
								<td><?php echo sizecount($info['size']);?></td>
								<td><?php echo sizecount($info['data_free']);?></td>
								<td>
								<a href="?m=database&f=index&v=public_repair&operation=optimize&tables=<?php echo $info['name']?><?php echo $this->su();?>" class="btn btn-primary btn-xs">优化</a>
								<a href="?m=database&f=index&v=public_repair&operation=repair&tables=<?php echo $info['name']?><?php echo $this->su();?>" class="btn btn-info btn-xs">修复</a>								</td>
							</tr>
							<?php }?>
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
            	<input type="submit" name="dosubmit" class="btn btn-info" value="备份">
		    </div>
		</div>
	</div>


				</form>
			</section>

		</div>
	</div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>