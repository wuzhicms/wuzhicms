<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>
<div class="container membercenter">
    <div class="row">
        <div class="span3 memberleft">
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','left'); ?>
        </div>
        <div class="memberright">
            <div class="memberframe article">
                <div class="memberinfotitle"><h4>系统公告</h4></div>
                <ul>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"affiche\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('affiche_template_parse')) {
	$affiche_template_parse = load_class("affiche_template_parse", "affiche");
}
if (method_exists($affiche_template_parse, 'listing')) {
	$rs = $affiche_template_parse->listing(array('order'=>'id DESC','status'=>'status IN(1,2)','start'=>'0','pagesize'=>'10','page'=>$page,));
	$pages = $affiche_template_parse->pages;$number = $affiche_template_parse->number;}?>
                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                    <li><a href="index.php?m=affiche&f=affiche&v=show&id=<?php echo $r['id'];?>"><?php echo safe_htm($r['title']);?><span><?php echo time_format($r['addtime']);?></span></a></li>
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
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>
