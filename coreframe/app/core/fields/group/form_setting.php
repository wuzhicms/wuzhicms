<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="100%" class="table table-striped table-advance">
	<tr> 
      <td >默认选择的会员组</td>
      <td><input type="text" name="setting[groups]" value="<?php echo output($setting,'groups');?>" size="20">多个会员组ID用 “,” 分开</td>
    </tr>
</table>