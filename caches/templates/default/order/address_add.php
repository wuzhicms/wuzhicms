<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head lang="zh-CN">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset=utf-8"<?php echo CHARSET;?>">
    <title>地址添加</title>
    <script src="<?php echo R;?>js/jquery.min.js"></script>
    <script src="<?php echo R;?>js/wuzhicms.js"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo R;?>css/style_address.css">
</head>

<body>
<div class="xiugaiadd_wz">
    <form action="" method="post">
    <table width="100%" border="0" cellspacing="5" cellpadding="5">
        <tr>
            <td colspan="2" style="line-height:32px;"><span class="color_777"> 电话号码、手机选项一项其余为必填项</span></td>
        </tr>
        <tr>
            <td width="120" align="right">所在地区<span class="color_warning">*</span></td>
            <td width="675"><?php echo linkage(1,'myfieldid1',0);?></td>
        </tr>
        <tr>
            <td align="right">详细地址<span class="color_warning">*</span></td>
            <td><textarea name="address" cols="60" rows="3" class="form-control" placeholder="不需要重复填写省市区，必须大于5个字符，小于120个字符"></textarea></td>
        </tr>
        <tr>
            <td align="right">邮政编码<em class="color_warning">*</em></td>
            <td>
                <input type="text" name="zipcode" id="zipcode" size="36"></td>
        </tr>
        <tr>
            <td align="right">收货人姓名<em class="color_warning">*</em></td>
            <td><input type="text" name="addressee" id="addressee" size="36" placeholder="长度不超过20个字符"></td>
        </tr>
        <tr>
            <td align="right">手机号码</td>
            <td><input type="text" name="mobile" id="mobile" size="36" placeholder="电话号码、手机号码必须填一项"></td>
        </tr>
        <tr>
            <td align="right">电话号码</td>
            <td><input name="tel1" type="text" id="tel1" size="6" placeholder="区号">
                -
                <input name="tel2" type="text" id="tel2" size="22" placeholder="电话号码">
                -
                <input name="tel3" type="text" id="tel3" size="6" placeholder="分机号"></td>
        </tr>
        <tr>
            <td align="right">&nbsp;</td>
            <td><input type="checkbox" name="isdefault" id="isdefault" value="1">
                <label>设为默认收货地址</label></td>
        </tr>
        <tr>
            <td align="right">&nbsp;</td>
            <td><input type="submit" name="submit" class="addbtn" id="button" value="保存"></td>
        </tr>
    </table>
    </form>
</div>

</body>
</html>
