<?php defined('IN_WZ') or exit('No direct script access allowed'); ?>  <?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>

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

      .edeshen{ display: block; position: absolute; top: 0px; right: 20px; z-index: 100; width: 60px;}
  </style>
  <link rel="stylesheet" href="<?php echo R;?>js/photoswipe/photoswipe.css">
  <link rel="stylesheet" href="<?php echo R;?>js/photoswipe/default-skin/default-skin.css">
  <script src="<?php echo R;?>js/photoswipe/photoswipe.min.js"></script>
  <script src="<?php echo R;?>js/photoswipe/photoswipe-ui-default.min.js"></script>

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


  <div class="container">
      <div class="row">
          <div class="col-xs-12">
              <h3 class="margin_bottom30  margin_top30 font_20_namal"><?php echo $title;?></h3>

              <!--全屏1 b-->
              <div class="my-simple-gallery edeshen" itemscope itemtype="http://schema.org/ImageGallery">
                  <?php $n=1;if(is_array($pictures)) foreach($pictures AS $r) { ?>
                  <figure itemprop="associatedMedia" class="hide">
                      <a href="<?php echo $r['url'];?>" itemprop="contentUrl" data-size="<?php echo imagesize($r['url']);?>">
                          <img style="width: 0px;"   src="<?php echo $r['url'];?>" itemprop="thumbnail" alt="<?php echo $r['alt'];?>"  />全屏预览
                      </a>
                      <div class="ext-info" style=" display: none">
                          <figcaption itemprop="caption description"><?php echo $r['alt'];?></figcaption>
                      </div>
                      <a class="btn" href="<?php echo $r['url'];?>" itemprop="contentUrl" data-size="<?php echo imagesize($r['url']);?>"></a>
                  </figure>
                  <?php $n++;}?>
              </div>

          </div>
      </div>
  </div>

  <div class="container-fluid">
      <!-- main slider carousel -->

      <div  id="slider">
          <div class="" id="carousel-bounding-box">
              <div id="myCarousel" class="carousel slide">
                  <!-- main slider carousel items -->
                  <div class="carousel-inner">
                      <?php $n=1;if(is_array($pictures)) foreach($pictures AS $r) { ?>
                      <div class="<?php if($n==1) { ?>active<?php } ?> item" data-slide-number="<?php echo $n-1; ?>">
                          <img src="<?php echo $r['url'];?>" class="img-responsive">
                      </div>
                      <?php $n++;}?>
                  </div>
                  <!-- main slider carousel nav controls -->
                  <a class="left carousel-control" href="#myCarousel" role="button" id="prev-slide">
                      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#myCarousel" role="button" id="next-slide">
                      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                  </a>
              </div>
          </div>
      </div>
      <!--/main slider carousel-->

  </div><!--container-fluid-->

  <div class="container">
      <!--照片描述-->

      <div class="pic-describe">
          <?php $totals = count($pictures);?>
          <?php $n=1;if(is_array($pictures)) foreach($pictures AS $r) { ?>
          <div class="pic_items  item <?php if($n!=1) { ?>hide<?php } ?>" id="itemid<?php echo intval($n-1);?>">
              <div class="media">
                  <div class="media-left">
                      <div class="d-number"><span  class="color_primary font_size32"><?php echo $n;?></span>/<?php echo $totals;?> </div>
                  </div>
                  <div class="media-body">
                      <?php echo $r['alt'];?>
                  </div>
              </div>
          </div>
<?php $n++;}?>
      </div>
  </div>


  <!-- thumb navigation carousel -->
  <div class=" hidden-sm hidden-xs" id="slider-thumbs" style="background: #f3f3f3; padding: 8px 8px 4px 8px; border: 1px solid #eee">
      <!-- thumb navigation carousel items -->
      <ul class="list-inline silder-suoluetu" style="margin-bottom: 0; text-align: center">
          <?php $n=1;if(is_array($pictures)) foreach($pictures AS $r) { ?>
          <li>
              <a id="carousel-selector-<?php echo $n-1; ?>" <?php if($n==1) { ?>class="selected"<?php } ?>>
              <img src="<?php echo $r[url];?>"  class="img-responsive" width="80" style="height: 60px;"  >
              </a>
          </li>
          <?php $n++;}?>

      </ul>
  </div>

  <!-- 全屏2 b -->

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
      var photo_totals = <?php echo $totals;?>;
  </script>


  <script type="text/javascript" src="<?php echo WEBURL;?>index.php?f=stat&id=<?php echo $id;?>&cid=<?php echo $cid;?>"></script>


<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>