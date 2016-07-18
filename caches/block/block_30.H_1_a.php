<?php
 return array (
  'blockid' => '30',
  'tplid' => 't3',
  'modelid' => '8',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '首页积分商城',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="3" type="1" blockid="30"}
            {loop $rs $r}
            {php $attach=unserialize($r[\'attach\'])}
            <div class="col-xs-3">
                <div class="thumbnail">
                    <div class="pic_Control">
                        <a href="{$r[\'url\']}"><img src="{imagecut($r[\'thumb\'],271,181,4)}" alt="{$r[\'title\']}" ></a>
                    </div>
                    <div class="caption">
                        <p class="titles manhangyichu"><strong>{$r[\'title\']}</strong><br>
                            <span><strong class="color_success">{$attach[\'point\']}</strong> 积分   {if $attach[\'price\']!=\'0.00\'}{if $attach[\'point_money\']!=0}<strong class="color_success">{$attach[\'point_money\']}</strong> 积分 + {/if}    <strong class="color_qiyecheng">{$attach[\'price\']}</strong>元{/if}</span>
                        </p>
                    </div>
                </div>
            </div>
            {/loop}
            {/wz}',
  'url' => '',
  'updatetime' => '1463542667',
  'status' => '9',
  'timing' => '1463546267',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>