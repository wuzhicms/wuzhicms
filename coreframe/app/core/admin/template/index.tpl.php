<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body class="index_frame">
<section id="container" >
    <!--header start-->
    <header class="header pxgrids-bg d-flex justify-content-between">
        <div class="d-flex">
            <a href="<?php echo WEBURL;?>" target="_blank" class="logo"><img src="<?php echo R;?>images/admin_logo.png" title="点击打开网站首页"></a>
            <div class="topmenunav" id="menu">
                <ul id="top_menu" class="align-items-center d-flex justify-content-between align-items-center">
                    <?php
                    foreach($panels as $menuid=>$panel) {
                        $selected = $menuid==1 ? 'class="active"' : '';
                        echo '<li><a href="javascript:;" '.$selected.' onclick="PANEL(this,\''.$menuid.'\')">'.$MENU[$menuid].'</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="top-nav">
            <ul class="top-menu p-0">
                <!-- userinfo dropdown start-->
                <li class="dropdown userinfo">
                    <a id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" class="align-items-center dropdown-toggle justify-content-center" href="#" role="button">
                        <img src="<?php echo R;?>images/userimg.jpg" class="userimg me-2" id="siteimg">
                        <span class="username" id="sitename"><?php echo $sitelist[$siteid]['name'];?></span>
                    </a>
                    <ul class="dropdown-menu extended userullist" id="userullist" aria-labelledby="dropdownMenuLink">
                        <div class="log-arrow-up"><i class="icon-sort-up"></i></div>
                        <li class="usersettitle"><h5>切换站点</h5></li>
                        <?php
                        foreach($sitelist as $site) {
                            echo '<li><a href="javascript:changesite('.$site['siteid'].',\''.$site['name'].'\')">'.$site['name'].'</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <!-- userinfo dropdown end -->
                <li><a href="javascript:void(1);" id="lock"><i class="icon-screen"></i><span>锁屏</span></a></li>
                <li><a href="index.php?m=core&f=index&v=logout<?php echo $this->su();?>"><i class="icon-power-off"></i><span>退出</span></a></li>
            </ul>
        </div>
    </header>
    <!--header end-->
    <section class="d-flex">
        <!--sidebar start-->
        <aside>
            <div id="sidebar"  class="nav-collapse ">
                <!-- sidebar menu start-->
                <?php
                foreach($panels as $menuid=>$panel) {
                    // if($menuid!=1) continue;
                    ?>
                    <ul class="sidebar-menu <?php if($menuid!='1') echo 'hide';?>" id="panel-<?php echo $menuid;?>">
                        <div class="appicon text-center"><img src="<?php echo R;?>images/appicons/<?php echo $menuid;?>.png" alt=""></div>
                        <?php
                        $n = 1;
                        if($_panels[$menuid]) {
                            foreach($_panels[$menuid] as $_mid=>$_panel) {
                                $_d = $_panel['data'] ? '&'.$_panel['data'] : '';
                                $url = '?m='.$_panel['m'].'&f='.$_panel['f'].'&v='.$_panel['v'].$_d;
                                $selected = $n==1 ? 'class="_p_menu fone active"' : 'class="_p_menu"';
                                echo '<li><a href="javascript:w(\''.$url.'\');" onclick="_PANEL(this,'.$_mid.',\''.$url.'\')" '.$selected.' ><span>'.$MENU[$_mid].'</span></a></li>';
                                $n++;
                            }
                        }

                        ?>
                        <li></li>
                    </ul>
                <?php }?>

                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content" class="w-100">
            <div class="main-nav d-flex justify-content-between">
                <div class="d-flex">
                    <i class="icon-desktop2"></i><span id="position">我的面板<span>></span>系统首页<span>></span></span>
                </div>
                <div class="crumbsbutton"><a href="?m=core&f=cache_all&v=index<?php echo $this->su();?>" target="iframeid">更新缓存</a><a href="?m=content&f=createhtml&v=index&setcache=1&startid=2<?php echo $this->su();?>" target="iframeid">生成首页</a><a href="#" onclick="refresh_iframe()">刷新</a><a href="<?php echo $siteurl;?>" target="_blank" id="weburl">站点首页</a></div>
            </div>
            <div class="alert alert-warning fade in fadeInDown hide alert-dismissible" id="alert-warning" role="alert">
                <span id="warning-tips"><strong>安全提示：</strong> 建议您将网站admin目录设置为644或只读</span>
                <button class="btn close close-sm btn-close" type="button" onclick="$('#alert-warning').addClass('hide');" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <section id="iframecontent"><iframe  width="100%" name="iframeid" id="iframeid" frameborder="false" scrolling="auto" height="auto" allowtransparency="true" frameborder="0" src="?m=core&f=index&v=listing<?php echo $this->su();?>"></iframe>
            </section>
        </section>
        <!--main content end-->
    </section>
</section>


<style type="text/css">
    .validate-has-error {box-shadow: 0 0 0 2px rgba(236, 89, 86, 0.35);border: #EC7876 1px dotted;}
</style>
<script type="text/javascript">
    // var menuids = new Array();
    // menuids[1] = 1;
    var parentpos = '';
    function PANEL(obj,menuid) {
        $("#top_menu li a").removeClass('active');
        $(obj).addClass('active');

        $("#sidebar ul").addClass('hide');
        $("#panel-"+menuid).removeClass("hide");
        $("._p_menu").removeClass('active');
        $(".fone").addClass('active');


        //异步加载
        var gotourl = '';
        if(menuid==1) {
            gotourl = "?m=core&f=index&v=listing";
        } else if(menuid==2) {
            gotourl = "?m=core&f=site&v=listing&_menuid=256";
        } else if(menuid==3) {
            gotourl = "?m=content&f=content&v=manage";
        } else if(menuid==4) {
            gotourl = "?m=appshop&f=index&v=listing&_menuid=27";
        } else if(menuid==5) {
            gotourl = "?m=attachment&f=index&v=listing&_menuid=29";
        } else if(menuid==6) {
            gotourl = "?m=member&f=index&v=listing&_menuid=30";
        } else if(menuid==7) {
            gotourl = "?m=template&f=index&v=listing&_menuid=31";
        }
        if(gotourl) $("#iframeid").attr('src', gotourl+'<?php echo $this->su(0);?>');
        //$("#sidebar").load("?m=core&f=index&v=left&id="+menuid+"<?php echo $this->su();?>", {},          function(){
       // });
        parentpos = $(obj).html()+"<span>></span>";
        $("#position").html(parentpos);

        //console.log(menuids);
    }
    function _PANEL(obj,menuid,gotourl) {
        $("#iframeid").attr('src', gotourl+'<?php echo $this->su(0);?>&_menuid='+menuid);
        $("._p_menu").removeClass('active');
        $(obj).addClass('active');
        var mypos = $(obj).html();
        $("#position").html(parentpos+mypos+"<span>></span>");
    }
    //刷新主框架
    function refresh_iframe() {
        var _iframe = document.getElementById("iframeid");
        if($("#iframeid").attr('url')) {
            _iframe.src = $("#iframeid").attr('url');
        }
    }
    function w(s) {}
    $(function(){
        function startTimer()
        {
            var today=new Date();
            var h=today.getHours();
            var m=today.getMinutes();
            var s=today.getSeconds();
            // add a zero in front of numbers<10
            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            $('#time').html(h+":"+m+":"+s);
            t=setTimeout(function(){startTimer()},500);
        }

        function checkLockStatus(locked){

            if(locked == 1){
                $('#locker').show();
                $('#container').hide();
                $(document.body).removeClass("body").addClass('lock-screen');
                $('#lock_password').val('');
            }else{
                $('#locker').hide();
                $('#container').show();
                $(document.body).removeClass("lock-screen").addClass('body');
            }
        }

        checkLockStatus('<?php echo $_SESSION['lock_screen']; ?>');

        function lockSystem(){
            var url ='index.php?m=core&f=index&v=lockscreen<?php echo $this->su();?>';
            $.post(url,
                function(data){
                    if(data=='1') {
                        checkLockStatus(1);
                    } else {
                        alert("锁屏失败，请稍后再试");
                    }
                });

            startTimer();
        }

        function unlockSystem(){
            var lock_password = $('#lock_password').val();

            $('#lock_password').removeClass('validate-has-error');

            var url ='index.php?m=core&f=index&v=unlockscreen<?php echo $this->su();?>';
            $.post(
                url,
                {
                    username: '<?php echo $username; ?>',
                    password: lock_password
                },
                function(data){
                    if(data=='0') {
                        checkLockStatus(0);
                    } else {
                        $('#lock_password').val('');
                        $('#lock_password').addClass('validate-has-error');
                        $('#lock_password').attr('placeholder', data);
                    }
                }
            );
        }


        $('#lock').click(function(){
            lockSystem();
        });

        $('#unlock').click(function(){
            unlockSystem();
        });

        $('#lock_password').keypress(function(e){
            var key = e.which;
            if (key == 13) {
                unlockSystem();
            }
        });



    });
    function checknew_version() {
        $.getJSON("?m=core&f=index&v=checknew_version<?php echo $this->su();?>", function(json){
            if(json.code=='200') {
                alert(json.msg);
            } else if(json.code=='300') {
                alert(json.msg);
                gotourl(json.url);
            }
        });
    }
    setTimeout("checknew_version()",10000);
    function keep_alive() {
        $.get("?m=core&f=index&v=keep_alive<?php echo $this->su();?>");
    }
    setInterval("keep_alive()",30000);
    function onlinetimes() {
        $.get("?m=core&f=onlinetime&v=init<?php echo $this->su();?>");
    }
    setInterval("onlinetimes()",180000);

    function changesite(siteid,sitename) {
        $.post("?m=core&f=site&v=changesite<?php echo $this->su();?>", { siteid:siteid, time: Math.random() },
            function(data){
                $('#sitename').html(sitename);
                $('#alert-warning').addClass('alert-danger');
                $('#alert-warning').removeClass('hide');
                $('#warning-tips').html('<strong>切换成功，请刷新</strong>');
                $("#weburl").attr('href',data);
                refresh_iframe();
                setTimeout("$('#alert-warning').addClass('hide');",2000)
            });
    }
</script>

<div class="lock-screen">
    <div id="locker" class="lock-wrapper" style="display: <?php if($_SESSION['lock_screen']==1){echo 'block'; }else{ echo 'none'; } ?>">
        <div id="time"></div>
        <div class="lock-box text-center">
            <img src="<?php echo R;?>images/userimg.jpg" alt=""/>
            <h1><?php echo $truename; ?></h1>
            <div class="form-group col-lg-12">
                <input type="password" placeholder="<?php echo L('lockscreen tip')?>" id="lock_password" class="form-control lock-input" autofocus />
                <button id="unlock" class="btn btn-default btn-lock" type="button" ><?php echo L('unlockscreen')?></button>
            </div>
        </div>
    </div>
</div>
<?php include $this->template('footer','core');?>
