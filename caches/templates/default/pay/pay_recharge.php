<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<style type="text/css">
    .payment-show .payment-desc {
        color: #999;
        display: block;
        overflow: auto;
    }
    .table_form {
        width: 980px;
        margin: auto;
    }

</style>
<table width="100%" cellspacing="0" class="table_form">
    <tr>
        <td  width="120">费用：</td>
        <td>1元</td>
    </tr>


    <tr>
        <td  width="120">合计：</td>
        <td><font style="color:#F00; font-size:22px;font-family:Georgia,Arial; font-weight:700">1</font>  元</td>
    </tr>

    <tr>
        <td  width="120">支付方式：</td>
        <td>支付宝</td>
    </tr>
</table>
<div class="bk10"></div>
<?php echo $paycode;?>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>