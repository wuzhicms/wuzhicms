<?php defined('IN_WZ') or exit('No direct script access allowed'); ?>
<?php include $this->template('header', 'core'); ?>
<body>
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']); ?>
                <form method="post" action="">
                <div class="panel-body" id="panel-bodys">
                        <input type="hidden" name="v" value="save"/>
                        <table class="table table-striped table-advance table-hover">
                        <tbody>
                              <tr>
                                  <td>是否启用全站搜索</td>
                                  <td class="hidden-phone"><input id="fulltextenble1" type="radio" name="cfg[fulltextenble]" value="1"
                                        <?php if($fulltextenble=='1'){ ?> checked <?php }   ?>  />
                                    <label for="fulltextenble1"> 是</label>
                                    <input id="fulltextenble0" type="radio" name="cfg[fulltextenble]" value="0"
                                        <?php if($fulltextenble=='0'){ ?> checked <?php }   ?>  />
                                    <label for="fulltextenble0"> 否</label></td>
                              </tr>
                              <tr>
                                  <td>是否启用相关搜索（此项功能会增大数据库压力） </td>
                                  <td><input id="relationenble1" type="radio" name="cfg[relationenble]" value="1"
                                        <?php if($relationenble=='1'){ ?> checked <?php }   ?> />
                                    <label for="relationenble1"> 是</label>
                                    <input id="relationenble0" type="radio" name="cfg[relationenble]" value="0"
                                        <?php if($relationenble=='0'){ ?> checked <?php }   ?> />
                                    <label for="relationenble0"> 否</label></span></td>
                              </tr>
                              </tbody>

                          
                            <?php /**
                            <tr>
                                <th>
                                    是否启用建议搜索<br/>
                                    （提示数据来源于 baidu）
                                </th>
                                <td>
                                    <input id="suggestenable1" type="radio" name="cfg[suggestenable]" value="1"
                                        <?php if($suggestenable=='1'){ ?> checked <?php }	?> />
                                    <label for="suggestenable1"> 是</label>
                                    <input id="suggestenable0" type="radio" name="cfg[suggestenable]" value="0"
                                        <?php if($suggestenable=='0'){ ?> checked <?php }	?> />
                                    <label for="suggestenable0"> 否</label>

                                </td>
                            </tr>
                            <tr>
                                <th width="200">是否启用sphinx全文索引</th>
                                <td>
                                    <input id="sphinxenable1" type="radio" name="cfg[sphinxenable]" value="1"
                                        <?php if($sphinxenable==1){ ?> checked <?php }	?> />
                                    <label for="sphinxenable1">是</label>
                                    <input id="sphinxenable0" type="radio" name="cfg[sphinxenable]" value="0"
                                        <?php if($sphinxenable==0){ ?> checked <?php }	?> />
                                    <label for="sphinxenable0">否</label>
                                </td>
                            </tr>
                            <tr>
                                <th>服务器IP或域名</th>
                                <td>
                                    <input name="cfg[sphinxhost]" id="sphinxhost" value="<?php echo $sphinxhost; ?>"
                                           type="text" class="input-text" />
                                </td>
                            </tr>
                            <tr>
                                <th>服务器端口号</th>
                                <td>
                                    <input name="cfg[sphinxport]" id="sphinxport" value="<?php echo $sphinxport; ?>"
                                           type="text" class="input-text" />
                                </td>
                            </tr>
 **/  ?>
                           
                               
                                
                                    
                         
                        </table>
                </div>
                <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="pull-left">
                                        <input class="btn btn-info" type="submit" name="dosubmit" value="保存设置" />
                                        <input class="btn btn-info" name="button" type="button" value="测试"
                                               onclick="test_sphinx()" />
                                        <div id="testing" class="alert alert-info fade in" style="display: none;"></div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                </form>
            </section>
        </div>
    </div>
</section>

<?php /**
<script type="text/javascript">


    function test_sphinx() {
        $('#testing').show().html('测试中...');
        var url = 'index.php?m=search&f=config&v=test<?php echo $this->su();?>';

        $.post(url,
            {
                sphinxhost:$('#sphinxhost').val(),
                sphinxport:$('#sphinxport').val()
            },
            function(data){
                var message = '';
                var msgClass = 'alert-danger';
                $('#testing').removeClass(msgClass).removeClass('alert-info').removeClass('alert-success');
                if(data == 1) {
                    message = '连接服务器成功';
                    msgClass = 'alert-success';
                } else if(data == -1) {
                    message = '服务器IP或域名为空';
                } else if(data == -2) {
                    message = '服务器端口号为空';
                } else {
                    message = data;
                }

                $('#testing').addClass(msgClass).show().html(message);
            }
        );
    }

</script>
**/?>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>
