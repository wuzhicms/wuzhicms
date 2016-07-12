<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
$show_dialog = true;
include $this->template('header','core');
?>

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?php echo R;?>js/jquery.mousewheel-3.0.6.pack.js"></script>
<!-- Add fancyBox -->
<link rel="stylesheet" href="<?php echo R;?>js/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo R;?>js/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="<?php echo R;?>js/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo R;?>js/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?php echo R;?>js/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

<body>
<section class="wrapper">
	<div class="panel mr0">
	<header><?php echo $this->menu($GLOBALS['_menuid']);?></header>
	<header class="panel-heading">
		<form action="" method="get" target="_self" class="form-inline">
		<input type="hidden" name="m" value="<?php echo M;?>" />
		<input type="hidden" name="f" value="<?php echo F;?>" />
		<input type="hidden" name="v" value="<?php echo V;?>" />
		<input type="hidden" name="_su" value="<?php echo _SU;?>" />
		<input type="hidden" name="_menuid" value="<?php echo $GLOBALS['_menuid'];?>" />
		<input type="hidden" name="_submenuid" value="<?php echo $GLOBALS['_submenuid'];?>" />
		<input type="hidden" name="dosearch" value="1" />
		上传时间<?php echo WUZHI_form::calendar('start',$GLOBALS['start'],1);?>- <?php echo WUZHI_form::calendar('end',$GLOBALS['end'],1);?>
		&nbsp;上传人 <input type="text" class="uploaduser" value="<?php echo $GLOBALS['userid'];?>" name="userid">
		&nbsp;文件名 <input type="text" class="filename" value="<?php echo $GLOBALS['name'];?>" name="name">
		&nbsp;Tags <input type="text"  class="tags" value="<?php echo $GLOBALS['tags'];?>" name="tags">
		&nbsp;
		<?php
		$options['0'] = '排序规则';
		$options['1'] = '文件从大到小';
		$options['2'] = '文件从小到大';
		$options['3'] = '上传时间倒序';
		$options['4'] = '上传时间正序';
		echo WUZHI_form::select( $options, isset($GLOBALS['order']) ? intval($GLOBALS['order']) : '' , 'name="order" class="form-control" ');?>
		<button type="submit" class="btn btn-info btn-sm">搜索</button>
		</form>
	</header>


<div class="panel-body" id="panel-bodys">
<table class="table table-striped table-advance table-hover">
	<thead>
	    <tr>
	    <th class="tablehead">文件名</th>
	    <th class="tablehead">文件夹</th>
		<th class="tablehead">大小</th>
	    <th class="tablehead hidden-phone">上传时间</th>
	    <th class="tablehead"></i>上传用户</th>
	    <th class="tablehead">操作</th>
	    </tr>
    </thead>
    <tbody>
<?php
foreach($lists AS $k=>$v)
{
?>
      <tr>
      <td class="hidden-phone"><a href="<?php echo ATTACHMENT_URL.$v['path'];?>" class="fancybox-button" rel="fancybox-button" title="<?php echo L('look_big');?>:<?php echo $v['name'];?>">
	  <?php if($this->_cache['show_mode'] == 2 && in_array( fileext($v['path']),array('jpg','jpeg','png','gif','bmp') ) ):?><img src="<?php echo ATTACHMENT_URL.$v['path'];?>" height="60" /> <?php endif;?><?php echo $v['name'];?></a></td>
          <td><?php echo $v['diycat'];?></td>
	  <td><?php echo filesize_format($v['filesize']);?></td>
      <td><?php echo time_format($v['addtime']);?></td>
      <td><?php echo $v['username'];?></td>
      <td>
<a href="javascript:makedo('<?php echo link_url( array('v'=>'del','id'=>$v['id']) );?>', '<?php echo L('confirm_del');?>')" class="btn btn-danger btn-xs">删除</a>
      </td>
      </tr>
<?php } ?>
    </tbody>
</table>
</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="pull-right">
                        <ul class="pagination pagination-sm mr0">
                            <?php echo $pages;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script src="<?php echo R;?>js/jquery.tagsinput.js"></script>

<script type="text/javascript">
$(function(){	
	$('.tagsinput').tagsInput({
	"width": "300px",
	'height':'42px',
	'minChars':2,
	'onAddTag':function(tag){callback_tags( tag, 1, $(this) )}, //增加标签的回调函数
	'onRemoveTag':function(tag){callback_tags( tag, 2, $(this) )}, //删除标签的回调函数
	});
})

function callback_tags(tag,type,obj)
{
	var att_id = obj.attr('data-id');
	var tags_new = obj.val();//处理过后的新标签内容
	var api = '<?php echo link_url( array('v'=>'tags') );?>';
	
	$.get(api, { tags: tags_new, tag: tag, att_id:att_id, _su:'<?php echo _SU;?>', act_type:type },
	function(data){
		if(data != 1){
			msg = data;
			var d = top.dialog({
			content: msg,
			title: '<?php echo L('tips');?>',
			});
			d.showModal();
			setTimeout(function () {
			d.close().remove();
			}, 2000);
		}
	});
}

$(document).ready(function() {
	$(".fancybox-button").fancybox({
		prevEffect		: 'none',
		nextEffect		: 'none',
		closeBtn		: false,
		helpers		: {
			title	: { type : 'inside' },
			buttons	: {}
		}
	});
})
</script>
</body>
</html>
