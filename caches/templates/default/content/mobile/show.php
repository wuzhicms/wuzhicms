<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<section class="showct">
    <section class="cbox">
        <h5><?php echo $title;?></h5>
        <div class="flxbox infobox">
            <div class="flxz"><?php echo date('Y-m-d H:i',$addtime);?> <?php echo $category['name'];?></div>
        </div>
        <article class="ctbox">
            <?php echo $content;?>
        </article>
        <div class="share">
            <dl>
                <dt>分享到</dt>
                <dd>
                    <script type="text/javascript">document.write('<a href="http://v.t.sina.com.cn/share/share.php?url='+encodeURIComponent(location.href)+'&appkey=2831224133&title='+encodeURIComponent('<?php echo $title;?>')+'" title="分享到新浪微博" class="sharewb" target="_blank">&nbsp;</a>');</script>
                    <script type="text/javascript">document.write('<a href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='+encodeURIComponent(location.href)+'" title="分享到QQ空间" class="shareqzone" target="_blank">&nbsp;</a>');</script>
                </dd>
            </dl>
        </div>
    </section>

</section>
<script type="text/javascript">

</script>
<footer class="ft">
    Copyright 2005 - 2014 WuzhiCMS. All Rights Reserved
</footer>
</body>
</html>
