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

                <div class="memberbordertop">
                    <section class="panel">
                        <header class="panel-heading"><span class="title">我的私信</span></header>
                    </section>
                    <ul id="myTab" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tabs1" id="1tab" role="tab" data-toggle="tab" aria-controls="tabs1" aria-expanded="true">发私信</a></li>
                    </ul>
                    <section class="panel">

                        <div class="panel-body" id="panel-bodys">
                            <form class="form-horizontal" role="form" name="myform" action="?m=message&f=message&v=add" method="post">
                                <table class="table table-striped table-advance table-hover text-center">
                                    <tbody>
                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-2 control-label text-right"><font color="red">*</font> 收件人：</label><div class="col-sm-8 text-left"><input type="text" class="form-control" placeholder="请输入收件人用户名" name="tousername" datatype="*" nullmsg="请输入收件人用户名" value="<?php echo $username;?>"></div></div></td>
                                    </tr>

                                    <tr>
                                        <td><div class="form-groupinfo"><label class="col-sm-2 control-label text-right">详细：</label><div class="col-sm-8 text-left"><textarea class="form-control textarea" rows="5" name="content"></textarea></div></div></td>
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

