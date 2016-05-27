<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<script type="text/javascript" src="http://cdn.wuzhicms.com/highcharts/4.1.9/highcharts.js"></script>

<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>

                <div class="panel-body">
                    <div id="container" style="min-width:700px;height:300px"></div>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
    <div class="row">
        <div class="col-lg-12">


            <section class="panel">
                <div class="panel-body" id="panel-bodys">
                    <table class="table table-striped table-advance table-hover">
                        <thead>
                        <tr>
                            <th class="tablehead">点击时间</th>
                            <th class="tablehead">ip</th>
                            <th class="tablehead">地理位置</th>
                            <th class="tablehead">访问用户</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach($result_detail AS $r) {

                            ?>
                            <tr>
                                <td><?php echo $r['addtime'];?></td>
                                <td><?php echo $r['ip'];?></td>
                                <td><?php echo $r['ip_location'];?></td>
                                <td><?php if($r['uid']) {
                                        $mr = $this->db->get_one('member', array('uid' => $r['uid']));
                                        echo $mr['username'];
                                    } else {
                                        echo '游客';
                                    }
                                    ?></td>
                            </tr>
                            <tr style="background-color: #F1F2F7;">
                                <td>来源：</td>
                                <td colspan="3"><?php echo WEBURL.$r['referer'];?></td>
                            </tr>
                            <?php
                        }
                        ?>



                        </tbody>
                    </table>
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
                </div>

            </section>

        </div>

    </div>

</section>

<script>
    Highcharts.setOptions({
        lang:{
            contextButtonTitle:"图表导出菜单",
            decimalPoint:".",
            downloadJPEG:"下载JPEG图片",
            downloadPDF:"下载PDF文件",
            downloadPNG:"下载PNG文件",
            downloadSVG:"下载SVG文件",
            drillUpText:"返回 {series.name}",
            loading:"加载中",
            months:["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
            noData:"没有数据",
            numericSymbols: [ "千" , "兆" , "G" , "T" , "P" , "E"],
            printChart:"打印图表",
            resetZoom:"恢复缩放",
            resetZoomTitle:"恢复图表",
            shortMonths: ["一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月"],
            thousandsSep:",",
            weekdays: ["星期一", "星期二", "星期三", "星期三", "星期四", "星期五", "星期六","星期天"]
        }
    });
    $(function () {
        $('#container').highcharts({
            credits:{
                enabled:false // 禁用版权信息
            },
            title: {
                text: '<?php echo $r['lk3title'];?>'
            },
            subtitle: {
                text: '<?php echo $r['lk1title'].' -' .$r['lk2title'];?>'
            },
            chart: {
                type: 'line'
            },
            legend: {
                enabled: false
            },
            xAxis: {
                categories: [
                    <?php
                     $str = '';
                     foreach($result as $rs) {
                        $str .="'".$rs['day']."日',";
                    }
                    $str = substr($str,0,-1);
                    echo $str;
                    ?>
                ],
                tickmarkPlacement: 'on',
                title: {
                    enabled: false
                }
            },
            yAxis: {
                title: {
                    text: '数量'
                },
                labels: {
                    formatter: function() {
                        return this.value;
                    }
                }
            },
            tooltip: {
                shared: true,
                valueSuffix: ' '
            },
            plotOptions: {
                area: {
                    stacking: 'normal',
                    lineColor: '#666666',
                    lineWidth: 1,
                    marker: {
                        lineWidth: 1,
                        lineColor: '#666666'
                    }
                }
            },
            series: [{
                name: '点击量',
                data: [
                    <?php
                     $str = '';
                     foreach($result as $rs) {
                        $str .="".intval($rs['num']).",";
                    }
                    $str = substr($str,0,-1);
                    echo $str;
                    ?>
                ]
            }]
        });
    });
</script>