<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>
<script src="<?php echo R;?>js/wuzhicms.js"></script>
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
                        <header class="panel-heading"><span class="title">收货地址管理</span></header>

                        <ul id="myTab" class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tabs1" id="1tab" role="tab" data-toggle="tab" aria-controls="tabs1" aria-expanded="true">全部</a></li>
                            <li role="presentation" class=""><a href="#tabs2" role="tab" id="2tab" data-toggle="tab" aria-controls="tabs2" aria-expanded="false">新增地址</a></li>
                            </li>
                        </ul>

                        <div id="myTabContent" class="tab-content tabsbordertop">

                            <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">
                                <div class="panel-body" id="panel-bodys">
                                    <table class="table table-striped table-advance table-hover text-center">
                                        <thead>
                                        <tr>
                                            <th class="tablehead">收件人</th>
                                            <th class="tablehead">地址</th>
                                            <th class="tablehead">电话</th>
                                            <th class="tablehead">默认？</th>
                                            <th class="tablehead">管理操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                                        <tr>
                                            <td class="orderlist"><?php echo $r['addressee'];?></td>
                                            <td class="orderlist"><?php echo $r['province'];?> <?php echo $r['city'];?> <?php echo $r['address'];?></td>
                                            <td class="orderlist"><?php echo $r['mobile'];?></td>
                                            <td class="orderlist"><?php if($r['isdefault']) { ?>
                                                <i class="paymenticon"></i>默认地址<?php } else { ?>
                                                <a href="index.php?m=order&f=address&v=setdefault&addressid=<?php echo $r['addressid'];?>&acbar=3">设为默认</a>
                                                <?php } ?></td>
                                            <td class="orderlist"><a href="index.php?m=order&f=address&v=delete&addressid=<?php echo $r['addressid'];?>&acbar=3">删除</a></td>
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

                                <form name="myform" action="index.php?m=order&f=address&v=add" method="post" id="myform">
                                    <table class="table table-striped table-advance table-hover">
                                        <tr>
                                            <td colspan="2" style="line-height:32px;"><span class="color_777"> 电话号码、手机选项一项其余为必填项</span></td>
                                        </tr>
                                        <tr>
                                            <td width="120" align="right">所在地区<span class="color_warning">*</span></td>
                                            <td width="675"><?php echo linkage(1,'myfieldid1',0);?></td>
                                        </tr>
                                        <tr>
                                            <td align="right">详细地址<span class="color_warning">*</span></td>
                                            <td><textarea name="address" cols="60" rows="3" class="form-control" placeholder="不需要重复填写省市区，必须大于5个字符，小于120个字符"></textarea></td>
                                        </tr>
                                        <tr>
                                            <td align="right">邮政编码<em class="color_warning">*</em></td>
                                            <td>
                                                <input type="text" name="zipcode" id="zipcode" size="36"></td>
                                        </tr>
                                        <tr>
                                            <td align="right">收货人姓名<em class="color_warning">*</em></td>
                                            <td><input type="text" name="addressee" id="addressee" size="36" placeholder="长度不超过20个字符"></td>
                                        </tr>
                                        <tr>
                                            <td align="right">手机号码</td>
                                            <td><input type="text" name="mobile" id="mobile" size="36" placeholder="电话号码、手机号码必须填一项"></td>
                                        </tr>
                                        <tr>
                                            <td align="right">电话号码</td>
                                            <td><input name="tel1" type="text" id="tel1" size="6" placeholder="区号">
                                                -
                                                <input name="tel2" type="text" id="tel2" size="22" placeholder="电话号码">
                                                -
                                                <input name="tel3" type="text" id="tel3" size="6" placeholder="分机号"></td>
                                        </tr>
                                        <tr>
                                            <td align="right">&nbsp;</td>
                                            <td><input type="checkbox" name="isdefault" id="isdefault" value="1">
                                                <label>设为默认收货地址</label></td>
                                        </tr>
                                        <tr>
                                            <td align="right">&nbsp;</td>
                                            <td>
                                                <input type="hidden" name="forward" value="<?php echo $forward;?>">
                                                <input type="submit" name="submit" class="addbtn" id="button" value="保存"></td>
                                        </tr>
                                    </table>
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
<script>
    <?php if(isset($GLOBALS['tab'])) { ?>
    $("#2tab").click();
        <?php } ?>
</script>
<!--正文部分-->
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>
