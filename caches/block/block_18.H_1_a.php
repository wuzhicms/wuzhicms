<?php
 return array (
  'blockid' => '18',
  'tplid' => 't3',
  'modelid' => '0',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '首页新闻区图片',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="3" type="1" blockid="18"}
                {loop $rs $r}
                {if $n==1}
                <div class="col-xs-6">
                    <div class="narrowArt">
                        <a href="{$r[\'url\']}" title="222" target="_blank">
                            <img  src=" {imagecut($r[\'thumb\'],562,380,4)}" alt="" height="380">
                            <h1>{$r[\'title\']}</h1>
                        </a>
                    </div>
                </div>
                <div class="col-xs-3">
                    {else}
                    <div class="narrowArt video">
                        <a href="{$r[\'url\']}" title="222" target="_blank">
                            <img  src=" {imagecut($r[\'thumb\'],273,182,4)}" alt="" height="182">
                            <h2>{$r[\'title\']}</h2>
                        </a>
                    </div>
                    {/if}
                    {/loop}
                    {/wz}',
  'url' => '',
  'updatetime' => '1460359733',
  'status' => '9',
  'timing' => '1460363333',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>