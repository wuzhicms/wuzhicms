<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
<section class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>
    <table class="table table-striped table-advance table-hover">
        <thead>
        <tr>
            <th class="hidden-phone tablehead">修改工作流</th>
        </tr>
        </thead>
    </table>
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">工作流名称</label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="text" class="form-control" name="name" value="<?php echo $data['name'];?>" datatype="*2-30" errormsg="别名至少2个字符,最多20个字符！">
                </div>
            </div>
			<div class="mb-3 row">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">审核次数（层级）</label>
				<div class="col-lg-3 col-sm-4 col-xs-4">
					 <select name="level" class="form-select" onchange="set_level(this.value);">
					<option value="1" <?php if($data['level']==1) echo 'selected';?>>1</option>
					<option value="2" <?php if($data['level']==2) echo 'selected';?>>2</option>
					<option value="3" <?php if($data['level']==3) echo 'selected';?>>3</option>
					<option value="4" <?php if($data['level']==4) echo 'selected';?>>4</option>
					 </select>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">一层名称</label>
				<div class="col-lg-3 col-sm-4 col-xs-4">
					<input type="text" class="form-control" name="level1_name" value="<?php echo $data['level1_name'];?>" datatype="*2-30" errormsg="至少2个字符,最多40个字符！">
				</div>
			</div>
			<div class="mb-3 row level0 level1_name">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">二层名称</label>
				<div class="col-lg-3 col-sm-4 col-xs-4">
					<input type="text" class="form-control" name="level2_name" value="<?php echo $data['level2_name'];?>" datatype="*2-30" errormsg="至少2个字符,最多40个字符！">
				</div>
			</div>
			<div class="mb-3 row level0 level1_name level2_name">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">三层名称</label>
				<div class="col-lg-3 col-sm-4 col-xs-4">
					<input type="text" class="form-control" name="level3_name" value="<?php echo $data['level3_name'];?>" datatype="*2-30" errormsg="至少2个字符,最多40个字符！">
				</div>
			</div>
			<div class="mb-3 row level0 level1_name level2_name level3_name">
				<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">四层名称</label>
				<div class="col-lg-3 col-sm-4 col-xs-4">
					<input type="text" class="form-control" name="level4_name" value="<?php echo $data['level4_name'];?>" datatype="*2-30" errormsg="至少2个字符,最多40个字符！">
				</div>
			</div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4">
                    <input type="hidden" name="forward" value="<?php echo HTTP_REFERER;?>">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                </div>
            </div>

        </form>
    </div>
</section>
<!-- page end-->
</section>
<script type="text/javascript">
    function set_level(level) {
        $('.level0').css('display','');
        $('.level'+level+'_name').css('display','none');
    }
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3,
            ignoreHidden:true
        });
        set_level(<?php echo $data['level'];?>);
    })

</script>
<?php include $this->template('footer','core');?>

