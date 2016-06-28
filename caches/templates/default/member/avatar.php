<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>

<?php if($set_iframe==0) { ?>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","iframetop"); ?>
<?php } else { ?>
<div style="padding-top: 15px;"></div>
<?php } ?>

<style>
	ul,li{margin:0;padding: 0;list-style: none;}
</style>
<script language="javascript" type="text/javascript" src="<?php echo R;?>js/swfobject.js"></script>
<script type="text/javascript">
	var flashvars = {
		'upurl':"<?php echo $upurl;?>&callback=return_avatar&"
	};
	var params = {
		'align':'middle',
		'play':'true',
		'loop':'false',
		'scale':'showall',
		'wmode':'window',
		'devicefont':'true',
		'id':'Main',
		'bgcolor':'#fff',
		'name':'Main',
		'allowscriptaccess':'always'
	};
	var attributes = {
	};
	swfobject.embedSWF("<?php echo R;?>js/avatar.swf", "myContent", "490", "434", "9.0.0","<?php echo R;?>js/expressInstall.swf", flashvars, params, attributes);

	function return_avatar(data) {
		if(data == 1) {
			var d = dialog({
				title: '太棒了',
				content: '头像更新成功!'
			});
			d.show();
			setTimeout(function () {
				d.close().remove();
				window.location.reload();
			}, 5000);

		} else {
			alert('failure');
		}
	}
</script>


<div class="container-fluid  ie8-member">
<!--<div class="wrapper wrapper-content">-->
	<div class="row row-40" >
	<?php if($set_iframe==0) { ?>
	<div class="col-sm-3 left-nav padding-right0">
		<!--左侧导航-->
		<nav class="navbar-default navbar-static-side" role="navigation">
			<div class="nav-close"><i class="fa fa-times-circle"></i>
			</div>
			<div class="slimScrollDiv" style="position: relative; width: auto; height: 100%;">
				<div class="sidebar-collapse" style="width: auto; height: 100%;">
					<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","left"); ?>
				</div>
			</div>
		</nav>
		<!--end 左侧导航-->
	</div><!--col-sm-3--><?php } ?>

	<div class="<?php if($set_iframe==0) { ?>col-sm-9<?php } else { ?>col-sm-12<?php } ?> paddingleft0">


	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>设置头像</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="close-link">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content" style="display: -webkit-box;">
					<div class="row">
					<div class="col-sm-9">
						<div id="myContent"><p>Alternative content</p></div>
					</div>
					<div class="col-sm-3">
						<div class="memberavatar" id="avatarlist">
							<li>
								<img src="<?php echo WEBURL;?>uploadfile/member/<?php echo $dir;?>180x180.jpg" height="180" width="180" onerror="this.src='<?php echo R;?>images/userface.png'"><br />
								<?php echo L('avatar');?>180 x 180
							</li>
							<li>
								<img src="<?php echo WEBURL;?>uploadfile/member/<?php echo $dir;?>180x180.jpg" height="90" width="90" onerror="this.src='<?php echo R;?>images/userface.png'"><br />
								<?php echo L('avatar');?>90 x 90
							</li>
							<li>
								<img src="<?php echo WEBURL;?>uploadfile/member/<?php echo $dir;?>180x180.jpg" height="45" width="45" onerror="this.src='<?php echo R;?>images/userface.png'"><br />
								<?php echo L('avatar');?>45 x 45
							</li>
							<li>
								<img src="<?php echo WEBURL;?>uploadfile/member/<?php echo $dir;?>180x180.jpg" height="30" width="30" onerror="this.src='<?php echo R;?>images/userface.png'"><br />
								<?php echo L('avatar');?>30 x 30
							</li>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
</div>

<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","foot"); ?>
</body>
</html>