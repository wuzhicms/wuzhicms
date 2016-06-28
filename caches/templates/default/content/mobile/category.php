<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<section class="pdbox">
    <div class="subnav">
        <div class="panel-body">
            <?php $n=1;if(is_array($sub_categorys)) foreach($sub_categorys AS $cats) { ?>
            <a href="<?php echo $cats['url'];?>"><?php echo $cats['name'];?></a>
            <?php $n++;}?>
        </div>
    </div>
    <article>
        <ul class="colst" id="wzlist">
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$cid,'start'=>'0','pagesize'=>'20','page'=>$page,));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <li>
                <div class="bl">
                    <div><a href="<?php echo $r['url'];?>"><?php echo safe_htm($r['title']);?></a></div>
                    <div><span class="nums"><?php echo $categorys[$r['cid']]['name'];?></span><span class="times"><?php echo date('Y-m-d',$r['updatetime']);?></span></div>
                </div>
                <?php if($r['thumb']) { ?><div class="mimg"><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" width="60" height="60"/></a></div><?php } ?>
            </li>
            <?php $n++;}?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
        </ul>
        <div class="loading-div" onclick="load_lists()"><span id="morebutton" class="button-bg morebutton">更多<?php echo $category['name'];?></span></div>
    </article>
</section>
<script type="text/javascript">
    var page = 2;
    function load_lists() {
        $("#morebutton").removeClass("button-bg");
        $("#morebutton").html("<img src='<?php echo R;?>images/loading.gif'>");
        $.getJSON("<?php echo WEBURL;?>index.php?m=content&f=json&v=listing&cid=<?php echo $cid;?>&pagesize=20&page="+page, function(data) {
            if(data=='finish') {
                $("#morebutton").html("已经是最后一页了");
            } else {
                $.each(data, function(i,item){
                    $("#wzlist").append('<li><div class="bl"><div><a href="'+item.url+'">'+item.title+'</a></div><div><span class="nums">'+item.catname+'</span><span class="times">'+item.updatetime+'</span></div></div></li>');

                });
                $("#morebutton").addClass("button-bg");
                $("#morebutton").html("更多<?php echo $category['name'];?>");
            }
        });

        page = page+1;
    }
</script>
<footer class="ft">
    Copyright 2005 - 2015 WuzhiCMS. All Rights Reserved
</footer>
</body>
</html>
