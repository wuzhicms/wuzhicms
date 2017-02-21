<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<style type="text/css">
    .tablewarnings{display: none;}
</style>
<link href="<?php echo R;?>js/colorpicker/style.css" rel="stylesheet">
<link href="<?php echo R;?>js/jquery-ui/jquery-ui.css" rel="stylesheet">
<script src="<?php echo R;?>js/colorpicker/color.js"></script>
<?php
echo '<script src="' . R . 'js/ckeditor/ckeditor.js"></script>';
echo '<script type="text/javascript" src="' . R . 'js/ueditor/ueditor.config.js"></script>';
echo '<script type="text/javascript" src="' . R . 'js/ueditor/ueditor.all.min.js"></script>';
?>
<section class="wrapper">
    <div class="row">
     <div class="col-lg-7 col-xm-7 col-sm-7">
         <section class="panel">
             <header class="panel-heading addpos"><font color="red"> <?php echo $data['title'];?></font>  > 采集网址配置 </header>
             <div class="panel-body" id="panel-bodys">
                 <form name="myform" class="form-horizontal tasi-form" action="" method="post">
                     <table class="table table-striped table-advance" id="contenttable">
                         <tbody>

                         <tr>
                             <td>

                                 </li>
                                 </ul>

                                 <div id="myTabContent" class="tab-content">
                                     <div role="tabpanel" class="tab-pane fade active in" id="tabs1" aria-labelledby="1tab">
                                         <table class="table table-striped table-advance" id="contenttable">
                                             <tr>
                                                 <td style="width: 120px;">
                                                     <strong>网址列表</strong>
                                                 </td>
                                                 <td class="hidden-phone">
                                                     <div class="col-sm-12 input-group">
                                                         <textarea name="form[remark]" class="form-control" cols="60" rows="8" placeholder="一行一个，第一页在最前面"></textarea>                                <span class="tablewarnings"></span>
                                                     </div>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td style="width: 120px;">
                                                     <strong>开始区域</strong>
                                                 </td>
                                                 <td class="hidden-phone">
                                                     <div class="col-sm-12 input-group">
                                                         <textarea name="form[remark]" class="form-control" cols="60" rows="3" ></textarea>                                <span class="tablewarnings"></span>
                                                     </div>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td style="width: 120px;">
                                                     <strong>结束区域</strong>
                                                 </td>
                                                 <td class="hidden-phone">
                                                     <div class="col-sm-12 input-group">
                                                         <textarea name="form[remark]" class="form-control" cols="60" rows="3" ></textarea>                                <span class="tablewarnings"></span>
                                                     </div>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td style="width: 120px;">
                                                     <strong>网址中必须包含的关键词</strong>
                                                 </td>
                                                 <td class="hidden-phone">
                                                     <div class="col-sm-12 input-group">
                                                         <input type="text" name="form[soft_author]" id="soft_author" size="" placeholder="" value="" class="form-control">                                <span class="tablewarnings"></span>
                                                     </div>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td style="width: 120px;">
                                                     <strong>网址中不能包含的关键词</strong>
                                                 </td>
                                                 <td class="hidden-phone">
                                                     <div class="col-sm-12 input-group">
                                                         <input type="text" name="form[soft_author]" id="soft_author" size="" placeholder="" value="" class="form-control">                                <span class="tablewarnings"></span>
                                                     </div>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td style="width: 120px;">
                                                     <strong>cookie</strong>
                                                 </td>
                                                 <td class="hidden-phone">
                                                     <div class="col-sm-12 input-group">
                                                         <textarea name="form[remark]" class="form-control" cols="60" rows="3" ></textarea>                                <span class="tablewarnings"></span>
                                                     </div>
                                                 </td>
                                             </tr>
                                         </table>

                                     </div>


                                 </div>

                             </td>
                         </tr>
                         <tr>
                             <td>
                                 <div class="contentsubmit text-center">
                                     <input type="hidden" name="modelid" value="1">
                                     <input name="submit" type="submit" class="save-bt btn btn-info" value=" 提 交 "> &nbsp;&nbsp;&nbsp;
                                     <input name="submit2" type="submit" class="btn  btn-primary" value=" 提交&发布英语">
                                 </div>
                             </td>
                         </tr>
                         </tbody>
                     </table>
                 </form>
             </div>
         </section>
     </div>
        <div class="col-lg-4 col-xm-4 col-sm-4">
            <div style="position: fixed;top: 18px;right: 0px;width: 40%;"><textarea style="width: 96%;height: 500px;" placeholder="测试结果将显示在这里，测试结果只显示前3页" class="form-control"></textarea></div>
        </div>
    </div>
</section>


<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<link href="<?php echo R;?>css/style.css" rel="stylesheet">
<script type="text/javascript">


</script>
