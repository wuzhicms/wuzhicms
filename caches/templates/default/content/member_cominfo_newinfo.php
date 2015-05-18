<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>
<link href="http://www.h1jk.cn/res/css/validform.css" rel="stylesheet" />
<script src="http://www.h1jk.cn/res/js/validform.min.js"></script>
<script src="http://www.h1jk.cn/res/js/wuzhicms.js"></script>
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

                <ul id="myTab" class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tabs1" id="1tab" role="tab" data-toggle="tab" aria-controls="tabs1" aria-expanded="true">需求信息发布</a></li>
                    <li role="presentation" class=""><a href="?m=content&f=cominfo&v=listing">我发布的信息</a></li>
                    <li class="tip-a" style="float:right;">温馨提示：我们的客服会在24小时内审核。全国免费咨询电话：400-001-0278</li>
                </ul>
                <div class="memberbordertop">
                    <section class="panel">
                        <div class="panel-body" id="panel-bodys">
                            <form class="form-horizontal" role="form" name="myform" action="" method="post">
                                <table class="table table-striped table-advance table-hover text-center">
                                    <tbody>

                                    <tr><td class="tablehead left"><h5>发布人信息</h5></td></tr>
                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">我们可以称呼您：</label><div class="col-sm-7 text-left"><label class="radio-inline"><input type="radio" name="form[sex]" id="inlineRadio1" value="1" <?php if($memberinfo['sex']) { ?>checked<?php } ?>> 先生</label>
                                            <label class="radio-inline"><input type="radio" name="form[sex]" id="inlineRadio2" value="0" <?php if(!$memberinfo['sex']) { ?>checked<?php } ?>> 女士</label></div></div></td>
                                    </tr>

                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right"><font color="red">*</font> 联系人：</label><div class="col-sm-3 text-left"><input type="text" class="form-control" placeholder="请输入您的姓名" name="form[truename]" id="truename" value="<?php echo $memberinfo['truename'];?>" datatype="*2-10"  nullmsg="请输入您的姓名" errormsg="请输入正确的姓名"></div></div></td>
                                    </tr>

                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right"><font color="red">*</font> 联系电话：</label><div class="col-sm-3 text-left"><input type="text" class="form-control" placeholder="请输入您的联系电话" datatype="*8-18" nullmsg="请输入您的联系电话" errormsg="请输入正确的电话号码" name="form[tel]" id="tel" value="<?php echo $memberinfo['mobile'];?>"></div></div></td>
                                    </tr>

                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right"><font color="red">*</font> 邮件地址：</label><div class="col-sm-3 text-left"><input type="text" class="form-control" placeholder="请输入您的邮件地址" datatype="e" nullmsg="请输入您的邮件地址" name="form[email]" id="email" value="<?php echo $memberinfo['email'];?>"></div></div></td>
                                    </tr>

                                    <tr><td class="tablehead"><h5>团检信息</h5></td></tr>

                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right"><font color="red">*</font> 所在地区：</label><?php echo linkage(3,'myfieldid3',0,'datatype="*"  nullmsg="请选择所在地区"');?></div></td>
                                    </tr>

                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right"><font color="red">*</font> 单位名称：</label><div class="col-sm-3 text-left"><input type="text" class="form-control" placeholder="请输入单位名称" datatype="*5-40" nullmsg="请输入单位名称"  name="form[companyname]" id="companyname"></div></div></td>
                                    </tr>

                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">企业性质：</label><div class="col-sm-3 text-left">
                                            <select name="form[qytype]" class="form-control" style="width:auto;" id="qytype"><option value="0" selected="">请选择企业类型</option><option value="1" >国有企业</option><option value="2">集体所有制企业</option><option value="3">联营企业</option><option value="4">三资企业</option><option value="5">私营企业</option><option value="6">其他企业</option></select></div></div></td>
                                    </tr>
                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right"><font color="red">*</font> 意向体检中心：</label><div class="col-sm-3 text-left">
                                            <select name="form[yixiang]" class="form-control input-sm" datatype="*" nullmsg="请选择意向体检中心">
                                                <option value="">请选择意向体检中心</option>
                                                <?php $n=1; if(is_array($categorys)) foreach($categorys AS $cid => $cate) { ?>
                                                <?php if($cate['modelid']==2) { ?>
                                                <option value="<?php echo $cid;?>"><?php echo $cate['name'];?></option><?php } ?>
                                                <?php $n++;}?>
                                            </select>
                                        </div></div></td>
                                    </tr>
                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">体检预算（每人）：</label><div class="col-sm-3 text-left"><input type="text" class="form-control" placeholder="如：2000元" name="form[yusuan]"></div></div></td>
                                    </tr>
                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right"><font color="red">*</font> 体检人数：</label><div class="col-sm-3 text-left"><input type="text" class="form-control" placeholder="请输入体检人数" name="form[renshu]" datatype="n" nullmsg="请输入体检人数"></div></div></td>
                                    </tr>

                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right"><font color="red">*</font> 体检时间：</label><div class="col-sm-3 text-left"><input type="text" class="form-control" placeholder="如：请输入体检时间" name="form[tjtime]" datatype="*" nullmsg="请输入体检时间"></div></div></td>
                                    </tr>

                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">其他需求：</label><div class="col-sm-7 text-left"><textarea class="form-control textarea" rows="5" name="form[content]"></textarea></div></div></td>
                                    </tr>


                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right"> </label><div class="col-sm-3 text-left"><input type="submit" name="submit" id="submit" value="提交" class="btn btn-order"></div></div></td>
                                    </tr>

                                    </tbody>
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
<!--正文部分-->
<script type="text/javascript">
    $("#submit").click(function(){
        t=setTimeout("hide_formtips()",2000);
    });
    function hide_formtips() {
        $.Hidemsg();
        clearInterval(t);
    }
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:1
        });
    })
    </script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>

