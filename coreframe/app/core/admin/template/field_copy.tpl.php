<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel tasks-widget">
                <header class="panel-heading">
                    <span>字段名称：<?php echo $fieldname;?> (<?php echo $field;?>)</span>
                </header>
                <form name="form1" method="post" action="">

                <div class="panel-body" id="panel-bodys">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="tablehead center">目标模型 - 目标模型如果存在该字段，字段配置将被覆盖</th>
                        </tr>
                        </thead>
                        <tr>
                        <td><div class="col-lg-12 col-sm-12"><?php
                            echo $form->select($models_arr, 0, 'name="modelids[]" style="height:160px;" class="form-control" size=2 multiple', '按住Ctrl或Command多选');
                            ?></div></td>
                        </tr>
                        <tr><td colspan="2" class="text-center">
                                <input name="forward" type="hidden" value="<?php echo HTTP_REFERER;?>">
                                <button type="submit" class="btn btn-primary" name="submit"><i class=" icon-angle-double-right btn-icon"></i>确认复制</button></td></tr>
                        </table>
                </div>
            </form>
            </section>
        </div>
    </div>
</section>
<script type="text/javascript">
    window.scrollTo(0,0);
</script>
<?php include $this->template('footer','core');?>


