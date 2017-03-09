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
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('tag_type');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <?php echo WUZHI_form::select($linkage, output($setting,'linkage'), $str = ' name="setting[linkage]"  class="form-control" ', L('select_linkage'));?>
                </div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('index_url_rule');?> <a href="<?php echo WEBURL;?>tags/" target="_blank">访问</a></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="hidden" name="setting[index_url_rule]" id="index_url_rule" value="tags/" class="col-sm-8" />
					<div class="col-lg-3 col-sm-4 col-xs-4 input-group">
						<?php echo WUZHI_form::templates('tags', output($setting,'index_tpl'),'name="setting[index_tpl]" class="form-control" id="tagselect"');?>
					</div>
                </div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('letter_url_rule');?> <a href="<?php echo WEBURL;?>tags/A.html" target="_blank">访问</a></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="hidden" name="setting[letter_url_rule]" id="letter_url_rule" value="tags/{$letter}.html" class="col-sm-8"/>
					<div class="col-lg-3 col-sm-4 col-xs-4 input-group">
						<?php echo WUZHI_form::templates('tags', output($setting,'letter_tpl'),'name="setting[letter_tpl]" class="form-control" id="tagselect" ');?>
					</div>
                </div>
            </div>

			<div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"><?php echo L('show_url_rule');?></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input type="hidden" name="setting[show_url_rule]" id="show_url_rule" value="tags/{$pinyin}.html" class="col-sm-8"/>
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
			<input type="hidden" name="setting[rewrite]" value="1">
        </form>
	<div class="alert alert-success fade in">
		<strong>需要配置伪静态规则: apache规则如下，</strong>
		<br>
		<br>
		<pre>
RewriteRule ^tags/$ index.php?m=tags
RewriteRule ^tags/([A-Z]).html index.php?m=tags&f=index&v=letter&letter=$1
RewriteRule ^tags/([a-z0-9-]+).html index.php?m=tags&f=index&v=show&tid=$1
RewriteRule ^tags/([a-z0-9-]+)-P([0-9]+).html index.php?m=tags&f=index&v=show&tid=$1&page=$2</pre>
	</div>
    </div>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>