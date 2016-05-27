<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","head"); ?>
<body class="gray-bg">
<?php if($set_iframe==0) { ?>
	<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","iframetop"); ?>
<?php } else { ?>
	<div style="padding-top: 15px;"></div>
<?php } ?>
<div class="container-fluid  ie8-member">
	<div class="row">
		<?php if($set_iframe==0) { ?>
		<div class="col-sm-3">
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

		<div class="<?php if($set_iframe==0) { ?>col-sm-9<?php } else { ?>col-sm-12<?php } ?>">

			<div class="row">
				<div class="col-sm-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>投稿-选择栏目</h5>
						</div>
						<div class="ibox-content" style="min-height: 500px;">
							<div class="row">
								<?php $n=1; if(is_array($category_priv)) foreach($category_priv AS $cid => $r) { ?>
								<div class="col-sm-4"><a type="button"
										href="?f=postinfo&v=newinfo&cid=<?php echo $cid;?>&set_iframe=<?php echo $set_iframe;?>"
										class="btn btn-block btn-outline btn-default btn-lg"><?php echo $r['name'];?></a></div>
								<?php $n++;}?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("member","foot"); ?>