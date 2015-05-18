<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>
<div class="container membercenter">
    <div class="row">
        <div class="span3 memberleft">
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','left'); ?>
        </div>
        <div class="memberright">
            <div class="memberframe article">
                <div class="memberinfotitle"><h4><?php echo $r['title'];?></h4></div>
                <ul>
                    <li>公告发布时间：<?php echo date('Y-m-d H:i',$r['addtime']);?></li>
                    <li><?php echo $r['content'];?></li>
                </ul>
            </div>

        </div>
    </div>


</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>
