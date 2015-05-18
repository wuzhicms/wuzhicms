<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><a href="#" class="dropdown-toggle" data-toggle="dropdown">我的购物车<span class="color_heyihong">(<?php echo $totals;?>)</span> <span class="caret"></span></a>
<ul class="dropdown-menu" role="menu" style=" min-width:300px;">
    <?php $n=1;if(is_array($result)) foreach($result AS $r) { ?>
    <li class="margin_left20">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td rowspan="2"><a href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" height="70" width="74"></a></td>
                <td colspan="2"><a href="<?php echo $r['url'];?>"><?php echo strcut($r['remark'],25);?></a></td>
            </tr>
            <tr>
                <td><span class="color_heyihong">￥<?php echo $r['price'];?></span> &times;<?php echo $r['quantity'];?></td>
                <td><a href="/index?m=order&f=order_goods&v=del&id=<?php echo $r['cartid'];?>">删除</a></td>
            </tr>
        </table>
    </li>
    <li class="divider"></li>
    <?php $n++;}?>
    <li class="margin_left20"><button type="button" class="btn btn-danger_g" style="float:right; margin-right:20px;" onclick="gotourl('/index?m=order&f=order_goods&v=cart')"><span class="glyphicon glyphicon-shopping-cart"></span>
        查看购物车</button></a></li>
</ul>