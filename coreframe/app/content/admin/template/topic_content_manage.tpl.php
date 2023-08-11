<?php
/**
 * 专题管理模板
 */
defined('IN_WZ') or exit('No direct script access allowed');
include $this->template('header', 'core');
?>
<body>
<section class="wrapper">
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']); ?>
        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">所属专题</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <?php
                        echo $form->select($options, $data['tid'], 'name="form[tid]" class="form-select" onchange="change_topic_tid(this.value)"', '请选择');
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label">专题子分类</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                        <?php
                        echo $form->select($options2, $data['kid2'], 'name="form[kid2]" id="kid2" class="form-select"');
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 col-xs-4 control-label"></label>
                    <div class="col-lg-3 col-sm-8 col-xs-8 input-group">
                        <input class="btn btn-info col-sm-6 col-xs-6" type="submit" name="submit" value="确认">&nbsp;&nbsp;&nbsp;
                        <input class="btn btn-primary col-sm-4 col-xs-4" type="button" value="清除选择" onclick="clean_topic()">
                    </div>
                </div>
            </form>
        </div>

        </div>
</section>
	<script type="text/javascript">
		function change_topic_tid(kid) {
			$.getJSON("/api/index.php?m=topic&f=gettype&tid=" + kid, function(data) {
				if (data.total != 0) {
					$("#kid2").empty();
				} else {
					$("#kid2").empty();
					$("#kid2").append("<option value=''>没有子分类</option>");
				} //清空下拉框
				$.each(data['lists'], function(index, value) {
					$("#kid2").append("<option value='" + value.kid + "'>" + value.name + "</option>");
				});
			});
		}
		function clean_topic() {
			var dialog = top.dialog.get(window);
			dialog.close("0~").remove();
		}
	</script>
<?php include $this->template('footer', 'core'); ?>
