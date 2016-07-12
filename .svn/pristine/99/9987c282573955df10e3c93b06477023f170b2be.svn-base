<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<div class="container Site_map"> 当前位置：<a href="<?php echo WEBURL;?>">首页</a><span> &gt; <?php echo catpos($cid);?></span></div>

<div class="bankuai_1 pd30">
    <div class="container">
        <div class="row">
            <div class="col-xs-8" style="border-right:1px solid #eee">
                <div class="content_title"><?php echo $title;?></div>
                <div class="bignewsbox">
                    <div class="Nfoot">
                        <div class="lwd">时间：<?php echo date('Y-m-d H:i',$addtime);?>&nbsp;&nbsp; 来源：<?php echo $copyfrom;?></div>
                    </div>
                </div>
                <div class="content_p">
                    <?php echo $content;?>
                </div>
                <?php if($content_pages) { ?>
                <div class="page-ination">
                    <div class="page-in">
                        <ul class="clearfix">
                            <?php echo $content_pages;?>
                        </ul>
                    </div>
                </div><?php } ?>
                <?php if($keywords) $keyword = implode(',',$keywords);?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'relation')) {
	$rs = $content_template_parse->relation(array('cid'=>$cid,'id'=>$id,'keywords'=>$keyword,'order'=>'id ASC','start'=>'0','pagesize'=>'5','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                <?php if(!empty($rs)) { ?>相关内容：<br>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a> <?php echo time_format($r['addtime']);?>
                <?php $n++;}?>
                <hr>
                <?php } ?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

            </div>
            <div class="col-xs-4">
                <div class="rightad_boxg"><img src="http://placehold.it/300x233" width="300" height="233"></div>
                <div class="right_hot" id="righthot">
                    <h4>浏览排行</h4>
                    <div class="list-group">
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'rank')) {
	$rs = $content_template_parse->rank(array('order'=>'monthviews DESC','cid'=>$cid,'start'=>'0','pagesize'=>'10','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <a href="<?php echo $r['url'];?>" class="list-group-item_gr active"><span class="badge_top"><?php echo str_pad($n, 2, "0", STR_PAD_LEFT);?> </span>&nbsp;<?php echo strcut($r['title'],36);?></a>
                        <?php $n++;}?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo WEBURL;?>index.php?f=stat&id=<?php echo $id;?>&cid=<?php echo $cid;?>"></script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>