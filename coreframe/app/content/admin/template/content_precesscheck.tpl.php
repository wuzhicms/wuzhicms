<?php
/**
 * 审核页面模板
 */
defined('IN_WZ') or exit('No direct script access allowed');
include $this->template('header', 'core');
?>
<body >
<link href="<?php echo R; ?>libs/colorpicker/style.css" rel="stylesheet">

<script src="<?php echo R; ?>libs/colorpicker/color.js"></script>
<style>
    .tablewarnings{display: none;}
    .bg-examine{background-color: #fffde7;border: 2px solid #e9e6cc;}
</style>
<section class="wrapper">
    <section class="border-2 border-dark border-top panel content-panel">
        <header class="panel-heading addpos d-flex justify-content-between">
            <div class="breadcrumb">
            <?php echo catpos($cid, ' &gt; ', 'target="_blank"'); ?>
            <a href="<?php echo $data['url']; ?>" target="_blank">访问</a> &gt; </div>
        </header>
        <div class="panel-body">
            <form name="myform" class="form-horizontal tasi-form" action="" method="post">
                    <?php
                    if (isset($formdata['5']['title'])) {
                    ?>
                    <div class="input-group mb-3" id="titlecss">
                        <span class="input-group-text bg-light py-0 rounded-0 small"><?php echo $formdata['5']['title']['name'] ?></span>
                        <?php echo $formdata['5']['title']['form'] ?>
                    </div>
                    <?php } ?>
                    <div class="w-100 mb-3">
                    <?php
                    if(isset($formdata['5']['content'])) {
                    ?>
                    <?php echo $formdata['5']['content']['form']?>
                    <span class="tablewarnings hide"><?php echo $formdata['5']['content']['remark']?></span>
                    <?php }?>
                    </div>

                    <ul class="nav nav-tabs"  id="myTab" role="tablist">
                        <li role="presentation" class="nav-item">
                            <button type="button" class="px-5 nav-link active" id="1tab" data-bs-toggle="tab"  data-bs-target="#tabs1" role="tab" aria-controls="tabs1" aria-selected="true">基本信息</button>
                        </li>
                        <li role="presentation" class="nav-item">
                            <button type="button" class="px-5 nav-link" data-bs-target="#tabs2" role="tab" id="2tab" data-bs-toggle="tab" aria-controls="tabs2" aria-selected="false">高级设置</button>
                        </li>
                        <li role="presentation" class="nav-item">
                            <button type="button" class="px-5 nav-link" data-bs-target="#tabs3" role="tab" id="3tab" data-bs-toggle="tab" aria-controls="tabs3" aria-selected="false">权限与收费</button>
                        </li>
                    </ul>

                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade show active" id="tabs1" aria-labelledby="1tab">
                            <table class="table table-striped table-advance table-hover" id="contenttable">
                                <?php
                                if (is_array($formdata['0'])) {
                                    foreach ($formdata['0'] as $field => $info) {
                                        if ($info['powerful_field'] || $field == 'status') continue;
                                        if ($info['formtype'] == 'powerful') {
                                            foreach ($formdata['0'] as $_fm => $_fm_value) {
                                                if ($_fm_value['powerful_field']) {
                                                    $info['form'] = str_replace('{' . $_fm . '}', $_fm_value['form'], $info['form']);
                                                }
                                            }
                                            foreach ($formdata['1'] as $_fm => $_fm_value) {
                                                if ($_fm_value['powerful_field']) {
                                                    $info['form'] = str_replace('{' . $_fm . '}', $_fm_value['form'], $info['form']);
                                                }
                                            }
                                            foreach ($formdata['2'] as $_fm => $_fm_value) {
                                                if ($_fm_value['powerful_field']) {
                                                    $info['form'] = str_replace('{' . $_fm . '}', $_fm_value['form'], $info['form']);
                                                }
                                            }
                                        }
                                ?>
                                <tr>
                                    <td>
                                        <?php if ($info['star']) { ?> <font color="red">*</font><?php } ?>
                                        <strong><?php echo $info['name'] ?></strong>
                                    </td>
                                    <td>
                                        <div class="col-sm-12 input-group">
                                            <?php echo $info['form'] ?>
                                            <span class="tablewarnings"><?php echo $info['remark'] ?></span>
                                        </div>
                                    </td>
                                </tr>
                                
                                <?php
                                    }
                                }
                                if ($tb_arr) {
                                    ?>
                                    <tr>
                                        <td>
                                            <strong>同步更新</strong>
                                        </td>
                                        <td>
                                            <div class="col-sm-12 input-group">
                                                <?php
                                                foreach ($tb_arr as $tb_r) {
                                                    echo '<label class="checkbox-inline"><input type="checkbox" name="tb_update[' . $tb_r['new_id'] . ']" value="' . $tb_r['new_cid'] . '"> ' . $tb_r['names'] . catpos2($tb_r['new_cid']) . 'ID:' . $tb_r['new_id'] . '</label>';
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>

                                
                            </table>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="tabs2" aria-labelledby="2tab">
                            <table class="table table-striped table-advance table-hover" id="contenttable">
                                <?php
                                if (is_array($formdata['1'])) {
                                    foreach ($formdata['1'] as $field => $info) {
                                        if ($info['powerful_field']) continue;
                                        if ($info['formtype'] == 'powerful') {
                                            foreach ($formdata['0'] as $_fm => $_fm_value) {
                                                if ($_fm_value['powerful_field']) {
                                                    $info['form'] = str_replace('{' . $_fm . '}', $_fm_value['form'], $info['form']);
                                                }
                                            }
                                            foreach ($formdata['1'] as $_fm => $_fm_value) {
                                                if ($_fm_value['powerful_field']) {
                                                    $info['form'] = str_replace('{' . $_fm . '}', $_fm_value['form'], $info['form']);
                                                }
                                            }
                                            foreach ($formdata['2'] as $_fm => $_fm_value) {
                                                if ($_fm_value['powerful_field']) {
                                                    $info['form'] = str_replace('{' . $_fm . '}', $_fm_value['form'], $info['form']);
                                                }
                                            }
                                        }
                                ?>
                                        <tr>
                                            <td>
                                                <?php if ($info['star']) { ?> <font color="red">*</font><?php } ?>
                                                <strong><?php echo $info['name'] ?></strong>
                                            </td>
                                            <td>
                                                <div class="col-sm-12 input-group">
                                                    <?php echo $info['form'] ?>
                                                    <span class="tablewarnings"><?php echo $info['remark'] ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </table>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="tabs3" aria-labelledby="3tab">
                            <table class="table table-striped table-advance" id="contenttable">
                                <?php
                                if (is_array($formdata['2'])) {
                                    foreach ($formdata['2'] as $field => $info) {
                                        if ($info['powerful_field']) continue;
                                        if ($info['formtype'] == 'powerful') {
                                            foreach ($formdata['0'] as $_fm => $_fm_value) {
                                                if ($_fm_value['powerful_field']) {
                                                    $info['form'] = str_replace('{' . $_fm . '}', $_fm_value['form'], $info['form']);
                                                }
                                            }
                                            foreach ($formdata['1'] as $_fm => $_fm_value) {
                                                if ($_fm_value['powerful_field']) {
                                                    $info['form'] = str_replace('{' . $_fm . '}', $_fm_value['form'], $info['form']);
                                                }
                                            }
                                            foreach ($formdata['2'] as $_fm => $_fm_value) {
                                                if ($_fm_value['powerful_field']) {
                                                    $info['form'] = str_replace('{' . $_fm . '}', $_fm_value['form'], $info['form']);
                                                }
                                            }
                                        }
                                ?>
                                        <tr>
                                            <td>
                                                <?php if ($info['star']) { ?> <font color="red">*</font><?php } ?>
                                                <strong><?php echo $info['name'] ?></strong>
                                            </td>
                                            <td>
                                                <div class="col-sm-12 input-group">
                                                    <?php echo $info['form'] ?>
                                                    <span class="tablewarnings"><?php echo $info['remark'] ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>

                    <div class="bg-examine mt-3 pt-2 pb-0">
                        <table class="table">
                            <tr>
                                <td class="fw-bold">审批记录</td>
                                <td>
                                <?php
                                    if ($check_records) {
                                        foreach ($check_records as $r) {
                                            echo '<li><span style="color: #b93c0d;">' . date('Y-m-d H:i:s', $r['checktime']) . ' ' . $r['admin_username'] . ' ' . $r['status_msg'] . '</span> 审批意见：' . $r['msg'] . '</li>';
                                        }
                                    } else {
                                        echo '没有审批记录';
                                    }
                                ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">审批状态</td>
                                <td>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pass" id="pass1" value="1">
                                    <label class="form-check-label" for="pass1">通过审核</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="pass" id="pass0" value="0">
                                    <label class="form-check-label" for="pass0">审核不通过</label>
                                </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">审批意见</td>
                                <td class="pb-3 pe-3 pt-3">
                                <textarea name="check_msg" class="form-control" cols="60" rows="3"></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="contentsubmit text-center">
                        <input type="hidden" name="modelid" value="<?php echo $modelid; ?>">
                        <input type="hidden" name="old_status" value="<?php echo $status; ?>">
                        <input name="submit" type="submit" class="save-bt btn btn-info btn-sm px-4" value=" 提 交 ">
                    </div>
            </form>
        </div>
    </section>
</section>

<script type="text/javascript">
    $(".save-bt").click(function() {
        t = setTimeout("hide_formtips()", 5000);
    });
    $(function() {
        $(".form-horizontal").Validform({
            tiptype: 1
            //$.Hidemsg()
        });
    })

    function fillurl(obj, value) {
        if (value != '' && $("#route_type").val() == 3) {
            value = value.replace("<?php echo POSTFIX; ?>", "");
            $(obj).val(value + '<?php echo POSTFIX; ?>');
        }
    }

    function change_route(name, value) {
        $("#def_type").html(name);
        $("#route_type").val(value);
    }

    function hide_formtips() {
        $.Hidemsg();
        clearInterval(t);
    }

    function check_title() {
        var title = $("#title").val();
        if (title == '') {
            alert('请填写标题');
            $("#title").focus();
        } else {
            $.post("?m=content&f=content&v=checktitle<?php echo $this->su(); ?>", {
                    title: title,
                    cid: <?php echo $cid; ?>,
                    id: 0
                },
                function(data) {
                    if (data == 'ok') {
                        alert('没有重复标题');
                    } else if (data == '1') {
                        alert('有完全相同的标题存在');
                    } else if (data == '2') {
                        alert('有相似度很高的标题存在');
                    }
                });
        }
    }
    //移除相关内容
    function remove_relation(obj, rid) {
        $.post("?m=content&f=relation&v=remove_relation<?php echo $this->su(); ?>", {
            rid: rid,
            time: Math.random()
        }, function(data) {
            if (data == '200') {
                $(obj).parent().fadeOut();
            } else {
                alert(data);
            }
        });

    }

    function remove_obj(obj) {
        $(obj).parent().remove();
    }

    function add_newfile(divid) {
        var str = $('#text_' + divid).val();
        str = '<li>' + str + '</li>';
        $('#' + divid + "_ul").append(str);
    }
    <?php
    if ($cate_config['workflowid'] && $_SESSION['role'] != 1) {
    ?>
        $("input[name='form[status]'][value='9']").attr("disabled", true);
        $("input[name='form[status]'][value='8']").attr("disabled", true);
        $("input[name='form[status]'][value='1']").attr("checked", true);

    <?php } ?>
</script>
<?php include $this->template('footer', 'core'); ?>