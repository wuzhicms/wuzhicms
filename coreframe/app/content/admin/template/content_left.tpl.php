<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body categorytree">

<div class="treelistmain">
<div class="categoryserach">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="输入名称，按回车搜索" onkeydown="if(event.keyCode==13) highlight(this.value);">
    </div>
</div>
    <div class="treetools">
        <ul>
            <li><a href="javascript:ftips(10);" class="tooltips" data-original-title="审核信息" data-toggle="tooltip" data-placement="top"><i class="icon-check-square-o"></i><span class="badge bg-important hide" id="id1">8</span></a></li>
            <li><a href="javascript:ftips(8);" class="tooltips" data-original-title="定时发送" data-toggle="tooltip" data-placement="top"><i class="icon-clock-o"></i><span class="badge bg-important hide" id="id2">15</span></a></li>
            <li><a href="javascript:ftips(6);" class="tooltips" data-original-title="草稿箱" data-toggle="tooltip" data-placement="top"><i class="icon-save"></i><span class="badge bg-important hide" id="id3">65</span></a></li>
            <li><a href="javascript:ftips(0);" class="tooltips" data-original-title="回收站" data-toggle="tooltip" data-placement="top"><i class="icon-trash-o"></i></a></li>
        </ul>
    </div>
    <div class="treelist">
        <section class="treepanel">
            <div id="panel-bodys">
                <?php echo $category_tree;?>
            </div>
        </section>
    </div>
</div>

<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo R;?>css/jquery-tree.css" />
<script type="text/javascript" src="<?php echo R;?>js/jquery-tree.min.js"></script>
<script type="text/javascript">
    var global_cid = '<?php echo $cid;?>';
    $('#tree').explr({
        rememberState   : true,
        startCollapsed  : false,
        treeWidth   : 180
    });
    var parentpos = top.$("#position").html();
    function o_p(cid,obj) {
        $(".i-t").css('color','#666');
        $(obj).css('color','#cb0d0d');
        var te = $(obj).text();
        top.$("#position").html(parentpos+te+"<span>></span>");
        parent.$("#iframeid").attr('src','?m=content&f=content&v=listing&cid='+cid+'&type=<?php echo $GLOBALS['type'].$this->su();?>');
        global_cid = cid;
    }
    function w(s) {}
    function ftips(status) {
        parent.$("#iframeid").attr('src','?m=content&f=content&v=allcheck&cid='+global_cid+'<?php echo $this->su();?>&status='+status);
    }
    function highlight(s){
        if (s.length==0){
            return false;
        }
        $(".i-t").css('color','#666');
        var total = 0;
        $("a").each(function(){
            if(search_text(s,$(this).text())) {
                $(this).css('color','#cb0d0d');
                total++;
                if(total==1) {
                    $(this).click();
                }
            }
            //console.log($(this).text());
        });

    }
    function search_text(s,text){
        if(text.match(s)) return true;
    }
</script>