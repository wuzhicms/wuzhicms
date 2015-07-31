<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%" class="table table-striped table-advance table-hover">
	<tr>
      <td>页面字段ID</td>
      <td><input type="text" name="setting[formfield]" value="<?php echo output($setting,'formfield');?>" size="40" class="input-text"></td>
    </tr>
</table>