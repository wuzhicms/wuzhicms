<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body class="body">
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<section class="wrapper">
    <div class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <div class="panel-body">
            <form id="myform" name="myfrom" class="form-horizontal tasi-form" method="post" action="index.php?m=member&f=index&v=add<?php echo $this->su();?>">



                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">用户名</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" name="info[username]" class="form-control" placeholder="请输入用户名" datatype="/^[a-z0-9\u4E00-\u9FA5\uf900-\ufa2d\-]{2,20}$/i" errormsg="用户名为3-20位数字、字母、汉字和-组成" sucmsg="OK" ajaxurl="index.php?m=member&f=index&v=public_check_user"/>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">密码</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="password" name="info[password]" class="form-control" placeholder="请输入密码" />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">确认密码</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="password" name="info[pwdconfirm]" class="form-control" placeholder="请重复输入密码" recheck="info[password]" errormsg="您两次输入的账号密码不一致！" sucmsg="OK" />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">手机</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" name="info[mobile]" class="form-control" value="" datatype="m|*0-0" errormsg="请输入正确的手机号" sucmsg="OK" ajaxurl="index.php?m=member&f=index&v=public_check_mobile" />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">选择单位</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <?php
                            echo $form->tree_select($orgLists, $pid, 'name="info[org_id]" class="form-select"', '≡ 无上单位 ≡');
                        ?>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">用户模型</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <select name="modelids[]" class="form-select opheight" multiple="multiple">
                            <?php if($this->model)foreach($this->model as $k=>$t){?>
                                <option value="<?php echo $t['modelid']?>" <?php if($k==10) echo 'selected';?>><?php echo $t['name'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">会员组</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <select name="info[groupid]" class="form-select">
                            <?php if(is_array($group))foreach($group as $v){?>
                                <option value="<?php echo $v['groupid']?>" <?php echo $v['groupid'] == 3 ? 'selected' : ''?> ><?php echo $v['name']?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>


                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">头像</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <div class="upload-picture-card"><?php echo $form->attachment('','1','avatar',$avatar);?></div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">真实姓名</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" name="info[truename]" id="truename" size="" placeholder="" value="" class="form-control">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                    </div>
                </div>

        </div>

        </form>
    </div>
    </div>
</section>
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:1,
            callback:function(form){
                $("#submit").click();
            }

        });
    });
    function set_gp(gid,pid) {
        //$('#gid'+pid).addClass('trbg');
        var istrue = $('#box'+gid).is(':checked');
        if(istrue) {
            $('#gid'+gid).addClass('trbg');
        } else {
            $('#gid'+gid).removeClass('trbg');
        }
        set_parents(gid,istrue);
    }
    function set_parents(gid,istrue) {
        var hgid = $("#hgid"+gid).val();
        if(hgid!=0) {
            if(istrue) {
                $('#gid'+hgid).addClass('trbg');
                $('#box'+hgid).prop('checked','checked');
            } else {
                $('#gid'+hgid).removeClass('trbg');
                $('#box'+hgid).prop('checked','');
            }

            set_parents(hgid,istrue);
        } else {
            if(istrue) {
                $('#gid'+gid).addClass('trbg');
                $('#box'+gid).prop('checked','checked');
            } else {
                $('#gid'+gid).removeClass('trbg');
                $('#box'+gid).prop('checked','');
            }
        }

    }
</script>
<?php include $this->template('footer','core');?>
