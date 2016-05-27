<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<!--路径导航-->
<div style="background: #f3f3f3">
    <div class="container">
        <ol class="breadcrumb" style="margin-bottom: 0px">
            您现在的位置：
            <li><a href="/">首页</a><span> &gt;</span></li>
            <?php echo catpos($cid);?>
        </ol>
    </div>
</div>



<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="ad-box" style="height: 120px; width: 100%; background: #dddddd"><script  src="<?php echo WEBURL;?>promote/21.js"></script></div>
        </div>
    </div>
</div>






<div class="down-one-screen">
    <div class="container">
        <div class="row">
            <div class="col-xs-8">

                <div class="row">
                    <div class="col-xs-6 ">
                        <div class="list-group">
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'41','start'=>'0','pagesize'=>'6','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                            <?php $active_num=1?>
                                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                                    <a href="<?php echo $r['url'];?>" class="list-group-item manhangyichu <?php if($active_num==1) { ?>active<?php } ?>"><?php echo $r['title'];?></a>
                                    <?php $active_num++; ?>
                                <?php $n++;}?>
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                        </div>
                    </div>

                    <div class="col-xs-6 ">
                        <div class="list-group">
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'42','start'=>'0','pagesize'=>'6','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                            <?php $active_num1=1?>
                            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                            <a href="<?php echo $r['url'];?>" class="list-group-item manhangyichu <?php if($active_num1==1) { ?>active<?php } ?>"><?php echo $r['title'];?></a>
                            <?php $active_num1++; ?>
                            <?php $n++;}?>
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                        </div>
                    </div>
                </div>
                <div class="ad-box" style="height: 120px; width: 100%; background: #dddddd"><script  src="<?php echo WEBURL;?>promote/22.js"></script></div>


                <!--news-tabs-box-->
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
                        <div class="media-left">
                            <?php if($r['thumb']) { ?>
                            <a href="<?php echo $r[url];?>"><img src="<?php echo $r[thumb];?>" width="165px" height="110px"></a>
                            <?php } ?>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading manhangyichu"><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></h4>
                            <div class="media-content" ><?php echo strcut($r['remark'],200,'...');?></div>
                            <div  class="media-time"><span class="left font_size12">发布时间：<?php echo date('Y-m-d',$r['updatetime']);?></span><span class="right font_size12"><span class="glyphicon glyphicon-fire font_size12 color_ccc" aria-hidden="true"></span> <samp  id="view_<?php echo $cid;?>_<?php echo $r['id'];?>">0</samp> <small class="color_999" style="padding-left: 5px; padding-right: 5px;">|</small><a href="<?php echo $r['url'];?>"> <span class="glyphicon glyphicon-arrow-down font_size12 color_ccc" ></span> 下载</a></span></div>
                        </div>
                    </div>
                    <?php $n++;}?>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
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
                    <!--end  五指分页 -->
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
                </div>
            </div><!-- col-xs-8  -->

            <div class="col-xs-4 ">
                <div class="right-bg-box xielinebg" style="  padding-bottom: 20px;">
                    <div class="lm-title margin_bottom15">
                        <h3 class="lm-title-left">下载分类</h3>
                    </div>
                    <div class="down-class">
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'category')) {
	$rs = $content_template_parse->category(array('cid'=>$elasticid,'order'=>'sort ASC','start'=>'0','pagesize'=>'100','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <?php if($r['ismenu']) { ?><a href="<?php echo $r['url'];?>"><?php echo $r['name'];?></a><?php } ?>
                        <?php $n++;}?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

                    </div>

                    <div class="ad-box" style="height: 300px; width: 100%; background: #dddddd"><script  src="<?php echo WEBURL;?>promote/23.js"></script></div>

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