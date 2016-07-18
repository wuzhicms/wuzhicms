<?php
 return array (
  'blockid' => '28',
  'tplid' => 't3',
  'modelid' => '2',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '首页团购推荐',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="3" type="1" blockid="28"}
            {loop $rs $r}
            {if $n==1}
            <div class="col-xs-4">
                <div class="narrowArt tuan-price">
                    <a href="{$r[\'url\']}">
                        <ins class="tuan-price_ico"><strong>￥{$r[\'price\']}</strong></ins>
                        <img  src=" {imagecut($r[\'thumb\'],369,380,4)}" alt="{$r[\'title\']}" height="380">
                        <h1>{$r[\'title\']}</h1>
                    </a>
                </div>
            </div>
            <div class="col-xs-3">
                {else}
                <div class="narrowArt tuan-price">
                    <a href="{$r[\'url\']}">
                        <ins class="tuan-price_ico"><strong>￥{$r[\'price\']}</strong></ins>
                        <img  src="{imagecut($r[\'thumb\'],273,181,4)}" alt="" height="182">
                        <h2>{$r[\'title\']}</h2>
                    </a>
                </div>
                {/if}
                {/loop}
                {/wz}
            </div>',
  'url' => '',
  'updatetime' => '1463542700',
  'status' => '9',
  'timing' => '1463546300',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>