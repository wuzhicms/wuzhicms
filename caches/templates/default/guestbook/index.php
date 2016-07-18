<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>

<!--路径导航-->
<div style="background: #f5f5f5; border-bottom: 1px solid #ddd">
    <div class="container">
        <ol class="breadcrumb" style="margin-bottom: 0px; font-size: 12px;">
            您现在的位置：
            <li><a href="/index.php">首页</a></li>
            <li class="active"><a href="/index.php?m=guestbook">留言板</a></li>
        </ol>
    </div>
</div>





<div class="container liuyan-list">

    <div class="margin_top30" style="display: inline-block;">
        <form class="form-inline" action="" method="get">
            <div class="biaodan-border">
                <select class="form-control" name="conditions">
                    <option value="0" <?php if($conditions==0) { ?>selected<?php } ?>>按关键字查询</option>
                    <option value="1" <?php if($conditions==1) { ?>selected<?php } ?>>按帖子查询码查询</option>
                </select>
            </div>
            <div class="biaodan-border">
                <div class="form-group">
                    <label class="sr-only" for="exampleInputEmail3"> </label>
                    <input type="text" name="keywords" class="form-control" id="exampleInputEmail3" placeholder="请输入搜索内容" value="<?php echo $keywords;?>">
                </div>
            </div>
            <div class="biaodan-border">
                <select class="form-control" name="area">
                    <option value="">主题领域</option>
                    <?php $n=1; if(is_array($area_array)) foreach($area_array AS $key => $r) { ?>
                    <option value="<?php echo $key;?>" <?php if($area==$key) { ?>selected<?php } ?>><?php echo $r;?></option>
                    <?php $n++;}?>
                </select>
            </div>
            <div class="biaodan-border">
                <select class="form-control" name="category">
                    <option value="">主题类别</option>
                    <?php $n=1; if(is_array($category_array)) foreach($category_array AS $key => $r) { ?>
                    <option value="<?php echo $key;?>" <?php if($category==$key) { ?>selected<?php } ?>><?php echo $r;?></option>
                    <?php $n++;}?>
                </select>
            </div>
            <input type="hidden" name="m" value="guestbook">
            <button type="submit" class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;搜索&nbsp;&nbsp;&nbsp;&nbsp;</button>
        </form>
    </div>
    <div class="margin_top30" style="float: right"><a href="index.php?m=guestbook&v=contact" class="btn  btn-warning"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 快速留言</a>
    </div>


    <hr>


    <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
        <ul id="myTabs" class="nav nav-pills liuyan-hdsx" role="tablist">
            <li role="presentation" <?php if($type==0) { ?>class="active"<?php } ?>><a href="index.php?m=guestbook&type=0" >全部</a></li>
            <li role="presentation" <?php if($type==8) { ?>class="active"<?php } ?>><a href="index.php?m=guestbook&type=8" >已回复</a></li>
            <li role="presentation" <?php if($type==9) { ?>class="active"<?php } ?>><a href="index.php?m=guestbook&type=9" >未回复</a></li>
            <li role="presentation" <?php if($type==7) { ?>class="active"<?php } ?>><a href="index.php?m=guestbook&type=7" >办理中</a></li>
        </ul>

        <div id="myTabContent" class="tab-content">

            <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">

                <div class="panel panel-default">

                    <?php $n=1;if(is_array($guestbook_result)) foreach($guestbook_result AS $r) { ?>
                    <div class="panel-heading">
                        <span style="display: inline-block"><strong>[<a><?php echo $r['area'];?></a> <a><?php echo $r['category'];?></a>] <a><?php echo $r['title'];?></a></strong><span class="color_danger  font_size14">&nbsp;&nbsp; | &nbsp;&nbsp;<?php echo $status[$r[status]];?></span> </span> <span style=" float: right; font-size: 14px;  color: #999; line-height: 2.2">网友：<?php echo $r['linkman'];?>  &nbsp;&nbsp; <?php echo date('Y-m-d H:i',$r['addtime']);?></span>
                    </div>
                    <div class="panel-body">
                        <?php echo strcut($r['content'],180,'...');?>
                        <?php if($r[status]==9) { ?>
                        <p class="text-right color_777 font_size14 margin_bottom0"><a href="<?php echo WEBURL;?>index.php?m=guestbook&f=index&v=show&id=<?php echo $r[id];?>">[查看全文]</a></p>
                        <?php } ?>
                    </div>
                    <!--回复-->
                    <?php if($r[status]==8) { ?>
                    <div class="panel-footer">
                        <div class="huifu-hd">
                            <div class="hd-left"><h4><strong>官方回复：</strong></h4></div>
                            <div class="hd-right"> <span style=" font-size: 14px;  color: #999; line-height: 2.2">回复单位：<?php echo $r[reply_user];?>  &nbsp;&nbsp; <?php echo date('Y-m-d H:i',$r['replytime']);?></span></div>
                        </div>
                        <?php echo strcut($r['reply'],180,'...');?>
                        <p class="text-right color_777 font_size14 margin_bottom0"><a href="/index.php?m=guestbook&f=index&v=show&id=<?php echo $r['id'];?>">[查看全文]</a></p>
                    </div>
                    <?php } ?>
                    <!-- // 回复-->
                    <?php $n++;}?>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                </div>
                <div style="text-align:center;">
                    <nav style="text-align: center;">
                        <ul class="pagination">
                            <?php echo $guestbook_pages;?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>




<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>