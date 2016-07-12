<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
<div class="panel tasks-widget">
<header>
<?php echo $this->menu($GLOBALS['_menuid']);?>
</header>

<div class="row">
                  <div class="col-md-12">
                      <section class="panel tasks-widget">
                          <header class="panel-heading">
                              <span>当前路径：<?php echo $cur_dir;?></span>
                          </header>
                          <div class="panel-body" id="panel-bodys">

                              <div class="task-content">

                                  <ul class="task-list">
<?php if ($dir !='' && $dir != '.'){ ?>
<li>
<div class="task-title"><a href="<?php echo link_url( array('dir'=>stripslashes(dirname($dir))) );?>"><img src="<?php echo R?>images/icon/folder-upload.png" />&nbsp;返回上级目录</a></div></li>
<?php  } ?>
<?php
//循环目录
$files_list = array();
foreach($lists AS $k=>$v) {
	$file = basename($v);
	if(stripos($file, '.php')!==false) continue;
    $is_dir = false;
	if(is_dir($v))
	{
		$file = '<a href="'.link_url(array('dir'=>($dir ? $dir.'/' : '').$file)).'"><img src="'.R.'images/icon/dir.png"> '.$file.'</a>';
        $is_dir = true;
	} else {
        $files_list[] = $v;
        continue;
    }
?>                  
<li>
<div class="task-title">
<span class="task-title-sp">
<?php
    echo $file;
?></span>
</div>
</li>
<?php
}
//循环文件
foreach($files_list AS $k=>$v) {
    $file = basename($v);
    if(stripos($file, '.php')!==false) continue;
    ?>
    <li>
        <div class="task-title">
<span class="task-title-sp">
<?php
    echo "<img src='".R."images/icon/file.png' class='pull-left'> ";
    echo "<span class='col-lg-2 col-sm-4'>".$file."</span>";
    echo " &nbsp;&nbsp;&nbsp;修改时间：".time_format(filemtime(TPL_ROOT.$dir.'/'.$file));

?></span>
            <div class="pull-right hidden-phone">
                <?php
                $extent = get_ext($file);
                if(in_array($extent,array('html'))) {
               ?>
                <a href="?m=template&f=index&v=history&dir=<?php echo $dir;?>&file=<?php echo substr($file,0,-5).$this->su();?>" class="btn btn-default btn-xs">历史版本</a>
                <a href="?m=template&f=index&v=edit&dir=<?php echo $dir;?>&file=<?php echo substr($file,0,-5).$this->su();?>" class="btn btn-primary btn-xs">修改</a>
<?php }?>
                <a href="javascript:makedo('?m=template&f=index&v=delete&dir=<?php echo $dir;?>&file=<?php echo substr($file,0,-5).$this->su();?>', '确认删除该模版吗？')"
                   class="btn btn-danger btn-xs">删除</a>
            </div>
        </div>
    </li>
<?php
}
?>
                                      
                                  </ul>
                              </div>

                              <div class="row">
                                  <div class="col-lg-4">

                                      <div style="padding: 0px 20px;width: 500px;" class="input-group m-bot15">
                                          <input type="text" id="filename" value="" class="form-control" placeholder="只能包含：a-z 0-9 _">
                                              <span class="input-group-btn">
                                                <button class="btn btn-white" type="button" onclick="add_template(0)">新建文件</button>
                                                <button class="btn btn-white" type="button" onclick="add_template(1)">新建目录</button>
                                              </span>
                                      </div>


                                  </div>

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
    function add_template(isdir) {
        var filename = $("#filename").val();
        if(filename=='') {
            msgtip("名称不能为空");
            return false;
        }
        var patrn=/^(\w){1,30}$/;
        if (!patrn.exec(filename)) {
            msgtip("名称不符合要求");
            return false;
        }

        $.post("?m=template&f=index&v=add<?php echo $this->su();?>", { isdir: isdir, dir:"<?php echo $dir;?>",filename: filename }, function(data) {
            if(data=='100') {
                var d = dialog({
                    content: '创建成功，即将重新载入页面...'
                });
                d.show();
                setTimeout(function () {
                    if(isdir==1) {
                        window.location.reload();
                    } else {
                        gotourl("?m=template&f=index&v=edit&dir=<?php echo $dir;?>&file="+filename+"<?php echo $this->su();?>");
                    }
                }, 2000);
            } else {
                msgtip(data);
            }
        });
    }
</script>
</body>
</html>