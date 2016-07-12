<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php $hide_search_icon=1;?>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head"); ?>
<link type="text/css" rel="stylesheet" href="<?php echo R;?>t3/css/search.css">
<style>
    .breadcrumb{ display: none}
    .search-top-box {
        background: #f3f3f3;
        border-bottom: 3px solid #eeeeee;
        padding: 100px 0 300px 0;
    }
    @media (max-width: 991px) {
        .search-top-box {
            padding: 50px 0;
        }
    }

    /*搜索框变大针对本页样式重置*/
    .select-search .form-control {
        border-left: 0px;
        background-position: 0 -51px;
    }
    .select-search .dropdown-menu {
        min-width: 120px;
    }
    .select-search .dropdown-menu {
        top: 43px;
    }
    .select-search .input-group-btn:first-child > .btn,
    .select-search .input-group-btn:first-child > .dropdown-toggle{
        min-width: 120px;
    }
    .footer {
       margin-top: 0;
    }
</style>

<div class="search-top-box">
    <div class="container">
        <div class="row">
            <div class="col-xs-2"></div>
            <div class="col-xs-8">
                <form role="search" method="get" action="<?php echo WEBURL;?>index.php?f=search">
                    <input name="f" value="search" type="hidden">
                    <div class="input-group  select-search input-group-lg" style="margin-top: 6px">
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
                        <!-- / input-group-btn-->
                        <input name="keywords" type="text" class="form-control" placeholder="请输入关键词" value="<?php echo $keywords;?>">
                      <span class="input-group-btn">
                        <button class="btn btn-primary btn-lg" type="submit">&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-search" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp; </button>
                      </span>
                    </div>
                </form>
                <div class="color_ccc margin_top30 line_height1d8"><span class="font_size16">永久开源，我们一路同行！</span>Permanently open, we ride!</div>
            </div>
            <div class="col-xs-2"></div>
        </div>
    </div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot"); ?>