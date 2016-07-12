<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<div class="container Site_map"> 当前位置：<a href="<?php echo WEBURL;?>">首页</a><span> &gt; <?php echo catpos($cid);?></span></div>

<div class="bankuai_1 pd5">
    <div class="container"> 
        <div class="row">
            <div class="col-xs-8" style="border-right:1px solid #eee">
                <div class="content_title"><?php echo $title;?> <span style="font-size:12px; float:right; padding-top:15px;">下载次数：<?php echo $down_numbers;?></span></div>
                <div class="bignewsbox">
                    <div class="Nfoot">
                        <div class="lwd">时间：<?php echo $addtime;?>&nbsp;&nbsp; 来源：<?php echo $copyfrom;?>   <div class="btn-group" role="group" aria-label="...">

                            <div class="btn-group" role="group">
                                <button type="button" class=" dropdown-toggle" data-toggle="dropdown" aria-expanded="false" onmousemove="show_qrcode('img1','<?php echo qrcode($url);?>')" style="background:none; border:none;">
                                    <img src="<?php echo R;?>images/appicons/weixin.png" width="26" height="26">
                                </button>
                                <ul class="dropdown-menu" role="menu" style="min-width: 50px; padding:3px 3px;">
                                    <li><img id="img1" src="<?php echo R;?>images/onLoad.gif"> </li>
                                </ul>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
				
                <div class="row">
                	<div class="col-xs-5" class="thumbnail"><a href="javascript:void(0);" onclick="toDownload()" class="thumbnail" >
                      <img src="<?php echo $thumb;?>" alt="<?php echo $title;?>" style="max-height:180px; overflow:hidden;">
                    </a></div>
                    <div class="col-xs-7">
                <div class="content_p" style="font-size:13px;">
                <strong>软件作者:</strong> <?php echo $soft_author;?> <br>
<strong>软件大小:</strong> <?php echo $soft_size;?><br>
<strong>软件类别:</strong> <?php echo $category['name'];?> <br>
<strong>软件语言:</strong> <?php echo $soft_language;?> <br>
<strong>运行环境:</strong> <?php echo $soft_env;?> <br>
<strong>软件授权:</strong> <?php echo $soft_license;?> <br>
                </div>                     
                    </div>
                </div>

                <h4><a href="#">• 内容介绍</a></h4>
                <div class="content_p">
                    <?php echo $content;?>
                </div>   
                <hr>

                <div class="content_p" id="download_address">
                   下载地址：
                    <a href="<?php echo $downfile;?>&cid=<?php echo $cid;?>&id=<?php echo $id;?>" target="_blank" onclick="download_count(<?php echo $cid;?>,<?php echo $id;?>);"><button type="button" class="btn btn-danger">点击下载</button></a>
                </div>
                <hr>
                <div class="content_p" onmousemove="show_qrcode('img2','<?php echo qrcode($downfile);?>')">
                    手机扫描下载：<!--<img src="<?php echo R;?>images/icon/qr_code.png" >-->
                    <img id="img2" src="<?php echo R;?>images/icon/qr_code.png" style=" position:relative; left:0px;" >
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

                <?php if($previous_page['url']) { ?>上一篇： <a class="f_pre" href="<?php echo $previous_page['url'];?>#top"><?php echo strcut($previous_page['title'],40);?></a> <br><?php } ?>
                <?php if($next_page['url']) { ?>下一篇： <a class="f_next" href="<?php echo $next_page['url'];?>#top"><?php echo strcut($next_page['title'],40);?></a><?php } ?>
<hr>


                <!--高速版，加载速度快，使用前需测试页面的兼容性-->
                <div id="SOHUCS"></div>
                <script>
                    (function(){
                        var appid = 'cyrKWBFTI',
                                conf = 'prod_51cde46e252516e5a1da7093b8db4c12';
                        var doc = document,
                                s = doc.createElement('script'),
                                h = doc.getElementsByTagName('head')[0] || doc.head || doc.documentElement;
                        s.type = 'text/javascript';
                        s.charset = 'utf-8';
                        s.src =  'http://assets.changyan.sohu.com/upload/changyan.js?conf='+ conf +'&appid=' + appid;
                        h.insertBefore(s,h.firstChild);
                        window.SCS_NO_IFRAME = true;
                    })()
                </script>

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
<script type="text/javascript">
    function show_qrcode(id,str) {
        $("#"+id).attr('src',str);
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
<script type="text/javascript" src="<?php echo WEBURL;?>index.php?f=stat&id=<?php echo $id;?>&cid=<?php echo $cid;?>"></script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>