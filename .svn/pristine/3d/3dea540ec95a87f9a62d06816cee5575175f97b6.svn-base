<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'6','start'=>'0','pagesize'=>'3','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
<?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
<div class="item <?php if($n==1) { ?>active<?php } ?>"><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>" width="465" height="300"></a>
                            <div class="carousel-caption"> ... </div>
                        </div>
<?php $n++;}?>
<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
