<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="100%" class="table table-striped table-advance table-hover">
	<tr> 
      <td width="125">默认值</td>
      <td class="d-flex col-3"><input type="text" name="setting[defaultvalue]" value="<?php echo output($setting,'defaultvalue');?>" size="40" class="input-text form-control"></td>
    </tr>
</table>