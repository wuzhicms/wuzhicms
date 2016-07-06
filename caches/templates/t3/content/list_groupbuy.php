<!DOCTYPE html><div class="remove_debug" style="position: relative;z-index: 99999;background-color: rgba(171, 166, 159, 0.66);color: #FFFDFD;">开始：<?php echo substr(str_replace(CACHE_ROOT,COREFRAME_ROOT,__FILE__),0,-4).".html";?><span style="float: right;padding: 0px 10px;cursor: pointer;" onclick="remove_debug_div()">关闭</span></div><?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<?php $filterurl_config = get_config('filterurl_config','tuan');?>
<!-- -------------------------------- -->
<!--wuzhi-shaixuan-->
<!-- -------------------------------- -->

<div class="wuzhi-shaixuan">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <dl>
                    <dt>类别</dt>
                    <dd>
                        <a class="<?php if($variables['space']==$top_categoryid) { ?>active<?php } ?>" href="<?php echo filterurl('tuan','cid',$top_categoryid);?>">全部</a>
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
            <h3 class="lm-title-left"><?php echo $category['name'];?>列表 <span class="fubiaoti color_777 font_size12 margin_left10">低价优惠 该出手了 </span></h3>
        </div>
        <div class="row">
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('cid'=>$cid,'where'=>$where,'order'=>$orderby,'urlrule'=>$_POST['page_urlrule'],'variables'=>$variables,'modelid'=>$modelid,'start'=>'0','pagesize'=>'8','page'=>$page,));
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
    <!-- start-五指分页-->
    <div style="text-align:center;">
        <nav>
            <ul class="pagination">
                <?php echo $pages;?>
            </ul>
        </nav>
    </div>
    <!--end  五指分页 -->
</div>

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?><div class="remove_debug" style="position: relative;z-index: 99999;background-color: rgba(171, 166, 159, 0.66);color: #FFFDFD;">结束：<?php echo substr(str_replace(CACHE_ROOT,COREFRAME_ROOT,__FILE__),0,-4).".html";?><span style="float: right;padding: 0px 10px;cursor: pointer;" onclick="remove_debug_div()">关闭</span></div><script>setTimeout(function(){$(".remove_debug").remove();},20000);</script>