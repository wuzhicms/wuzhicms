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
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-phone tablehead">修改</th>
                    </tr>
                    </thead>
                </table>
                <div class="panel-body">
                    <form class="form-horizontal tasi-form" method="post" action="">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">类型</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <label class="radio-inline"><input name="type" type="radio" value="1"  onclick="change_type(this.value);" <?php if($r['type']==1) echo "checked";?>> 列表</label>
                                <label class="radio-inline"><input name="type" type="radio" value="2" onclick="change_type(this.value);" <?php if($r['type']==2) echo "checked";?>> 代码</label>
                                    <label class="radio-inline"><input name="type" type="radio" value="3" onclick="change_type(this.value);" <?php if($r['type']==3) echo "checked";?>> RSS</label>
                                        <label class="radio-inline"><input name="type" type="radio" value="4" onclick="change_type(this.value);" <?php if($r['type']==4) echo "checked";?>> JSON</label>
                                            <label class="radio-inline"><input name="type" type="radio" value="5" onclick="change_type(this.value);" disabled> RPC</label>
                                <label class="radio-inline"><input name="type" type="radio" value="6" onclick="change_type(this.value);" disabled> 自定义列表</label>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">名称</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="form[name]" color="#000000" datatype="*"  errormsg="请输入标题" value="<?php echo $r['name'];?>">
                            </div>
                        </div>
                        <div class="form-group hide" id="models">
                            <label class="col-sm-2 col-xs-4 control-label">绑定模型</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <?php echo WUZHI_form::select(key_value($models,'modelid','name'), $r['modelid'], 'name="modelid" class="form-control "', '--不限模型--');?>
                            </div>
                        </div>
                        <div class="form-group hide" id="rssid">
                            <label class="col-sm-2 col-xs-4 control-label">RSS源</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="form[rssurl]" color="#000000" datatype="url|*0-100"  errormsg="请输入正确的网址！" value="<?php echo $r['url'];?>">
                            </div>
                        </div>
                        <div class="form-group hide" id="jsonid">
                            <label class="col-sm-2 col-xs-4 control-label">JSON源</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="form[jsonurl]" color="#000000" datatype="url|*0-100"  errormsg="请输入正确的网址" value="<?php echo $r['url'];?>">
                            </div>
                        </div>
                        <div class="form-group hide" id="template_codeid">
                            <label class="col-sm-2 col-xs-4 control-label">模版</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <textarea type="text" class="form-control" name="form[template_code]" rows="6">
<?php if($r['type']!=2) echo p_htmlspecialchars($r['code']);?>
</textarea>
                            </div>
                        </div>
                        <div class="form-group " id="codeid">
                            <label class="col-sm-2 col-xs-4 control-label">代码</label>
                            <div class="col-lg-8 col-sm-8 col-xs-8 input-group">
                                <textarea name="form[code]" id="code" style="width:100%;height: 300px;"><?php echo $r['code'];?></textarea>
                                <br>

                                <div class="alert alert-info fade in">
                                    <strong>使用技巧:</strong> 编辑器会自动在代码中增加段落 &lt;P&gt;&lt;/P&gt;，可通过切换为文本框来输入。 <p id="destroy"  onclick="destroy()" class="btn btn-xs btn-inverse"> <?php if($r['codetype']) echo '切换为文本框';else echo '切换为编辑器';?></p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">生成静态列表</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <label class="radio-inline"><input name="createhtml" type="radio" value="1" <?php if($r['createhtml']==1) echo "checked";?>> 是 － 生成html页面</label>
                                <label class="radio-inline"><input name="createhtml" type="radio" value="0" <?php if($r['createhtml']==0) echo "checked";?>> 否 （通用标签不受此限制可调用）</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label"></label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="hidden" name="codetype" id="codetype" value="<?php echo $r['codetype'];?>">
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



<script type="text/javascript" charset="utf-8">
//1 是编辑器。0是文本
<?php
if($r['codetype']) {
echo "var editor = UE.getEditor('code');";}
?>
    function destroy() {

        var codetype = $("#codetype").val();
        codetype = parseInt(codetype);
        if(codetype==1) {
            $("#codetype").val("0");
            $("#destroy").html("切换为文本框");

        } else {
            $("#codetype").val("1");
            $("#destroy").html("切换为编辑器");
        }
        var editor = UE.getEditor('code');
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

        change_type(<?php echo $r['type'];?>);

    })

</script>

