<?php
 return array (
  'blockid' => '40',
  'tplid' => 't3',
  'modelid' => '7',
  'siteid' => '1',
  'type' => '1',
  'codetype' => '1',
  'name' => '内容页视频新闻',
  'max_number' => '500',
  'code' => '{wz:content action="block" pagesize="3" type="1" blockid="40"}
                {loop $rs $r}
                <div class="media">
                    <div class="media-left ">
                        <a href="{$r[\'url\']}">
                            <img class="media-object" src="{imagecut($r[\'thumb\'],106,70,4)}" alt="..." width="105px" >
                        </a>
                    </div>
                    <div class="media-body" style="max-width: 205px">
                        <h5 class="media-heading manhangyichu"><a href="{$r[\'url\']}">{$r[\'title\']}</a></h5>
                        <div class="media-content" >{$r[\'remark\']}</div>
                    </div>
                </div>
                {/loop}
                {/wz}
                                ',
  'url' => '',
  'updatetime' => '1463542817',
  'status' => '9',
  'timing' => '1463546417',
  'createhtml' => '0',
  'remark' => '',
  'isopenid' => '0',
  'lang' => 'zh',
)?>