<?php
 return array (
  'blockid' => '24',
  'tplid' => 't3',
  'modelid' => '0',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '首页视频区一',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="3" type="1" blockid="24"}
                {loop $rs $r}
                <div class="narArts">
                    <a title="222" href="{$r[\'url\']}" target="_blank">
                        <div class="crop">
                            <img  src=" {$r[\'thumb\']}" alt="{$r[\'title\']}">
                        </div>
                        <h2><strong>+ 专题 + </strong><br>{$r[\'title\']}</h2>
                    </a>
                </div>
                {/loop}
                {/wz}',
  'url' => '',
  'updatetime' => '1459315436',
  'status' => '9',
  'timing' => '1459319036',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>