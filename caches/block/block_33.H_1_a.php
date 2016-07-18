<?php
 return array (
  'blockid' => '33',
  'tplid' => 't3',
  'modelid' => '1',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '新闻频道推荐',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="3" type="1" blockid="33"}
        {loop $rs $r}
<div class="item {if $n==1}active{/if}">
    <a href="{$r[\'url\']}" target="_blank">
        <div style="max-height: 370px; overflow: hidden">
            <img src=" {$r[\'thumb\']}" alt="{$r[\'title\']}">
        </div>
        
        <div class="carousel-caption">
            <h3 style="font-weight: normal; margin-bottom:  16px">{$r[\'title\']}</h3>
        </div>
    </a>
</div>
        {/loop}
        {/wz}',
  'url' => '',
  'updatetime' => '1463542627',
  'status' => '9',
  'timing' => '1463546227',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>