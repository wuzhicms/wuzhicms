<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
    <section class="panel">
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        <div class="panel-body">
            <form class="form-horizontal tasi-form" method="post" action="">
                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">动作名称</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4">
                        <input type="text" class="form-control" name="name">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">动作方法名</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4">
                        <input type="text" id="action" class="form-control" name="action" value="" placeholder="开发人员专用">
                        <span class="input-group-btn"><select onchange="set_action(this.value)" class="form-select">
                        <option value="addnews">选择方法</option>
                        <option value="addnews">添加内容</option>
                        <option value="editnews">编辑内容</option>
                        <option value="checknews">审核内容</option>
                        <option value="register">注册</option>
                        <option value="login">登录</option>
                        </select></span>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">操作类型</label>
                    <div class="align-items-center col-lg-3 col-sm-4 col-xs-4 d-flex">
                        <div class="form-check form-check-inline mb-0 mt-2">
                            <input class="form-check-input" type="radio" name="type" id="inlineRadio1" value="1" checked>
                            <label class="form-check-label" for="inlineRadio1">增加</label>
                        </div>
                        <div class="form-check form-check-inline mb-0 mt-2">
                            <input class="form-check-input" type="radio" name="type" id="inlineRadio2" value="2">
                            <label class="form-check-label" for="inlineRadio2">减少</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">积分数量</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4">
                        <input type="text" class="form-control" name="point" value="" placeholder="正整数">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">积分次数限制</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4">
                        <input type="text" class="form-control" name="quantity" value="1000" placeholder="正整数">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end">策略所在频道</label>
                    <div class="col-lg-3 col-sm-4 col-xs-4">
                        <select name="cid" class="form-select">
                            <option value="">选择频道</option>
                            <?php
                                foreach($big_categorys as $_cat) {
                            ?>
                            <option value="<?php echo $_cat['cid'];?>"><?php echo $_cat['name'];?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
                    <div class="col-lg-3 col-sm-4 col-xs-4">
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
    function set_action(text) {
        $('#action').val(text);
    }
</script>
<?php include $this->template('footer','core');?>


