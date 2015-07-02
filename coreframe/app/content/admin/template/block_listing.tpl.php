<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>

<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">

<form name="myform" action="?m=content&f=block&v=html<?php echo $this->su();?>" method="post">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>

                <div class="panel-body" id="panel-bodys">
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>
                            <th class="tablehead">选择</th>
                            <th class="hidden-phone tablehead">ID</th>
                            <th class="tablehead">名称</th>
                            <th class="tablehead">ssi调用代码 <a href="http://www.wuzhicms.com/help-block-ssi.html" target="_blank"><i class="icon-help"></i></a></th>
                            <th class="tablehead">常规调用 <a href="http://www.wuzhicms.com/help-block-code.html" target="_blank"><i class="icon-help"></i></a></th>
                            <th class="hidden-phone tablehead">更新时间</th>
                            <th class="tablehead">管理操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($result AS $r) {
                            ?>
                            <tr title="下次更新时间：<?php echo date('Y-m-d H:i',$r['timing']);?>">

                                <td><input name="blockids[]" type="checkbox" value="<?php echo $r['blockid'];?>" <?php if(!$r['createhtml']) echo 'disabled';?>></td>
                                <td <?php if($r['isopenid']) echo 'style="color:#FF6C60;" title="云端ID"';?>><?php echo $r['blockid'];?></td>
                                <td><?php echo $r['name'];?></td>
                                <td><?php if($r['createhtml']) {?><div class="blockcode"><textarea><!--#include virtual="<?php echo WWW_PATH;?>webs/<?php echo $r['blockid'];?>.html"-->
<!--<?php echo $r['name'];?>--></textarea></div><?php }?></td>
                                <td>{block=<?php echo $r['blockid'];?>}</td>
                                <td ><?php echo time_format($r['updatetime']);?></td>

                                <td>
                                    <?php if($r['type']==1) {?><a href="?m=content&f=block&v=item_listing&blockid=<?php echo $r['blockid'];?><?php echo $this->su();?>" class="btn btn-info btn-xs">管理内容</a><?php }?>
                                    <a href="?m=content&f=block&v=edit&blockid=<?php echo $r['blockid'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">修改</a>
                                    <a href="javascript:makedo('?m=content&f=block&v=delete&blockid=<?php echo $r['blockid'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                       class="btn btn-danger btn-xs">删除</a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>



                        </tbody>
                    </table>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="pull-left"> <button type="submit" name="submit" class="btn btn-default btn-sm">生成静态</button>
                                </div>
                                <div class="pull-right">
                                    <ul class="pagination pagination-sm mr0">
                                        <?php echo $pages;?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
</form>
        </div>
    </div>

    <!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>