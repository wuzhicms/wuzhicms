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
                    <span>批量更新</span>
                </header>
                <div class="panel-body">
                        <!--批量生成栏目页开始-->
                        <div class="col-sm-4">
                        <form name="form1" method="post" action="?m=content&f=createhtml&v=htmllist<?php echo $this->su();?>">
                           <div class="createhtmllist">
                                 <?php
                                 echo $formcategorys = $form->tree_select($categorys, 0, 'name="catids[]" class="form-control" multiple="multiple" title="按住“Ctrl”或“Shift”键可以多选，按住“Ctrl”可取消选择"', '≡ 全部 ≡');

                                 ?>
                            </div>
                            <div class="text-center createhtmlbtn">
                            <button type="submit" class="btn btn-primary"><i class="icon-cycle btn-icon"></i>批量生成栏目页</button>
                            </div>
                        </form>
                        </div>
                        <!--批量生成栏目页结束-->

                        <!--批量生成内容页开始-->
                        <div class="col-sm-4">
                        <form name="form2" method="post" action="?m=content&f=createhtml&v=htmlshow<?php echo $this->su();?>">
                           <div class="createhtmllist">
                                 <?php
                                     echo $formcategorys;
                                     ?>
                            </div>
                            <div class="text-center createhtmlbtn">
                            <button type="submit" class="btn btn-primary"><i class="icon-cycle btn-icon"></i>批量生成内容页</button>
                            </div>
                        </form>
                        </div>
                        <!--批量生成内容页结束-->

                        <!--批量更新内容页url开始-->
                        <div class="col-sm-4">
                        <form name="form3" method="post" action="?m=content&f=createhtml&v=updateurls<?php echo $this->su();?>">
                           <div class="createhtmllist">
                                 <?php
                                     echo $formcategorys;
                                     ?>
                            </div>
                            <div class="text-center createhtmlbtn">
                            <button type="submit" class="btn btn-primary"><i class="icon-cycle btn-icon"></i>批量生成更新内容页url</button>
                            </div>
                        </form>
                        </div>
                        <!--批量更新内容页url结束-->
                        
                </div>
            </section>
        </div>
    </div>
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script type="text/javascript">
    window.scrollTo(0,0);
</script>
</body>
</html>