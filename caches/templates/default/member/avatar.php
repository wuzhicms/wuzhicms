<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','head'); ?>
<div class="container membercenter">
    <div class="row">
        <div class="span3 memberleft">
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','left'); ?>
        </div>
        <div class="memberright">
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
						window.location.reload();
					} else {
						alert('failure');
					}
				}
			</script>
			<div class="memberavatar" id="avatarlist" style="float:right;">
				<li>
					<img src="<?php echo WEBURL;?>uploadfile/member/<?php echo $dir;?>/180x180.jpg" height="180" width="180" onerror="this.src='<?php echo R;?>images/userface.png'"><br />
					<?php echo L('avatar');?>180 x 180
				</li>
				<li>
					<img src="<?php echo WEBURL;?>uploadfile/member/<?php echo $dir;?>/90x90.jpg" height="90" width="90" onerror="this.src='<?php echo R;?>images/userface.png'"><br />
					<?php echo L('avatar');?>90 x 90
				</li>
				<li>
					<img src="<?php echo WEBURL;?>uploadfile/member/<?php echo $dir;?>/45x45.jpg" height="45" width="45" onerror="this.src='<?php echo R;?>images/userface.png'"><br />
					<?php echo L('avatar');?>45 x 45
				</li>
				<li>
					<img src="<?php echo WEBURL;?>uploadfile/member/<?php echo $dir;?>/30x30.jpg" height="30" width="30" onerror="this.src='<?php echo R;?>images/userface.png'"><br />
					<?php echo L('avatar');?>30 x 30
				</li>
			</div>
			<div class="col-auto">
				<div id="myContent"><p>Alternative content</p></div>
			</div>

        </div>
    </div>
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T('member','foot'); ?>
