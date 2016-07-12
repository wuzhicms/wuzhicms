<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body>
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>

                <div class="panel-body">
                    <form class="form-horizontal tasi-form" method="post" action="">
                        <input type="hidden" name="v" value="<?php echo $v;?>" />
                        <input type="hidden" nmae="sid" value="<?php echo $sid;?>" />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">类别名称</label>
                            <div class="col-sm-4 input-group">
                                <input type="text" class="form-control" name="form[name]" value="<?php echo $result['name'];?>"
                                       color="#000000" datatype="s2-30"
                                       placeholder="类别名称"  errormsg="至少2个字符,最多20个字符！">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">所属模块</label>
                            <div class="col-sm-4 input-group">
                                <select class="form-control" id="selectm" name="form[selectm]" >
                                    <?php foreach($module_list as $r){ ?>
                                        <option value="<?php echo $r['m'];?>"
                                            <?php if( $r['m'] == $result['m'] ){

                                                echo ' selected="selected" ';
                                            }
                                            ?>
                                            ><?php echo $r['m'];?></option>
                                    <?php }  ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">所属模型</label>
                            <div class="col-sm-4 input-group" id="modelListDiv">
                                加载中...
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">类别描述</label>
                            <div class="col-sm-4 input-group">
                                <textarea class="form-control" style="height:100px;" name="form[remark]" ><?php echo $result['remark'];?></textarea>
                            </div>
                        </div>




                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10 input-group">
                                <input class="btn btn-info" type="submit" name="submit" value="提交">
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script type="text/javascript">
    $(function(){

        function rederModelSelector(data){
            var html = '<select class="form-control" name="form[modelid]" >';
            var selectId = '<?php echo $result['modelid'];?>';
            if(data){
                //console.info('data: ' + data);

                for(var i = 0; i<data.length; i++){
                   var item = data[i];
                   //console.info('item: ' + item);
                   html += '<option value="' + item.modelid +'" ';
                   if(selectId == item.modelid ){
                       html += ' selected="selectd" ';
                   }
                   html += ' >';
                   html += item.name;
                   //console.info(item.name);
                   html += '</option>';
                }

            }
            html += '</select>';
            $('#modelListDiv').html(html);
        }


        function initModelList(){
            var selectm = $('#selectm').val();
            var murl = 'index.php?m=search&f=index&v=model_list<?php echo $this->su();?>';
            $.post(murl,
                {'selectm':selectm},
                function(data){
                    console.info('ajax post ok ');
                    rederModelSelector(data);
                },
                'json'
            );
        }


        initModelList();

        $('#selectm').change(function(){
            initModelList();
        });

    })
</script>

