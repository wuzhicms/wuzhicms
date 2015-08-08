<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
<div class="row">
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading">
        <span>内容高级搜索</span>
    </header>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="get" action="">
            <input name="m" value="content" type="hidden">
            <input name="f" value="content" type="hidden">
            <input name="v" value="search" type="hidden">
            <input name="_su" value="<?php echo $GLOBALS['_su'];?>" type="hidden">
            <input name="status" value="<?php echo $status;?>" type="hidden">
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">搜索类型</label>
                <div class="col-sm-2 input-group">
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
                <div class="col-sm-8 input-gorup">
                    <?php echo WUZHI_form::calendar('start',$start,1);?> - <?php echo WUZHI_form::calendar('end',$end,1);?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">状态</label>
                <div class="col-sm-2 input-group">
                    <?php echo $form->select($this->status_array, $status, 'name="status" id="status" class="form-control"');?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
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
        <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">ID</th>
                        <th class="tablehead">所属栏目</th>
                        <th class="tablehead">标题</th>
                        <th class="tablehead">更新时间</th>
                        <th class="tablehead" width="120">管理操作</th>
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
                                <a href="?m=content&f=content&v=view&id=<?php echo $r['id'];?>&cid=<?php echo $r['cid'];?><?php echo $this->su();?>" class="btn btn-success btn-xs"><i class="icon-checkmark"></i></a>
                                <a href="?m=content&f=content&v=edit&id=<?php echo $r['id'];?>&cid=<?php echo $r['cid'].$this->su();?>" class="btn btn-primary btn-xs"><i class="icon-pencil"></i></a>
                                <a href="javascript:makedo('?m=content&f=content&v=<?php if($status!=0) echo 'recycle_';?>delete&id=<?php echo $r['id'];?>&cid=<?php echo $r['cid'].$this->su();?>', '确认删除该记录？')" class="btn btn-danger btn-xs"><i class="icon-x "></i></a>
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
</script>

