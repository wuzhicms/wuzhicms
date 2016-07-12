<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>
<script src="<?php echo R;?>member/js/jscarousel.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#jsCarousel').jsCarousel({ onthumbnailclick: function(src) {
            // 可在这里加入点击图片之后触发的效果
            $("#overlay_pic").attr('src', src);
            $(".overlay").show();
        }, autoscroll: true });

        $(".overlay").click(function(){
            $(this).hide();
        });
    });
</script>
<!--正文部分-->
<div class="container adframe">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            
        </div>
    </div>
</div>

<div class="container memberframe">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <!--左侧开始-->
            <div class="memberleft">
                <div class="membertitle"><h3>会员中心</h3></div>
                <div class="memberborder">
                    <?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','left'); ?>
                </div>
            </div>
            <!--左侧结束-->

            <!--右侧开始-->
            <div class="memberright">

                <div class="memberbordertop">
                    <section class="panel">
                        <header class="panel-heading"><span class="title">我收藏的套餐</span></header>

                        <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">
                            <div class="panel-body" id="panel-bodys">
                                <table class="table table-striped table-advance table-hover text-center">
                                    <thead>
                                    <tr>
                                        <th class="tablehead">套餐名称</th>
                                        <th class="tablehead">收藏时间</th>
                                        <th class="tablehead">现价</th>
                                        <th class="tablehead">原价</th>
                                        <th class="tablehead">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                                    <tr>
                                        <td align="left"><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['title'];?></a></td>
                                        <td><?php echo date('Y-m-d',$r['addtime']);?></td>
                                        <td><?php echo $r['price'];?></td>
                                        <td><?php echo $r['price_old'];?></td>
                                        <td class="orderlist"><span><a href="?m=member&f=favorite&v=delete&fid=<?php echo $r['fid'];?>">删除</a></span></td>
                                    </tr>
<?php $n++;}?>

                                    </tbody>
                                </table>
                            </div>
<?php if($total>10) { ?>
                            <!--分页开始-->
                            <div class="paginationpage text-center">
                                <nav>
                                    <ul class="pagination">
                                        <?php echo $pages;?>
                                    </ul>
                                </nav>
                            </div>
                            <?php } ?>
                            <!--分页结束-->
                        </div>
                    </section>
                </div>

            </div>
            <!--右侧结束-->


        </div>
    </div>
</div>
<!--正文部分-->
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>

