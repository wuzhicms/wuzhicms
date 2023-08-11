<?php
   /**
    * 推荐位添加模板
    */
    defined('IN_WZ') or exit('No direct script access allowed');
    include $this->template('header', 'core');
?>
<body>
<link rel="stylesheet" href="<?php echo R;?>libs/CodeMirror/lib/codemirror.css"/>
<link rel="stylesheet" href="<?php echo R;?>libs/CodeMirror/theme/wuzhicms.css"/>
<script src="<?php echo R;?>libs/CodeMirror/lib/codemirror.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/addon/selection/active-line.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/addon/fold/xml-fold.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/addon/edit/matchtags.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/addon/edit/closebrackets.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/addon/display/fullscreen.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/addon/edit/closetag.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/addon/fold/foldcode.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/addon/fold/foldgutter.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/addon/fold/brace-fold.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/addon/fold/comment-fold.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/addon/dialog/dialog.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/addon/search/jump-to-line.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/addon/scroll/annotatescrollbar.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/addon/search/matchesonscrollbar.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/addon/search/searchcursor.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/addon/search/match-highlighter.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/mode/php/php.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/mode/xml/xml.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/mode/javascript/javascript.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/mode/css/css.js"></script>
<script src="<?php echo R;?>libs/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>
<section class="wrapper">
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']); ?>
        <div class="bg-light py-2 px-3">添加</div>
        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">类型</label>
                    <div class="col-auto d-flex align-items-center pt-2">
                        <div class="form-check me-3 form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="flexRadioDefault1" value="1"  onclick="change_type(this.value);">
                            <label class="form-check-label" for="flexRadioDefault1">列表</label>
                        </div>
                        <div class="form-check me-3 form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="flexRadioDefault2" value="2"  onclick="change_type(this.value);" checked>
                            <label class="form-check-label" for="flexRadioDefault2">代码</label>
                        </div>
                        <div class="form-check me-3 form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="flexRadioDefault3" value="3"  onclick="change_type(this.value);">
                            <label class="form-check-label" for="flexRadioDefault3">RSS</label>
                        </div>
                        <div class="form-check me-3 form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="flexRadioDefault4" value="4"  onclick="change_type(this.value);">
                            <label class="form-check-label" for="flexRadioDefault4">JSON</label>
                        </div>
                        <div class="form-check me-3 form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="flexRadioDefault5" value="5"  onclick="change_type(this.value);" disabled>
                            <label class="form-check-label" for="flexRadioDefault5">RPC</label>
                        </div>
                        <div class="form-check me-3 form-check-inline">
                            <input class="form-check-input" type="radio" name="type" id="flexRadioDefault6" value="6"  onclick="change_type(this.value);" disabled>
                            <label class="form-check-label" for="flexRadioDefault6">自定义列表</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">名称</label>
                    <div class="col-5">
                        <input type="text" class="form-control" name="form[name]" datatype="*" errormsg="请输入标题">
                    </div>
                </div>
                <div class="mb-3 row hide" id="models">
                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">绑定模型</label>
                    <div class="col-5">
                        <?php echo WUZHI_form::select(key_value($models, 'modelid', 'name'), 0, 'name="modelid" class="form-select "', '--不限模型--'); ?>
                    </div>
                </div>
                <div class="mb-3 row hide" id="rssid">
                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">RSS源</label>
                    <div class="col-5">
                        <input type="text" class="form-control" name="form[rssurl]" datatype="url|*0-100" errormsg="请输入正确的网址！">
                    </div>
                </div>
                <div class="mb-3 row hide" id="jsonid">
                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">JSON源</label>
                    <div class="col-5">
                        <input type="text" class="form-control" name="form[jsonurl]" datatype="url|*0-100" errormsg="请输入正确的网址">
                    </div>
                </div>
                <div class="mb-3 row" id="template_codeid">
                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">模版</label>
                    <div class="col-auto">
                        <textarea type="text" class="form-control" id="template_code" name="form[template_code]" rows="12">
{wz:content action="block" pagesize="10" #wz#}
<ul>
{loop $rs $r}
    <li>{$r["title"]}</li>
{/loop}
</ul>
{/wz}
                    </textarea>
                        <span class="help-block"><i class="icon-info-circle"></i> F11按键: 全屏编辑； ESC: 取消全屏； Ctrl+G: 跳至指定行；Ctrl+Z: 撤销；Tab: 向右缩进；Shift+Tab: 向左缩进；</span>
                    </div>
                </div>
                <div class="mb-3 row " id="codeid">
                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">代码</label>
                    <div class="col-5">
                        <textarea name="form[code]" id="code" class="form-control" rows="12"><?php echo $r['code']; ?></textarea>
                        <div class="alert alert-info fade in">
                            <strong>使用技巧:</strong> 编辑器会自动在代码中增加段落 &lt;P&gt;&lt;/P&gt;，可通过切换为文本框来输入。 <p id="destroy" onclick="destroy()" class="btn btn-sm btn-xs btn-inverse"> 切换为文本框</p>
                        </div>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">生成静态列表</label>
                    <div class="col-auto d-flex align-items-center pt-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="createhtml" id="inlineRadio1" value="1" <?php if($r['createhtml']==1) echo "checked";?>>
                            <label class="form-check-label" for="inlineRadio1">是 － 生成html页面</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="createhtml" id="inlineRadio0" value="0" <?php if($r['createhtml']==0) echo "checked";?>>
                            <label class="form-check-label" for="inlineRadio0">否 （通用标签不受此限制可调用）</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end"></label>
                    <div class="col-5">
                        <input type="hidden" name="codetype" id="codetype" value="1">
                        <input class="btn btn-info px-5" type="submit" name="submit" value="提交">
                    </div>
                </div>

            </form>
        </div>
    </section>
 </section>
<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("template_code"), {
        mode: "text/html",
        theme: "wuzhicms",  //设置主题
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
</script>
    <script type="text/javascript">
        var editor = UE.getEditor('code');

        function destroy(){
            editor.destroy();
            editor = null;
            $("#codetype").val("0");
            var button = document.getElementById("destroy");
            $("#destroy").html("切换为编辑器");

            button.onclick = function(){
                editor = UE.getEditor('code');
                $("#destroy").html("切换为文本框");
                $("#codetype").val("1");
                this.onclick = destroy;

            }
        }

        function change_type(value) {
            if (value == 1) {
                $("#rssid").addClass("hide");
                $("#jsonid").addClass("hide");
                $("#template_codeid").removeClass("hide");
                $("#models").removeClass("hide");
                $("#codeid").addClass("hide");
            } else if (value == 2) {
                $("#rssid").addClass("hide");
                $("#jsonid").addClass("hide");
                $("#template_codeid").addClass("hide");
                $("#models").addClass("hide");
                $("#codeid").removeClass("hide");
            } else if (value == 3) {
                $("#rssid").removeClass("hide");
                $("#jsonid").addClass("hide");
                $("#template_codeid").removeClass("hide");
                $("#models").addClass("hide");
                $("#codeid").addClass("hide");
            } else if (value == 4) {
                $("#rssid").addClass("hide");
                $("#jsonid").removeClass("hide");
                $("#template_codeid").removeClass("hide");
                $("#models").addClass("hide");
                $("#codeid").addClass("hide");
            }
        }
        $(function() {
            $(".form-horizontal").Validform({
                tiptype: 3
            });
        })
    </script>
    <?php include $this->template('footer', 'core'); ?>