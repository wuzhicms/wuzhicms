<?php
 return array (
  'blockid' => '45',
  'tplid' => 't3',
  'modelid' => '15',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '内容页底部4广告图',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="10" type="1" blockid="45"}
<div class="container">
<div class="row">               
{loop $rs $r}
<div class="col-xs-3"><a href="{$r[\'url\']}" target="_blank"><img src="{$r[\'thumb\']}" width="273" height="92"></a></div>
{/loop}
</div>
</div> 
{/wz}',
  'url' => '',
  'updatetime' => '1463472967',
  'status' => '9',
  'timing' => '1463476567',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>