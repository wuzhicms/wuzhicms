<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<script src="<?php echo R;?>/js/masonry.min.js"></script>
<div class="container Site_map"> 当前位置：<a href="<?php echo WEBURL;?>">首页</a><span> &gt; <?php echo catpos($cid);?></span></div>
<div class="bankuai_1">

    <div class="container">
        <!--瀑布流-->

        <div id="masonry" class="pbl_box">
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'20','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <div class="box">
                <a class="abs" target="_blank" href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>"></a>
                <div class="ext-info">
                    <a class="abs" target="_blank" href="#"><?php echo $r['title'];?></a>
                    <?php if($r['keywords']) { ?><div class="tags "><label>标签:</label>
                    <?php $keywords = explode(',',$r['keywords']);?>
                    <?php $n=1;if(is_array($keywords)) foreach($keywords AS $keyword) { ?>
                    <a class="tag" href="/index.php?m=tags&v=show&tid=<?php echo urlencode($keyword);?>" target="_blank"><?php echo $keyword;?></a>
                    <?php $n++;}?>
                </div><?php } ?>
                </div>
            </div>
            <?php $n++;}?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

        </div>
    </div>
</div>
<div class="container"><div id="page_tag_load" style="display:none;color: #7E7373;font-size: 14px;width: 100%;bottom: 0px;background-color: #F7F7F7;text-align: center;height: 30px;padding: 5px;">加载中...</div></div>
<script type="text/javascript">

    function getItemElement(value) {
        var elem = document.createElement('div');
        //console.log(elem);
        if(value.keywords=='') {
            var tags = '';
        } else {
            var tag = value.keywords;
            tag = tag.split(',');
            var tags = '<div class="tags "><label>标签:</label> ';
            $.each(tag, function(index,tag) {
                tags+='<a class="tag" href="/index.php?m=tags&v=show&tid='+tag+'" target="_blank">'+tag+'</a>';
            });
            tags+='</div>';
        }

        elem.innerHTML = '<a class="abs" target="_blank" href="'+value.url+'"><img src="'+value.thumb+'"></a><div class="ext-info"><a class="abs" target="_blank" href="'+value.url+'">'+value.title+'</a>'+tags+' </div>'
        elem.className = 'box';
        return elem;
    }

    $( function() {

        var $container = $('#masonry').masonry({
            columnWidth: 60
        });
        /**
         $('#append-button').on( 'click', function() {
        var elems = [getItemElement()];
        $container.append( elems ).masonry( 'appended', elems );
    });
         **/
    });
    var page = 1;
    function insertcode() {
        page++;
        var $container = $('#masonry').masonry({
            columnWidth: 60
        });
        $.getJSON("/index.php?f=json&v=listing&cid=<?php echo $cid;?>", { page: page, pagesize:20,time: Math.random() }, function(json){
            if(json=='finish') {
                $("#page_tag_load").html('已到达最后一页');
                $("#page_tag_load").show();
            } else {
                var elems = new Array();
                $.each(json, function( index, value ) {
                    elems.push(getItemElement(value));

                });
                $container.append( elems ).masonry( 'appended', elems );

            }
        });
    }
    $(document).ready(function () {

        $(window).scroll(function () {
            var $body = $("body");
            /*判断窗体高度与竖向滚动位移大小相加 是否 超过内容页高度*/
            if (($(window).height() + $(window).scrollTop()) >= $body.height()-160) {
                $("#page_tag_load").show();
                insertcode();
            }
        });
    });
</script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>