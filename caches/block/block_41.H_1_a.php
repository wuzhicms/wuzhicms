<?php
 return array (
  'blockid' => '41',
  'tplid' => 't3',
  'modelid' => '6',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '下载子栏目-头部左',
  'max_number' => '500',
  'code' => '                                {wz:content action="block" pagesize="10" type="1" blockid="41"}
                                <ul>
                                {loop $rs $r}
                                    <li>{$r["title"]}</li>
                                {/loop}
                                </ul>
                                {/wz}
                                ',
  'url' => '',
  'updatetime' => '1463542755',
  'status' => '9',
  'timing' => '1463546355',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>