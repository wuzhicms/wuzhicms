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
<table cellpadding="2" cellspacing="1" class="table table-striped table-advance ">
	<tr>
      <td width="125">时间格式：</td>
      <td class="col-6 d-block">
          <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="setting[fieldtype]" id="date" value="date" <?php if(output($setting,'fieldtype')=='date') echo 'checked';?>>
              <label class="form-check-label" for="date">日期（<?=date('Y-m-d')?>）</label>
          </div>
          <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="setting[fieldtype]" id="datetime_a" value="datetime_a" <?php if(output($setting,'fieldtype')=='datetime_a') echo 'checked';?>>
              <label class="form-check-label" for="datetime_a">日期+12小时制时间（<?=date('Y-m-d Ah:i:s')?>）</label>
          </div>
          <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="setting[fieldtype]" id="datetime" value="datetime" <?php if(output($setting,'fieldtype')=='datetime') echo 'checked';?>>
              <label class="form-check-label" for="datetime">日期+24小时制时间（<?=date('Y-m-d H:i:s')?>）</label>
          </div>
          <div class="form-check">
              <input class="form-check-input" type="radio" name="setting[fieldtype]" id="int" value="int" <?php if(output($setting,'fieldtype')=='int') echo 'checked';?>>
              <label class="form-check-label d-inline-flex" for="int">
                  <span>整数 显示格式：</span>
                  <span>
                      <select name="setting[format]" class="form-select">
                      <option value="Y-m-d Ah:i:s" <?php if(output($setting,'format')=='Y-m-d Ah:i:s') echo 'selected';?>>12小时制:<?php echo date('Y-m-d h:i:s')?></option>
                      <option value="Y-m-d H:i:s" <?php if(output($setting,'format')=='Y-m-d H:i:s') echo 'selected';?>>24小时制:<?php echo date('Y-m-d H:i:s')?></option>
                      <option value="Y-m-d H:i" <?php if(output($setting,'format')=='Y-m-d H:i') echo 'selected';?>><?php echo date('Y-m-d H:i')?></option>
                      <option value="Y-m-d" <?php if(output($setting,'format')=='Y-m-d') echo 'selected';?>><?php echo date('Y-m-d')?></option>
                      <option value="m-d" <?php if(output($setting,'format')=='m-d') echo 'selected';?>><?php echo date('m-d')?></option>
                  </select>
                  </span>
              </label>
          </div>
	  </td>
    </tr>
</table>