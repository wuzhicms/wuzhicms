<?php
    /**
     * 添加栏目模板
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
                    <ul class="nav nav-tabs"  id="myTab" role="tablist">
                        <li role="presentation" class="nav-item">
                            <button type="button" class="px-5 nav-link active" id="1tab" data-bs-toggle="tab"  data-bs-target="#tabs1" role="tab" aria-controls="tabs1" aria-selected="true">基本信息</button>
                        </li>
                        <li role="presentation" class="nav-item">
                            <button type="button" class="px-5 nav-link" data-bs-target="#tabs2" role="tab" id="2tab" data-bs-toggle="tab" aria-controls="tabs2" aria-selected="false">生成静态设置</button>
                        </li>
                        <li role="presentation" class="nav-item">
                            <button type="button" class="px-5 nav-link" data-bs-target="#tabs3" role="tab" id="3tab" data-bs-toggle="tab" aria-controls="tabs3" aria-selected="false">模板设置</button>
                        </li>
                        <li role="presentation" class="nav-item">
                            <button type="button" class="px-5 nav-link" data-bs-target="#tabs4" role="tab" id="4tab" data-bs-toggle="tab" aria-controls="tabs4" aria-selected="false">SEO设置</button>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active show" id="tabs1" aria-labelledby="1tab">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">类型</label>
                                <div class="col-3">
                                    <div class="col-auto d-flex align-items-center pt-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="type0" value="0" <?php if (!$r['type']) echo 'checked'; ?>>
                                            <label class="form-check-label" for="type0">列表</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="type" id="type1" value="1" <?php if ($r['type'] == 1) echo 'checked'; ?>>
                                            <label class="form-check-label" for="type1">单网页 </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">请选择模型</label>
                                <div class="col-3 d-flex justify-content-center">
                                    <?php
                                    echo $form->select(key_value($models, 'modelid', 'name'), $modelid, 'name="form[modelid]" class="form-select" datatype="*" errormsg="请选择模型！"', "≡ 请选择模型 ≡");
                                    ?>

                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">上级栏目</label>
                                <div class="col-3 d-flex justify-content-center">
                                    <?php
                                    echo $form->tree_select($categorys, $pid, 'name="form[pid]" class="form-select" onchange="check_parent(this.value)"', '≡ 无上级栏目 ≡');
                                    ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">名称|英文目录</label>
                                <div class="col-3">
                                    <div id="batch_add">
                                        <textarea class="form-control" maxlength="255" rows="5" placeholder="例如：&#10;国内新闻|china&#10;国际新闻|world" datatype="*" errormsg="请输入栏目名称" onblur="set_category(this.value)"></textarea><span class="Validform_checktip"></span>
                                    </div>
                                    <span id="new_category"></span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">栏目图片</label>
                                <div class="col-3">
                                    <div class="upload-picture-card"><?php echo $form->attachment('', '1', 'form[thumb]'); ?></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">栏目icon</label>
                                <div class="col-3">
                                    <div class="upload-picture-card"><?php echo $form->attachment('', '1', 'form[icon]', ''); ?></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">工作流</label>
                                <div class="col-3">
                                    <?php
                                    echo $form->select(key_value($workflow, 'workflowid', 'name'), 0, 'name="form[workflowid]" class="form-select"', '≡ 无需审核 ≡');
                                    ?>
                                </div>
                            </div>
                            <?php
                            if ($type == 0 || $type == 2) {
                            ?>
                                <div class="row mb-3 <?php if ($pid) echo 'hide'; ?>" id="domain-div">
                                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">绑定域名</label>
                                    <div class="col-3">
                                        <input type="text" class="form-control" id="domain" name="form[domain]" value="">
                                    </div>
                                    <div class="col"><small class="help-block"><i class="icon-info-circle"></i>可绑定任意域名：格式为：http://www.wuzhicms.cn/ ，绑定域名后，生成静态规则将使用默认规则</small></div>
                                </div>
                            <?php } ?>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">是否在栏目列表处显示</label>
                                <div class="col-3">
                                    <div class="col-auto d-flex align-items-center pt-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="form[showloop]" id="showloop1" value="1" <?php if($r['showloop']==1) echo "checked";?>>
                                            <label class="form-check-label" for="showloop1">是</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="form[showloop]" id="showloop0" value="0" <?php if($r['showloop']==0) echo "checked";?>>
                                            <label class="form-check-label" for="showloop0">否 </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">是否在导航中显示</label>
                                <div class="col-3">
                                    <div class="col-auto d-flex align-items-center pt-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="form[ismenu]" id="ismenu1" value="1" <?php if($r['ismenu']==1) echo "checked";?>>
                                            <label class="form-check-label" for="ismenu1">是</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="form[ismenu]" id="ismenu0" value="0" <?php if($r['ismenu']==0) echo "checked";?>>
                                            <label class="form-check-label" for="ismenu0">否 </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tabs2" aria-labelledby="2tab">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">栏目页生成静态</label>
                                <div class="col-3">
                                    <div class="col-auto d-flex align-items-center pt-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="form[listhtml]" id="listhtml1" value="1" <?php if ($r['listhtml']) echo "checked"; ?> onclick="change_listhtml(1);">
                                            <label class="form-check-label" for="listhtml1">是</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="form[listhtml]" id="listhtml0" value="0" <?php if (!$r['listhtml']) echo "checked"; ?> onclick="change_listhtml(0);">
                                            <label class="form-check-label" for="listhtml0">否 </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($type == 0) {
                            ?>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">内容页生成静态</label>
                                    <div class="col-3">
                                        <div class="col-auto d-flex align-items-center pt-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="form[showhtml]" id="showhtml1" value="1" <?php if ($r['showhtml']) echo "checked"; ?> onclick="change_listhtml(1);">
                                                <label class="form-check-label" for="showhtml1">是</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="form[showhtml]" id="showhtml0" value="0" <?php if (!$r['showhtml']) echo "checked"; ?> onclick="change_listhtml(0);">
                                                <label class="form-check-label" for="showhtml0">否 </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">栏目页URL规则</label>
                                <div class="col-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="listurl" name="form[listurl]" value="index.php?v=listing&cid={$cid}|index.php?v=listing&cid={$cid}&page={$page}">
                                        <button type="button" class="btn btn-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">选择规则 </button>
                                        <ul id="phpurlruleid" class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                                            <li><a class="dropdown-item small" href="javascript:" onclick="htmlit('index.php?v=listing&cid={$cid}|index.php?v=listing&cid={$cid}&page={$page}','listurl');">动态地址：index.php?v=listing&cid=1&page=1</a></li>
                                            <li><a class="dropdown-item small" href="javascript:" onclick="htmlit('list-{$cid}-{$page}.html','listurl');">伪静态：list-1-10000.html</a></li>
                                        </ul>
                                        <ul id="htmlurlruleid" class="dropdown-menu dropdown-menu-end dropdown-menu-dark hide">
                                            <li><a class="dropdown-item small" href="javascript:" onclick="htmlit('{$categorydir}/{$cid}/index.html|{$categorydir}/{$cid}/{$page}.html','listurl');">news/1001/1.html</a></li>
                                            <li><a class="dropdown-item small" href="javascript:" onclick="htmlit('{$catdir}/index.html|{$catdir}/{$page}.html','listurl');">download/1.html</a></li>
                                            <li><a class="dropdown-item small" href="javascript:" onclick="htmlit('{$categorydir}/{$catdir}/index.html|{$categorydir}/{$catdir}/{$page}.html','listurl');">download/free/1.html</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <?php
                            if ($type == 0) {
                            ?>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">内容页URL规则</label>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="showurl" name="form[showurl]" value="index.php?v=show&cid={$cid}&id={$id}|index.php?v=show&cid={$cid}&id={$id}&page={$page}">
                                            <button type="button" class="btn btn-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">选择规则 </button>
                                            <ul id="phpurlruleid2" class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                                                <li><a class="dropdown-item small" href="javascript:" onclick="htmlit('index.php?v=show&cid={$cid}&id={$id}|index.php?v=show&cid={$cid}&id={$id}&page={$page}','showurl');">动态地址：index.php?v=show&cid=1&id=1&page=1</a></li>
                                                <li><a class="dropdown-item small" href="javascript:" onclick="htmlit('item-{$cid}-{$id}-{$page}.html','showurl');">伪静态：item-1-1-1.html</a></li>
                                                <li><a class="dropdown-item small" href="javascript:" onclick="htmlit('show-{$cid}-{$id}-{$page}.html','showurl');">伪静态：show-1-1-1.html</a></li>
                                            </ul>
                                            <ul id="htmlurlruleid2" class="dropdown-menu dropdown-menu-end dropdown-menu-dark hide">
                                                <li><a class="dropdown-item small" href="javascript:" onclick="htmlit('{$year}/{$cid}/{$id}.html|{$year}/{$cid}/{$id}-{$page}.html','showurl');">2014/1001/1-1.html</a></li>
                                                <li><a class="dropdown-item small" href="javascript:" onclick="htmlit('{$year}/{$catdir}_{$month}{$day}/{$id}.html|{$year}/{$catdir}_{$month}{$day}/{$id}_{$page}.html','showurl');">2014/dir_1010/1_2.html</a></li>
                                                <li><a class="dropdown-item small" href="javascript:" onclick="htmlit('{$categorydir}/{$catdir}/{$year}/{$month}{$day}/{$id}.html|{$categorydir}/{$catdir}/{$year}/{$month}{$day}/{$id}_{$page}.html','showurl');">parentdir/dir/2014/0101/1_1.html</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tabs3" aria-labelledby="3tab">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">大栏目页模版</label>
                                <div class="col-3">
                                    <?php
                                    echo $form->templates('content', 'default:category', 'name="form[category_template]" class="form-select"');
                                    ?>
                                </div>
                                <small class="col help-block"><i class="icon-info-circle"></i>该栏目下有子栏目时生效</small>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">终级栏目页模版</label>
                                <div class="col-3" style="padding-top: 7px;">
                                    <?php
                                    echo $form->templates('content', 'default:list', 'name="form[list_template]" class="form-select"');
                                    ?>
                                </div>
                                <small class="col help-block"><i class="icon-info-circle"></i>该栏目没有子栏目时生效</small>
                            </div>
                            <?php
                            if ($type == 0) {
                            ?>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">内容页模版</label>
                                    <div class="col-3">
                                        <?php
                                        echo $form->templates('content', 'default:show', 'name="form[show_template]" class="form-select"');
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tabs4" aria-labelledby="4tab">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">SEO 标题</label>
                                <div class="col-3">
                                    <input type="text" class="form-control" name="form[seo_title]" value="">
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">SEO 关键字</label>
                                <div class="col-3">
                                    <input type="text" class="form-control" name="form[seo_keywords]" value="">
                                </div>
                            </div>


                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">SEO 网页描述</label>
                                <div class="col-3">
                                    <textarea type="text" rows="2" class="form-control" name="form[seo_description]" value=""></textarea>
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
        <div class="alert alert-success fade in">
            <strong>重要提示:</strong> 栏目访问权限，投稿配置，请移步至：管理会员-<a href="?m=member&f=group&v=listing<?php echo $this->su(); ?>&_menuid=86" target="_blank">会员组管理</a>-权限访问设置
        </div>
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
                html += "<td><input name='catname[]' class='form-control' value='" + vas[0] + "'></td>";
                if ("undefined" == typeof vas[1]) {
                    vas[1] = '';
                }
                html += "<td><input name='catdir[]' class='form-control' value='" + vas[1] + "'></td>";
                html += "</tr>";
            }
            if (i > 1) $("#domain-div").remove();
            html += "</table>"
            $("#new_category").append(html);
        }

        function htmlit(value, id) {
            $("#" + id).val(value);
        }

        function change_listhtml(type) {
            if (type == 1) {
                $("#htmlurlruleid").removeClass('hide');
                $("#phpurlruleid").addClass('hide');
                $("#listurl").val('{$categorydir}/{$catdir}/index.html|{$categorydir}/{$catdir}/{$page}.html');
            } else {
                $("#htmlurlruleid").addClass('hide');
                $("#phpurlruleid").removeClass('hide');
                $("#listurl").val('index.php?v=listing&cid={$cid}');
            }
        }

        function change_showhtml(type) {
            if (type == 1) {
                $("#htmlurlruleid2").removeClass('hide');
                $("#phpurlruleid2").addClass('hide');
                $("#showurl").val('{$year}/{$cid}/{$id}.html|{$year}/{$cid}/{$id}-{$page}.html');
            } else {
                $("#htmlurlruleid2").addClass('hide');
                $("#phpurlruleid2").removeClass('hide');
                $("#showurl").val('index.php?v=show&cid={$cid}&id={$id}');
            }
        }

        function check_parent(value) {
            if (value == 0) {
                $("#domain-div").removeClass('hide');
            } else {
                $("#domain-div").addClass('hide');
            }
        }
    </script>
    <?php include $this->template('footer', 'core'); ?>