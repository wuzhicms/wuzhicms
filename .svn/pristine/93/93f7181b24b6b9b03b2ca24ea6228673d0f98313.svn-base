<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<link type="text/css" rel="stylesheet" href="<?php echo R;?>h1jk/css/abouts_style.css">
<!-- ---------------------------------- -->
<div class="container">
        <div class="abouts_box">
                <div class="row">
                        <div class="col-xs-12">
                                <div class="yqlinksbox">

                                        <h3 style="color:#26496d; font-weight:600;padding: 20px 0px 0px 0px;"><a href="" title="更多商家">签约商家</a></h3>
                                        <p>全国体检预约第一品牌，公信有力！提供全国3万家签约机构预订服务！</p><br>


                                        <div class="row">
                                                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"link\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('link_template_parse')) {
	$link_template_parse = load_class("link_template_parse", "link");
}
if (method_exists($link_template_parse, 'listing')) {
	$rs = $link_template_parse->listing(array('kid'=>'2','order'=>'sort ASC','start'=>'0','pagesize'=>'20','page'=>'0',));
	$pages = $link_template_parse->pages;$number = $link_template_parse->number;}?>
                                                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                                                <div class="col-xs-2">
                                                        <div class="thumbnail">
                                                                <img src="<?php echo $r['logo'];?>" >
                                                                <div class="caption">
                                                                        <p><?php echo $r['sitename'];?></p>
                                                                </div>
                                                        </div>
                                                </div>
                                                <?php $n++;}?>
                                                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                                        </div>

                                        <hr/>
                                        <h3 style="color:#26496d; font-weight:600; padding: 20px 0px 0px 0px;"><a href="" title="更多商家">入驻企业</a></h3>
                                        <p>全国50个城市，30000家医院，只为给你一个最佳的选择。团体体检解决方案提供商！<br>
                                                企事业单位，学校，社团，工厂，公司,量身为您定制体检方案！</p><br>

                                        <div class="row">
                                                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"link\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('link_template_parse')) {
	$link_template_parse = load_class("link_template_parse", "link");
}
if (method_exists($link_template_parse, 'listing')) {
	$rs = $link_template_parse->listing(array('kid'=>'3','order'=>'sort ASC','start'=>'0','pagesize'=>'20','page'=>'0',));
	$pages = $link_template_parse->pages;$number = $link_template_parse->number;}?>
                                                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                                                <div class="col-xs-2">
                                                        <div class="thumbnail">
                                                                <img src="<?php echo $r['logo'];?>" >
                                                                <div class="caption">
                                                                        <p><?php echo $r['sitename'];?></p>
                                                                </div>
                                                        </div>
                                                </div>
                                                <?php $n++;}?>
                                                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                                        </div>


                                        <hr/>
                                        <h3 style="color:#26496d; font-weight:600; padding: 20px 0px 0px 0px;"><a href="" title="更多商家">合作网站</a></h3>
                                        <p> </p><br>

                                        <div class="row">
                                                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"link\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('link_template_parse')) {
	$link_template_parse = load_class("link_template_parse", "link");
}
if (method_exists($link_template_parse, 'listing')) {
	$rs = $link_template_parse->listing(array('kid'=>'1','order'=>'sort ASC','start'=>'0','pagesize'=>'20','page'=>'0',));
	$pages = $link_template_parse->pages;$number = $link_template_parse->number;}?>
                                                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                                                <div class="col-xs-2">
                                                        <div class="thumbnail">
                                                                <img src="<?php echo $r['logo'];?>" >
                                                                <div class="caption">
                                                                        <p><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['sitename'];?></a></p>
                                                                </div>
                                                        </div>
                                                </div>
                                                <?php $n++;}?>
                                                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                                        </div>

                                </div>
                        </div>
                </div>
        </div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>