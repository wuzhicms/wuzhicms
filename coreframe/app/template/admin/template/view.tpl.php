<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<link rel="stylesheet" href="<?php echo R;?>static/CodeMirror/lib/codemirror.css"/>
<link rel="stylesheet" href="<?php echo R;?>static/CodeMirror/theme/wuzhicms.css"/>
<script src="<?php echo R;?>static/CodeMirror/lib/codemirror.js"></script>
<script src="<?php echo R;?>static/CodeMirror/addon/selection/active-line.js"></script>
<script src="<?php echo R;?>static/CodeMirror/addon/fold/xml-fold.js"></script>
<script src="<?php echo R;?>static/CodeMirror/addon/edit/matchtags.js"></script>
<script src="<?php echo R;?>static/CodeMirror/addon/edit/closebrackets.js"></script>
<script src="<?php echo R;?>static/CodeMirror/addon/display/fullscreen.js"></script>
<script src="<?php echo R;?>static/CodeMirror/addon/edit/closetag.js"></script>
<script src="<?php echo R;?>static/CodeMirror/addon/fold/foldcode.js"></script>
<script src="<?php echo R;?>static/CodeMirror/addon/fold/foldgutter.js"></script>
<script src="<?php echo R;?>static/CodeMirror/addon/fold/brace-fold.js"></script>
<script src="<?php echo R;?>static/CodeMirror/addon/fold/comment-fold.js"></script>
<script src="<?php echo R;?>static/CodeMirror/addon/dialog/dialog.js"></script>
<script src="<?php echo R;?>static/CodeMirror/addon/search/jump-to-line.js"></script>
<script src="<?php echo R;?>static/CodeMirror/addon/scroll/annotatescrollbar.js"></script>
<script src="<?php echo R;?>static/CodeMirror/addon/search/matchesonscrollbar.js"></script>
<script src="<?php echo R;?>static/CodeMirror/addon/search/searchcursor.js"></script>
<script src="<?php echo R;?>static/CodeMirror/addon/search/match-highlighter.js"></script>
<script src="<?php echo R;?>static/CodeMirror/mode/php/php.js"></script>
<script src="<?php echo R;?>static/CodeMirror/mode/xml/xml.js"></script>
<script src="<?php echo R;?>static/CodeMirror/mode/javascript/javascript.js"></script>
<script src="<?php echo R;?>static/CodeMirror/mode/css/css.js"></script>
<script src="<?php echo R;?>static/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>
<body>
<script type="text/javascript" src="<?php echo R;?>js/swfobject.js"></script>
<section class="wrapper">
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <div class="panel-body">
            <div class="d-flex justify-content-between">
                <a href="?m=template&f=index&v=listing&dir=<?php echo $dir.$this->su();?>"><img src="<?php echo R?>images/icon/folder-upload.png" />&nbsp;返回上级目录</a>
                <span>文件路径：<?php echo $dir.'/'.$file.'.html';?></span>
            </div>
            <div class="pt-2"><span class="help-block"><i class="icon-info-circle"></i> F11按键: 全屏编辑； ESC: 取消全屏；</span></div>
            <textarea id="wzhtml" style="display:none"><?php echo $code;?></textarea>
            <div class="pt-2">更新时间：<?php echo time_format($r['addtime']);?></div>
            <script>
                var editor = CodeMirror.fromTextArea(document.getElementById("wzhtml"), {
                    mode: "text/html",
                    theme: "wuzhicms",	//设置主题
                    styleActiveLine: true,  //选中行变色
                    lineNumbers: true,      //行号
                    lineWrapping: true,     //自动换行
                    autoCloseBrackets: true,      //自动闭合括号
                    matchTags: {bothTags: true},  //选中结束标记
                    autoCloseTags: true,          //自动结束标记
                    foldGutter: true,    //折叠
                    gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
                    highlightSelectionMatches: {showToken: /\w/, annotateScrollbar: true},
                    extraKeys: {
                        //F11全屏编辑
                        "F11": function(cm) {
                            cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                        },
                        //ESC退出全屏
                        "Esc": function(cm) {
                            if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                        },
                        //跳至指定行
                        "Ctrl-G": "jumpToLine"
                    }
                });
                editor.setSize('100%', '600px');
            </script>
        </div>
    </section>
    <!-- page end-->
</section>
<?php include $this->template('footer','core');?>
