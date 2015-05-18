<?php
 return array (
  'type' => '1',
  'modelid' => '6',
  'codetype' => '1',
  'name' => '常用下载',
  'max_number' => '500',
  'createhtml' => '0',
  'updatetime' => '1431495536',
  'timing' => '1431499136',
  'status' => '9',
  'code' => '{wz:content action="block" pagesize="10" type="1" blockid="14" cid="$cid"}
                        {loop $rs $r}
                        <a href="{$r[\'url\']}" class="list-group-item_gr active"><span class="badge_top">{str_pad($n, 2, "0", STR_PAD_LEFT)} </span>&nbsp;{strcut($r[\'title\'],36)}</a>
                        {/loop}
                        {/wz}',
)?>