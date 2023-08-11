<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body>
<section class="wrapper">
	<section class="panel">
		<header class="panel-heading"><span>模块设置</span></header>
			<div class="panel-body">
				<form class="form-horizontal tasi-form" method="post" action="">
					<div class="row mb-3">
						<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">开启会员注册</label>
						<div class="col-lg-3 col-sm-6 col-xs-6 d-flex align-items-center">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="setting[register]" id="register1" value="1" <?php echo $setting['register'] == 1 ? 'checked' : '';?>>
								<label class="form-check-label" for="register1">是</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="setting[register]" id="register0" value="0" <?php echo $setting['register'] != 1 ? 'checked' : '';?>>
								<label class="form-check-label" for="register0">否</label>
							</div>
						</div>
					</div>
					<div class="row mb-3">
						<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">开启邮件验证</label>
						<div class="col-lg-3 col-sm-6 col-xs-6 d-flex align-items-center">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="setting[checkemail]" id="checkemail1" value="1" <?php echo $setting['checkemail'] == 1 ? 'checked' : '';?>>
								<label class="form-check-label" for="checkemail1">是</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="setting[checkemail]" id="checkemail0" value="0" <?php echo $setting['checkemail'] != 1 ? 'checked' : '';?>>
								<label class="form-check-label" for="checkemail0">否</label>
							</div>
						</div>
					</div>
					<div class="row mb-3">
						<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">开启手机验证</label>
						<div class="col-lg-3 col-sm-6 col-xs-6 d-flex align-items-center">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="setting[checkmobile]" id="checkmobile1" value="1" <?php echo $setting['checkmobile'] == 1 ? 'checked' : '';?>>
								<label class="form-check-label" for="checkmobile1">是</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="setting[checkmobile]" id="checkmobile0" value="0" <?php echo $setting['checkmobile'] != 1 ? 'checked' : '';?>>
								<label class="form-check-label" for="checkmobile0">否</label>
							</div>
						</div>
					</div>
					<div class="row mb-3">
						<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">开启注册审核</label>
						<div class="col-lg-3 col-sm-6 col-xs-6 d-flex align-items-center">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="setting[checkuser]" id="checkuser1" value="1" <?php echo $setting['checkuser'] == 1 ? 'checked' : '';?>>
								<label class="form-check-label" for="checkuser1">是</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="setting[checkuser]" id="checkuser0" value="0" <?php echo $setting['checkuser'] != 1 ? 'checked' : '';?>>
								<label class="form-check-label" for="checkuser0">否</label>
							</div>
						</div>
					</div>
					<div class="row mb-3">
						<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">开启邀请注册</label>
						<div class="col-lg-3 col-sm-6 col-xs-6 d-flex align-items-center">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="setting[invite]" id="invite1" value="1" <?php echo $setting['invite'] == 1 ? 'checked' : '';?> onclick="$('.invite_box').show()">
								<label class="form-check-label" for="invite1">是</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="setting[invite]" id="invite0" value="0" <?php echo $setting['invite'] != 1 ? 'checked' : '';?> onclick="$('.invite_box').hide()">
								<label class="form-check-label" for="invite0">否</label>
							</div>
						</div>
					</div>

					<div class="row mb-3 invite_box" <?php echo $setting['invite'] ? '' : 'style="display:none;"'?>>
						<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">邀请码价格</label>
						<div class="col-auto">
							<div class="input-group w-50">
								<input type="text" name="setting[inviteprice]" class="form-control" value="<?php echo (int)$setting['inviteprice']?>" />
								<span class="input-group-text">点</span>
							</div>
						</div>
					</div>

					<div class="row mb-3 invite_box" <?php echo $setting['invite'] ? '' : 'style="display:none;"'?>>
						<label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
						<div class="col-lg-3 col-sm-3 col-xs-3">
							<table class="border table table-striped table-advance table-hover">
								<thead>
									<tr>
										<th class="tablehead col-2">组名</th>
										<th class="tablehead col-2">每天免费数量</th>
										<th class="tablehead col-2">每天付费数量</th>
									</tr>
								</thead>
								<tbody>
								<?php if(is_array($group))foreach($group as $r) {?>
									<tr>
										<td><?php echo $r['name'];?></td>
										<td class="p-2"><input type="text" class="form-control" name="setting[invitenum][<?php echo $r['groupid']?>][free]" value="<?php echo $setting['invitenum'][$r['groupid']]['free']?>" /></td>
										<td class="p-2"><input type="text" class="form-control" name="setting[invitenum][<?php echo $r['groupid']?>][buy]" value="<?php echo $setting['invitenum'][$r['groupid']]['buy']?>" /></td>
									</tr>
								<?php }	?>
								</tbody>
							</table>
						</div>
					</div>

					<div class="row mb-3">
						<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">注册赠送点数</label>
						<div class="col-auto">
							<div class="input-group w-50">
								<input type="text" name="setting[points]" class="form-control" value="<?php echo $setting['points']?>" />
								<span class="input-group-text">点</span>
							</div>
						</div>
					</div>

					<div class="row mb-3">
						<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">显示注册协议</label>
						<div class="col-lg-3 col-sm-6 col-xs-6 d-flex align-items-center">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="setting[showprotocol]" id="showprotocol1" value="1" <?php echo $setting['showprotocol'] == 1 ? 'checked' : '';?>>
								<label class="form-check-label" for="showprotocol1">是</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="setting[showprotocol]" id="showprotocol0" value="0" <?php echo $setting['showprotocol'] != 1 ? 'checked' : '';?>>
								<label class="form-check-label" for="showprotocol0">否</label>
							</div>
						</div>
					</div>

					<div class="row mb-3">
						<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">注册协议</label>
						<div class="col-lg-8 col-sm-8 col-xs-8">
							<textarea name="setting[protocol]" class="form-control" rows="10"><?php echo $setting['protocol']?></textarea>
						</div>
					</div>


					<div class="row mb-3">
						<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">第三方登录</label>
						<div class="col-lg-8 col-sm-8 col-xs-8">
							<div class="mb-3">
								<label class="form-label">QQ号码登录：</label>
								<div class="row">
									<div class="col-4">
										<div class="input-group">
											<span class="input-group-text">AppID</span>
											<input type="text" class="form-control col-sm-3 col-xs-3" name="setting[qq_appid]" id="qq_appid" size="20" value="<?php echo output($setting,'qq_appid');?>" />
										</div>
									</div>
									<div class="col-4">
										<div class="input-group">
											<span class="input-group-text">Appkey</span>
											<input type="text" class="form-control col-sm-3 col-xs-3" name="setting[qq_appkey]" id="qq_appkey" size="20" value="<?php echo output($setting,'qq_appkey');?>" />
										</div>
									</div>
									<div class="col-4"><a class="btn btn-info btn-sm" href="http://connect.qq.com" target="_blank" title="点击跳转申请">点击申请</a></div>
								</div>
							</div>
							
							<div class="mb-3">
								<label class="form-label">微博登录：</label>
								<div class="row">
									<div class="col-4">
										<div class="input-group">
											<span class="input-group-text">App Key</span>
											<input type="text" class="form-control col-sm-3 col-xs-3" name="setting[sina_key]" id="sina_key" size="20" value="<?php echo output($setting,'sina_key');?>" />
										</div>
									</div>
									<div class="col-4">
										<div class="input-group">
											<span class="input-group-text">App Secret</span>
											<input type="text" class="form-control col-sm-3 col-xs-3" name="setting[sina_secret]" id="sina_secret" size="20" value="<?php echo output($setting,'sina_secret');?>" />
										</div>
									</div>
									<div class="col-4"><a class="btn btn-info btn-sm" href="http://open.weibo.com/authentication" target="_blank" title="点击跳转申请">点击申请</a></div>
								</div>
							</div>

							<div class="mb-3">
								<label class="form-label">微信登录：</label>
								<div class="row">
									<div class="col-4">
										<div class="input-group">
											<span class="input-group-text">App Key</span>
											<input type="text" class="form-control col-sm-3 col-xs-3" name="setting[weixin_key]" id="weixin_key" size="20" value="<?php echo output($setting,'weixin_key');?>" />
										</div>
									</div>
									<div class="col-4">
										<div class="input-group">
											<span class="input-group-text">App Secret</span>
											<input type="text" class="form-control col-sm-3 col-xs-3" name="setting[weixin_secret]" id="weixin_secret" size="20" value="<?php echo output($setting,'weixin_secret');?>" />
										</div>
									</div>
									<div class="col-4"><a class="btn btn-info btn-sm" href="http://open.weixin.qq.com/" target="_blank" title="点击跳转申请">点击申请</a></div>
								</div>
							</div>
						</div>

					</div>

					<div class="row mb-3">
						<label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
						<div class="col-lg-3 col-sm-6 col-xs-6">
							<input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
						</div>
					</div>
			</form>
		</div>
	</section>
</section>

<?php include $this->template('footer','core');?>