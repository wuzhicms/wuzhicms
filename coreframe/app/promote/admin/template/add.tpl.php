<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
$menu_r = $this->db->get_one('menu',array('m'=>'promote','f'=>'index','v'=>'listing'));
$submenuid = $menu_r['menuid'];
?>
<body class="body pxgridsbody">
<section class="wrapper">
<div class="row">
<div class="col-lg-12">
<section class="panel">
    <?php echo $this->menu($submenuid,"&pid=$pid");?>

    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">广告名称</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[title]" datatype="*2-80" errormsg="至少2个字符,最多80个字符！"></div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">广告子标题</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[subtitle]">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">关键字</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[keywords]" >
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">类型</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <label class="radio-inline">
                        <input type="radio" name="form[template]" value="show_pic" checked="" onclick="change_radio(this.value)">图片
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="form[template]" value="show_video" onclick="change_radio(this.value)">视频
                    </label>

                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">图片地址</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <div class="input-group"><?php echo $form->attachment('gif|jpg|png','1','form[file]','','callback_thumb_dialog',0);?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">小图地址</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <div class="input-group"><?php echo $form->attachment('gif|jpg|png','1','form[icon]','','callback_thumb_dialog',0);?></div>
                </div>
            </div>
            <div class="form-group" id="url_div">
                <label class="col-sm-2 col-xs-4 control-label">链接地址</label>
                <div class="col-lg-3 col-sm-6 col-xs-6 input-group">
                    <div class="input-group"><?php echo $form->attachment('gif|jpg|png|mp4|3gp|mp3|apk','1','form[url]','','callback_thumb_dialog',0);?></div>
                </div>
            </div>
            <div class="form-group" id="url_div">
                <label class="col-sm-2 col-xs-4 control-label">上线时间</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <div class="input-group"><?php echo WUZHI_form::calendar('starttime',date('Y-m-d 00:00:00'),1);?></div>
                </div>
            </div>
            <div class="form-group" id="url_div">
                <label class="col-sm-2 col-xs-4 control-label">下线时间</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <div class="input-group"><?php echo WUZHI_form::calendar('endtime',date('Y-m-d 23:59:59',SYS_TIME+86400*365),1);?></div>
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
    function change_radio(type) {
        if(type=='show_app') {

        }
    }
</script>

