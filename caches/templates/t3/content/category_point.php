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

<div class="jifenmall-one-screen">
    <div class="container">
        <div class="lm-title margin_bottom15">
            <h3 class="lm-title-left">精品推荐 <span class="fubiaoti" style="color: #777777">&nbsp;&nbsp; 积分多多 优惠多多 </span></h3>
        </div>
        <div class="row">
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'4','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <div class="col-xs-3">
                <div class="thumbnail">
                    <div class="pic_Control_g max-height-hide262" >
                        <a href="<?php echo $r['url'];?>"><img src="<?php echo imagecut($r['thumb'],271,181,4);?>" alt="..."></a>
                    </div>
                    <div class="caption">
                        <p class="titles manhangyichu"><a href="<?php echo $r['url'];?>"><strong>兑换礼品：<?php echo $r['title'];?></strong></a><br>
                            <span class="titles-sm"><strong class="color_success"><?php echo $r['point'];?></strong> 积分  &nbsp; <?php if($r['price']!='0.00') { ?><?php if($r['point_money']!=0) { ?><strong class="color_success"><?php echo $r['point_money'];?></strong> 积分+<?php } ?><strong class="color_qiyecheng"><?php echo $r['price'];?></strong>元<?php } ?></span>
                        </p>
                    </div>
                </div>
            </div>
            <?php $n++;}?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </div>
    </div>
</div>

<?php $n=1; if(is_array($sub_categorys)) foreach($sub_categorys AS $photocid => $cats) { ?>
<div class=" jifenmall-one-screen">
    <div class="container">
        <div class="lm-title margin_bottom15">
            <h3 class="lm-title-left"><a href="<?php echo $cats['url'];?>" ><?php echo $cats['name'];?></a><span class="fubiaoti" style="color: #777777">&nbsp;&nbsp; 积分多多 优惠多多 </span></h3>
        </div>
        <div class="row" id="cat_<?php echo $photocid;?>">
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$photocid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'8','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <div class="col-xs-3">
                <div class="thumbnail">
                    <div class="pic_Control_g max-height-hide262" >
                        <a href="<?php echo $r['url'];?>"><img src="<?php echo imagecut($r['thumb'],271,181,4);?>" alt="..."></a>
                    </div>
                    <div class="caption">
                        <div  class="titles manhangyichu"><strong><?php echo $r['title'];?></strong><br>
                            <span class="titles-sm"><strong class="color_success"><?php echo $r['point'];?></strong> 积分   &nbsp; <?php if($r['price']!='0.00') { ?><?php if($r['point_money']!=0) { ?><strong class="color_success"><?php echo $r['point_money'];?></strong> 积分 + <?php } ?>  <strong class="color_qiyecheng"><?php echo $r['price'];?></strong>元<?php } ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php $n++;}?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </div>
    </div>
</div>
<?php $n++;}?>
<!--
<div class="jifenmall-one-screen">
    <div class="container">
        <div class="lm-title margin_bottom15">
            <h3 class="lm-title-left">生活汇 <span class="fubiaoti" style="color: #777777">&nbsp;&nbsp; 积分多多 优惠多多 </span></h3>
            <a href="" class="lm-title-right">更多 <span class="glyphicon glyphicon-circle-arrow-right"
                                                       aria-hidden="true" style="font-size: smaller"></span></a>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <div class="thumbnail">
                    <div class="pic_Control_g max-height-hide262">
                        <a href="jifenmal-content.html"><img src="<?php echo R;?>t3/image/temp/temp1.jpg" alt="..."></a>
                    </div>
                    <div class="caption">
                        <div  class="titles manhangyichu"><strong>Ctrip 特制方巾礼盒特制方巾礼盒特制方巾礼盒特制方巾礼盒特制方巾礼盒特制方巾礼盒</strong><br>
                            <span class="titles-sm"><strong class="color_success">11500</strong> 积分   &nbsp;&nbsp; <strong class="color_success">9500</strong> 积分 + <strong class="color_qiyecheng">20</strong>元</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="thumbnail">
                    <div class="pic_Control_g max-height-hide262">
                        <a href=""><img src="<?php echo R;?>t3/image/temp/temp2.jpg" alt="..."></a>
                    </div>
                    <div class="caption">
                        <div  class="titles manhangyichu"><strong>Ctrip 特制方巾礼盒特制方巾礼盒特制方巾礼盒特制方巾礼盒特制方巾礼盒特制方巾礼盒</strong><br>
                            <span class="titles-sm"><strong class="color_success">11500</strong> 积分   &nbsp;&nbsp; <strong class="color_success">9500</strong> 积分 + <strong class="color_qiyecheng">20</strong>元</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="thumbnail">
                    <div class="pic_Control_g max-height-hide262">
                        <a href=""><img src="<?php echo R;?>t3/image/temp/temp1.jpg" alt="..."></a>
                    </div>
                    <div class="caption">
                        <div  class="titles manhangyichu"><strong>Ctrip 特制方巾礼盒特制方巾礼盒特制方巾礼盒特制方巾礼盒特制方巾礼盒特制方巾礼盒</strong><br>
                            <span class="titles-sm"><strong class="color_success">11500</strong> 积分   &nbsp;&nbsp; <strong class="color_success">9500</strong> 积分 + <strong class="color_qiyecheng">20</strong>元</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="thumbnail">
                    <div class="pic_Control_g max-height-hide262">
                        <a href=""><img src="<?php echo R;?>t3/image/temp/temp1.jpg" alt="..."></a>
                    </div>
                    <div class="caption">
                        <div  class="titles manhangyichu"><strong>Ctrip 特制方巾礼盒特制方巾礼盒特制方巾礼盒特制方巾礼盒特制方巾礼盒特制方巾礼盒</strong><br>
                            <span class="titles-sm"><strong class="color_success">11500</strong> 积分   &nbsp;&nbsp; <strong class="color_success">9500</strong> 积分 + <strong class="color_qiyecheng">20</strong>元</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
-->

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>