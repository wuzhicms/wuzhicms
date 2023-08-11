<?php
/**
 * 审核列表模板
 */
defined('IN_WZ') or exit('No direct script access allowed');
include $this->template('header', 'core');
?>

<body class="body">
    <section class="wrapper">
        <section class="panel">
            <header class="panel-heading d-flex">
                <span class="dropdown examine">
                    <?php
                    echo $this->_status2($status);
                    ?>
                </span>
                <form class="ms-auto position" action="" method="get">
                    <input name="m" value="content" type="hidden">
                    <input name="f" value="content" type="hidden">
                    <input name="v" value="listing" type="hidden">
                    <input name="_su" value="<?php echo $GLOBALS['_su']; ?>" type="hidden">
                    <input name="status" value="<?php echo $status; ?>" type="hidden">
                    <input name="cid" value="<?php echo isset($cid) ? $cid : null; ?>" type="hidden">
                    <div class="input-append dropdown">
                        <input type="text" name="title" placeholder="搜索标题" class="sr-input" value="<?php echo isset($title) ? $title : null; ?>">
                        <button type="submit" class="btn sr-btn"><i class="icon-search"></i></button><button type="button" class="btn adsr-btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"></button>
                        <ul class="dropdown-menu dropdown-menu-dark" id="adsearch">
                            <li><a class="dropdown-item" href="?m=content&f=content&v=search<?php echo $this->su(); ?>">高级搜索</a></li>
                        </ul>
                    </div>
                </form>
            </header>
            <div class="panel-body" id="panel-bodys">
                <form name="myform" id="myform" method="post" action="?m=content&f=content&v=sort<?php echo $this->su(); ?>">
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                            <tr>
                                <th class="tablehead text-center">选择</th>
                                <th class="tablehead">ID</th>
                                <?php $modelid = isset($modelid) ? $modelid : null; ?>
                                <?php if ($modelid == 0) echo ' <th class="tablehead">所属栏目</th>'; ?>
                                <th class="tablehead w-50">标题</th>
                                <th class="tablehead">更新时间</th>
                                <th class="tablehead">管理操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result as $rs) {
                                foreach ($rs as $r) { ?>
                                    <tr>
                                        <td class="text-center"><input class="form-check-input" type="checkbox" name="ids[]" value="<?php echo $r['id']; ?>"></td>
                                        <td><?php echo $r['id']; ?></td>
                                        <?php if ($modelid == 0) echo ' <td>' . $categorys[$r['cid']]['name'] . '</td>'; ?>
                                        <td><a href="<?php if ($r['status'] == 9) {
                                                            echo $r['url'];
                                                        } else {
                                                            echo '?m=content&f=content&v=view&id=' . $r['id'] . '&cid=' . $r['cid'] . $this->su();
                                                        } ?>" target="_blank"><?php echo p_htmlentities($r['title']); ?></a></td>
                                        <td title="添加时间：<?php echo date('Y-m-d H:i:s', $r['addtime']); ?>"><?php echo time_format($r['updatetime']); ?></td>
                                        <td>
                                            <a href="?m=content&f=content&v=edit&id=<?php echo $r['id']; ?>&cid=<?php echo $r['cid'] . $this->su(); ?>" class="btn btn-primary btn-sm btn-xs">编辑</a>
                                            <a href="?m=content&f=content&v=view&id=<?php echo $r['id']; ?>&cid=<?php echo $r['cid']; ?><?php echo $this->su(); ?>" target="_blank" class="btn btn-default btn-sm btn-xs">审核</a>
                                            <a href="javascript:makedo('?m=content&f=content&v=<?php if ($status != 0) echo 'recycle_'; ?>delete&id=<?php echo $r['id']; ?>&cid=<?php echo $r['cid'] . $this->su(); ?>', '确认删除该记录？')" class="btn btn-danger btn-sm btn-xs">删除</a>
                                            <?php if ($cid == 69) { ?>
                                                <a href="?m=medical&f=jingjia&v=listing&id=<?php echo $r['id']; ?><?php echo $this->su(); ?>" class="btn btn-info btn-sm btn-xs">竞价</a><?php } ?>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                    <div class="panel-foot">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="panel-label">
                                <input id="v" name="v" type="hidden" value="<?php echo V; ?>">
                                <button type="button" onClick="checkall()" name="submit2" class="btn btn-default btn-sm">全选/反选</button>
                                <button type="submit" onclick="$('#v').val('move')" class="btn btn-default btn-sm">移动</button>
                                <input name="cid" value="<?php $cid; ?>" type="hidden">
                            </div>
                            <div class="panel-label">
                                <ul class="pagination pagination-sm">
                                    <?php echo isset($pages) ? $pages : null; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
        </section>
    </section>
    <?php include $this->template('footer', 'core'); ?>