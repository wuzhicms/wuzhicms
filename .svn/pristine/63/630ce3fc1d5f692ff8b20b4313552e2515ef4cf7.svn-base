<?php defined('IN_WZ') or exit('No direct script access allowed'); ?>                                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'19','start'=>'0','pagesize'=>'10','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                                <ul>
                                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                                    <li><?php echo $r["title"];?></li>
                                <?php $n++;}?>
                                </ul>
                                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                                