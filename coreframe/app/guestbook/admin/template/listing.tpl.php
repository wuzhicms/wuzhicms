<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<section class="wrapper">
<!-- page start-->
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <form action="?m=guestbook&f=index<?php echo $this->su();?>" name="myform" method="post" onsubmit="checkform()">
        <div class="panel-body" id="panel-bodys">
            <table class="table table-striped table-advance table-hover">
                <thead>
                <tr>
                    <th class="tablehead">选择</th>
                    <th class="tablehead">ID</th>
                    <th class="tablehead">留言标题</th>
                    <th class="tablehead">留言时间</th>
                    <th class="tablehead">主题领域</th>
                    <th class="tablehead">主题类别</th>
                    <th class="tablehead">状态</th>
                    <th class="tablehead">联系人</th>
                    <th class="tablehead">邮箱</th>
                    <th class="tablehead">联系电话</th>
                    <th class="tablehead">用户地理位置</th>
                    <th class="tablehead">管理操作</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($result AS $r) {
                    ?>
                    <tr>
                        <td class="center"><input type="checkbox" class="form-check-input" name="ids[]" value="<?php echo $r['id'];?>"></td>
                        <td><?php echo $r['id'];?></td>
                        <td><?php echo "<a href='index.php?m=guestbook&f=index&v=reply&id=".$r['id'].$this->su()."'>".safe_htm($r['title'])."</a>";?></a></td>
                        <td><?php echo time_format($r['addtime']);?></td>
                        <td><?php echo $r['area'];?></td>
                        <td><?php echo $r['category'];?></td>
                        <td><button type="button" <?php if($r['status']==1||$r['status']==9){ echo 'class="btn btn-danger btn-sm btn-xs"';}else{ echo 'class="btn btn-primary btn-sm btn-xs"';} ?> ><?php echo $status[$r['status']];?></button></td>
                        <td><?php echo $r['linkman'];?></td>
                        <td><?php echo $r['email'];?></td>
                        <td><?php echo $r['tel'];?></td>
                        <td><?php echo $r['ip_location'];?></td>
                        <td>
                            <a href="?m=guestbook&f=index&v=audit&id=<?php echo $r['id'];?><?php echo $this->su();?>" class="btn btn-primary btn-sm btn-xs">审核</a>
                            <a href="?m=guestbook&f=index&v=reply&id=<?php echo $r['id'];?><?php echo $this->su();?>" class="btn btn-primary btn-sm btn-xs">回复</a>
                            <a href="?m=guestbook&f=index&v=end&id=<?php echo $r['id'];?><?php echo $this->su();?>" class="btn btn-primary btn-sm btn-xs">完结</a>
                            <a href="javascript:makedo('?m=guestbook&f=index&v=delete&id=<?php echo $r['id'];?><?php echo $this->su();?>', '确认删除该记录？')"
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
                        <input id="v" name="v" type="hidden" value="<?php echo V;?>">
                        <button type="button" onClick="checkall()" name="submit2" class="btn btn-default btn-sm">全选/反选</button>
                        <button type="submit" onclick="$('#v').val('delete_more')" class="btn btn-default btn-sm">批量删除</button>
                    </div>
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
    function checkform() {
        if($("#v").val() == 'delete_more'){
            if (confirm("您确认要删除吗")){

            }else{
                return false;
            }
        }
    }
</script>
<?php include $this->template('footer','core');?>