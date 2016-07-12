<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><div class="panel-heading">
    <h3 class="panel-title">
        <span class="glyphicon glyphicon-list-alt"></span> 全部评论
    </h3>
</div>

<div class="panel-body">
    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"dianping\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('dianping_template_parse')) {
	$dianping_template_parse = load_class("dianping_template_parse", "dianping");
}
if (method_exists($dianping_template_parse, 'listing')) {
	$rs = $dianping_template_parse->listing(array('keyid'=>$keyid,'start'=>'0','pagesize'=>'10','page'=>$page,));
	$pages = $dianping_template_parse->pages;$number = $dianping_template_parse->number;}?>
    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
    <div class="media" style="border-bottom:1px solid #ddd; padding-bottom:16px;"> <div class="media-left"> <img class="img-circle" src="<?php echo avatar($r['uid'], 180);?>" width="60px" alt="...">
        <div style="width:100px; line-height:1.6; padding-top:4px;" class="manhangyichu" > <?php echo $r['username'];?><br>
            <span class=" color_777 font_size12"><?php echo $r['groupname'];?></span> </div>
    </div>
        <div class="media-body">
            <?php if($r['field4']) { ?><?php echo $r['field4'];?><?php } ?>
            <?php if($r['field5']) { ?><?php echo $r['field5'];?><?php } ?>
            <br>
            <span class="font_size12 color_777"><?php echo time_format($r['addtime']);?></span>
            <?php if($r['data']) { ?>
<?php $imgrs = explode("\r\n",$r['data']);?>
            <div class="shangchuangimg" >
                <ul>
                    <?php $n=1;if(is_array($imgrs)) foreach($imgrs AS $img) { ?>
                    <li><img class="thumbnail" src="<?php echo $img;?>" width="80px;" ></li>
                    <?php $n++;}?>
                </ul>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php $n++;}?>
    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
</div>
<?php if($number>10) { ?>
<div style="text-align:center">
    <ul class="pagination">
        <?php echo $pages;?>
    </ul>
</div>
<?php } ?>