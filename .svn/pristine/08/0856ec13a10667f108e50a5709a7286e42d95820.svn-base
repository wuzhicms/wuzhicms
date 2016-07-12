<?php exit();?>
	private function keyword($field, $value) {
        if($value=='') return '';
		$data = array();
        if(strpos($value,',')===false) {
		    $data = explode(' ', $value);
        } else {
            $data = explode(',', $value);
        }
        foreach ($data as $v) {
            $v = sql_replace($v);
            $v = str_replace(array('/','#','.'),'',$v);
			$tag_info = $this->db->get_one('tag',array('tag'=>$v),'tid');
            if ( empty($tag_info) ) 
			{
                $tid = $this->db->insert('tag',array('tag'=>$v,'addtime'=>SYS_TIME));
				$this->keyword_pro($v,$tid);
            }
			else 
			{
			    $tid = $tag_info['tid'];
            }
            $id = $this->id;
			$exists_where = array('tid'=>$tid, 'modelid'=>$this->modelid, 'cid'=>$this->cid, 'id'=>$id);
            if (!$this->db->get_one('tag_data',$exists_where)) 
			{
                $this->db->insert('tag_data',$exists_where);
				$this->db->update('tag',"`number`=(`number`+1)", array('tid'=>$tid));
            }
        }
	}

	private function keyword_pro($tag = '', $tid = '')
	{
		if(empty($tag) || empty($tid)) return false;
		$tag_info = $py = array();
		$pinyin = load_class('pinyin');
		$py = $pinyin->return_py($tag);
		$tag_info['pinyin'] = $py['pinyin'];
		$tag_info['letter'] = $py['letter'];

		$tag_class = load_class('tags','tags');
		$param = array(
			'pinyin'=>$tag_info['pinyin'],
			'letter'=>$tag_info['letter'],
			'urlencode_tag'=>$tag,
			'tagid'=>$tid,
			'page'=>1,
		);
		$tag_info['url'] = $tag_class->url_rule('show',$param);
		unset($param);
		$this->db->update( 'tag', $tag_info, array('tid'=>$tid));
		return true;
	}