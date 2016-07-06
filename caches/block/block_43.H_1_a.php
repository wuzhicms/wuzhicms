<?php
 return array (
  'tplid' => 't3',
  'type' => '1',
  'modelid' => '0',
  'codetype' => '1',
  'name' => '装机必备',
  'siteid' => '1',
  'max_number' => '500',
  'createhtml' => '0',
  'updatetime' => '1462774426',
  'timing' => '1462778026',
  'status' => '9',
  'isopenid' => '0',
  'blockid' => '43',
  'code' => '                                {wz:content action="block" pagesize="10" type="1" blockid="43"}
                                <ul>
                                {loop $rs $r}
                                    <li>{$r["title"]}</li>
                                {/loop}
                                </ul>
                                {/wz}
                                ',
)?>