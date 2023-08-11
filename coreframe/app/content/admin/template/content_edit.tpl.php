<?php
/**
 * 内容添加模板
 */
defined('IN_WZ') or exit('No direct script access allowed');
include $this->template('header', 'core');
?>
<body>
    <link href="<?php echo R; ?>libs/colorpicker/style.css" rel="stylesheet">
    
    <script src="<?php echo R; ?>libs/colorpicker/color.js"></script>
    <section class="wrapper">
        <section class="border-2 border-dark border-top panel content-panel">
            <header class="panel-heading addpos d-flex justify-content-between">
                <div class="breadcrumb">
                    <?php echo catpos($cid, ' &gt; ', 'target="_blank"'); ?>
                    <a href="<?php echo $data['url'];?>" target="_blank">访问</a> &gt;
                </div>
                <button type="button" class="btn btn-outline-dark btn-sm btn-editer small">进入全屏模式</button></header>
            <div class="panel-body">
                <form name="myform" class="form-horizontal tasi-form" action="" method="post">
                    <?php
                    if (isset($formdata['5']['title'])) {
                    ?>
                    <div class="input-group mb-3" id="titlecss">
                        <span class="input-group-text bg-light py-0 rounded-0 small"><?php echo $formdata['5']['title']['name'] ?></span>
                        <?php echo $formdata['5']['title']['form'] ?>
                    </div>
                    <div id="checkwrap" class="list-group"></div>
                    <?php } ?>
                    <div class="w-100 mb-3">
                    <?php
                    if(isset($formdata['5']['content'])) {
                    ?>
                    <?php echo $formdata['5']['content']['form']?>
                    <span class="tablewarnings"><?php echo $formdata['5']['content']['remark']?></span>
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
                                                <?php if ($info['star']) { ?> <font color="red">*</font>
                                                <?php } ?>
                                                <strong><?php echo $info['name'] ?></strong>
                                            </td>
                                            <td>
                                                <div class="col-sm-12 input-group">
                                                    <?php echo $info['form'] ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
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
                                                <?php if ($info['star']) { ?> <font color="red">*</font>
                                                <?php } ?>
                                                <strong><?php echo $info['name'] ?></strong>
                                            </td>
                                            <td>
                                                <div class="col-sm-12 input-group">
                                                    <?php echo $info['form'] ?>
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
                                                <?php if ($info['star']) { ?> <font color="red">*</font>
                                                <?php } ?>
                                                <strong><?php echo $info['name'] ?></strong>
                                            </td>
                                            <td>
                                                <div class="col-sm-12 input-group">
                                                    <?php echo $info['form'] ?>
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
                    <div class="contentsubmit text-center">
                        <input name="forward" type="hidden" value="<?php echo HTTP_REFERER; ?>">
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

    //全屏模式
    $(".btn-editer").click(function () {
        if($(this).html() == '退出全屏模式')
        {$(this).html('进入全屏模式')}
        else
        {$(this).html('退出全屏模式')}
        $(".content-panel").toggleClass("content-panel-edit-mode");
        $("body" , window.top.document).toggleClass("edit_mode");
        $("body" , window.parent.document).toggleClass("edit_mode");
    });


    function fillurl(obj, value) {
        if (value != '' && $("#route_type").val() == 3) {
            value = value.replace("<?php echo POSTFIX;?>", "");
            $(obj).val(value + '<?php echo POSTFIX;?>');
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
console.log(title);

if (title !='')  {
$.post("?m=content&f=content&v=checktitle<?php echo $this->su();?>", {
title: title,
cid:<?php echo $cid;?>,
id: <?php echo $id;?>,
},
function (data) {
    if (data == 'ok') {
        $("#checkwrap").empty();//清空旧数据
        var item = document.createElement("div");
        var button = document.createElement("button");
        var checkwrap = document.getElementById("checkwrap");
        item.innerText="没有重复标题";
        item.setAttribute("class", "alert alert-success alert-dismissible fade show text-center p-2");
        button.setAttribute("type","button");
        button.setAttribute("class","btn-close pe-3 pt-1");
        button.setAttribute("data-bs-dismiss","alert");
        button.setAttribute("aria-label","Close");
        item.append(button);
        checkwrap.append(item);
    return;
    }
    data=JSON.parse(data);
    $("#checkwrap").empty();//清空旧数据
    for (let index = 0; index < data.length; index++) {
        const element = data[index];
        var checkwrap = document.getElementById("checkwrap");
        var item = document.createElement("a");
        var span = document.createElement("span");
        item.setAttribute("href", element["url"]);
        item.setAttribute("class", "alert alert-warning d-flex justify-content-between mb-2 p-2");
        item.setAttribute("target","_blank");
        span.setAttribute("class", "text-black-50");
        span.innerText="栏目ID：" + element["cid"];
        item.innerText= element["title"];
        item.append(span);
        checkwrap.append(item);
    }
});
}
}
    //移除相关内容
    function remove_relation(obj, rid) {
        $.post("?m=content&f=relation&v=remove_relation<?php echo $this->su();?>", {
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
        str = '<li class="list-group-item align-items-center d-flex justify-content-between">' + str + '</li>';
        $('#' + divid + "_ul").append(str);
    }
<?php if($cate_config['workflowid'] && $_SESSION['role'] != 1) { ?>
    <?php if($data['status'] > 0 && $data['status'] < 6) {?>
    $("input[name='form[status]'][value='1']").val(<?php echo $data['status'];?>);
    $("input[name='form[status]'][value='9']").attr("disabled", true);
    <?php } elseif($data['status'] == 6) {?>
    $("input[name='form[status]'][value='6']").attr("checked", true);
    $("input[name='form[status]'][value='9']").attr("disabled", true);
    <?php } elseif ($data['status'] == 8) {?>
    $("input[name='form[status]'][value='8']").attr("checked", true);
    $("input[name='form[status]'][value='9']").attr("disabled", true);
    <?php } elseif ($data['status'] == 7) {?>
    $("input[name='form[status]'][value='9']").attr("disabled", true);
    $("input[name='form[status]'][value='1']").attr("checked", true);
    <?php } elseif ($data['status'] == 9) { ?>
    $("input[name='form[status]'][value='9']").attr("checked", true);
    $("input[name='form[status]'][value='8']").attr("disabled", true);
    $("input[name='form[status]'][value='6']").attr("disabled", true);
<?php } }?>
    </script>
<?php include $this->template('footer', 'core'); ?>
