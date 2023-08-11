<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
	<!-- page start-->
	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
				<?php echo $this->menu($GLOBALS['_menuid']);?>
				<header class="panel-heading">
					<form class="d-flex align-items-center" role="form" method="post">
						<div class="col-auto">
							<?php
							echo $form->tree_select($categorys, $cid, 'name="cid" class="form-select"', '≡ 无上级栏目 ≡');
							?>
						</div>
                        <div class="align-items-center ms-3 row">
                            <label class="col-auto col-form-label">时间段： </label>
                            <div class="col-auto input-gorup row">
                                <div class="col-sm-5 p-0">
                                    <?php echo WUZHI_form::calendar('regTimeStart', $starttime); ?>
                                </div>
                                <div class="col-sm-1 d-inline-block lh-lg pe-1 ps-2">-</div>
                                <div class="col-sm-5 p-0">
                                    <?php echo WUZHI_form::calendar('regTimeEnd', $endtime); ?>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info btn-sm me-3 px-4">搜索</button>
						<button type="submit" name="submit2" class="btn btn-primary btn-sm">切换成表格显示</button>
					</form>
				</header>
				<div class="panel-body" id="panel-bodys">
					<script src="/res/js/echarts.common.min.js"></script>
					<div id="main" style="width: 100%;height:400px;"></div>
				</div>
			</section>
		</div>
	</div>

	<!-- page end-->
</section>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));

    option = {
        title: {
            text: '<?php echo $categorys[$cid]['name'];?>'
        },
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            data:['文章数量']
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        toolbox: {
            feature: {
                saveAsImage: {}
            }
        },
        xAxis: {
            type: 'category',
            boundaryGap: false,
            data: [<?php echo $xAxis;?>]
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                name:'稿件数量',
                type:'line',
                stack: '总量',
                data:[<?php echo $datas;?>]
            }
        ]
    };



    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
</script>
<?php include $this->template('footer','core');?>
