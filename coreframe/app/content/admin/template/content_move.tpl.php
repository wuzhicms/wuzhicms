<?php
/**
 * 文章移动操作模板
 */
defined('IN_WZ') or exit('No direct script access allowed');
include $this->template('header', 'core');
?>
<body>
    <section class="wrapper">
        <section class="panel tasks-widget">
            <header class="panel-heading"><span>批量移动</span></header>
                <form name="form1" method="post" action="?m=content&f=content&v=move<?php echo $this->su(); ?>">
                    <div class="row panel-body">
                        <div class="col-sm-6">
                            <h6 class="text-center small">文章id</h6>
                            <textarea name="ids" class="form-control" rows="14"><?php echo $ids; ?></textarea>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="text-center small">目标栏目(<?php echo $modelname; ?>)</h6>
                                <?php
                                echo $form->tree_select($categorys, 0, 'name="cid" style="height:260px;" class="form-control" size=2', '≡ 请选择栏目 ≡');
                                ?>
                        </div>
                        <div class="text-center mt-4">
                            <input name="forward" type="hidden" value="<?php echo HTTP_REFERER; ?>">
                            <button type="submit" class="btn btn-primary btn-sm px-4"><i class=" icon-angle-double-right btn-icon"></i>批量移动</button>
                        </div>
                    </div>
                </form>
        </section>
    </section>
    <script type="text/javascript">
        window.scrollTo(0, 0);
    </script>
    <?php include $this->template('footer', 'core'); ?>
