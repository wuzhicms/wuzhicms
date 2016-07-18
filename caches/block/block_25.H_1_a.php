<?php
 return array (
  'blockid' => '25',
  'tplid' => 't3',
  'modelid' => '7',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '首页视频区二',
  'max_number' => '500',
  'code' => '                                {wz:content action="block" pagesize="10" type="1" blockid="25"}
                                <ul>
                                {loop $rs $r}
                                    <li>{$r["title"]}</li>
                                {/loop}
                                </ul>
                                {/wz}
                                ',
  'url' => '',
  'updatetime' => '1463542736',
  'status' => '9',
  'timing' => '1463546336',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>