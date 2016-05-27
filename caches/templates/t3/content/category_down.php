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

<div class="down-one-screen">
    <div class="container">
        <div class="row">

            <div class="col-xs-8">
                <div class="row">
                    <div class="col-xs-6">
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
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'35','start'=>'0','pagesize'=>'3','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <div class="item <?php if($n==1) { ?>active<?php } ?>">
<a href=" <?php echo $r['url'];?>">
                            <img src=" <?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>" style="height: 260px">
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

                    <div class="col-xs-6 " style="padding-left: 16px;">
                        <div class="list-group">
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'36','start'=>'0','pagesize'=>'6','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                    <?php if($n==1) { ?>
                    <a href="<?php echo $r['url'];?>" class="list-group-item manhangyichu active">
                        <?php echo $r['title'];?>
                    </a>
                    <?php } else { ?>
                    <a href="<?php echo $r['url'];?>" class="list-group-item manhangyichu"><?php echo $r['title'];?></a>
                    <?php } ?>
                    <?php $n++;}?>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                </div>
                    </div>
                </div>
                <div class="news-tabs-box" style="padding-top: 25px;">
                    <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
                        <ul id="myTabs" class="nav nav nav-tabs" role="tablist"><!--<ul id="myTabs" class="nav nav-pills nav-stacked" role="tablist">-->  <!--胶囊标签  /  竖向标签 -->
                            <li role="presentation" class="active"><a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">最新更新</a></li>

                            <?php $n=1; if(is_array($sub_categorys)) foreach($sub_categorys AS $downcid => $cats) { ?>
                            <li role="presentation" class=""><a href="#cat_<?php echo $downcid;?>" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false"><?php echo $cats['name'];?></a></li>
                            <?php $n++;}?>
                        </ul>

                        <div id="myTabContent" class="tab-content ">
                            <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">
                                <div class="headline-news-list">
                                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,updatetime DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'20','page'=>$page,));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="<?php echo $r[url];?>"><img src="<?php echo $r[thumb];?>" width="120px;"></a>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading manhangyichu" style="max-width:480px;"><strong><a href="<?php echo $r[url];?>" target="_blank"><?php echo $r['title'];?></a></strong></h4>
                                            <p style="width:599px;"><span class="down_wds"><a href="<?php echo $categorys[$r['cid']]['url'];?>"><?php echo $categorys[$r['cid']]['name'];?></a> | <?php echo $r['soft_license'];?> | 大小:<?php echo $r['soft_size'];?> | 环境:<?php echo $r['soft_env'];?> | 人气:<?php echo $r['down_numbers'];?></span><br>
                                                <?php echo strcut($r['remark'],180,'...');?><br>
                                                <small style="float:right"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> 更新日期：<?php echo date('Y.m.d',$r['updatetime']);?></small></p>

                                        </div>
                                    </div>
                                    <?php $n++;}?>
                                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                                    <?php if($this->db->number>5) { ?>
                                    <nav style="text-align: center;">
                                        <ul class="pagination">
                                            <?php echo $pages;?>
                                        </ul>
                                    </nav>
                                    <?php } ?>
                                </div>
                            </div>

                            <!------------------------------------------->
                            <?php $n=1; if(is_array($sub_categorys)) foreach($sub_categorys AS $downcid => $cats) { ?>
                            <div role="tabpanel" class="tab-pane fade" id="cat_<?php echo $downcid;?>" aria-labelledby="profile-tab">
                                <div class="headline-news-list">
                                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,updatetime DESC','cid'=>$downcid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'6','page'=>$page,));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="<?php echo $r[url];?>"><img src="<?php echo $r[thumb];?>" width="120px;"></a>
                                        </div>
                                        <div class="media-body">
                                            <h4 class="media-heading manhangyichu" style="max-width:480px;"><strong><a href="<?php echo $r[url];?>" target="_blank"><?php echo $r['title'];?></a></strong></h4>
                                            <p style="width:599px;"><span class="down_wds"><a href="<?php echo $categorys[$r['cid']]['url'];?>"><?php echo $categorys[$r['cid']]['name'];?></a> | <?php echo $r['soft_license'];?> | 大小:<?php echo $r['soft_size'];?> | 环境:<?php echo $r['soft_env'];?> | 人气:<?php echo $r['down_numbers'];?></span><br>
                                                <?php echo strcut($r['remark'],180,'...');?><br>
                                                <small style="float:right"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> 更新日期：<?php echo date('Y.m.d',$r['updatetime']);?></small></p>

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
            </div>
            <div class="col-xs-4 ">
                <div class="right-bg-box xielinebg">
                    <div class="lm-title margin_bottom15">
                        <h3 class="lm-title-left">推荐</h3>
                    </div>
                    <div class="headline-news-list right-bg-media">
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'37','start'=>'0','pagesize'=>'5','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <div class="media">
                            <div class="media-left ">
                                <a href="<?php echo $r['url'];?>">
                                    <img class="media-object" src="<?php echo $r['thumb'];?>"  width="105px" >
                                </a>
                            </div>
                            <div class="media-body" style="max-width: 205px">
                                <h5 class="media-heading manhangyichu"><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></h5>
                                <div class="media-content" ><?php echo $r['remark'];?></div>
                            </div>
                        </div>
                        <?php $n++;}?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                                
                    </div>

                </div>
                <div>&nbsp;</div>
                <div class="right-bg-box" style="padding-top: 20px; padding-bottom: 20px;">
                    <div class="ad-box-first" style="height: 300px; width: 100%; background: #dddddd"><script  src="<?php echo WEBURL;?>promote/20.js"></script></div>
                    <div class="lm-title margin_bottom15">
                        <h3 class="lm-title-left">下载排行 </h3>
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
	$rs = $content_template_parse->rank(array('order'=>'monthviews DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'10','page'=>'0',));
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

<!------------------------------------------------------------------------------------------------------>
<div class="news-second-screen" style="margin-top: 32px">
    <div class="container">
        <div class="row">
            <div class="col-xs-8">
                <!--news-tabs-box-->

            </div><!-- col-xs-8  -->
<!----------------------------------------------------------------------------------------------------------->
            <div class="col-xs-4 ">



            </div>
        </div>
    </div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>