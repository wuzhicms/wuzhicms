<?php
/**
 * 内容管理栏目树目录模板
 */
defined('IN_WZ') or exit('No direct script access allowed');
include $this->template('header', 'core');
?>

<body class="body categorytree">

    <div class="treelistmain">
        <div class="categoryserach">
            <div class="input-serach">
                <input type="text" class="form-control" placeholder="输入名称，按回车搜索" onkeydown="if(event.keyCode==13) highlight(this.value);">
            </div>
        </div>
        <div class="treetools">
            <ul class="d-flex justify-content-between mb-1 mt-3">
                <li><a href="javascript:ftips(10);" title="审核信息"><i class="icon-check-square-o"></i><span class="badge bg-important hide" id="id1"></span></a></li>
                <li><a href="javascript:ftips(8);" title="定时发送"><i class="icon-clock-o"></i><span class="badge bg-important hide" id="id2"></span></a></li>
                <li><a href="javascript:ftips(6);" title="草稿箱"><i class="icon-save"></i><span class="badge bg-important hide" id="id3"></span></a></li>
                <li><a href="javascript:ftips(0);" title="回收站"><i class="icon-trash-o"></i></a></li>
            </ul>
        </div>
        <div class="treelist">
            <section class="treepanel">
                <div id="panel-bodys">
                    <?php echo $category_tree; ?>
                </div>
            </section>
        </div>
    </div>

    <link rel="stylesheet" type="text/css" href="<?php echo R; ?>css/jquery-tree.css" />
    <script type="text/javascript" src="<?php echo R; ?>js/jquery-tree.min.js"></script>
    <script type="text/javascript">
        var global_cid = '<?php echo $cid; ?>';
        $('#tree').explr({
            rememberState: true,
            startCollapsed: false,
        });
        var parentpos = top.$("#position").html();

        function o_p(cid, obj) {
            $(".i-t").css('color', '#666');
            $(obj).css('color', '#cb0d0d');
            var te = $(obj).text();
            top.$("#position").html(parentpos + te + "<span>></span>");
            parent.$("#iframeid").attr('src', '?m=content&f=content&v=listing&cid=' + cid + '&type=<?php echo $GLOBALS['type'] . $this->su(); ?>');
            global_cid = cid;
        }

        function w(s) {}

        function ftips(status) {
            parent.$("#iframeid").attr('src', '?m=content&f=content&v=allcheck&cid=' + global_cid + '<?php echo $this->su(); ?>&status=' + status);
        }

        function highlight(s) {
            if (s.length == 0) {
                return false;
            }
            $(".i-t").css('color', '#666');
            var total = 0;
            $("a").each(function() {
                if (search_text(s, $(this).text())) {
                    $(this).css('color', '#cb0d0d');
                    total++;
                    if (total == 1) {
                        $(this).click();
                    }
                }
                //console.log($(this).text());
            });

        }

        function search_text(s, text) {
            if (text.match(s)) return true;
        }
    </script>
    <?php include $this->template('footer', 'core'); ?>