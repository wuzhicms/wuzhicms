<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">广告名称</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[title]" datatype="*2-60" errormsg="别名至少2个字符,最多60个字符！">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">广告子标题</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[subtitle]">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">关键字</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[keywords]" >
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">类型</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6 d-flex align-items-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[template]" id="show_pic" value="show_pic" checked="" onclick="change_radio(this.value)">
                            <label class="form-check-label" for="show_pic">图片</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="form[template]" id="show_video" value="show_video" checked="" onclick="change_radio(this.value)">
                            <label class="form-check-label" for="show_video">视频</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">图片地址</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <div class="upload-picture-card"><?php echo $form->attachment('gif|jpg|png','1','form[file]','');?></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">小图地址</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <div class="upload-picture-card"><?php echo $form->attachment('gif|jpg|png','1','form[icon]','');?></div>
                    </div>
                </div>
                <div class="row mb-3" id="url_div">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">链接地址</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="form[url]">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">选择广告位</label>
                    <div class="col-10">
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th class="tablehead"><input type="checkbox" class="form-check-input" id="check_box" onclick="checkall('selectAll',this);"></th>
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
                                    <td><input type="checkbox" class="form-check-input" name="pids[]" value="<?php echo $r['pid'];?>"></td>
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
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input class="btn btn-info w-100" type="submit" name="submit" value="提交">
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
</script>
<?php include $this->template('footer','core');?>