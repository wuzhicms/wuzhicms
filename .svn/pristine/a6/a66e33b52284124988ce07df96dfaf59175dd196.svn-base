<?php exit();?>
    private function relation($field, $value) {
        if(empty($value)) return '';
        $data = explode('~wuzhicms~', $value);
        $models = get_cache('model_content','model');
        $categorys = get_cache('category','content');
        foreach ($data as $v) {
            if(trim($v)=='') continue;
            $v = sql_replace($v);
            $d2 = explode('~wz~', $v);
            $formdata = array();
            $formdata['id'] = $this->id;
            $formdata['cid'] = $this->formdata['cid'];
            $formdata['title'] = $d2[0];
            $formdata['url'] = $d2[1];
            $formdata['origin_id'] = $d2[2];
            $formdata['origin_cid'] = $d2[3];
            $formdata['addtime'] = SYS_TIME;
            $modelid = $categorys[$formdata['cid']]['modelid'];
            $master_table = $models[$modelid]['master_table'];
            $r = $this->db->get_one($master_table, array('id' => $formdata['origin_id']));
            $formdata['thumb'] = $r['thumb'];
            $this->db->insert('content_relation',$formdata);
        }
    }
