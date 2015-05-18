<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body>
<section class="wrapper">
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
            <?php echo $this->menu($GLOBALS['_menuid']);?>
            <div class="panel-body">
                <form action="" method="post">
                    <input type="hidden" name="v" value="rebuild" />
                    重建索引将会清空原有的所有的索引内容 , 每轮更新
                    <input  type="text" name="pagesize" value="100" size="5" /> 条
                    <input class="btn btn-info" type="submit" name="dosubmit" class="button" value="确认重建索引" />
                </form>
            </div>
        </section>
    </div>
</div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>
