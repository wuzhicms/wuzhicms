<?php

/**
 * 添加单位模板
 */
defined('IN_WZ') or exit('No direct script access allowed');
include $this->template('header', 'core');
?>

<body>
    <link href="<?php echo R; ?>css/validform.css" rel="stylesheet">
    <script src="<?php echo R; ?>js/validform.min.js"></script>
    <section class="wrapper">
        <!-- page start-->
        <section class="panel">
            <?php echo $this->menu($GLOBALS['_menuid']); ?>
            <div class="panel-body">
                <form class="form-horizontal tasi-form" method="post" action="">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">上级单位</label>
                        <div class="col-3 d-flex justify-content-center">
                            <?php
                            echo $form->tree_select($orgLists, $pid, 'name="form[pid]" class="form-select"', '≡ 无上单位 ≡');
                            ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">单位名称</label>
                        <div class="col-3">
                            <input type="text" class="form-control" id="name" name="form[name]" value="">
                        </div>
                    </div>

                    <div class="row mb-3" >
                        <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">负责人</label>
                        <div class="col-3">
                            <input type="text" class="form-control" id="org_leader" name="form[org_leader]" value="">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">联系电话</label>
                        <div class="col-3">
                            <input type="text" class="form-control" id="org_leader_tel" name="form[org_leader_tel]" value="">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">邮箱</label>
                        <div class="col-3">
                            <input type="text" class="form-control" id="org_leader_email" name="form[org_leader_email]" value="">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">状态</label>
                        <div class="col-3">
                            <div class="col-auto d-flex align-items-center pt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="type1" value="1" checked>
                                    <label class="form-check-label" for="type1">正常 </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="type0" value="0">
                                    <label class="form-check-label" for="type0">停用</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-xs-4 control-label col-form-label text-end"></label>
                        <div class="col-3">
                            <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <!-- page end-->
    </section>
    <script type="text/javascript">
        $(function() {
            $(".form-horizontal").Validform({
                tiptype: 3
            });
        })

        function set_category(value) {
            if (value == '') return false;
            $("#batch_add").css('display', 'none');
            arr = value.split("\n");
            var html = '<table class="table_form">';
            for (i = 0; i < arr.length; i++) {
                html += "<tr>";
                vas = arr[i].split("|");
                html += "<td><input name='org_name[]' class='form-control' value='" + vas[0] + "'></td>";
                if ("undefined" == typeof vas[1]) {
                    vas[1] = '';
                }
                html += "</tr>";
            }
            if (i > 1) $("#domain-div").remove();
            html += "</table>"
            $("#new_category").append(html);
        }

    </script>
    <?php include $this->template('footer', 'core'); ?>