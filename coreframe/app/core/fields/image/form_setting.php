<table cellpadding="2" cellspacing="1" width="100%" class="table table-striped table-advance table-hover">
    <tr>
        <td width="125">允许上传的文件类型</td>
        <td class="d-flex col-3 pe-3"><input type="text" name="setting[upload_allowext]" value="<?php echo output($setting,'upload_allowext');?>" size="40" class="input-text form-control"></td>
    </tr>
     <tr>
        <td>是否添加水印</td>
        <td class="d-flex col-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[is_water]" id="is_water1" value="1" <?php if(output($setting,'is_water')) echo 'checked';?>>
                <label class="form-check-label" for="is_water1">是</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[is_water]" id="is_water0" value="0" <?php if(!output($setting,'is_water')) echo 'checked';?>>
                <label class="form-check-label" for="is_water0">否</label>
            </div>
        </td>
    </tr>
    <tr>
        <td>会员上传显示模式</td>
        <td  class="d-flex col-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[member_show_type]" id="member_show_type1" value="1" <?php if(output($setting,'member_show_type')) echo 'checked';?>>
                <label class="form-check-label" for="member_show_type1">图片形式</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[member_show_type]" id="member_show_type0" value="0" <?php if(!output($setting,'member_show_type')) echo 'checked';?>>
                <label class="form-check-label" for="member_show_type0">input输入框形式</label>
            </div>
        </td>
    </tr>
    <tr>
        <td>是否允许原图显示</td>
        <td class="d-flex col-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[is_allow_show_img]" id="is_allow_show_img1" value="1" <?php if(output($setting,'is_allow_show_img')) echo 'checked';?>>
                <label class="form-check-label" for="is_allow_show_img1">是</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[is_allow_show_img]" id="is_allow_show_img0" value="0" <?php if(!output($setting,'is_allow_show_img')) echo 'checked';?>>
                <label class="form-check-label" for="is_allow_show_img0">否</label>
            </div>
        </td>
    </tr>
</table>