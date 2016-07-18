<?php
 return array (
  'blockid' => '35',
  'tplid' => 't3',
  'modelid' => '6',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '下载图片推荐',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="3" type="1" blockid="35"}
                        {loop $rs $r}
                        <div class="item {if $n==1}active{/if}">
<a href=" {$r[\'url\']}">
                            <img src=" {$r[\'thumb\']}" alt="{$r[\'title\']}" style="height: 260px">
                            <div class="carousel-caption">
                                <h3 style="font-weight: normal; margin-bottom:  16px">{$r[\'title\']}</h3>
                            </div>
</a>
                        </div>
                        {/loop}
                        {/wz}',
  'url' => '',
  'updatetime' => '1463542600',
  'status' => '9',
  'timing' => '1463546200',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>