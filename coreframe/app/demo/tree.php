<?php
class tree{
	function __construct() {
	}
	function index() {
		
		$list=array(
	       1 => array('id'=>'1','pid'=>0,'name'=>'一级栏目A'),
	       2 => array('id'=>'2','pid'=>0,'name'=>'一级栏目B'),
	       3 => array('id'=>'3','pid'=>1,'name'=>'二级栏目A'),
	       4 => array('id'=>'4','pid'=>1,'name'=>'二级栏目B'),
	       5 => array('id'=>'5','pid'=>2,'name'=>'二级栏目C'),
	       6 => array('id'=>'6','pid'=>3,'name'=>'三级栏目A'),
	       7 => array('id'=>'7','pid'=>3,'name'=>'三级栏目B')
	     );
 
		$tree = load_class('tree','core',$list);
		
		$html="<select name='cat'>";
		 
		//格式字符串
		$str="<option value=\$id \$selected>\$spacer\$name</option>";
		 
		//返回树
		$html.=$tree->create(0,$str);
		 
		$html.="</select>";
		 
		echo($html);
		
	}

}
