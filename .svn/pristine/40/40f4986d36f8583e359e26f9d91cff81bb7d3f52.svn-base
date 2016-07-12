<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>

<body>

<section class="wrapper">
<div class="panel tasks-widget">
<header>
<?php echo $this->menu($GLOBALS['_menuid']);?>
</header>


<div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
		<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('tag');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" name="tag[tag]" id="tag" class="form-control" value="<?php echo output($tag_info,'tag');?>"<?php if($tid):?> readonly<?php endif;?> />
					<?php if($tid):?>
					<input type="checkbox" name="is_edit" value="1" onchange="$(this).is(':checked') ? $('#tag').removeAttr('readonly') : $('#tag').attr('readonly','readonly');" /><?php echo L('edit_tag');?>
					<?php endif;?>
                </div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('tag_title');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" name="tag[title]" class="form-control" id="title" value="<?php echo output($tag_info,'title');?>" />
                </div>
            </div>

				<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('tag_keyword');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" name="tag[keyword]" class="form-control" id="keyword" value="<?php echo output($tag_info,'keyword');?>" />
                </div>
            </div>

				<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('tag_desc');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <textarea class="form-control" name="tag[desc]" id="desc"  cols="80" rows="5"><?php echo output($tag_info,'desc');?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('isshow');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><label class="radio-inline"><input type="radio" name="tag[isshow]" value="1" <?php echo output($tag_info,'isshow') == 1 || !$tid ? 'checked' : '';?>><?php echo L('yes');?> </label> <label class="radio-inline"><input type="radio" name="tag[isshow]" value="0" <?php echo output($tag_info,'isshow') == 0 && $tid ? 'checked' : '';?>> <?php echo L('no');?> <?php echo L('isshow_tips');?></label></div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('tag_type');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <?php echo linkage(output($this->_cache,'linkage'),'tag[linkage]');?>
                </div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('pinyin');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" name="tag[pinyin]" class="form-control" id="pinyin" value="<?php echo output($tag_info,'pinyin');?>" placeholder="<?php echo L('empty_tips');?>" />
                </div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('letter');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" name="tag[letter]" class="form-control" placeholder="<?php echo L('empty_tips');?>" id="letter" value="<?php echo output($tag_info,'letter');?>" />
                </div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('url');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" name="tag[url]" class="form-control" id="url" value="<?php echo output($tag_info,'url');?>" placeholder="<?php echo L('empty_tips');?>" />
					<?php if($tid):?><a href="<?php echo WEBURL.output($tag_info,'url');?>" target="_blank"><?php echo L('view_tag');?></a><?php endif;?>
                </div>
            </div>


             <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="<?php echo L('submit');?>">
                </div>
            </div>

        </form>
    </div>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>