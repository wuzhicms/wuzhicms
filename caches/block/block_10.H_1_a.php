<?php
 return array (
  'blockid' => '10',
  'tplid' => 't2',
  'modelid' => '0',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '推荐礼品',
  'max_number' => '500',
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
  'url' => '',
  'updatetime' => '1435747704',
  'status' => '9',
  'timing' => '1435751304',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => '',
)?>