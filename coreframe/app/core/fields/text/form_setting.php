<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" class="table table-striped table-advance table-hover" style="border: 1px solid #E9EAEE;">
	<tr> 
    <td class="col-sm-2">文本框长度</td>
    <td><input type="text" name="setting[size]" value="<?php echo output($setting,'size');?>" class="input-text col-sm-2"></td>
  </tr>
	<tr> 
    <td>默认值</td>
    <td><input type="text" name="setting[defaultvalue]" value="<?php echo output($setting,'defaultvalue');?>"  class="input-text col-sm-2"></td>
  </tr>
  <tr>
    <td>placeholder</td>
    <td><input type="text" name="setting[placeholder]" value="<?php echo output($setting,'placeholder');?>" class="input-text col-sm-2"></td>
  </tr>
	<tr> 
    <td>是否为密码框</td>
    <td><input type="radio" name="setting[ispassword]" value="1" <?php if(output($setting,'ispassword')) echo 'checked';?>> 是 <input type="radio" name="setting[ispassword]" value="0" <?php if(!output($setting,'ispassword')) echo 'checked';?>> 否</td>
  </tr>
	<tr> 
    <td>是否过滤html标签</td>
    <td><input type="radio" name="setting[enablehtml]" value="1" <?php if(output($setting,'enablehtml')) echo 'checked';?>> 是 <input type="radio" name="setting[enablehtml]" value="0" <?php if(!output($setting,'enablehtml')) echo 'checked';?>> 否</td>
  </tr>
</table>