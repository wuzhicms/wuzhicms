<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<link type="text/css" rel="stylesheet" href="<?php echo R;?>/html-page/css/erji-pindao.css">
<link rel="stylesheet" href="<?php echo R;?>js/dialog/ui-dialog.css" />
<script src="<?php echo R;?>js/dialog/dialog-plus.js"></script>
<!--路径导航-->
<div style="background: #f3f3f3">
    <div class="container">
        <ol class="breadcrumb" style="margin-bottom: 0px">
            您现在的位置：
            <li><a href="<?php echo WEBURL;?>">首页</a><span> &gt;</span> </li>
            <?php echo catpos($cid);?>
            <li class="active">正文</li>
        </ol>
    </div>
</div>


<div class="wzcms-tuangou">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-9  col-xs-12">

                <div class="wzcms-tuangou-list  hot-wzcms-content">
                    <h4 class="tuan-list-titleg "><?php echo $title;?></h4>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12">
                            <a href="#" class="thumbnail max-height-hide262">
                                <img src="<?php echo $thumb;?>" alt="<?php echo $title;?>">
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6  col-xs-12">
                            <div style="line-height: 2" class="jifen-mall-content"  >
                                <ul class="sm-page-goods-msg">
                                    <li class="sm-page-goods-msg-method" id="payType">
                                        <span class="sm-page-goods-msg-title">兑换方式：</span>
                                        <?php if($point) { ?>
                                        <a href="javascript:;" value="1" onfocus="this.blur();" onclick="changeNav_payType(0)" id="ct_type0" class="ct_type current">全积分<span>&nbsp;</span></a><?php } ?>
                                        <?php if($point_money) { ?>
                                        <a href="javascript:;" value="1,2" onfocus="this.blur();" class="ct_type" id="ct_type1" onclick="changeNav_payType(1)" >积分 + 现金<span>&nbsp;</span></a><?php } ?>
                                    </li>

                                    <li class="sm-page-goods-msg-price margin_bottom10" id="pay0" style="display: ;">
                                        <span class="sm-page-goods-msg-title pading_top_5px">价　　格：</span>
                                        <div><strong class=" color_success font_size18"><?php echo $point;?></strong> 分</div>
                                    </li>

                                    <li class="sm-page-goods-msg-price margin_bottom10" id="pay1" style="display: none;">
                                        <span class="sm-page-goods-msg-title pading_top_5px">价　　格：</span>
                                        <div><strong class=" color_success font_size18"><?php echo $point_money;?></strong> 分 <span class="font_size18 color_999">+</span> <strong class=" color_qiyecheng font_size18"><?php echo $price;?></strong> 元</div>
                                    </li>

                                    <li>
                                        <span class="sm-page-goods-msg-title">配送方式：</span>快递
                                    </li>
                                    <li>
                                        <span class="sm-page-goods-msg-title">剩余数量：</span><?php echo $surplus;?>件
                                    </li>
                                    <li>
                                        <span class="sm-page-goods-msg-title">兑换数量：</span>
                                        <div class="form-group">
                                            <div class="btn-group" role="group" aria-label="...">
                                                <button type="button" class="btn btn-default  btn-sm " onclick="ct_quantity(0)">-</button>
                                                <button type="button" class="btn btn-default btn-sm" id="quantity_num">1</button>
                                                <button type="button" class="btn btn-default  btn-sm" onclick="ct_quantity(1)">+</button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <br>
                                <input type="hidden" id="point_type" value="0">
                                <input type="hidden" id="quantity" value="1">
                                <a class="btn btn-warning" href="#" role="button" onclick="goods_ct(<?php echo $id;?>);">&nbsp;&nbsp;&nbsp;&nbsp;立即兑换&nbsp;&nbsp;&nbsp;&nbsp; </a>

                            </div>

                        </div>

                        <div class="col-xs-12 content-bfb-img">
                            <hr>
                            <h3>详细介绍 </h3>
                            <hr>
                            <p>
                                <?php echo $content;?>
                            </p>

                        </div>
                    </div>
                </div>
            </div>

            <div class=" col-lg-3 col-md-3 col-sm-3 col-xs-12">

                <div class="tuangou-right-box">
                    <h3><a href=""  title="查看更多往期团购">最新商品</a></h3>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'id DESC,sort DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'4','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>

                    <a href="<?php echo $r['url'];?>"  class="thumbnail">
                        <img src="<?php echo imagecut($r['thumb'],239,159,4);?>"  alt="...">
                        <p class=" margin_top10 manhangyichu text-center"><?php echo $r['title'];?></p>
                    </a>

                    <?php $n++;}?>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function changeNav_payType(type) {
        if(type==0) {
            $("#ct_type1").removeClass('current');
            $("#ct_type0").addClass('current');
            $("#pay1").css('display','none');
            $("#pay0").css('display','');
        } else {
            $("#ct_type0").removeClass('current');
            $("#ct_type1").addClass('current');
            $("#pay0").css('display','none');
            $("#pay1").css('display','');
        }
        $("#point_type").val(type);
    }
    var quantity_num = 1;
    function ct_quantity(type) {
        if(type==0) {
            quantity_num--;
            if(quantity_num<1) quantity_num=1;
        } else {
            if(quantity_num>=<?php echo $surplus;?>) {

            } else {
                quantity_num++;
            }
        }
        $("#quantity_num").html(quantity_num);
    }
    function goods_ct(id) {
        if(_uid==null) {
            $.get("/index.php?m=member&f=checklogin&v=check", { time: Math.random() },
                    function(data){
                        if(data=='0') {
                            login_form('/index.php?m=member&v=public_mini_login','login','会员登录',600,350);
                            return false;
                        } else {
                            goto_goods_ct(id);
                        }
                    });
        } else {
            goto_goods_ct(id);
        }
    }
    function goto_goods_ct() {
        var point_type = $("#point_type").val();
        gotourl('<?php echo WEBURL;?>index.php?m=order&id=<?php echo $id;?>&cid=<?php echo $cid;?>&type='+point_type+'&quantity='+quantity_num);
    }
</script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>