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
        <div class="col-sm-3 left-nav">             <!--左侧导航-->
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

        <div class="<?php if($set_iframe==0) { ?>col-sm-9<?php } else { ?>col-sm-12<?php } ?> paddingleft0">

            <div class="row">
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>账户余额</h5>
                            <div class="submitbtn pull-right"><a href="index.php?m=pay&f=payment&v=pay&set_iframe=<?php echo $set_iframe;?>" class="right_btn btn-primary">在线充值</a></div>
                        </div>
                        <section class="ibox-content">
                            <div class="mymoney">可用余额：<span class="myprice">￥<?php echo $memberinfo['money'];?></span> 账户状态：<span class="state">有效</span></div>

                            <ul id="myTab" class="nav nav-tabs" role="tablist">
                                <li <?php if($_k==$keytype) { ?>class="active"<?php } ?>><a href="index.php?m=pay&f=payment&v=listing&set_iframe=<?php echo $set_iframe;?>">所有记录</a></li>
                                <?php $n=1; if(is_array($pay_config)) foreach($pay_config AS $_k => $_v) { ?>
                                <li <?php if($_k==$keytype) { ?>class="active"<?php } ?>><a href="index.php?m=pay&f=payment&v=listing&keytype=<?php echo $_k;?>&set_iframe=<?php echo $set_iframe;?>"><?php echo $_v;?></a></li>
                                <?php $n++;}?>
                            </ul>


                            <div id="myTabContent" class="tab-content tabsbordertop">

                                <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">
                                    <div class="panel-body" id="panel-bodys">

                                        <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                                        <table class="table table-striped table-advance table-hover text-center" style="    border-bottom: 1px dashed #EEEFF1;">
                                            <tr>
                                                <th class="tablehead" style="text-align: left;font-weight: 400;color: #BFBEC3;"><?php echo date('Y-m-d H:i:s',$r['addtime']);?></th>
                                                <th class="tablehead" colspan="4" style="text-align: left;font-weight: 400;"><?php echo $r['order_no'];?></th>

                                            </tr>
                                            <tr <?php if($n%2==0) { ?>class="tabletr"<?php } ?>>
                                                <td width="20%" align="center"><?php echo $r['payname'];?> <br><?php echo $r['remark'];?></td>
                                                <td width="10%" align="center"><?php echo $payments[$r['payment']];?></td>
                                                <td class="smprice">
                                                    <?php if($r['plus_minus']==1) { ?>
                                                    <font color='green'>+<?php echo sprintf("%.2f",$r['money']);?></font>
                                                    <?php } elseif ($r['plus_minus']==-1) { ?>
                                                    <font color='#f37800'>-<?php echo $r['money'];?></font>
                                                    <?php } ?>
                                                </td>
                                                <td width="15%" align="center"><?php echo $status_arr[$r['status']];?>
                                                </td>
                                                <td width="8%" align="center">
                                                    <?php if($r['status']==6) { ?>
                                                    <a class="btn btn-warning" href="index.php?m=pay&f=payment&v=repay&id=<?php echo $r['id'];?>&acbar=3" target="_blank">付款</a>
                                                    <?php } elseif ($r['dianping_status']==0 && $r['dianping_keyid']) { ?>
                                                    <a class="btn btn-warning" href="index.php?m=dianping&f=index&v=comment&keyid=<?php echo $r['dianping_keyid'];?>&acbar=3" target="_blank">我要点评</a>
                                                    <?php } elseif ($r['status']==1) { ?>
                                                    <img src="<?php echo R;?>images/right.png">
                                                    <?php } ?>
                                                    <?php if(($keytype==4 || $keytype==7) && $r['status']==1 && $r['apply_point']==0) { ?> <br><br>
                                                    <a class="btn btn-default" href="index.php?m=receipt&f=receipt&v=apply_point&orderid=<?php echo $r['id'];?>">上传发票-返积分</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>                                    </table>
                                        <br>

                                        <?php $n++;}?>
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
            </div>
        </div>
    </div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>