<?php
 return array (
  'blockid' => '31',
  'tplid' => 't3',
  'modelid' => '8',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '首页热门兑换',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="10" type="1" blockid="31"}
            {loop $rs $r}
            {php $attach=unserialize($r[\'attach\'])}
            <div class="col-xs-3">
                <div class="thumbnail">
                    <div class="pic_Control">
                        <a href="{$r[\'url\']}"><img src="{imagecut($r[\'thumb\'],271,181,4)}" alt="{$r[\'title\']}" ></a>
                        <ins class="tuijian_ico">立即兑换</ins>
                    </div>
                    <div class="caption">
                        <p class="titles manhangyichu"><strong>{$r[\'title\']}</strong><br>
                            <span><strong class="color_success">{$attach[\'point\']}</strong> 积分   {if $attach[\'price\']!=\'0.00\'}{if $attach[\'point_money\']!=0}<strong class="color_success">{$attach[\'point_money\']}</strong> 积分 +{/if}    <strong class="color_qiyecheng">{$attach[\'price\']}</strong>元{/if}</span>
                        </p>
                    </div>
                </div>
            </div>
            {/loop}
            {/wz}',
  'url' => '',
  'updatetime' => '1463542656',
  'status' => '9',
  'timing' => '1463546256',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>