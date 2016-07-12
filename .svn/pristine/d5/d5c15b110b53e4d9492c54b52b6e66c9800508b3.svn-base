<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body">
<section id="iframecontent">
    <section class="treelistframe pull-left">
        <iframe  width="190px" name="treemain" id="treemain" frameborder="false" scrolling="auto" height="auto" allowtransparency="true" frameborder="0" src="?m=content&f=content&v=left&modelid=<?php echo $modelid.'&type='.$GLOBALS['type'].$this->su();?>"></iframe>
    </section>
    <section id="iframecontent">
        <iframe  width="100%" name="iframeid" id="iframeid" frameborder="false" scrolling="auto" height="auto" allowtransparency="true" frameborder="0" src="?m=content&f=content&v=listing&<?php echo $modelid.$this->su();?>"></iframe>
    </section>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/contentiframe.js"></script>
</body>
</html>