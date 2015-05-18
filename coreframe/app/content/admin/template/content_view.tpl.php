<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body">
<style>
    .tables{width: 100%;}
    .tables td{padding: 10px;border-bottom: 1px dashed #eaeaea;}
    .m-panel{
        position: fixed;
        z-index: 2000;
        background-color: rgba(148, 189, 207, 0.33);
        float: right;
        top: 200px;
        right: 15px;
        width: 150px;
        border: 1px #D222AE dashed;
        font-size: 16px;
        line-height: 03.42857143;
        color: #F91E0C;
    }
    .m-panel>ul>li{
        line-height: 36px;
    }
</style>
<link href="http://dev.wuzhicms.com/res/css/validform.css" rel="stylesheet">
<script src="http://dev.wuzhicms.com/res/js/validform.min.js"></script>
<section class="wrapper">
    <form name="myform" method="post" action="">
    <div class="row">

<div class="m-panel">
    <ul>
        <li>上一篇</li>
        <li>下一篇</li>
        <li>编辑</li>
        <li>通过审核</li>
        <li>删除</li>

    </ul>

</div>
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-body">
<table cellpadding="5" cellspacing="5" border="0" class="tables">
    <?php
    if(is_array($data)) {
    foreach($data as $key=>$info) {

    ?>
    <tr>
        <td width="120"><?php echo $info['name']?></td>
        <td><?php if(is_array($info['data'])) {
                echo implode(',',$info['data']);
            } else {
                if($key=='addtime') {
                    echo date('Y-m-d H:i:s',$info['data']);
                } elseif($key=='status') {
                    echo $this->status_array[$info['data']];
                } elseif($key=='thumb') {
                    echo "<a href='".$info['data']."' target='_blank'><img src='".$info['data']."' width='100'></a>";
                } elseif($key=='allowcomment') {
                    if($info['data']==1) {
                        echo "是";
                    } else {
                        echo "否";
                    }
                } else {
                    echo $info['data'];
                }
            }
            ?></td>
    </tr>
    <?php
    }
    }
    ?>
</table>




                </div>
            </section>

    </div>
</form>

</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>


