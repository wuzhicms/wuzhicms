<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>
<div class="container membercenter">
    <div class="row">
        <div class="span3 memberleft">
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','left'); ?>
        </div>
        <div class="memberright">
            <div class="memberframe order">
                <div class="memberinfotitle"><h4>预约体检</h4></div>
                <div class="orderstate"><strong>订单信息：</strong></div>
                您的预约信息已经提交！预约单号：<?php echo $card_no;?> <br>
                重要提示：<a href="index.php?m=order&order_form&v=subscribe&acbar=3">查看我的预约单</a> <br>
                您的预约体检地点：<?php echo $r['title'];?> ，您预约的体检时间：<?php echo $tjtime;?>
            </div>

        </div>
    </div>


</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>
