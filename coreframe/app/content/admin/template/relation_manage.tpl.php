<?php
/**
 * 相关文章选择操作页面模板
 */
defined('IN_WZ') or exit('No direct script access allowed');
include $this->template('header', 'core');
?>
<body class="bg-white">
    <style type="text/css">
        .cur {
            cursor: pointer;
        }
    </style>
    <section class="wrapper p-0">
        <section class="panel">
            <div class="border-1 border-bottom panel-body">
                <form class="d-flex align-items-center" action="" method="get" onsubmit="return false;">
                    <div class="input-group me-3 w-50">
                        <input type="hidden" name="m" value="content">
                        <input type="hidden" name="f" value="relation">
                        <input type="hidden" name="v" value="listing">
                        <input type="hidden" name="_su" value="<?php echo $GLOBALS['_su']; ?>">
                        <select name="keytype" id="keytype" class="form-select">
                            <option value="keywords" <?php if ($GLOBALS['keytype'] == 'keywords') echo "selected"; ?>>关键字</option>
                            <option value="username" <?php if ($GLOBALS['keytype'] == 'username') echo "selected"; ?>>用户名</option>
                        </select>
                    </div>
                    <input type="text" id="keywords" class="form-control me-3 w-50" name="keywords" value="<?php echo $keywords; ?>">
                    <div class="input-group me-3 w-50">
                        <?php
                        echo $form->tree_select($categorys, $cid, 'name="cid" id="cid" class="form-select"');
                        ?>
                    </div>
                    <button type="submit" name="button" class="btn btn-info btn-sm w-25 me-3" onclick="search_form();">搜索</button>
                    <button type="button" class="btn btn-primary w-25" onclick="add_relation();">自定义添加</button>
                </form>
            </div>
        </section>
        <div class="row m-0">
            <div class="col-sm-6 p-0">
                <section class="panel tasks-widget">
                    <div class="panel-body" id="panel-bodys">
                    </div>
                </section>
            </div>
            <div class="col-sm-6 p-0">
                <section class="panel tasks-widget">
                    <div class="border-1 border-start" style="height: 399px;overflow:auto;" id="sheiht">
                        <ul class="task-list" id="slist">
                        </ul>
                    </div>
                    <div class="text-center p-3">
                        <button class="btn btn-info px-4" onclick="save_result();">确定</button>
                    </div>
                </section>
            </div>
        </div>
        <script type="text/javascript">
            var cid = <?php echo $cid; ?>;

            function changepage(pageid) {
                var keytype = $("#keytype").val();
                var keywords = $("#keywords").val();
                $("#panel-bodys").load("?m=content&f=relation&v=listing&keytype=" + keytype + "&keywords=" + keywords + "&cid=" + cid + "<?php echo $this->su(); ?>&page=" + pageid, {}, function() {});
            }
            changepage(1);

            function search_form() {
                cid = $("#cid").val();
                var keywords = $("#keywords").val();
                var keytype = $("#keytype").val();
                $("#panel-bodys").load("?m=content&f=relation&v=listing&charset=1&&keytype=" + keytype + "&cid=" + cid + "&keywords=" + keywords + "<?php echo $this->su(); ?>", {}, function() {});

            }

            function changeList(title, url, origin_id, origin_cid) {
                title = title.replace('<', '&lt;');
                $("#slist").append('<li><div class="d-flex task-title justify-content-between"><span class="task-title-sp"><a href="' + url + '" target="_blank" origin_id="' + origin_id + '" origin_cid="' + origin_cid + '">' + title + '</a></span><div class="btn btn-danger btn-sm btn-xs cur" onclick="removeList(this);">移 除</div></div></li>');
                document.getElementById('sheiht').scrollTop = document.getElementById('sheiht').scrollHeight;


            }

            function removeList(obj) {
                $(obj).parent().parent().remove();
            }

            function save_result() {
                var dialog = top.dialog.get(window);
                var htmls = '';
                $("#slist a").each(function() {
                    htmls += $(this).html() + "~wz~" + $(this).attr('href') + "~wz~" + $(this).attr('origin_id') + "~wz~" + $(this).attr('origin_cid') + "~wuzhicms~";
                    //alert($(this).html());
                });
                dialog.close(htmls).remove();
                return false;

                // var oldfile = parent.$('#relation').val();
                var ids = $("#resvalue").val();
                dialog.close(ids).remove();
            }

            function add_relation() {
                $("#panel-bodys").html('<div class="panel-body"><label class="control-label"><strong>标题</strong></label><div class="col-sm-10 input-group"><input type="text" class="form-control" id="diytitle" name="diytitle"  placeholder="请输入标题" ></div><br><label class="control-label"><strong>链接</strong></label><div class="col-sm-10 input-group"><input type="text" class="form-control" id="diyurl"  placeholder="请输入链接地址" ></div><br><div class="col-sm-10 input-group"><button class="btn btn-info pull-left" onclick="insert_rdiy();">确定</button></div></div>');
            }

            function insert_rdiy() {
                var diytitle = $("#diytitle").val();
                var diyurl = $("#diyurl").val();
                if (diytitle == '') {
                    var d = dialog({
                        content: '请输入标题'
                    });
                    d.show();
                    setTimeout(function() {
                        d.close().remove();
                    }, 2000);
                    return false;
                }
                if (diyurl == '') {
                    var d = dialog({
                        content: '请输入链接地址'
                    });
                    d.show();
                    setTimeout(function() {
                        d.close().remove();
                    }, 2000);
                    return false;
                }
                $("#diytitle").val('');
                $("#diyurl").val('');
                changeList(diytitle, diyurl);
                var d = dialog({
                    content: '已添加至右侧列表'
                });
                d.show();
                setTimeout(function() {
                    d.close().remove();
                }, 2000);

            }
        </script>
    </section>
    <?php include $this->template('footer', 'core'); ?>