<table cellpadding="2" cellspacing="1" width="100%" class="table table-striped table-advance table-hover">
	<tr> 
      <td>允许上传的文件类型</td>
      <td><input type="text" name="setting[upload_allowext]" value="<?php echo output($setting,'upload_allowext');?>" size="40" class="input-text"></td>
    </tr>
	<tr> 
      <td>文件打开方式</td>
      <td><label><input type="radio" name="setting[linktype]" value="1" <?php if(output($setting,'linktype')) echo 'checked';?> > 当前页面打开 </label> <label><input type="radio" name="setting[linktype]" value="0" <?php if(!output($setting,'linktype')) echo 'checked';?>> 新窗口打开（支持登录验证） </label></td>
    </tr>
    <tr>
        <td>文件下载方式</td>
        <td><label><input type="radio" name="setting[downloadtype]" value="1" <?php if(output($setting,'downloadtype')) echo 'checked';?>> 链接到真实地址 </label> <label><input type="radio" name="setting[downloadtype]" value="0" <?php if(!output($setting,'downloadtype')) echo 'checked';?>> 通过PHP读取 </label></td>
    </tr>
</table>