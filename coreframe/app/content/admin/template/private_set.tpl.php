<?php
defined('IN_WZ') or exit('No direct script access allowed');
include $this->template('header', 'core');
?>
<body class="body pxgridsbody">
    <section class="wrapper">
        <!-- page start-->
        <section class="panel">
            <?php echo $this->menu($GLOBALS['_menuid']); ?>
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
        <!-- page end-->
    </section>
    <script type="text/javascript">
        function st(cid, obj) {
            if ($(obj).is(':checked')) {
                var chk = 1;
            } else {
                var chk = 0;
            }
            $.post("?m=content&f=category&v=private_set<?php echo $this->su(); ?>", {
                ac: obj.value,
                chk: chk,
                cid: cid,
                role: <?php echo $role; ?>
            }, function(data) {
                //alert("Data Loaded: " + data);
                parent.$('#alert-warning').removeClass('alert-warning');
                parent.$('#alert-warning').addClass('alert-success');
                parent.$('#alert-warning').removeClass('hide');
                parent.$('#warning-tips').html('<strong>更新成功</strong>');
                top.set_timer();
            });
        }

        function select_tr(cid, obj) {
            if ($(obj).is(':checked')) {
                $("input[name='cid" + cid + "']").each(function() {
                    $(this).prop("checked", true);
                });
                var chk = 1;
            } else {
                $("input[name='cid" + cid + "']").each(function() {
                    $(this).prop("checked", false);
                });
                var chk = 0;
            }
            $.post("?m=content&f=category&v=private_set<?php echo $this->su(); ?>", {
                ac: 'all',
                chk: chk,
                cid: cid,
                role: <?php echo $role; ?>
            }, function(data) {
                //alert("Data Loaded: " + data);
                parent.$('#alert-warning').removeClass('alert-warning');
                parent.$('#alert-warning').addClass('alert-success');
                parent.$('#alert-warning').removeClass('hide');
                parent.$('#warning-tips').html('<strong>更新成功</strong>');
                top.set_timer();
            });
        }
    </script>
    <?php include $this->template('footer', 'core'); ?>
