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
<table cellpadding="2" cellspacing="1" width=100%" class="table table-striped table-advance">
    <tr>
        <td width="125">关联模型</td>
        <td class="d-flex col-3 pe-3"><input type="text" name="setting[modelid]" size="40" class="input-text form-control" value="<?php echo output($setting,'modelid');?>"></td>
    </tr>
    <tr>
        <td>关联分类</td>
        <td class="d-flex col-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[enable]" id="enable1" value="1" <?php if(output($setting,'enable')) echo 'checked';?>>
                <label class="form-check-label" for="enable1">是</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[enable]" id="enable0" value="0" <?php if(output($setting,'enable')) echo 'checked';?>>
                <label class="form-check-label" for="enable0">是</label>
            </div>
        </td>
    </tr>
</table>
<script LANGUAGE="JavaScript">
    function fieldtype_setting(obj) {
        if(obj!='varchar') {
            $('#minnumber').css('display','');
        } else {
            $('#minnumber').css('display','none');
        }
    }
    //-->
</script>