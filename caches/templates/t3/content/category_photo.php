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
<div class="photo-one-screen">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'34','start'=>'0','pagesize'=>'10','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <div class="item <?php if($n==1) { ?> active <?php } ?>">
                            <a href="<?php echo $r['url'];?>"><img src=" <?php echo imagecut($r['thumb'],1140,550,4);?>" alt="<?php echo $r['title'];?>"></a>
                            <div class="carousel-caption">
                                <h3 class="margin_bottom20 line_height1d8"><?php echo $r['title'];?></h3>
                            </div>
                        </div>
                        <?php $n++;}?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                                
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>


        </div>
    </div>
</div>
<?php $photo_num=17;?>
<!-- 图片 -->
<?php $n=1; if(is_array($sub_categorys)) foreach($sub_categorys AS $photocid => $cats) { ?>
<div class="container">
    <div class="index-pic-box ">
        <div class="center-lanmu-title changlangbg">
            <h2 class="text-center "><a href="<?php echo $cats['URL'];?>" ><?php echo $cats['name'];?></a></h2>
        </div>

        <div class="row" id="cat_<?php echo $photocid;?>">
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$photocid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'7','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <?php if($n==1) { ?>
            <div class="col-xs-3">
                <div class="narrowArt">
                    <a href="<?php echo $r['url'];?>" title="222">
                        <img  src="<?php echo imagecut($r['thumb'],273,380,4);?>" alt="<?php echo $r['title'];?>" height="380">
                        <h2><?php echo $r['title'];?></h2>
                    </a>
                </div>
            </div>
            <?php } else { ?>
            <div class="col-xs-3">
                <div class="narrowArt pic_height">
                    <a href="<?php echo $r['url'];?>" alt="<?php echo $r['title'];?>">
                        <img  src="<?php echo imagecut($r['thumb'],273,182,4);?>" alt="<?php echo $r['title'];?>" width="275">
                        <h2><?php echo $r['title'];?></h2>
                    </a>
                </div>
            </div>
            <?php } ?>
            <?php $n++;}?>
            <!-----------长型灰框------------------------>
            <div class="ad-box">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div style="height: 120px; background: #ddd"><script  src="<?php echo WEBURL;?>promote/<?php echo $photo_num;?>.js"></script></div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </div>
    </div>
</div>
<?php if($photo_num<19) { ?>
<?php $photo_num++; ?>
<?php } ?>
<?php $n++;}?>

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>