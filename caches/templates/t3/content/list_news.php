<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<!--路径导航-->
<div style="background: #f3f3f3">
    <div class="container">
        <ol class="breadcrumb" style="margin-bottom: 0px">
            您现在的位置：
            <li><a href="<?php echo WEBURL;?>">首页</a><span> &gt;</span></li>
            <?php echo catpos($cid);?>
        </ol>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="ad-box" style="height: 120px; width: 100%; background: #dddddd"><script  src="<?php echo WEBURL;?>promote/7.js"></script></div>
        </div>
    </div>
</div>

<div class="news-second-screen">
    <div class="container">
        <div class="row">
            <div class="col-xs-8">
                <div class="headline-news-list">
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'10','page'=>$page,));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                    <div class="media">
                        <?php if($r['thumb']) { ?>
                        <div class="media-left ">
                            <a href="<?php echo $r['url'];?>">
                                <img class="media-object" src=" <?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>" width="165px" height="110px">
                            </a>
                        </div>
                        <?php } ?>
                        <div class="media-body">
                            <h4 class="media-heading manhangyichu"><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></h4>
                            <div class="media-content" ><?php echo strcut($r['remark'],200,'...');?></div>
                            <div  class="media-time"><span class="left">发布时间：<?php echo date('Y-m-d H:i:s',$r['addtime']);?></span><span class="right">浏览(<samp  id="view_<?php echo $cid;?>_<?php echo $r['id'];?>">0</samp>) </span></div>
                        </div>
                    </div>
                    <?php $n++;}?>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                </div>

                <!-- start-五指分页-->
                <div style="text-align:center;">
                    <?php if($this->db->number>10) { ?>
                    <nav style="text-align: center;">
                        <ul class="pagination">
                            <?php echo $pages;?>
                        </ul>
                    </nav>
                    <?php } ?>
                </div>
                <script>
                var views_keyid = new Array();
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                views_keyid.push('<?php echo $cid;?>_<?php echo $r['id'];?>');
                <?php $n++;}?>
                $.getJSON("index.php", {f: "stats", keyid: views_keyid },
                function(data){
                    $.each(data, function( index, value ) {
                        console.log(value);
                        $("#view_"+value.cid+'_'+value.id).html(value.views);
                    });
                });
                </script>


            </div><!-- col-xs-8  -->

            <div class="col-xs-4 ">
                <div class="right-bg-box" style="padding-top: 20px; padding-bottom: 20px;">
                    <div class="ad-box-first" style="height: 300px; width: 100%; background: #dddddd"><script  src="<?php echo WEBURL;?>promote/8.js"></script></div>
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
</div>

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>