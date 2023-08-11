<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<link href="<?php echo R;?>libs/colorpicker/style.css" rel="stylesheet">

<script src="<?php echo R;?>libs/colorpicker/color.js"></script>
<section class="wrapper">
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">留言时间</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <?php echo date('Y-m-d H:i',$r['addtime']);?>
                    </div>
                </div>
                <?php
                if(is_array($formdata['0']))
                    foreach($formdata['0'] as $field=>$info){
                        if($info['powerful_field']) continue;
                        if($info['formtype']=='powerful') {
                            foreach($formdata['0'] as $_fm=>$_fm_value) {
                                if($_fm_value['powerful_field']) {
                                    $info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
                                }
                            }
                            foreach($formdata['1'] as $_fm=>$_fm_value) {
                                if($_fm_value['powerful_field']) {
                                    $info['form'] = str_replace('{'.$_fm.'}',$_fm_value['form'],$info['form']);
                                }
                            }
                        }
                        ?>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"><?php echo $info['name']?></label>
                            <div class="col-lg-3 col-sm-6 col-xs-6"><?php echo $r[$field];?></div>
                        </div>
                    <?php }?>

                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">回复</label>
                    <div class="col-lg-8 col-sm-8 col-xs-8">
                        <?php echo WUZHI_form::editor('reply','reply',$r['reply']);?>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">回复人</label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input type="text" class="form-control" name="reply_user" placeholder="<?php echo $reply_user;?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                    <div class="col-lg-3 col-sm-6 col-xs-6">
                        <input name="forward" type="hidden" value="<?php echo HTTP_REFERER;?>">
                        <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- page end-->
</section>
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3
        });
    })
    var fontweight = '';
    function change_fontweight() {
        if(fontweight=='') {
            $("#title").css('font-weight','bold');
            fontweight = 1;
            $("#font_weight").val('font-weight:bold');
        } else {
            $("#title").css('font-weight','normal');
            fontweight = '';
            $("#font_weight").val('');
        }
    }
</script>
<?php include $this->template('footer','core');?>