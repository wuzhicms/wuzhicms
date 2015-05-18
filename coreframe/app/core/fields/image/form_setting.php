<table cellpadding="2" cellspacing="1" width="100%" class="table table-striped table-advance table-hover">
    <tr>
        <td>允许上传的文件类型</td>
        <td><input type="text" name="setting[upload_allowext]" value="<?php echo output($setting,'upload_allowext');?>" size="40" class="input-text"></td>
    </tr>
    <tr>
        <td>是否在直接裁剪为固定尺寸</td>
        <td><label><input type="radio" name="setting[images_cut]" value="1" <?php if(output($setting,'images_cut')) echo 'checked';?> > 是 （一般设置为所需尺寸的2倍最佳）</label> <label><input type="radio" name="setting[images_cut]" value="0" <?php if(!output($setting,'images_cut')) echo 'checked';?>> 否 </label></td>
    </tr>
	<tr> 
      <td>图像大小（设置为直接裁剪时有效）</td>
      <td>宽 <input type="text" name="setting[images_width]" value="<?php echo output($setting,'images_width');?>" size="3" class="input-text">px 高 <input type="text" name="setting[images_height]" value="<?php echo output($setting,'images_height');?>" size="3" class="input-text">px</td>
    </tr>
</table>