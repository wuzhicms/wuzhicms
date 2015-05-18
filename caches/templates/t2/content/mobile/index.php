<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<section class="jdbox">
    <div class="jdt"><?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'7','start'=>'0','pagesize'=>'1','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
<ul>
<?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
<div class="tit"><?php echo $r["title"];?></div><a href="<?php echo $r["url"];?>"><img src="<?php echo imagecut($r["thumb"],600,400,4);?>"/></a>
<?php $n++;}?>
</ul>
<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
</div>
</section>
<?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'8','start'=>'0','pagesize'=>'5','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
<section class="cbox">
    <ul class="colst">
<?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <li>
                <div class="bl">
                    <div><a href="<?php echo $r['url'];?>"><?php echo safe_htm($r['title']);?></a></div>
                    <div><span class="nums"><?php echo $categorys[$r['cid']]['name'];?></span><span class="times"><?php echo date('Y-m-d',$r['addtime']);?></span></div>
                </div>
                <?php if($r['thumb']) { ?><div class="mimg"><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" width="60" height="60"/></a></div><?php } ?>
            </li>
            <?php $n++;}?>
</ul>
</section>
<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

<?php $n=1; if(is_array($categorys)) foreach($categorys AS $cid => $cat) { ?>
<?php if($cat['showloop'] && $cat['type']==0) { ?>
<section class="pdbox">
    <header class="pdtit">
        <h6><?php echo $cat['name'];?></h6>
    </header>
    <article>
        <ul class="colst">
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$cid,'start'=>'0','pagesize'=>'8','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <li>
                <div class="bl">
                    <div><a href="<?php echo $r['url'];?>"><?php echo safe_htm($r['title']);?></a></div>
                    <div><span class="nums"><?php echo $categorys[$r['cid']]['name'];?></span><span class="times"><?php echo date('Y-m-d',$r['updatetime']);?></span></div>
                </div>
                <?php if($r['thumb']) { ?><div class="mimg"><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" width="60" height="60"/></a></div><?php } ?>
            </li>
            <?php $n++;}?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </ul>
        <a href="<?php echo $cat['url'];?>"><div class="more_btn"><span>更多<?php echo $cat['name'];?></span></div></a>
    </article>
</section>
<?php } ?>
<?php $n++;}?>
<footer class="ft">
    Copyright 2005 - 2015 WuzhiCMS. All Rights Reserved
</footer>
</body>
</html>
