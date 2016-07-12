<?php exit();?>
    function box($field, $value) {
        extract($this->fields[$field]['setting']);
        if($outputtype) {
            return $value;
        } else {
            $options = explode("\n",$options);
            foreach($options as $_k) {
                $v = explode("|",$_k);
                $k = trim($v[1]);
                $option[$k] = $v[0];
            }
            $string = '';
            switch($boxtype) {
                case 'radio':
                    $string = $option[$value];
                    break;

                case 'checkbox':
                    $value_arr = explode(',',$value);
                    foreach($value_arr as $_v) {
                        if($_v) $string .= $option[$_v].' 、';
                    }
                    break;

                case 'select':
                    $string = $option[$value];
                    break;

                case 'multiple':
                    $value_arr = explode(',',$value);
                    foreach($value_arr as $_v) {
                        if($_v) $string .= $option[$_v].' 、';
                    }
                    break;
            }
            return $string;
        }
    }
