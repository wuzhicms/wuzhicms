<?php
 return array (
  'type' => '1',
  'modelid' => '0',
  'codetype' => '1',
  'name' => '推荐礼品',
  'max_number' => '500',
  'createhtml' => '0',
  'updatetime' => '1435747704',
  'timing' => '1435751304',
  'status' => '9',
  'code' => '{wz:content action="block" pagesize="5" type="1" blockid="10"}
<ul>
{loop $rs $r}
                <a href="{$r[\'url\']}"><img src="{$r[\'thumb\']}" width="134" alt="{$r[\'title\']}"></a>
                <div class="caption">
                    <h5>{strcut($r[\'title\'],24)}</h5>
                    <p>现价： <span class=" color_danger">{$r[\'point\']}积分</span></p>
                </div>
                {/loop}
</ul>
{/wz}
',
)?>