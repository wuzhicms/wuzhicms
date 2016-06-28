<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","head"); ?>
<body class="gray-bg">
<?php if($set_iframe==0) { ?>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","iframetop"); ?>
<?php } else { ?>
<div style="padding-top: 15px;"></div>
<?php } ?>
<div class="container-fluid  ie8-member">
    <div class="row row-40" >
        <?php if($set_iframe==0) { ?>
        <div class="col-sm-3 left-nav padding-right0">
            <!--左侧导航-->
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="nav-close"><i class="fa fa-times-circle"></i>
                </div>
                <div class="slimScrollDiv" style="position: relative; width: auto; height: 100%;">
                    <div class="sidebar-collapse" style="width: auto; height: 100%;">
                        <?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","left"); ?>
                    </div>
                </div>
            </nav>
            <!--end 左侧导航-->
        </div><!--col-sm-3--><?php } ?>

        <div class="<?php if($set_iframe==0) { ?>col-sm-9<?php } else { ?>col-sm-12<?php } ?>  paddingleft0">

            <div class="row">
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>我的提问 <?php echo $total;?>次</h5><span class="pull-right"><a href="?m=member&f=index&v=edit_email&set_iframe=<?php echo $set_iframe;?>"><font color="#dc143c"> 您的邮箱还未通过验证，验证后，可以通过邮箱获得回复提醒，点击验证</font></a></span>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <section class="panel">

                                    <div class="submitbtn"><a href="index.php?m=guestbook&f=myissue&v=newask&set_iframe=<?php echo $set_iframe;?>" class="btn btn-danger">我要提问</a></div>
                                    <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">
                                        <div class="panel-body" id="panel-bodys">
                                            <table class="table  table-advance table-hover  table-bordered">
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
                                                    <td align="left"><div style="font-weight: 600; margin-bottom: 5px; "><?php echo $r['title'];?> </div> <?php echo $r['content'];?></td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>

