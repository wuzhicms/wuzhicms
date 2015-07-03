<?php
 return array (
  'type' => '1',
  'modelid' => '0',
  'codetype' => '1',
  'name' => '首页头条推荐（4条）',
  'max_number' => '500',
  'createhtml' => '0',
  'updatetime' => '1435747716',
  'timing' => '1435751316',
  'status' => '9',
  'code' => '{wz:content action="block" pagesize="4" type="1" blockid="5"}
<h3>首页头条推荐<span class="lm_more"></span></h3>
                <div class="list-group">
{loop $rs $r}
{php $attach=unserialize($r[\'attach\'])}
<a href="{$r[\'url\']}" class="list-group-item">
                    <h4 class="list-group-item-heading"><span class="badge">{$categorys[$attach[\'cid\']][\'name\']}</span> {strcut($r[\'title\'],40)}</h4>
                    <p class="list-group-item-text">&nbsp;{strcut($r[\'remark\'],50)}</p>
                </a>
{/loop}
</div>
{/wz}',
)?>