<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>

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
                        <header class="panel-heading"><span class="title">我收藏的机构</span></header>


                        <div id="myTabContent" class="tab-content tabsbordertop">

                            <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">
                                <div class="panel-body" id="panel-bodys">
                                    <table class="table table-striped table-advance table-hover text-center">
                                        <thead>
                                        <tr>
                                            <th class="tablehead">机构名称</th>
                                            <th class="tablehead">最新体检套餐</th>
                                            <th class="tablehead">现价（元）</th>
                                            <th class="tablehead">原价（元）</th>
                                            <th class="tablehead">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>

                                        <tr>
                                            <td colspan="7" class="text-left ordernumber"><?php echo $r['title'];?> <span style="float: right;">地址：<?php echo $r['address'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td class="orderlist"><a href="<?php echo $r['url'];?>"><div class="orderproimg"><img src="<?php echo $r['thumb'];?>"></div></a></td>
                                            <td class="tuanlist orderlist">
                                                <?php $n=1;if(is_array($r['tuan_list'])) foreach($r['tuan_list'] AS $rs) { ?>
                                                <div><a href="<?php echo $rs['url'];?>" target="_blank"><?php echo $rs['title'];?></a></div>
                                                <?php $n++;}?></td>
                                            <td class="tuanlist orderlist">
                                                <?php $n=1;if(is_array($r['tuan_list'])) foreach($r['tuan_list'] AS $rs) { ?>
                                                <div>￥<?php echo $rs['price'];?></div>
                                                <?php $n++;}?></td>
                                            <td class="tuanlist orderlist">
                                                <?php $n=1;if(is_array($r['tuan_list'])) foreach($r['tuan_list'] AS $rs) { ?>
                                                <div>￥<?php echo $rs['price_old'];?></div>
                                                <?php $n++;}?></td>

                                            <td class="orderlist"><span><a href="?m=member&f=favorite&v=delete&fid=<?php echo $r['fid'];?>">删除</a></span></td>
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


                            <div role="tabpanel" class="tab-pane fade" id="tabs2" aria-labelledby="2tab">
                                <div class="panel-body" id="panel-bodys">
                                    <table class="table table-striped table-advance table-hover text-center">
                                        <thead>
                                        <tr>
                                            <th class="tablehead">订单信息</th>
                                            <th class="tablehead">数量</th>
                                            <th class="tablehead">下单时间</th>
                                            <th class="tablehead">支付方式</th>
                                            <th class="tablehead">状态</th>
                                            <th class="tablehead">金额（总价）</th>
                                            <th class="tablehead">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $n=1;if(is_array($result2)) foreach($result2 AS $r) { ?>
                                        <tr>
                                            <td colspan="7" class="text-left ordernumber">订单号：<?php echo $r['order_no'];?> <?php if(count_field($result,$r['order_no'])>1) { ?>(包含子订单)<?php } ?></td>
                                        </tr>
                                        <tr>
                                            <td class="orderlist"><a href="#"><div class="orderproimg"><img src="<?php echo $r['thumb'];?>" title="<?php echo $r['remark'];?>"><span><?php echo strcut($r['remark'],30);?></span></div></a></td>
                                            <td class="orderlist"><?php echo $r['quantity'];?></td>
                                            <td class="orderlist"><?php echo date('Y-m-d H:i',$r['addtime']);?></td>
                                            <td class="orderlist"><i class="onlinepay"></i>在线付款</td>
                                            <td class="orderlist"><?php if($r['status']==2) { ?><i class="nopayment"></i>未付款<?php } elseif ($r['status']==3) { ?>已取消<?php } elseif ($r['status']==1 || $r['status']==5) { ?><i class="paymenticon"></i>已付款<?php } ?></td>
                                            <td class="orderlist">￥<?php echo intval($r['money']*$r['quantity']);?></td>
                                            <td><?php if($r['status']==2) { ?><a href="?m=order&f=order_goods&v=repay&order_no=<?php echo $r['order_no'];?>" class="btn btn-orderpay" target="_blank">马上付款</a> <br><br> <a href="?m=order&f=order_goods&v=cancel&order_no=<?php echo $r['order_no'];?>">取消订单</a><?php } elseif ($r['status']==5 && $r['comment']==0) { ?><a href="#" class="btn btn-order">立即点评</a><?php } ?></td>
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
                                            <th class="tablehead">订单信息</th>
                                            <th class="tablehead">数量</th>
                                            <th class="tablehead">下单时间</th>
                                            <th class="tablehead">支付方式</th>
                                            <th class="tablehead">状态</th>
                                            <th class="tablehead">金额（总价）</th>
                                            <th class="tablehead">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $n=1;if(is_array($result3)) foreach($result3 AS $r) { ?>
                                        <tr>
                                            <td colspan="7" class="text-left ordernumber">订单号：<?php echo $r['order_no'];?> <?php if(count_field($result,$r['order_no'])>1) { ?>(包含子订单)<?php } ?></td>
                                        </tr>
                                        <tr>
                                            <td class="orderlist"><a href="#"><div class="orderproimg"><img src="<?php echo $r['thumb'];?>" title="<?php echo $r['remark'];?>"><span><?php echo strcut($r['remark'],30);?></span></div></a></td>
                                            <td class="orderlist"><?php echo $r['quantity'];?></td>
                                            <td class="orderlist"><?php echo date('Y-m-d H:i',$r['addtime']);?></td>
                                            <td class="orderlist"><i class="onlinepay"></i>在线付款</td>
                                            <td class="orderlist"><?php if($r['status']==2) { ?><i class="nopayment"></i>未付款<?php } elseif ($r['status']==3) { ?>已取消<?php } elseif ($r['status']==1 || $r['status']==5) { ?><i class="paymenticon"></i>已付款<?php } ?></td>
                                            <td class="orderlist">￥<?php echo intval($r['money']*$r['quantity']);?></td>
                                            <td><?php if($r['status']==2) { ?><a href="?m=order&f=order_goods&v=repay&order_no=<?php echo $r['order_no'];?>" class="btn btn-orderpay" target="_blank">马上付款</a> <br><br> <a href="?m=order&f=order_goods&v=cancel&order_no=<?php echo $r['order_no'];?>">取消订单</a><?php } elseif ($r['status']==5 && $r['comment']==0) { ?><a href="#" class="btn btn-order">立即点评</a><?php } ?></td>
                                        </tr>
                                        <?php $n++;}?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="tabs4" aria-labelledby="4tab">
                                <div class="panel-body" id="panel-bodys">
                                    <table class="table table-striped table-advance table-hover text-center">
                                        <thead>
                                        <tr>
                                            <th class="tablehead">订单信息</th>
                                            <th class="tablehead">数量</th>
                                            <th class="tablehead">下单时间</th>
                                            <th class="tablehead">支付方式</th>
                                            <th class="tablehead">状态</th>
                                            <th class="tablehead">金额（总价）</th>
                                            <th class="tablehead">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $n=1;if(is_array($result4)) foreach($result4 AS $r) { ?>
                                        <tr>
                                            <td colspan="7" class="text-left ordernumber">订单号：<?php echo $r['order_no'];?> <?php if(count_field($result,$r['order_no'])>1) { ?>(包含子订单)<?php } ?></td>
                                        </tr>
                                        <tr>
                                            <td class="orderlist"><a href="#"><div class="orderproimg"><img src="<?php echo $r['thumb'];?>" title="<?php echo $r['remark'];?>"><span><?php echo strcut($r['remark'],30);?></span></div></a></td>
                                            <td class="orderlist"><?php echo $r['quantity'];?></td>
                                            <td class="orderlist"><?php echo date('Y-m-d H:i',$r['addtime']);?></td>
                                            <td class="orderlist"><i class="onlinepay"></i>在线付款</td>
                                            <td class="orderlist"><?php if($r['status']==2) { ?><i class="nopayment"></i>未付款<?php } elseif ($r['status']==3) { ?>已取消<?php } elseif ($r['status']==1 || $r['status']==5) { ?><i class="paymenticon"></i>已付款<?php } ?></td>
                                            <td class="orderlist">￥<?php echo intval($r['money']*$r['quantity']);?></td>
                                            <td><?php if($r['status']==2) { ?><a href="?m=order&f=order_goods&v=repay&order_no=<?php echo $r['order_no'];?>" class="btn btn-orderpay" target="_blank">马上付款</a> <br><br> <a href="?m=order&f=order_goods&v=cancel&order_no=<?php echo $r['order_no'];?>">取消订单</a><?php } elseif ($r['status']==5 && $r['comment']==0) { ?><a href="#" class="btn btn-order">立即点评</a><?php } ?></td>
                                        </tr>
                                        <?php $n++;}?>
                                        </tbody>
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
<script >
    <?php if($status==1) { ?>$("#2tab").click();<?php } ?>
</script>
<!--正文部分-->
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>