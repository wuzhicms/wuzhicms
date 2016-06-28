<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<section class="wrapper">
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <?php echo $this->menu($GLOBALS['_menuid']);?>
            <div class="panel mr0">
                <header><?php if(isset($GLOBALS['_menuid']))echo $this->menu($GLOBALS['_menuid']);?></header>
                <header class="panel-heading">
                    <form class="form-inline" role="form">
                        <input type="hidden" name="m" value="<?php echo M;?>" />
                        <input type="hidden" name="f" value="<?php echo F;?>" />
                        <input type="hidden" name="v" value="<?php echo V;?>" />
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
                            <select name="flag" class="form-control">
                                <option value='' >全部状态</option>
                                <?php

                                foreach($flag_arr as $key=>$value){?>
                                    <option value="<?php echo $key;?>" <?php echo $flag!='' && $key == $flag ? 'selected' : ''?>><?php echo $value;?></option>
                                <?php }?>
                            </select>
                        </div>
                        　　创建时间 <?php echo WUZHI_form::calendar('starttime', $starttime ? date('Y-m-d', $starttime) : '');?>- <?php echo WUZHI_form::calendar('endtime', $endtime ? date('Y-m-d', $endtime) : '');?>
                        <button type="submit" class="btn btn-info btn-sm">搜索</button>
                        <button type="submit" name="exp" class="btn btn-default btn-sm">导出Excel</button>
                    </form>
                </header>
            </div>

            <form action="?m=order&f=demand&v=kf<?php echo $this->su();?>" name="myform" method="post">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">选择</th>
                        <th class="hidden-phone tablehead">ID</th>
                        <th class="tablehead">姓名</th>
                        <th class="tablehead">电话</th>
                        <th class="tablehead">品牌</th>
                        <th class="tablehead">车型</th>
                        <th class="tablehead">提交时间</th>
                        <th class="tablehead">提交人</th>
                        <th class="tablehead">所属客服</th>
                        <th class="tablehead">经销商</th>
                        <th class="tablehead">转发给经销商</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr>
                            <td><input name="ids[]" type="checkbox" value="<?php echo $r['did'];?>"></td>

                            <td><?php echo $r['did'];?></td>
                            <td><?php echo $r['username'];?></td>
                            <td><?php echo $r['mobile'];?></td>
                            <td><?php echo $r['pinpai'];?></td>
                            <td><?php echo $r['chexing'];?></td>
                            <td><?php echo date('Y-m-d H:i:s',$r['addtime']);?></td>
                            <td><?php echo $r['publisher'];?></td>
                            <td><?php echo $r['kf_username'];?></td>
                            <td><?php echo $r['jxs_username'];?></td>
                            <td><?php if($r['flag']==0) {echo '<a href="?m=order&f=demand&v=relay&did='.$r['did'].$this->su().'" class="btn btn-primary btn-xs">转发</a>';}?>
                                <a href="javascript:makedo('?m=order&f=demand&v=delete&did=<?php echo $r['did'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                   class="btn btn-danger btn-xs">删除</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
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
            </form>
        </section>
        </form>
    </div>
</div>
<!-- page end-->
</section>
<script type="text/javascript">
    function send_goods(id,username){
        top.openiframe('index.php?m=order&f=index&v=send_goods&orderid='+id+'<?php echo $this->su();?>', 'edit', '处理"'+username+'"的订单', 660, 450);
    }
    function view(userid){
        top.openiframe('index.php?m=member&f=index&v=view&uid='+userid+'<?php echo $this->su();?>', 'view', '查看用户信息', 660, 260);
    }

    </script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>