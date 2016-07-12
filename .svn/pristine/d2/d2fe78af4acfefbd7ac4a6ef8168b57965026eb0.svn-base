<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('tags','header'); ?>


<ul>
<?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"tags\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('tags_template_parse')) {
	$tags_template_parse = load_class("tags_template_parse", "tags");
}
if (method_exists($tags_template_parse, 'listing')) {
	$rs = $tags_template_parse->listing(array('order'=>'number DESC','start'=>'0','pagesize'=>'10','page'=>$page,));
	$pages = $tags_template_parse->pages;$number = $tags_template_parse->number;}?>
<?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
<li><?php echo $r[tid];?> <a href="<?php echo $r[url];?>"><?php echo safe_htm($r['tag']);?></a>(<?php echo $r['number'];?>)</li>
<?php $n++;}?>
<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
</ul>
分页：<?php echo $pages;?>
<hr>

区块展示：


</body>
</html>