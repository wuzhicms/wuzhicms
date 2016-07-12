<?php
/**
 * 数据更新类，数据插入后，进行后续更新
 */
class form_update {
    var $modelid;
    var $fields;
    var $formdata;
    var $extdata;//扩展数据，用于额外的参数传递，赋值方法：$form_add->extdata['mykey'] = 'data'

    function __construct($modelid) {
        $this->db = load_class('db');
        $this->tablepre = $this->db->tablepre;
        $this->modelid = $modelid;
        $this->fields = get_cache('field_'.$modelid,'model');
        $this->extdata = '';
        $this->hook = load_class('hook');
    }
	function execute($formdata) {
        if(!isset($formdata['master_data'])) return '';
        $datas = $formdata['master_data'];
        if(isset($formdata['attr_data'])) $datas = array_merge($datas,$formdata['attr_data']);
        $this->hook->run_hook('form_update',$datas,array('modelid'=>$this->modelid));

        $info = array();
        $this->formdata = $datas;
        $this->id = $datas['id'];
		$this->cid = $datas['cid'];//tuzwu 栏目id
        if($this->modelid==1001) {
            $datas['pics'] = 1;
        }
		foreach($datas as $field=>$value) {
			if(!isset($this->fields[$field])) continue;
			$func = $this->fields[$field]['formtype'];
			$info[$field] = method_exists($this, $func) ? $this->$func($field, $value) : $value;
		}
	}
}exit();?>