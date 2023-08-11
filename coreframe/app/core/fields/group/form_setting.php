<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="100%" class="table table-striped table-advance">
	<tr> 
      <td width="125">默认选择的会员组</td>
      <td class="d-flex">
          <input type="text" name="setting[groups]" value="<?php echo output($setting,'groups');?>" size="20" class="input-text form-control">
          <div class="col-sm-8 ps-2">
              <span class="tablewarnings"><i class="icon-info-circle"></i> 多个会员组ID用 “,” 分开</span>
          </div>
      </td>
    </tr>
</table>