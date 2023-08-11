<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
$menu_r = $this->db->get_one('menu',array('m'=>'topic','f'=>'index','v'=>'list_manage'));
$submenuid = $menu_r['menuid'];
?>
<body>
<section class="wrapper">
    <!-- page start-->
        <section class="panel">
            <?php echo $this->menu($submenuid,'&tid='.$tid);?>
            <form action="" name="myform" method="post">
                <div class="panel-body" id="panel-bodys">
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>
                            <th class="hidden-phone tablehead text-center">选择</th>
                            <th class="tablehead">ID</th>
                            <th class="tablehead">标题</th>
                            <th class="tablehead">所属频道</th>
                            <th class="tablehead">分类名称</th>
                            <th class="tablehead">添加时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($result AS $r) {
                            $topic_content = $this->db->get_one('topic_content', array('tid' => $tid,'sid'=>$r['sid']));
                            ?>
                            <tr>
                                <td class="text-center">
                                    <?php if(!$topic_content) {?>
                                    <input type="checkbox" name="ids[]" value="<?php echo $r['sid'];?>"><?php }?>
                                </td>
                                <td><?php echo $r['sid'];?></td>
                                <td><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['title'];?></a></td>
                                <td><?php echo $r['channelname'];?></td>
                                <td><?php echo $r['catname'];?></td>
                                <td><?php echo date('Y-m-d H:i:s',$r['addtime']);?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <div class="panel-foot">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="panel-label">
                                <div class="d-flex">
                                    <button type="button" onClick="checkall()" name="submit2" class="btn btn-default btn-sm">全选/反选</button>
                                    <div class="ms-2">
                                        <select name="kid1" class="form-select">
                                            <?php
                                            foreach($kid1s as $kid) {
                                                echo '<option value="'.$kid['kid'].'">'.$kid['name'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="ms-2">
                                        <?php
                                        if($kid2s) {
                                            ?>
                                            <select name="kid2" class="form-select">
                                                <?php
                                                foreach($kid2s as $kid) {
                                                    echo '<option value="'.$kid['kid'].'">'.$kid['name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        <?php }?>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-danger btn-sm ms-2">导入</button>
                                </div>
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
<script type="text/javascript">
    $(function(){
        $("#index-list_manage").html("专题内容管理：<?php echo $data['name'];?>");
    })
</script>
<?php include $this->template('footer','core');?>

