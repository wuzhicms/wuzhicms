<?php
 return array (
  'blockid' => '19',
  'tplid' => 't3',
  'modelid' => '0',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '首页新闻区列表',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="3" type="1" blockid="19"}
                        {loop $rs $r}
                        <div class="media">
                            <div class="media-body">
                                <h4 class="media-heading color_qiyelan font_size16 toutiao-right-title" ><a href="{$r[\'url\']}" target="_blank">{$r[\'title\']}</a></h4>
                                <div class="media-content  color_777 ">{strip_tags($r[\'remark\'])}</div>
                            </div>
                        </div>
                        {/loop}
                        {/wz}
                                ',
  'url' => '',
  'updatetime' => '1460013897',
  'status' => '9',
  'timing' => '1460017497',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>