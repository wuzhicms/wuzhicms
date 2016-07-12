<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<div class="container login">
    <div class="verticalcenter">
        <div class="row">
            <div class="span7 rightline">
            <form action="" method="post" name="form-register" class="form-horizontal">
            	<div class="form-group">
					<label class="control-label">会员模型</label>
					<div class="col-sm-8">
					<?php $n=1;if(is_array($model)) foreach($model AS $v) { ?>
					<input type="radio" name="modelid" value="<?php echo $v['modelid'];?>" <?php if($modelid == $v['modelid']) { ?>checked<?php } else { ?>onclick="location.href ='index.php?m=member&v=model&modelid=<?php echo $v['modelid'];?>'"<?php } ?> /> <?php echo $v['name'];?>
					<?php $n++;}?>
					</div>
				</div>
				<?php
				if(is_array($formdata['0']))
				foreach($formdata['0'] as $field=>$info){
					if($info['powerful_field']) continue;
					if($info['formtype']=='powerful_field') {
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
				<div class="form-group">
					<label class="control-label"><?php if($info['star']) { ?><font color="red">*</font><?php } ?><?php echo $info['name'];?></label>
					<div class="col-sm-8"><?php echo $info['form'];?> <?php echo $info['remark'];?></div>
				</div>
				<?php }?>
				<div class="form-group">
                    <label class="control-label"></label>
                    <input type="submit" name="submit" class="btn btn-login" value="确认提交" />
                </div>
				</form>            
            </div>
            <div class="span5">
                <div class="connectwebsite">
                    <h6>使用合作网站登录</h6>
                    <ul>
                        <?php if($this->setting['qq_appid']) { ?><li><a href="index.php?m=member&f=index&v=auth&type=qq"><img src="<?php echo R;?>images/qqlogin.png" alt="使用QQ帐号登录" title="使用QQ帐号登录"></a></li><?php } ?>
						<?php if(isset($this->setting['sina_key'])) { ?><li><a href="<?php echo WEBURL;?>index.php?m=member&f=index&v=auth&type=sina"><img src="<?php echo R;?>images/weibologin.png" alt="使用微博帐号登录" title="使用微博帐号登录"></a></li><?php } ?>
						<?php if(isset($this->setting['baidu_key'])) { ?><li><a href="<?php echo WEBURL;?>index.php?m=member&f=index&v=auth&type=baidu"><img src="<?php echo R;?>images/baidulogin.png" alt="使用百度帐号登录" title="使用百度帐号登录"></a></li><?php } ?>
						<li><a href="#"><img src="<?php echo R;?>images/alipaylogin.png" alt="使用支付宝帐号登录" title="使用支付宝帐号登录"></a></li>
						<li><a href="#"><img src="<?php echo R;?>images/weichatlogin.png" alt="使用微信帐号登录" title="使用微信帐号登录"></a></li>
					</ul>
                </div>
            </div>
        </div>
    </div>
</div>
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<script type="text/javascript">
$(function(){
	$(".form-register").Validform({
		tiptype:3
	});
});
</script>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>