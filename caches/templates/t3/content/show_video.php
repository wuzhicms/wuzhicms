<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<!--路径导航-->
<div style="background: #f3f3f3">
    <div class="container">
        <ol class="breadcrumb" style="margin-bottom: 0px">
            您现在的位置：
            <li><a href="<?php echo WEBURL;?>">首页</a><span> &gt;</span> </li>
            <?php echo catpos($cid);?>
            <li class="active">正文</li>
        </ol>
    </div>
</div>

<div class="video-content-top">
    <div class="container">
        <div class="row">

            <div class="col-xs-9">
                <h3 class="margin_bottom6  margin_top10"><?php echo $title;?></h3>
                <p class="color_999">发布：<?php echo $addtime;?> &nbsp;&nbsp;&nbsp;&nbsp; 播放：<span id="hits">0</span>&nbsp;&nbsp;&nbsp;&nbsp; 时长：03:24</p>
                <!--优酷播放器-->
                <?php if($youku) { ?>
                <div class="vido-windows">
                    <iframe height=580 width=100% src="<?php echo $youku['url'];?>" frameborder="0" allowtransparency="true" allowfullscreen="true" allowfullscreenInteractive="true"></iframe>
                    <a  class="new-open"  href="<?php echo WEBURL;?>index.php?f=player&v=youku&code=<?php echo $youku['code'];?>&cid=<?php echo $cid;?>&id=<?php echo $id;?>&token=<?php echo md5($youku['code'].$cid.$id._KEY);?>&title=<?php echo urlencode($title);?>" target="_blank">新窗口播放</a>
                </div>
                <?php } ?>
                <!--土豆播放器-->
                <?php if($tudou) { ?>
                <div>
                    <a href="<?php echo WEBURL;?>index.php?f=player&v=tudou&code=<?php echo $tudou['code'];?>&type=<?php echo $tudou['type'];?>&lcode=<?php echo $tudou['lcode'];?>&cid=<?php echo $cid;?>&id=<?php echo $id;?>&token=<?php echo md5($tudou['code'].$cid.$id._KEY);?>&title=<?php echo urlencode($title);?>" target="_blank">新窗口播放</a>
                    <iframe height=580 width=100% src="<?php echo $tudou['url'];?>" frameborder="0" allowtransparency="true" allowfullscreen="true" allowfullscreenInteractive="true"></iframe>
                </div>
                <?php } ?>
            </div>

            <div class="col-xs-3">
                <div class="ad-box" style="height: 84px; background: #ddd; margin-top: 0px"><script  src="<?php echo WEBURL;?>promote/15.js"></script></div>
                <div class="headline-news-list  video-right-list">
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'6','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                    <div class="media">
                        <div class="media-left ">
                            <a href="<?php echo $r['url'];?>">
                                <img class="media-object" src="<?php echo $r['thumb'];?>" alt="..." width="72px" >
                            </a>
                        </div>
                        <div class="media-body" style="max-width: 205px">
                            <h5 class="media-heading"><a href="<?php echo $r['url'];?>"  <?php if($r['id']==$id) { ?>class="active" <?php } ?>><?php echo $r['title'];?></a></h5>
                        </div>
                    </div>
                    <?php $n++;}?>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="ad-box">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div style="height: 120px; background: #ddd"><script  src="<?php echo WEBURL;?>promote/16.js"></script></div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="video-second-screen ">
        <div class="row">
            <div class="col-xs-9">
                <div class="lm-title margin_bottom15">
                    <h3 class="lm-title-left">热播推荐 </h3>
                </div>
                <div class="row">
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'6','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                    <div class="col-xs-4">
                        <div class="narrowArt">
                            <a href="<?php echo $r['url'];?>" title="<?php echo $r['title'];?>">
                                <img  src="<?php echo $r['thumb'];?>" alt="" width="273" height="182">
                                <h2><?php echo $r['title'];?></h2>
                            </a>
                        </div>
                    </div>
                    <?php $n++;}?>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                </div>
            </div>

            <div class="col-xs-3">
                <div class="lm-title margin_bottom15">
                    <h3 class="lm-title-left">浏览排行 </h3>
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
	$rs = $content_template_parse->rank(array('order'=>'weekviews DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'10','page'=>'0',));
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


<div class="container">
    <div class="video-second-screen margin_top20 ">
        <div class="row">
            <div class="col-xs-9">
                <!--高速版，加载速度快，使用前需测试页面的兼容性-->
                <div id="SOHUCS"></div>
                <script>
                    (function(){
                        var appid = "<?php echo $siteconfigs['cy_appid'];?>",
                                conf = "<?php echo $siteconfigs['cy_key'];?>";
                        var doc = document,
                                s = doc.createElement('script'),
                                h = doc.getElementsByTagName('head')[0] || doc.head || doc.documentElement;
                        s.type = 'text/javascript';
                        s.charset = 'utf-8';
                        s.src =  'http://assets.changyan.sohu.com/upload/changyan.js?conf='+ conf +'&appid=' + appid;
                        h.insertBefore(s,h.firstChild);
                        window.SCS_NO_IFRAME = true;
                    })()
                </script>
            </div>

            <div class="col-xs-3">
                <div class="ad-box" style="height: 300px; background: #f4f4f4"><script  src="<?php echo WEBURL;?>promote/25.js"></script></div>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo WEBURL;?>index.php?f=stat&id=<?php echo $id;?>&cid=<?php echo $cid;?>"></script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>
