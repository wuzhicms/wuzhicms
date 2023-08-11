<?php exit();?>
private function downfiles($config, $value){
if (!empty($value)) $value = string2array($value);
extract($config, EXTR_SKIP);
$str = '<script src="/res/libs/jquery-ui/jquery-ui.min.js"></script>';
$str .= '<script>
    $(function() {
        $( "#'.$field.'_ul" ).sortable();
        $( "#'.$field.'_ul" ).disableSelection();
    });
</script>';
$default_multiple = '';
if ($value && is_array($value)) {
foreach ($value AS $k => $v) {
$default_multiple .= '<li id="file_node_' . $k . '" class="bg-white border border-1 input-group mb-2 p-3"><input type="text" name="form[' . $field . '][' . $k . '][name]" value="' . $v['name'] . '" class="form-control w-25" size="" placeholder="下载服务器名称"> <input name="form[' . $field . '][' . $k . '][url]" class="form-control w-50" placeholder="http://下载地址" value="' . $v['url'] . '"><a class="btn btn-danger btn-sm btn-xs" href="javascript:remove_file(' . $k . ');">移除</a></li>';
}
}
$str2 = '<div id="' . $field . '"><ul id="' . $field . '_ul">' . $default_multiple . '</ul></div>';
$ext_arr['htmldata'] = '<button type="button" class="btn btn-white" onclick="downfiles_add(\'' . $field . '\')">添加一行</button>';
return $str . '<div class="attaclist w-100">' . $str2 . $this->form->attachment($setting['upload_allowext'], 20, "form[$field]", $value, 'callback_downfile', 0,true,'', 0,0,false,'',0,$ext_arr) . '</div>';
}
