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
                        <header class="panel-heading"><span class="title">我的优惠券</span></header>

                        <ul id="myTab" class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tabs1" id="1tab" role="tab" data-toggle="tab" aria-controls="tabs1" aria-expanded="true">未使用优惠券</a></li>
                            <li role="presentation" class=""><a href="#tabs2" role="tab" id="tab2" data-toggle="tab" aria-controls="tabs2" aria-expanded="false">已使用优惠券</a></li>
                            <li role="presentation" class=""><a href="#tabs3" role="tab" id="tab3" data-toggle="tab" aria-controls="tabs3" aria-expanded="false">已过期优惠券</a></li>
                            <li role="presentation" class=""><a href="#tabs4" role="tab" id="tab4" data-toggle="tab" aria-controls="tabs4" aria-expanded="false">优惠券激活</a></li>
                        </li>
                        </ul>

                        <div id="myTabContent" class="tab-content tabsbordertop">

                            <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">
                                <div class="panel-body" id="panel-bodys">
                                    <table class="table table-striped table-advance table-hover text-center">
                                        <thead>
                                        <tr>
                                            <th class="tablehead">优惠券编号</th>
                                            <th class="tablehead">优惠券名称</th>
                                            <th class="tablehead">面值</th>
                                            <th class="tablehead">有效期截止</th>
                                            <th class="tablehead">使用限制</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $n=1;if(is_array($result1)) foreach($result1 AS $r) { ?>
                                        <tr>
                                            <td class="orderlist"><?php echo $r['card_no'];?></td>
                                            <td class="orderlist"><?php echo $r['title'];?></td>
                                            <td class="orderlist"><?php echo $r['mount'];?></td>
                                            <td class="orderlist"><?php echo date('Y-m-d H:i:s',$r['endtime']);?></td>
                                            <td class="orderlist"><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['remark'];?></a></td>

                                        </tr>
                                        <?php $n++;}?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="tabs2" aria-labelledby="2tab">

                                <div class="panel-body" id="panel-bodys">
                                    <table class="table table-striped table-advance table-hover text-center">
                                        <thead>
                                        <tr>
                                            <th class="tablehead">优惠券编号</th>
                                            <th class="tablehead">优惠券名称</th>
                                            <th class="tablehead">面值</th>
                                            <th class="tablehead">有效期截止</th>
                                            <th class="tablehead">使用限制</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $n=1;if(is_array($result2)) foreach($result2 AS $r) { ?>
                                        <tr>
                                            <td class="orderlist"><?php echo $r['card_no'];?></td>
                                            <td class="orderlist"><?php echo $r['title'];?></td>
                                            <td class="orderlist"><?php echo $r['mount'];?></td>
                                            <td class="orderlist"><?php echo date('Y-m-d H:i:s',$r['endtime']);?></td>
                                            <td class="orderlist"><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['remark'];?></a></td>

                                        </tr>
                                        <?php $n++;}?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tabs3" aria-labelledby="3tab">
                                <div class="panel-body" id="panel-bodys">
                                    <table class="table table-striped table-advance table-hover text-center">
                                        <thead>
                                        <tr>
                                            <th class="tablehead">优惠券编号</th>
                                            <th class="tablehead">优惠券名称</th>
                                            <th class="tablehead">面值</th>
                                            <th class="tablehead">有效期截止</th>
                                            <th class="tablehead">使用限制</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $n=1;if(is_array($result3)) foreach($result3 AS $r) { ?>
                                        <tr>
                                            <td class="orderlist"><?php echo $r['card_no'];?></td>
                                            <td class="orderlist"><?php echo $r['title'];?></td>
                                            <td class="orderlist"><?php echo $r['mount'];?></td>
                                            <td class="orderlist"><?php echo date('Y-m-d H:i:s',$r['endtime']);?></td>
                                            <td class="orderlist"><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['remark'];?></a></td>

                                        </tr>
                                        <?php $n++;}?>
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="tabs4" aria-labelledby="4tab">

                                <form name="myform" action="index.php?m=coupon&f=coupon&v=getit" method="post" id="myform">
                                    <table class="table table-striped table-advance table-hover">

                                        <tr>
                                            <th align="right">优惠券：</th>
                                            <td><input name="order_no" type="text" id="order_no" size="30" value=""></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td colspan="2"><label>
                                                <input type="submit" name="submit" id="dosubmit" value="激活" class="btn btn-submit">
                                            </label></td>
                                        </tr>
                                        </tbody></table>
                                </form>

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