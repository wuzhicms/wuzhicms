<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php $hide_search_icon=1;?>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head"); ?>
<link type="text/css" rel="stylesheet" href="<?php echo R;?>t3/css/search.css">
<style>
    .breadcrumb{ display: none}
</style>
<div class="search-top-box">
    <div class="container">
        <div class="row">
            <div class=" col-sm-2"></div>
            <div class=" col-sm-8">
                <form role="search" method="get" action="<?php echo WEBURL;?>index.php?f=search">
            <input name="f" value="search" type="hidden">
                    <div class="input-group select-search">

                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span id="option_modelid">
                                <?php echo $search_typename;?>
                                </span>
                                <input id="modelid" name="modelid" value="<?php echo $modelid;?>" type="hidden">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <?php $n=1;if(is_array($categorys)) foreach($categorys AS $r) { ?>
                                <?php if($r['ismenu'] && $r['pid']==0) { ?><li><a href="javascript:set_option('modelid',<?php echo $r['modelid'];?>,'<?php echo $r['name'];?>');"><?php echo $r['name'];?></a></li><?php } ?>
                                <?php $n++;}?>


                            </ul>
                        </div>

                        <input type="text" name="keywords" class="form-control" placeholder="请输入关键词" value="<?php echo $keywords;?>">
                            <span class="input-group-btn" style="overflow: hidden;  vertical-align: top;">
                                <button class="btn btn-primary" type="submit">
                                    <span class="glyphicon glyphicon-search  font_weight"></span> 搜索
                                </button>
                            </span>
                    </div>
                    </form>
                <div class="color_999 margin_top10"> 获得约<strong class="color_qiyecheng"> <?php echo $total_number;?> </strong>条结果 （用时<?php echo $runtime;?>  秒）</div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>

<div class="wuzhi_search">
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <div class="wuzhi_search_list" id="wuzhi_searchlist" style="width: 130px;">

                    <h5 style=" text-align:right">按时间搜索</h5>
                    <div class="list-group" style="text-align:right">
                        <a href="?f=search&starttime=0&keywords=<?php echo $keywords;?>" class="list-group-item_gr <?php if($starttime==0) { ?>active<?php } ?>">全部时间</a>
                        <a href="?f=search&starttime=1&keywords=<?php echo $keywords;?>" class="list-group-item_gr <?php if($starttime==1) { ?>active<?php } ?>" >一天内</a>
                        <a href="?f=search&starttime=7&keywords=<?php echo $keywords;?>" class="list-group-item_gr <?php if($starttime==7) { ?>active<?php } ?>">一周内</a>
                        <a href="?f=search&starttime=30&keywords=<?php echo $keywords;?>" class="list-group-item_gr <?php if($starttime==30) { ?>active<?php } ?>">一月内</a>
                        <a href="?f=search&starttime=365&keywords=<?php echo $keywords;?>" class="list-group-item_gr <?php if($starttime==365) { ?>active<?php } ?>">一年内</a>
                    </div>
                    <h5 style=" text-align:right">搜索历史</h5>
                    <div class="list-group" style="text-align:right">
                        <?php $n=1;if(is_array($history_result)) foreach($history_result AS $rs) { ?>
                        <a href="?f=search&starttime=0&keywords=<?php echo $rs;?>" class="list-group-item_gr"><?php echo $rs;?></a>
                        <?php $n++;}?>
                    </div>
                </div>
            </div>
            <div class="col-md-10 left-line">
                <div class="wuzhi_search_bd">
                    <div class="headline-news-list">
                    <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                    <?php if($GLOBALS['_groupid']==4 && $r['cid']==316 ) continue;?>
                    <?php if($GLOBALS['_groupid']==4 && $r['cid']==317 ) continue;?>
                    <?php if($GLOBALS['_groupid']==4 && $r['cid']==236 ) continue;?>
                    <?php if($GLOBALS['_groupid']==4 && $r['cid']==238 ) continue;?>
                    <?php if($GLOBALS['_groupid']==4 && $r['cid']==237 ) continue;?>
                    <?php if($GLOBALS['_groupid']==4 && $r['cid']==304 ) continue;?>
                    <?php if($GLOBALS['_groupid']==4 && $r['cid']==239 ) continue;?>
                    <div class="media">
                        <?php if($r['thumb']) { ?>
                        <a class="media-left" href="<?php echo $r['url'];?>">
                            <img src="<?php echo $r['thumb'];?>" style="max-width:120px;max-height:120px;">
                        </a>
                        <?php } ?>
                        <div class="media-body">
                            <h4 class="media-heading manhangyichu"><a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a></h4>
                            <div class="media-content" ><?php echo str_replace($keywords, "<font color='#C00'>".$keywords."</font>", strcut($r['remark'],160));?></div>
                            <div  class="media-time"><span class="left font_size12">发布时间：<?php echo date('Y年m月d日 H:i',$r['addtime']);?></span></div>
                        </div>
                    </div>
                    <?php $n++;}?>
                    </div>
                    <!-- start-五指分页-->
                    <div style="text-align:center;">
                        <nav>
                            <ul class="pagination">
                                <li><a>共<?php echo $total_number;?>条</a></li>
                                <?php echo $result_pages;?>
                            </ul>
                        </nav>
                    </div>
                    <!--end  五指分页 -->                </div>

            </div>
        </div>
    </div>
</div>
<script src="<?php echo R;?>t3/js/wuzhi_searchlist.js"></script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot"); ?>