<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<style type="text/css">
    .my-simple-gallery {
        width: 100%;
        float: left;
    }
    .my-simple-gallery img {
        width: 100%;
        height: auto;
    }
    .my-simple-gallery figure {
        display: block;
        float: left;
        margin: 0 0px 20px 0;
        width: 100%;
    }
    .my-simple-gallery figcaption {
        display: block;
    }
	
	
	.my-simple-gallery .ext-info {
  padding: 12px;
  line-height: 20px;
    background: #fff;
  box-shadow: 0 1px 2px 0 rgba(210,210,210,.31);
  -webkit-box-shadow: 0 1px 2px 0 rgba(180,180,180,.5);
  border-top: 1px solid #EEE;
  overflow: hidden;
  zoom: 1;
  
}
</style>
<link rel="stylesheet" href="<?php echo R;?>js/photoswipe/photoswipe.css">
<link rel="stylesheet" href="<?php echo R;?>js/photoswipe/default-skin/default-skin.css">
<script src="<?php echo R;?>js/photoswipe/photoswipe.min.js"></script>
<script src="<?php echo R;?>js/photoswipe/photoswipe-ui-default.min.js"></script>
<div class="container Site_map"> 当前位置：<a href="<?php echo WEBURL;?>">首页</a><span> &gt; <?php echo catpos($cid);?></span></div>

<div class="bankuai_1 pd30">
    <div class="container">
        <div class="row">
            <div class="col-xs-8" style="border-right:1px solid #eee">
                <div class="content_title"><?php echo $title;?></div>
                <div class="bignewsbox">
                    <div class="Nfoot">
                        <div class="lwd">时间：<?php echo $addtime;?>&nbsp;&nbsp; 来源：<?php echo $copyfrom;?></div>
                    </div>
                </div>




                <div class="my-simple-gallery" itemscope itemtype="http://schema.org/ImageGallery">

<?php $n=1;if(is_array($pictures)) foreach($pictures AS $r) { ?>

                    <figure itemprop="associatedMedia">
                        <a href="<?php echo $r['url'];?>" itemprop="contentUrl" data-size="<?php echo imagesize($r['url']);?>">
                            <img src="<?php echo imagecut($r['url'],630,460,2);?>" itemprop="thumbnail" alt="<?php echo $r['alt'];?>" />
                        </a>
                        <div class="ext-info">
                        <figcaption itemprop="caption description"><?php echo $r['alt'];?></figcaption>
                        </div>
                    </figure>
<?php $n++;}?>
                </div>

                <div class="content_p">
                    <?php echo $content;?>
                </div>

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

<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe.
         It's a separate element, as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides. PhotoSwipe keeps only 3 slides in DOM to save memory. -->
        <!-- don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">

            <div class="pswp__top-bar">

                <!--  Controls are self-explanatory. Order can be changed. -->

                <div class="pswp__counter"></div>

                <button class="pswp__button pswp__button--close" title="关闭 (Esc)"></button>

                <button class="pswp__button pswp__button--share" title="分享"></button>

                <button class="pswp__button pswp__button--fs" title="全屏显示"></button>

                <button class="pswp__button pswp__button--zoom" title="放大/缩小"></button>

                <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                <!-- element will get class pswp__preloader--active when preloader is running -->
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>

            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
            </button>

            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
            </button>

            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>

        </div>

    </div>

</div>
<script src="<?php echo R;?>js/photoswipe/loadimage.js"></script>
<script type="text/javascript">
    // execute above function
    initPhotoSwipeFromDOM('.my-simple-gallery');
</script>

<script type="text/javascript" src="<?php echo WEBURL;?>index.php?f=stat&id=<?php echo $id;?>&cid=<?php echo $cid;?>"></script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>