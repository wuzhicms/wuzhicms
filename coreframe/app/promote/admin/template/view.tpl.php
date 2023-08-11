<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <section class="panel">
        <div class="panel-body">
            广告预览：<?php echo $r['name'];?><br><br>
            <script src="<?php echo WEBURL;?>promote/<?php echo $pid;?>.js"></script>
        </div>
    </section>
<!-- page end-->
</section>
<?php include $this->template('footer','core');?>