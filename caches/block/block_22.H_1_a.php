<?php
 return array (
  'blockid' => '22',
  'tplid' => 't3',
  'modelid' => '0',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '首页图片区二',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="8" type="1" blockid="22"}
{loop $rs $r}
{if $n==1}
<div class="narrowArt">
    <a href="{$r[\'url\']}" title="222" target="_blank">
        <img  src=" {imagecut($r[\'thumb\'],369,380,4)}" alt="{$r[\'title\']}" height="380">
        <h1>{$r[\'title\']}</h1>
    </a>
</div>
{elseif $n==2}
<div class="narrowArt">
    <a href="{$r[\'url\']}" title="222" target="_blank">
        <img  src=" {imagecut($r[\'thumb\'],369,181,4)}" alt="{$r[\'title\']}" height="182">
        <h2>{$r[\'title\']}</h2>
    </a>
</div>
</div>
<div class="col-xs-6">
    <div class="row">
        {else}
        <div class="col-xs-6">
            <div class="narrowArt">
                <a href="{$r[\'url\']}" title="222" target="_blank">
                    <img  src=" {imagecut($r[\'thumb\'],273,182,4)}" alt="{$r[\'title\']}" height="182">
                    <h2>{$r[\'title\']}</h2>
                </a>
            </div>
        </div>
        {/if}
        {/loop}
        {/wz}
',
  'url' => '',
  'updatetime' => '1460540857',
  'status' => '9',
  'timing' => '1460544457',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>