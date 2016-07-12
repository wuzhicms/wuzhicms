<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
$show_dialog = true;
include $this->template('header','core');
?>
<style type="text/css">
div#wz_linkage{display: inline;}
</style>
<body>
<section class="wrapper">
	<div class="panel mr0">
	<header><?php echo $this->menu($GLOBALS['_menuid']);?></header>
	<header class="panel-heading">
		<form action="" class="form-inline" method="get" target="_self">
		<input type="hidden" name="m" value="<?php echo M;?>" />
		<input type="hidden" name="f" value="<?php echo F;?>" />
		<input type="hidden" name="v" value="<?php echo V;?>" />
		<input type="hidden" name="_su" value="<?php echo _SU;?>" />
		<input type="hidden" name="_menuid" value="<?php echo $GLOBALS['_menuid'];?>" />
		<input type="hidden" name="_submenuid" value="<?php echo $GLOBALS['_submenuid'];?>" />
		<input type="hidden" name="dosearch" value="1" />
		创建时间<?php echo WUZHI_form::calendar('start',$GLOBALS['start'],1);?> - <?php echo WUZHI_form::calendar('end',$GLOBALS['end'],1);?>
		&nbsp;Tag <input type="text" size="12" value="<?php echo $GLOBALS['tags'];?>" name="tags">
		&nbsp;
            <div class="input-group"><?php echo linkage(output($this->_cache,'linkage'),'linkage');?></div>
            <div class="input-group"><?php
		$options['0'] = '排序规则';
		$options['1'] = '使用从大到小';
		$options['2'] = '使用从小到大';
		$options['3'] = '创建时间倒序';
		$options['4'] = '创建时间正序';
		echo WUZHI_form::select( $options,  intval( output($GLOBALS,'order') )  , 'name="order" class="form-control"');?>
            </div>
		<button type="submit" class="btn btn-info btn-sm">搜索</button>
		</form>
	</header>


<div class="panel-body" id="panel-bodys">
<table class="table table-striped table-advance table-hover">
	<thead>
	    <tr>
		<th class="tablehead">ID</th>
	    <th class="tablehead">TAG名</th>
		<th class="tablehead">使用次数</th>
	    <th class="tablehead hidden-phone">创建时间</th>
	    <th class="tablehead">拼音</th>
		<th class="tablehead">类别</th>
	    <th class="tablehead"></i>操作</th>
	    </tr>
    </thead>
    <tbody>
<?php
foreach($lists AS $k=>$v)
{
?>
      <tr>
      <td><?php echo $v['tid'];?></td>
      <td class="hidden-phone">
	  <a href="<?php echo WEBURL.$v['url'];?>" target="_blank" title="<?php echo $v['tag'];?>">
	  <?php echo $v['tag'];?></a></td>
	  <td><?php echo $v['number'];?></td>
      <td><?php echo time_format($v['addtime']);?></td>
      <td><span class="label btn-default label-mini"><?php echo $v['pinyin'];?></span></td>
	  <td><span class="label btn-default label-mini"><?php echo $v['linkage'];?></span></td>
      <td>
<a href="<?php echo link_url( array('v'=>'html','tid'=>$v['tid']) );?>" class="btn btn-info btn-xs"><?php echo L('create_html');?></a>
<a href="<?php echo link_url( array('v'=>'add','tid'=>$v['tid']) );?>" class="btn btn-primary btn-xs"><?php echo L('edit');?></a>
<a href="javascript:makedo('<?php echo link_url( array('v'=>'del','tid'=>$v['tid']) );?>', '<?php echo L('confirm_del');?>')" class="btn btn-danger btn-xs"><?php echo L('del');?></a>
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
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script src="<?php echo R;?>js/jquery.tagsinput.js"></script>

<script type="text/javascript">
$(function(){	
	$('.tagsinput').tagsInput({
	"width": "100%",
	'height':'75px',
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
</script>
</body>
</html>
