<?php
 return array (
  'blockid' => '36',
  'tplid' => 't3',
  'modelid' => '6',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '下载文章推荐',
  'max_number' => '500',
  'code' => '<div class="list-group">
                    {wz:content action="block" pagesize="6" type="1" blockid="36"}
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
                </div>',
  'url' => '',
  'updatetime' => '1463542584',
  'status' => '9',
  'timing' => '1463546184',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>