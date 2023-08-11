<table cellpadding="2" cellspacing="1" width="100%" class="table table-striped table-advance table-hover">
	<tr> 
      <td width="125">允许上传的文件类型</td>
      <td class="d-flex col-3 pe-3"><input type="text" name="setting[upload_allowext]" value="<?php echo output($setting,'upload_allowext');?>" size="40" class="input-text form-control"></td>
    </tr>
	<tr> 
      <td>文件打开方式</td>
      <td class="d-flex col-5 pe-3">
          <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="setting[linktype]" id="linktype1" value="1" <?php if(output($setting,'linktype')) echo 'checked';?>>
              <label class="form-check-label" for="linktype1">当前页面打开</label>
          </div>
          <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="setting[linktype]" id="linktype0" value="0" <?php if(output($setting,'linktype')) echo 'checked';?>>
              <label class="form-check-label" for="linktype0">新窗口打开（支持登录验证）</label>
          </div>
      </td>
    </tr>
    <tr>
        <td>文件下载方式</td>
        <td class="d-flex col-5 pe-3">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[downloadtype]" id="downloadtype1" value="1" <?php if(output($setting,'downloadtype')) echo 'checked';?>>
                <label class="form-check-label" for="downloadtype1">链接到真实地址</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="setting[downloadtype]" id="downloadtype0" value="0" <?php if(output($setting,'downloadtype')) echo 'checked';?>>
                <label class="form-check-label" for="downloadtype0">通过PHP读取</label>
            </div>
        </td>
    </tr>
</table>