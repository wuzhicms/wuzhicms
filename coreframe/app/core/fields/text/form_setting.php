<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%" class="table table-striped table-advance table-hover">
	<tr> 
      <td width="125">文本框长度</td>
      <td class="d-flex col-3 pe-3"><input type="text" name="setting[size]" value="<?php echo output($setting,'size');?>" size="10" class="input-text form-control"></td>
    </tr>
	<tr>
        <td>默认值</td>
        <td class="d-flex col-3 pe-3"><input type="text" name="setting[defaultvalue]" value="<?php echo output($setting,'defaultvalue');?>" size="40" class="input-text form-control"></td>
    </tr>
    <tr>
        <td>placeholder</td>
        <td class="d-flex col-3 pe-3"><input type="text" name="setting[placeholder]" value="<?php echo output($setting,'placeholder');?>" size="40" class="input-text form-control"></td>
    </tr>
	<tr> 
      <td>是否为密码框</td>
      <td class="d-flex col-3">
          <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="setting[ispassword]" id="ispassword1" value="1" <?php if(output($setting,'ispassword')) echo 'checked';?>>
              <label class="form-check-label" for="ispassword1">是</label>
          </div>
          <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="setting[ispassword]" id="ispassword0" value="0" <?php if(output($setting,'ispassword')) echo 'checked';?>>
              <label class="form-check-label" for="ispassword0">否</label>
          </div>
      </td>
    </tr>
	<tr> 
      <td>是否过滤html标签</td>
      <td class="d-flex col-3">
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