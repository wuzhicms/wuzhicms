<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<link type="text/css" rel="stylesheet" href="<?php echo R;?>h1jk/css/tuangou_style.css">

<div class="container">
    <div class="gmwidth">
        <div class="row">
            <div class="col-xs-12">
                <div class="gouwu_fukuan_box">
                    <div class="dingdanok_tishi">
                        <div class="fukuan_ok"><span class="glyphicon glyphicon-ok-circle"></span></div>
                        <div class="fukuan_p">
                            <h3>订单已提交，请尽快付款！</h3>
                            <p>
                                订单号：<span class="color_heyihong"><?php echo $order_no;?></span>
                                应付总额：<span class="color_heyihong font_weight">￥<?php echo sprintf('%.2f',$total_price);?></span><br>
                                还差一步，请尽快付款（请在24小时之内付清款项，否则订单会被自动取消）</p>
                        </div>
                    </div>
                    <div class="zhifufangshi">
                        支付方式：<img src="<?php echo R;?>images/icon/alipay.jpg">
                        <br><br>
                       <?php echo $pay_link;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>