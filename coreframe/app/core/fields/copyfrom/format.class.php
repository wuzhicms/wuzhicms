<?php exit();?>
    private function copyfrom($field, $value) {
        if(is_numeric($value)) {
            $r = $this->db->get_one('copyfrom',array('fromid'=>$value));
            if($r['logo']) {
                return '<a href="'.$r['url'].'" target="_blank"><img src="'.$r['logo'].'"></a>';
            } else {
                return '<a href="'.$r['url'].'" target="_blank">'.$r['name'].'</a>';
            }

        } elseif(is_string($value)) {
            if(strpos($value,'|')===false) {
                return $value;
            } else {
                $values = explode('|',$value);
                $values[1] = 'http://'.ltrim($values[1],'http://');
                return '<a href="'.$values[1].'" target="_blank">'.$values[0]."</a>";
            }
            return $value;
        }
    }
