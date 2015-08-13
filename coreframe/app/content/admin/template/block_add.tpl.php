<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body xmlns="http://www.w3.org/1999/html">
<script type="text/javascript" src="<?php echo R;?>js/ueditor/ueditor.config.js"></script><script type="text/javascript" src="<?php echo R;?>js/ueditor/ueditor.all.min.js"></script>
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>

                <div class="panel-body">
                    <form class="form-horizontal tasi-form" method="post" action="">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">类型</label>
                            <div class="col-sm-8 input-group">
                                <label class="radio-inline"><input name="type" type="radio" value="1"  onclick="change_type(this.value);"> 列表</label>
                                <label class="radio-inline"><input name="type" type="radio" value="2" onclick="change_type(this.value);" checked> 代码</label>
                                    <label class="radio-inline"><input name="type" type="radio" value="3" onclick="change_type(this.value);"> RSS</label>
                                        <label class="radio-inline"><input name="type" type="radio" value="4" onclick="change_type(this.value);"> JSON</label>
                                            <label class="radio-inline"><input name="type" type="radio" value="5" onclick="change_type(this.value);" disabled> RPC</label>
                                <label class="radio-inline"><input name="type" type="radio" value="6" onclick="change_type(this.value);" disabled> 自定义列表</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">名称</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="form[name]" color="#000000" datatype="*"  errormsg="请输入标题">
                            </div>
                        </div>
                        <div class="form-group hide" id="models">
                            <label class="col-sm-2 col-xs-4 control-label">绑定模型</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <?php echo WUZHI_form::select(key_value($models,'modelid','name'), 0, 'name="modelid" class="form-control "', '--不限模型--');?>
                            </div>
                        </div>
                        <div class="form-group hide" id="rssid">
                            <label class="col-sm-2 col-xs-4 control-label">RSS源</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="form[rssurl]" color="#000000" datatype="url|*0-100"  errormsg="请输入正确的网址！">
                            </div>
                        </div>
                        <div class="form-group hide" id="jsonid">
                            <label class="col-sm-2 col-xs-4 control-label">JSON源</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="form[jsonurl]" color="#000000" datatype="url|*0-100"  errormsg="请输入正确的网址">
                            </div>
                        </div>
                        <div class="form-group hide" id="template_codeid">
                            <label class="col-sm-2 col-xs-4 control-label">模版</label>
                            <div class="col-sm-8 input-group">
                                <textarea type="text" class="form-control" name="form[template_code]" rows="6">
                                {wz:content action="block" pagesize="10" #wz#}
                                <ul>
                                {loop $rs $r}
                                    <li>{$r["title"]}</li>
                                {/loop}
                                </ul>
                                {/wz}
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group " id="codeid">
                            <label class="col-sm-2 col-xs-4 control-label">代码</label>
                            <div class="col-sm-8 input-group">
                                <textarea name="form[code]" id="code"><?php echo $r['code'];?></textarea>
                                <br>

                                <div class="alert alert-info fade in">
                                    <strong>使用技巧:</strong> 编辑器会自动在代码中增加段落 &lt;P&gt;&lt;/P&gt;，可通过切换为文本框来输入。 <p id="destroy"  onclick="destroy()" class="btn btn-xs btn-inverse"> 切换为文本框</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">生成静态列表</label>
                            <div class="col-sm-8 input-group">
                                <label class="radio-inline"><input name="createhtml" type="radio" value="1" checked> 是 － 生成html页面</label>
                                <label class="radio-inline"><input name="createhtml" type="radio" value="0"> 否 （通用标签不受此限制可调用）</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">使用云端ID</label>
                            <div class="col-sm-8 input-group">
                                <label class="radio-inline"><input name="isopenid" type="radio" value="1" > 是</label> （如果需要对外发布该内容，请选择该项，<a href="?m=core&f=set&v=safe<?php echo $this->su();?>">配置安全识别码</a>）
                                <label class="radio-inline"><input name="isopenid" type="radio" value="0" checked> 否 </label>
                            </div>
                        </div>

                        <div class="form-group">
                        <label class="col-sm-2 col-xs-4 control-label"></label>
                        <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                            <input type="hidden" name="codetype" id="codetype" value="1">
                            <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                        </div>
                        </div>

                    </form>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
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
        if(value==1) {
            $("#rssid").addClass("hide");
            $("#jsonid").addClass("hide");
            $("#template_codeid").removeClass("hide");
            $("#models").removeClass("hide");
            $("#codeid").addClass("hide");
        } else if(value==2) {
            $("#rssid").addClass("hide");
            $("#jsonid").addClass("hide");
            $("#template_codeid").addClass("hide");
            $("#models").addClass("hide");
            $("#codeid").removeClass("hide");
        } else if(value==3) {
            $("#rssid").removeClass("hide");
            $("#jsonid").addClass("hide");
            $("#template_codeid").removeClass("hide");
            $("#models").addClass("hide");
            $("#codeid").addClass("hide");
        } else if(value==4) {
            $("#rssid").addClass("hide");
            $("#jsonid").removeClass("hide");
            $("#template_codeid").removeClass("hide");
            $("#models").addClass("hide");
            $("#codeid").addClass("hide");
        }
    }
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3
        });
    })

</script>

