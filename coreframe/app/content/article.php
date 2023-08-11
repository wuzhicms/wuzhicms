<?php
/*
 * @Author: 一根鱼骨棒
 * @Date: 2020-09-18 09:20:58
 * @LastEditTime: 2020-09-21 17:25:48
 * @LastEditors: 一根鱼骨棒
 * @Description: 
 * @FilePath: \3qjwe:\Code\work\wuzhi6\coreframe\app\content\article.php
 * @Software: VScode
 * @Copyright 2020 迷彩视界
 */

class article
{
    private $db;
    function __construct()
    {
        $this->db = load_class('db');
    }

    function getDataOfJson()
    {
        //接收json数据
        $jsonData = file_get_contents("php://input");
        $data = json_decode($jsonData, true);
        //处理视频数据入库
        if ( $data['video'] )
        {
            $str = '';
            $count = count($data['video']);
            $n = 1;
            foreach($data['video'] as $key=>$value) {
                if ($count == 1) {
                    $str .= $value;
                } else {
                    if ($n == $count) {
                        $str .= $value;
                    } else {
                        $str .= $value."\r\n";
                    }
                }
                $n++;
            }
            $data['video'] = $str;
        }

        //验证数据
        if (empty($data['cid']) || empty($data['modelid']) || empty($data['title'])) {
            $this->echoJson(400, 'Parameter exception', 'cid or modelid or title can`t be NULL');
        }

        require get_cache_path('content_add', 'model');
        $form_add = new form_add(intval($data['modelid']));
        $formdata = $form_add->execute($data);
        // 获取不到表名
        if ($data['master_table'] != NULL) {
            $formdata['master_table'] = $data['master_table'];
        } else {
            $formdata['master_table'] = 'content_share';
        }
        if ($data['attr_table'] != NULL) {
            $formdata['attr_table'] = $data['attr_table'];
        } else {
            $formdata['attr_table'] = 'news_data';
        }
        // 判断重复
        $title=$data['title'];
        $addtime=$data['addtime'] - 86400*30;
        $where="AND `addtime`>'$addtime' AND `status`=9";
        $r = $this->db->get_one($formdata['master_table'],"`title`='$title' $where");
        if($r) {
            $this->echoJson(402, 'Duplicate Content', $r["title"]);
            exit;
        }
        // print_r($formdata);
        $formdata['master_data']['addtime'] = $formdata['master_data']['updatetime'] = $data['addtime'];

        //如果是共享模型，那么需要在将字段modelid增加到数据库
        if ($formdata['master_table'] == 'content_share') {
            $formdata['master_data']['modelid'] = $data['modelid'];
        }
        $formdata['master_data']['status'] = isset($data['status']) ? intval($data['status']) : 9;
        //如果 route为 0 默认，1，加密，2外链 ，3，自定义 例如：wuzhicms-diy-url-example 用户，不能不需要自己写后缀。程序自动补全。
        $formdata['master_data']['route'] = 0;
        $pinyin = load_class('pinyin');
        $title = trim($data['title']);
        $py = $pinyin->return_py($title);
        $formdata['master_data']['initial'] = strtolower($py['pinyin']);
        $id = $this->db->insert($formdata['master_table'], $formdata['master_data']);

        $cate_config = get_cache('category_' . $data['cid'], 'content');
        if ($cate_config['type'] == 1) {
            $urls['url'] = $cate_config['url'];
        } elseif ($formdata['master_data']['route'] > 1) { //外部链接
            $urls['url'] = remove_xss($data['url']);
        } else {
            //生成url
            $urlclass = load_class('url', 'content', $cate_config);
            $categorys = get_cache('category', 'content');
            $urlclass->set_category($cate_config);
            $urlclass->set_categorys($categorys);
            $route_config = array('id' => $id, 'cid' => $data['cid'], 'addtime' => $data['addtime'], 'page' => 1);
            $route_config = array_merge($route_config, $formdata['master_data']);
            $urls = $urlclass->showurl($route_config);
        }
        $this->db->update($formdata['master_table'], array('url' => $urls['url']), array('id' => $id));

        if (!empty($formdata['attr_table'])) {
            $formdata['attr_data']['id'] = $id;
            // print_r($formdata['attr_data']);exit;
            $this->db->insert($formdata['attr_table'], $formdata['attr_data']);
        }
        $this->echoJson(200, '导入成功', array('id' => $id));
    }

    function echoJson($code, $message, $data)
    {
        echo json_encode(array('code' => $code, 'message' => $message, 'data' => $data));
        exit;
    }
}
