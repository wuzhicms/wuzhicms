<table cellpadding="2" cellspacing="1" width="100%" class="table table-striped table-advance table-hover">
	<tr> 
      <td width="150">默认值</td>
      <td class="d-flex col-3 pe-3"><input type="text" name="setting[defaultvalue]"  size="40" class="input-text form-control"></td>
    </tr>
	<tr> 
      <td>允许上传的图片类型</td>
      <td class="d-flex col-3 pe-3"><input type="text" name="setting[upload_allowext]" value="gif|jpg|jpeg|png|bmp" size="40" class="input-text form-control"></td>
    </tr>
	<tr> 
      <td>是否在图片上添加水印</td>
      <td class="d-flex col-3 pe-3">
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
      <td>是否从已上传中选择</td>
      <td class="d-flex col-3 pe-3">
          <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="setting[isselectimage]" id="isselectimage1" value="1" checked>
              <label class="form-check-label" for="isselectimage1">是</label>
          </div>
          <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="setting[isselectimage]" id="isselectimage0" value="0">
              <label class="form-check-label" for="isselectimage0">否</label>
          </div>
      </td>
    </tr>
	<tr> 
      <td>图像大小</td>
      <td class="d-flex col-4 pe-3">
          <div class="input-group pe-2">
              <span class="input-group-text">宽</span>
              <input type="text" class="form-control" name="setting[images_width]" value="" size="3" >
              <span class="input-group-text">px</span>
          </div>
          <div class="input-group ps-2">
              <span class="input-group-text">高</span>
              <input type="text" class="form-control" name="setting[images_height]" value="" size="3" >
              <span class="input-group-text">px</span>
          </div>
      </td>
    </tr>
</table>