<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<meta charset=utf-8"<?php echo CHARSET;?>">
<title>WZCMS后台管理系统</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="" />
<meta name="author" content="Pixel grid studio"  />
<link href="<?php echo R;?>css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo R;?>css/bootstrapreset.css" rel="stylesheet">
<link href="<?php echo R;?>css/pxgridsicons.min.css" rel="stylesheet" />
<link href="<?php echo R;?>css/style.css" rel="stylesheet">
<link href="<?php echo R;?>css/responsive.css" rel="stylesheet" media="screen"/>
<link href="<?php echo R;?>css/animation.css" rel="stylesheet">
<script src="<?php echo R;?>js/jquery.min.js"></script>
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
</head>
<body>
<section class="wrapper">
<div class="col-lg-6">
  <section class="panel">
    <header class="panel-heading">
    	<span>邀请码</span>
        <?php if($setting['invite']) { ?>
        	<button type="button" class="btn btn-info btn-sm" onclick="create()">获取邀请码</button>
        <?php } else { ?>
        	系统未开启邀请注册
        <?php } ?>
    </header>
    <div class="panel-body" id="panel-bodys">
    <table class="table table-striped table-advance table-hover">
      <thead>
        <tr>
          <td>邀请码</td>
          <td>来源</td>
          <td>生成时间</td>
          <td>使用者</td>
          <td>使用时间</td>
        </tr>
      </thead>
      <?php $n=1;if(is_array($infos)) foreach($infos AS $v) { ?>
      <tr>
        <td><?php echo $v['invite'];?></td>
        <td><?php if($v['isbuy']) { ?>购买<?php } else { ?>免费获取<?php } ?></td>
        <td><?php echo date('Y-m-d', $v['createtime']);?></td>
        <td><?php echo $v['usinguser'];?></td>
        <td><?php if($v['usingtime']) { ?><?php echo date('Y-m-d', 	$v['usingtime']);?><?php } ?></td>
      </tr>
      <?php $n++;}?>
    </table>
  </section>
</div>
<script type="text/javascript">
<?php if($setting['invite']) { ?>
function create(){
	<?php if($freenum < 1) { ?>
		<?php if($buynum < 1) { ?>
		alert('您今日的邀请名额已经用完');
		return false;
		<?php } else { ?>
		if(!confirm('您确认花费<?php echo $setting['inviteprice'];?>点购买邀请码吗'))return false;
		<?php } ?>
	<?php } ?>
	$.getJSON('index.php?m=member&f=invite&v=create&rand='+Math.random()+'&callback=?', function(data){
		if(data.error){
			alert(data.msg);
		}else{
			alert('获取成功');	
		}
	});
}
<?php } ?>
</script>
</body>
</html>