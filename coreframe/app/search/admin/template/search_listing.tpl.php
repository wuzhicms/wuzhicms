<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body>
<section class="wrapper">
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
            <?php echo $this->menu($GLOBALS['_menuid']);?>
		</section>
	</div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-info fade in">
            <strong>注意：</strong>全文索引模块需要 MySQL 开启全文索引功能<br/>
            <strong>开启方法：</strong>
            修改 MySQL 配置文件，在 [mysqld] 后面加入一行“ft_min_word_len=1”，然后重启 MySQL。
            使用时需要在 MyISAM 类型的表的 char、varchar 和 tex t的字段上创建 fulltext 类型的索引。
        </div>

        <section class="panel">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                        <tr>
                            <th class="tableth15">ID</th>
                            <th class="tableth15">类别名称</th>
                            <th class="tableth15">所属模块</th>
                            <th class="tableth15">所属模型</th>
                            <th class="tableth15">类别描述</th>
                            <th class="tableth15">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($result) && is_array($result))foreach($result as $r) {?>
                            <td><?php echo $r['id'];?></td>
                            <td><?php echo safe_htm($r['name']);?></td>
                            <td><?php echo $r['m'];?></td>
                            <td><?php echo $r['model_name']; ;?></td>
                            <td><?php echo safe_htm($r['remark']);?></td>
                            <td>
                                <a href="javascript:void(0)" onclick="edit(<?php echo $r['id'];?>)" class="btn btn-primary btn-xs">修改</a>
                                <a href="javascript:void(0)" onclick="del(<?php echo $r['id'];?>)" class="btn btn-danger btn-xs">删除</a>
                            </td>
                        </tr>
                    <?php }	?>
                    </tbody>
                </table>
            </div>


            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="pull-left">

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

</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script type="text/javascript">
function edit(id){
    self.location.href = 'index.php?m=search&f=index&v=edit&sid='+id+'<?php echo $this->su();?>';
}
function del(id){
	if(!confirm('您确认要删除吗，该操作不可恢复！'))return false;
    self.location.href = 'index.php?m=search&f=index&v=del&sid='+id+'<?php echo $this->su();?>';
}
</script>
</body>
</html>
