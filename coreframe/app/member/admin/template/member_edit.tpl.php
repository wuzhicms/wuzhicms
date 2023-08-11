<?php defined('IN_WZ') or exit('No direct script access allowed'); ?>
<?php
include $this->template('header', 'core');
?>

<body>
	<link href="<?php echo R; ?>css/validform.css" rel="stylesheet">
	<script src="<?php echo R; ?>js/validform.min.js"></script>
	<section class="wrapper">
		<!-- page start-->
		<section class="panel">
			<?php echo $this->menu($GLOBALS['_menuid']); ?>
			<form id="myform" name="myfrom" class="form-horizontal tasi-form" method="post" action="index.php?m=member&f=index&v=edit&uid=<?php echo $uid . $this->su(); ?>">
				<div class="panel-body">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li role="presentation" class="nav-item">
							<button type="button" class="px-5 nav-link active" id="1tab" data-bs-toggle="tab" data-bs-target="#tabs1" role="tab" aria-controls="tabs1" aria-selected="true">基本信息</button>
						</li>
						<li role="presentation" class="nav-item">
							<button type="button" class="px-5 nav-link" data-bs-target="#tabs2" role="tab" id="2tab" data-bs-toggle="tab" aria-controls="tabs2" aria-selected="false">中文信息</button>
						</li>
					</ul>

					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade active show" id="tabs1" aria-labelledby="1tab">
							<div class="mb-3 row">
								<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">用户名</label>
								<div class="col-lg-3 col-sm-6 col-xs-6">
									<input class="form-control" id="disabledInput" type="text" name="info[username]" value="<?php echo $member['username'] ?>">
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">密码</label>
								<div class="col-lg-3 col-sm-6 col-xs-6">
									<input type="password" name="info[password]" id="password" class="form-control" />
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">确认密码</label>
								<div class="col-lg-3 col-sm-6 col-xs-6">
									<input type="password" name="info[pwdconfirm]" class="form-control" recheck="password" errormsg="您两次输入的账号密码不一致！" sucmsg="OK" />
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">手机</label>
								<div class="col-lg-3 col-sm-6 col-xs-6">
									<input type="text" name="info[mobile]" class="form-control" value="<?php echo $member['mobile']; ?>" datatype="m|*0-0" errormsg="请输入正确的手机号" sucmsg="OK" />
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">选择单位</label>
								<div class="col-lg-3 col-sm-6 col-xs-6">
									<?php
									echo $form->tree_select($orgLists, $pid, 'name="info[org_id]" class="form-select"', '≡ 无上单位 ≡');
									?>
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">用户模型</label>
								<div class="col-lg-3 col-sm-6 col-xs-6">
									<select name="modelids[]" class="form-select" multiple="multiple">
										<?php if ($this->model) foreach ($this->model as $k => $t) { ?>
											<option value="<?php echo $t['modelid'] ?>" <?php echo in_array($t['modelid'], $modelids) ? 'selected' : ''; ?>><?php echo $t['name']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">会员组</label>
								<div class="col-lg-3 col-sm-6 col-xs-6">
									<select name="info[groupid]" class="form-select">
										<?php if (is_array($group)) foreach ($group as $v) { ?>
											<option value="<?php echo $v['groupid'] ?>" <?php echo $v['groupid'] == $member['groupid'] ? 'selected' : '' ?>><?php echo $v['name'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">头像</label>
								<div class="col-lg-3 col-sm-6 col-xs-6">
									<div class="upload-picture-card"><?php echo $form->attachment('', '1', 'avatar', $avatar); ?></div>
								</div>
							</div>

							<div class="mb-3 row">
								<label class="col-sm-2 col-xs-4 col-form-label control-label text-end">真实姓名</label>
								<div class="col-lg-3 col-sm-6 col-xs-6">
									<input type="text" name="info[truename]" id="truename" size="" placeholder="" value="<?php echo $member['truename']; ?>" class="form-control">
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="tabs2" aria-labelledby="2tab">
							<?php
							foreach ($modelids as $modelid) {
								echo '<div class="alert alert-primary fw-bold mb-3 p-3 rounded-1 text-center">' . $models[$modelid]['name'] . '</div>';
								$formdata = 'formdata_' . $modelid;
								$data = $$formdata;
								foreach ($data[0] as $field => $info) {
									if ($info['powerful_field'] || $field == 'email_10') continue;
									if ($info['formtype'] == 'powerful_field') {
										foreach ($formdata['0'] as $_fm => $_fm_value) {
											if ($_fm_value['powerful_field']) {
												$info['form'] = str_replace('{' . $_fm . '}', $_fm_value['form'], $info['form']);
											}
										}
										foreach ($formdata['1'] as $_fm => $_fm_value) {
											if ($_fm_value['powerful_field']) {
												$info['form'] = str_replace('{' . $_fm . '}', $_fm_value['form'], $info['form']);
											}
										}
									}
							?>
									<div class="mb-3 row">
										<label class="col-sm-2 col-xs-4 col-form-label control-label text-end"><?php if ($info['star']) { ?><font color="red">*</font><?php } ?> <?php echo $info['name'] ?></label>
										<div class="col-lg-3 col-sm-6 col-xs-6"><?php echo $info['form'] ?><?php echo $info['remark'] ?></div>
									</div>
							<?php }
							} ?>
						</div>
					</div>

					<div class="mb-3 row">
						<label class="col-sm-2 col-xs-4 col-form-label control-label text-end"></label>
						<div class="col-lg-3 col-sm-6 col-xs-6">
							<input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
						</div>
					</div>

				</div>
			</form>
		</section>
		<!-- page end-->
	</section>
	<script type="text/javascript">
		$(function() {
			$(".form-horizontal").Validform({
				tiptype: 3,
				callback: function(form) {
					$("#submit").click();
				}

			});

		});

		function set_gp(gid, pid) {
			//$('#gid'+pid).addClass('trbg');
			var istrue = $('#box' + gid).is(':checked');
			if (istrue) {
				$('#gid' + gid).addClass('trbg');
			} else {
				$('#gid' + gid).removeClass('trbg');
			}
			set_parents(gid, istrue);
		}

		function set_parents(gid, istrue) {
			var hgid = $("#hgid" + gid).val();
			if (hgid != 0) {
				if (istrue) {
					$('#gid' + hgid).addClass('trbg');
					$('#box' + hgid).prop('checked', 'checked');
				} else {
					$('#gid' + hgid).removeClass('trbg');
					$('#box' + hgid).prop('checked', '');
				}

				set_parents(hgid, istrue);
			} else {
				if (istrue) {
					$('#gid' + gid).addClass('trbg');
					$('#box' + gid).prop('checked', 'checked');
				} else {
					$('#gid' + gid).removeClass('trbg');
					$('#box' + gid).prop('checked', '');
				}
			}

		}
	</script>
	<?php include $this->template('footer', 'core'); ?>