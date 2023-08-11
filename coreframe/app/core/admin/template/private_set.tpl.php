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
                        echo '<td><div class="form-check form-check-inline d-inline-flex align-items-center">
                                  <input class="form-check-input" type="checkbox" id="'.$r['menuid'].'" value="'.$r['menuid'].'" onclick="st(this);" '.check_in($r['menuid'],$privates,'checked').'>
                                  <label class="form-check-label" for="'.$r['menuid'].'">'.$r['name'].'</label>
                                </div></td>
                            <td></td>
                        </tr>';
                        foreach($result as $rs) {
                            if($rs['pid']!=$r['menuid']) continue;
                            echo '<tr><td class="ps-5"><div class="form-check form-check-inline d-flex align-items-center">
                                  <input class="form-check-input" type="checkbox" id="'.$rs['menuid'].'" value="'.$rs['menuid'].'" onclick="st(this);" '.check_in($rs['menuid'],$privates,'checked').'>
                                  <label class="form-check-label" for="'.$rs['menuid'].'">'.$rs['name'].'</label>
                                </div><td>';
                            foreach($result as $r2) {
                                if($rs['menuid'] == $r2['pid']) {
                                    echo '<div class="form-check form-check-inline d-inline-flex align-content-center flex-wrap">
                                  <input class="form-check-input" type="checkbox" id="'.$r2['menuid'].'" onclick="st(this);" value="'.$r2['menuid'].'" '.check_in($r2['menuid'],$privates,'checked').'>
                                  <label class="form-check-label" for="'.$r2['menuid'].'">'.$r2['name'].'</label>
                                </div>';
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
<!-- page end-->
</section>
<script type="text/javascript">
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
            top.set_timer();
        });
    }


    var toastTrigger = document.getElementById('liveToastBtn')
var toastLiveExample = document.getElementById('liveToast')
if (toastTrigger) {
  toastTrigger.addEventListener('click', function () {
    var toast = new bootstrap.Toast(toastLiveExample)

    toast.show()
  })
}


</script>
<?php include $this->template('footer','core');?>

