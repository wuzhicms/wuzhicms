<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<div class="task-content">

    <ul class="task-list">
        <?php foreach($result AS $r) {

            ?>
            <li class="cur" onclick="changeList('<?php echo p_htmlentities($r['title']);?>','<?php echo $r['url'];?>',<?php echo $r['id'];?>,<?php echo $r['cid'];?>);">
                <div class="task-checkbox">
                    <?php echo $r['id'];?>
                </div>
                <div class="task-title">
                    <span class="task-title-sp" title="<?php echo p_htmlentities($r['title']);?>"><?php echo p_htmlentities(strcut($r['title'],45));?></span>
                    <div class="pull-right hidden-phone">
                        <?php echo date('Y/m/d',$r['updatetime']);?>
                    </div>
                </div>
            </li>

        <?php }?>
        <div style="padding: 3px 50px;"><a class="btn btn-default btn-sm pull-left"  href="javascript:;" onclick="changepage(<?php echo max(1,$page-1);?>);">上一页</a>
        <a class="btn btn-default btn-sm pull-right" href="javascript:;" onclick= "changepage(<?php echo max(1,$page+1);?>);">下一页</a></div>
    </ul>
</div>
