<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<style>
    .overtbody:hover{border: 3px #b0b8bf solid;}
</style>
<section class="wrapper">
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
            <div class="panel mr0">
                <header><?php if(isset($GLOBALS['_menuid']))echo $this->menu($GLOBALS['_menuid']);?></header>
                <header class="panel-heading">
                    <form class="form-inline" role="form">
                        <input type="hidden" name="m" value="<?php echo M;?>" />
                        <input type="hidden" name="f" value="<?php echo F;?>" />
                        <input type="hidden" name="v" value="<?php echo V;?>" />
                        <input type="hidden" name="keytype" value="<?php echo $keytype;?>" />
                        <input type="hidden" name="_su" value="<?php echo _SU;?>" />
                        <input type="hidden" name="_menuid" value="<?php echo $GLOBALS['_menuid'];?>" />
                        <input type="hidden" name="search" />
                        <div class="input-group">
                            <select name="fieldtype" class="form-control">
                                <?php foreach($fieldtypes as $k=>$v){?>
                                    <option value="<?php echo $k;?>" <?php echo $fieldtype == $k ? 'selected' : ''?>><?php echo $v;?></option>
                                <?php }?>
                            </select>
                        </div>
                        <input type="text" name="keyValue" class="usernamekey form-control" value="<?php echo $keyValue?>"/>
                        <div class="input-group">
                            <select name="status" class="form-control">
                                <option value='' >全部状态</option>
                                <?php

                                foreach($this->status_arr as $key=>$value){?>
                                    <option value="<?php echo $key;?>" <?php echo $key == $status ? 'selected' : ''?>><?php echo $value;?></option>
                                <?php }?>
                            </select>
                        </div>
                        　　创建时间 <?php echo WUZHI_form::calendar('starttime', $starttime ? date('Y-m-d', $starttime) : '');?>- <?php echo WUZHI_form::calendar('endtime', $endtime ? date('Y-m-d', $endtime) : '');?>
                        <button type="submit" class="btn btn-info btn-sm">搜索</button>
                        <button type="submit" name="exp" class="btn btn-default btn-sm">导出Excel</button>
                    </form>
                </header>
            </div>

        <form name="myform" action="?m=pay&f=index&v=kf<?php echo $this->su();?>" method="post">
        <section class="panel">
            <div style="padding-left:25px;padding-top: 15px;">
                <ul id="myTab" class="nav nav-tabs" role="tablist">
                    <li <?php if($_k==$keytype) echo 'class="active"';?>><a href="?m=pay&f=index&v=listing<?php echo $this->su();?>">全部记录</a></li>
                    <?php
                    foreach($pay_config as $_k=>$_v) {?>
                        <li <?php if($_k==$keytype) echo 'class="active"';?>><a href="?m=pay&f=index&v=listing&keytype=<?php echo $_k.$this->su();?>"><?php echo $_v;?></a></li>
                    <?php }?>
                </ul>
            </div>
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance">
                    <thead>
                    <tr>
                        <th class="tablehead">选择</th>
                        <th class="tablehead">创建时间</th>
                        <th class="hidden-phone tablehead">名称</th>
                        <th class="tablehead">订单号</th>
                        <th class="tablehead">数量</th>
                        <th class="tablehead">所属客服</th>
                        <th class="tablehead">经销商</th>
                        <th class="tablehead">状态</th>
                        <th class="tablehead">详情</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>

                    <?php
                    foreach($result AS $r) {

                        ?>
                    <tbody class="overtbody">
                        <tr>
                            <td><input name="ids[]" type="checkbox" value="<?php echo $r['id'];?>"></td>
                            <td><?php echo time_format($r['addtime']);?></td>
                            <td><?php echo "<a href='?m=pay&f=index&v=view&id=".$r['id'].$this->su()."'>".safe_htm($r['payname'])."</a>";?></a></td>
                            <td ><?php echo $r['order_no'];?></td>
                            <td ><?php echo $r['quantity'];?></td>
                            <td colspan="4"> </td>
                            <td> <?php if($r['status']==6) {?>
                                    <a href="javascript:makedo('?m=pay&f=index&v=confirm_order&id=<?php echo $r['id'];?><?php echo $this->su();?>', '确认收款后，订单状态将变为：交易成功！')"
                                       class="btn btn-warning btn-xs">确认收款</a>
                               <?php }?>
                                <?php if(($r['keytype']==4 ||$r['keytype']==7) && $r['status']==1) {?>
                                <a href="javascript:makedo('?m=pay&f=index&v=refund&id=<?php echo $r['id'];?><?php echo $this->su();?>', '确认设置为已退款吗?')"
                                   class="btn btn-default btn-xs">退款</a><?php }?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><?php echo $r['username'];?></td>
                            <td style="font-weight: 700;"><?php if($r['plus_minus']==1) {
                                    echo "<font color='green'>+".$r['money']."</font>";
                                } elseif($r['plus_minus']==-1) {
                                    echo "<font color='#f37800'>-".$r['money']."</font>";
                                }
                                ?></td>

                            <td><?php if($r['payment']==2) {
                                    echo "<font color='#f37800'>" . $payments[$r['payment']] . "</font> ".$r['email'];
                                } elseif($r['payment']==9) {
                                        echo "<font color='red'>".$payments[$r['payment']]."</font>";
                                } else {
                                    echo $payments[$r['payment']];
                                }

                                ?></td>
                            <td ></td>
                            <td ><?php echo $r['kf_username'];?></td>
                            <td ><?php echo $r['jxs_username'];?></td>

                            <td><?php echo $status_arr[$r['status']];?></td>
                            <td><a href='?m=pay&f=index&v=view&id=<?php echo $r['id'].$this->su();?>'>详情</a></td>
                            <td>
<?php if($r['status']==6) {?>
                                <a href="javascript:edit(<?php echo $r['id'];?>);" class="btn btn-primary btn-xs">改价</a><?php }?>
                                <a href="javascript:makedo('?m=pay&f=index&v=delete&id=<?php echo $r['id'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                   class="btn btn-danger btn-xs">删除</a>

                            </td>
                        </tr>
                    </tbody>
                    <?php
                    }
                    ?>


                </table>
                <div class="panel-body">
                    <div class="row">
                        <?php
                        if($_SESSION['role']!=4) {
                        ?>
                        <div class="pull-left"> <div class="form-inline">分配订单给
                            <select name="kf_username" class="form-control">
                                <option value="">选择客服</option>
                                <?php
                                foreach($admin_result as $r) {
                                    $mr = $this->db->get_one('member', array('uid' => $r['uid']));
echo '<option value="'.$mr['username'].'">'.$mr['username'].'</option>';
                                }
                                ?>

                            </select><button type="submit" name="submit" class="btn btn-default btn-sm">确认</button></div>
                        </div>
                        <?php }?>
                            <div class="pull-right">
                                <ul class="pagination pagination-sm mr0">
                                    <?php echo $pages;?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>
        </form>

    </div>

</div>

<!-- page end-->
</section>
<script type="text/javascript">
    function edit(id){
        top.openiframe('index.php?m=pay&f=index&v=edit&id='+id+'<?php echo $this->su();?>', 'edit', '改价', 500, 240);
    }
    </script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>