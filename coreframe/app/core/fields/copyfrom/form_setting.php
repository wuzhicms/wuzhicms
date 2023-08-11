<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="100%">
	<tr> 
      <td width="125">默认值</td>
      <td class="d-flex col-3"><input type="text" name="setting[defaultvalue]" value="<?php echo output($setting,'defaultvalue');?>" size="50" class="input-text form-control"></td>
    </tr>
</table>