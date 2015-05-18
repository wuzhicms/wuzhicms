<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<link type="text/css" rel="stylesheet" href="<?php echo R;?>h1jk/css/tuangou_style.css">

<div class="white-section">
    <!--订单内容-->
    <link type="text/css" rel="stylesheet" href="<?php echo R;?>css/style_address.css">
    <form method="post" action="<?php echo WEBURL;?>index.php?m=order&f=order_goods&v=confirm" onsubmit="return checkform();">
    <div id="contenter">
        <div class="jet">
            <div class="shipping-address">
                <h4 class="font_size14" style="font-weight:700; margin:40px 0px 16px 0px;">选择收货地址</h4>
                <div class="list">
                    <?php $n=1;if(is_array($address_result)) foreach($address_result AS $r) { ?>
                    <div class="addr <?php if($r['addressid']==$addressid) { ?>addr-active<?php } ?> " <?php if($n>8) { ?>style='display:none'<?php } ?> onclick="change_add(<?php echo $r['addressid'];?>,this);">
                        <div class="inner">
                            <div class="addr-hd"><?php echo $r['province'];?><?php echo $r['city'];?>(<?php echo $r['addressee'];?>收)</div>
                            <div class="addr-bd"><?php echo $r['area'];?> <?php echo $r['address'];?> <?php if($r['mobile']) { ?><?php echo $r['mobile'];?><?php } else { ?><?php echo $r['tel'];?><?php } ?> </div>
                        </div>
                        <ins class="curmarker"></ins> <a class="defaultaddress" id="def<?php echo $r['addressid'];?>" <?php if($r['addressid']!=$addressid) { ?>style="display:none;"<?php } ?>>默认地址</a>
                    <a class="setdefault" onclick="setdefault(<?php echo $r['addressid'];?>,this);">设为默认</a> </div>
                    <?php $n++;}?>

                </div>
                <div class="control"><a href="/index.php?m=order&f=address&v=listing&acbar=1&tab=tabs2&forward=1" id="new_address" style="display: ;" class="new_address">+ 新增收货地址</a>
                    <?php if(count($address_result)>8) { ?>
                    <a href="javascript:;" id="showallid" onclick="showall_address();" class="showAll">显示全部地址</a> <?php } ?><a href="index.php?m=order&f=address&v=listing&acbar=3" class="manageAddr" target="_blank">管理收货地址</a> </div>
            </div>
            <h4 class="font_size14" style="font-weight:700;margin:40px 0px 16px 0px;">确认订单信息</h4>
            <div class="orders">
                <table class="grid-bundle grid-TmallSeller">
                    <thead>
                    <tr>
                        <th class="tube-title">商品</th>
                        <th class="tube-price">单价（元）</th>
                        <th class="tube-amount">数量</th>
                        <th class="tube-promo">优惠（元）</th>
                        <th class="tube-sum">小计（元）</th>
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
                    <?php $n=1;if(is_array($goods_result)) foreach($goods_result AS $r) { ?>
                    <tr class="grid-main">
                        <td colspan="5" class="tube-main"><table>
                            <tbody>
                            <tr class="grid-order">
                                <td class="tube-img"><input type="hidden" name="cartids[]" value="<?php echo $r['cartid'];?>">
                                    <input type="hidden" name="quantity[<?php echo $r['cartid'];?>]" value="<?php echo $r['quantity'];?>">
                                    <a class="img" href="<?php echo $r['url'];?>" target="_blank"><img src="<?php echo $r['thumb'];?>" style="max-width: 50px;max-height: 50px;"></a></td>
                                <td class="tube-master"><p class="item-title"><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['title'];?></a></p></td>
                                <td class="tube-sku"></td>
                                <td class="tube-price"><?php echo $r['price'];?></td>
                                <td class="tube-amount"><div class="tc-amount"><?php echo $r['quantity'];?></div></td>
                                <td class="tube-promo"><?php echo $r['jr_price'];?></td>
                                <td class="tube-sum"><span class="itemPay">
                      <p class="sum"><?php echo $r['count_price'];?></p>
                      </span></td>
                            </tr>
                            </tbody>
                        </table></td>
                        <td class="tube-postage tube-postage-coverage">
                            <div class="cage postage center">
                                <label class="hd">
                                    普通配送 （免邮费）</label>

                            </div>

                        </td>
                    </tr>
                    <?php $n++;}?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td class="tube-annex" colspan="5"><div class="memo"> 补充说明：
                            <input name="mynote" type="text" value="" placeholder="选填，特殊要求，如开发票，发票抬头" maxlength="150" style="width: 280px;">
                        </div></td>
                        <td class="tube-bill"></td>
                    </tr>
                    <tr>
                        <td style="background: #F2F4F9;padding-left: 20px;border-top: 1px solid #B4D0FF" colspan="6"><div class="memo" style="color: #564E52;"> <input type="radio" name="cardtype" value="0" checked> 选择虚拟卡 （适用于需要直接预约体检的客户）
                            <input type="radio" name="cardtype" value="1"> 选择实体卡 （适用于企业，赠送亲朋，赠送客户）

                        </div></td>
                    </tr>
                    <?php if(!empty($cards_result)) { ?>
                    <tr>
                        <td style="background: #F2F4F9;padding-left: 20px;border-top: 1px solid #B4D0FF" colspan="6"><div class="memo" style="color: #564E52;">
                            您有未使用的优惠券：
                            <select name="coupon_card" id="coupon_card" onchange="count_price(this.value);">
                        <option value="">不使用</option>
                                <?php $n=1;if(is_array($cards_result)) foreach($cards_result AS $r) { ?>
                        <option value="<?php echo $r['aid'];?>"><?php echo $r['mount'];?> 元 <?php echo $r['remark'];?></option>
                                <?php } ?>
                        </select>
                        </div></td>
                    </tr>
                    <?php } ?>
                    </tfoot>
                </table>
            </div>
            <div class="checkbar">

                <div class="coupon">
                    <input name="check_use" id="check_use" type="checkbox" style="vertical-align:top">
                    使用合一健康积分 <span id="jifenid" class="jifenduihuan">
                  <input name="usepoint" id="usepoint" type="text" size="6" onblur="change_points(this.value)" value="<?php echo $memberinfo['points'];?>">
                  点 <span class="color_warning">-￥<span id="point_price"> <?php echo sprintf('%.2f',$memberinfo['points']/100);?></span></span>
                  <p style="text-align:left;white-space: nowrap; padding-left:112px; color:#777">(可用<?php echo $memberinfo['points'];?>点)</p>
                  </span></div>
                <div class="due">
                    <div class="realPay">
                        <p class="money"><span class="hd">实付款：</span><span class="bd"><span class="tc-rmb"></span><strong><span id="total_price"><?php echo $total_price;?></span></strong></span></p>
                    </div>
                    <div class="obtainedPoint"> 可获得合一 <span class="inner">健康积分</span>：<span class="obtain"><strong><?php echo $point;?></strong>点</span> </div>
                </div>

                <div class="action"><a class="back-cart" href="javascript:history.go(-1);">返回购物车修改</a><div class="go-wrapper"><button type="submit" class="btn btn-danger_g active btn-lg">&nbsp;&nbsp;提交订单&nbsp;&nbsp;</button></div></div>
            </div>
                <?php $n=1;if(is_array($form_fields)) foreach($form_fields AS $fields) { ?>
                <input type="hidden" name="<?php echo $fields;?>" value="<?php echo $goods[$fields];?>">
                <?php $n++;}?>
                <input type="hidden" name="addressid" id="addressid" value="<?php echo $addressid;?>">
                <input type="hidden" name="secret_key" value="<?php echo $secret_key;?>">

</div></div>
    </form>

    </div>
<!--订单内容-->

</div>
<link rel="stylesheet" href="<?php echo R;?>js/dialog/ui-dialog.css" />
<script src="<?php echo R;?>js/dialog/dialog-plus.js"></script>
<script src="<?php echo R;?>js/wuzhicms.js"></script>
<script type="text/javascript">
    var usepoint = false;
    var maxpoint = <?php echo $memberinfo['points'];?>;
    var __total_price = <?php echo $total_price;?>;
    var coupon_card_price = 0;
    $("#check_use").bind("click", function(){
        var total_price = 0;
        total_price = __total_price;
        if(usepoint) {
            usepoint = false;
            $("#jifenid").addClass('jifenduihuan');
            total_price = __total_price-coupon_card_price;
        } else {
            usepoint = true;
            $("#jifenid").removeClass('jifenduihuan');
            total_price = total_price-<?php echo sprintf('%.2f',$memberinfo['points']/100);?>-coupon_card_price;
        }
        $("#total_price").html(total_price);
    });

    function count_price(aid) {
        if(aid) {
            $.post("index.php?m=order&f=json&v=get_coupon_card_price", { aid: aid,time:Math.random()},
                    function(data){
                        coupon_card_price = data;
                        //alert($("input[name='check_use']:checked").val());
                        //alert($("#check_use").attr('checked'));
                        if($("input[name='check_use']:checked").val()=='on') {
                            var point = $('#usepoint').val();
                            change_points(point);
                        } else {
                            $("#total_price").html(__total_price-coupon_card_price);
                        }
                    });
        } else {
            coupon_card_price = 0;
            if($("input[name='check_use']:checked").val()=='on') {
                var point = $('#usepoint').val();
                change_points(point);
            } else {
                $("#total_price").html(__total_price);
            }
        }

    }
    function change_points(point) {
        if(point<0) {
            alert('点数错误');
            return false;
        } else if(point>maxpoint) {
            alert('您没有这么多的积分');
            return false;
        }
        var total_price = 0;
        var point_price = point/100;
        total_price = __total_price-point_price-coupon_card_price;
        //total_price = parseInt(total_price);
        $("#total_price").html(total_price);
        $("#point_price").html(point_price);
    }
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
    function showall_address() {
        //$('.addr').css('display','');
        $('.addr').animate({opacity: 'show',height: '100%' }, 1000);
        $("#showallid").css('display','none');
        $('#new_address').css('display','');
    }
    function checkform() {
        var addressid = $("#addressid").val();
        if(addressid=='0') {
            var d = dialog({
                content: '需要您填写收货地址！'
            });
            d.show();
            setTimeout(function () {
                d.close().remove();
                gotourl('/index.php?m=order&f=address&v=listing&acbar=1&tab=tabs2&forward=1');
            }, 2000);

            return false;
        }
    }
    <?php if(empty($address_result)) { ?>
        showall_address();
        <?php } ?>
</script>

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>