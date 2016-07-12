<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th class="tablehead">文件名称</th>
                                <th class="tablehead">文件大小</th>
                                <th class="tablehead">备份时间</th>
                                <th class="tablehead">总卷数</th>
                                <th class="tablehead">操作</th>
                            </tr>
                            </thead>
                            <tbody>
							<?php 
								if(is_array($datas)){
								foreach ($datas as $info){?>
							<tr>
								<td><?php echo $info['filename'];?></td>
								<td><?php echo sizecount($info['filesize']);?></td>
								<td><?php echo $info['maketime'];?></td>
								<td><?php echo $info['volume'];?></td>
								<td><a href="javascript:makedo('?m=database&f=index&v=import&filename=<?php echo $info['filename'];?>&dosubmit=1<?php echo $this->su();?>', '确认恢复数据库吗？')"
                                           class="btn btn-info btn-xs">数据恢复</a></td>
							</tr> 
							<?php }}?>
                            </tbody>
                        </table>
                    </div>


		</div>
	</div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>