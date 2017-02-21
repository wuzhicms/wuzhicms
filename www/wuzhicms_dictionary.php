<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
//http://dev.wuzhicms.com/wuzhicms_dictionary.php

$dbhost = "localhost";
$dbuser = "admin";
$dbpwd = "admin";
$dbname = "test7";
$title = "DICT";
$sql = <<<SQL
select distinct
a.TABLE_SCHEMA as '数据库' ,
a.TABLE_NAME as '表名',
a.TABLE_COMMENT as '表说明',
a.COLUMN_NAME as '字段名',
a.COLUMN_TYPE as '类型长度',
a.COLUMN_COMMENT as '字段说明',
IF(a.IS_NULLABLE='yes', '√', '✕')  as '允许空值',
case when a.COLUMN_DEFAULT='' then '""' when ISNULL(a.COLUMN_DEFAULT) then '' else a.COLUMN_DEFAULT end  as '默认值',
IF(a.EXTRA='auto_increment', '<span class="font-auto">√</span>', '✕')  as '自动递增'
-- ,IF(b.CONSTRAINT_NAME='PRIMARY', '√', '✕')  as '主键'
-- ,a.CHARACTER_SET_NAME as '字符集',
-- a.COLLATION_NAME as '排序规则'
-- ,c.CONSTRAINT_NAME  as '外键名',
-- c.REFERENCED_TABLE_NAME as '关联父表',
-- c.REFERENCED_COLUMN_NAME as '父表字段',
-- d. CONSTRAINT_NAME as '索引名称'
FROM
(
    SELECT
        T.TABLE_COMMENT,
        C.TABLE_SCHEMA,
        C.TABLE_NAME,
        C.COLUMN_NAME,
        C.COLUMN_TYPE,
        C.COLUMN_COMMENT,
        C.IS_NULLABLE,
        C.COLUMN_DEFAULT,
        C.EXTRA,
        C.CHARACTER_SET_NAME,
        C.COLLATION_NAME
    FROM
        information_schema.`COLUMNS` AS C
    JOIN information_schema.`TABLES` AS T ON C.TABLE_SCHEMA = T.TABLE_SCHEMA
    AND C.TABLE_NAME = T.TABLE_NAME
)
-- INFORMATION_SCHEMA.COLUMNS
as a
left join (select CONSTRAINT_NAME,TABLE_NAME table_name2,COLUMN_NAME col_name2 from INFORMATION_SCHEMA.KEY_COLUMN_USAGE where  CONSTRAINT_NAME='PRIMARY' and TABLE_SCHEMA = @dbname) as b
on a.TABLE_NAME=b.table_name2 and a.COLUMN_NAME=b.col_name2
left join (select CONSTRAINT_NAME,REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME,TABLE_NAME table_name3,COLUMN_NAME col_name3 from INFORMATION_SCHEMA.KEY_COLUMN_USAGE where REFERENCED_COLUMN_NAME!='' and TABLE_SCHEMA = @dbname) as c
on a.TABLE_NAME=c.table_name3 and a.COLUMN_NAME=c.col_name3
left join (select CONSTRAINT_NAME,REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME,TABLE_NAME table_name4,COLUMN_NAME col_name4 from INFORMATION_SCHEMA.KEY_COLUMN_USAGE where REFERENCED_COLUMN_NAME is null and CONSTRAINT_NAME!='PRIMARY' and TABLE_SCHEMA = @dbname) as d
on a.TABLE_NAME=d.table_name4 and a.COLUMN_NAME=d.col_name4
where a.TABLE_SCHEMA = "{$dbname}"
ORDER BY a.TABLE_NAME ASC;
SQL;
$dsn = "mysql:dbname=$dbname;charset=utf8;host=$dbhost";
try {
	$conn = new PDO($dsn, $dbuser, $dbpwd);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	die('Connection failed: ' . $e->getMessage());
}

$result = $conn->query($sql, PDO::FETCH_ASSOC);

if(!$result) {
	return "查询失败";
}
$dict = [];
foreach ($result as $row) {
	if (!isset($dict[$row['表名']])) {
		$dict[$row['表名']] = [];
	}
	$dict[$row['表名']][] = $row;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title?></title>
	<style>
		body { margin: 0; font:14px/20px "Microsoft YaHei", Verdana, Arial, sans-serif; color: #333; background: #f8f8f8;}
		h1, h2, pre { margin: 0; padding: 0;}
		h1 { font:bold 24px "Microsoft YaHei", Verdana, Arial; background:#8892BF; padding: 12px 5px; border-color: #4F5B93; border-bottom: 4px solid #669; box-shadow: 0 .25em .25em rgba(0,0,0,.1); color: #222;}
		h2 { font:normal 20px/22px "Microsoft YaHei", Georgia, Times, "Times New Roman", serif; padding: 5px 0 8px; margin: 20px 10px 0; border-bottom: 1px solid #ddd; cursor:pointer; color:#369;}
		p, dd { color: #555; }
		h2 u { font-size:20px;text-decoration:none;padding:10px; }
		pre {font: normal 15px "Fira Mono", "Source Code Pro", monospace, "Microsoft YaHei"; background-color: #fff;    box-shadow: inset 0 0 0 1px rgba(0,0,0,.15);
			border-radius: 0 0 2px 2px;padding: 15px; margin-top: 20px;}
		.form-control {
			display: block;
			width: 100%;
			height: 34px;
			padding: 6px 12px;
			font: normal 20px "Microsoft YaHei", Verdana, Arial;
			line-height: 1.42857143;
			color: #555;
			background-color: #fff;
			border: 1px solid #ccc;
			border-radius: 4px;
			-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
			box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
			-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
			-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
			transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		}
		.module-block { margin-bottom: 15px; }
		.dbdict-block { margin: 20px; }
		.dbdict-block table {border: 1px solid #c6ccd2;margin-bottom: 20px;table-layout: fixed;text-align: center;}
		.dbdict-block table th { background: #f3f4f5; color: #000; font-size: 14px; font-weight: 700; height: 29px; text-align: center;}
		.dbdict-block table th, .dbdict-block table td { border: 1px solid #e8eaec; padding: 0 10px; vertical-align: middle;}
		.dbdict-block table td { line-height: 20px; padding: 7px 5px;}
		.font-auto{color: #ff0000;}
	</style>
</head>
<body>
<div class="module-block">
	<h1><?php echo $title ?></h1>
	<div class="filter">
		<input id="keyword" class="form-control" value="" placeholder="filter" />
	</div>
	<?php foreach($dict as $tableName => $tableColumns): ?>
		<?php
		$tmp = $tableColumns[0];
		$tmp['表说明'] = $tmp['表说明'] ? "({$tmp['表说明']})" : "";
		$table_title = $tmp['表名'] . $tmp['表说明'];
		?>
		<div class="one_table">
			<h2 class="table_title" data-tname="<?php echo $tmp['表名']?>" data-tdesc="<?php echo $tmp['表说明']?>">
				<u>+</u><?php echo $table_title ?>
			</h2>
			<div class="dbdict-block" style="display:none">
				<!-- <pre style="white-space:pre-line"> -->
				<?php
				$tableContent = [];
				$tableContent[] = '<table width="100%" cellspacing="0" cellpadding="0" border="0">';
				foreach ($tableColumns as &$columns) {
					unset($columns['数据库']);
					unset($columns['表名']);
					unset($columns['表说明']);
				}
				unset($columns);
				// header
				$tableContent[] =  '<tr>';
				$jl = 1;
				foreach ($tableColumns[0] as $k => $_) {
					$wd = '';
					if($jl>3) {
						$wd = "style='width: 80px;';";
					}
					$tableContent[] = "<th $wd>$k</th>";
					$jl++;
				}
				$tableContent[] = '</tr>';
				// body
				foreach ($tableColumns as $columns) {
					$tableContent[] =  '<tr>';
					foreach ($columns as $v) {
						$tableContent[] =  "<td>$v</td>";
					}
					$tableContent[] =  '</tr>';
				}
				$tableContent[] =  '</table>';
				?>
				<?php echo implode($tableContent) ?>
				<!-- </pre> -->
			</div>
		</div>
	<?php endforeach;?>
</div>
</body>
<script>
	var $ = document.querySelectorAll.bind(document)
	Element.prototype.on = Element.prototype.addEventListener
	NodeList.prototype.on = function (event, fn) {
		[]["forEach"].call(this, function (el) {
			el.on(event, fn, false)
		})
		return this
	}
	window.addEventListener("load", function() {
		$(".table_title").on("click", function(e) {
			var elem = e.target
			while(elem.className !== "table_title") {
				elem = elem.parentElement
			}
			var block = elem.nextSibling,
				info = elem.getElementsByTagName('u')[0]
			while (block) {
				if ( block.nodeType == 1 && block.className.indexOf("dbdict-block") > -1 ) {
					break
				}
				block = block.nextSibling
			}
			if(block) {
				var isHidden = block.style.display == 'none'
				block.style.display = isHidden ? '' : 'none'
				info.innerHTML = isHidden ? '-'  : '+'
			}
		})
		var Table = (function() {
			var $all_table = [].slice.call($(".one_table"))
			return {
				show_all: function() {
					$all_table.forEach(function(el) {
						el.style.display = "block"
					})
					return this
				},
				hide_all: function() {
					$all_table.forEach(function(el) {
						el.style.display = "none"
					})
					return this
				},
				filter_table_name: function(target) {
					$all_table.forEach(function(el) {
						var el_title = el.childNodes[1]
						el.style.display = el_title.dataset.tname.includes(target) ? "block" : "none"
						// TODO highlight keywords
					})
					return this
				},
				toggle_fold_show: function() {
					$all_table.forEach(function(el) {
						if(el.style.display === "block") {
							var el_dbdict_block = el.childNodes[3]
							var stl = el_dbdict_block.style
							stl.display = (stl.display === "none" ? "block" : "none")
						}
					})
					return this
				},
				fold_all: function() {
					$all_table.forEach(function(el) {
						var el_dbdict_block = el.childNodes[3]
						el_dbdict_block.style.display = "none"
					})
					return this
				}
			}
		}())
		var $keyword = $("#keyword")[0]
		$keyword.on("input", function(e) {
			var val = $keyword.value.trim()
			if(val === "") {
				Table.show_all().fold_all()
			} else {
				Table.filter_table_name(val)
			}
		})
		// on enter
		$keyword.on("keydown", function(e) {
			if(e.keyCode == 13) {
				Table.toggle_fold_show()
			}
		})
	}, false)
</script>
</html>
