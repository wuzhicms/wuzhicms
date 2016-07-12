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

    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">广告名称</label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" class="form-control" name="form[title]" datatype="*2-60" errormsg="别名至少2个字符,最多60个字符！">
                </div>
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
                <div class="col-lg-3 col-sm-6 col-xs-6 input-group">
                    <div class="input-group"><?php echo $form->attachment('gif|jpg|png','1','form[file]','');?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">小图地址</label>
                <div class="col-lg-3 col-sm-6 col-xs-6 input-group">
                    <div class="input-group"><?php echo $form->attachment('gif|jpg|png','1','form[icon]','');?></div>
                </div>
            </div>
            <div class="form-group" id="url_div">
                <label class="col-sm-2 col-xs-4 control-label">链接地址</label>
                <div class="col-lg-3 col-sm-6 col-xs-6 input-group">
                    <div class="input-group"><?php echo $form->attachment('gif|jpg|png|mp4|3gp|mp3|apk','1','form[url]','');?></div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label">选择广告位</label>
                <div class="col-sm-10 input-group" style="border: 1px solid #E9EAEE;">
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>
                            <th class="tablehead"><input type="checkbox" id="check_box" onclick="checkall('selectAll',this);"></th>
                            <th class="tablehead">ID</th>
                            <th class="tablehead">名称</th>
                            <th class="tablehead">尺寸</th>
                            <th class="tablehead">预览</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($result AS $r) {

                            ?>
                            <tr>
                                <td><input type="checkbox" name="pids[]" value="<?php echo $r['pid'];?>"></td>
                                <td><?php echo $r['pid'];?></td>
                                <td><?php echo '<a href="'.$r['url'].'" target="_blank">'.$r['name'];?></a></td>
                                <td>宽：<?php if($r['width']) echo $r['width'].'px';else echo '不限';?>  -- 高：<?php if($r['height']) echo $r['height'].'px';else echo '不限';?></td>
                                <td><a href="?m=promote&f=index&v=view&pid=<?php echo $r['pid'].$this->su();?>" target="_blank">预览</a></td>
                            </tr>
                        <?php
                        }
                        ?>



                        </tbody>
                    </table>
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

