<?php
 return array (
  'blockid' => '42',
  'tplid' => 't3',
  'modelid' => '6',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '下载子栏目-头部右',
  'max_number' => '500',
  'code' => '                                {wz:content action="block" pagesize="10" type="1" blockid="42"}
                                <ul>
                                {loop $rs $r}
                                    <li>{$r["title"]}</li>
                                {/loop}
                                </ul>
                                {/wz}
                                ',
  'url' => '',
  'updatetime' => '1463542748',
  'status' => '9',
  'timing' => '1463546348',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>