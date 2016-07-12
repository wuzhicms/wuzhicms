<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>我的收藏</h5>
                </div>
                <div class="ibox-content">
                    <?php if(empty($result)) { ?>
                    <div class="wrapper wrapper-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="text-center animated fadeInRightBig">
                                    <h3 class="font-bold">还没有收藏任何内容!</h3>
                                    <div class="error-desc">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="project-list">

                        <table class="table table-hover">
                            <tbody>
                            <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                            <tr>
                                <td class="project-title">
                                    <a href="<?php echo $r['url'];?>" target="_blank"> <?php echo $r['title'];?></a>
                                    <br/>
                                    <small>时间: <?php echo date('Y-m-d H:i:s',$r['addtime']);?></small>
                                </td>

                                <td class="project-actions">
                                    <a href="<?php echo $r['url'];?>" class="btn btn-white btn-sm" target="_blank"><i
                                            class="fa fa-folder"></i> 查看 </a>
                                    <a href="?m=member&f=biz_favorite&v=delete&fid=<?php echo $r['fid'];?>"
                                       class="btn btn-white btn-sm"><i class="fa fa-recycle"></i> 删除 </a>
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
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","foot"); ?>
</body>
</html>

