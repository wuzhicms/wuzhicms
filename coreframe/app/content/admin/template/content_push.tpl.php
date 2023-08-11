<?php
/***
 * 内容推送操作模板
 */
defined('IN_WZ') or exit('No direct script access allowed');
include $this->template('header', 'core');
?>
<body>
    <section class="wrapper">
        <section class="panel tasks-widget">
            <header class="panel-heading"><span>批量推送内容</span></header>
                    <form name="form1" method="post" action="?m=content&f=content&v=push<?php echo $this->su(); ?>">
                        <div class="row panel-body">
                            <div class="col-sm-4">
                                <h6 class="text-center small">文章id</h6>
                                <textarea name="ids" class="form-control" rows="14"><?php echo $ids; ?></textarea>
                            </div>
                            <div class="col-sm-4">
                                <h6 class="text-center small">目标站点</h6>
                                <?php
                                $sitelist = get_cache('sitelist');
                                $site_arr = key_value($sitelist, 'siteid', 'name');
                                echo $form->select($site_arr, 0, 'name="cid" style="height:260px;" class="form-control" size=2 onchange="load_sitecate(this.value)"');
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <h6 class="text-center small">目标栏目(模型名:<?php echo $modelname; ?>)</h6>
                                <div id="categorys">
                                    <?php
                                    echo $form->tree_select($categorys, 0, 'name="cid" style="height:260px;" class="form-control" size=2', '≡ 请选择栏目 ≡');
                                    ?>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <input name="forward" type="hidden" value="<?php echo HTTP_REFERER; ?>">
                                <button type="submit" class="btn btn-primary btn-sm px-4"><i class=" icon-angle-double-right btn-icon"></i>批量推送</button>
                            </div>
                        </div>
                    </form>
                </section>
    </section>
    <script type="text/javascript">
        window.scrollTo(0, 0);
        function load_sitecate(siteid) {
            $("#categorys").html('<select name="cid" style="height:260px;" class="form-control" size="2"><option value="" selected="">正在载入栏目列表，请稍等...</option></select>');
            $.get("?m=content&f=category&v=load_sitecate&siteid=" + siteid + "&cid=<?php echo $GLOBALS['cid'] . $this->su(); ?>", {
                    time: "2pm"
                },
                function(data) {
                    $("#categorys").html(data);
                });
        }
    </script>
    <?php include $this->template('footer', 'core'); ?>
