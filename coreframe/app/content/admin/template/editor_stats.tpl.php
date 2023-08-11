<?php
/**
 * 编辑工作量统计页面模板
 */
defined('IN_WZ') or exit('No direct script access allowed');
include $this->template('header','core');
?>
<body>
<section class="wrapper">
	<section class="panel">
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
			统计开始时间：<?php echo WUZHI_form::calendar('start',$GLOBALS['start'],0);?> 截止时间： <?php echo WUZHI_form::calendar('end',$endstr,0);?>

			<button type="submit" class="btn btn-info btn-sm"> 查看统计 </button>
		</form>
	</header>
	</section>
    <!-- page start-->
    <form name="myform" method="post" action="?m=content&f=category&v=sort<?php echo $this->su();?>">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">

                    <div class="panel-body" id="panel-bodys">
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th class="tablehead">ID</th>
                                <th class="tablehead">栏目名称</th>
                                <th class="tablehead">所属模型</th>
                                <th class="tablehead text-center">投稿数</th>
                                <th class="tablehead text-center">发稿数</th>
                                <th class="tablehead text-center">优秀稿</th>
                                <th class="tablehead text-center">评论数</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            echo $tree_data;
                            ?>
                            </tbody>
                        </table>
                    </div>

                </section>
            </div>
        </div>
    </form>
    <!-- page end-->
</section>
<script type="text/javascript">
    function repair() {
        $.get("?m=content&f=category&v=repair<?php echo $this->su();?>",
            function(data){
                var d = dialog({
                    content: data
                });
                d.show();
                setTimeout(function () {
                    d.close().remove();
                }, 2000);
            });

    }
</script>
<?php include $this->template('footer','core');?>
