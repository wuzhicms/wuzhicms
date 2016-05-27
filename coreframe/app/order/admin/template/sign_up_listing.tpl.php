<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
$menu_r = $this->db->get_one('menu',array('m'=>'content','f'=>'content','v'=>'listing'));
$submenuid = $menu_r['menuid'];
?>
<body>
<section class="wrapper">
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <?php
        if($id) {
        ?>
        <header class="panel-heading"><a href="?m=content&f=content&v=listing&cid=<?php echo $GLOBALS['cid'].$this->su();?>" class="btn btn-info btn-sm" id="index-listing"><i class="icon-gears2 btn-icon"></i>返回上一级</a> </header>
        <?php }?>
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
                        <select name="status" class="form-control">
                            <option value='' >全部状态</option>
                            <?php

                            foreach($status_arr as $key=>$value){?>
                                <option value="<?php echo $key;?>" <?php echo $status!='' && $key == $status ? 'selected' : ''?>><?php echo $value;?></option>
                            <?php }?>
                        </select>
                    </div>
                    　　创建时间 <?php echo WUZHI_form::calendar('starttime', $starttime ? date('Y-m-d', $starttime) : '');?>- <?php echo WUZHI_form::calendar('endtime', $endtime ? date('Y-m-d', $endtime) : '');?>
                    <button type="submit" class="btn btn-info btn-sm">搜索</button>
                </form>
            </header>
        </div>

        <section class="panel">

            <form action="?m=affiche&f=index&v=sort<?php echo $this->su();?>" name="myform" method="post">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead">ID</th>
                        <th class="hidden-phone tablehead">订单ID</th>
                        <th class="tablehead">提交人姓名</th>
                        <th class="tablehead">提交人电话</th>
                        <th class="tablehead">成人数</th>
                        <th class="tablehead">儿童数</th>
                        <th class="tablehead">紧急联系人</th>
                        <th class="tablehead">紧急联系电话</th>
                        <th class="tablehead">提交时间</th>
                        <th class="tablehead">订单状态</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        $sm = $this->db->get_one('tour_signup_member', array('smid' => $r['smid']));
                        ?>
                        <tr>
                            <td><?php echo $r['tsid'];?></td>
                            <td><?php echo $r['order_no'];?></td>
                            <td><?php echo $r['truename'];?></td>
                            <td><?php echo $r['mobile'];?></td>
                            <td><?php echo $r['cr_num'];?></td>
                            <td><?php echo $r['et_num'];?></td>
                            <td><?php echo $r['jjname'];?></td>
                            <td><?php echo $r['jjmobile'];?></td>
                            <td><?php echo time_format($r['addtime']);?></td>
                            <td><?php echo $status_arr[$r['status']];?></td>
                            <td> <a href="?m=order&f=sign_up&v=member&tsid=<?php echo $r['tsid'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">参团人列表</a>
                                <a href="javascript:makedo('?m=order&f=sign_up&v=delete&tsid=<?php echo $r['tsid'];?><?php echo $this->su();?>', '确认删除该记录？')"
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
        top.openiframe('index.php?m=order&f=index&v=send&orderid='+id+'<?php echo $this->su();?>', 'edit', '处理"'+username+'"的订单', 660, 450);
    }
    function view(id,username){
        top.openiframe('index.php?m=order&f=index&v=view&orderid='+id+'<?php echo $this->su();?>', 'view', '查看"'+username+'"的订单', 660, 260);
    }

    </script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>