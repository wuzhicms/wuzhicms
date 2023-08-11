<table cellpadding="2" cellspacing="1" width="100%" class="table table-striped table-advance">
	<tr> 
      <td width="100">表单</td>
      <td class="col-3 d-inline-block"><textarea name="setting[formtext]" rows="2" cols="20" id="options" class="form-control"><?php echo htmlentities(output($setting,'formtext'));?></textarea>
          <a href="https://www.wuzhicms.com/doc/field-chaojiziduan.html" class="d-block pt-2" target="_blank"><i class="icon-help"></i> 打开帮助页面</a>
	  </td>
    </tr>
	<tr> 
      <td>字段类型</td>
      <td class="d-flex col-3">
	  <select name="setting[fieldtype]" class="form-select" onchange="fieldtype_setting(this.value);">
	  <option value="varchar" <?php if(output($setting,'fieldtype')=='varchar') echo "selected";?>>字符 VARCHAR</option>
	  <option value="tinyint" <?php if(output($setting,'fieldtype')=='tinyint') echo "selected";?>>整数 TINYINT(3)</option>
	  <option value="smallint" <?php if(output($setting,'fieldtype')=='smallint') echo "selected";?>>整数 SMALLINT(5) </option>
	  <option value="mediumint" <?php if(output($setting,'fieldtype')=='mediumint') echo "selected";?>>整数 MEDIUMINT(8)</option>
	  <option value="int" <?php if(output($setting,'fieldtype')=='int') echo "selected";?>>整数 INT(10)</option>
	  </select> <span id="minnumber" style="display:none"><input type="radio" name="setting[minnumber]" value="1" checked/> <font color='red'>正整数</font> <input type="radio" name="setting[minnumber]" value="-1" /> 整数</span>
	  </td>
    </tr>
</table>