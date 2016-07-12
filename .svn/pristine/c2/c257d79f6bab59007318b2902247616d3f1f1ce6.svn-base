<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>
<script src="<?php echo R;?>member/js/bootstrap-wizard.min.js"></script>
<script src="<?php echo R;?>member/js/wizard.js"></script>
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
                        <header class="panel-heading"><span class="title">在线预约</span></header>
                        <div class="panel-body">
                            <div class="contentpanel contentpanel-wizard">

                                <div class="row">

                                    <div class="col-md-12">
                                        <!-- PROGRESS WIZARD -->
                                        <form name="mypost" method="post" id="progressWizard" class="panel-wizard form-horizontal" onsubmit="return check_orderform();">
                                            <input type="hidden" name="v" value="save">
                                            <ul class="nav nav-justified nav-wizard">
                                                <li><a href="#tab2-2" id="tabs2" data-toggle="tab"><strong>1:</strong> 选择体检套餐</a></li>
                                                <li><a href="#tab1-2" id="tabs1" data-toggle="tab"><strong>2:</strong> 填写体检人信息</a></li>
                                                <li><a href="#tab3-2" id="tabs3" data-toggle="tab"><strong>3:</strong> 选择体检机构</a></li>
                                                <li><a href="#tab4-2" id="tabs4" data-toggle="tab"><strong>4:</strong> 选择体检时间</a></li>
                                            </ul>

                                            <div class="progress progress-xs">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                            <div class="tab-content">

                                                <div class="tab-pane" id="tab1-2">
                                                    <table class="table table-striped table-advance table-hover text-center">
                                                        <tbody>

                                                        <tr>
                                                            <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">姓名：</label><div class="col-sm-3 text-left"><input type="text" class="form-control" placeholder="请输入您的姓名" name="mform[truename]" id="truename" value="<?php echo $memberinfo['truename'];?>"></div></div></td>
                                                        </tr>


                                                        <tr>
                                                            <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">性别：</label><div class="col-sm-7 text-left"><label class="radio-inline"><input type="radio" name="mform[sex]" id="inlineRadio1" value="1" <?php if($memberinfo['sex']) { ?>checked<?php } ?>> 男</label>
                                                                <label class="radio-inline"><input type="radio" name="mform[sex]" id="inlineRadio2" value="0" <?php if(!$memberinfo['sex']) { ?>checked<?php } ?>> 女</label></div></div></td>
                                                        </tr>

                                                        <tr>
                                                            <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">婚姻：</label><div class="col-sm-7 text-left"><label class="radio-inline"><input type="radio" name="mform[marriage]" id="inlineRadio3" value="1" <?php if($memberinfo['marriage']) { ?>checked<?php } ?>> 已婚</label>
                                                                <label class="radio-inline"><input type="radio" name="mform[marriage]" id="inlineRadio4" value="0" <?php if(!$memberinfo['marriage']) { ?>checked<?php } ?>> 未婚</label></div></div></td>
                                                        </tr>

                                                        <tr>
                                                            <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">生日：</label><div class="col-sm-2">
                                                                <select class="form-control" name="birthday_year">
                                                                    <?php echo $birthday_year;?>
                                                                </select></div> <div class="col-sm-2">
                                                                <select class="form-control" name="birthday_month">
                                                                    <?php echo $birthday_month;?>
                                                                </select>
                                                            </div> <div class="col-sm-2">
                                                                <select class="form-control" name="birthday_day">
                                                                    <?php echo $birthday_day;?>
                                                                </select>
                                                            </div></div></td>
                                                        </tr>


                                                        <tr>
                                                            <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">身份证号码：</label><div class="col-sm-3 text-left"><input type="text" class="form-control" placeholder="请输入您证件号码" name="mform[identity_card]" id="identity_card" value="<?php echo $memberinfo['identity_card'];?>"></div></div></td>
                                                        </tr>

                                                        <tr>
                                                            <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">手机：</label><div class="col-sm-3 text-left"><input type="text" class="form-control" placeholder="请输入您的手机号码" name="mform[mobile]" id="mobile" value="<?php echo $memberinfo['mobile'];?>"></div></div></td>
                                                        </tr>

                                                        <tr>
                                                            <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">邮件地址：</label><div class="col-sm-3 text-left"><input type="text" class="form-control" placeholder="如：请输入邮件地址" name="mform[email]" id="email" value="<?php echo $memberinfo['email'];?>"></div></div></td>
                                                        </tr>

                                                        <tr>
                                                            <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">地址：</label><div class="col-sm-3 text-left"><input type="text" class="form-control" placeholder="如：请输入您现居的详细地址" name="mform[address]" value="<?php echo $memberinfo['address'];?>"></div></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">居住城市：</label><div class="col-sm-3 text-left"><input type="text" class="form-control" placeholder="如：北京" name="mform[livecity]" value="<?php echo $memberinfo['livecity'];?>"></div></div></td>
                                                        </tr>

                                                        </tbody>
                                                    </table>

                                                </div><!-- tab-pane -->

                                                <div class="tab-pane" id="tab2-2">
                                                    <table class="table table-striped table-advance table-hover text-center">
                                                        <tbody>
                                                        <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                                                        <tr>
                                                            <td>
                                                                <input type="radio" name="setcardid" value="<?php echo $r['cardid'];?>" onclick="setcartid(this.value);"> <?php echo $r['title'];?> <a href="<?php echo $r['url'];?>" target="_blank">[查看该套餐详情]</a>
                                                                </td>
                                                        </tr>
                                                        <?php $n++;}?>

                                                        </tbody>
                                                    </table>
                                                </div><!-- tab-pane -->
                                                <input name="cardid" id="cardid" type="hidden" value="0">
                                                <input name="mecid" id="mecid" type="hidden" value="0">

                                                <div class="tab-pane" id="tab3-2">
                                                    <table class="table table-striped table-advance">
                                                        <tbody>

                                                        <tr>
                                                            <td><div class="form-groupinfo"><label class="col-sm-3 control-label text-right">所在城市：</label><div class="col-sm-2">
                                                                <?php $hotcity = hotcity(0);?>
                                                                <select name="lcity" class="form-control" onchange="getmeclist(this)">
                                                                    <option value="0">请选择</option>
                                                                    <?php $n=1;if(is_array($hotcity)) foreach($hotcity AS $r) { ?>
                                                                    <option value="<?php echo $r['cid'];?>"><?php echo $r['name'];?></option>
                                                                    <?php $n++;}?>
                                                                </select>
                                                            </div></div></td>
                                                        </tr>
                                                        </tbody>
                                                        <tbody id="wzlist">
                                                        </tbody>
                                                    </table>
                                                </div><!-- tab-pane -->

                                                <div class="tab-pane" id="tab4-2">
                                                    <div id="dateshow">
                                                        <?php
                $dateComponents = getdate();
$month = $dateComponents['mon'];
$year = $dateComponents['year'];
echo build_calendar($month,$year,$dateArray);
?></div>
                                                </div><!-- tab-pane -->

                                            </div><!-- tab-content -->

                                            <ul class="list-unstyled wizard">
                                                <li class="pull-left previous"><button type="button" class="btn btn-default">上一步</button></li>
                                                <li class="pull-right next"><button type="button" class="btn btn-primary">下一步</button></li>
                                                <input type="hidden" name="tjtime" id="tjtime" value="0">
                                                <input type="hidden" name="v"  value="save">
                                                <li class="pull-right finish hide"><button type="submit" name="submit" class="btn btn-primary">提交预约</button></li>
                                            </ul>

                                            <!-- Modal -->
                                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">在线预约</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-success text-center" role="alert">
                                                                <i class="glyphicon glyphicon-ok-sign"></i><h4>您的预约信息已成功提交!预约单号<strong>（110120119）</strong></h4><br>您可以：<a href="#">查看我的预约单</a><br><br>
                                                                <small>您预约的体检地点：北京市海淀区中关村某某某医院，您预约的体检时间：2036-10-16 <a href="#">查看服务单</a></small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </form><!-- panel-wizard -->

                                    </div><!-- col-md-12 -->

                                </div><!-- row -->



                            </div><!-- contentpanel -->
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
    function getmeclist(obj) {
        if($("#cardid").val()=='0'){
            alert('请选择体检套餐');
            $("#tabs2").click();
            obj.value = 0;
            return false;
        }
        var cardid = $("#cardid").val();
        var cityid = obj.value;
        $.getJSON("index.php?m=content&f=json&v=getmec&cardid="+cardid+"&cid="+cityid+"&pagesize=20&page=1", function(data) {
            if(data=='finish') {
                $("#wzlist").html('');
            } else {
                var wzlist = '';
                $.each(data, function(i,item){
                    wzlist +='<tr><td><div class="form-groupinfo"><label class="col-sm-2 control-label text-right"></label><div class="col-sm-10 text-left"><label><input type="radio" onclick="setmecid(this.value);" name="mecids" value="'+item.id+'"> '+item.title+'</label> <small><span class="nums">'+item.catname+''+item.address+'</span></small><a href="'+item.url+'">[ 查看该分院详情 ]</a></label></div></div></td></tr>';
                });
                $("#wzlist").html(wzlist);
            }
        });
    }
    function setmecid(id) {
        $("#mecid").val(id);
    }
    function setdate(y,m,d,obj) {
        $('.calendar td').removeClass('currentdate');
        $(obj).parent().addClass('currentdate');
        $("#tjtime").val(y+'-'+m+'-'+d);
    }
    function setmonth(d) {
        $("#dateshow").load("index.php?m=order&f=json&v=setmonth&d="+d);
        $("#tjtime").val('0');
    }
    var errno = 0;

    function check_orderform() {

        if($("#cardid").val()=='0'){
            alert('请选择体检套餐');
            $("#tabs2").click();
            return false;
        }
        if($("#truename").val()==''){
            alert($("#truename").attr('placeholder'));
            $("#tabs1").click();
            $("#truename").focus();
            return false;
        }

        if($("#inlineRadio1").attr('checked')!='checked' && $("#inlineRadio2").attr('checked')!='checked'){
            alert('请选择体检人的性别');
            $("#tabs1").click();
            $("#inlineRadio1").focus();
            return false;
        }
        if($("#identity_card").val()==''){
            alert($("#identity_card").attr('placeholder'));
            $("#tabs1").click();
            $("#identity_card").focus();
            return false;
        } else {
            var identity_card = $("#identity_card").val();
            if(IdCardValidate(identity_card)==false) {
                alert('身份证号码错误！');
                $("#tabs1").click();
                $("#identity_card").focus();
                errno = errno+1;
                return false;
            }
        }

        if($("#mobile").val()==''){
            alert($("#mobile").attr('placeholder'));
            $("#tabs1").click();
            $("#mobile").focus();
            return false;
        } else if (!$("#mobile").val().match(/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0-9]|170)\d{8}$/)) {
            if(errno==1) {
                alert("请认证填写每一项，o(>﹏<)o千万别再开玩笑了！请输入正确的手机号码！");
            } else {
                alert("请输入正确的手机号码！");
            }
            $("#tabs1").click();
            $("#mobile").focus();
            errno = errno+1;
            return false;
        }
        if($("#email").val()==''){
            alert($("#email").attr('placeholder'));
            if(errno==1) {
                alert("请认证填写每一项，o(>﹏<)o千万别再开玩笑了！请输入正确的邮箱！");
            } else if(errno>1) {
                alert("连续多次想忽悠我，你真厉害！");
                window.location.reload();
            } else {
                alert("请输入正确的邮箱！");
            }
            $("#tabs1").click();
            $("#email").focus();
            return false;
        } else {
            var reg = /^([a-zA-Z0-9_-\.])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
            if (!reg.test($("#email").val())) {
                alert('邮箱格式不正确，请重新填写!');
                $("#tabs1").click();
                $("#email").focus();
                return false;
            }
        }

        if($("#mecid").val()=='0'){
            alert('请选择体检机构');
            $("#tabs3").click();
            return false;
        }
        if($("#tjtime").val()=='0'){
            alert('请选择体检时间');
            $("#tabs4").click();
            return false;
        }

        orderform.submit();
    }
    function setcartid(cardid) {
        $("#cardid").val(cardid);
    }
</script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>
