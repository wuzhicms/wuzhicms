<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
$menu_r = $this->db->get_one('menu',array('m'=>'topic','f'=>'index','v'=>'list_manage'));
$submenuid = $menu_r['menuid'];
?>
<body>
<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading d-flex p-0">
                    <?php echo $this->menu($submenuid,'&tid='.$tid);?>
                    <form class="position ms-auto p-3"  action="" method="get">
                        <input name="m" value="topic" type="hidden">
                        <input name="f" value="index" type="hidden">
                        <input name="v" value="search" type="hidden">
                        <input name="type" value="<?php echo $type;?>" type="hidden">
                        <input name="_su" value="<?php echo $GLOBALS['_su'];?>" type="hidden">
                        <input name="status" value="<?php echo $status;?>" type="hidden">
                        <input name="cid" value="<?php echo $cid;?>" type="hidden">
                        <div class="input-append dropdown">
                            <input type="text" name="title" placeholder="搜索标题" class="sr-input" value="<?php echo $title;?>">
                            <button type="submit" class="btn adsr-btn"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </header>
                <form action="?m=topic&f=index&v=list_sort<?php echo $this->su();?>" name="myform" method="post">
                    <div class="panel-body" id="panel-bodys">
                        <table class="table table-striped table-advance table-hover">
                            <thead>
                            <tr>
                                <th class="hidden-phone tablehead">排序</th>
                                <th class="tablehead">ID</th>
                                <th class="tablehead w-50">标题</th>
                                <th class="tablehead">所属大分类</th>
                                <th class="tablehead">所属子分类</th>
                                <th class="tablehead">导入时间</th>
                                <th class="tablehead">状态</th>
                                <th class="tablehead">管理操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($result AS $r) {
                            	if($r['sid']) {
									$share_item = $this->sharedb->get_one('share_item', array('sid' => $r['sid']));
									$title = $share_item['title'];
									$url = $share_item['url'];
								} elseif($r['islink']) {
										$data = $this->db->get_one('content_share', array('id' => $r['id']));
										$title = $r['title'];
										$url = $data['url'];
										$cid = $data['cid'];
								} else {
									$title = $r['title'];
									$url = WEBURL.'index.php?m=topic&v=show&tcid='.$r['tcid'];
								}
                                ?>
                                <tr>
                                    <!---排序--->
                                    <td><input name="sorts[<?php echo $r['tcid'];?>]" type="text" class="text-center form-control" style="padding:3px;width: 30px" value="<?php echo $r['sort'];?>" size="3"></td>
                                    <td><?php echo $r['tcid'];?></td>
                                    <td><a href="<?php echo $url;?>" target="_blank"><?php echo $title;?></a></td>
                                    <td><?php echo $r['kid1name'];?></td>
                                    <td><?php echo $r['kid2name'];?></td>
                                    <td><?php echo date('Y-m-d H:i:s',$r['importtime']);?></td>
									<td><?php echo $status[$r['status']];?></td>
									<td>
                                        <?php
                                            if($r['recommend'] == 0  || $r['recommend'] == 2){
                                        ?>
                                            <a href="javascript:makedo('?m=topic&f=index&v=recommend&recommend=1&tcid=<?php echo $r['tcid'];?><?php echo $this->su();?>','确认推荐？')" class="btn btn-primary btn-sm btn-xs">推荐焦点图</a>
                                        <?php
                                            }else{
                                        ?>
                                            <a href="javascript:makedo('?m=topic&f=index&v=recommend&recommend=0&tcid=<?php echo $r['tcid'];?><?php echo $this->su();?>','取消推荐？')" class="btn btn-danger btn-sm btn-xs">取消焦点图</a>
                                        <?php
                                        }
                                            if($r['recommend'] == 0 || $r['recommend'] == 1){

                                         ?>
                                                <a href="javascript:makedo('?m=topic&f=index&v=recommend&recommend=2&tcid=<?php echo $r['tcid'];?><?php echo $this->su();?>','确认推荐？')" class="btn btn-primary btn-sm btn-xs">推荐头条</a>

                                                <?php
                                            }else{
                                        ?>
                                                <a href="javascript:makedo('?m=topic&f=index&v=recommend&recommend=0&tcid=<?php echo $r['tcid'];?><?php echo $this->su();?>','取消推荐？')" class="btn btn-danger btn-sm btn-xs">取消头条</a>

                                                <?php

                                            }
										if($r['islink']) {
											?>
											<a href="?m=content&f=content&v=edit&id=<?php echo $r['id'];?>&cid=<?php echo $cid;?><?php echo $this->su();?>" class="btn btn-primary btn-sm btn-xs">修改</a>
										<?php
										} else {
                                         ?>
											<a href="?m=topic&f=index&v=edit_content&tcid=<?php echo $r['tcid'];?><?php echo $this->su();?>" class="btn btn-primary btn-sm btn-xs">修改</a>
										<?php
										}
										?>
                                        <a href="javascript:makedo('?m=topic&f=index&v=list_delete&tcid=<?php echo $r['tcid'];?><?php echo $this->su();?>', '确认删除该记录？')"
                                            class="btn btn-danger btn-sm btn-xs">删除</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <div class="panel-foot">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="panel-label">
                                    <button type="submit" name="submit" class="btn btn-default btn-sm">排序</button>
                                </div>
                                <div class="panel-label">
                                    <ul class="pagination pagination-sm">
                                        <?php echo $pages;?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
            </section>
        </div>
    </div>
    <!-- page end-->
</section>
<script type="text/javascript">
    $(function(){
        $("#index-list_manage").html("专题内容管理：<?php echo $data['name'];?>");
    })
</script>
<?php include $this->template('footer','core');?>

