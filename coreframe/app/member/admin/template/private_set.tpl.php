<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body class="body pxgridsbody">
<style type="text/css">
    label{min-width: 120px;}
</style>
<section class="wrapper">
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <?php echo $this->menu($GLOBALS['_menuid'],'','<a href="?m=member&f=group&v=private_set&groupid='.$groupid.$this->su().'" class="btn btn-info btn-sm" id="group-private_set"><i class="icon-gears2 btn-icon"></i>权限设置</a>');?>

            <div class="panel-body" id="panel-bodys">

                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead" colspan="8">设置会员组权限：<font color="green"><?php echo $r_member_group['name'];?></font></th>
                    </tr>
                    </thead>
                    <thead>
                    <tr>
                        <th class="tablehead">ID</th>
                        <th class="tablehead">所属站点</th>
                        <th class="tablehead">栏目名称</th>
                        <th class="tablehead">类型</th>
                        <th class="tablehead">所属模型</th>
                        <th class="tablehead">访问</th>
                        <th class="tablehead"></th>
                        <th class="tablehead" style="color:green;">权限选择</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    echo $tree_data;
                    ?>
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
    $(function($) {
        $("#group-listing").removeClass('btn-info');
        $("#group-listing").addClass('btn-default');

    });
    

    function st(actype,obj) {
        if($(obj).is(':checked')) {
            var chk=1;
        } else {
            var chk=0;
        }
        $.post("?m=member&f=group&v=private_set<?php echo $this->su();?>",{cid:obj.value,chk:chk,actype:actype,groupid:<?php echo $groupid;?>}, function(data){
            //alert("Data Loaded: " + data);
            parent.$('#alert-warning').removeClass('alert-warning');
            parent.$('#alert-warning').addClass('alert-success');
            parent.$('#alert-warning').removeClass('hide');
            parent.$('#warning-tips').html('<strong>更新成功</strong>');
            top.set_timer();
        });
    }

</script>
</body>
</html>