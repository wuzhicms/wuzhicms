<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<div class="headimg"><img src="<?php echo R;?><?php echo TPLID;?>/images/headimg.jpg" alt=""><div class="headimgtitle"></div></div>
<div class="white-section">
    <div class="container">
        <div class="crumbs"><a href="<?php echo WEBURL;?>">首页</a><span> &gt; <a href="index.php?m=affiche&f=index&v=listing">网站公告</a> </span></div>
        <div class="row">
            <div class="span12">
                <div class="row">
                    <!-- span4 end -->
                    <div style="width: 980px;padding: 0px 20px;">
                        <div id="content">
                            <div id="contentmian">
                                <div class="newscontent">
                                    <div class="newstitle"><h3 class="dotted_line"><?php echo $title;?></h3></div>
                                    <div class="exnewscontent">
                                    <?php echo $content;?>
                                    </div>
                                </div>
                                <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_youdao" data-cmd="youdao" title="分享到有道云笔记"></a><a href="#" class="bds_mail" data-cmd="mail" title="分享到邮件分享"></a><a href="#" class="bds_copy" data-cmd="copy" title="分享到复制网址"></a><a href="#" class="bds_print" data-cmd="print" title="分享到打印"></a></div>
                                <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","weixin","youdao","mail","copy","print"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
                            </div>
                        </div>
                    </div>
                </div><!-- span8 end -->
            </div><!-- row end -->
        </div><!-- span12 end -->
    </div><!-- row end -->
</div><!-- conteiner end -->
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>