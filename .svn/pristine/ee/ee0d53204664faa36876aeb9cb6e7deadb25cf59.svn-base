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

                                foreach($status as $key=>$value){?>
                                    <option value="<?php echo $key;?>" <?php echo $flag!='' && $key == $flag ? 'selected' : ''?>><?php echo $value;?></option>
                                <?php }?>
                            </select>
                        </div>
                        　　申请时间 <?php echo WUZHI_form::calendar('starttime', $starttime ? date('Y-m-d', $starttime) : '');?>- <?php echo WUZHI_form::calendar('endtime', $endtime ? date('Y-m-d', $endtime) : '');?>
                        <button type="submit" class="btn btn-info btn-sm">搜索</button>
                        <button type="submit" name="exp" class="btn btn-default btn-sm">导出Excel</button>

                    </form>
                </header>
            </div>
            <form action="?m=affiche&f=index&v=sort<?php echo $this->su();?>" name="myform" method="post">
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead">订单ID</th>
                        <th class="tablehead" colspan="2">名称</th>
                        <th class="tablehead">数量</th>
                        <th class="tablehead">申请时间/发货时间</th>
                        <th class="tablehead">物流/单号</th>
                        <th class="tablehead">下单会员</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {
                        ?>
                        <tr>
                            <td><?php echo $r['order_no'];?></td>
                            <td><img src="<?php echo $r['thumb'];?>" onclick="view('<?php echo $r['orderid'];?>','<?php echo $mr['username'];?>)" style="max-width: 50px;max-height: 50px;"></td>
                            <td><?php
                                echo '<a href="'.$r['url'].'" target="_blank">'.safe_htm($r['remark']).'</a>';?></td>
                            <td><?php echo $r['quantity'];?></td>
                            <td><?php echo date('Y-m-d H:i:s',$r['addtime']);?>
                            <br><?php echo $r['post_time'];?></td>
                            <td><?php echo $r['express'].'<br>'.$r['snid'];?></td>
                            <td><?php echo $r['username'];?></td>
                            <td>
                                <?php if($r['status']==1) {
                                    echo '<a href="javascript:void(0)" onclick="send_goods('.$r['orderid'].',\''.$mr['username'].'\')" class="btn btn-primary btn-xs">发货</a>';
                                } else {
                                    echo $status[$r['status']];
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><?php echo $r['addressee'];?></td>
                            <td><?php echo $r['mobile'];?></td>
                            <td><?php echo $r['tel'];?></td>
                            <td><?php echo $r['address'];?></td>
                            <td colspan="4"></td>
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