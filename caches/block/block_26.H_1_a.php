<?php
 return array (
  'blockid' => '26',
  'tplid' => 't3',
  'modelid' => '2',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '特惠推荐',
  'max_number' => '500',
  'code' => '<div class="row">
            {wz:content action="block" pagesize="10" type="1" blockid="26"}
            {loop $rs $r}
            <div class="col-xs-3">
                <div class="thumbnail">
                    {php $attach=unserialize($r[\'attach\'])}
                    <div class="pic_Control_g">
                        <a href="{$r[\'url\']}"><img src="{$r[\'thumb\']}" alt="..."></a>
                        <span   class="shoucang_ico">
                            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                            {if ($attach[\'endtime\'] < SYS_TIME)} 结束 {else}
                            <span id="t{$r[\'id\']}_d">0</span>天
                            <span id="t{$r[\'id\']}_h">0</span>时
                            <span id="t{$r[\'id\']}_m">0</span>分
                            <span id="t{$r[\'id\']}_s">0</span>秒
                            {/if}
                        </span>
                    </div>
                    <div class="caption">

                        <h4 class="manhangyichu"><a href="{$r[\'url\']}">{$r[\'title\']}</a></h4>
                        <p class="color_777">{$attach[\'subtitle\']}</p>
                        <div class="price-and-pingjia">

                            <div class="p-a-p-price">￥{intval($attach[\'iprice\'])} <del class="color_999  font_size14">￥{intval($attach[\'price\'])}</del></div>
                            <div class="p-a-p-pingjia" style="padding-top: 12px">
                                <div class="rate-score"> <span class="score-value-no" ><em style="width: 80%"></em></span></div>
                                <small class="color_999">123</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {/loop}
            <script>
                {loop $rs $r}
                {php $attach=unserialize($r[\'attach\'])}
                window.setInterval(function(){GetRTime(\'{date(\'Y-m-d H:i:s\',$attach[\'endtime\'])}\',\'t{$r[\'id\']}_\');}, 0);
                {/loop}
            </script>
            {/wz}
        </div>
                                ',
  'url' => '',
  'updatetime' => '1463542727',
  'status' => '9',
  'timing' => '1463546327',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>