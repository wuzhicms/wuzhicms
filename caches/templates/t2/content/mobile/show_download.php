<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<section class="showct">
    <section class="cbox">
        <h5><?php echo $title;?></h5>
        <div class="flxbox infobox">
            <div class="flxz"><?php echo date('Y-m-d H:i',$addtime);?> <?php echo $category['name'];?></div>
        </div>
        <div class="row">
            <div class="col-xs-12" class="thumbnail"><a href="javascript:void(0);" onclick="toDownload()" class="thumbnail" >
                <img src="<?php echo $thumb;?>" alt="<?php echo $title;?>" style="max-height:180px; overflow:hidden;">
            </a></div>
            <div class="col-xs-12">
                <div class="content_p" style="font-size:13px;">
                    <strong>软件作者:</strong> <?php echo $soft_author;?> <br>
                    <strong>软件大小:</strong> <?php echo $soft_size;?><br>
                    <strong>软件类别:</strong> <?php echo $category['name'];?> <br>
                    <strong>软件语言:</strong> <?php echo $soft_language;?> <br>
                    <strong>运行环境:</strong> <?php echo $soft_env;?> <br>
                    <strong>软件授权:</strong> <?php echo $soft_license;?> <br>
                </div>
            </div>
        </div>
<hr>
        <h4><a href="#">内容介绍</a></h4>
        <div class="content_p">
            <?php echo $content;?>
        </div>
        <hr>
        <div class="content_p" id="download_address">
            下载地址：<a class="btn btn-danger"  style="color: white" href="<?php echo $downfile;?>&cid=<?php echo $cid;?>&id=<?php echo $id;?>" target="_blank" onclick="download_count(<?php echo $cid;?>,<?php echo $id;?>);" role="button">点击下载</a>
        </div>
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
