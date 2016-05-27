<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<div style="background: #f3f3f3">
    <div class="container">
        <ol class="breadcrumb" style="margin-bottom: 0px">
            您现在的位置：
            <li><a href="#">B首页</a><span> &gt;</span></li>
            <?php echo catpos($cid);?>
        </ol>
    </div>
</div>
<br>


<div class="jifenmall-one-screen">
    <div class="container">
        <div class="row">
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'20','page'=>$page,));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <div class="col-xs-3">
                <div class="thumbnail">
                    <div class="pic_Control_g max-height-hide262" >
                        <a href="<?php echo $r['url'];?>"><img src="<?php echo imagecut($r['thumb'],271,181,4);?>" alt="..."></a>
                    </div>
                    <div class="caption">
                        <p class="titles manhangyichu"><a href="<?php echo $r['url'];?>"><strong>兑换礼品：<?php echo $r['title'];?></strong></a><br>
                            <span class="titles-sm">会员积分：<strong class="color_success"><?php echo $r['point'];?></strong> 积分   &nbsp;&nbsp; <?php if($r['price']!='0.00') { ?><strong class="color_success"><?php echo $r['point_money'];?></strong> 积分 + <strong class="color_qiyecheng"><?php echo $r['price'];?></strong>元<?php } ?></span>
                        </p>
                    </div>
                </div>
            </div>
            <?php $n++;}?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </div>
    </div>
    <div style="text-align:center;">
        <?php if($this->db->number>20) { ?>
        <nav style="text-align: center;">
            <ul class="pagination">
                <?php echo $pages;?>
            </ul>
        </nav>
        <?php } ?>
    </div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>