<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
//默认值
if(V=='field_add') {
    $setting = array(
        'boxtype'=>'radio',
        'width'=>'100',
        'size'=>'10',
        'options'=>"选项1|1\r\n选项2|2",
        'defaultvalue'=>"1",
    );
}
?>
<table cellpadding="2" cellspacing="1" width=100%" class="table table-striped table-advance ">
    <tr>
        <td width="100">选项列表</td>
        <td><textarea name="setting[options]" rows="2" cols="20" id="options" style="height:100px;width:200px;"><?php echo output($setting,'options');?></textarea></td>
    </tr>
    <tr>
        <td>选项类型</td>
        <td>
            <input type="radio" name="setting[boxtype]" value="radio" <?php if(output($setting,'boxtype')=='radio') echo 'checked';?> onclick="$('#setcols').show();$('#setsize').hide();"/> 单选按钮
            <input type="radio" name="setting[boxtype]" value="checkbox" <?php if(output($setting,'boxtype')=='checkbox') echo 'checked';?> onclick="$('#setcols').show();$('setsize').hide();"/> 复选框
            <input type="radio" name="setting[boxtype]" value="select" <?php if(output($setting,'boxtype')=='select') echo 'checked';?> onclick="$('#setcols').hide();$('setsize').show();" /> 下拉框
            <input type="radio" name="setting[boxtype]" value="multiple" <?php if(output($setting,'boxtype')=='multiple') echo 'checked';?> onclick="$('#setcols').hide();$('setsize').show();" /> 多选列表框
        </td>
    </tr>
    <tr>
        <td>字段类型</td>
        <td>
            <select name="setting[fieldtype]" onchange="javascript:fieldtype_setting(this.value);">
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
        <td><input type="text" name="setting[defaultvalue]" size="40" class="input-text" value="<?php echo output($setting,'defaultvalue');?>"></td>
    </tr>
    <tr>
        <td>输出格式</td>
        <td>
            <input type="radio" name="setting[outputtype]" value="1" <?php if(output($setting,'outputtype')) echo 'checked';?> /> 输出选项值
            <input type="radio" name="setting[outputtype]" value="0" <?php if(!output($setting,'outputtype')) echo 'checked';?> /> 输出选项名称
        </td>
    </tr>
</table>
<SCRIPT LANGUAGE="JavaScript">
    <!--
    function fieldtype_setting(obj) {
        if(obj!='varchar') {
            $('#minnumber').css('display','');
        } else {
            $('#minnumber').css('display','none');
        }
    }
    //-->
</SCRIPT>