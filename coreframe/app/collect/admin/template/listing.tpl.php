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
                        <th class="tablehead">标题</th>
                        <th class="tablehead">时间</th>

                        <th class="tablehead" width="260">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($result)) {

                    foreach($result AS $r) {
                        ?>
                        <tr>
                            <td><a href="<?php echo $r['url'];?>" target="_blank"> <?php echo $r['title'];?></a></td>
                            <td><?php echo $r['addtime'];?></td>
                            <td>
                                <a href="?m=collect&f=index&v=get_content&url=<?php echo urlencode($r['url']);?><?php echo $this->su();?>"
                                    class="btn btn-info btn-sm btn-xs">采集网址</a>
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
                                <ul class="pagination pagination-sm">
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
<?php include $this->template('footer','core');?>

