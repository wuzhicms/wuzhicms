<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<link href="<?php echo R;?>js/colorpicker/style.css" rel="stylesheet">
<link href="<?php echo R;?>js/jquery-ui/jquery-ui.css" rel="stylesheet">
<script src="<?php echo R;?>js/colorpicker/color.js"></script>
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">

                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-9">
                            收件人：［<?php echo $er['addressee'].'］ 电话：［'.$er['mobile'].'］ '.$er['tel'].'<br> 收货地址：［'.$er['province'].$er['city'].$er['area'].$er['address'].'］邮编：［'.$er['zipcode'];?>］
                        </div>
                    </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"><?php echo $r['express'];?>：快递单号</label>
                            <div class="col-sm-9">
                                <input name="snid" class="form-control" type="text" value="<?php echo $r['snid'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">备注（管理员可见）</label>
                            <div class="col-sm-9">
                                <textarea name="note" class="form-control" cols="60" rows="3"><?php echo $r['note'];?></textarea>                </div>
                        </div>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</section>

