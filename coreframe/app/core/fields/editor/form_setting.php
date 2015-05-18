<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
//默认值
if(V=='field_add') {
    $setting = array(
        'toolbar'=>'basic',
    );
}
?>
<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-advance table-hover">
    <tr>
        <td width="175">编辑器样式：</td>
        <td><input type="radio" name="setting[toolbar]" value="basic" <?php if(output($setting,'toolbar')=='basic') echo 'checked';?>> 简洁型 <input type="radio" name="setting[toolbar]" value="normal" <?php if(output($setting,'toolbar')=='normal') echo 'checked';?>> 标准型 <input type="radio" name="setting[toolbar]" value="full" <?php if(output($setting,'toolbar')=='full') echo 'checked';?>> 全功能 <input type="radio" name="setting[toolbar]" value="textarea" <?php if(output($setting,'toolbar')=='textarea') echo 'checked';?>> 文本框 </td>
    </tr>
    <tr>
        <td>默认值：</td>
        <td><textarea name="setting[defaultvalue]" rows="2" cols="20" id="defaultvalue" style="height:100px;width:250px;"><?php echo output($setting,'defaultvalue');?></textarea></td>
    </tr>

    <tr>
        <td>是否保存远程图片：</td>
        <td><input type="radio" name="setting[enablesaveimage]" value="1" <?php if(output($setting,'enablesaveimage')==1) echo 'checked';?>> 是 <input type="radio" name="setting[enablesaveimage]" value="0"  <?php if(output($setting,'enablesaveimage')==0) echo 'checked';?>> 否</td>
    </tr>

    <tr>
        <td>是否添加水印：</td>
        <td> <input type="radio" name="setting[watermark_enable]" value="1" <?php if(output($setting,'watermark_enable')==1) echo 'checked';?>>是 <input type="radio" name="setting[watermark_enable]" value="0" <?php if(output($setting,'watermark_enable')==0) echo 'checked';?>> 否</td>
    </tr>
</table>