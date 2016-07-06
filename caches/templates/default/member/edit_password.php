<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","head"); ?>
<body class="gray-bg">
<?php if($set_iframe==0) { ?>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","iframetop"); ?>
<?php } else { ?>
<div style="padding-top: 15px;"></div>
<?php } ?>
<div class="container-fluid  ie8-member">
    <div class="row row-40" >
        <?php if($set_iframe==0) { ?>
        <div class="col-sm-3 left-nav">             <!--左侧导航-->
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="nav-close"><i class="fa fa-times-circle"></i>
                </div>
                <div class="slimScrollDiv" style="position: relative; width: auto; height: 100%;">
                    <div class="sidebar-collapse" style="width: auto; height: 100%;">
                        <?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","left"); ?>
                    </div>
                </div>
            </nav>
            <!--end 左侧导航-->
        </div><!--col-sm-3--><?php } ?>

        <div class="<?php if($set_iframe==0) { ?>col-sm-9<?php } else { ?>col-sm-12<?php } ?>">

            <div class="row">
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>修改密码</h5>
                        </div>
                        <div class="ibox-content" style="min-height: 500px;">
                            <div class="row">
                                <form name="myform" action="" method="post" id="myform" onsubmit="return formsubmit();">
                                    <table class="table-dashed table-advance table-hover ">

                                        <tr>
                                            <th width="150" align="right">旧密码：</th>
                                            <td><input name="oldpassword" class="form-control" type="password" size="30" value="" class="input-text"/>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th align="right">新密码：</th>
                                            <td><input name="password" class="form-control" type="password" size="30" value="" class="input-text"/></td>
                                        </tr>
                                        <tr>
                                            <th align="right">新密码确认：</th>
                                            <td><input name="password2" class="form-control" type="password" size="30" value="" class="input-text"/></td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td colspan="2"><label>
                                                <input type="submit" name="submit" id="dosubmit" value="确 定"
                                                        class="btn btn-primary"/>
                                            </label></td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function formsubmit() {
        myform.submit();
    }
</script>

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","foot"); ?>