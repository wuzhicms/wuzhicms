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
                              <span>可视化布局内容管理</span>
                          </header>
                          <div class="panel-body" id="panel-bodys">

                              <div class="task-content">
                                  <ul class="task-list">
                                      <li>
                                          <div class="task-title">
<span class="task-title-sp">
<a href="?m=core&f=layout&v=view&pageid=index<?php echo $this->su();?>" target="_blank"><img src="http://enterprise.wuzhicms.com/res/images/icon/dir.png"> 【首页】可视化</a></span>
                                          </div>
                                      </li>

                                  </ul>

                              </div>




                          </div>
                      </section>
                  </div>
              </div>

</div>
</section>
<?php include $this->template('footer','core');?>

