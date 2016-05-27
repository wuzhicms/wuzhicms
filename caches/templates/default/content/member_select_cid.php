<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>
<div class="wrapper wrapper-content  animated fadeInRight">
    <div class="row" style="padding-top: 30px;">


        <div class="col-sm-6">
            <div class="ibox">
                <a href="index.php?f=postinfo&v=newinfo&cid=41" >
                <div class="ibox-content text-center" style="background: #9de3cf;">
                    <h3 class="m-b-xxs" style="color:#fff;font-size:36px;">项目</h3>
                </div>
                </a>
            </div>

        </div>
        <div class="col-sm-6">
            <div class="ibox">
                <a href="index.php?f=postinfo&v=newinfo&cid=42" >
                    <div class="ibox-content text-center" style="background: #e39f39;">
                        <h3 class="m-b-xxs" style="color:#fff;font-size:36px;">企业</h3>
                    </div>
                </a>
            </div>

        </div>
    </div>
</div>

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","foot"); ?>
</body>
</html>