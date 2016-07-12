<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
//默认值
if(V=='field_add') {
    $setting = array(
        'modelid'=>"1",
        'cid'=>"1",
    );
}
?>
<table cellpadding="2" cellspacing="1" width=100%" class="table table-striped table-advance ">
    <tr>
        <td>关联模型</td>
        <td><input type="text" name="setting[modelid]" size="40" class="input-text" value="<?php echo output($setting,'modelid');?>"></td>
    </tr>
    <tr>
        <td>关联分类</td>
        <td><input type="radio" name="setting[enable]" value="1" <?php if(output($setting,'enable')) echo 'checked';?>> 是 <input type="radio" name="setting[enable]" value="0" <?php if(!output($setting,'enable')) echo 'checked';?>> 否</td>
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