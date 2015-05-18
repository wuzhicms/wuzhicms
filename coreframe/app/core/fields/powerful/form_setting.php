<table cellpadding="2" cellspacing="1" width="100%" class="table table-striped table-advance">
	<tr> 
      <td width="100">表单</td>
      <td><textarea name="setting[formtext]" rows="2" cols="20" id="options" style="height:100px;width:400px;"><?php echo output($setting,'formtext');?></textarea><BR>
          <a href="http://www.wuzhicms.com/help-powerful-field.html" target="_blank"><i class="icon-help"></i> 打开帮助页面</a>
	  </td>
    </tr>
	<tr> 
      <td>字段类型</td>
      <td>
	  <select name="setting[fieldtype]" class="form-control" onchange="javascript:fieldtype_setting(this.value);">
	  <option value="varchar" <?php if(output($setting,'fieldtype')=='varchar') echo "selected";?>>字符 VARCHAR</option>
	  <option value="tinyint" <?php if(output($setting,'fieldtype')=='tinyint') echo "selected";?>>整数 TINYINT(3)</option>
	  <option value="smallint" <?php if(output($setting,'fieldtype')=='smallint') echo "selected";?>>整数 SMALLINT(5)</option>
	  <option value="mediumint" <?php if(output($setting,'fieldtype')=='mediumint') echo "selected";?>>整数 MEDIUMINT(8)</option>
	  <option value="int" <?php if(output($setting,'fieldtype')=='int') echo "selected";?>>整数 INT(10)</option>
	  </select> <span id="minnumber" style="display:none"><input type="radio" name="setting[minnumber]" value="1" checked/> <font color='red'>正整数</font> <input type="radio" name="setting[minnumber]" value="-1" /> 整数</span>
	  </td>
    </tr>
</table>