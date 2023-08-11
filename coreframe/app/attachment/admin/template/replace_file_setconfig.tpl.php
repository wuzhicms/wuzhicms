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
            <form class="form-horizontal tasi-form" method="post" action="?m=attachment&f=replace_file&v=setconfig<?php echo $this->su();?>">
                <div class="row mb-3">
                    <label class="col-2 control-label col-form-label text-end">当前路径</label>
                    <div class="col-3"><input type="text" value="<?php echo $data['data'];?>" class="form-control" name="setting[current_path]" size="100"></div>
                </div>
                <div class="row mb-3">
                    <label class="col-2 control-label col-form-label text-end">替换后</label>
                    <div class="col-3"><input type="text" value="" class="form-control" name="setting[path]" size="100"></div>
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
<?php include $this->template('footer','core');?>
