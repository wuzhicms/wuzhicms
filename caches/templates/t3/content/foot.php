<!DOCTYPE html><div class="remove_debug" style="position: relative;z-index: 99999;background-color: rgba(171, 166, 159, 0.66);color: #FFFDFD;">开始：<?php echo substr(str_replace(CACHE_ROOT,COREFRAME_ROOT,__FILE__),0,-4).".html";?><span style="float: right;padding: 0px 10px;cursor: pointer;" onclick="remove_debug_div()">关闭</span></div><?php defined('IN_WZ') or exit('No direct script access allowed'); ?>
<!--ad-->
<div class="container">
    <div class="row margin_top20">
        <div class="col-xs-3"><script  src="<?php echo WEBURL;?>promote/27.js"></script> </div>
        <div class="col-xs-3"><script  src="<?php echo WEBURL;?>promote/28.js"></script> </div>
        <div class="col-xs-3"><script  src="<?php echo WEBURL;?>promote/29.js"></script> </div>
        <div class="col-xs-3"><script  src="<?php echo WEBURL;?>promote/30.js"></script> </div>
    </div>
</div>

<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-center  line_height2d0">
                <p>联系电话：010-82463345 &nbsp; &nbsp;QQ:282198327 &nbsp;Email:zhw@wuzhicms.com</p> <br>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'category')) {
	$rs = $content_template_parse->category(array('cid'=>'51','order'=>'sort ASC','start'=>'0','pagesize'=>'10','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <a href="<?php echo $r[url];?>"><?php echo $r['name'];?></a>  <small class="color_999" style="padding-left: 5px; padding-right: 5px;">|</small>
                <?php $n++;}?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                <a href="<?php echo WEBURL;?>index.php?m=link">友情链接</a> <br>
                <?php echo $siteconfigs['copyright'];?><?php echo $siteconfigs['statcode'];?> <a href="http://www.wuzhicms.com" target="_blank">五指CMS提供技术支持</a> </div>
        </div>
    </div>

</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo R;?>t3/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?php echo R;?>t3/js/ie10-viewport-bug-workaround.js"></script>
<script src="<?php echo R;?>t3/js/my.js"></script>
<script src="<?php echo R;?>t3/js/bootstrap-hover-dropdown.min.js"></script>
<script type="text/javascript">
    var _uid=getcookie('_uid');
    if(_uid!=null) {
        $("#mylogined").removeClass('hide');
        $("#mylogin").addClass('hide');
        var _username=decodeURI(getcookie('truename'));
        $("#myname").html(_username);
    }
</script>
</body>
</html><div class="remove_debug" style="position: relative;z-index: 99999;background-color: rgba(171, 166, 159, 0.66);color: #FFFDFD;">结束：<?php echo substr(str_replace(CACHE_ROOT,COREFRAME_ROOT,__FILE__),0,-4).".html";?><span style="float: right;padding: 0px 10px;cursor: pointer;" onclick="remove_debug_div()">关闭</span></div><script>setTimeout(function(){$(".remove_debug").remove();},20000);</script>