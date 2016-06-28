<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>

                <div class="panel-body">
                    <form class="form-horizontal tasi-form" method="post" action="" onsubmit="return check_mform();">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-2 control-label">转发内容</label>
                            <div class="col-lg-10 col-sm-10 col-xs-10 input-group">
                                <table class="table table-striped table-advance table-hover">
                                    <thead>
                                    <tr>
                                        <th class="hidden-phone tablehead">ID</th>
                                        <th class="tablehead">姓名</th>
                                        <th class="tablehead">电话</th>
                                        <th class="tablehead">品牌</th>
                                        <th class="tablehead">车系</th>
                                        <th class="tablehead">车型</th>
                                        <th class="tablehead">提交时间</th>
                                        <th class="tablehead">提交人</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td><?php echo $r['id'];?></td>
                                            <td><?php echo $r['linkman'];?></td>
                                            <td><?php echo $r['telephone'];?></td>
                                            <td><?php echo $r['data1'];?></td>
                                            <td><?php echo $r['data2'];?></td>
                                            <td><?php echo $r['data3'];?></td>
                                            <td><?php echo date('Y-m-d H:i:s',$r['addtime']);?></td>
                                            <td><?php echo $r['username'];?></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">收件人</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="hidden" class="form-control" name="to_uid" id="uid" value="<?php echo $data['to_uid'];?>">
                                <input type="hidden" class="form-control" name="to_username" id="to_username" value="<?php echo $data['to_username'];?>">
                                <input type="text" class="form-control" name="username" id="username" value="<?php echo $data['to_username'];?>" placeholder="下面选择收件人" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label"></label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="hidden" name="forward" value="<?php echo $forward;?>">
                                <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="发送">
                            </div>
                        </div>
                    </form>

                    <header>                    <header class="panel-heading"><a href="" class="btn btn-info btn-sm" id="index-listing"><i class="icon-gears2 btn-icon"></i>会员搜索</a></header>		</header>
                    <header class="panel-heading">
                        <form class="form-inline" role="form" action="" method="post">
                            <div class="input-group">
                                <select name="keyType" class="form-control">
                                    <option value="username" <?php if($keyType=='username') echo 'selected';?>>用户名</option>
                                    <option value="uid" <?php if($keyType=='uid') echo 'selected';?>>UID</option>
                                    <option value="mobile" <?php if($keyType=='mobile') echo 'selected';?>>手机</option>
                                </select>
                            </div>
                            <input type="text" name="keyValue" class="usernamekey" value="<?php echo $keyValue;?>">
<button type="submit" name="search" class="btn btn-info">搜索</button>
                        </form>
                    </header>

                    <table class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>
                            <th class="tablehead">选择</th>
                            <th class="tablehead">UID</th>
                            <th class="tablehead">用户名</th>
                            <th class="tablehead">电话</th>
                            <th class="tablehead">Email</th>
                            <th class="tablehead">状态</th>
                            <th class="tablehead">余额</th>
                            <th class="tablehead">积分</th>
                            <th class="tablehead">注册时间</th>
                            <th class="tablehead">登录时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(is_array($result))foreach($result as $r) {?>
                            <tr id="u_<?php echo $r['uid'];?>">
                                <td><label><input type="radio" name="uid[]" value="<?php echo $r['uid'];?>" onclick="set_username(<?php echo $r['uid'];?>,'<?php echo $r['username'];?>');"></label></td>
                                <td><?php echo $r['uid'];?></td>
                                <td><?php echo $r['username']; ?></td>
                                <td><?php echo $r['mobile']; ?></td>
                                <td><?php echo $r['email'];?></td>

                                <td>
                                    <?php
                                    if($r['checkmec']==0) {
                                        echo " <img src='/res/images/icon/check.png' height='16'>";
                                    } elseif($r['checkmec']==2) {
                                        echo " <img src='/res/images/icon/pass.jpg' height='20'>";
                                    } elseif($r['checkmec']==1) {
                                        echo " <img src='/res/images/icon/nopass.jpg' height='20'>";
                                    }
                                    ?>
                                </td>
                                <td><?php echo $r['money'];?></td>
                                <td><?php echo $r['points'];?></td>
                                <td><?php echo date('Y-m-d H:i', $r['regtime']);?></td>
                                <td><?php if($r['lasttime']) echo date('Y-m-d H:i', $r['lasttime']);?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3
        });
    })
function set_username(uid,username) {
    $("#uid").val(uid);
    $("#username").val(username);
    $("#to_username").val(username);
}
    function check_mform() {
        if($("#uid").val()=='') {
            alert('请选择收件人');
            return false;
        }
    }
</script>

