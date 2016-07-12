<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>

                <div class="panel-body">
                    <form class="form-horizontal tasi-form" method="post" action="">
                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label">文本类型</label>
                            <div class="col-sm-8 input-group">
                                <label class="radio-inline">
                                    <input type="radio" name="msgtype" value="1" <?php if(output($setting,'msgtype')) echo 'checked';?> onclick="set_type(this.value)">文本回复
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="msgtype" value="0" <?php if(!output($setting,'msgtype')) echo 'checked';?> onclick="set_type(this.value)">图文回复
                                </label>
                            </div>
                        </div>
                        <div class="msgtype0 form-group <?php if($setting['msgtype']==1) echo 'hide';?>" style="border-top: 2px #F1F2F7 outset;padding-top: 10px;">
                            <label class="col-sm-2 col-xs-4 control-label">内容1</label>
                            <div class="col-sm-8">
                                <table class="table">
                                    <tr>
                                        <th width="50">标题</th>
                                        <th><input type="text" name="titles[1]" class="form-control" value="<?php echo $setting['content'][0]['Title'];?>"></th>
                                    </tr>

                                    <tr>
                                        <th>图片</th>
                                        <th><div class="input-group"><?php echo WUZHI_form::attachment('','1','imgs[1]',$setting['content'][0]['PicUrl']);?></div></th>
                                    </tr>
                                    <tr>
                                        <th>链接</th>
                                        <th><input type="text" name="urls[1]" class="form-control" value="<?php echo $setting['content'][0]['Url'];?>"></th>
                                    </tr>
                                    <tr>
                                        <th>描述</th>
                                        <th><input type="text" name="des[1]" class="form-control" value="<?php echo $setting['content'][0]['Description'];?>"></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="msgtype0 form-group <?php if($setting['msgtype']==1) echo 'hide';?>" style="border-top: 2px #F1F2F7 outset;padding-top: 10px;">
                            <label class="col-sm-2 col-xs-4 control-label">内容2</label>
                            <div class="col-sm-8">
                                <table class="table">
                                    <tr>
                                        <th width="50">标题</th>
                                        <th><input type="text" name="titles[2]" class="form-control" value="<?php echo $setting['content'][1]['Title'];?>"></th>
                                    </tr>

                                    <tr>
                                        <th>图片</th>
                                        <th><div class="input-group"><?php echo WUZHI_form::attachment('','1','imgs[2]',$setting['content'][1]['PicUrl']);?></div></th>
                                    </tr>
                                    <tr>
                                        <th>链接</th>
                                        <th><input type="text" name="urls[2]" class="form-control" value="<?php echo $setting['content'][1]['Url'];?>"></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="msgtype0 form-group <?php if($setting['msgtype']==1) echo 'hide';?>"  style="border-top: 2px #F1F2F7 outset;padding-top: 10px;">
                            <label class="col-sm-2 col-xs-4 control-label">内容3</label>
                            <div class="col-sm-8">
                                <table class="table">
                                    <tr>
                                        <th width="50">标题</th>
                                        <th><input type="text" name="titles[3]" class="form-control" value="<?php echo $setting['content'][2]['Title'];?>"></th>
                                    </tr>

                                    <tr>
                                        <th>图片</th>
                                        <th><div class="input-group"><?php echo WUZHI_form::attachment('','1','imgs[3]',$setting['content'][2]['PicUrl']);?></div></th>
                                    </tr>
                                    <tr>
                                        <th>链接</th>
                                        <th><input type="text" name="urls[3]" class="form-control" value="<?php echo $setting['content'][2]['Url'];?>"></th>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="msgtype1 form-group <?php if($setting['msgtype']==0) echo 'hide';?>" style="border-top: 2px #F1F2F7 outset;padding-top: 10px;">
                            <label class="col-sm-2 col-xs-4 control-label">文本内容</label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <textarea name="text_content" class="form-control" cols="60" rows="5"><?php echo $text_content;?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 col-xs-4 control-label"></label>
                            <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                                <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                            </div>
                        </div>

                    </form>
                </div>

            </section>
        </div>

    </div>
    <!-- page end--><div class="alert alert-success fade in">
        <strong>使用提示:</strong> 目前自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。一级菜单最多4个汉字，二级菜单最多7个汉字，多出来的部分将会以“...”代替。请注意，创建自定义菜单后，由于微信客户端缓存，需要24小时微信客户端才会展现出来。建议测试时可以尝试取消关注公众账号后再次关注，则可以看到创建后的效果。
        更多开发规则，请参考<a href="http://mp.weixin.qq.com/wiki/13/43de8269be54a0a6f64413e4dfa94f39.html" target="_blank">《微信开发者文档》</a>
    </div>
</section>
<script>
    function set_type(type) {
        if(type==1) {
            $('.msgtype1').removeClass('hide');
            $('.msgtype0').addClass('hide');
        } else {
            $('.msgtype0').removeClass('hide');
            $('.msgtype1').addClass('hide');
        }
    }
</script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>

