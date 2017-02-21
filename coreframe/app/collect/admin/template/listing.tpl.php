<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<style>
    .sharekey{color: #e8921b;}
</style>
<section class="wrapper">
<!-- page start-->
<div class="row">
    <div class="col-lg-12">


        <section class="panel">
            <?php echo $this->menu($GLOBALS['_menuid']);?>

            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">ID</th>
                        <th class="tablehead">规则名称</th>
                        <th class="tablehead">备注</th>
                        <th class="tablehead">规则更新时间</th>
                        <th class="tablehead">采集网址数</th>
                        <th class="tablehead">采集状态</th>
                        <th class="tablehead">发布状态</th>
                        <th class="tablehead">共享规则</th>
                        <th class="tablehead" width="260">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($result)) {

                    foreach($result AS $r) {
                        $wait_num = $this->db->count_result('collect_url',array('configid'=>$r['configid'],'status'=>0));
                        $has_num = $this->db->count_result('collect_url',array('configid'=>$r['configid'],'status'=>1));
                        $insert_num = $this->db->count_result('collect_url',array('configid'=>$r['configid'],'status'=>2));

                        ?>
                        <tr>

                            <td><?php echo $r['configid'];?></td>
                            <td><?php echo $r['title'];?></td>
                            <td><?php echo $r['remark'];?></td>
                            <td><?php echo date('m/d H:i:s',$r['updatetime']);?></td>
                            <td>未采集：<?php echo $wait_num.'<br>已采集：'.$has_num.' <br> 已入库：'.$insert_num;?></td>
                            <td><?php echo $status[$r['status']];?></td>
                            <td><?php echo $pub_status[$r['publish']];?></td>
                            <td><?php if($r['is_share']) {?>我要分享规则<?php } else {echo '规则已分享<br>（站长采用次数：<span class="sharekey" sharekey="'.$r['sharekey'].'"></span>）';}?></td>
                            <td>
                                <a href="?m=collect&f=collect&v=get_urls_config&configid=<?php echo $r['configid'];?><?php echo $this->su();?>"
                                    class="btn btn-info btn-xs">1、采集网址配置</a>
                                <a href="?m=collect&f=collect&v=get_urls&configid=<?php echo $r['configid'];?><?php echo $this->su();?>"
                                    class="btn btn-info btn-xs">2、采集网址</a>
                                <br><br>
                                <a href="?m=collect&f=collect&v=get_urls_config&configid=<?php echo $r['configid'];?><?php echo $this->su();?>"
                                    class="btn btn-primary btn-xs">3、采集内容配置</a>
                                <a href="?m=collect&f=collect&v=get_urls&configid=<?php echo $r['configid'];?><?php echo $this->su();?>"
                                    class="btn btn-primary btn-xs">4、采集内容</a>
                                <br><br>
                                <a href="?m=collect&f=collect&v=get_urls_config&configid=<?php echo $r['configid'];?><?php echo $this->su();?>"
                                    class="btn btn-danger btn-xs">5、发布内容配置</a>
                                <a href="?m=collect&f=collect&v=get_urls_config&configid=<?php echo $r['configid'];?><?php echo $this->su();?>"
                                    class="btn btn-danger btn-xs">6、发布内容</a>
                            </td>
                        </tr>
                        <?php
                    }
                    }
                    ?>



                    </tbody>
                </table>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">

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
    </div>
</div>

<!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script>
    $(function(){
        $(".sharekey").each(function(index, domEle){
            $(this).html(" 0 次");
        });

    })
</script>

</body>
</html>