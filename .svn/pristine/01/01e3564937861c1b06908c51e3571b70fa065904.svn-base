<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(defined('IN_ADMIN') && !defined('HTML')) {
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
                <div><a href="#">苏夫吗苏联解体该起苏联解体该起事实上诉</a></div>
                <div><span class="nums">2014</span><span class="times">2014-04-15</span></div>
            </div>
            <div class="mimg"><img src="<?php echo R;?>img/img1.jpg"/></div>
        </li>
<?php $n++;}?>
</ul>
</section>
<?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
