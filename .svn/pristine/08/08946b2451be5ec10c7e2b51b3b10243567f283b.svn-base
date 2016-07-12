<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?php echo R;?>js/jquery.mousewheel-3.0.6.pack.js"></script>
<!-- Add fancyBox -->
<link rel="stylesheet" href="<?php echo R;?>js/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo R;?>js/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="<?php echo R;?>js/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo R;?>js/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?php echo R;?>js/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

<body class="body pxgridsbody">
<section class="wrapper">
<div class="panel tasks-widget">
<header>
<?php echo $this->menu($GLOBALS['_menuid']);?>
</header>

<div class="row">
                  <div class="col-md-12">
                      <section class="panel tasks-widget">
                      	<table class="table table-striped table-advance table-hover">
					        <thead>
					        <tr>
					            <th class="hidden-phone tablehead"><?php echo L('cur_dir');?>：<?php echo $cur_dir;?></th>
					        </tr>
					        </thead>
					    </table>
                          <div class="panel-body" id="panel-bodys">

                              <div class="task-content">

                                  <ul class="task-list">
<?php if ($dir !='' && $dir != '.'){ ?>
<li>
<div class="task-title"><a href="<?php echo link_url( array('dir'=>stripslashes(dirname($dir))) );?>"><img src="<?php echo R?>images/icon/folder-upload.png" />&nbsp;<?php echo L("parent_dir")?></a></div></li>
<?php  } ?>
<?php
foreach($lists AS $k=>$v){
	$file = basename($v);
	if(stripos($file, '.php')!==false) continue;
	if(is_dir($v))
	{
		$file = '<a href="'.link_url(array('dir'=>($dir ? $dir.'/' : '').$file)).'">'.$file.'</a>';
	}
	else
	{
		$path = $dir.'/'.$file;
	    $file = '<a href="'.ATTACHMENT_URL.$dir.'/'.$file.'" title="'.L('look_big').':'.$file.'" alt="'.$file.'" class="fancybox-button" rel="fancybox-button">'.$file.'</a>';
	}
?>                  
<li>
<div class="task-title">
<span class="task-title-sp"><?php echo $file;?></span>
<?php if(isset($path)):?>
<div class="pull-right hidden-phone">
<a href="javascript:makedo('<?php echo link_url( array('v'=>'del','url'=>$path) );?>', '<?php echo L('confirm_del');?>')" class="btn btn-danger btn-xs"><i class="icon-x "></i></a>
</div>
<?php endif;?>
</div>
</li>
<?php
}
?>
                                      
                                  </ul>
                              </div>
                          </div>
                      </section>
                  </div>
              </div>

</div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script type="text/javascript">
$(function(){
	$('.show_open_win').click(function(){
		var url = $(this).attr('href');
		var title = $(this).attr('title');
		openiframe(url, 'big_open', title, '900', '500');
		return false;
	});
})

$(document).ready(function() {
	$(".fancybox-button").fancybox({
		prevEffect		: 'none',
		nextEffect		: 'none',
		closeBtn		: false,
		helpers		: {
			title	: { type : 'inside' },
			buttons	: {}
		}
	});
})
</script>

</body>
</html>