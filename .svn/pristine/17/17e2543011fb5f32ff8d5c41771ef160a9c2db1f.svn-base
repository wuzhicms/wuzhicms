<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><!doctype html>
<html>
<head>
    <meta charset="<?php echo CHARSET;?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="format-detection" content="telephone=no" />
    <title><?php echo $seo_title;?></title>
    <meta name="keywords" content="<?php echo $seo_keywords;?>">
    <meta name="description" content="<?php echo $seo_description;?>">
    <link href="<?php echo R;?>css/mob.css" rel="stylesheet" type="text/css">
    <link href="<?php echo R;?>css/new.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo R;?>js/jquery.min.js"></script>
</head>

<body>
<section class="tbox">
    <div class="topbar">
        <!--<aside class="fr tbr"><a href="#">导航</a></aside>-->
        <div class="logo"><a href="<?php echo WEBURL;?>index.php"><img src="<?php echo R;?>images/mologo.png" height="30" width="100%"/></a></div>
    </div>
    <header class="navbox">
        <ul class="navlst">
            <li><a href="<?php echo WEBURL;?>" <?php if(!isset($cid)) { ?>class="ac"<?php } ?>>首页</a></li><?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'category')) {
	$rs = $content_template_parse->category(array('mshow'=>'1','order'=>'sort ASC','start'=>'0','pagesize'=>'100','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?><?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?><li><a href="<?php echo $r[url];?>" <?php if(isset($cid) && $cid==$r['cid']) { ?>class="ac"<?php } ?>><?php echo $r['mb'];?></a></li><?php $n++;}?><?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </ul>
    </header>
</section>