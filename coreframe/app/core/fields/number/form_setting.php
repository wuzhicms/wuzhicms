<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
//默认值
if(V=='field_add') {
    $setting = array(
        'defaultvalue'=>"0",
    );
}
?>
<table cellpadding="2" cellspacing="1" width=100%" class="table table-striped table-advance ">
    <tr>
        <td>字段类型</td>
        <td>
            <select name="setting[fieldtype]" onchange="javascript:fieldtype_setting(this.value);">
                <option value="int" <?php if(output($setting,'fieldtype')=='int') echo 'selected';?>>整数 INT(10)</option>
                <option value="tinyint" <?php if(output($setting,'fieldtype')=='tinyint') echo 'selected';?>>整数 TINYINT(3)</option>
                <option value="smallint" <?php if(output($setting,'fieldtype')=='smallint') echo 'selected';?>>整数 SMALLINT(5)</option>
                <option value="mediumint" <?php if(output($setting,'fieldtype')=='mediumint') echo 'selected';?>>整数 MEDIUMINT(8)</option>
                <option value="money1" <?php if(output($setting,'fieldtype')=='money1') echo 'selected';?>>浮点型 decimal(10,1) - 例如:1.0 </option>
                <option value="money" <?php if(output($setting,'fieldtype')=='money') echo 'selected';?>>浮点型 decimal(10,2) - 例如: 1.00</option>
                <option value="money2" <?php if(output($setting,'fieldtype')=='money2') echo 'selected';?>>浮点型 decimal(4,3) - 一般用于评分换算,默认5.000</option>
                <option value="money3" <?php if(output($setting,'fieldtype')=='money3') echo 'selected';?>>浮点型 decimal(4,1) - 一般用于评分,默认5.0</option>
            </select> <span id="minnumber" style="display:none"><input type="radio" name="setting[minnumber]" value="1" <?php if(output($setting,'minnumber')==1) echo 'checked';?>/> <font color='red'>正整数</font> <input type="radio" name="setting[minnumber]" value="-1" <?php if(output($setting,'minnumber')==-1) echo 'checked';?>/> 整数</span>
        </td>
    </tr>
    <tr>
        <td>默认值</td>
        <td><input type="text" name="setting[defaultvalue]" size="40" class="input-text" value="<?php echo output($setting,'defaultvalue');?>"></td>
    </tr>
</table>
