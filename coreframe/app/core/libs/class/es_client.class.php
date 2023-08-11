<?php
// +----------------------------------------------------------------------
// | wuzhicms [ 五指互联网站内容管理系统 ]
// | Copyright (c) 2014-2015 http://www.wuzhicms.com All rights reserved.
// | Licensed ( http://www.wuzhicms.com/licenses/ )
// | Author: wangcanjia <phpip@qq.com>
// +----------------------------------------------------------------------
/**
 * Elasticsearch client
 */
require WWW_ROOT.'vendor/autoload.php';

use Elasticsearch\ClientBuilder;


class WUZHI_es_client {
   public $es_serverip = ['127.0.0.1'];
    //public $es_serverip = ['172.17.15.183'];
    public $index = 'web';
    public function __construct() {
        $this->client = ClientBuilder::create()->setHosts($this->es_serverip)->build();
    }

    /**
     * 分词
     *
    GET _analyze
    {
        "text":"中华人民共和国国歌在什么",
        "analyzer": "ik_smart"
    }
     * @param $text
     * @param int $max
     * @return array
     */
    public function analyze($text,$max = 5){
        if($text=='') return [];
        $params = [
            'body' => [
                'text' => $text,
                'analyzer'=>'ik_smart' //ik_max_word 精细  ik_smart 粗略
            ]
        ];

        $result = $this->client ->indices()->analyze($params);
        $keywords = [];
        $total = 0;
        foreach ($result['tokens'] as $r) {
            if($total>=$max) break;
            if($r['type']=='CN_WORD' || $r['type']=='ENGLISH') {
                $keywords[] = $r['token'];
                $total++;
            }
        }
        return $keywords;
    }

    public function createIndex() {
        $params = [
            'index' => $this->index,
            'body' => [
                'settings' => [
                    'number_of_shards' => 3,
                    'number_of_replicas' => 0
                ]
            ]
        ];
        $this->client->indices()->create($params);
    }
    /**
     * 创建字段map
     */
    public function createMap() {
        $params = [
            'index' => 'web',
            'body' => [
                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => [
                        'id' => [
                            'type' => 'integer'
                        ],
                        'modelid' => [
                            'type' => 'integer'
                        ],
                        'cid' => [
                            'type' => 'integer'
                        ],
                        'title' => [
                            'type' => 'text',
                            'analyzer' => 'ik_max_word'
                        ],
                        'catname' => [
                            'type' => 'text',
                            'analyzer' => 'ik_max_word'
                        ],
                        'remark' => [
                            'type' => 'text',
                            'analyzer' => 'ik_max_word'
                        ],
                        'thumb' => [
                            'type' => 'text',
                        ],
                        'addtime' => [
                            'type' => 'integer',
                        ],
                        'viewdate' => [
                            'type' => 'text'
                        ],
                        'url' => [
                            'type' => 'text',
                        ],
                        'data' => [
                            'type' => 'text',
                            'analyzer' => 'ik_smart'
                        ]
                    ]

            ]
        ];
        $this->client->indices()->putMapping($params);
    }

    /**
     * 添加内容到es
     * @param $data
     */
    public function add_content($data) {
        $params = [
            'index' => $this->index,
            'id' => $data['cid'].'-'.$data['id'],
            'body' => [
                'id' => $data['id'],
                'modelid' => $data['modelid'],
                'cid' => $data['cid'],
                'title' => $data['title'],
                'catname' => $data['catname'],
                'remark' => trim($data['remark']),
                'thumb' => $data['thumb'],
                'addtime' => $data['addtime'],
                'viewdate' => date('Y-m-d H:i:s',$data['addtime']),
                'url' => $data['url'],
                'data' => strip_tags(trim($data['content'])),
            ]
        ];
        $this->client->index($params);
    }

    /**
     * 删除索引内容
     *
     * @param $id
     * @param $cid
     */
    public function delete_content($id,$cid) {
        $params = [
            'index' => $this->index,
            'type' => $this->index,
            'id' => $cid.'-'.$id,
        ];
        $this->client->delete($params);
    }


    public function search($keyword,$page = 0,$pagesize = 10,$starttime = 0) {
        $query = [
            'query' => [
                'bool' => [
                    'must' => [
                        'multi_match' => [
                            'query' => $keyword,
                            'fields' => [
                                'title',
                                'data',
                                'catname'
                            ],
                        ]
                    ],
                    /*'filter'=>[
                        'range'=>[
                            'addtime'=>[
                                'gte'=>$starttime
                            ]
                        ]
                    ]*/
                ]

            ]
        ];
        if($starttime) $query['query']['bool']['filter']['range']['addtime']['gte'] = $starttime;
        $params = [
            'index' => $this->index,
            '_source' => ['id','title','data','modelid','catname','remark','thumb','addtime','url'], //显示的字段
            'body' => array_merge([
                'from' => $page,
                'size' => $pagesize
            ],$query)
        ];
        $data = $this->client->search($params);
        return $data['hits'];
    }
}
