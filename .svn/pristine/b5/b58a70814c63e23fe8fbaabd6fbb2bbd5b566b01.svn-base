<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body style="background-color: #fff;">
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-body">
                    <form class="form-horizontal tasi-form" method="get" action="">
                        <input name="m" value="content" type="hidden">
                        <input name="f" value="sundry" type="hidden">
                        <input name="v" value="listing" type="hidden">
                        <input name="modelid" value="<?php echo $modelid;?>" type="hidden">
                        <input name="_su" value="<?php echo $GLOBALS['_su'];?>" type="hidden">
                        <input name="status" value="<?php echo $status;?>" type="hidden">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">搜索类型</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <?php echo $form->select($options, $stype, 'name="stype" id="stype" class="form-control"');?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">关键字</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="keywords" value="<?php echo $keywords;?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">所属栏目 </label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <?php
                                echo $form->tree_select($categorys, $cid, 'name="cid" class="form-control" ', '≡ 全部 ≡');

                                ?>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">发布时间 </label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <div class="col-lg-3 col-sm-6 col-xs-6 input-group pull-left" style="margin-right:1px"><?php echo WUZHI_form::calendar('start',$start,1);?></div>
                                <div class="col-lg-3 col-sm-6 col-xs-6 input-group pull-left"><?php echo WUZHI_form::calendar('end',$end,1);?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label"></label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                            </div>
                        </div>

                    </form>
                </div>
            </section>
            <?php
            if($result) {
                ?>
                <section class="panel">
                    <div class="panel-body" id="panel-bodys">
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th class="tablehead">ID</th>
                                <th class="tablehead">所属栏目</th>
                                <th class="tablehead">标题</th>
                                <th class="tablehead">更新时间</th>
                                <th class="tablehead" width="120">选择</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($result AS $r) { ?>
                                <tr>
                                    <td><?php echo $r[ 'id'];?></td>
                                    <td><?php echo $categorys[$r['cid']]['name'];?></td>
                                    <td><a href="<?php echo $r['url'];?>" target="_blank"><?php echo p_htmlentities($r['title']);?></a></td>
                                    <td title="添加时间：<?php echo date('Y-m-d H:i:s',$r[ 'addtime']);?>"><?php echo time_format($r[ 'updatetime']);?></td>
                                    <td>
                                        <a href="javascript:select_id(<?php echo $r[ 'id'];?>,'<?php echo $r[ 'title'];?>')" class="btn btn-info btn-xs">选择</a>
                                    </td>
                                </tr>
                            <?php } ?>
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
                </section>
            <?php }?>
        </div>
    </div>
    <!-- page end-->
</section>
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3
        });
    })
    function select_id(id,title) {
        var dialog = top.dialog.get(window);
        var htmls = id+"~wuzhicms~"+title;
        dialog.close(htmls).remove();
        return false;
    }
</script>

