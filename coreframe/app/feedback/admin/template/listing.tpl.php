<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <!-- page start-->
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <form action="?m=feedback&f=index&v=sort<?php echo $this->su();?>" name="myform" method="post">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">ID</th>
                        <th class="tablehead">反馈问题</th>
                        <th class="tablehead">类型</th>
                        <th class="tablehead">反馈时间</th>
                        <th class="tablehead">联系人</th>
                        <th class="tablehead">邮箱</th>
                        <th class="tablehead">用户地理位置</th>
                        <th class="tablehead">状态</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr>
                            <td><?php echo $r['id'];?></td>
                            <td width="30%"><?php echo '<a href="'.$r['url'].'" target="_blank">'.strcut($r['content'],180,'...');?></a></td>
                            <td><?php echo $types[$r['typeid']];?></td>
                            <td><?php echo time_format($r['addtime']);?></td>
                            <td><?php echo $r['linkman'];?></td>
                            <td><?php echo $r['email'];?></td>
                            <td><?php echo $r['ip_location'];?></td>
                            <td><?php if($r['replytime']) {echo '已处理';}else{echo '<font color="red">未处理</font>';}?></td>
                            <td>
                                <a href="javascript:void(0);" onclick="view(<?php echo $r['id'];?>)" class="btn btn-primary btn-sm btn-xs">查看</a>
                                <a href="javascript:makedo('?m=feedback&f=index&v=delete&id=<?php echo $r['id'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                    class="btn btn-danger btn-sm btn-xs">删除</a>

                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <div class="panel-foot">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="panel-label">
                            <ul class="pagination pagination-sm">
                                <?php echo $pages;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
    <!-- page end-->
</section>
<script>
    function view(id){
        top.openiframe('?m=feedback&f=index&v=reply&id='+id+'<?php echo $this->su();?>', 'editGroup', '查看', 600, 300);
    }
</script>
<?php include $this->template('footer','core');?>