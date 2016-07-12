<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>

                <div class="panel-body" id="formid">
                    <form class="form-horizontal tasi-form" method="post" action="">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">预约卡前缀</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="pre" value="" placeholder="例如：AK （爱康国宾）"  datatype="s0-4" errormsg="最多4个字符">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">生成数量</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input type="text" class="form-control" name="number" value="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">绑定套餐（产品）</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <div class="input-group">
                                    <input type="hidden" name="form[id]" id="relation" value="">
                                    <input type="text" name="relation_search" id="relation_search" class="form-control" style="width: 322px;" readonly datatype="*1-100" nullmsg="请选择套餐">
<span class="input-group-btn pull-left">
<button class="btn btn-white" type="button" onclick="select_content(2)">选择套餐</button>
</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">截至时间</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <?php echo WUZHI_form::calendar('endtime',$endtime);?>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">备注（管理员可见）</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <textarea name="form[admin_note]" class="form-control" cols="60" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">下载－线下发送</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <label class="radio-inline">
                                    <input type="radio" name="download" value="1" >是
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="download" value="0" checked>否
                                </label>
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
    <!-- page end--><div class="alert alert-success fade in hide" id="success">
        <strong>生成成功:</strong> <a href="<?php echo WEBURL;?>/index.php?m=order&f=card&v=listing<?php echo $this->su();?>"> 点击这里返回列表</a>
    </div>
</section>
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:1,
            postonce:true,
            beforeSubmit:function(curform){
                $("#formid").addClass('hide');
                $("#success").removeClass('hide');
            }
        });
    })
    function select_content(modelid) {
        top.dialog({
            id: 'relation',
            fixed: true,
            width: 900,
            height: 530,
            title: '选择内容',
            padding: 5,
            url: '?m=content&f=sundry&v=listing&modelid='+modelid+"<?php echo $this->su();?>",
            onclose: function () {
                if (this.returnValue) {
                    var text=this.returnValue;
                    var htmls = text.split("~wuzhicms~");
                    $("#relation").val(htmls[0]);
                    $("#relation_search").val(htmls[1]);
                }
            }
        }).showModal(this);
    }
</script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>

