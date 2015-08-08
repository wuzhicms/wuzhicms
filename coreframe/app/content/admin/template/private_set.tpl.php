<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body class="body pxgridsbody">
<style type="text/css">
    label{min-width: 60px;}
</style>
<section class="wrapper">
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <?php echo $this->menu($GLOBALS['_menuid']);?>
            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead" colspan="8">设置内容管理权限</th>
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
    function set_timer() {
       var t=setTimeout(function(){parent.$('#alert-warning').addClass('hide');clearInterval(t);},3000);
    }

    function st(cid,obj) {
        if($(obj).is(':checked')) {
            var chk=1;
        } else {
            var chk=0;
        }
        $.post("?m=content&f=category&v=private_set<?php echo $this->su();?>",{ac:obj.value,chk:chk,cid:cid,role:<?php echo $role;?>}, function(data){
            //alert("Data Loaded: " + data);
            parent.$('#alert-warning').removeClass('alert-warning');
            parent.$('#alert-warning').addClass('alert-success');
            parent.$('#alert-warning').removeClass('hide');
            parent.$('#warning-tips').html('<strong>更新成功</strong>');
            set_timer();
        });
    }
function select_tr(cid,obj) {
    if($(obj).is(':checked')) {
        $("input[name='cid"+cid+"']").each(function(){
            $(this).prop("checked",true);
        });
        var chk=1;
    } else {
        $("input[name='cid"+cid+"']").each(function(){
            $(this).prop("checked",false);
        });
        var chk=0;
    }
    $.post("?m=content&f=category&v=private_set<?php echo $this->su();?>",{ac:'all',chk:chk,cid:cid,role:<?php echo $role;?>}, function(data){
        //alert("Data Loaded: " + data);
        parent.$('#alert-warning').removeClass('alert-warning');
        parent.$('#alert-warning').addClass('alert-success');
        parent.$('#alert-warning').removeClass('hide');
        parent.$('#warning-tips').html('<strong>更新成功</strong>');
        set_timer();
    });
}
</script>
</body>
</html>