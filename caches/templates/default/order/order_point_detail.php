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
                        <header class="panel-heading"><span class="title">积分兑换－订单详情</span></header>

                        <div id="myTabContent" class="tab-content tabsbordertop">

                            <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">
                                <div class="panel-body" id="panel-bodys">
                                    <table class="table table-striped table-advance table-hover text-center">
                                            <tr>
                                                <th width="150" align="right">商品名称</th>
                                                <td  align="left"><?php echo $goods['remark'];?></td>
                                            </tr>
                                            <tr>
                                                <th align="right">下单时间</th>
                                                <td align="left"><?php echo date('Y-m-d H:i:s',$goods['addtime']);?></td>
                                            </tr>

                                            <tr>
                                                <th align="right">收件地址：</th>
                                                <td align="left"><?php echo $goods['address'];?></td>
                                            </tr>
                                            <tr>
                                                <th align="right">当前状态：</th>
                                                <td align="left"><?php echo $status[$goods['status']];?></td>
                                            </tr>
                                            <?php if($goods['post_time']) { ?>
                                            <tr>
                                                <th align="right">发货时间：</th>
                                                <td align="left"><?php echo date('Y-m-d H:i:s',$goods['post_time']);?></td>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                </div>

                            </div>



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
