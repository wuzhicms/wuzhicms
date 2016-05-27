<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>
                <div class="panel-body">
                    <form class="form-horizontal tasi-form" method="get" action="">
                        <input name="m" value="coupon" type="hidden">
                        <input name="f" value="card" type="hidden">
                        <input name="v" value="bind_select_content" type="hidden">
                        <input name="modelid" value="<?php echo $modelid;?>" type="hidden">
                        <input name="_su" value="<?php echo $GLOBALS['_su'];?>" type="hidden">
                        <input name="status" value="<?php echo $status;?>" type="hidden">
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">搜索类型</label>
                            <div class="col-sm-2 input-group">
                                <?php echo $form->select($options, $stype, 'name="stype" id="stype" class="form-control"');?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">关键字</label>
                            <div class="col-sm-4 input-group">
                                <input type="text" class="form-control" name="keywords" value="<?php echo $keywords;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">所属栏目 </label>
                            <div class="col-sm-4 input-group">
                                <select name="cid" class="form-control">
                                    <option value="52" <?php if($cid==52) echo 'selected=""';?>>≡ 高端旅游 ≡</option>
                                    <option value="51" <?php if($cid==51) echo 'selected=""';?>>≡ 自驾游 ≡</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label">发布时间 </label>
                            <div class="col-sm-8 input-group">
                                <?php echo WUZHI_form::calendar('start',$start,1);?> - <?php echo WUZHI_form::calendar('end',$end,1);?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-sm-2 control-label"></label>
                            <div class="col-sm-10 input-group">
                                <input class="btn btn-info" type="submit" name="submit" value="提交">
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            <?php
            if($result) {
                ?>
                <section class="panel">
                    <form name="myform2" action="" method="post">

                    <div class="panel-body" id="panel-bodys">

                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th class="tablehead"><input type="checkbox"  id="check_box" onclick="checkall('selectAll',this);"> 全选</th>
                                <th class="tablehead">ID</th>
                                <th class="tablehead">所属栏目</th>
                                <th class="tablehead">标题</th>
                                <th class="tablehead">更新时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($result AS $r) {
                                $jr = $this->db->get_one('coupon_ids', array('id' => $r['id'],'cid'=>$cid));
                                ?>
                                <tr>
                                    <td><input type="checkbox" name="ids[]" value="<?php echo $r['id'];?>" <?php if($jr) echo 'checked';?>></td>
                                    <td><?php echo $r[ 'id'];?></td>
                                    <td><?php echo $category['name'];?></td>
                                    <td><a href="<?php echo $r['url'];?>" target="_blank"><?php echo p_htmlentities($r['title']);?></a></td>
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

                                        <input type="hidden" name="cid" value="<?php echo $cid;?>">
                                        <button type="submit" name="submit" class="btn btn-default btn-sm">确定</button>
                                    </div>
                                    <div class="pull-right">
                                        <ul class="pagination pagination-sm mr0">
                                            <?php echo $pages;?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                </section>
            <?php }?>
        </div>
    </div>
    <!-- page end-->
</section>
<script type="text/javascript">
    function select_id(id,title) {
        var dialog = top.dialog.get(window);
        var htmls = id+"~wuzhicms~"+title;
        dialog.close(htmls).remove();
        return false;
    }
</script>

