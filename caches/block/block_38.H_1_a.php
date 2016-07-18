<?php
 return array (
  'blockid' => '38',
  'tplid' => 't3',
  'modelid' => '1',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '内容页频道推荐',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="6" type="1" blockid="38"}
                {loop $rs $r}
                {if $n==1}
                <a href="{$r[\'url\']}" class="list-group-item manhangyichu active">
                    {$r[\'title\']}
                </a>
                {else}
                <a href="{$r[\'url\']}" class="list-group-item manhangyichu">{$r[\'title\']}</a>
                {/if}
                {/loop}
                {/wz}
                                ',
  'url' => '',
  'updatetime' => '1463542777',
  'status' => '9',
  'timing' => '1463546377',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>