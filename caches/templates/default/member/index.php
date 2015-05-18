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

                <div class="memberbordertop ybg">
                    <div class="memberdateblock">
                        <h3>我的会员中心</h3>
                        <div class="memberpadding">
                            <div class="prompt text-center">早上好，欢迎光临！您现在是<strong><i class="smmember <?php echo $groups[$memberinfo['groupid']]['icon'];?>"></i> <?php echo $groups[$memberinfo['groupid']]['name'];?></strong> 一共有 <strong>【<?php echo $memberinfo['points'];?>】</strong> 积分<?php if($groupid!=5 && $groupid!=4) { ?>，再获得 <a href="#">【<?php echo $nextpoints;?>】</a> 积分即可成为 <strong><i class="smmember <?php echo $groups[$next_group]['icon'];?>"></i><?php echo $groups[$next_group]['name'];?></strong><?php } ?></div>
                            <div class="promptaccunticon">
                                <div class="safelevel">
                                    您的账户安全等级：<?php if($safe_level==3) { ?><a href="#" class="low">高</a><?php } elseif ($safe_level==2) { ?><a href="#" class="in">中</a><?php } else { ?><a href="#" class="hight">低</a><?php } ?>
                                </div>
                                <div class="verification">

                                    <?php if($memberinfo['ischeck_mobile']) { ?><a href="?m=member&f=index&v=edit_mobile"><i class="vmoblieicon"></i>手机已验证</a><?php } else { ?><a href="?m=member&f=index&v=edit_mobile"><i class="moblieicon"></i>手机未验证</a><?php } ?>
                                    <?php if($memberinfo['ischeck_email']) { ?><a href="?m=member&f=index&v=profile"><i class="vemailicon"></i>邮箱已验证</a><?php } else { ?><a href="?m=member&f=index&v=profile"><i class="emailicon"></i>邮箱未验证</a><?php } ?>
                                </div>
                                <div class="logintime">上次登录时间：<?php echo date('Y-m-d H:i',$memberinfo['lasttime']);?></div>
                            </div>
                            <div class="memberdateinfo">
                                <ul>
                                    <li><a href="#"><i class="moneyicon"></i>金额：<span>（<?php echo $memberinfo['money'];?>）</span></a></li>
                                    <li><a href="?m=order&f=order_goods&v=listing&acbar=3#tabs3"><i class="pendingorder"></i>待处理订单：<span>（<?php echo $order_goods_count;?>）</span></a></li>
                                    <li><a href="?m=order&f=order_form&v=subscribe&acbar=3"><i class="evaluation"></i>待评价商品：<span>（<?php echo $order_goods_comment;?>）</span></a></li>
                                    <li><a href="#"><i class="coupon"></i>优惠券：<span>（<?php echo $coupon_card_count;?>）</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="memberbordertop myorder">
                    <section class="panel">
                        <header class="panel-heading"><span class="title">我的订单</span><span class="pull-right"><a href="?m=order&f=order_goods&v=listing&acbar=3">查看更多订单信息>></a></span></header>
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
                                <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                                <tr>
                                    <td colspan="7" class="text-left ordernumber">订单号：<?php echo $r['order_no'];?> <?php if($r['cardtype']==1) { ?>(<font color="green">实物卡</font>)<?php } ?> <?php if($r['snid']) { ?> <?php echo $r['express'];?>单号：<?php echo $r['snid'];?><?php } ?></td>
                                </tr>
                                <tr>
                                    <td class="orderlist" style="max-width: 300px;">
                                        <?php $n=1;if(is_array($r['goodlist'])) foreach($r['goodlist'] AS $goodlist) { ?>
                                        <a href="<?php echo $goodlist['url'];?>"><div class="orderproimg"><img src="<?php echo $goodlist['thumb'];?>" title="<?php echo $goodlist['remark'];?>"><span><?php echo strcut($goodlist['remark'],20);?></span></div></a>
                                        <?php $n++;}?>
                                    </td>
                                    <td class="orderlist"><?php echo $r['quantity'];?></td>
                                    <td class="orderlist"><?php echo date('Y-m-d H:i',$r['addtime']);?></td>
                                    <td class="orderlist"><i class="onlinepay"></i>在线付款</td>
                                    <td class="orderlist"><?php if($r['status']==2) { ?><i class="nopayment"></i>未付款<?php } elseif ($r['status']==3) { ?>已取消<?php } elseif ($r['status']==1 || $r['status']==5) { ?><i class="paymenticon"></i>已付款<?php } elseif ($r['status']==6) { ?><i class="paymenticon"></i>已发货<?php } ?></td>
                                    <td class="orderlist">￥<?php echo $r['money'];?></td>
                                    <td><?php if($r['status']==2) { ?><a href="?m=order&f=order_goods&v=repay&order_no=<?php echo $r['order_no'];?>" class="btn btn-orderpay" target="_blank">马上付款</a> <br><br> <a href="?m=order&f=order_goods&v=cancel&order_no=<?php echo $r['order_no'];?>">取消订单</a><?php } elseif ($r['status']==5 && $r['comment']==0) { ?><a href="#" class="btn btn-order">立即点评</a><?php } ?></td>
                                </tr>
                                <?php $n++;}?>
                                </tbody>
                            </table>
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
