<?php
/**
 * 内容输出格式化
 */
class form_format {
    var $modelid;
    var $fields;
    var $formdata;
    var $extdata;//扩展数据，用于额外的参数传递，赋值方法：$form_add->extdata['mykey'] = 'data'
    var $id;//内容id

	function __construct($modelid) {
        $this->db = load_class('db');
        $this->tablepre = $this->db->tablepre;
        $this->modelid = $modelid;
        $this->fields = get_cache('field_'.$modelid,'model');
        $this->extdata = '';
        //TODO 初始化勾子，在程序提交前处理
    }
	function execute($formdata) {
        $this->formdata = $formdata;
		$this->id = $formdata['id'];
		$info = array();
        foreach($formdata as $field=>$value) {
            $field_config = $this->fields[$field];
            $func = $field_config['formtype'];
            $value = $formdata[$field];
            $result = method_exists($this, $func) ? $this->$func($field, $formdata[$field]) : $formdata[$field];
            if($result !== false) {
                $info[$field]['name'] = isset($field_config['name']) ? $field_config['name'] : $field;
                $info[$field]['data'] = $result;
            }
        }

		return $info;
	}
    function set_config($modelid) {
        $this->modelid = $modelid;
        $this->fields = get_cache('field_'.$modelid,'model');
    }
}exit();?>