<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php $groups = $this->groups;?>
<?php if(!isset($memberinfo)) $memberinfo = $this->memberinfo;?>
<div class="memberuserinfo">
    <div class="memberphoto"><a href="?m=member&f=index&v=profile"><img src="<?php echo avatar($this->uid, 180);?>"></a></div>
    <div class="membername"><i class="memberusericon"></i><span><?php echo $memberinfo['username'];?></span><a href="?m=member&f=index&v=profile&tabid=3tab" class="edituser"><?php echo $groups[$this->memberinfo['groupid']]['name'];?></a></div>
    <div class="memberblock">
        <a href="?m=member&f=friend&v=listing" class="friends"><i class="friendsicon"></i>好友圈</a>
        <a href="?m=message&f=message&v=listing" class="message"><i class="membermessage"></i>私　信</a>
        <span style="position: absolute;margin-top: -10px;  margin-left:-60px;" class="hide" id="mymessage-tips"><img src="<?php echo R;?>member/image/new_font.gif"></span>
    </div>
</div>
<?php if($memberinfo['modelid']==23) { ?>
<!--机构 -->
<div class="memberleftmenu">

    <div class="menutitle text-center"><i class="myinfoicon"></i>我的信息夹</div>
    <ul>
        <li><a href="index.php?m=content&f=mecinfo&v=listing" class="<?php if(M=='content' && F=='mecinfo' && V=='listing') { ?>menuactive<?php } ?>">机构发布信息</a></li>
        <li><a href="index.php?m=content&f=postinfo&v=listing" class="<?php if(M=='content' && F=='postinfo' && V=='listing') { ?>menuactive<?php } ?>">机构产品发布</a></li>

        <li><a href="index?m=dianping&v=index&v=mydianping&acbar=3" class="<?php if(M=='dianping' && F=='index' && V=='mydianping') { ?>menuactive<?php } ?>">我的点评</a></li>
        <li class="<?php if(M=='issue' && F=='myissue' && V=='listing') { ?>menuactive<?php } ?>"><a href="?m=guestbook&f=myissue&v=listing">我的提问</a></li>

        <li class="<?php if(M=='member' && F=='favorite' && V=='mec') { ?>menuactive<?php } ?>"><a href="index.php?m=member&f=favorite&v=mec&acbar=3">我收藏的机构</a></li>
        <li class="<?php if(M=='member' && F=='favorite' && V=='listing') { ?>menuactive<?php } ?>"><a href="index.php?m=member&f=favorite&v=tuan">我收藏的套餐</a></li>
    </ul>
    <div class="menutitle text-center"><i class="accounticon"></i>账户中心</div>
    <ul>
        <li class="<?php if(M=='member' && F=='index' && V=='profile') { ?>menuactive<?php } ?>"><a href="index.php?m=member&f=index&v=profile&acbar=2">账户信息</a></li>
        <li class="<?php if(M=='member' && F=='index' && V=='edit_password') { ?>menuactive<?php } ?>"><a href="index.php?m=member&f=index&v=account_safe">账户安全</a></li>
        <li class="<?php if(M=='pay' && F=='payment' && V=='listing') { ?>menuactive<?php } ?>"><a href="index.php?m=pay&f=payment&v=listing&acbar=1">账户余额</a></li>
        <li class="<?php if(M=='credit' && F=='mycredit' && V=='listing') { ?>menuactive<?php } ?>"><a href="?m=credit&f=mycredit&v=listing">账户积分</a></li>
        <li class="<?php if(M=='order' && F=='address' && V=='listing') { ?>menuactive<?php } ?>"><a href="index.php?m=order&f=address&v=listing&acbar=1">收货地址管理</a></li>
    </ul>
</div>
<?php } elseif ($memberinfo['modelid']==11) { ?>
<!--企业 -->
<div class="memberleftmenu">
    <div class="menutitle text-center"><i class="ordericon"></i>订单中心</div>
    <ul>
        <li><a href="index.php?m=order&f=order_goods&v=listing&acbar=3" class="<?php if(M=='order' && F=='order_goods' && V=='listing' && $status==0) { ?>menuactive<?php } ?>">我的订单</a></li>
    </ul>
    <div class="menutitle text-center"><i class="myinfoicon"></i>我的信息夹</div>
    <ul>
        <li><a href="index.php?m=content&f=cominfo&v=listing" class="<?php if(M=='content' && F=='cominfo' && V=='listing') { ?>menuactive<?php } ?>">需求信息发布</a></li>

        <li><a href="index?m=dianping&v=index&v=mydianping&acbar=3" class="<?php if(M=='dianping' && F=='index' && V=='mydianping') { ?>menuactive<?php } ?>">我的点评</a></li>
        <li class="<?php if(M=='issue' && F=='myissue' && V=='listing') { ?>menuactive<?php } ?>"><a href="?m=guestbook&f=myissue&v=listing">我的提问</a></li>

        <li class="<?php if(M=='member' && F=='favorite' && V=='mec') { ?>menuactive<?php } ?>"><a href="index.php?m=member&f=favorite&v=mec&acbar=3">我收藏的机构</a></li>
        <li class="<?php if(M=='member' && F=='favorite' && V=='listing') { ?>menuactive<?php } ?>"><a href="index.php?m=member&f=favorite&v=tuan">我收藏的套餐</a></li>
        <li><a href="index.php?m=order&f=index&v=point_listing&acbar=3" class="<?php if(M=='order' && F=='index' && V=='point_listing') { ?>menuactive<?php } ?>">积分兑换</a></li>

    </ul>
    <div class="menutitle text-center"><i class="accounticon"></i>账户中心</div>
    <ul>
        <li class="<?php if(M=='member' && F=='index' && V=='profile') { ?>menuactive<?php } ?>"><a href="index.php?m=member&f=index&v=profile&acbar=2">账户信息</a></li>
        <li class="<?php if(M=='member' && F=='index' && V=='edit_password') { ?>menuactive<?php } ?>"><a href="index.php?m=member&f=index&v=account_safe">账户安全</a></li>
        <li class="<?php if(M=='pay' && F=='payment' && V=='listing') { ?>menuactive<?php } ?>"><a href="index.php?m=pay&f=payment&v=listing&acbar=1">账户余额</a></li>
        <li class="<?php if(M=='credit' && F=='mycredit' && V=='listing') { ?>menuactive<?php } ?>"><a href="?m=credit&f=mycredit&v=listing">账户积分</a></li>
        <li class="<?php if(M=='coupon' && F=='coupon' && V=='listing') { ?>menuactive<?php } ?>"><a href="index.php?m=coupon&f=coupon&v=listing&acbar=1">我的现金券</a></li>
        <li class="<?php if(M=='order' && F=='address' && V=='listing') { ?>menuactive<?php } ?>"><a href="index.php?m=order&f=address&v=listing&acbar=1">收货地址管理</a></li>
    </ul>
    <div class="menutitle text-center"><i class="seviceicon"></i>客户服务</div>
    <ul>
        <li class="<?php if(M=='receipt' && F=='receipt' && V=='listing') { ?>menuactive<?php } ?>"><a href="index.php?m=receipt&f=receipt&v=listing&acbar=1">发票申请</a></li>
    </ul>
</div>
<?php } else { ?>
<!--个人 -->
<div class="memberleftmenu">
    <div class="menutitle text-center"><i class="ordericon"></i>订单中心</div>
    <ul>
        <li><a href="index.php?m=order&f=order_goods&v=listing&acbar=3" class="<?php if(M=='order' && F=='order_goods' && V=='listing' && $status==0) { ?>menuactive<?php } ?>">我的订单</a></li>
        <li><a href="index.php?m=order&f=index&v=point_listing&acbar=3" class="<?php if(M=='order' && F=='index' && V=='point_listing') { ?>menuactive<?php } ?>">积分兑换</a></li>
    </ul>
    <div class="menutitle text-center"><i class="myinfoicon"></i>我的信息夹</div>
    <ul>
        <li><a href="index.php?m=dianping&v=index&v=mydianping&acbar=3" class="<?php if(M=='dianping' && F=='index' && V=='mydianping') { ?>menuactive<?php } ?>">我的点评</a></li>
        <li class="<?php if(M=='issue' && F=='myissue' && V=='listing') { ?>menuactive<?php } ?>"><a href="?m=guestbook&f=myissue&v=listing">我的提问</a></li>

        <li class="<?php if(M=='member' && F=='favorite' && V=='mec') { ?>menuactive<?php } ?>"><a href="index.php?m=member&f=favorite&v=mec&acbar=3">我收藏的机构</a></li>
        <li class="<?php if(M=='member' && F=='favorite' && V=='listing') { ?>menuactive<?php } ?>"><a href="index.php?m=member&f=favorite&v=tuan">我收藏的套餐</a></li>
    </ul>
    <div class="menutitle text-center"><i class="accounticon"></i>账户中心</div>
    <ul>
        <li class="<?php if(M=='member' && F=='index' && V=='profile') { ?>menuactive<?php } ?>"><a href="index.php?m=member&f=index&v=profile&acbar=2">账户信息</a></li>
        <li class="<?php if(M=='member' && F=='index' && V=='edit_password') { ?>menuactive<?php } ?>"><a href="index.php?m=member&f=index&v=account_safe">账户安全</a></li>
        <li class="<?php if(M=='pay' && F=='payment' && V=='listing') { ?>menuactive<?php } ?>"><a href="index.php?m=pay&f=payment&v=listing&acbar=1">账户余额</a></li>
        <li class="<?php if(M=='credit' && F=='mycredit' && V=='listing') { ?>menuactive<?php } ?>"><a href="?m=credit&f=mycredit&v=listing">账户积分</a></li>
        <li class="<?php if(M=='coupon' && F=='coupon' && V=='listing') { ?>menuactive<?php } ?>"><a href="index.php?m=coupon&f=coupon&v=listing&acbar=1">我的现金券</a></li>
        <li class="<?php if(M=='order' && F=='address' && V=='listing') { ?>menuactive<?php } ?>"><a href="index.php?m=order&f=address&v=listing&acbar=1">收货地址管理</a></li>
    </ul>
    <div class="menutitle text-center"><i class="seviceicon"></i>客户服务</div>
    <ul>
        <li class="<?php if(M=='receipt' && F=='receipt' && V=='listing') { ?>menuactive<?php } ?>"><a href="index.php?m=receipt&f=receipt&v=listing&acbar=1">发票申请</a></li>
    </ul>
</div>

<?php } ?>