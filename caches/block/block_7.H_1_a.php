<?php
 return array (
  'type' => '1',
  'modelid' => '0',
  'codetype' => '1',
  'name' => '首页幻灯片（移动站）',
  'max_number' => '500',
  'createhtml' => '0',
  'updatetime' => '1431684105',
  'timing' => '1431687705',
  'status' => '9',
  'code' => '{wz:content action="block" pagesize="1" type="1" blockid="7"}
<ul>
{loop $rs $r}
<div class="tit">{$r["title"]}</div><a href="{$r["url"]}"><img src="{imagecut($r["thumb"],600,400,4)}"/></a>
{/loop}
</ul>
{/wz}
',
)?>