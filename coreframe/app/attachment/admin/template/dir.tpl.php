<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <div class="panel tasks-widget">
        <header>
        <?php echo $this->menu($GLOBALS['_menuid']);?>
        </header>
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
                            $file = '<a href="'.link_url(array('dir'=>($dir ? $dir.'/' : '').$file)).'"><img src="'.R.'images/icon/dir.png"> '.$file.'</a>';
                        }
                        else
                        {
                            $path = $dir.'/'.$file;
                            $file = '<a href="'.ATTACHMENT_URL.$dir.'/'.$file.'" title="'.L('look_big').':'.$file.'" alt="'.$file.'">'.$file.'</a>';
                        }
                    ?>
                    <li>
                    <div class="d-flex justify-content-between">
                    <span class="task-title-sp"><?php echo $file;?></span>
                    <?php if(isset($path)):?>
                    <div class=" ">
                    <a href="javascript:makedo('<?php echo link_url( array('v'=>'del','url'=>$path) );?>', '<?php echo L('confirm_del');?>')" class="btn btn-danger btn-sm btn-xs">删除</a>
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
    </div>
</section>
<script type="text/javascript">
$(function(){
	$('.show_open_win').click(function(){
		var url = $(this).attr('href');
		var title = $(this).attr('title');
		openiframe(url, 'big_open', title, '900', '500');
		return false;
	});
})
</script>
<?php include $this->template('footer','core');?>
