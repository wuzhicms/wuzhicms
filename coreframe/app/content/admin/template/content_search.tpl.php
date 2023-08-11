<?php
    defined('IN_WZ') or exit('No direct script access allowed');
    include $this->template('header', 'core');
?>

<body>
    <section class="wrapper">
        <section class="panel">
            <header class="panel-heading"><span>内容高级搜索</span></header>
            <div class="panel-body">
                <form class="form-horizontal tasi-form" method="get" action="">
                    <input name="m" value="content" type="hidden">
                    <input name="f" value="content" type="hidden">
                    <input name="v" value="search" type="hidden">
                    <input name="_su" value="<?php echo $GLOBALS['_su']; ?>" type="hidden">
                    <input name="status" value="<?php echo $status; ?>" type="hidden">
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <div class="row">
                                <label class="col-sm-3 control-label col-form-label">搜索类型</label>
                                <div class="col-sm-9">
                                    <?php echo WUZHI_form::select($options, $stype, 'name="stype" id="stype" class="form-select"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="row">
                                <label class="col-sm-3 control-label col-form-label">状态</label>
                                <div class="col-sm-9">
                                    <?php echo WUZHI_form::select($this->status_array, $status, 'name="status" id="status" class="form-select"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="row">
                                <label class="col-sm-3 control-label col-form-label">发布时间 </label>
                                <div class="col-sm-9 input-gorup row">
                                    <div class="col-sm-5 p-0">
                                        <?php echo WUZHI_form::calendar('start', $start); ?>
                                    </div>
                                    <div class="col-sm-1 d-inline-block lh-lg pe-1 ps-2">-</div>
                                    <div class="col-sm-5 p-0">
                                        <?php echo WUZHI_form::calendar('end', $end); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="row">
                                <label class="col-sm-3 control-label col-form-label">关键字</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="keywords" value="<?php echo $keywords; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="row">
                                <label class="col-sm-3 control-label col-form-label">所属栏目 </label>
                                <div class="col-sm-9 col-sm-4 col-xs-4">
                                    <?php
                                    echo WUZHI_form::tree_select($categorys, $cid, 'name="cid" class="form-select" ', '≡ 全部 ≡');
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-sm-4 row">
                                <label class="col-sm-3 control-label col-form-label"> </label>
                                <div class="col-sm-9 col-sm-4 col-xs-4">
                                    <input class="btn btn-info col-sm-4 mb-3 btn-sm" type="submit" name="submit" value="提交">
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </section>
        <?php
        if ($result) {
        ?>
            <section class="panel">
                <div class="panel-body" id="panel-bodys">
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th class="tablehead">ID</th>
                                <th class="tablehead">所属栏目</th>
                                <th class="tablehead w-50">标题</th>
                                <th class="tablehead">更新时间</th>
                                <th class="tablehead">管理操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $r) { ?>
                                <tr>
                                    <td><?php echo $r['id']; ?></td>
                                    <td><?php echo $categorys[$r['cid']]['name']; ?></td>
                                    <td><a href="<?php echo $r['url']; ?>" target="_blank"><?php echo p_htmlentities($r['title']); ?></a><?php if ($r['block']) { ?><small class="icon_good">推</small><?php } if ($r['thumb']) { ?> <small class="icon_img">图</small><?php } if ($r['push']) { ?> <small class="icon_push">荐</small><?php } ?></td>
                                    <td title="添加时间：<?php echo date('Y-m-d H:i:s', $r['addtime']); ?>"><?php echo time_format($r['updatetime']); ?></td>
                                    <td>
                                        <a href="?m=content&f=content&v=edit&id=<?php echo $r['id']; ?>&type=<?php echo $type; ?>&cid=<?php echo $r['cid'] . $this->su(); ?>" class="btn btn-primary btn-sm btn-xs">编辑</a>
                                        <?php if ($r['status'] != 9) { ?>
                                        <a href="?m=content&f=content&v=precesscheck&id=<?php echo $r['id']; ?>&cid=<?php echo $r['cid']; ?><?php echo $this->su(); ?>" target="_blank" class="btn btn-default btn-sm btn-xs">审核</a><?php } else {
                                            ?>
                                            <a href="javascript:" onclick="check_records(<?php echo $r['id']; ?>,<?php echo $r['cid']; ?>,'<?php echo safe_htm($r['title']); ?>');" class="btn btn-default btn-sm btn-xs">审批记录</a>
                                            <?php
                                        } ?>
                                        <a href="javascript:makedo('?m=content&f=content&v=<?php if ($status != 0) echo 'recycle_'; ?>delete&id=<?php echo $r['id']; ?>&cid=<?php echo $r['cid'] . $this->su(); ?>', '确认删除该记录？')" class="btn btn-danger btn-sm btn-xs">删除</a>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <div class="panel-foot">
                        <ul class="pagination pagination-sm">
                            <?php echo $pages; ?>
                        </ul>
                    </div>
            </section>
        <?php } ?>
        <!-- page end-->
    </section>
    <script type="text/javascript">
        function check_myform() {
            if ($("#v").val() == 'delete_more') {
                if (confirm('批量删除后,无法恢复-请确认?')) {

                } else {
                    return false;
                }
            }
        }
        function check_records(id, cid, name) {
            top.openiframe('index.php?m=content&f=content&v=view_checkrecords&cid=' + cid + '&id=' + id + '<?php echo $this->su(); ?>', 'records', '【' + name + '】的审批记录', 800, 400);
        }
    </script>
    <?php include $this->template('footer', 'core'); ?>
