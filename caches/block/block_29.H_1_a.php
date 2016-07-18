<?php
 return array (
  'blockid' => '29',
  'tplid' => 't3',
  'modelid' => '2',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '首页特惠推荐',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="4" type="1" blockid="29"}
                    {loop $rs $r}
                    <div class="col-xs-6">
                        <a href="{$r[\'url\']}" class="thumbnail box-and-title-img">
                            <ins class="tuijian_ico">抢购</ins>
                            <div class="imght">
                                <img src=" {imagecut($r[\'thumb\'],126,91,4)}" alt="{$r[\'title\']}" >
                            </div>
                            <div class="caption height-hide97">
                                <h4><strong class="color_warning font_size18">￥{$r[\'price\']}</strong> <del class="color_999 font_size12">￥{$r[\'iprice\']}</del></h4>
                                <p class="font_size12">
                                    {$r[\'title\']}
                                </p>
                            </div>
                        </a>
                    </div>
                    {/loop}
                    {/wz}
                                ',
  'url' => '',
  'updatetime' => '1463542692',
  'status' => '9',
  'timing' => '1463546292',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>