<?php exit();?>
	private function relation($field, $value) {
        if(empty($value)) return '';
        $data = explode('~wuzhicms~', $value);
        foreach ($data as $v) {
            if(trim($v)=='') continue;
            $v = sql_replace($v);
            $d2 = explode('~wz~', $v);
            $formdata = array();
            $formdata['id'] = $this->id;
            $formdata['cid'] = $this->formdata['cid'];
            $formdata['title'] = $d2[0];
            $formdata['url'] = $d2[1];
            $formdata['addtime'] = SYS_TIME;
            $this->db->insert('content_relation',$formdata);
        }
	}
