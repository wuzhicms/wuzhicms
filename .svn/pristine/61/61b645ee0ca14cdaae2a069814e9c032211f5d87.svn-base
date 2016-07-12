<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
//默认值
if(V=='field_add') {
    $setting = array(
        'fieldtype'=>'date',
        'format'=>'Y-m-d Ah:i:s',
    );
}
?>
<table cellpadding="2" cellspacing="1" bgcolor="#ffffff" class="table table-striped table-advance ">
	<tr>
      <td><strong>时间格式：</strong></td>
      <td>
	  <input type="radio" name="setting[fieldtype]" value="date" <?php if(output($setting,'fieldtype')=='date') echo 'checked';?>>日期（<?=date('Y-m-d')?>）<br />
	  <input type="radio" name="setting[fieldtype]" value="datetime_a" <?php if(output($setting,'fieldtype')=='datetime_a') echo 'checked';?>>日期+12小时制时间（<?=date('Y-m-d Ah:i:s')?>）<br />
	  <input type="radio" name="setting[fieldtype]" value="datetime" <?php if(output($setting,'fieldtype')=='datetime') echo 'checked';?>>日期+24小时制时间（<?=date('Y-m-d H:i:s')?>）<br />
	  <input type="radio" name="setting[fieldtype]" value="int" <?php if(output($setting,'fieldtype')=='int') echo 'checked';?>>整数 显示格式：
	  <select name="setting[format]">
	  <option value="Y-m-d Ah:i:s" <?php if(output($setting,'format')=='Y-m-d Ah:i:s') echo 'selected';?>>12小时制:<?php echo date('Y-m-d h:i:s')?></option>
	  <option value="Y-m-d H:i:s" <?php if(output($setting,'format')=='Y-m-d H:i:s') echo 'selected';?>>24小时制:<?php echo date('Y-m-d H:i:s')?></option>
	  <option value="Y-m-d H:i" <?php if(output($setting,'format')=='Y-m-d H:i') echo 'selected';?>><?php echo date('Y-m-d H:i')?></option>
	  <option value="Y-m-d" <?php if(output($setting,'format')=='Y-m-d') echo 'selected';?>><?php echo date('Y-m-d')?></option>
	  <option value="m-d" <?php if(output($setting,'format')=='m-d') echo 'selected';?>><?php echo date('m-d')?></option>
	  </select>
	  </td>
    </tr>
</table>