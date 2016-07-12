<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>
<!--正文部分-->
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <ul class="nav nav-tabs">
                        <li ><a href="index.php?m=content&f=contribute&v=newinfo">投稿</a></li>
                        <li class="active"><a href="index.php?m=content&f=contribute&v=listing">我的投稿</a>
                        </li>
                    </ul>

                         <div class="project-list">

                            <table class="table table-hover">
                                <tbody>
                                <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                                    <tr>

                                        <td class="project-title">
                                            <strong><?php echo $r['title'];?></strong>
                                            <br/>
                                            <small>时间: <?php echo date('Y-m-d H:i:s',$r['addtime']);?></small>
                                        </td>
                                        <td class="project-status">
                                            <?php if($r['status']==0) { ?><span class="label label-default">已删除</span><?php } elseif ($r['status']==9) { ?><span class="label label-primary">审核通过</span><?php } else { ?><span class="label label-danger">待审核</span><?php } ?>
                                        </td>
                                        <td class="project-actions">
                                            <a href="?m=content&f=contribute&v=view&id=<?php echo $r['id'];?>" class="btn btn-white btn-sm" target="_blank"><i class="fa fa-folder"></i> 查看 </a>
                                            <a href="?m=content&f=contribute&v=edit&id=<?php echo $r['id'];?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>
                                            <a href="?m=content&f=contribute&v=delinfo&id=<?php echo $r['id'];?>" class="btn btn-white btn-sm"><i class="fa fa-recycle"></i> 删除 </a>
                                        </td>
                                    </tr>
<?php $n++;}?>
                                    </tbody>
                                </table>
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","foot"); ?>
</body>
</html>

