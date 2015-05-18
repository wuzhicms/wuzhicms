<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>

<!--正文部分-->
<div class="container adframe">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            
        </div>
    </div>
</div>

<div class="container memberframe">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <!--左侧开始-->
            <div class="memberleft">
                <div class="membertitle"><h3>会员中心</h3></div>
                <div class="memberborder">
                    <?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','left'); ?>
                </div>
            </div>
            <!--左侧结束-->

            <!--右侧开始-->
            <div class="memberright">

                <div class="memberbordertop">
                    <section class="panel">
                        <header class="panel-heading"><span class="title">我的好友圈（<?php echo $total;?>个）</span></header>

                        <ul id="myTab" class="nav nav-tabs" role="tablist">
                            <?php if($this->memberinfo['modelid']!=23) { ?>
                            <li role="presentation" ><a href="?m=member&f=friend&v=listing" id="1tab" >为你推荐</a></li>
                            <?php } ?>
                            <li role="presentation" ><a href="?m=member&f=friend&v=myfriend">我的好友</a></li>
                            <li role="presentation" class="active"><a href="?m=member&f=friend&v=myfans">我的粉丝</a></li>
                            <div class="col-md-3 pull-right" style="padding-top:3px;">
                                <form name="search" action="index.php?m=member&f=friend&v=search" method="post">
                                <div class="input-group"><input type="text" name="username" class="form-control" placeholder="输入会员名"><span class="input-group-btn"><button class="btn btn-order" type="submit">搜索</button></span></div></form>
                            </div>
                        </ul>

                        <div id="myTabContent" class="tab-content tabsbordertop">

                            <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">
                                <div class="panel-body" id="panel-bodys">
                                    <table class="table table-striped table-advance table-hover text-center">

                                        <tbody>
                                        <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                                        <?php if(($n-1)%3==0) { ?><tr><?php } ?>
                                            <td class="friendblock">
                                                <div class="friendli">
                                                    <div class="friendimg"><img src="<?php echo avatar($r['uid'],180);?>" alt=""></div>
                                                    <span><?php if($r['rtype']==1) { ?><i class="friendeachicon"></i>互相关注<?php } elseif ($r['rtype']==2) { ?><i class="vfriendeachicon"></i>已关注<?php } else { ?><span onclick="guanzhu(<?php echo $r['uid'];?>,this)" style="cursor: pointer"><i class=""></i>点击关注</span><?php } ?></span>
                                                    <?php if($r['rtype']!=3) { ?><span class="btn" onclick="cancelgz(<?php echo $r['uid'];?>,this)">取消关注</span><?php } ?>

                                                    <div class="description">会员名：<?php echo $r['member_info']['username'];?><?php if($r['member_info']['truename']) { ?> 真实姓名：<?php echo $r['member_info']['truename'];?><?php } ?></div>

                                                </div>
                                            </td>
                                            <?php if(($n-1)%3==2) { ?></tr><?php } ?>
                                        <?php $n++;}?>

                                        </tbody>
                                    </table>
                                </div>

                                <!--分页开始-->
                                <div class="paginationpage text-center">
                                    <nav>
                                        <ul class="pagination">
                                            <?php echo $pages;?>
                                        </ul>
                                    </nav>
                                </div>
                                <!--分页结束-->

                            </div>


                            <div role="tabpanel" class="tab-pane fade" id="tabs2" aria-labelledby="2tab">
                                已移除好友圈
                            </div>


                        </div>
                    </section>
                </div>

            </div>
            <!--右侧结束-->
        </div>
    </div>
</div>
<script >
function cancelgz(uuid,obj) {
    $.post("index.php?m=member&f=friend&v=cancelgz", { uuid: uuid, time: Math.random()},
            function(data){
                $(obj).html('已取消');
            });

}
function guanzhu(uuid,obj) {
    $.post("index.php?m=member&f=friend&v=guanzhu", { uuid: uuid, time: Math.random()},
            function(data){
                $(obj).html('已关注');
            });

}
</script>
<!--正文部分-->
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>