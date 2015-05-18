<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<link type="text/css" rel="stylesheet" href="<?php echo R;?>h1jk/css/tuangou_style.css">

<div class="white-section">
    <!--订单内容-->
    <link type="text/css" rel="stylesheet" href="<?php echo R;?>css/style_address.css">
    <form method="post" action="<?php echo WEBURL;?>index.php?m=order&v=confirm">
    <div id="contenter">
        <div class="jet">
            <div class="shipping-address">
                <h4 class="font_size14" style="font-weight:700; margin:40px 0px 16px 0px;">选择收货地址</h4>
                <div class="list">
                    <?php $n=1;if(is_array($address_result)) foreach($address_result AS $r) { ?>
                    <div class="addr <?php if($n==1) { ?>addr-active<?php } ?> " <?php if($n>4) { ?>style='display:none'<?php } ?> onclick="change_add(<?php echo $r['addressid'];?>,this);">
                        <div class="inner">
                            <div class="addr-hd"><?php echo $r['province'];?><?php echo $r['city'];?>(<?php echo $r['addressee'];?>收)</div>
                            <div class="addr-bd"><?php echo $r['area'];?> <?php echo $r['address'];?> <?php if($r['mobile']) { ?><?php echo $r['mobile'];?><?php } else { ?><?php echo $r['tel'];?><?php } ?> </div>
                        </div>
                        <ins class="curmarker"></ins> <a class="defaultaddress" id="def<?php echo $r['addressid'];?>" <?php if($n!=1) { ?>style="display:none;"<?php } ?>>默认地址</a>
                    <a class="setdefault" onclick="setdefault(<?php echo $r['addressid'];?>,this);">设为默认</a> </div>
                    <?php $n++;}?>

                </div>
                <div class="control"><a href="javascript:;" id="new_address" style="display: none;" onclick="open_address();" class="new_address">+ 新增收货地址</a>
                    <a href="javascript:;" onclick="showall_address(this);" class="showAll">显示全部</a> <a href="index.php?m=order&f=address&v=listing&acbar=3" class="manageAddr" target="_blank">管理收货地址</a> </div>
            </div>
            <h4 class="font_size14" style="font-weight:700;margin:40px 0px 16px 0px;">确认订单信息</h4>
            <div class="orders">
                <table class="grid-bundle grid-TmallSeller">
                    <thead>
                    <tr>
                        <th class="tube-title">商品</th>
                        <th class="tube-price">积分</th>
                        <th class="tube-amount">数量</th>
                        <th class="tube-promo">优惠</th>
                        <th class="tube-sum">小计</th>
                        <th class="tube-postage">配送方式</th>
                    </tr>
                    <tr class="row-border">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="tube-postage"></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="grid-main">
                        <td colspan="5" class="tube-main"><table>
                            <tbody>
                            <tr class="grid-order">
                                <td class="tube-img"><a class="img" href="#"><img src="<?php echo $goods['thumb'];?>" style="max-width: 50px;max-height: 50px;"></a></td>
                                <td class="tube-master"><p class="item-title"><a href="#"><?php echo $goods['title'];?></a></p></td>
                                <td class="tube-sku"></td>
                                <td class="tube-price"><?php echo $goods['point'];?>点</td>
                                <td class="tube-amount"><div class="tc-amount">1</div></td>
                                <td class="tube-promo">-</td>
                                <td class="tube-sum"><span class="itemPay">
                      <p class="sum"><?php echo $goods['point'];?>点</p>
                      </span></td>
                            </tr>
                            </tbody>
                        </table></td>
                        <td class="tube-postage tube-postage-coverage">
                            <div class="cage postage">
                                <label class="hd">
                                    普通配送 （免邮）</label>

                            </div>

                        </td>
                    </tr>
                    </tbody>

                </table>
            </div>
            <div class="checkbar">
                <div class="checkbar">
                    <div class="due">
                        <div class="realPay"><p class="money"><span class="hd">实付：</span><span class="bd"><span class="tc-rmb"></span><strong><?php echo $goods['point'];?>点</strong></span></p></div>
                </div>
            </div>
                <?php $n=1;if(is_array($form_fields)) foreach($form_fields AS $fields) { ?>
                <input type="hidden" name="<?php echo $fields;?>" value="<?php echo $goods[$fields];?>">
                <?php $n++;}?>
                <input type="hidden" name="addressid" id="addressid" value="<?php echo $addressid;?>">
                <input type="hidden" name="secret_key" value="<?php echo $secret_key;?>">
                <input type="submit" name="submit" id="copy-button" value="提交订单" class="btn btn-info btn-lg" style="height: 42px;padding-top: 0px;margin-bottom: 10px;">
        </div>

    </form>
    </div>
<!--订单内容-->

</div>
<link rel="stylesheet" href="<?php echo R;?>js/dialog/ui-dialog.css" />
<script src="<?php echo R;?>js/dialog/dialog-plus.js"></script>
<script src="<?php echo R;?>js/wuzhicms.js"></script>
<script type="text/javascript">
    function setdefault(addressid,obj) {
        $.post("index.php?m=order&f=address&v=setdefault&addressid="+addressid, { js: "1"},
        function(data){
            $('.addr').removeClass('addr-active');
            $(obj).parent().addClass('addr-active');
            $("#addressid").val(addressid);
            $(".defaultaddress").css('display','none');
            $("#def"+addressid).css('display','');

        });
    }
    function change_add(addressid,obj) {
        $('.addr').removeClass('addr-active');
        $(obj).addClass('addr-active');
        $("#addressid").val(addressid);
    }
    function open_address() {
        openiframe('index.php?m=order&f=address&v=add', 'edit', '新增收货地址', 660, 430);
    }
    function showall_address(obj) {
        //$('.addr').css('display','');
        $('.addr').animate({opacity: 'show',height: '100%' }, 1000);
        $(obj).css('display','none');
        $('#new_address').css('display','');
    }
</script>

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>