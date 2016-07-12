<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'5','start'=>'0','pagesize'=>'4','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
<h3>首页头条推荐<span class="lm_more"></span></h3>
                <div class="list-group">
<?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
<?php $attach=unserialize($r['attach'])?>
<a href="<?php echo $r['url'];?>" class="list-group-item">
                    <h4 class="list-group-item-heading"><span class="badge"><?php echo $categorys[$attach['cid']]['name'];?></span> <?php echo strcut($r['title'],40);?></h4>
                    <p class="list-group-item-text">&nbsp;<?php echo strcut($r['remark'],50);?></p>
                </a>
<?php $n++;}?>
</div>
<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>