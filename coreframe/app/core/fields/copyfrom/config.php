<?php
return array(
	'fieldname'=>'来源',//字段别名
	'display'=>0,//是否在字段类型中隐藏
	'unique_fields'=>1,//允许添加但必须唯一的字段
	'allow_forbidden'=>1,//是否允许被禁用
	'allow_delete'=>0,//是否允许被删除
	'field_type'=> 'varchar', //字段数据库类型
	'allow_addto_master'=> 0, //是否允许添加到主表
	'allow_index'=> 0, //是否允许建立索引
	'minlength'=> 0, //字符长度默认最小值
	'maxlength'=> '', //字符长度默认最大值
	'allow_fulltext'=> 0, //是否有意义添加到全站搜索当中
);
?>