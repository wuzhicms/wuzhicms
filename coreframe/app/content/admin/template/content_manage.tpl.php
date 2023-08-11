<?php
/**
 * 内容管理封面模板
 */
defined('IN_WZ') or exit('No direct script access allowed');
include $this->template('header', 'core');
?>

<body class="body">
    <section id="iframecontent" class="d-flex">
        <section class="treelistframe">
            <iframe width="210" name="treemain" id="treemain" frameborder="false" scrolling="auto" height="auto" allowtransparency="true" frameborder="0" src="?m=content&f=content&v=left&modelid=<?php echo $modelid . '&type=' . $GLOBALS['type'] . $this->su(); ?>"></iframe>
        </section>
        <section id="iframecontent">
            <iframe width="100%" name="iframeid" id="iframeid" frameborder="false" scrolling="auto" height="auto" allowtransparency="true" frameborder="0" src="?m=content&f=content&v=listing&<?php echo $modelid . $this->su(); ?>"></iframe>
        </section>
    </section>
    <?php include $this->template('footer', 'core'); ?>
    <script type="text/javascript">
        var iframeWindowSize = function() {
            return ["Height", "Width"].map(function(name) {
                return window["inner" + name] || document.compatMode === "CSS1Compat" && document.documentElement["client" + name] || document.body["client" + name]
            })
        }
        window.onload = function() {
            if (!+"\v1" && !document.querySelector) {
                document.body.onresize = iframeresize
            } else {
                window.onresize = iframeresize
            }

            function iframeresize() {
                iframeSize();
                return false
            }
        }

        function iframeSize() {
            var str = iframeWindowSize();
            var pxstrs = [];
            iframestrs = str.toString().split(",");
            var heights = iframestrs[0] - 20,
                Body = $('body');
            $('#iframeid').height(heights);
            if (iframestrs[1] < 980) {
                Body.attr('scroll', '');
                Body.removeClass('pxgridsbody')
            } else {
                Body.attr('scroll', 'no');
                Body.addClass('pxgridsbody')
            }
            var sidebar = $("#iframeid").height() - 20;
            $('#treemain').height(sidebar + 35);
            $('#iframeid').height(sidebar + 35);
            iframeWindowSize();
        }
        iframeSize();
    </script>
