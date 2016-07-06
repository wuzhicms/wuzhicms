<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<link type="text/css" rel="stylesheet" href="<?php echo R;?>h1jk/css/shequ.css">

<!-- 社区-->
<!-- ---------------------------------- -->

<div class="container">
    <div class="row">
        <div class="col-xs-12" style="background:url(<?php echo R;?>h1jk/image/shequbg.png) no-repeat top center;">
            <div class="shequ_box" >


                <div class="shequ_list">
                    <div class="header">
                        <ul class="nav nav-tabs">
                            <li role="presentation" class="active"><a href="#zuiixnfabiao" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> 最新发表</a></li>

                        </ul>
                    </div>
                    <div class="main">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="zuiixnfabiao">

                                <table class="table table-hover">
                                    <tbody>
                                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"guestbook\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('guestbook_template_parse')) {
	$guestbook_template_parse = load_class("guestbook_template_parse", "guestbook");
}
if (method_exists($guestbook_template_parse, 'listing')) {
	$rs = $guestbook_template_parse->listing(array('order'=>'id DESC','start'=>'0','pagesize'=>'20','page'=>$page,));
	$pages = $guestbook_template_parse->pages;$number = $guestbook_template_parse->number;}?>
                                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                                    <tr>
                                        <td class="tuxiang"><img src="<?php echo avatar($r['uid'], 180);?>" width="60"></td>
                                        <td class="zhuti">
                                            <div class="title"><a href="index.php?m=guestbook&v=show&id=<?php echo $r['id'];?>" class="color_heyilan"><?php echo $r['title'];?></a></div>
                                            <div class="em"><?php echo $r['publisher'];?>&nbsp;&nbsp; 于<?php echo date('Y-m-d',$r['addtime']);?>发表 </div>
                                        </td>
                                        <td class="rw">
                                            <div class="liulan"><?php echo $r['hits'];?></div>
                                            <div class="huifu">浏览次数</div>
                                        </td>
                                    </tr>
                                    <?php $n++;}?>
                                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                                    </tbody>
                                </table>
                                <div style="text-align:center">
                                    <ul class="pagination">
                                        <?php echo $pages;?>
                                    </ul>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="zuire">
                                <table class="table table-hover">
                                    <tbody>
                                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'rank')) {
	$rs = $content_template_parse->rank(array('order'=>'views DESC','cid'=>$cid,'start'=>'0','pagesize'=>'10','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                                    <tr>
                                        <td class="tuxiang"><img src="<?php echo R;?>h1jk/image/luntanmr.jpg" width="60"></td>
                                        <td class="zhuti">
                                            <div class="title"><a href="<?php echo $r['url'];?>" class="color_heyilan"><?php echo $r['title'];?></a></div>
                                            <div class="em">五指CMS&nbsp;&nbsp; 于<?php echo date('Y-m-d',$r['addtime']);?>发表 <a href="<?php echo $categorys[$r['cid']]['url'];?>">[<?php echo $categorys[$r['cid']]['name'];?>]</a> </div>
                                        </td>
                                        <td class="rw">
                                            <div class="liulan"><?php echo get_hits($r['cid'],$r['id'],'views');?></div>
                                            <div class="huifu">浏览次数</div>
                                        </td>
                                    </tr>
                                    <?php $n++;}?>
                                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- Tab panes js -->
                        <script>
                            $(function () {
                                $('#myTab a:last').tab('show')
                            })
                        </script>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>