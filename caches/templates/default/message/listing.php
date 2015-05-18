<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>
<!--正文部分-->
<div class="container adframe">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo R;?>js/wuzhicms.js"></script>

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
                        <header class="panel-heading"><span class="title">我的私信</span></header>

                        <ul id="myTab" class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tabs1" id="1tab" role="tab" data-toggle="tab" aria-controls="tabs1" aria-expanded="true">私信（<?php echo $total;?>）</a></li>
                        </ul>

                        <div id="myTabContent" class="tab-content tabsbordertop">

                            <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">
                                <div class="panel-body" id="panel-bodys">
                                    <table class="table table-striped table-advance table-hover text-center">
                                        <thead>
                                        <tr>
                                            <th class="tablehead" colspan="7">
                                                <form name="myform" action="" method="post"><div class="pull-left"><a href="?m=message&f=message&v=add" class="btn btn-order">发私信</a> <a href="javascript:makedo('index.php?m=message&f=message&v=make_empty', '确认要清空收件夹？')" class="btn btn-white">清空所有私信</a> </div> <div class="col-md-3 pull-right"><div class="input-group"><input type="text" name="keyword" class="form-control" placeholder="查找联系人或私信"><span class="input-group-btn"><button class="btn btn-order" type="submit">搜索</button></span></div></div></form> </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                                        <tr>
                                            <td class="messagelist">
                                                <a href="?m=message&f=message&v=add&username=<?php echo $r['username'];?>">
                                                <div class="userphoto"><img src="<?php echo avatar($r['uid'],180);?>" alt=""></div>
                                                <div class="username"><h5><?php echo $r['username'];?>：<span><?php echo time_format($r['addtime']);?></span></h5></div>
                                                <div class="usermessage"><?php echo $r['content'];?></div></a>
                                            </td>
                                        </tr>
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