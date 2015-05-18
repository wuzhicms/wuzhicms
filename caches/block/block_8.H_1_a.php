<?php
 return array (
  'type' => '1',
  'modelid' => '0',
  'codetype' => '1',
  'name' => '首页推荐（移动站－文字＋图片）',
  'max_number' => '500',
  'createhtml' => '0',
  'updatetime' => '1431749582',
  'timing' => '1431753182',
  'status' => '9',
  'code' => '{wz:content action="block" pagesize="5" type="1" blockid="8"}
<section class="cbox">
    <ul class="colst">
{loop $rs $r}
            <li>
                <div class="bl">
                    <div><a href="{$r[\'url\']}">{safe_htm($r[\'title\'])}</a></div>
                    <div><span class="nums">{$categorys[$r[\'cid\']][\'name\']}</span><span class="times">{date(\'Y-m-d\',$r[\'addtime\'])}</span></div>
                </div>
                {if $r[\'thumb\']}<div class="mimg"><a href="{$r[\'url\']}"><img src="{$r[\'thumb\']}" width="60" height="60"/></a></div>{/if}
            </li>
            {/loop}
</ul>
</section>
{/wz}',
)?>