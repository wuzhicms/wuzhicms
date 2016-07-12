<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<div class="container Site_map"> 当前位置：<a href="<?php echo WEBURL;?>">首页</a><span> &gt; <?php echo catpos($cid);?></span></div>

<div class="bankuai_1">
    <div class="container">
        <div class="row">
            <div class="col-xs-10" style="border-right:1px solid #eee">
                <h3>兑换礼品</h3>
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
                <div class="bignewsbox_g">
                    <div class="Nbd_g"><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>"></a>
                        <p><a href="<?php echo $r['url'];?>"><span style="font-weight:600"><?php echo $r['title'];?></span></a><br>
                            所需积分：<span class="color_danger"><?php echo $r['point'];?>积分</span><br>
                            库存：<span class="color_danger">有货</span><br>
                            使用范围：<?php echo strcut($r['remark'],60);?></p>
                        <p><a href="<?php echo $r['url'];?>" class="btn btn-danger" role="button">立即兑换</a></p>
                    </div>
                </div>
                <?php $n++;}?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
            </div>



            <div class="col-xs-2">
                <h4>==推荐礼品==</h4>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'10','start'=>'0','pagesize'=>'5','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
<ul>
<?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" width="134" alt="<?php echo $r['title'];?>"></a>
                <div class="caption">
                    <h5><?php echo strcut($r['title'],24);?></h5>
                    <p>现价： <span class=" color_danger"><?php echo $r['point'];?>积分</span></p>
                </div>
                <?php $n++;}?>
</ul>
<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

            </div>
        </div>
    </div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>