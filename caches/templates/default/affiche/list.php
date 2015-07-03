<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<div class="headimg"><img src="<?php echo R;?><?php echo TPLID;?>/images/headimg.jpg" alt=""></div>
<div class="white-section">
    <div class="container">
        <div class="crumbs"><a href="<?php echo WEBURL;?>">首页</a><span> &gt; <a href="index.php?m=affiche&f=index&v=listing">网站公告</a></span></div>
        <div class="row">
            <div class="span12">
                <div class="row">
                    <div class="span256 custom-page-sidebar">
                        <div class="widget widget_nav_menu">
                            <div class="menu-services-container">
                                <ul>
              <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'category')) {
	$rs = $content_template_parse->category(array('cid'=>'0','order'=>'sort ASC','start'=>'0','pagesize'=>'100','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                   <?php if($r['ismenu']) { ?><li><a href="<?php echo $r[url];?>"><?php echo $r['name'];?></a></li><?php } ?>
                    <?php $n++;}?>
              <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                                </ul>
                            </div>
                        </div>
                    </div><!-- span4 end -->
                    <div class="span704">
                        <div id="content">
                            <div id="contentmian">
                                <div class="newslist">
                                    <ul>
                                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"affiche\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('affiche_template_parse')) {
	$affiche_template_parse = load_class("affiche_template_parse", "affiche");
}
if (method_exists($affiche_template_parse, 'listing')) {
	$rs = $affiche_template_parse->listing(array('order'=>'id DESC','status'=>'status=2','start'=>'0','pagesize'=>'5','page'=>$page,));
	$pages = $affiche_template_parse->pages;$number = $affiche_template_parse->number;}?>
                                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                                        <li><a href="<?php echo $r[url];?>">
                                            <div class="newstitle"><h3><?php echo safe_htm($r['title']);?></h3></div></a>
                                            <p><?php echo safe_htm(strcut(strip_tags($r['content']),100));?>.</p>
                                        </li>
                                        <?php $n++;}?>
                                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
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
                </div><!-- span8 end -->
            </div><!-- row end -->
        </div><!-- span12 end -->
    </div><!-- row end -->
</div><!-- conteiner end -->
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>