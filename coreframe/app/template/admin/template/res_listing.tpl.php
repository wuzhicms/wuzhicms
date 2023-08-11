<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <header><?php echo $this->menu($GLOBALS['_menuid']);?></header>
    <section class="panel tasks-widget">
        <header class="panel-heading">
            <span>当前路径：<?php echo $cur_dir;?></span>
        </header>
        <div class="panel-body" id="panel-bodys">
            <div class="task-content">
                <ul class="task-list">
                <?php if ($dir !='' && $dir != '.'){ ?>
                <li>
                <div class="task-title"><a href="<?php echo link_url( array('dir'=>stripslashes(dirname($dir))) );?>"><img src="<?php echo R?>images/icon/folder-upload.png" class="pull-left" /><span class="ps-1">返回上级目录</span></a></div></li>
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
                $file = '<a href="'.link_url(array('dir'=>($dir ? $dir.'/' : '').$file)).'"><img src="'.R.'images/icon/dir.png"> <span> '.$file.' </span></a>';
                $is_dir = true;
                } else {
                $files_list[] = $v;
                continue;
                }
                ?>
                <li>
                <div class="d-flex justify-content-between">
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
                <div class="d-flex justify-content-between">
                <div class="task-title-sp">
                <?php
                echo "<img src='".R."images/icon/file.png' class='pull-left'> ";
                echo "<span class='me-2'>".$file."</span>";
                echo "<small>修改时间：".time_format(filemtime(TPL_ROOT.$dir.'/'.$file))."</small>";
                ?></div>
                <div class="pull-right hidden-phone">
                <?php
                $extent = get_ext($file);
                if(in_array($extent,array('js','css'))) {
                ?>
                <a href="?m=template&f=res&v=history&dir=<?php echo $dir;?>&file=<?php echo $file.$this->su();?>" class="btn btn-default btn-sm btn-xs">历史版本</a>
                <a href="?m=template&f=res&v=edit&dir=<?php echo $dir;?>&file=<?php echo $file.$this->su();?>" class="btn btn-primary btn-sm btn-xs">修改</a>
                <?php }?>
                <a href="javascript:makedo('?m=template&f=res&v=delete&dir=<?php echo $dir;?>&file=<?php echo $file.$this->su();?>', '确认删除该文件吗？')"
                class="btn btn-danger btn-sm btn-xs">删除</a>
                </div>
                </div>
                </li>
                <?php
                }
                ?>

                </ul>
            </div>
        </div>
    </section>
</section>
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
<?php include $this->template('footer','core');?>