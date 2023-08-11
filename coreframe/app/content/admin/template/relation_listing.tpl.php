<?php
/**
 * 相关文章选择操作页面模板
 */
defined('IN_WZ') or exit('No direct script access allowed');
?>
<div class="task-content mb-0">
    <ul class="task-list pt-2">
        <?php foreach ($result as $r) {
        ?>
            <li class="cur" onclick="changeList('<?php echo p_htmlentities($r['title']); ?>','<?php echo $r['url']; ?>',<?php echo $r['id']; ?>,<?php echo $r['cid']; ?>);">
                <div class="task-checkbox">
                    <?php echo $r['id']; ?>
                </div>
                <div class="d-flex task-title justify-content-between">
                    <span class="task-title-sp" title="<?php echo p_htmlentities($r['title']); ?>"><?php echo p_htmlentities(strcut($r['title'], 45)); ?></span>
                    <div class="data">
                        <?php echo date('Y/m/d', $r['updatetime']); ?>
                    </div>
                </div>
            </li>

        <?php } ?>
        <div class="p-3 text-center"><a class="btn btn-default btn-sm me-2" href="javascript:" onclick="changepage(<?php echo max(1, $page - 1); ?>);">上一页</a>
            <a class="btn btn-default btn-sm ms-2" href="javascript:" onclick="changepage(<?php echo max(1, $page + 1); ?>);">下一页</a>
        </div>
    </ul>
</div>