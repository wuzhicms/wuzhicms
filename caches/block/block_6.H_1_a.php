<?php
 return array (
  'type' => '1',
  'modelid' => '0',
  'codetype' => '1',
  'name' => '首页幻灯片',
  'max_number' => '500',
  'createhtml' => '1',
  'updatetime' => '1429582297',
  'timing' => '1429585897',
  'status' => '9',
  'code' => '{wz:content action="block" pagesize="3" type="1" blockid="6"}
{loop $rs $r}
<div class="item {if $n==1}active{/if}"><a href="{$r[\'url\']}"><img src="{$r[\'thumb\']}" alt="{$r[\'title\']}" width="465" height="300"></a>
                            <div class="carousel-caption"> ... </div>
                        </div>
{/loop}
{/wz}
',
)?>