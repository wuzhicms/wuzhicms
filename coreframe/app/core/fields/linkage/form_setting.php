<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%" class="table table-striped table-advance table-hover">
	<tr> 
      <td width="100">联动菜单ID</td>
      <td><input type="text" name="setting[linkageid]" value="<?php echo output($setting,'linkageid');?>" size="10" class="input-text"></td>
    </tr>
	<tr> 
      <td>默认值</td>
      <td><input type="text" name="setting[defaultvalue]" value="<?php echo output($setting,'defaultvalue');?>" size="40" class="input-text"></td>
    </tr>
</table>