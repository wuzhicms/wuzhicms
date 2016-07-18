<?php
 return array (
  'blockid' => '32',
  'tplid' => 't3',
  'modelid' => '7',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '视频频道推荐',
  'max_number' => '500',
  'code' => ' {wz:content action="block" pagesize="3" type="1" blockid="32"}
            {loop $rs $r}
            {if $n==1}
            <div class="col-xs-8">
                <div class="narrowArt video">
                    <a href="{$r[\'url\']}"  title="{$r[\'title\']}">
                        <img  src="{imagecut($r[\'thumb\'],562,380,4)}" alt="{$r[\'title\']}" height="380">
                        <h1>{$r[\'title\']}</h1>
                    </a>
                </div>
            </div>
            {else}
            <div class="col-xs-4">
                <div class="narrowArt video">
                    <a href="{$r[\'url\']}"  title="{$r[\'title\']}">
                        <img  src="{imagecut($r[\'thumb\'],272,182,4)}"  alt="{$r[\'title\']}" height="182">
                        <h2>{$r[\'title\']}</h2>
                    </a>
                </div>
            </div>
            {/if}
            {/loop}
            {/wz}',
  'url' => '',
  'updatetime' => '1463542639',
  'status' => '9',
  'timing' => '1463546239',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>