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
                        <header class="panel-heading"><span class="title">积分兑换商品信息</span></header>

                        <ul id="myTab" class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tabs1" id="1tab" role="tab" data-toggle="tab" aria-controls="tabs1" aria-expanded="true">全部订单</a></li>
                            <li role="presentation" class=""><a href="?m=credit&f=mycredit&v=listing" role="tab" >积分明细</a></li>
                        </ul>
                        </li>
                        </ul>

                        <div id="myTabContent" class="tab-content tabsbordertop">

                            <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">
                                <div class="panel-body" id="panel-bodys">

                                    <table class="table table-striped table-advance table-hover text-center">
                                        <thead>
                                        <tr>
                                            <th class="tablehead">订单ID</th>
                                            <th class="tablehead">订单信息</th>
                                            <th class="tablehead">下单时间</th>
                                            <th class="tablehead">状态</th>
                                            <th class="tablehead">积分</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                                        <tr>
                                            <td class="orderlist"><?php echo $r['orderid'];?></td>
                                            <td class="orderlist"><a href="<?php echo $r['url'];?>" target="_blank"><div class="orderproimg"><img src="<?php echo $r['thumb'];?>" title="<?php echo $r['remark'];?>"><span><?php echo strcut($r['remark'],30);?></span></div></a></td>
                                            <td class="orderlist"><?php echo date('Y-m-d H:i',$r['addtime']);?></td>
                                            <td class="orderlist"><?php echo $status[$r['status']];?></td>
                                            <td class="orderlist"><?php echo $r['point'];?></td>
                                        </tr>
                                        <?php $n++;}?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="paginationpage text-center">
                                    <nav>
                                        <ul class="pagination">
                                            <?php echo $pages;?>
                                        </ul>
                                    </nav>
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