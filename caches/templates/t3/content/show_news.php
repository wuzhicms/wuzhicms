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

<div class="container">
    <div class="col-xs-8">
        <div class="news-content">
            <h2 class="text-center"><?php echo $title;?></h2>
            <div class="text-center color_999">时间：<?php echo $addtime;?> &nbsp;&nbsp;&nbsp;&nbsp;<?php if($copyfrom!=="") { ?>来源：<?php } ?><?php echo $copyfrom;?>&nbsp;&nbsp;&nbsp;&nbsp; 访问次数：<span id="hits">0</span></div>
            <hr>
            <div  class="content-p">
                <?php echo $content;?>
            </div>

            <hr>
            <div class="before-and-next">
                <div class="row">
                    <div><?php if($previous_page['url']) { ?><a href="<?php echo $previous_page['url'];?>">上一篇：<?php echo strcut($previous_page['title'],50);?></a><?php } ?></div>
                    <div><?php if($next_page['url']) { ?><a href="<?php echo $next_page['url'];?>">下一篇：<?php echo strcut($next_page['title'],50);?></a><?php } ?></div>
                </div>
            </div>
        </div>
        <div>
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
    </div>
    <div class="col-xs-4">
        <div class="ad-box">
            <div style="height: 320px; background: #ddd"><script  src="<?php echo WEBURL;?>promote/6.js"></script></div>
        </div>


        <div class="right-bg-box xielinebg  down-one-screen" >
            <div class="lm-title margin_bottom15">
                <h3 class="lm-title-left">频道推荐 </h3>
            </div>
            <div class="list-group ">
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'38','start'=>'0','pagesize'=>'6','page'=>'0',));
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

        <div class="right-bg-box xielinebg">
            <div class="lm-title margin_bottom15">
                <h3 class="lm-title-left">图片新闻 </h3>
            </div>
            <div class="headline-news-list right-bg-media">
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'39','start'=>'0','pagesize'=>'3','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <div class="media">
                    <div class="media-left ">
                        <a href="<?php echo $r['url'];?>">
                            <img class="media-object" src="<?php echo imagecut($r['thumb'],106,70,4);?>" alt="..." width="105px" >
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

        <div class="right-bg-box xielinebg">
            <div class="lm-title margin_bottom15">
                <h3 class="lm-title-left">视频新闻 </h3>
            </div>
            <div class="headline-news-list right-bg-media">
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'40','start'=>'0','pagesize'=>'3','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <div class="media">
                    <div class="media-left ">
                        <a href="<?php echo $r['url'];?>">
                            <img class="media-object" src="<?php echo imagecut($r['thumb'],106,70,4);?>" alt="..." width="105px" >
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
    </div>
</div>


<script type="text/javascript" src="<?php echo WEBURL;?>index.php?f=stat&id=<?php echo $id;?>&cid=<?php echo $cid;?>"></script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>