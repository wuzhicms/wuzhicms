<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<!--路径导航-->
<script src="<?php echo R;?>js/masonry.min.js"></script>
<div style="background: #f3f3f3">
    <div class="container">
        <ol class="breadcrumb" style="margin-bottom: 0px">
            您现在的位置：
            <li><a href="#">B首页</a><span> &gt;</span></li>
            <?php echo catpos($cid);?>
        </ol>
    </div>
</div>
<!--------------------------------------------------------------------------------------------->
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="ad-box" style="height: 120px; width: 100%; background: #dddddd"><script  src="<?php echo WEBURL;?>promote/19.js"></script></div>
        </div>
    </div>
</div>
<!----------------------------------------------------------------------------------------------->
<div class="photo-list-box">
    <div class="container">
        <div class="row">
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'20','page'=>$page,));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <div class="col-xs-3">
                <div class="thumbnail">
                    <div class="pic_Control_g" style="overflow: hidden;height: 181px;">
                        <a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt="..."  ></a>
                    </div>
                    <div class="caption">
                        <p  class="manhangyichu margin_bottom0"><a href=""><?php echo $r['title'];?></a></p>
                        <div class="caption-left-and-right">
                            <div class="caption-left color_999 font_size12"><?php echo date('Y-m-d H:i:s',$r['addtime']);?> </div>
                            <div class="caption-right color_999 font_size12"><a href=""><span class="glyphicon glyphicon-comment font_size12 color_ccc" aria-hidden="true"></span> 600</a></div>
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
        <div style="text-align:center;">
            <?php if($this->db->number>20) { ?>
            <nav style="text-align: center;">
                <ul class="pagination">
                    <?php echo $pages;?>
                </ul>
            </nav>
            <?php } ?>
        </div>
    </div>
    <!--end  五指分页 -->
</div>

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>