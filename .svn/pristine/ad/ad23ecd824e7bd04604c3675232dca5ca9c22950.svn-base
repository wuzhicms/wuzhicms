<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>

<section class="panel">
    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
        <div class="form-group">
          <div class="col-sm-2">
          订单号：<?php
                echo safe_htm($r['order_no']);
                ?>
          　　名称：<?php
                echo safe_htm($r['payname']);
                ?>
          </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2">
                金额： <input  type="text" name="money" value="0.00" > <input type="radio" name="type" value="1" checked> 减少 <input type="radio" name="type" value="0"> 增加
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2"><input class="btn btn-info" type="submit" name="submit" value="提交"></div>
        </form>
    </div>
</section>

<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3
        });
    })

</script>

