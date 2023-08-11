<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<?php
//默认值
if(V=='field_add') {
    $setting = array(
        'toolbar'=>'basic',
    );
}
?>
<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-advance table-hover">
    <tr>
        <td width="125">编辑器类型：</td>
        <td >
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[editor_type]" id="ckeditor" value="ckeditor" <?php if(output($setting,'editor_type')=='ckeditor') echo 'checked';?>>
                <label class="form-check-label" for="ckeditor"> Ckeditor（推荐）</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[editor_type]" id="ueditor" value="ueditor" <?php if(output($setting,'editor_type')=='ueditor') echo 'checked';?>>
                <label class="form-check-label" for="ueditor"> Ueditor（百度编辑器）</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[editor_type]" id="ewebeditor" value="ewebeditor" <?php if(output($setting,'editor_type')=='ewebeditor') echo 'checked';?> disabled>
                <label class="form-check-label" for="ewebeditor"> Ewebeditor(授权用户可选)</label>
            </div>
        </td>
    </tr>
    <tr>
        <td>编辑器样式：</td>
        <td>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[toolbar]" id="basic" value="basic" <?php if(output($setting,'toolbar')=='basic') echo 'checked';?>>
                <label class="form-check-label" for="basic">简洁型</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[toolbar]" id="normal" value="normal" <?php if(output($setting,'toolbar')=='normal') echo 'checked';?>>
                <label class="form-check-label" for="normal">标准型</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[toolbar]" id="full" value="full" <?php if(output($setting,'toolbar')=='full') echo 'checked';?>>
                <label class="form-check-label" for="full">全功能</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[toolbar]" id="textarea" value="textarea" <?php if(output($setting,'toolbar')=='textarea') echo 'checked';?>>
                <label class="form-check-label" for="textarea">文本框</label>
            </div>
        </td>
    </tr>
    <tr>
        <td>默认值：</td>
        <td><textarea name="setting[defaultvalue]" rows="2" cols="20" id="defaultvalue" class="form-control w-50"><?php echo output($setting,'defaultvalue');?></textarea></td>
    </tr>
    <tr>
        <td>是否保存远程图片：</td>
        <td>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[enablesaveimage]" id="enablesaveimage1" value="1" <?php if(output($setting,'enablesaveimage')==1) echo 'checked';?>>
                <label class="form-check-label" for="enablesaveimage1">是</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[enablesaveimage]" id="enablesaveimage0" value="0" <?php if(output($setting,'enablesaveimage')==0) echo 'checked';?>>
                <label class="form-check-label" for="enablesaveimage0">否</label>
            </div>
           </td>
    </tr>
    <tr>
        <td>是否添加水印：</td>
        <td>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[watermark_enable]" id="watermark_enable1" value="1" <?php if(output($setting,'watermark_enable')==1) echo 'checked';?>>
                <label class="form-check-label" for="watermark_enable1">是</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[watermark_enable]" id="watermark_enable2" value="2" <?php if(output($setting,'watermark_enable')==2) echo 'checked';?>>
                <label class="form-check-label" for="watermark_enable2">否</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[watermark_enable]" id="watermark_enable0" value="0" <?php if(output($setting,'watermark_enable')==0) echo 'checked';?>>
                <label class="form-check-label" for="watermark_enable0">与总开关保持一致</label>
            </div>
        </td>
    </tr>
</table>