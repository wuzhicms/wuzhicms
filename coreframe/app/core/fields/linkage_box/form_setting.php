<?php defined('IN_ADMIN') or exit('No permission resources.');?>
<table cellpadding="2" cellspacing="1" width="98%" class="table table-striped table-advance table-hover">
	<tr>
      <td>页面字段ID </td>
      <td><input type="text" name="setting[formfield]" value="<?php echo output($setting,'formfield');?>" size="40" class="input-text"></td>
    </tr>
    <tr>
        <td>帮助: </td>
        <td><a href="http://www.wuzhicms.com/item-34-33-1.html" target="_blank"><i class="icon-help"></i> 打开帮助页面</a></td>
    </tr>
</table>