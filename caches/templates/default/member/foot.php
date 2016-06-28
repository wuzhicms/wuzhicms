<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><!-- 自定义js -->
<script src="<?php echo R;?>member/js/hplus.js?v=4.0.0"></script>
<script type="text/javascript" src="<?php echo R;?>member/js/contabs.js"></script>
<!-- 第三方插件 -->
<script src="<?php echo R;?>member/js/plugins/pace/pace.min.js"></script>
<!-- iCheck -->
<script src="<?php echo R;?>member/js/plugins/iCheck/icheck.min.js"></script>

<?php if($set_iframe==0) { ?>
<script type="text/javascript">
    var _uid=getcookie('_uid');
    if(_uid!=null) {
        $("#mylogined").removeClass('hide');
        $("#mylogin").addClass('hide');
        var _username=decodeURI(getcookie('truename'));
        $("#myname").html(_username);
        var modelid=getcookie('modelid');
    }
    setInterval("get_newmessage()", 10000);
    function get_newmessage() {
        $.getJSON("/index.php?m=member&f=json&v=get_newmessage", { time: Math.random()}, function(json){
            if(json.newmessage==1) {
                $("#mymessage-tips").removeClass('hide');
            } else {
                $("#mymessage-tips").addClass('hide');
            }
        });
    }
    get_newmessage();
</script>
<?php } ?>
</body>
</html>