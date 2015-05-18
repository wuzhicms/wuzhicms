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
                        <header class="panel-heading"><span class="title">账户余额</span></header>

                        <div class="mymoney">可用余额：<span class="myprice">￥<?php echo $memberinfo['money'];?></span> 账户状态：<span class="state">有效</span></div>

                        <ul id="myTab" class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#tabs1" id="1tab" role="tab" data-toggle="tab" aria-controls="tabs1" aria-expanded="true">账户收支明细</a></li>
                            <li role="presentation"><a href="?m=pay&f=payment&v=pay&acbar=1" id="2tab">在线充值</a></li>
                        </ul>


                        <div id="myTabContent" class="tab-content tabsbordertop">

                            <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">
                                <div class="panel-body" id="panel-bodys">
                                    <table class="table table-striped table-advance table-hover text-center">
                                        <thead>
                                        <tr>
                                            <th class="tablehead">支付单号</th>
                                            <th class="tablehead">交易时间</th>
                                            <th class="tablehead">支付方式</th>
                                            <th class="tablehead">金额</th>
                                            <th class="tablehead">支付状态</th>
                                            <th class="tablehead">操作</th>
                                        </tr>

                                        </thead>
                                        <tbody>
                                        <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                                        <tr <?php if($n%2==0) { ?>class="tabletr"<?php } ?>>
                                            <td width="20%" align="center"><?php echo $r['order_no'];?></td>
                                            <td width="20%" align="center"><?php echo date('Y-m-d H:i:s',$r['addtime']);?></td>
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
                                                <a class="btn" href="index.php?m=pay&f=payment&v=repay&id=<?php echo $r['id'];?>&acbar=3" target="_blank">付款</a>
                                                <?php } elseif ($r['status']==1) { ?>
                                                <img src="<?php echo R;?>images/right.png">
                                                <?php } ?>
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