<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
<div class="panel tasks-widget">
    <header>
    <?php echo $this->menu($GLOBALS['_menuid']);?>
    </header>
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
                    <div class="d-flex justify-content-between">
                        <span class="task-title-sp"><?php echo $rs['username'];?> 在 <?php echo time_format($rs['addtime']);?> 更新了该模版</span>
                        <div>
                        <a href="?m=template&f=index&v=view&id=<?php echo $rs['id'];?>&dir=<?php echo $dir;?>&file=<?php echo $file.$this->su();?>" class="btn btn-default btn-sm btn-xs">查看</a>
                        </div>
                    </div>
                </li>
                <?php
                }
                ?>
                </ul>
            </div>
            <div class="panel-foot">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="panel-label">
                        <ul class="pagination pagination-sm">
                            <?php echo $pages;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<?php include $this->template('footer','core');?>