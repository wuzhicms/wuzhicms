<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<nav class="navbar1 navbar-default">
    <!-- Note that the .navbar-collapse and .collapse classes have been removed from the #navbar -->
    <div id="navbar1" class="container">
        <ul class="nav navbar-nav" style="padding-left: 86px">
            <li class="active"><a href="<?php echo $category['url'];?>"><?php echo $category['name'];?>A首页</a></li>
            <?php $n=1;if(is_array($sub_categorys)) foreach($sub_categorys AS $cats) { ?>
            <li><a href="<?php echo $cats['url'];?>"><?php echo $cats['name'];?></a></li>
            <?php $n++;}?>
        </ul>
    </div><!--/.nav-collapse -->
</nav>

<!---------------------以上是头部-------------------------------------------------------------------------------->
<div class="news-one-screen">
    <div class="container">
        <div class="row">
            <div class="col-xs-8">
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
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'33','start'=>'0','pagesize'=>'3','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
<div class="item <?php if($n==1) { ?>active<?php } ?>">
    <a href="<?php echo $r['url'];?>" target="_blank">
        <div style="max-height: 370px; overflow: hidden">
            <img src=" <?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>">
        </div>
        
        <div class="carousel-caption">
            <h3 style="font-weight: normal; margin-bottom:  16px"><?php echo $r['title'];?></h3>
        </div>
    </a>
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
<!--------------------------以上是动画 幻灯片----------------------------------------------------------------->

            <div class="col-xs-4 ">
                <div class="right-bg-box xielinebg">
                    <div class="lm-title margin_bottom15">
                        <h3 class="lm-title-left">热点专题 </h3>
                        <!--<a href="" class="lm-title-right"><small>+更多</small> </a>-->
                    </div>
                    <div class="headline-news-list right-bg-media">
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'3','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <div class="media">
                                <?php if($r['thumb']) { ?>
                            <div class="media-left ">
                                <a href="<?php echo $r['url'];?>">
                                    <img class="media-object" src="<?php echo $r['thumb'];?>" alt="..." width="105px" >
                                </a>
                            </div>
                                <?php } ?>
                            <div class="media-body">
                                <h5 class="media-heading manhangyichu"><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></h5>
                                <div class="media-content" ><?php echo strcut($r['remark'],100,'...');?></div>
                            </div>
                        </div>
                        <?php $n++;}?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-------------------以上是右边上方的热点专题------------------------------------------------------------------->

<div class="news-second-screen">
    <div class="container">
        <div class="row">
            <div class="col-xs-8">
                <!--news-tabs-box-->
                <div class="news-tabs-box">

                    <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">

                        <div id="sidebar">
                            <ul id="myTabs" class="nav nav nav-tabs" role="tablist" style="width: 755px;"><!--<ul id="myTabs" class="nav nav-pills nav-stacked" role="tablist">-->  <!--胶囊标签  /  竖向标签 -->

                                <li role="presentation" class="active"><a href="#news" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">最新</a></li>

                                <?php $n=1; if(is_array($sub_categorys)) foreach($sub_categorys AS $newcid => $cats) { ?>
                                <li role="presentation" class=""><a href="#cat_<?php echo $newcid;?>" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false"><?php echo $cats['name'];?></a></li>
                                <?php $n++;}?>
                            </ul>
                        </div>


                        <div id="myTabContent" class="tab-content ">
                            <div role="tabpanel" class="tab-pane fade active in" id="news" aria-labelledby="home-tab">
                                <div class="headline-news-list">

                                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'20','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                                    <div class="media">
                                        <?php if($r['thumb']) { ?>
                                        <div class="media-left ">
                                            <a href="<?php echo $r['url'];?>">
                                                <img class="media-object" src="<?php echo $r['thumb'];?>" alt="..." width="165px" height="110px">
                                            </a>
                                        </div>
                                        <?php } ?>
                                        <div class="media-body">
                                            <h4 class="media-heading manhangyichu"><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></h4>
                                            <div class="media-content" ><?php echo strcut($r['remark'],200,'...');?></div>
                                        </div>
                                    </div>
                                    <?php $n++;}?>
                                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                                </div>
                            </div>

                            <?php $n=1; if(is_array($sub_categorys)) foreach($sub_categorys AS $newcid => $cats) { ?>
                            <div role="tabpanel" class="tab-pane fade" id="cat_<?php echo $newcid;?>" aria-labelledby="profile-tab">
                                <div class="headline-news-list">
                                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$newcid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'20','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                                    <div class="media">
                                        <?php if($r['thumb']) { ?>
                                        <div class="media-left ">
                                            <a href="<?php echo $r['url'];?>">
                                                <img class="media-object" src="<?php echo $r['thumb'];?>" alt="..." width="165px" height="110px">
                                            </a>
                                        </div>
                                        <?php } ?>
                                        <div class="media-body">
                                            <h4 class="media-heading manhangyichu"><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></h4>
                                            <div class="media-content" ><?php echo trim(strcut($r['remark'],200,'...'));?></div>
                                        </div>
                                    </div>
                                    <?php $n++;}?>
                                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

                                </div>
                            </div>
                            <?php $n++;}?>
                        </div>
                    </div>
                </div>
            </div><!-- col-xs-8  -->
            <div class="col-xs-4 ">
                <div class="right-bg-box" style="padding-bottom: 20px;">
                    <div class="lm-title margin_bottom15">
                        <h3 class="lm-title-left">浏览排行 </h3>
                    </div>
                    <div class="list-ol-box-2">
                        <ol class="rectangle-list-2">
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'rank')) {
	$rs = $content_template_parse->rank(array('order'=>'monthviews DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'15','page'=>'0',));
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
</div>

</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>

<!-- start  滚动定位 -->
<script   src="<?php echo R;?>t3/js/portamento.js"></script>
<script>
    $('#sidebar').portamento({
        gap: 0,
        disableWorkaround: true
    });
</script>
