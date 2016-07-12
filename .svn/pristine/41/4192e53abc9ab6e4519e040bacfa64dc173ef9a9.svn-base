<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<div class="container Site_map"> 当前位置：<a href="<?php echo WEBURL;?>">首页</a><span> &gt; <?php echo catpos($cid);?></span></div>

<div class="bankuai_1">
    <div class="container">
        <div class="row">
            <div class="col-xs-8" style="border-right:1px solid #eee">
                <?php $n=1;if(is_array($sub_categorys)) foreach($sub_categorys AS $cats) { ?>
                <h3><?php echo $cats['name'];?><span class="lm_more"><a href="<?php echo $cats['url'];?>">更多&raquo;</a></span></h3>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'20','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <div class="bignewsbox">
                    <div class="Nhead"><a href="<?php echo $r[url];?>"><?php echo $r['title'];?></a></div>
                    <div class="Nbd"><?php if($r[thumb]) { ?><a href="<?php echo $r[url];?>"><img src="<?php echo $r[thumb];?>"></a><?php } ?>
                        <p><?php echo strcut($r['remark'],200,'...');?></p>
                    </div>
                    <div class="Nfoot">
                        <div class="lwd"><?php echo date('Y-m-d',$r['addtime']);?></div>
                    </div>
                </div>

                <?php $n++;}?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                <?php $n++;}?>

            </div>
            <div class="col-xs-4">
                <div class="rightad_boxg"><img src="<?php echo R;?>haiwaitou/image/ad2.jpg" width="300" height="233"></div>
                <div class="right_hot" id="righthot">
                    <h4>浏览排行</h4>
                    <div class="list-group">
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'rank')) {
	$rs = $content_template_parse->rank(array('order'=>'monthviews DESC','start'=>'0','pagesize'=>'10','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <a href="<?php echo $r['url'];?>" class="list-group-item_gr active"><span class="badge_top"><?php echo str_pad($n, 2, "0", STR_PAD_LEFT);?> </span>&nbsp;<?php echo strcut($r['title'],36);?></a>
                        <?php $n++;}?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>