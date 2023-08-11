<?php
/**
 * @author     haochuan <haochuan6868@163.com>
 * @created    2020/1/13 22:17
 * @version    1.0.1
 */
?>
<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<body class="body pxgridsbody">
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo isset($GLOBALS['_menuid']) ? $this->menu($GLOBALS['_menuid']) : '';?>
                <div class="panel-body" id="panel-bodys">
                    <form id="myform" name="myfrom" class="form-horizontal tasi-form" method="post" action="index.php?m=member&f=verify&v=add<?php echo $this->su();?>">
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                                <tr>
                                    <th class="tablehead"></th>
                                    <th class="tablehead"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-sm-2 col-xs-4 text-right"><label class="control-label">名称</label></td>
                                    <td>
                                        <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><input type="text" name="info[username]" class="form-control" placeholder="请输入认证名称" datatype="/^[a-z0-9\u4E00-\u9FA5\uf900-\ufa2d\-]{3,20}$/i" errormsg="用户名为3-20位数字、字母、汉字和-组成" sucmsg="OK" ajaxurl="index.php?m=member&f=index&v=public_check_user"/></div>
                                    </td>
                                </tr>
                            </tbody>
                    </form>
                </div>
            </section>
        </div>
    </div>
</section>
</body>
