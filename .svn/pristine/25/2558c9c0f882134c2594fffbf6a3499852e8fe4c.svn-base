<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(defined('IN_ADMIN') && !defined('HTML')) {
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
