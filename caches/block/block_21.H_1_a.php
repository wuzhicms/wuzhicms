<?php
 return array (
  'blockid' => '21',
  'tplid' => 't3',
  'modelid' => '0',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '首页图片区一',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="3" type="1" blockid="21"}
                {loop $rs $r}
                <div class="narArts">
                    <a title="222" href="{$r[\'url\']}" target="_blank">
                        <div class="crop">
                            <img  src=" {$r[\'thumb\']}" alt="{$r[\'title\']}">
                        </div>
                        <h2>{$r[\'title\']}</h2>
                    </a>
                </div>
                {/loop}
                {/wz}
                                ',
  'url' => '',
  'updatetime' => '1459312991',
  'status' => '9',
  'timing' => '1459316591',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>