<?php
    defined('IN_WZ') or exit('No direct script access allowed');
    include $this->template('header', 'core');
?>
<body class="body">
    <section class="wrapper">
        <section class="panel">
            <header class="panel-heading d-flex">
                <span class="dropdown addcontent">
                    <?php
                    if ($modelid == 0) {
                    ?>
                        <a href="?m=content&f=content&v=listing<?php echo $this->su(); ?>" class="btn btn-info btn-sm">共享模型数据列表</a>
                    <?php
                    } elseif ($master_table == 'content_share') {
                    ?>
                        <a href="#" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="icon-plus btn-icon"></i>添加内容</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <?php
                            echo $this->_show_share_add($cid);
                            ?>
                        </ul>
                    <?php } else {
                    ?>
                        <a href="?m=content&f=content&v=add&modelid=<?php echo $modelid; ?>&cid=<?php echo $cid . '&type=' . $GLOBALS['type'] . $this->su(); ?>" class="btn btn-info btn-sm "><i class="icon-plus btn-icon"></i>添加内容</a>
                    <?php
                    } ?>
                </span>
                <span class="dropdown examine ms-2">
                    <?php
                    echo $this->_status($status);
                    ?>
                </span>
                <form class="position ms-auto" action="" method="get">
                    <input name="m" value="content" type="hidden">
                    <input name="f" value="content" type="hidden">
                    <input name="v" value="listing" type="hidden">
                    <input name="type" value="<?php echo $type; ?>" type="hidden">
                    <input name="_su" value="<?php echo $GLOBALS['_su']; ?>" type="hidden">
                    <input name="status" value="<?php echo $status; ?>" type="hidden">
                    <input name="cid" value="<?php echo $cid; ?>" type="hidden">
                    <div class="input-append dropdown">
                        <input type="text" name="title" placeholder="搜索标题" class="sr-input" value="<?php echo isset($title) ? $title : null;?>">
                        <button type="submit" class="btn sr-btn"><i class="icon-search"></i></button><button type="button" class="btn adsr-btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"></button>
                        <ul class="dropdown-menu dropdown-menu-dark" id="adsearch">
                            <li><a class="dropdown-item" href="?m=content&f=content&v=search<?php echo $this->su();?>">高级搜索</a></li>
                        </ul>
                    </div>
                </form>
            </header>
            <div class="panel-body" id="panel-bodys">
                <form name="myform" id="myform" method="post" action="?m=content&f=content&v=sort<?php echo $this->su(); ?>" onsubmit="return check_myform();">
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th class="tablehead text-center">选择</th>
                                <th class="tablehead">排序</th>
                                <th class="tablehead">ID</th>
                                <?php if ($modelid == 0) echo ' <th class="tablehead">所属栏目</th>'; ?>
                                <th class="tablehead w-50">标题</th>
                                <th class="tablehead">更新时间</th>
                                <th class="tablehead">管理操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $r) :  ?>
                               
                                <tr title="<?php echo $models[$r['modelid']]['name']; ?>">
                                    <td class="text-center"><input class="form-check-input" type="checkbox" name="ids[]" value="<?php echo $r['id']; ?>"></td>
                                    <td><input type="text" class="text-center form-control" style="width: 35px;padding:3px;" name="sorts[<?php echo $r['id']; ?>]" value="<?php echo $r['sort']; ?>"></td>
                                    <td><?php echo $r['id']; ?></td>
                                    <?php if ($modelid == 0) echo ' <td>' . $categorys[$r['cid']]['name'] . '</td>'; ?>
                            <td><a <?php if ($r['status'] != 9) {?>class="text-danger" "<?php }?> href="<?php if ($r['status'] == 9) {
                                                        if (strpos($r['url'], '://') === false) {
                                                            echo $this->siteurl;
                                                            echo $r['url'];
                                                        } else {
                                                            echo $r['url'];
                                                        }
                                                    } else {
                                                        echo '?m=content&f=content&v=view&id=' . $r['id'] . '&cid=' . $r['cid'] . $this->su();
                                                    } ?>" target="_blank" title="<?php echo p_htmlentities($r['title']); ?>"><?php echo p_htmlentities($r['title']); ?></a>
                                                    <?php if ($r['block']) { ?><small class="icon_good">推</small><?php } if ($r['thumb']) { ?> <small class="icon_img">图</small><?php } if ($r['push']) { ?> <small class="icon_push">荐</small><?php } if ($r['video']) { ?><small class="icon_img">影</small><?php }?>
                                    </td>
                                    <td title="更新时间：<?php echo date('Y-m-d H:i:s', $r['updatetime']); ?>"><?php echo time_format($r['addtime']); ?></td>
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
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="panel-foot">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="panel-label">
                                <input id="v" name="v" type="hidden" value="<?php echo V; ?>">
                                <button type="button" onClick="checkall()" name="submit2" class="btn btn-default btn-sm">全选/反选</button>
                                <button type="submit" onclick="$('#v').val('sort')" name="submit" class="btn btn-default btn-sm">排序</button>
                                <button type="submit" onclick="$('#v').val('push')" class="btn btn-default btn-sm">推送内容</button>
                                <button type="submit" onclick="$('#v').val('move')" class="btn btn-default btn-sm">移动</button>
                                <?php if ($cid) { ?>
                                    <button type="submit" onclick="$('#v').val('delete_more')" class="btn btn-default btn-sm">批量删除</button><?php } ?>
                                <input name="status" value="<?php echo $status; ?>" type="hidden">
                                <input name="cid" value="<?php echo $cid; ?>" type="hidden">
                            </div>
                            <div class="panel-label">
                                <ul class="pagination pagination-sm">
                                    <?php echo $pages; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </section>
    <script>
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

         //自动退出编辑模式
        $(function () {
            $(".content-panel").removeClass("content-panel-edit-mode");
            $("body" , window.top.document).removeClass("edit_mode");
            $("body" , window.parent.document).removeClass("edit_mode");
        });

    </script>
    <?php include $this->template('footer', 'core'); ?>
