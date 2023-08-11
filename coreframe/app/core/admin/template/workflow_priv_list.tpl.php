<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body class="body pxgridsbody">
<style>
	.userspan{
		padding: 5px 20px;
	}
</style>
<section class="wrapper">
<!-- page start-->
    <section class="panel">
            <?php echo $this->menu($GLOBALS['_menuid']);?>
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">审核权限名称</th>
                        <th class="tablehead">用户列表</th>
                        <th class="tablehead center" >添加审批人</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    for($i=1;$i<=$data['level'];$i++) {
                    	$levelname = 'level'.$i.'_name';
                    	$leveluser = 'level'.$i.'_user';
						$levelusers = unserialize($data[$leveluser]);
						$str = '';
						if($levelusers)  {
							foreach($levelusers as $uid=>$le) {
								//$str .= '<span class="userspan">'.$le.' <a href="?m=core&f=workflow&v=deluser&level=2&uid='.$uid.'&workflowid='.$i.$this->su().'">[删除]</a></span>';
                                $str .= '<span class="userspan">'.$le.' <a href="?m=core&f=workflow&v=deluser&level='.$i.'&uid='.$uid.'&workflowid='.$workflowid.$this->su().'">[删除]</a></span>';
							}
						}
                        ?>
                        <tr>
                            <td><?php echo $data[$levelname];?></td>
                            <td><?php echo $str;?></td>
                            <td align="center"><a href="?m=core&f=workflow&v=adduser&workflowid=<?php echo $workflowid;?>&level=<?php echo $i;?><?php echo $this->su();?>" class="btn btn-info btn-sm btn-xs">添加</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </section>
<!-- page end-->
</section>
<?php include $this->template('footer','core');?>
