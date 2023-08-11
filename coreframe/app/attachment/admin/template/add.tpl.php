<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <section class="panel">
    <header>
    <?php echo $this->menu($GLOBALS['_menuid']);?>
    </header>
    <div class="panel-body">
    <form class="form-horizontal tasi-form" method="post" action="">
			<div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end">自定义目录名</label>
                <div class="col-3">
                    <input type="text" value="" class="form-control" id="attachment_test" name="diycat">
                </div>
            </div>
			<div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end">批量上传附件</label>
                <div class="col-10">
                    <div class="attaclist">
                        <div id="files"><ul id="files_ul"></ul></div>
                        <?php echo WUZHI_form::attachment('jpg|gif|png','100','files','', 'callback_more_dialog',0);?>
                    </div>
                    <div class="help-block">支持格式：jpg，gif，png</div>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-2 control-label col-form-label text-end"></label>
                <div class="col-3">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="<?php echo L('dosubmit');?>">
                </div>
            </div>
        </form>
    </div>
    </section>
</section>
    <script>
        sync_delete_file = true;
    </script>
<?php include $this->template('footer','core');?>
