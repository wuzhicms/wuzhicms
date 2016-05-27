<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>
<script type="text/javascript" src="<?php echo R;?>js/base.js"></script>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" >
                    <h5>系统消息</h5>
                </div>
                <div class="ibox-content">
                    <div>
                        <table class="table-dashed table-advance table-hover ">
                            <tbody>
                            <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
                            <tr>
                                <td class="messagelist">
                                        <div class="userphoto"><i class="fa fa-volume-up" style="font-size: 16px;"></i></div>
                                        <div class="username"><h4 style="<?php echo $r['css'];?>"><?php echo $r['title'];?><span style="color: #999;"><?php echo time_format($r['addtime']);?></span></h4></div>
                                        <div class="usermessage"><?php echo $r['content'];?></div>
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
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","foot"); ?>
<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>
</body>
</html>