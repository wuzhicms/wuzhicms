<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<section class="showct">
    <section class="cbox">
        <h5><?php echo $title;?></h5>
        <div class="flxbox infobox">
            <div class="flxz"><?php echo date('Y-m-d H:i',$addtime);?> <?php echo $category['name'];?></div>
        </div>
        <article class="ctbox">
            <?php echo $content;?>
            <?php $n=1;if(is_array($pictures)) foreach($pictures AS $r) { ?>

            <figure itemprop="associatedMedia">
                <a href="<?php echo $r['url'];?>" itemprop="contentUrl" data-size="<?php echo imagesize($r['url']);?>">
                    <img src="<?php echo imagecut($r['url'],630,460,2);?>" itemprop="thumbnail" alt="<?php echo $r['alt'];?>" />
                </a>
                <div class="ext-info">
                    <figcaption itemprop="caption description"><?php echo $r['alt'];?></figcaption>
                </div>
            </figure>
            <?php $n++;}?>
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
    Copyright 2005 - 2015 WuzhiCMS. All Rights Reserved
</footer>
</body>
</html>
