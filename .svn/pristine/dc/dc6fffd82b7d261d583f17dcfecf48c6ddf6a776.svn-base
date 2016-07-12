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
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('mod_title');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" name="setting[title]" id="title" value="<?php echo output($setting,'title');?>" class="form-control" />
                </div>
            </div>

				<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('mod_keyword');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                   <input type="text" name="setting[keyword]" id="keyword" value="<?php echo output($setting,'keyword');?>" class="form-control" />
                </div>
            </div>

				<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('mod_desc');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <textarea class="form-control" name="setting[desc]" id="desc"  cols="80" rows="5"><?php echo output($setting,'desc');?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('show_mode');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><label class="radio-inline col-sm-4"><input type="radio" name="setting[show_mode]" value="1" <?php echo output($setting,'show_mode') == 1 ? 'checked' : '';?>><?php echo L('strict_mode');?></label> <label class="radio-inline col-sm-8 input-group"><input type="radio" name="setting[show_mode]" value="2" <?php echo output($setting,'show_mode') == 2 ? 'checked' : '';?>><?php echo L('free_mode');?>  <?php echo L('mode_tips');?></label></div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('rewrite');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group"><label class="radio-inline"><input type="radio" name="setting[rewrite]" value="1" <?php echo output($setting,'rewrite') == 1 ? 'checked' : '';?>><?php echo L('yes');?></label> <label class="radio-inline"><input type="radio" name="setting[rewrite]" value="2" <?php echo output($setting,'rewrite') == 2 ? 'checked' : '';?>><?php echo L('no');?>  <?php echo L('rewrite_tips');?></label></div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('tag_type');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <?php echo WUZHI_form::select($linkage, output($setting,'linkage'), $str = ' name="setting[linkage]"  class="form-control" ', L('select_linkage'));?>
                </div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('index_url_rule');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" name="setting[index_url_rule]" id="index_url_rule" value="<?php echo output($setting,'index_url_rule');?>" class="col-sm-8" />
					<div class="col-lg-3 col-sm-4 col-xs-4 input-group">
						<?php echo WUZHI_form::templates('tags', output($setting,'index_tpl'),'name="setting[index_tpl]" class="form-control" id="tagselect"');?>
					</div>
                </div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('letter_url_rule');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" name="setting[letter_url_rule]" id="letter_url_rule" value="<?php echo output($setting,'letter_url_rule');?>" class="col-sm-8" />
					<div class="col-lg-3 col-sm-4 col-xs-4 input-group">
						<?php echo WUZHI_form::templates('tags', output($setting,'letter_tpl'),'name="setting[letter_tpl]" class="form-control" id="tagselect" ');?>
					</div>
                </div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('show_url_rule');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="text" name="setting[show_url_rule]" id="show_url_rule" value="<?php echo output($setting,'show_url_rule');?>" class="col-sm-8" />
					<div class="col-lg-3 col-sm-4 col-xs-4 input-group">
						<?php echo WUZHI_form::templates('tags', output($setting,'show_tpl'),'name="setting[show_tpl]" class="form-control" id="tagselect" ');?>
					</div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="dosubmit" value="<?php echo L('submit');?>">
                </div>
            </div>
        </form>
    </div>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>