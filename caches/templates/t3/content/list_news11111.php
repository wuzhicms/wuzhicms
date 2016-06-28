<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<!--路径导航-->
<div style="background: #f3f3f3">
    <div class="container">
        <ol class="breadcrumb" style="margin-bottom: 0px">
            您现在的位置：
            <li><a href="#">B首页</a></li>
            <?php echo catpos($cid);?>
        </ol>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="ad-box" style="height: 120px; width: 100%; background: #dddddd">ad</div>
        </div>
    </div>
</div>

<div class="news-second-screen">
    <div class="container">
        <div class="row">
            <div class="col-xs-8">
                <div class="headline-news-list">
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {
	echo "<div class=\"visual_div\" pc_action=\"content\" data=\"\"><a href=\"javascript:void(0)\" class=\"visual_edit\">修改</a>";
}
if(!class_exists('content_template_parse')) {
	$content_template_parse = load_class("content_template_parse", "content");
}
if (method_exists($content_template_parse, 'listing')) {
	$rs = $content_template_parse->listing(array('order'=>'sort DESC,id DESC','cid'=>$cid,'urlrule'=>$urlrule,'start'=>'0','pagesize'=>'20','page'=>$page,));
	$pages = $content_template_parse->pages;$number = $content_template_parse->number;}?>
                    <?php $n=1;if(is_array($rs)) foreach($rs AS $r) { ?>

                    <div class="media">
                        <div class="media-left ">
                            <a href="#">
                                <img class="media-object" src=" <?php echo R;?>t3/image/temp/temp1.jpg" alt="..." width="165px" height="110px">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading manhangyichu"><a href="<?php echo $r[url];?>"><?php echo $r['title'];?></a></h4>
                            <div class="media-content" ><?php echo strcut($r['remark'],200,'...');?></div>
                            <div  class="media-time"><span class="left">发布时间：2005-10-21</span><span class="right">评论(1234) <small class="color_999" style="padding-left: 5px; padding-right: 5px;">|</small> 分享</span></div>
                        </div>
                    </div>

                    <!--
                    <div class="bignewsbox">
                        <div class="Nhead"><a href="<?php echo $r[url];?>"><?php echo $r['title'];?></a></div>
                        <div class="Nbd"><?php if($r[thumb]) { ?><a href="<?php echo $r[url];?>"><img src="<?php echo $r[thumb];?>"></a><?php } ?>
                            <p><?php echo strcut($r['remark'],180,'...');?></p>
                        </div>
                        <div class="Nfoot">
                            <div class="lwd"><?php echo date('Y-m-d',$r['addtime']);?></div>
                        </div>
                    </div>
-->
                    <?php $n++;}?>
                    <?php if(defined('IN_ADMIN') && !defined('HTML')) {echo '</div>';}?>


                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="<?php echo R;?>t3/image/temp/temp2.jpg" alt="..." width="165px" height="110px">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">党岭葫芦海-丹巴藏寨-新都桥深度赏秋7日</h4>
                            <div class="media-content" >今日全国各地的队友到成都集合如果您的时间比较宽裕领袖户外的领队已经在酒店等大家了。</div>
                            <div  class="media-time"><span class="left">发布时间：2005-10-21</span><span class="right">评论(1234) <small class="color_999" style="padding-left: 5px; padding-right: 5px;">|</small> 分享</span></div>
                        </div>
                    </div>

                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading">党岭葫芦海-丹巴藏寨-新都桥深度赏秋7日</h4>
                            <div class="media-content" >今日全国各地的队友到成都集合如果您的时间比较宽裕领袖户外的领队已经在酒店等大家了。</div>
                            <div  class="media-time"><span class="left">发布时间：2005-10-21</span><span class="right">评论(1234) <small class="color_999" style="padding-left: 5px; padding-right: 5px;">|</small> 分享</span></div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="<?php echo R;?>t3/image/temp/temp5.jpg" alt="..." width="165px" height="110px">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">党岭葫芦海-丹巴藏寨-新都桥深度赏秋7日</h4>
                            <div class="media-content" >今日全国各地的队友到成都集合如果您的时间比较宽裕领袖户外的领队已经在酒店等大家了。</div>
                            <div  class="media-time"><span class="left">发布时间：2005-10-21</span><span class="right">评论(1234) <small class="color_999" style="padding-left: 5px; padding-right: 5px;">|</small> 分享</span></div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="<?php echo R;?>t3/image/temp/temp4.jpg" alt="..." width="165px" height="110px">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">党岭葫芦海-丹巴藏寨-新都桥深度赏秋7日</h4>
                            <div class="media-content" >今日全国各地的队友到成都集合如果您的时间比较宽裕领袖户外的领队已经在酒店等大家了。</div>
                            <div  class="media-time"><span class="left">发布时间：2005-10-21</span><span class="right">评论(1234) <small class="color_999" style="padding-left: 5px; padding-right: 5px;">|</small> 分享</span></div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="<?php echo R;?>t3/image/temp/temp5.jpg" alt="..." width="165px" height="110px">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">党岭葫芦海-丹巴藏寨-新都桥深度赏秋7日</h4>
                            <div class="media-content" >今日全国各地的队友到成都集合如果您的时间比较宽裕领袖户外的领队已经在酒店等大家了。</div>
                            <div  class="media-time"><span class="left">发布时间：2005-10-21</span><span class="right">评论(1234) <small class="color_999" style="padding-left: 5px; padding-right: 5px;">|</small> 分享</span></div>
                        </div>
                    </div>
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="<?php echo R;?>t3/image/temp/temp4.jpg" alt="..." width="165px" height="110px">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">党岭葫芦海-丹巴藏寨-新都桥深度赏秋7日</h4>
                            <div class="media-content" >今日全国各地的队友到成都集合如果您的时间比较宽裕领袖户外的领队已经在酒店等大家了。</div>
                            <div  class="media-time"><span class="left">发布时间：2005-10-21</span><span class="right">评论(1234) <small class="color_999" style="padding-left: 5px; padding-right: 5px;">|</small> 分享</span></div>
                        </div>
                    </div>  <div class="media">
                    <div class="media-left">
                        <a href="#">
                            <img class="media-object" src="<?php echo R;?>t3/image/temp/temp5.jpg" alt="..." width="165px" height="110px">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">党岭葫芦海-丹巴藏寨-新都桥深度赏秋7日</h4>
                        <div class="media-content" >今日全国各地的队友到成都集合如果您的时间比较宽裕领袖户外的领队已经在酒店等大家了。</div>
                        <div  class="media-time"><span class="left">发布时间：2005-10-21</span><span class="right">评论(1234) <small class="color_999" style="padding-left: 5px; padding-right: 5px;">|</small> 分享</span></div>
                    </div>
                </div>
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="<?php echo R;?>t3/image/temp/temp4.jpg" alt="..." width="165px" height="110px">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">党岭葫芦海-丹巴藏寨-新都桥深度赏秋7日</h4>
                            <div class="media-content" >今日全国各地的队友到成都集合如果您的时间比较宽裕领袖户外的领队已经在酒店等大家了。</div>
                            <div  class="media-time"><span class="left">发布时间：2005-10-21</span><span class="right">评论(1234) <small class="color_999" style="padding-left: 5px; padding-right: 5px;">|</small> 分享</span></div>
                        </div>
                    </div>  <div class="media">
                    <div class="media-left">
                        <a href="#">
                            <img class="media-object" src="<?php echo R;?>t3/image/temp/temp5.jpg" alt="..." width="165px" height="110px">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">党岭葫芦海-丹巴藏寨-新都桥深度赏秋7日</h4>
                        <div class="media-content" >今日全国各地的队友到成都集合如果您的时间比较宽裕领袖户外的领队已经在酒店等大家了。</div>
                        <div  class="media-time"><span class="left">发布时间：2005-10-21</span><span class="right">评论(1234) <small class="color_999" style="padding-left: 5px; padding-right: 5px;">|</small> 分享</span></div>
                    </div>
                </div>
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="<?php echo R;?>t3/image/temp/temp4.jpg" alt="..." width="165px" height="110px">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">党岭葫芦海-丹巴藏寨-新都桥深度赏秋7日</h4>
                            <div class="media-content" >今日全国各地的队友到成都集合如果您的时间比较宽裕领袖户外的领队已经在酒店等大家了。</div>
                            <div  class="media-time"><span class="left">发布时间：2005-10-21</span><span class="right">评论(1234) <small class="color_999" style="padding-left: 5px; padding-right: 5px;">|</small> 分享</span></div>
                        </div>
                    </div>
                </div>


                <!-- start-五指分页-->
                <div style="text-align:center;">
                    <nav>
                        <ul class="pagination">
                            <li title="按住向左方向键 向前翻页"><a href="/mec/beijing/0-0-0-0-1.html">&lt;</a></li>
                            <li><a class="active"  href="/mec/beijing/0-0-0-0-1.html">1</a></li>
                            <li><a href="/mec/beijing/0-0-0-0-2.html">2</a></li>
                            <input type="hidden" id="page-up" value="/mec/beijing/0-0-0-0-1.html">
                            <input type="hidden" id="page-next" value="/mec/beijing/0-0-0-0-2.html">
                            <script>$(this).focus();</script><li title="按住向右方向键 向后翻页"><a href="/mec/beijing/0-0-0-0-2.html">&gt;</a>
                        </li>
                        </ul>
                    </nav>
                </div>
                <!--end  五指分页 -->

            </div><!-- col-xs-8  -->

            <div class="col-xs-4 ">
                <div class="right-bg-box" style="padding-top: 20px; padding-bottom: 20px;">
                    <div class="ad-box-first" style="height: 300px; width: 100%; background: #dddddd"></div>
                    <div class="lm-title margin_bottom15">
                        <h3 class="lm-title-left">浏览排行 </h3>
                        <a href="" class="lm-title-right"><small>+更多</small> </a>
                    </div>
                    <div class="list-ol-box-2">
                        <ol class="rectangle-list-2">
                            <li ><a href="">习近平向金正恩致贺电 刘云山会见金正恩(图)刘云山会见金正恩</a></li>
                            <li><a href="">李克强送政策大红包</a> </li>
                            <li><a href="">电动汽车行业获发展良机 </a></li>
                            <li><a href="">南京大屠杀档案 “申遗”成功</a></li>
                            <li><a href="">慰安妇档案落选朝鲜将举行建党70周年阅兵</a> </li>
                            <li><a href="">全国多发1个月工资平壤生活的日与夜 </a></li>
                            <li><a href="">电动汽车行业获发展良机 </a></li>
                            <li><a href="">南京大屠杀档案 “申遗”成功</a></li>
                            <li><a href="">慰安妇档案落选朝鲜将举行建党70周年阅兵</a> </li>
                            <li><a href="">全国多发1个月工资平壤生活的日与夜 </a></li>
                        </ol>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="friend-link">

        <a href="http://www.52pk.com/" target="_blank">52PK游戏网 </a><a href="http://www.chinaz.com" target="_blank">站长之家</a><a href="http://www.admin5.com/" target="_blank">站长网</a><a href="http://www.leiphone.com/" target="_blank">雷锋网</a><a href="http://www.ctocio.com.cn/" target="_blank">IT专家网 </a><a href="http://www.ithome.com/" target="_blank">IT之家</a><a href="http://www.ebrun.com/" target="_blank">亿邦动力网</a><a href="http://www.weiphone.com/" target="_blank">iPhone威锋网</a><a href="http://www.yzmg.com" target="_blank">亿智蘑菇</a><a href="http://www.tompda.com/" target="_blank">智能手机</a><a href="http://www.ikanchai.com" target="_blank">砍柴网</a><a href="http://www.fengniao.com/" target="_blank">蜂鸟网</a><a href="http://www.weiot.net " target="_blank">威腾网</a><a href="http://www.dop2p.com/" target="_blank">互联网金融门户</a><a href="http://www.3533.com/" target="_blank">手机世界</a><a href="http://www.uc.cn/" target="_blank">手机浏览器</a><a href="http://www.9466.com/" target="_blank">9466网页助手</a><a href="http://www.hqbpc.com" target="_blank">华强北电脑网</a><a href="http://www.uisdc.com/" target="_blank">优秀网页设计</a><a href="http://hao.360.cn/" target="_blank">360安全网址导航</a><a href="http://www.1616.net/" target="_blank">1616个人门户</a><a href="http://www.sudu.cn/" target="_blank">华夏名网</a><a href="http://www.szsmw.com/Default.shtml" target="_blank">神州商贸网</a><a href="http://www.ciotimes.com/" target="_blank">CIO时代网</a><a href="http://www.nmglabs.com/" target="_blank">内蒙古IT实验室</a><a href="http://www.cnzz.cn/" target="_blank">中国站长</a><a href="http://www.xmtnews.com/" target="_blank">新媒体观察</a><a href="http://www.oneplusbbs.com" target="_blank">一加手机</a>

    </div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>