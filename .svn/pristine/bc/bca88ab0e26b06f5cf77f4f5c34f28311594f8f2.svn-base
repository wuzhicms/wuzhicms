<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<style type="text/css">
    .tablewarnings{display: none;}
    .red_color{color: #fe461c;}
</style>
<section class="wrapper">

<div class="col-lg-12">
<section class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>
<div class="panel-body" id="panel-bodys">
    <table class="table table-striped table-advance table-hover">
        <thead>
        <tr>
            <th class="tablehead">物品名称</th>
            <th class="tablehead">缩略图</th>
            <th class="tablehead">链接地址</th>
            <th class="tablehead">ip</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($result AS $rs) {
            ?>
            <tr>
                <td><?php echo $rs['title'];?></td>
                <td><?php if($rs['thumb']) echo "<img src='".$rs['thumb']."' style='max-width:120px;max-height:120px;'>";?></td>
                <td><a href="<?php echo $rs['url'];?>" target="_blank">打开</a></td>
                <td><?php echo $rs['ip'];?></td>
            </tr>
            <?php
        }
        ?>

        </tbody>
    </table>
    <table class="table table-striped table-advance table-hover">
        <thead>
        <tr>
            <th class="hidden-phone tablehead">记录详情</th>
        </tr>
        </thead>
    </table>

<form name="myform" class="form-horizontal tasi-form" action="" method="post">
<table class="table table-striped table-advance table-hover" id="contenttable">
<tbody>

<tr>
    <td>
        <strong>名称</strong>
    </td>
    <td class="hidden-phone">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-10 input-group">
                    <?php echo $r['payname'];?>
                </div>

            </div>
    </td>
</tr>
<tr>
    <td>
        <strong>订单号</strong>
    </td>
    <td class="hidden-phone">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-10 input-group">
                    <?php echo $r['order_no'];?>
                </div>

            </div>
    </td>
</tr>
<tr>
    <td>
        <strong>类型</strong>
    </td>
    <td class="hidden-phone">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-10 input-group">
                    【<?php echo $pay_config[$r['keytype']];?>】
                </div>

            </div>
    </td>
</tr>
<tr>
    <td>
        <strong>对方信息</strong>
    </td>
    <td class="hidden-phone">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-10 input-group">
                    <?php echo $r['username'];?> <?php echo $r['linkman'].' （'.$r['telephone'].'） '.$mr['email'];?>
                </div>

            </div>
    </td>
</tr>
<tr>
    <td>
        <strong>对方备注</strong>
    </td>
    <td class="hidden-phone">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-10 input-group <?php if($r['remark']) echo 'red_color';?>">
                    <?php echo $r['remark'];?>
                </div>

            </div>
    </td>
</tr>
<tr>
    <td>
        <strong>支付方式</strong>
    </td>
    <td class="hidden-phone">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-10 input-group">
                    <?php echo $payments[$r['payment']];?>
                </div>

            </div>
    </td>
</tr>
<tr>
    <td>
        <strong>金额</strong>
    </td>
    <td class="hidden-phone">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-10 input-group">
                    <?php if($r['plus_minus']==1) {
                        echo "<font color='green'>+".$r['money']."</font>";
                    } elseif($r['plus_minus']==-1) {
                        echo "<font color='#f37800'>-".$r['money']."</font>";
                    }
                    ?>
                </div>

            </div>
    </td>
</tr>
<tr>
    <td>
        <strong>支付状态</strong>
    </td>
    <td class="hidden-phone">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-10 input-group">
                <span class="label btn-info label-mini"><?php echo $status_arr[$r['status']];?></span>
                </div>

            </div>
    </td>
</tr>

<tr>
    <td>
        <strong>购买时间</strong>
    </td>
    <td class="hidden-phone">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-10 input-group">
                    <?php echo date('Y-m-d H:i:s',$r['addtime']);?>
                </div>

            </div>
    </td>
</tr>
<tr>
    <td>
        <strong>付款时间</strong>
    </td>
    <td class="hidden-phone">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-10 input-group">
                    <?php echo date('Y-m-d H:i:s',$r['paytime']);?>
                </div>

            </div>
    </td>
</tr>
<tr>
    <td>
        <strong>交易结束时间</strong>
    </td>
    <td class="hidden-phone">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-10 input-group">
                    <?php echo date('Y-m-d H:i:s',$r['endtime']);?>
                </div>

            </div>
    </td>
</tr>
<?php
if($r['adminuid']) {
    $ar = $this->db->get_one('member', array('uid' => $r['adminuid']));
?>
<tr style="background-color: #F5E8E8">
    <td>
        <strong>确认收款的操作员名称</strong>
    </td>
    <td class="hidden-phone">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-10 input-group">
                    <?php
                    echo $ar['username'];?>
                </div>

            </div>
    </td>
</tr>
<?php }?>
<tr>
    <td>
        <strong>备注（仅后台用户可见）</strong>
    </td>
    <td class="hidden-phone">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-10 input-group">
                    <textarea name="note" class="form-control" cols="60" rows="3"><?php echo $r['note'];?></textarea>
                </div>

            </div>
    </td>
</tr>

<tr>
    <td>


    </td>
    <td>
        <input type="hidden" name="forward" value="<?php echo HTTP_REFERER;?>">
        <input type="hidden" name="v" value="edit_note">
        <input name="submit" type="submit" class="save-bt btn btn-sm btn-info" value=" 提 交 "> &nbsp;&nbsp;&nbsp;
        <a href="?m=pay&f=index&v=relay&id=<?php echo $r['id'].'&forward='.urlencode(HTTP_REFERER).$this->su();?>" class="btn btn-primary">转发</a>
    </td>
</tr>
</tbody>
</table>
</form>
</div>
</section>
</div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>