<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<style type="text/css">
    .table_form td{
        padding: 10px;
    }
</style>
<section class="wrapper">
    <!-- page start-->

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>
                <div class="panel-body">
                 <form class="form-horizontal tasi-form" method="post" action="">


    <div id="myTabContent" class="tab-content">
      <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">上级城市</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <?php echo $r['name'];?>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">名称|拼音</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">

                                <div id="batch_add">
                                    <textarea class="form-control" maxlength="255" style="height:60px;" datatype="*" errormsg="请输入栏目名称" onblur="set_category(this.value)"></textarea><span class="Validform_checktip"></span><br>例如：<font color="#959595"><br>海淀区|haidian<br>昌平区|changping<br></font>竖线以及后面的英文名可留空，默认会自动生成区域的拼音
                                </div>
                                <span id="new_category"></span>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label"></label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
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
$(function(){
    $(".form-horizontal").Validform({
        tiptype:3
    });
})
function set_category(value) {
	if(value=='') return false;
	$("#batch_add").css('display','none');
	arr=value.split("\n");
	var html='<table class="table_form">';
	for(i=0;i<arr.length;i++){
		html+="<tr>";
		vas=arr[i].split("|");
		html+="<td><input name='catname[]' class='form-control' value='"+vas[0]+"'></td>";
		if("undefined" == typeof vas[1]) {
			vas[1]='';
		}
		html+="<td><input name='catdir[]' class='form-control' value='"+vas[1]+"'></td>";
		html+="</tr>";
	}
    if(i>1) $("#domain-div").remove();
	html+="</table>"
	$("#new_category").append(html);
}

function htmlit(value,id) {
    $("#"+id).val(value);
}
</script>
