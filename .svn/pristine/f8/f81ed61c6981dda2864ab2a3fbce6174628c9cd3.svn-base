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
                        <header class="panel-heading"><span class="title">发票申请记录</span></header>

                        <ul id="myTab" class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tabs1" id="1tab" role="tab" data-toggle="tab" aria-controls="tabs1" aria-expanded="true">全部</a></li>
                            <li role="presentation" class=""><a href="#tabs2" role="tab" id="2tab" data-toggle="tab" aria-controls="tabs2" aria-expanded="false">申请发票</a></li>
                        </li>
                        </ul>

                        <div id="myTabContent" class="tab-content tabsbordertop">

                            <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">
                                <div class="panel-body" id="panel-bodys">
                                    <table class="table table-striped table-advance table-hover text-center">
                                        <thead>
                                        <tr>
                                            <th class="tablehead">申请单号</th>
                                            <th class="tablehead">姓名</th>
                                            <th class="tablehead">发票抬头</th>
                                            <th class="tablehead">金额</th>
                                            <th class="tablehead">申请时间</th>
                                            <th class="tablehead">处理状态</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                                        <tr>
                                            <td class="orderlist"><?php echo $r['id'];?></td>
                                            <td class="orderlist"><?php echo $r['linkman'];?></td>
                                            <td class="orderlist"><?php echo $r['title'];?></td>
                                            <td class="orderlist">￥<?php echo $order_result[$r['orderid']]['money'];?></td>
                                            <td class="orderlist"><?php echo date('Y-m-d H:i:i',$r['addtime']);?></td>
                                            <td class="orderlist"><i class="<?php if($r['status']==1) { ?>paymenticon<?php } else { ?>nopayment<?php } ?>"></i><?php echo $status_arr[$r['status']];?></td>
                                        </tr>
                                        <?php $n++;}?>
                                        </tbody>
                                    </table>
                                </div>
<?php if($total>20) { ?>
                                <div class="paginationpage text-center">
                                    <nav>
                                        <ul class="pagination">
                                            <?php echo $pages;?>
                                        </ul>
                                    </nav>
                                </div>
<?php } ?>
                            </div>


                            <div role="tabpanel" class="tab-pane fade" id="tabs2" aria-labelledby="2tab">
                                <?php if(empty($order_values)) { ?>
<div style="padding: 50px;text-align: center;">您当前没有任何订单可以申请发票</div>
                                <?php } else { ?>
                                <form name="myform" action="index.php?m=receipt&f=receipt&v=apply" method="post" id="myform">
                                    <table class="table table-striped table-advance table-hover">
                                        <tbody><tr>
                                            <th width="150" align="right">选择订单：</th>
                                            <td><?php echo WUZHI_form::select($order_values, 0, 'name="orderid" class="input-sm"', '');?></td>
                                        </tr>
                                        <tr>
                                            <th align="right">发票抬头：</th>
                                            <td><input name="title" type="text" id="title" size="30" value=""></td>
                                        </tr>
                                        <tr>
                                            <th align="right">收件人姓名：</th>
                                            <td><input name="linkman" type="text" id="linkman" size="30" value=""></td>
                                        </tr>
                                        <tr>
                                            <th align="right">电 话：</th>
                                            <td><input name="tel" type="text" id="tel" size="30" value=""></td>
                                        </tr>
                                        <tr>
                                            <th align="right">收件地址：</th>
                                            <td><input name="address" type="text" id="address" size="30" value=""></td>
                                        </tr>
                                        <tr>
                                            <th align="right">邮编：</th>
                                            <td><input name="zip" type="text" id="zip" size="6" value=""></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td colspan="2"><label>
                                                <input type="submit" name="submit" id="dosubmit" value="确认申请" class="btn btn-submit">
                                            </label></td>
                                        </tr>
                                        </tbody></table>
                                </form>
                                <?php } ?>
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