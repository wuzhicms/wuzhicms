<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%" class="table_field">
	<tr> 
      <td width="125">默认值</td>
      <td class="d-flex col-3 pe-3"><input type="text" name="setting[defaultvalue]" value="<?php echo output($setting,'defaultvalue');?>" size="40" class="input-text form-control"></td>
    </tr>
	<tr> 
      <td>是否过滤html标签</td>
      <td class="d-flex col-3 pe-3">
          <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="setting[enablehtml]" id="enablehtml1" value="1" <?php if(output($setting,'enablehtml')) echo 'checked';?>>
              <label class="form-check-label" for="enablehtml1">是</label>
          </div>
          <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="setting[enablehtml]" id="enablehtml0" value="0" <?php if(output($setting,'enablehtml')) echo 'checked';?>>
              <label class="form-check-label" for="enablehtml0">否</label>
          </div>
      </td>
    </tr>
</table>