<?php exit();?>
	private function topic($config, $value) {
		$id = $this->id;
		$formdata = array();
		$formdata['importtime'] = $this->formdata['addtime'];
		$formdata['id'] = $id;
		$formdata['title'] = $this->formdata['title'];
		//$formdata['thumb'] = $this->formdata['thumb'];
		//$formdata['remark'] = $this->formdata['remark'];
		//$formdata['content'] = $this->formdata['content'];
		$formdata['status'] = $this->formdata['status'];
		$formdata['islink'] = 1;
		$this->db->update('topic_content', $formdata, array('tcid' => $value));
		return true;
	}
