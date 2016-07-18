<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>

<div style="background: #f5f5f5; border-bottom: 1px solid #ddd">
    <div class="container">
        <ol class="breadcrumb" style="margin-bottom: 0px; font-size: 12px;">
            您现在的位置：
            <li><a href="index.php">首页</a></li>
            <li ><a href="index.php?m=guestbook">留言板</a></li>
            <li class="active">正文</li>
        </ol>
    </div>
</div>
<hr>
<div class="container liuyan-list">
<div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
<div id="myTabContent" class="tab-content">
    <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span style="display: inline-block"><strong>留言主题： <a><?php echo $title;?></a></strong> </span> <span style=" float: right; font-size: 14px;  color: #999; line-height: 2.2">网友：<?php echo $linkman;?>  &nbsp;&nbsp; <?php echo date('Y-m-d H:i',$addtime);?></span>
            </div>
            <div class="panel-body">
                <?php echo $content;?>
            </div>
            <!--回复-->
            <?php if($replytime) { ?>
            <div class="panel-footer">
                <div class="huifu-hd">
                    <div class="hd-left"><h4><strong>官方回复：</strong></h4></div>
                    <div class="hd-right"> <span style=" font-size: 14px;  color: #999; line-height: 2.2">回复单位：<?php echo $reply_user;?>  &nbsp;&nbsp; <?php echo date('Y-m-d H:i',$replytime);?></span></div>
                </div>
                <?php echo $reply;?>
            </div>
            <?php } ?>

        </div>
    </div>
</div>
</div>
</div>

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>
