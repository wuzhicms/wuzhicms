<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body class="body pxgridsbody">
<section class="wrapper">
	<div class="panel tasks-widget">
	<header><?php echo $this->menu($GLOBALS['_menuid']);?></header>
	<div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
            <div class="form-group">
                <label class="col-sm-2 control-label">开启会员注册</label>
                <div class="col-sm-4">
                	<label class="radio-inline"><input type="radio" name="setting[register]" value="1" <?php echo $setting['register'] == 1 ? 'checked' : '';?>>是 </label>
                	<label class="radio-inline"><input type="radio" name="setting[register]" value="0" <?php echo $setting['register'] != 1 ? 'checked' : '';?> >否</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">开启邮件验证</label>
                <div class="col-sm-4">
                	<label class="radio-inline"><input type="radio" name="setting[checkemail]" value="1" <?php echo $setting['checkemail'] == 1 ? 'checked' : '';?>>是 </label>
                	<label class="radio-inline"><input type="radio" name="setting[checkemail]" value="0" <?php echo $setting['checkemail'] != 1 ? 'checked' : '';?> >否</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">开启手机验证</label>
                <div class="col-sm-4">
                	<label class="radio-inline"><input type="radio" name="setting[checkmobile]" value="1" <?php echo $setting['checkmobile'] == 1 ? 'checked' : '';?>>是 </label>
                	<label class="radio-inline"><input type="radio" name="setting[checkmobile]" value="0" <?php echo $setting['checkmobile'] != 1 ? 'checked' : '';?> >否</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">开启注册审核</label>
                <div class="col-sm-4">
                	<label class="radio-inline"><input type="radio" name="setting[checkuser]" value="1" <?php echo $setting['checkuser'] == 1 ? 'checked' : '';?>>是 </label>
                	<label class="radio-inline"><input type="radio" name="setting[checkuser]" value="0" <?php echo $setting['checkuser'] != 1 ? 'checked' : '';?> >否</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">开启邀请注册</label>
                <div class="col-sm-10">
                	<label class="radio-inline"><input type="radio" name="setting[invite]" value="1" <?php echo $setting['invite'] == 1 ? 'checked' : '';?> onclick="$('.invite_box').show()">是 </label>
                	<label class="radio-inline"><input type="radio" name="setting[invite]" value="0" <?php echo $setting['invite'] != 1 ? 'checked' : '';?> onclick="$('.invite_box').hide()" >否</label>
                	<div class="form-group invite_box" <?php echo $setting['invite'] ? '' : 'style="display:none;"'?>>
                		<label class="col-sm-2 control-label">邀请码价格</label>
                		<div class="col-sm-4"><input type="text" name="setting[inviteprice]" value="<?php echo (int)$setting['inviteprice']?>" />点</div>
                	</div>
                	<div class="form-group invite_box" <?php echo $setting['invite'] ? '' : 'style="display:none;"'?>>
                		<div class="col-sm-8">
                			<table class="table table-striped table-advance table-hover">
                				<thead>
                					<tr>
                						<th>组名</th>
                						<th>每天免费数量</th>
                						<th>每天付费数量</th>
                					</tr>
                				</thead>
                				<tbody>
                				<?php if(is_array($group))foreach($group as $r) {?>
                					<tr>
                						<td><?php echo $r['name'];?></td>
                						<td><input type="text" name="setting[invitenum][<?php echo $r['groupid']?>][free]" value="<?php echo $setting['invitenum'][$r['groupid']]['free']?>" /></td>
                						<td><input type="text" name="setting[invitenum][<?php echo $r['groupid']?>][buy]" value="<?php echo $setting['invitenum'][$r['groupid']]['buy']?>" /></td>
									</tr>
								<?php }	?>
								</tbody>
							</table>
                		</div>
                	</div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">注册赠送点数</label>
                <div class="col-sm-4">
                	<input type="text" name="setting[points]" value="<?php echo $setting['points']?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">显示注册协议</label>
                <div class="col-sm-4">
                	<label class="radio-inline"><input type="radio" name="setting[showprotocol]" value="1" <?php echo $setting['showprotocol'] == 1 ? 'checked' : '';?>>是 </label>
                	<label class="radio-inline"><input type="radio" name="setting[showprotocol]" value="0" <?php echo $setting['showprotocol'] != 1 ? 'checked' : '';?> >否</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">注册协议</label>
                <div class="col-sm-8">
                	<textarea name="setting[protocol]" class="form-control" rows="6"><?php echo $setting['protocol']?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">UCENTER整合</label>
                <div class="col-sm-4">
                	<label class="radio-inline"><input type="radio" name="setting[ucenter]" value="1" <?php echo isset($setting['ucenter']) && $setting['ucenter'] == 1 ? 'checked' : '';?> onclick="$('.ucenter_box').show()">启用</label>
                	<label class="radio-inline"><input type="radio" name="setting[ucenter]" value="0" <?php echo !isset($setting['ucenter']) || $setting['ucenter'] != 1 ? 'checked' : '';?> onclick="$('.ucenter_box').hide()">关闭</label>
                </div>
                <div class="form-group ucenter_box" <?php echo isset($setting['ucenter']) && $setting['ucenter'] ? '' : 'style="display:none;"'?>>
                	<div class="col-sm-8">
                		<table class="table table-striped table-advance table-hover">
               				<tr>
               					<th width="160">UCenter 访问地址：</th>
               					<td><input type="text" name="setting[uc_api]" id="uc_api" value="<?php if(isset($setting['uc_api']))echo $setting['uc_api']?>" size="40"/>如 http://www.wuzhicms.com/ucenter 最后不要带<font color="red">/</font></td>
               				</tr>
               				<tr>
               					<th>UCenter IP 地址：</th>
               					<td><input type="text" name="setting[uc_ip]" id="uc_ip" value="<?php if(isset($setting['uc_ip']))echo $setting['uc_ip']?>" />一般可不填,遇到无法同步时,请填写ucenter主机的IP地址</td>
               				</tr>
							<tr>
								<th>UCenter 应用 ID：</th>
								<td><input type="text" name="setting[uc_appid]" id="uc_appid" value="<?php if(isset($setting['uc_appid']))echo $setting['uc_appid']?>" /></td>
							</tr>
							<tr>
								<th>Ucenter 通信密钥：</th>
								<td><input type="text" name="setting[uc_key]" id="uc_key" value="<?php if(isset($setting['uc_key']))echo $setting['uc_key']?>" size="50"/></td>
							</tr>
               				<tr>
               					<th>Ucenter 数据库服务器：</th>
								<td><input type="text" name="setting[uc_dbhost]" id="uc_dbhost" value="<?php if(isset($setting['uc_dbhost']))echo $setting['uc_dbhost']?>" /></td>
							</tr>
							<tr>
								<th>Ucenter 数据库用户名：</th>
								<td><input type="text" name="setting[uc_dbuser]" id="uc_dbuser" value="<?php if(isset($setting['uc_dbuser']))echo $setting['uc_dbuser']?>" /></td>
							</tr>
							<tr>
								<th>Ucenter 数据库密码：</th>
								<td><input type="password" name="setting[uc_dbpw]" id="uc_dbpw" value="<?php if(isset($setting['uc_dbpw']))echo $setting['uc_dbpw']?>" /></td>
							</tr>
							<tr>
								<th>Ucenter 数据库名：</th>
								<td><input type="text" name="setting[uc_dbname]" id="uc_dbname" value="<?php if(isset($setting['uc_dbname']))echo $setting['uc_dbname']?>" /></td>
							</tr>
							<tr>
								<th>Ucenter 数据库表前缀：</th>
								<td><input type="text" name="setting[uc_dbtablepre]" id="uc_dbtablepre" value="<?php if(isset($setting['uc_dbtablepre']))echo $setting['uc_dbtablepre']?>" /> <input type="button" value="测试数据库连接" class="btn btn-info btn-sm"  onclick="check_uc()" /></td>
							</tr>
							<tr>
								<th>Ucenter 数据库字符集：</th>
								<td>
									<select name="setting[uc_dbcharset]"  id="uc_dbcharset"  />
										<option value="">请选择</option>
										<option value="gbk" <?php echo isset($setting['uc_dbcharset']) && $setting['uc_dbcharset'] == 'gbk' ? 'selected' : ''?>>GBK</option>
										<option value="utf8" <?php echo isset($setting['uc_dbcharset']) && $setting['uc_dbcharset'] == 'utf8' ? 'selected' : ''?>>UTF-8</option>
									</select>
								</td>
							</tr>
						</table>
                	</div>
               	</div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 control-label">第三方登录</label>
                <div class="form-group" >
                	<div class="col-sm-8">
                		<table class="table table-striped table-advance table-hover">
               				<tr>
               					<th width="160"><a href="http://connect.qq.com" target="_blank" title="点击跳转申请">QQ号码登录：</a></th>
               					<td>
               						AppID <input type="text" name="setting[qq_appid]" id="qq_appid" size="20" value="<?php echo output($setting,'qq_appid');?>" />
               						Appkey <input type="text" name="setting[qq_appkey]" id="qq_appkey" size="30" value="<?php echo output($setting,'qq_appkey');?>"/>
               					</td>
               				</tr>
               				<tr>
               					<th width="160"><a href="http://open.weibo.com/authentication" target="_blank" title="点击跳转申请">SINA微博登录：</a></th>
               					<td>
               						App Key <input type="text" name="setting[sina_key]" id="sina_key" size="20" value="<?php echo output($setting,'sina_key');?>" />
               						App Secret<input type="text" name="setting[sina_secret]" id="sina_secret" size="30" value="<?php echo output($setting,'sina_secret');?>"/>
               					</td>
               				</tr>
               				<tr>
               					<th width="160"><a href="http://developer.baidu.com/" target="_blank" title="点击跳转申请">BAIDU登录：</a></th>
               					<td>
               						App Key <input type="text" name="setting[baidu_key]" id="baidu_key" size="20" value="<?php echo output($setting,'baidu_key');?>" />
               						App Secret<input type="text" name="setting[baidu_secret]" id="baidu_secret" size="30" value="<?php echo output($setting,'baidu_secret');?>"/>
               					</td>
               				</tr>
						</table>
                	</div>
               	</div>
            </div>
            <div class="form-group">
            	<label class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                	<input class="btn btn-info" type="submit" name="submit" value="提交">
                </div>
			</div>
        </div>
        </form>
    </div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script type="text/javascript">
function check_uc() {
	$.get('?m=member&f=index&v=check_uc&_su=<?php echo _SU?>', {uc_dbhost:$('#uc_dbhost').val(), uc_dbuser:$('#uc_dbuser').val(), uc_dbpw:$('#uc_dbpw').val()}, function(data){
		if(data == 1){
			alert('连接成功！');
		}else{
			alert('连接失败！');
		}
	});
}
</script>

</body>
</html>