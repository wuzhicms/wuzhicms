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
            <?php echo $this->menu($GLOBALS['_menuid']);?>

            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead" colspan="2">设置权限：<?php echo $r_role['name'];?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($parent_top AS $r) {
                        echo '<tr>';
                        echo '<td><label><input type="checkbox"  value="'.$r['menuid'].'" onclick="st(this);" '.check_in($r['menuid'],$privates,'checked').'> '.$r['name'].'</label></td>
                            <td></td>
                        </tr>';
                        foreach($result as $rs) {
                            if($rs['pid']!=$r['menuid']) continue;
                            echo '<tr>
                            <td style="padding-left: 50px;"><label><input type="checkbox" value="' . $rs['menuid'] . '" onclick="st(this);" '.check_in($rs['menuid'],$privates,'checked').'> ' . $rs['name'] . '</label></td>
                            <td>';
                            foreach($result as $r2) {
                                if($rs['menuid'] == $r2['pid']) {
                                    echo '<label><input type="checkbox" value="' . $r2['menuid'] . '" onclick="st(this);" '.check_in($r2['menuid'],$privates,'checked').'> ' . $r2['name'] . '</label>';
                                }
                            }
                            echo '</td>
                            </tr>';
                        }
                    }
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

    function st(obj) {
        if($(obj).is(':checked')) {
            var chk=1;
        } else {
            var chk=0;
        }
        $.post("?m=core&f=power&v=private_set<?php echo $this->su();?>",{id:obj.value,chk:chk,role:<?php echo $role;?>}, function(data){
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