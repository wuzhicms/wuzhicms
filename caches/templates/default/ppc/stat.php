<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","head"); ?>
<div class="container membercenter">
    <div class="row">
        <div class="span3 memberleft">
            <?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','left'); ?>
        </div>
        <div class="memberright">
            <div class="userdisplay">
                <div class="userbar">
                    <ul>
                        <li><a href="#"><p><?php echo $toay_count;?></p><span>今日访问量</span></a></li>
                        <li><a href="#"><p><?php echo $tatal_count;?></p><span>总访问量</span></a></li>
                        <li><a href="#"><p><?php echo $total_member;?></p><span>下线会员数</span></a></li>
                    </ul>
                </div>

            </div>
            <div class="memberframe article mt10">
                <div class="memberinfotitle"><h4>推广访问统计</h4></div>
                <ul>
                    <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                    <li><a href="#"><?php echo $r['ip_location'];?><span><?php echo time_format($r['addtime']);?></span></a></li>
                    <?php $n++;}?>
                </ul>
            </div>

            <div class="page-ination">
                <div class="page-in">
                    <ul class="clearfix">
                        <?php echo $pages;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>


</div>

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","foot"); ?>