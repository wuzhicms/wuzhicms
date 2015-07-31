<table cellpadding="2" cellspacing="1" width="100%" class="table table-striped table-advance table-hover">
    <tr>
        <td>允许上传的文件类型</td>
        <td><input type="text" name="setting[upload_allowext]" value="<?php echo output($setting,'upload_allowext');?>" size="40" class="input-text"></td>
    </tr>
     <tr>
        <td>是否添加水印</td>
        <td><label><input type="radio" name="setting[is_water]" value="1" <?php if(output($setting,'is_water')) echo 'checked';?> > 是 </label> <label><input type="radio" name="setting[is_water]" value="0" <?php if(!output($setting,'is_water')) echo 'checked';?>> 否 </label></td>
    </tr>
    <tr>
        <td>是否允许原图显示</td>
        <td><label><input type="radio" name="setting[is_allow_show_img]" value="1" <?php if(output($setting,'is_allow_show_img')) echo 'checked';?> > 是</label> <label><input type="radio" name="setting[is_allow_show_img]" value="0" <?php if(!output($setting,'is_allow_show_img')) echo 'checked';?>> 否 </label></td>
    </tr>
</table>