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
						<td><input type="text" class="form-control w-auto" name="sizelimit" value="2048" size=5> K</td>
					</tr>
					<tr>
						<td class="col-sm-4 col-xs-4">建表语句格式</td>
						<td>
                            <div class="form-check form-check-inline mb-0 mt-2">
                                <input class="form-check-input" type="radio" name="sqlcompat" id="inlineRadio1" value="" checked>
                                <label class="form-check-label" for="inlineRadio1"> 默认</label>
                            </div>
                            <div class="form-check form-check-inline  mb-0 mt-2">
                                <input class="form-check-input" type="radio" name="sqlcompat" id="inlineRadio2" value="MYSQL41">
                                <label class="form-check-label" for="inlineRadio2">5.x</label>
                            </div>
                        </td>
					</tr>
					<tr>
						<td class="col-sm-4 col-xs-4">强制字符集</td>
						<td>
                            <div class="form-check form-check-inline mb-0 mt-2">
                                <input class="form-check-input" type="radio" name="sqlcharset" id="inlineRadio3" value="" checked>
                                <label class="form-check-label" for="inlineRadio3"> 默认</label>
                            </div>
                            <div class="form-check form-check-inline  mb-0 mt-2">
                                <input class="form-check-input" type="radio" name="sqlcharset" id="inlineRadio4" value="latin1">
                                <label class="form-check-label" for="inlineRadio4">LATIN1</label>
                            </div>
                            <div class="form-check form-check-inline  mb-0 mt-2">
                                <input class="form-check-input" type="radio" name="sqlcharset" id="inlineRadio5" value="utf8">
                                <label class="form-check-label" for="inlineRadio5">UTF-8</label>
                            </div>
                        </td>
					</tr>
					<tr>
						<td class="col-sm-4 col-xs-4">请先选择备份的数据表，再点击备份按钮！</td>
						<td><input type="submit" name="dosubmit" class="btn btn-info btn-sm" value="备 份"></td>
					</tr>
					</table>

                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <thead>
							<tr>
								<th class="tablehead"><input type="checkbox" class="form-check-input"  id="check_box" onclick="checkall('selectAll',this);"> 全选</th>
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
								<td><input type="checkbox" class="form-check-input" name="tables[]" value="<?php echo $info['name']?>"></td>
								<td><?php echo $info['name'];?></td>
								<td><?php echo $info['engine'];?></td>
								<td><?php echo $info['collation'];?></td>
								<td><?php echo $info['rows'];?></td>
								<td><?php echo sizecount($info['size']);?></td>
								<td><?php echo sizecount($info['data_free']);?></td>
								<td>
								<a href="?m=database&f=index&v=public_repair&operation=optimize&tables=<?php echo $info['name']?><?php echo $this->su();?>" class="btn btn-primary btn-sm btn-xs">优化</a>
								<a href="?m=database&f=index&v=public_repair&operation=repair&tables=<?php echo $info['name']?><?php echo $this->su();?>" class="btn btn-info btn-sm btn-xs">修复</a>								</td>
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
<?php include $this->template('footer','core');?>
