<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<nav class="navbar1 navbar-default">
    <!-- Note that the .navbar-collapse and .collapse classes have been removed from the #navbar -->
    <div id="navbar1" class="container">
        <ul class="nav navbar-nav" style="padding-left: 86px">
            <li class="active"><a href="<?php echo $category['url'];?>"><?php echo $category['name'];?>首页</a></li>
            <?php $n=1;if(is_array($sub_categorys)) foreach($sub_categorys AS $cats) { ?>
            <li><a href="<?php echo $cats['url'];?>"><?php echo $cats['name'];?></a></li>
            <?php $n++;}?>
        </ul>
    </div><!--/.nav-collapse -->
</nav>

<div class="video-one-screen">
    <div class="container">
        <div class="row">
            <div class="col-xs-9">
                <div class="row">
                     <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'32','start'=>'0','pagesize'=>'3','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <?php if($n==1) { ?>
            <div class="col-xs-8">
                <div class="narrowArt video">
                    <a href="<?php echo $r['url'];?>"  title="<?php echo $r['title'];?>">
                        <img  src="<?php echo imagecut($r['thumb'],562,380,4);?>" alt="<?php echo $r['title'];?>" height="380">
                        <h1><?php echo $r['title'];?></h1>
                    </a>
                </div>
            </div>
            <?php } else { ?>
            <div class="col-xs-4">
                <div class="narrowArt video">
                    <a href="<?php echo $r['url'];?>"  title="<?php echo $r['title'];?>">
                        <img  src="<?php echo imagecut($r['thumb'],272,182,4);?>"  alt="<?php echo $r['title'];?>" height="182">
                        <h2><?php echo $r['title'];?></h2>
                    </a>
                </div>
            </div>
            <?php } ?>
            <?php $n++;}?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="lm-title margin_bottom15 te-h3">
                    <h3 class="lm-title-left ">浏览排行 </h3>
                </div>
                <div class="list-ol-box">
                    <ol class="rectangle-list">
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'rank')) {
	$rs = $content_template_parse->rank(array('order'=>'weekviews DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'9','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <li ><a href="<?php echo $r[url];?>"><?php echo $r['title'];?></a></li>
                        <?php $n++;}?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ad-box">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div style="height: 120px; background: #ddd"><script  src="<?php echo WEBURL;?>promote/9.js"></script></div>
            </div>
        </div>
    </div>
</div>
<?php $video_num=10;?>
<?php $n=1; if(is_array($sub_categorys)) foreach($sub_categorys AS $videocid => $cats) { ?>
<div class="container">
    <div class="video-second-screen ">

        <div class="center-lanmu-title changlangbg">
            <h2 class="text-center "><a href="<?php echo $cats['url'];?>" ><?php echo $cats['name'];?></a></h2>
        </div>

        <div class="row" id="cat_<?php echo $videocid;?>">
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$videocid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'7','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <?php if($n==1) { ?>
            <div class="col-xs-3">
                <div class="narrowArt">
                    <a href="<?php echo $r['url'];?>" title="222">
                        <img  src="<?php echo imagecut($r['thumb'],273,380,4);?>" alt="" height="380">
                        <h2><?php echo $r['title'];?></h2>
                    </a>
                </div>
            </div>
            <?php } else { ?>
            <div class="col-xs-3">
                <div class="narrowArt" style="overflow: hidden;width: 273px;height: 182px;">
                    <a href="<?php echo $r['url'];?>" title="<?php echo $r['title'];?>">
                        <img  src="<?php echo imagecut($r['thumb'],273,257,4);?>" alt="" height="380">
                        <h2><?php echo $r['title'];?></h2>
                    </a>
                </div>
            </div>
            <?php } ?>
            <?php $n++;}?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </div>
    </div>
</div>

<div class="ad-box">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div style="height: 120px; background: #ddd"><script  src="<?php echo WEBURL;?>promote/<?php echo $video_num;?>.js"></script></div>
            </div>
        </div>
    </div>
</div>
<?php if($video_num<14) { ?>
<?php $video_num++; ?>
<?php } ?>
<?php $n++;}?>




<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>