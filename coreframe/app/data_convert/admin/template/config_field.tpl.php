<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>

<section class="wrapper">
<!-- page start-->
<div class="row">
    <div class="col-lg-12">


        <section class="panel">
            <?php echo $this->menu($GLOBALS['_menuid']);?>

            <div class="panel-body" id="panel-bodys">
				<form name="form" method="post" action="">
                <table class="table table-striped table-advance table-hover">
                    <thead>
                    <tr>
                        <th class="tablehead">选择</th>
                        <th class="tablehead">表名</th>
                        <th class="tablehead">字段名</th>
                        <th class="tablehead">字段类型</th>
                        <th class="tablehead">原表字段</th>
                        <th class="tablehead">默认值</th>
                        <th class="tablehead">处理函数</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($to_arr AS $arrs) {
						$field = $arrs['field'];
						$tablename = $arrs['tablename'];

						$r = $this->db->get_one('data_convert_fields', array('dcid' => $dcid,'to_field'=>$field,'to_table'=>$tablename));
                        ?>
                        <tr>
                               <!---排序--->
                            <td><input type="checkbox" name="fields[]" value="<?php echo $tablename.'.'.$field;?>" <?php if($r) echo 'checked';?>></td>
                            <td><?php echo $tablename;?></td>
                            <td><?php echo $field;?></td>
                            <td><?php echo $arrs['field_type'];?></td>
							<td>
								<select name="from_arr_<?php echo $tablename;?>[<?php echo $field;?>]">
									<option value=""> - </option>
								<?php
								foreach($from_arr as $arr) {
									$selected = '';
									if($arr['tablename'].$arr['field']==$r['from_table'].$r['from_field']) $selected = 'selected';
									$to_field = $arr['field'];
									$va = $arr['tablename'].' 表，字段名：【'.$arr['field'];
									$va .= '】 字段类型：'.$arr['field_type'];
									echo '<option value="'.$arr['tablename'].'.'.$arr['field'].'" '.$selected.'>'.$va.'</option>';
								}
								?>
								</select>
							</td>
							<td><textarea name="default_value_<?php echo $tablename;?>[<?php echo $field;?>]" style="width:200px;height: 24px;" onfocus="$(this).css('height','80px');"><?php echo $r['default_value'];?></textarea></td>
							<td><input name="fun_<?php echo $tablename;?>[<?php echo $field;?>]" value="<?php echo $r['fun'];?>"></td>

                        </tr>
                    <?php
                    }
                    ?>

                    </tbody>
                </table>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div> <button type="submit" name="submit" class="btn btn-primary btn-sm">提交</button>
                            </div>

                        </div>
                    </div>
                </div>
				</form>
            </div>
			<table class="table table-bordered">
				<thead>
				<tr>
					<th>序号</th>
					<th>函数名</th>
					<th>说明</th>
					<th>其它例子</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td >1</td>
					<td >strlength~255</td>
					<td>字符串截取，过滤所有的html标签，得到的结果然后，保留255个字符</td>
					<td >strlength~80</td>
				</tr>
				<tr>
					<td >2</td>
					<td >strtotime</td>
					<td>时间格式化为时间戳(Unix timestamp)：例如，2017/9/20 17:33:35 格式化后为：1505900015</td>
					<td></td>
				</tr>
				<tr>
					<td >3</td>
					<td >get_index</td>
					<td>在有从表的情况，从表对应关系id用该函数获取，默认值必须为空</td>
					<td></td>
				</tr>
				<tr>
					<td >4</td>
					<td>date~Y/m/d</td>
					<td>时间戳转化为指定格式，如：1505900015 ，转化为：2017/9/20</td>
					<td>date~Y-m-d H:i:s</td>
				</tr>
				<tr>
					<td >5</td>
					<td>wuzhicms_password~ksu9s2</td>
					<td>转化为五指CMS用户密码，需要原加密方法为md5，没有截断和添加任何随机值，其中～之后的参数需要指定，手动任意6位字母，数字组合即可，不需要记住，然后需要将factor 字段设置为这个值。</td>
					<td>wuzhicms_password~Js3iU</td>
				</tr>
				<tr>
					<td >6</td>
					<td>hz2pinyin</td>
					<td>汉子转化为拼音</td>
					<td></td>
				</tr>
				<tr>
					<td >7</td>
					<td>first_letter</td>
					<td>汉子或者字母或数字，第一个字符，例如：新闻，x ;例如：9百，9 </td>
					<td></td>
				</tr>
				</tbody>
			</table>
        </section>

    </div>

</div>

<!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>