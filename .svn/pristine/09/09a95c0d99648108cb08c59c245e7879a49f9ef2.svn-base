<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<link type="text/css" rel="stylesheet" href="<?php echo R;?>css/animate.css">
<div class="bankuai_1 pd30">
    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                
            </div>
            <div class="col-xs-6">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span> <span class="sr-only">Next</span> </a> </div>
            </div>
        </div>
    </div>
</div>
<div class="bankuai_1">
    <div class="container">
        <div class="row">
            <div class="col-xs-8 ">
                <h3><?php echo $categorys[1]['name'];?> <span class="lm_more"><?php $sub_categorys = sub_categorys(1);?>
                    <?php $n=1; if(is_array($sub_categorys)) foreach($sub_categorys AS $cid => $cat) { ?>
                    <a href="<?php echo $cat['url'];?>" target="_blank"><?php echo $cat['name'];?></a>&nbsp;&nbsp;
                    <?php $n++;}?></span>
                    </h3>
                    
                    <div class="row">
                    	<div class="col-xs-6">


                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>'6','start'=>'0','pagesize'=>'6','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                    <h4>&#8226; <a href="<?php echo $categorys[6]['url'];?>" target="_blank"><?php echo $categorys[6]['name'];?></a></h4>
                    <div class="list-group">
                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <?php if($n==1) { ?><a href="<?php echo $r[url];?>" class="list-group-item_g" target="_blank"><?php echo strcut($r['title'],36);?></a><?php } else { ?>
                        <a href="<?php echo $r[url];?>" class="list-group-item_g" target="_blank"><span class="badge"><?php echo date('m-d',$r['addtime']);?></span>· <?php echo strcut($r['title'],32);?></a><?php } ?>
                    <?php $n++;}?>
                    </div>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>'7','start'=>'0','pagesize'=>'6','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                    <h4>&#8226; <a href="<?php echo $categorys[7]['url'];?>" target="_blank"><?php echo $categorys[7]['name'];?></a></h4>
                    <div class="list-group">
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <?php if($n==1) { ?><a href="<?php echo $r[url];?>" class="list-group-item_g" target="_blank"><?php echo strcut($r['title'],36);?></a><?php } else { ?>
                        <a href="<?php echo $r[url];?>" class="list-group-item_g" target="_blank"><span class="badge"><?php echo date('m-d',$r['addtime']);?></span>· <?php echo strcut($r['title'],32);?></a><?php } ?>
                        <?php $n++;}?>
                    </div>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

                        </div>
                    
                
                <div class="col-xs-6">
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>'8','start'=>'0','pagesize'=>'6','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                    <h4>&#8226; <a href="<?php echo $categorys[8]['url'];?>" target="_blank"><?php echo $categorys[8]['name'];?></a></h4>
                    <div class="list-group">
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <?php if($n==1) { ?><a href="<?php echo $r[url];?>" class="list-group-item_g" target="_blank"><?php echo strcut($r['title'],36);?></a><?php } else { ?>
                        <a href="<?php echo $r[url];?>" class="list-group-item_g" target="_blank"><span class="badge"><?php echo date('m-d',$r['addtime']);?></span>· <?php echo strcut($r['title'],32);?></a><?php } ?>
                        <?php $n++;}?>
                    </div>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>'9','start'=>'0','pagesize'=>'6','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                    <h4>&#8226; <a href="<?php echo $categorys[9]['url'];?>" target="_blank"><?php echo $categorys[9]['name'];?></a></h4>
                    <div class="list-group">
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <?php if($n==1) { ?><a href="<?php echo $r[url];?>" class="list-group-item_g" target="_blank"><?php echo strcut($r['title'],36);?></a><?php } else { ?>
                        <a href="<?php echo $r[url];?>" class="list-group-item_g" target="_blank"><span class="badge"><?php echo date('m-d',$r['addtime']);?></span>· <?php echo strcut($r['title'],32);?></a><?php } ?>
                        <?php $n++;}?>
                    </div>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                </div>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="lipin_box">
                    <div class="h_title">注册有礼</div>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>'26','start'=>'0','pagesize'=>'1','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                    <img src="<?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>" class="imgys" width="95" height="88">
                    <?php $n++;}?>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

                    <div class="list-group">
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>'26','start'=>'0','pagesize'=>'3','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                            <?php if($n==1) { ?>
                            <div style="height:105px;">
                                <a href="<?php echo $r['url'];?>" class="list-group-item_gg" target="_blank">
                                    <p><?php echo strcut($r['title'],58);?></p>
                                </a>
                            </div>
                            <?php } else { ?>
                            <a href="<?php echo $r['url'];?>" class="list-group-item_gg">· <?php echo strcut($r['title'],30);?></a><?php } ?>
                            <?php $n++;}?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    </div>
                    <ins class="liimg"></ins>
                </div>
                <a href="<?php echo WEBURL;?>index.php?m=member&v=register" target="_blank"><button type="button" class="big_btn">马上注册</button></a>
                <div class="rightad_box"><img src="http://placehold.it/300x233" width="300" height="233"></div>
            </div>
        </div>
    </div>
</div>

<div class="bankuai_ad">
    <div class="container">
        <img src="http://placehold.it/960x100" width="960" height="100">
    </div>
</div>

<?php $cates=array(2,4);?>
<?php $n=1;if(is_array($cates)) foreach($cates AS $cats) { ?>
<div class="bankuai_1">
    <div class="container">
        <h3><?php echo $categorys[$cats]['name'];?><span class="lm_more"><?php $sub_categorys = sub_categorys($cats);?>
                    <?php $n=1; if(is_array($sub_categorys)) foreach($sub_categorys AS $cid => $cat) { ?>
                    <a href="<?php echo $cat['url'];?>" target="_blank"><?php echo $cat['name'];?></a>&nbsp;&nbsp;
                    <?php $n++;}?></span></h3>
        <div class="row">
            <?php $n=1; if(is_array($sub_categorys)) foreach($sub_categorys AS $cid => $cat) { ?>
            <?php if($n==1) { ?>
            <div class="col-xs-6">
                <h4><a href="<?php echo $cat['url'];?>" target="_blank">&#8226; <?php echo $cat['name'];?></a></h4>
                <div class="row">
                    <div class="col-xs-4">
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC','cid'=>$cid,'start'=>'0','pagesize'=>'1','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                            <a href="<?php echo $r['url'];?>" title="<?php echo $r['title'];?>" target="_blank"><img src="<?php echo $r['thumb'];?>" style="width: 150px;height: 280px;" class="imgys" ></a>
                            <?php $n++;}?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    </div>
                    <div class="col-xs-8">
                        <div class="list-group">
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('startid'=>'2','order'=>'sort DESC','cid'=>$cid,'start'=>'0','pagesize'=>'7','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                            <?php if($n==1) { ?>
                            <a href="<?php echo $r['url'];?>" target="_blank">
                                <h4 class="list-group-item_g-heading"><?php echo strcut($r['title'],36);?></h4>
                                <p class="list-group-item_g-text"><?php echo strcut($r['remark'],72,'...');?></p>
                            </a>
                            <hr/><?php } else { ?>
                            <a href="<?php echo $r['url'];?>" class="list-group-item_g" target="_blank"><span class="badge"><?php echo date('y-d',$r['addtime']);?></span>· <?php echo strcut($r['title'],33);?></a><?php } ?>
                            <?php $n++;}?>
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>

                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php $n++;}?>
            <div class="col-xs-6" >
                <?php $n=1; if(is_array($sub_categorys)) foreach($sub_categorys AS $cid => $cat) { ?>
                <?php if($n!=1) { ?>
                <h4><a href="<?php echo $cat['url'];?>">&#8226; <?php echo $cat['name'];?></a></h4>
                <div class="row">
                    <div class="col-xs-4">
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC','cid'=>$cid,'start'=>'0','pagesize'=>'1','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                        <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                        <a href="<?php echo $r['url'];?>" target="_blank"><img src="<?php echo $r['thumb'];?>" style="width: 150px;height: 110px;" class="imgys"></a>
                        <?php $n++;}?>
                        <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                    </div>
                    <div class="col-xs-8">
                        <div class="list-group" style="margin-bottom: 0px;">
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC','cid'=>$cid,'start'=>'0','pagesize'=>'4','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                            <?php if($n==1) { ?>
                            <a href="<?php echo $r['url'];?>" class="list-group-item_g"><?php echo strcut($r['title'],36);?></a>
                            <?php } else { ?>
                            <a href="<?php echo $r['url'];?>" class="list-group-item_g"><span class="badge"><?php echo date('y-d',$r['addtime']);?></span>· <?php echo strcut($r['title'],32);?></a><?php } ?><?php $n++;}?>
                            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php $n++;}?>
            </div>
        </div>
    </div>
</div>
<?php $n++;}?>

    <div class="container">
    <div class="row">
        <?php $sub_categorys = sub_categorys(3);?>
            <?php $n=1; if(is_array($sub_categorys)) foreach($sub_categorys AS $cid => $cat) { ?>
         <div class="col-xs-6" >
           <h4><a href="<?php echo $cat['url'];?>"><?php echo $cat['name'];?></a></h4>
            <div class="row">
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$cid,'start'=>'0','pagesize'=>'4','page'=>'0',));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
                <div class="col-xs-6">
                    <div class="thumbnail " style="padding:0px; border:0px; margin-bottom: 30px;">
                        <div  class="pichend"><a href="<?php echo $r['url'];?>" target="_blank"><img src="<?php echo imagecut($r['thumb'],222,150,4);?>" class="imgysg animated"></a>
                        </div>
                        <div class="caption" style="color: #26496D; text-align:center; background:#f1f1f1">
                        <?php echo $r['title'];?>
                        </div>
                    </div>
                </div>
                <?php $n++;}?>
                <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
          	</div>
        </div>
        <?php $n++;}?>

</div>
</div>

<div class="container">

        <div style="height:6px; background:#AA151B;"></div>
        <div style="background:#efefef;padding:8px 8px 16px 8px;">
            <div style="font-size:14px; font-weight:bold; line-height:2; font-family:inherit; padding-left:5px;">合作伙伴</div>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"link\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('link_template_parse')) {
	$link_template_parse = load_class("link_template_parse", "link");
}
if (method_exists($link_template_parse, 'listing')) {
	$rs = $link_template_parse->listing(array('kid'=>'0','order'=>'sort ASC','start'=>'0','pagesize'=>'16','page'=>'0',));
	$pages = $link_template_parse->pages;$number = $link_template_parse->number;}?>
            <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>
            <a href="<?php echo $r['url'];?>" target="_blank"><img src="<?php echo $r['logo'];?>" width="116" height="41"></a>
            <?php $n++;}?>
            <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>
         </div>
</div>

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>
