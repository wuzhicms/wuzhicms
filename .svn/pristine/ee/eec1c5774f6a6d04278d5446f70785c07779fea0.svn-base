<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
<div class="panel tasks-widget">
<header>
<?php echo $this->menu($GLOBALS['_menuid']);?>
</header>

<div class="row">
                  <div class="col-md-12">
                      <section class="panel tasks-widget">
                          <header class="panel-heading">
                              <span>当前模版文件：<?php echo $cur_dir.$file.'.html';?></span>
                          </header>
                          <div class="panel-body" id="panel-bodys">

                              <div class="task-content">

                                  <ul class="task-list">
<?php
foreach($result as $rs) {
?>
<li>
<div class="task-title">
<span class="task-title-sp"><?php echo $rs['username'];?> 在 <?php echo time_format($rs['addtime']);?> 更新了该模版</span>
<div class="pull-right hidden-phone">

    <a href="?m=template&f=index&v=view&id=<?php echo $rs['id'];?>&dir=<?php echo $dir;?>&file=<?php echo $file.$this->su();?>" class="btn btn-default btn-xs">查看</a>
</div>
</div>
</li>
<?php
}
?>
                                      
                                  </ul>
                              </div>
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

</div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>