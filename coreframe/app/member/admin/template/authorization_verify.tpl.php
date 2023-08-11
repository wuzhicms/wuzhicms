<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body>
    <section class="wrapper">
        <section class="panel">
            <header class="panel-heading"><span>认证信息</span></header>
            <div class="panel-body">
                <form action="index.php?m=member&f=authorization&v=do_verify<?php echo $this->su(); ?>" method="post" class="form-horizontal tasi-form">

                    <?php
                        foreach ($result as $field => $value) {
                            ?>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"><?php echo $model_field[$field]['name'];?></label>
                                <div class="col-lg-3 col-sm-4 col-xs-4">
                                    <?php
                                    $boxData = array();
                                        $option = explode("\n", $model_field[$field]['setting']['options']);
                                        foreach ($option as $optionData) {
                                            $eachOption = explode('|', trim($optionData));
                                            $boxData[$eachOption[1]] = $eachOption[0];
                                        }
                                    ?>

                                    <input type="text" class="form-control" value="<?php
                                    if($model_field[$field]['formtype'] == 'box') {
                                        echo $boxData[$value];
                                    } else {
                                        echo $value;
                                    }
                                    ?>" readonly="readonly">
                                </div>
                            </div>
                            <?php
                        }
                    ?>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">审批意见</label>
                        <div class="col-lg-3 col-sm-4 col-xs-4">
                            <textarea name="remark" class="form-control" rows="5"></textarea>
                        </div>
                    </div>

                    <input name="uid" hidden value="<?php echo $uid?>">
                    <input name="modelid" hidden value="<?php echo $modelid?>">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                        <div class="col-lg-3 col-sm-4 col-xs-4">
                            <div class="d-flex">
                                <input name="sub" type="submit" value="通过" class="btn w-50 me-2 btn-info">
                                <input name="sub" type="submit" value="驳回" class="btn w-50 ms-2 btn-danger">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

</section>
<?php include $this->template('footer','core');?>