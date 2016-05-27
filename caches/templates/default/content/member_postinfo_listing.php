<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","head"); ?>
<body class="gray-bg">
<?php if($set_iframe==0) { ?>
    <?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","iframetop"); ?>
<?php } else { ?>
    <div style="padding-top: 15px;"></div>
<?php } ?>
<div class="container-fluid  ie8-member">
    <div class="row">
        <?php if($set_iframe==0) { ?>
        <div class="col-sm-3">
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

        <div class="<?php if($set_iframe==0) { ?>col-sm-9<?php } else { ?>col-sm-12<?php } ?>">

            <div class="row">
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <ul class="nav nav-tabs">
                                <li ><a href="index.php?m=content&f=postinfo&v=newinfo&cid=<?php echo $cid;?>&set_iframe=<?php echo $set_iframe;?>"><?php echo $catname;?> - 信息发布</a></li>
                                <li class="active"><a href="index.php?m=content&f=postinfo&v=listing&cid=<?php echo $cid;?>&set_iframe=<?php echo $set_iframe;?>">我发布的<?php echo $catname;?></a>
                                </li>
                            </ul>

                            <div class="project-list">

                                <table class="table table-hover">
                                    <tbody>
                                    <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                                    <tr>

                                        <td class="project-title">
                                            <?php if($r['status']==9) { ?> <a href="<?php echo $r['url'];?>"><?php echo $r['title'];?></a><?php } else { ?><strong><?php echo $r['title'];?></strong><?php } ?>
                                            <br/>
                                            <small>时间: <?php echo date('Y-m-d H:i:s',$r['addtime']);?></small>
                                        </td>
                                        <td class="project-status" width="100">
                                            <?php if($r['status']==0) { ?><span class="label label-default">已删除</span><?php } elseif ($r['status']==9) { ?><span class="label label-primary">审核通过</span><?php } else { ?><span class="label label-danger">待审核</span><?php } ?>
                                        </td>
                                        <td class="project-actions">
                                            <a href="?m=content&f=postinfo&v=edit&cid=<?php echo $r['cid'];?>&id=<?php echo $r['id'];?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>
                                            <?php if($r['status']!=0) { ?>
                                            <a href="?m=content&f=postinfo&v=delinfo&cid=<?php echo $r['cid'];?>&id=<?php echo $r['id'];?>" class="btn btn-white btn-sm"><i class="fa fa-recycle"></i> 删除 </a><?php } ?>
                                        </td>
                                    </tr>
                                    <?php $n++;}?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="paginationpage text-center">
                                <nav>
                                    <ul class="pagination">
                                        <?php echo $pages;?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","foot"); ?>
