<?php
   /**
    * 推荐位内容列表模板
    */
    defined('IN_WZ') or exit('No direct script access allowed'); 
    include $this->template('header', 'core');
?>
<body>
    <section class="wrapper">
        <section class="panel">
            <?php echo $this->menu($GLOBALS['_menuid']); ?>
            <div class="bg-light py-2 px-3">推荐位：<?php echo $rs['name']; ?></div>
                    <div class="panel-body">
                        <form class="form-horizontal tasi-form" method="post" action="">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">标题 <font color="red">＊</font></label>
                                <div class="col-5">
                                    <input type="text" class="form-control" name="form[title]" value="<?php echo $r['title']; ?>" datatype="*" errormsg="标题不能为空">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">缩略图</label>
                                <div class="col-5">
                                    <div class="input-group"><?php echo $form->attachment('', '1', 'form[thumb]', $r['thumb']); ?></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">链接地址</label>
                                <div class="col-5">
                                    <input type="text" class="form-control" name="form[url]" value="<?php echo $r['url']; ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">描述</label>
                                <div class="col-5">
                                    <textarea name="form[remark]" class="form-control" rows="5"><?php echo p_htmlentities($r['remark']); ?></textarea>
                                </div>
                            </div>
                            <?php if ($attach) {
                                $showdiy = false;
                                foreach ($attach as $field => $value) {
                                    if ($r['isdiy'] && in_array($field, array('subtitle', 'smalltitle'))) continue;
                                    if (in_array($field, array('sex', 'age', 'purpose', 'interest1', 'interest2', 'interest3'))) {
                                        $showdiy = true;
                                        continue;
                                    }
                            ?>
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-xs-4 control-label col-form-label text-end"><?php echo $field; ?></label>
                                        <div class="col-5">
                                            <textarea name="attform[<?php echo $field; ?>]" class="form-control" rows="2"><?php echo p_htmlentities($value); ?></textarea>
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                            if ($showdiy) {
                                if (is_string($attach['sex'])) {
                                    $attach['sex'] = explode(',', trim($attach['sex'], ','));
                                    $attach['age'] = explode(',', trim($attach['age'], ','));
                                }
                                ?>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">子标题</label>
                                    <div class="col-5">
                                        <input type="text" class="form-control" name="attform[subtitle]" value="<?php echo $attach['smalltitle']; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">小标题</label>
                                    <div class="col-5">
                                        <input type="text" class="form-control" name="attform[smalltitle]" value="<?php echo $attach['smalltitle']; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">性别</label>
                                    <div class="col-5">
                                        <label><input type="checkbox" name='attform[sex][]' value="1" <?php if (in_array(1, $attach['sex'])) echo 'checked'; ?>> 男</label> <label class="radio-inline"><input type="checkbox" name='attform[sex][]' value="2" <?php if (in_array(2, $attach['sex'])) echo 'checked'; ?>> 女</label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">年龄</label>
                                    <div class="col-5">
                                        <label><input type="checkbox" name='attform[age][]' value="1" <?php if (in_array(1, $attach['age'])) echo 'checked'; ?>> 18以下 </label> <label class="radio-inline"><input type="checkbox" name='attform[age][]' value="2" <?php if (in_array(2, $attach['age'])) echo 'checked'; ?>> 18~30</label> <label class="radio-inline"><input type="checkbox" name='attform[age][]' value="3" <?php if (in_array(3, $attach['age'])) echo 'checked'; ?>> 30~45</label> <label class="radio-inline"><input type="checkbox" name='attform[age][]' value="4" <?php if (in_array(4, $attach['age'])) echo 'checked'; ?>> 45以上</label>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">第一兴趣</label>
                                    <div class="col-5">
                                        <?php
                                        echo $form->radio($interest, $attach['interest1'], 'name="attform[interest1]"');
                                        ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">第二兴趣</label>
                                    <div class="col-5">
                                        <?php
                                        array_unshift($interest, '不选择');
                                        echo $form->radio($interest, $attach['interest2'], 'name="attform[interest2]"');
                                        ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-xs-4 control-label col-form-label text-end">第三兴趣</label>
                                    <div class="col-5">
                                        <?php
                                        echo $form->radio($interest, $attach['interest3'], 'name="attform[interest3]"');
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-xs-4 control-label col-form-label text-end"></label>
                                <div class="col-5">
                                    <input type="hidden" name="forward" value="<?php echo HTTP_REFERER; ?>">
                                    <input class="btn btn-info btn btn-info px-5" type="submit" name="submit" value="提交">
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
    </section>
    <script type="text/javascript">
        $(function() {
            $(".form-horizontal").Validform({
                tiptype: 3
            });
        })
    </script>