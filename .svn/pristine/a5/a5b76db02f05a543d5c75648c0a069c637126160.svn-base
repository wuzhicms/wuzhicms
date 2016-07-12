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

                <div class="panel-body">
                    <form class="form-horizontal tasi-form" method="post" action="">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">是否开启优惠活动:</label>
                            <div class="col-sm-4">
                                <label class="radio-inline">
                                    <input type="radio" name="open" value="1" <?php if($setting['open']) echo 'checked';?>>是
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="open" value="0" <?php if(!$setting['open']) echo 'checked';?>>否
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">满足条件（小于这个数的，不参与）：</label>
                            <div class="col-sm-2 ">
                                <input type="text" class="form-control" name="needmoney"  value="<?php echo output($setting,'needmoney');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">抵价：</label>
                            <div class="col-sm-2 ">
                                <input type="text" class="form-control" name="deefmoney"  value="<?php echo output($setting,'deefmoney');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                <input class="btn btn-info" type="submit" name="submit" value="提交">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="alert alert-success fade in">
                    <strong>已绑定的套餐列表:</strong>
                </div>

                <form name="myform2" action="" method="post">
                    <input type="hidden" name="v" value="delete_content">
                    <div class="panel-body" id="panel-bodys">

                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th class="tablehead"><input type="checkbox"  id="check_box" onclick="checkall('selectAll',this);"> 全选</th>
                                <th class="tablehead">ID</th>
                                <th class="tablehead">所属栏目</th>
                                <th class="tablehead">标题</th>
                                <th class="tablehead">价格</th>
                                <th class="tablehead">更新时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($result AS $res) {
                                $r = $this->db->get_one('tuangou', array('id' => $res['id']));
                                ?>
                                
                                <tr>
                                    <td><input type="checkbox" name="ids[]" value="<?php echo $r['id'];?>"></td>
                                    <td><?php echo $r[ 'id'];?></td>
                                    <td><?php echo $categorys[$r['cid']]['name'];?></td>
                                    <td><a href="<?php echo $r['url'];?>" target="_blank"><?php echo p_htmlentities($r['title']);?></a></td>
                                    <td><?php echo $r[ 'price'];?></td>
                                    <td title="添加时间：<?php echo date('Y-m-d H:i:s',$r[ 'addtime']);?>"><?php echo time_format($r[ 'updatetime']);?></td>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="pull-left">
                                        <button type="button" onClick="checkall()" name="submit2" class="btn btn-default btn-sm">全选/反选</button>

                                        <button type="submit" name="submit" class="btn btn-default btn-sm">删除选择</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                </form>
            </section>
        </div>

    </div>

</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
