<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
$menu_r = $this->db->get_one('menu',array('m'=>'promote','f'=>'index','v'=>'listing'));
$submenuid = $menu_r['menuid'];
?>
<body>
<section class="wrapper">
    <section class="panel">
        <?php echo $this->menu($submenuid,"&pid=$pid");?>
        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">广告名称</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[title]" datatype="*2-60" errormsg="别名至少2个字符,最多60个字符！" value="<?php echo $r['title'];?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">广告子标题</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[subtitle]" value="<?php echo $r['subtitle'];?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">关键字</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[keywords]" value="<?php echo $r['keywords'];?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">类型</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6 d-flex align-items-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[template]" id="show_pic" value="show_pic" checked="" onclick="change_radio(this.value)" <?php if($r['template']=='show_pic') echo 'checked';?>>
                            <label class="form-check-label" for="show_pic">图片</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[template]" id="show_video" value="show_video" onclick="change_radio(this.value)" <?php if($r['template']=='show_video') echo 'checked';?>>
                            <label class="form-check-label" for="show_video">视频</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">图片地址</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <div class="input-group"><?php echo $form->attachment('gif|jpg|png','1','form[file]',$r['file'],'callback_thumb_dialog',0);?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">小图地址</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <div class="input-group"><?php echo $form->attachment('gif|jpg|png','1','form[icon]',$r['icon'],'callback_thumb_dialog',0);?></div>
                    </div>
                </div>
                <div class="row mb-3" id="url_div">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">链接地址</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" value="<?php echo $r['url'];?>" name="form[url]">
                    </div>
                </div>
                <div class="row mb-3" id="url_div">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">上线时间</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <div class="input-group"><?php echo WUZHI_form::calendar('starttime',$starttime,1);?></div>
                    </div>
                </div>
                <div class="row mb-3" id="url_div">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">下线时间</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <div class="input-group"><?php echo WUZHI_form::calendar('endtime',$endtime,1);?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="hidden" name="forward" value="<?php echo HTTP_REFERER;?>">
                        <input class="btn btn-info col-lg-12 col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- page end-->
</section>
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
    <?php
        echo "change_radio('".$r['template']."');"
 ?>
</script>
<?php include $this->template('footer','core');?>