<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
//默认值
if(V=='field_add') {
    $setting = array(
        'sql'=>'SELECT `groupid`,`name` FROM `wz_member_group` ORDER BY `groupid` ASC',
        'field_name'=>'name',
        'field_value'=>'groupid',
        'boxtype'=>'radio',
        'width'=>'100',
        'size'=>'10',
        'defaultvalue'=>"1",
    );
}
?>
<table cellpadding="2" cellspacing="1" width=100%" class="table table-striped table-advance ">
    <tr>
        <td width="125">SQL</td>
        <td class="d-flex col-8 pe-3"><input type="text" name="setting[sql]" class="form-control" value="<?php echo output($setting,'sql');?>"></td>
    </tr>
    <tr>
        <td>选项名的字段名</td>
        <td class="d-flex col-3 pe-3"><input type="text" name="setting[field_name]" class="form-control" value="<?php echo output($setting,'field_name');?>"></td>
    </tr>
    <tr>
        <td>选项值的字段名</td>
        <td class="d-flex col-3 pe-3"><input type="text" name="setting[field_value]" class="form-control" value="<?php echo output($setting,'field_value');?>"></td>
    </tr>
    <tr>
        <td>选项类型</td>
        <td>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[boxtype]" id="radio" value="radio" <?php if(output($setting,'boxtype')=='radio') echo 'checked';?> onclick="$('#setcols').show();$('#setsize').hide();"/>
                <label class="form-check-label" for="radio">单选按钮</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[boxtype]" id="checkbox" value="checkbox" <?php if(output($setting,'boxtype')=='checkbox') echo 'checked';?> onclick="$('#setcols').show();$('#setsize').hide();"/>
                <label class="form-check-label" for="checkbox">复选框</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[boxtype]" id="select" value="select" <?php if(output($setting,'boxtype')=='select') echo 'checked';?> onclick="$('#setcols').show();$('#setsize').hide();"/>
                <label class="form-check-label" for="select">下拉框</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[boxtype]" id="multiple" value="multiple" <?php if(output($setting,'boxtype')=='multiple') echo 'checked';?> onclick="$('#setcols').show();$('#setsize').hide();"/>
                <label class="form-check-label" for="multiple">多选列表框</label>
            </div>
        </td>
    </tr>
    <tr>
        <td>字段类型</td>
        <td class="d-flex col-3 pe-3">
            <select name="setting[fieldtype]" onchange="fieldtype_setting(this.value);" class="form-select">
                <option value="varchar" <?php if(output($setting,'fieldtype')=='varchar') echo 'selected';?>>字符 VARCHAR</option>
                <option value="tinyint" <?php if(output($setting,'fieldtype')=='tinyint') echo 'selected';?>>整数 TINYINT(3)</option>
                <option value="smallint" <?php if(output($setting,'fieldtype')=='smallint') echo 'selected';?>>整数 SMALLINT(5)</option>
                <option value="mediumint" <?php if(output($setting,'fieldtype')=='mediumint') echo 'selected';?>>整数 MEDIUMINT(8)</option>
                <option value="int" <?php if(output($setting,'fieldtype')=='int') echo 'selected';?>>整数 INT(10)</option>
            </select> <span id="minnumber" style="display:none"><input type="radio" name="setting[minnumber]" value="1" <?php if(output($setting,'minnumber')==1) echo 'checked';?>/> <font color='red'>正整数</font> <input type="radio" name="setting[minnumber]" value="-1" <?php if(output($setting,'minnumber')==-1) echo 'checked';?>/> 整数</span>
        </td>
    </tr>
    <tr>
        <td>默认值</td>
        <td class="d-flex col-3 pe-3"><input type="text" name="setting[defaultvalue]" size="40" class="input-text form-control" value="<?php echo output($setting,'defaultvalue');?>"></td>
    </tr>
    <tr>
        <td>输出格式</td>
        <td class="d-flex pe-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[outputtype]" id="outputtype1" value="1" <?php if(output($setting,'outputtype')) echo 'checked';?>>
                <label class="form-check-label" for="outputtype1">输出选项值</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[outputtype]" id="outputtype0" value="0" <?php if(output($setting,'outputtype')) echo 'checked';?>>
                <label class="form-check-label" for="outputtype0">输出选项名称</label>
            </div>
        </td>
    </tr>
</table>
<script language="JavaScript">
    function fieldtype_setting(obj) {
        if(obj!='varchar') {
            $('#minnumber').css('display','');
        } else {
            $('#minnumber').css('display','none');
        }
    }
</script>