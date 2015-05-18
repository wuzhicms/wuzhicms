<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<script src="<?php echo R;?>js/jquery.min.js"></script>
<style type="text/css">
    .m-panel{
        position: fixed;
        z-index: 2000;
        background-color: rgba(148, 189, 207, 0.33);
        float: right;
        top: 200px;
        right: 15px;
        width: 130px;
        border: 1px #D222AE dashed;
        font-size: 16px;
        line-height: 03.42857143;
        color: #F91E0C;
    }
    .m-panel>ul{
        margin: 0px 0px;
    }
    .m-panel>ul>li{
        line-height: 36px;
        margin: 0px 0px;
    }
</style>

<div class="m-panel">
    <ul>
        <li><a href="?m=content&f=content&v=edit&id=<?php echo $id;?>&cid=<?php echo $cid.$this->su();?>" target="_blank">编辑</a></li>
        <li><a href="?m=content&f=content&v=check&pass=1&id=<?php echo $id;?>&cid=<?php echo $cid.$this->su();?>">审核通过</a></li>
        <li><a href="?m=content&f=content&v=check&pass=0&id=<?php echo $id;?>&cid=<?php echo $cid.$this->su();?>">退稿</a></li>
        <li><a href="?m=content&f=content&v=recycle_delete&close=1&id=<?php echo $id;?>&cid=<?php echo $cid.$this->su();?>" >删除</a></li>
    </ul>
</div>


