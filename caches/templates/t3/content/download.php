<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<!--路径导航-->
<div style="background: #f3f3f3">
    <div class="container">
        <ol class="breadcrumb" style="margin-bottom: 0px">
            您现在的位置：
            <li><a href="<?php echo WEBURL;?>">首页</a><span> &gt;</span> </li>
            <?php echo catpos($cid);?>
            <li class="active">正文</li>
        </ol>
    </div>
</div>





<div class="down-one-screen">
    <div class="container">
        <div class="row">
            <div class="col-xs-8">

                <div class="wzcms-tuangou-list " style="margin-bottom: 0px; margin-top: 0px; padding-top: 0px">
                    <div class="content_title"><h4><?php echo $title;?><span style="font-size:12px; float:right; padding-top:25px;">下载次数：<?php echo $down_numbers;?></span></h4></div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-5">
                            <a href="#" class="thumbnail ">
                                <img src="<?php echo $thumb;?>" alt="<?php echo $title;?>">
                            </a>
                        </div>
                        <div class="col-xs-7">
                            <p class="line_height1d8">
                                <strong>软件作者:</strong> <?php echo $soft_author;?> <br>
                                <strong>软件大小:</strong> <?php echo $soft_size;?><br>
                                <strong>软件类别:</strong> <?php echo $category['name'];?> <br>
                                <strong>软件语言:</strong> <?php echo $soft_language;?> <br>
                                <strong>运行环境:</strong> <?php echo $soft_env;?> <br>
                                <strong>软件授权:</strong> <?php echo $soft_license;?> <br>
                            </p>
                            <a href="<?php echo $downfile;?>"><button  type="button" class="btn btn-danger  font_size16 margin_top10"><strong> &nbsp;&nbsp;立即下载&nbsp;&nbsp; </strong></button></a>
                        </div>

                    </div>
                </div>


            </div><!-- col-xs-8  -->

            <div class="col-xs-4 ">
                <div class="right-bg-box xielinebg" style="  padding-bottom: 20px;">

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

<script type="text/javascript">
    function show_qrcode(id,str) {
        $("#"+id).attr('src',str);
        $("#"+id).css('display','');
    }
    function download_count(cid,id) {
        $.post("<?php echo WEBURL;?>index.php?f=download_stat", { cid: cid,id:id, time: Math.random()},
                function(data){
                });

    }
    function toDownload() {
        var download_pos = $("#download_address").offset().top;
        download_pos = download_pos-60;
        $("html,body").animate({scrollTop:download_pos},600);
    }
</script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>