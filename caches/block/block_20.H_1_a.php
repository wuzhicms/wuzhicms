<?php
 return array (
  'blockid' => '20',
  'tplid' => 't3',
  'modelid' => '0',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '首页专题',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="4" type="1" blockid="20"}
                {loop $rs $r}
                <div class="col-xs-3">
                    <div class="narrowArt jia-biaoqian">
                        <a href="{$r[\'title\']}" title="222" target="_blank">
                            <img  src="{imagecut($r[\'thumb\'],273,182,4)}" alt="{$r[\'tilte\']}" height="182">
                            <h2 data-autor="专题推荐">{$r[\'title\']}</h2>
                        </a>
                    </div>
                </div>
                {/loop}
                {/wz}',
  'url' => '',
  'updatetime' => '1460359855',
  'status' => '9',
  'timing' => '1460363455',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>