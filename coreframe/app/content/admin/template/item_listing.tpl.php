<?php
/**
 * 专题内容列表模板
 */
defined('IN_WZ') or exit('No direct script access allowed');
include $this->template('header', 'core');
$menu_r = $this->db->get_one('menu', array('m' => 'content', 'f' => 'block', 'v' => 'item_listing'));
$submenuid = $menu_r['menuid'];
?>
<body>
    <section class="wrapper">
        <form name="myform" action="?m=content&f=block&v=item_sort<?php echo $this->su(); ?>" method="post">
                    <section class="panel">
                        <?php echo $this->menu($submenuid, "&blockid=$blockid"); ?>
                        <div class="panel-body" id="panel-bodys">
                            <table class="table table-striped table-advance table-hover">
                                <thead>
                                    <tr>
                                        <th class="tablehead text-center">排序</th>
                                        <th class="hidden-phone tablehead">ID</th>
                                        <th class="hidden-phone tablehead">所属站点</th>
                                        <th class="tablehead w-50">标题</th>
                                        <th class="tablehead">更新时间</th>
                                        <th class="tablehead">原文状态</th>
                                        <th class="tablehead">管理操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($result as $r) {
                                    ?>
                                        <tr>
                                            <td class="text-center"><input class='text-center form-control' style="width: 35px;padding:3px;"  name="sorts[<?php echo $r['id']; ?>]" type='text' size='3' value='<?php echo $r['sort']; ?>'></td>
                                            <td><?php echo $r['id']; ?></td>
                                            <td><?php echo $sitelist[$r['siteid']]['name']; ?></td>
                                            <td><?php echo '<a href="' . $r['url'] . '" target="_blank">' . $r['title'] . '</a>'; ?></td>
                                            <td><?php echo time_format($r['addtime']); ?></td>
                                            <td><?php echo $this->status_array[$r['status']]; ?></td>
                                            <td>
                                                <a href="?m=content&f=block&v=item_edit&id=<?php echo $r['id']; ?><?php echo $this->su(); ?>" class="btn btn-primary btn-sm btn-xs">修改</a>
                                                <a href="javascript:makedo('?m=content&f=block&v=item_delete&id=<?php echo $r['id']; ?><?php echo $this->su(); ?>', '确认删除该记录？')" class="btn btn-danger btn-sm btn-xs">删除</a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="panel-foot">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="panel-label"> <button type="submit" name="submit" class="btn btn-default btn-sm">排序</button></div>
                                    <div class="panel-label">
                                        <ul class="pagination pagination-sm">
                                            <?php echo $pages; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>
                </form>
</section>
<?php include $this->template('footer', 'core'); ?>