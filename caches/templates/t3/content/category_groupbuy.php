<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<?php $filterurl_config = get_config('filterurl_config','tuan');?>
<!-- -------------------------------- -->
<!--wuzhi-shaixuan-->
<!-- -------------------------------- -->
<?php //print_r($sub_categorys);?>
<div class="wuzhi-shaixuan">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <dl>
                    <dt>类别</dt>
                    <dd>
                        <a class="<?php if($variables['space']==0) { ?>active<?php } ?>" href="<?php echo filterurl('tuan','cid',$cid);?>">全部</a>
                        <?php $n=1; if(is_array($sub_categorys)) foreach($sub_categorys AS $_k => $_v) { ?>
                        <a class="<?php if($variables['cid']==$_k) { ?>active<?php } ?>" href="<?php echo filterurl('tuan','cid',$_k);?>"><?php echo $_v['name'];?></a>
                        <?php $n++;}?>
                    </dd>
                </dl>
                <dl>
                    <dt>价位</dt>
                    <dd>
                        <a class="<?php if($variables['price']==0) { ?>active<?php } ?>" href="<?php echo filterurl('tuan','price',0);?>">全部</a>
                        <?php $n=1; if(is_array($filterurl_config['price'])) foreach($filterurl_config['price'] AS $_k => $_v) { ?>
                        <a class="<?php if($variables['price']==$_k) { ?>active<?php } ?>" href="<?php echo filterurl('tuan','price',$_k);?>"><?php echo $_v['name'];?></a>
                        <?php $n++;}?>
                    </dd>
                </dl>
                <dl>
                    <dt>排序</dt>
                    <dd>
                        <a class="<?php if($variables['order']==0) { ?>active<?php } ?>" href="<?php echo filterurl('tuan','order',0);?>">全部</a>
                        <?php $n=1; if(is_array($filterurl_config['order'])) foreach($filterurl_config['order'] AS $_k => $_v) { ?>
                        <a class="<?php if($variables['order']==$_k) { ?>active<?php } ?>" href="<?php echo filterurl('tuan','order',$_k);?>"><?php echo $_v['name'];?></a>
                        <?php $n++;}?>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>


<div class="tuangou-one-screen">
    <div class="container">
        <div class="lm-title margin_bottom15">
            <h3 class="lm-title-left">特惠推荐 <span class="fubiaoti color_777 font_size12 margin_left10">低价优惠 该出手了 </span></h3>
        </div>
        <div class="row">
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'block')) {
	$rs = $content_template_parse->block(array('type'=>'1','blockid'=>'26','start'=>'0','pagesize'=>'10','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <div class="col-xs-3">
                <div class="thumbnail">
                    <?php $attach=unserialize($r['attach'])?>
                    <div class="pic_Control_g">
                        <a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt="..."></a>
                        <span   class="shoucang_ico">
                            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            <?php if(($attach['endtime'] < SYS_TIME)) { ?> 结束 <?php } else { ?>
                            <span id="t<?php echo $r['id'];?>_d">0</span>天
                            <span id="t<?php echo $r['id'];?>_h">0</span>时
                            <span id="t<?php echo $r['id'];?>_m">0</span>分
                            <span id="t<?php echo $r['id'];?>_s">0</span>秒
                            <?php } ?>
                        </span>
                    </div>
                    <div class="caption">

                        <h4 class="manhangyichu"><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></h4>
                        <p class="color_777"><?php echo $attach['subtitle'];?></p>
                        <div class="price-and-pingjia">

                            <div class="p-a-p-price">￥<?php echo intval($attach['iprice']);?> <del class="color_999  font_size14">￥<?php echo intval($attach['price']);?></del></div>
                            <div class="p-a-p-pingjia" style="padding-top: 12px">
                                <div class="rate-score"> <span class="score-value-no" ><em style="width: 80%"></em></span></div>
                                <small class="color_999">123</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $n++;}?>
            <script>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <?php $attach=unserialize($r['attach'])?>
                window.setInterval(function(){GetRTime('<?php echo date('Y-m-d H:i:s',$attach['endtime']);?>','t<?php echo $r['id'];?>_');}, 0);
                <?php $n++;}?>
            </script>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </div>
                                
    </div>
</div>
<?php $n=1; if(is_array($sub_categorys)) foreach($sub_categorys AS $_k => $_v) { ?>
<div class="tuangou-<?php if(($i%2)) { ?>one<?php } else { ?>second<?php } ?>-screen">
    <div class="container">

        <div class="lm-title margin_bottom15">
            <h3 class="lm-title-left"><?php echo $_v['name'];?> <span class="fubiaoti margin_left10" style="color: #777777">精选品牌  优质多多</span></h3>
            <a href="<?php echo $_v['url'];?>" class="lm-title-right">查看更多 <span class="glyphicon glyphicon-circle-arrow-right"
                                                         aria-hidden="true" style="font-size: smaller"></span></a>
        </div>
        <div class="row">
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('cid'=>$_k,'where'=>$where,'order'=>$orderby,'urlrule'=>$_POST['page_urlrule'],'variables'=>$variables,'modelid'=>$modelid,'start'=>'0','pagesize'=>'8','page'=>$page,));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <div class="col-xs-3">
                <div class="thumbnail">
                    <div class="pic_Control_g">
                        <a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt="..."></a>
                    </div>
                    <div class="caption">
                        <h4 class="manhangyichu"><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></h4>
                        <div class="price-and-pingjia">
                            <div class="p-a-p-price">￥<?php echo intval($r['iprice']);?> </div>
                            <div class="p-a-p-pingjia" style="padding-top: 12px">
                                <del class="color_999  font_size14">￥<?php echo intval($r['price']);?></del>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $n++;}?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </div>
    </div>
</div>
<?php $i++; ?>
<?php $n++;}?>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>
