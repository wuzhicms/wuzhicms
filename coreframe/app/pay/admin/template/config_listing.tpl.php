<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <?php echo $this->menu($GLOBALS['_menuid']);?>

            <div class="panel-body" id="panel-bodys">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">ID</th>
                        <th class="tablehead">支付方式</th>
                        <th class="tablehead" width="600px;">描述</th>
                        <th class="tablehead">状态</th>
                        <th class="tablehead">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($result AS $r) {

                        ?>
                        <tr>
                            <td><?php echo $r['id'];?></td>
                            <td><?php echo $r['name'];?></td>
                            <td class="paydescription"><?php echo $r['remark'];?></td>
                            <td <?php if($r['status']==1) echo "style='color:red;'";?>><?php echo $status_arr[$r['status']];?></td>
                            <td><a href="?m=pay&f=pay_config&v=edit&id=<?php echo $r['id'].$this->su();?>" class="btn btn-primary btn-xs">配置</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>

            </div>
        </section>
        </form>

    </div>

</div>

<!-- page end-->
</section>
<script type="text/javascript">
    function edit(id){
        top.openiframe('index.php?m=pay&f=index&v=edit&id='+id+'<?php echo $this->su();?>', 'edit', '改价', 500, 240);
    }
    </script>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>