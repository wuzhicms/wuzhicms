<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<section class="wrapper">
<div class="row">
<div class="col-lg-12">
<section class="panel">
    <?php echo $this->menu($GLOBALS['_menuid']);?>

    <div class="panel-body">
        <form class="form-horizontal tasi-form" method="post" action="">
			<div class="form-group">
				<label class="col-sm-2 col-xs-4 control-label">配置名称</label>
				<div class="col-lg-3 col-sm-4 col-xs-4 input-group">
					<input type="text" class="form-control" name="form[title]" datatype="*2-60" errormsg="配置名称填写错误" value="文章数据导入"></div>
			</div>
			<div class="form-group">
				<table class="table table-striped table-advance">
					<thead>
					<tr>
						<th class="tablehead" colspan="2">数据来源账号配置</th>
						<th class="tablehead" style="background-color: #e8e6e4;"></th>
						<th class="tablehead" colspan="2">入库账号配置</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>数据库地址</td>
						<td><input type="text" class="form-control" name="form[dbhost]" datatype="*2-60" errormsg="数据库地址错误" value="<?php echo $dbconfig['dbhost'];?>"></td>
						<td style="background-color: #e8e6e4;"> </td>
						<td>数据库地址</td>
						<td><input type="text" class="form-control" name="form[dbhost]" datatype="*2-60" errormsg="数据库地址错误" value="<?php echo $dbconfig['dbhost'];?>"></td>

					</tr>
					<tr>
						<td>数据库用户名</td>
						<td>
							<input type="text" class="form-control" name="form[username]" datatype="*2-60" errormsg="数据库用户名错误" value="<?php echo $dbconfig['username'];?>">
						</td>
						<td style="background-color: #e8e6e4;"> </td>
						<td>数据库用户名</td>
						<td>
							<input type="text" class="form-control" name="form[username]" datatype="*2-60" errormsg="数据库用户名错误" value="<?php echo $dbconfig['username'];?>">
						</td>

					</tr>
					<tr>
						<td>数据库密码</td>
						<td>
							<input type="text" class="form-control" name="form[password]" datatype="*2-60" errormsg="数据库密码">
						</td>
						<td style="background-color: #e8e6e4;"> </td>
						<td>数据库密码</td>
						<td>
							<input type="text" class="form-control" name="form[password]" datatype="*2-60" errormsg="数据库密码">
						</td>

					</tr>
					<tr>
						<td>数据库名</td>
						<td>
							<input type="text" class="form-control" name="form[dbname]" datatype="*2-60" errormsg="数据库名错误" value="<?php echo $dbconfig['dbname'];?>">
						</td>
						<td style="background-color: #e8e6e4;"> </td>
						<td>数据库名</td>
						<td>
							<input type="text" class="form-control" name="form[dbname]" datatype="*2-60" errormsg="数据库名错误" value="<?php echo $dbconfig['dbname'];?>">
						</td>

					</tr>
					<tr>
						<td>查询表1（from_table）</td>
						<td>
							<input type="text" class="form-control" name="form[dbname]" datatype="*2-60" errormsg="数据库名错误" value="<?php echo $dbconfig['dbname'];?>">
						</td>
						<td style="background-color: #e8e6e4;"> </td>
						<td>插入表1（to_table）</td>
						<td>
							<input type="text" class="form-control" name="form[dbname]" datatype="*2-60" errormsg="数据库名错误" value="<?php echo $dbconfig['dbname'];?>">
						</td>

					</tr>
					<tr>
						<td>查询表2（from_table2）</td>
						<td>
							<input type="text" class="form-control" name="form[dbname]" datatype="*2-60" errormsg="数据库名错误" value="<?php echo $dbconfig['dbname'];?>">
						</td>
						<td style="background-color: #e8e6e4;"> </td>
						<td>插入表2（to_table2）</td>
						<td>
							<input type="text" class="form-control" name="form[dbname]" datatype="*2-60" errormsg="数据库名错误" value="<?php echo $dbconfig['dbname'];?>">
						</td>

					</tr>
					<tr>
						<td>Mysql查询语句</td>
						<td>
							<input type="text" class="form-control" name="form[dbname]" datatype="*2-60" errormsg="数据库名错误" value="<?php echo $dbconfig['dbname'];?>">
						</td>
						<td style="background-color: #e8e6e4;"> </td>
						<td></td>
						<td>

						</td>

					</tr>
					<tr>
						<td colspan="2">执行SQL（插入单条数据后调用）</td>

						<td style="background-color: #e8e6e4;"> </td>
						<td colspan="2">执行SQL （插入单条数据后调用）</td>


					</tr>
					<tr>
						<td colspan="2">
							<div class="col-lg-12 col-sm-12 col-xs-12">
								<textarea name="form[remark]" class="form-control" cols="60" rows="3" placeholder="仅操作 [数据来源库]，多条SQL用分号隔开"></textarea>                </div>
						</td>
						<td style="background-color: #e8e6e4;"> </td>
						<td colspan="2">
							<div class="col-lg-12 col-sm-12 col-xs-12">
								<textarea name="form[remark]" class="form-control" cols="60" rows="3" placeholder="仅操作 [入库数据库]，多条SQL用分号隔开"></textarea>                </div>
						</td>
					</tr>
					</tbody>
				</table>
			</div>

            <div class="form-group">
                <label class="col-sm-2 col-xs-4 control-label"></label>
                <div class="col-lg-3 col-sm-4 col-xs-4 input-group">
                    <input class="btn btn-info col-sm-12 col-xs-12" type="submit" name="submit" value="提交">
                </div>
            </div>
        </form>
    </div>
</section>
</div>
</div>
<!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<script type="text/javascript">
    $(function(){
        $(".form-horizontal").Validform({
            tiptype:3
        });
    })

</script>

