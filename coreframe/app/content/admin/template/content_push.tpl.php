<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <div class="row">
        <div class="col-sm-12">
            <section class="panel tasks-widget">
                <header class="panel-heading">
                    <span>批量推送内容</span>
                </header>
                <form name="form1" method="post" action="?m=content&f=content&v=push<?php echo $this->su();?>">

                <div class="panel-body" id="panel-bodys">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="tablehead center">文章id</th>
                            <th class="tablehead center">目标站点</th>
                            <th class="tablehead center">目标栏目(<?php echo $modelname;?>)</th>

                        </tr>
                        </thead>
                        <tr>
                        <td><div class="col-lg-12 col-sm-12"><textarea name="ids" class="form-control" rows="14"><?php echo $ids;?></textarea></div></td>

                        <td><div class="col-lg-12 col-sm-12"><?php
                                $sitelist = get_cache('sitelist');
                                $site_arr = key_value($sitelist,'siteid','name');
                            echo $form->select($site_arr, 0, 'name="cid" style="height:260px;" class="form-control" size=2 onchange="load_sitecate(this.value)"');

                            ?></div></td>
                            <td><div class="col-lg-12 col-sm-12" id="categorys"><?php
                                    echo $form->tree_select($categorys, 0, 'name="cid" style="height:260px;width:260px;" class="form-control" size=2', '≡ 请选择栏目 ≡');

                                    ?></div></td>
                        </tr>
                        <tr><td colspan="3" class="text-center">
                                <input name="forward" type="hidden" value="<?php echo HTTP_REFERER;?>">
                                <button type="submit" class="btn btn-primary"><i class=" icon-angle-double-right btn-icon"></i>批量推送</button></td></tr>
                        </table>
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
    window.scrollTo(0,0);
    function load_sitecate(siteid) {
        $("#categorys").html('<select name="cid" style="height:260px;width:260px;" class="form-control" size="2"><option value="" selected="">正在载入栏目列表，请稍等...</option></select>');
        $.get("?m=content&f=category&v=load_sitecate&siteid="+siteid+"&cid=<?php echo $GLOBALS['cid'].$this->su();?>", {  time: "2pm" },
            function(data){
                $("#categorys").html(data);
            });

    }
</script>
</body>
</html>