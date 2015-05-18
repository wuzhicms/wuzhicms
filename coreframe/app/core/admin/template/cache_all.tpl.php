<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel tasks-widget">
                <header class="panel-heading">
                    <span>更新缓存</span>
                </header>
                <form name="myform" method="post" action="">
                <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                <thead>
                    <tr>
                        <th class="tablehead"><input type="checkbox"  id="check_box" onclick="checkall('selectAll',this);"> 全选</th>
                        <th class="tablehead">缓存项目</th>
                        <th class="tablehead">更新</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($result as $r) {
                        ?>
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="<?php echo $r['id'];?>"></td>
                        <td><?php echo $r['data'];?></td>
                        <td>
                             <a href="?m=core&f=cache_all&v=cache&module=<?php echo $r['m'];?>&file=<?php echo $r['f'];?>&view=<?php echo $r['v'];?><?php echo $this->su();?>" class="btn btn-primary btn-xs">更新</a>
                        </td>
                    </tr>
                    <?php
                         }?>
              
                </tbody>
            </table>
  
            <div class="panel-body" id="cachesicon">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="pull-left">
                            <input type="hidden" name="v" value="cache_select">
                            <button type="button" onClick="checkall()" name="submit2" class="btn btn-default btn-sm">全选/反选</button>
                            <a href="javascript:cache_select();" class="btn btn-default btn-sm"><i class="icon-cycle btn-icon"></i>更新选择</a>
                            <a href="?m=core&f=cache_all&v=cache_select<?php echo $this->su();?>" class="btn btn-primary btn-sm"><i class="icon-cycle btn-icon"></i>一键全部更新</a>

                        </div>

                    </div>
                </div>
            </div>

                </div>
                </form>
            </section>
        </div>
    </div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script type="text/javascript">
    function cache_select() {
        myform.submit();
    }
</script>
</body>
</html>