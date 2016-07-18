<?php
 return array (
  'blockid' => '34',
  'tplid' => 't3',
  'modelid' => '5',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '图片频道推荐',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="10" type="1" blockid="34"}
                        {loop $rs $r}
                        <div class="item {if $n==1} active {/if}">
                            <a href="{$r[\'url\']}"><img src=" {imagecut($r[\'thumb\'],1140,550,4)}" alt="{$r[\'title\']}"></a>
                            <div class="carousel-caption">
                                <h3 class="margin_bottom20 line_height1d8">{$r[\'title\']}</h3>
                            </div>
                        </div>
                        {/loop}
                        {/wz}
                                ',
  'url' => '',
  'updatetime' => '1463542613',
  'status' => '9',
  'timing' => '1463546213',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>