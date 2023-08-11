<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%" class="table table-striped table-advance table-hover">
	<tr>
      <td width="125">页面字段ID </td>
      <td class="d-flex col-3"><input type="text" name="setting[formfield]" value="<?php echo output($setting,'formfield');?>" size="40" class="input-text form-control"></td>
    </tr>
    <tr>
        <td>帮助: </td>
        <td class="d-flex col-3"><a href="http://www.wuzhicms.com/item-34-33-1.html" target="_blank"><i class="icon-help"></i> 打开帮助页面</a></td>
    </tr>
</table>