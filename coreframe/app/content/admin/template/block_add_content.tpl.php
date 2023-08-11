<?php 
   /**
    * 推荐位内容添加模板
    */
    defined('IN_WZ') or exit('No direct script access allowed'); 
    include $this->template('header', 'core');
    $menu_r = $this->db->get_one('menu', array('m' => 'content', 'f' => 'block', 'v' => 'item_listing'));
    $submenuid = $menu_r['menuid'];
?>
<body>
    <section class="wrapper">
        <section class="panel">
                    <?php echo $this->menu($submenuid, "&blockid=$blockid"); ?>
                    <div class="bg-light py-2 px-3 fw-bold">推荐位：<?php echo $rs['name']; ?></div>
                    <div class="panel-body">
                        <form class="form-horizontal tasi-form" method="post" action="">
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">标题 <font color="red">＊</font></label>
                                <div class="col-5">
                                    <input type="text" class="form-control" name="form[title]" value="<?php echo $r['title']; ?>" datatype="*" errormsg="标题不能为空">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">缩略图</label>
                                <div class="col-5">
                                    <div class="upload-picture-card"><?php echo $form->attachment('', '1', 'form[thumb]', $r['thumb']); ?></div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">链接地址</label>
                                <div class="col-5">
                                    <input type="text" class="form-control" name="form[url]" value="<?php echo $r['url']; ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">描述</label>
                                <div class="col-5">
                                    <textarea name="form[remark]" class="form-control" rows="5"><?php echo p_htmlentities($r['remark']); ?></textarea>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end"></label>
                                <div class="col-5">
                                    <input type="hidden" name="forward" value="<?php echo HTTP_REFERER; ?>">
                                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
        <!-- page end-->
    </section>
    <script type="text/javascript">
        $(function() {
            $(".form-horizontal").Validform({
                tiptype: 3
            });
        })
    </script>
<?php include $this->template('footer', 'core'); ?>