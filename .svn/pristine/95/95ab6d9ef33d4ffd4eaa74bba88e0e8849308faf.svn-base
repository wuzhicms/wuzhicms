<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<script type="text/javascript" src="<?php echo R;?>h1jk/js/starmap.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo R;?>h1jk/css/shequ.css">
<!-- ---------------------------------- -->
<!-- ---------------------------------- -->

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="shequ_box" >
                <div class="shequ_title_g">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <td class="tuxiang"><img src="<?php echo avatar($uid, 180);?>" width="60"></td>
                            <td class="zhuti">
                                <div class="title"><?php echo $title;?></div>
                                <div class="em"><?php echo $publisher;?>&nbsp;&nbsp; 于<?php echo date('Y-m-d',$addtime);?>发表 </div>
                            </td>
                            <td class="rw">
                                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> <span ><?php echo $hits;?></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="shequ_list">
                    <div class="content">
                        <?php echo $content;?>
                    </div>

                </div>
                <?php if($replytime) { ?>
                <div style="line-height:40px; padding:0px 16px; font-weight:bold;">最后回复 <?php echo date('Y-m-d H:i',$replytime);?></div>
                <div class="shequ_list_g">
                    <?php echo $reply;?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>