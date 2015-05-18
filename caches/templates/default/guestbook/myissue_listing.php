<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>
<script src="<?php echo R;?>member/js/jscarousel.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#jsCarousel').jsCarousel({ onthumbnailclick: function(src) {
            // 可在这里加入点击图片之后触发的效果
            $("#overlay_pic").attr('src', src);
            $(".overlay").show();
        }, autoscroll: true });

        $(".overlay").click(function(){
            $(this).hide();
        });
    });
</script>
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
                        <header class="panel-heading"><span class="title">我的提问</span><span class="pull-right"><a href="?m=member&f=index&v=edit_email"><font color="#dc143c"> 您的邮箱还未通过验证，验证后，可以通过邮箱获得回复提醒，点击验证</font></a></span></header>

                        <div class="myask">我的提问：<span class="info"><?php echo $total;?>次</span></div>
                        <div class="submitbtn"><a href="index.php?m=guestbook&f=myissue&v=newask" class="btn">我要提问</a></div>
                        <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">
                            <div class="panel-body" id="panel-bodys">
                                <table class="table table-striped table-advance table-hover text-center">
                                    <thead>
                                    <tr>
                                        <th class="tablehead">ID</th>
                                        <th class="tablehead" width="300">提问内容</th>
                                        <th class="tablehead">提问时间</th>
                                        <th class="tablehead">回复人</th>
                                        <th class="tablehead" width="300">回复内容</th>
                                        <th class="tablehead">回复时间</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                                    <tr>
                                        <td ><?php echo $r['id'];?></td>
                                        <td align="left"><?php echo $r['title'];?><br><?php echo $r['content'];?></td>
                                        <td><?php echo date('Y-m-d',$r['addtime']);?></td>
                                        <td><?php echo $r['reply_user'];?></td>
                                        <td><?php echo $r['reply'];?></td>
                                        <td><?php if($r['replytime']) { ?><?php echo date('Y-m-d',$r['replytime']);?><?php } ?></td>
                                    </tr>
<?php $n++;}?>

                                    </tbody>
                                </table>
                            </div>
<?php if($total>10) { ?>
                            <!--分页开始-->
                            <div class="paginationpage text-center">
                                <nav>
                                    <ul class="pagination">
                                        <?php echo $pages;?>
                                    </ul>
                                </nav>
                            </div>
                            <?php } ?>
                            <!--分页结束-->
                        </div>
                    </section>
                </div>

            </div>
            <!--右侧结束-->


        </div>
    </div>
</div>
<!--正文部分-->
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>

