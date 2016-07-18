<?php
 return array (
  'blockid' => '27',
  'tplid' => 't3',
  'modelid' => '2',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '首页团购专场',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="2" type="1" blockid="27"}
                {loop $rs $r}
                <div class="narArts">
                    <a title="222" href="{$r[\'url\']}" target="_blank">
                        <div class="crop">
                            <img  src=" {$r[\'thumb\']}" alt="">
                        </div>
                        <h2><strong>+ 团购专场 + </strong><br> {$r[\'title\']}</h2>
                    </a>
                </div>
                {/loop}
                {/wz}
                                ',
  'url' => '',
  'updatetime' => '1463542712',
  'status' => '9',
  'timing' => '1463546312',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>