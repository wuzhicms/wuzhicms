<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
$show_dialog = true;
include $this->template('header','core');
?>
<body>
<section class="wrapper">
	<div class="panel">
	<header><?php echo $this->menu($GLOBALS['_menuid']);?></header>
	<div class="p-3 d-flex">
        <form action="" method="get" target="_self" class="d-flex align-items-center">
        <input type="hidden" name="m" value="<?php echo M;?>" />
        <input type="hidden" name="f" value="<?php echo F;?>" />
        <input type="hidden" name="v" value="<?php echo V;?>" />
        <input type="hidden" name="_su" value="<?php echo _SU;?>" />
        <input type="hidden" name="_menuid" value="<?php echo $GLOBALS['_menuid'];?>" />
        <input type="hidden" name="_submenuid" value="<?php echo $GLOBALS['_submenuid'];?>" />
        <input type="hidden" name="dosearch" value="1" />
        <div class="align-items-center d-flex">
            <div class="input-group me-3">
                <span class="input-group-text">上传时间：</span>
                <?php echo WUZHI_form::calendar('start',$GLOBALS['start'],1);?>
                <span class="input-group-text">-</span>
                <?php echo WUZHI_form::calendar('end',$GLOBALS['end'],1);?>
            </div>
            <div class="input-group me-3 w-50">
                <span class="input-group-text" id="basic-addon1">上传人：</span>
                <input type="text" class="uploaduser form-control" value="<?php echo $GLOBALS['userid'];?>" name="userid">
            </div>
            <div class="input-group me-3 w-50">
                <span class="input-group-text" id="basic-addon1">文件名：</span>
                <input type="text" class="filename form-control" value="<?php echo $GLOBALS['name'];?>" name="name">
            </div>
            <div class="input-group me-3 w-50">
                <span class="input-group-text" id="basic-addon1">Tags：</span>
                <input type="text"  class="tags form-control" value="<?php echo $GLOBALS['tags'];?>" name="tags">
            </div>
        </div>

        <div class="input-group w-auto">
            <?php
            $options['0'] = '排序规则';
            $options['1'] = '文件从大到小';
            $options['2'] = '文件从小到大';
            $options['3'] = '上传时间倒序';
            $options['4'] = '上传时间正序';
            echo WUZHI_form::select( $options, isset($GLOBALS['order']) ? intval($GLOBALS['order']) : '' , 'name="order" class="form-select" ');?>
            <button type="submit" class="btn btn-info btn-sm px-3">搜索</button>
        </div>

		</form>
        
	</div>
<div class="panel-body" id="panel-bodys">
	<form name="myform" id="myform" method="post" action="?m=attachment&f=index&v=listing<?php echo $this->su();?>">
<table class="table table-striped table-advance table-hover">
	<thead>
	    <tr>
			<th class="tablehead" >选择</th>
			<th class="tablehead w-50">文件名</th>
            <th class="tablehead">文件夹</th>
            <th class="tablehead">大小</th>
            <th class="tablehead">上传时间</th>
            <th class="tablehead"></i>上传用户</th>
            <th class="tablehead">操作</th>
	    </tr>
    </thead>
    <tbody>
    <?php
    foreach($lists AS $k=>$v)
    {
    ?>
          <tr><td class="center"><input type="checkbox" class="form-check-input" name="id[]" value="<?php echo $v['id'];?>"></td>
          <td class="hidden-phone"><a target="_blank" href="<?php echo $v['path'];?>" title="<?php echo L('look_big');?>:<?php echo $v['name'];?>">
          <?php if($this->_cache['show_mode'] == 2 && in_array( fileext($v['path']),array('jpg','jpeg','png','gif','bmp') ) ):?><img src="<?php echo $v['path'];?>" height="60" /> <?php endif;?><?php echo $v['name'];?></a></td>
              <td><?php echo $v['diycat'];?></td>
          <td><?php echo filesize_format($v['filesize']);?></td>
          <td><?php echo time_format($v['addtime']);?></td>
          <td><?php echo $v['username'];?></td>
          <td>
        <a href="javascript:makedo('<?php echo link_url( array('v'=>'del','id'=>$v['id']) );?>', '<?php echo L('confirm_del');?>')" class="btn btn-danger btn-sm btn-xs">删除</a>
          </td>
          </tr>
    <?php } ?>
        </tbody>
    </table>
        <div class="panel-foot">
            <div class="d-flex justify-content-between align-items-center">
                <div class="panel-label">
                    <input id="v" name="v" type="hidden" value="<?php echo V;?>">
                    <button type="button" onClick="checkall()" name="submit2" class="btn btn-default btn-sm">全选/反选</button>
                    <button type="submit" onclick="$('#v').val('del')" class="btn btn-default btn-sm">批量删除</button>
                </div>
                <div class="panel-label">
                    <ul class="pagination pagination-sm">
                        <?php echo $pages;?>
                    </ul>
                </div>
            </div>
        </div>
	</form>
        </div>
		<div class="alert alert-success fade in">
			<strong>重要提示:</strong> 上传的所有文件会后，会自动建立md5file，即，您上传重复文件不会保存多份。
		</div>
</div>
</section>
<script src="<?php echo R;?>libs/jquery/jquery.tagsinput.js"></script>
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
</script>
<?php include $this->template('footer','core');?>