<?php exit();?>
    private function downfile($field, $value) {
        if(empty($value)) return '';
        $setting = $this->fields[$field]['setting'];
        if($setting['linktype']) {
            if($setting['downloadtype']) {
                return $value;
            } else {
                return private_file($value);
            }
        } else {
            return WEBURL.'index.php?f=down&v=filedown&str='.urlencode(encode($setting['downloadtype'].$value));
        }
    }
