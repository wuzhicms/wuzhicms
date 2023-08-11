<link rel="stylesheet" href="<?php echo R;?>js/dialog/ui-dialog.css" />
<script src="<?php echo R;?>js/dialog/dialog-plus.js"></script>

<div id="wztools" class="wztools-bar">
    <div class="wztools-row">
        <div class="wztools-col-xs-10">
            <div  id="wztools-list">

                <div id="wztools-wrap" class="wrap">
                    <ul>
                        <?php
                        foreach($layout_result as $layouts) {
                        ?>
                        <li>
                            <div class="wztools-row">
                                <?php
                                foreach($layouts as $layout_r) {
                                    ?>
                                    <div class="wztools-col-xs-2">
                                        <div class="wztools-li grid-stack-item" id="<?php echo $layout_r['custom_id'];?>">
                                            <div class="grid-stack-item-content wztools-mk-imght " title="<?php echo $layout_r['custom_id'];?>">
                                                <div class="wztools-mk-imght-l" style="background: url(<?php echo $layout_r['thumb'];?>) no-repeat center; background-size: contain"></div>
                                            </div>
                                            <div class="wztools-mk-name manhangyichu"><?php echo $layout_r['title'];?></div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>

                            </div>
                        </li>
                        <?php }?>
                    </ul>
                </div>
                <a type=" " value="上一组 " id="wztools-wrap-next" class="wrap-go-shang"> </a>
                <a type=" " value="下一组" id="wztools-wrap-prev" class="wrap-go-xia"> </a>

                <script type="text/javascript">
                    $(function() {
                        wztools_marquee();
                    });
                    function wztools_marquee() {
                        $('#wztools-wrap').marquee({
                            auto: false,
                            prevElement: $('#wztools-wrap-prev'),
                            nextElement: $('#wztools-wrap-next'),
                            showNum: 1,
                            stepLen: 1,
                            type: 'vertical'
                        });
                    }
                </script>

            </div>
        </div>
        <div class="wztools-col-xs-2" style="border-left: 1px solid #919191">
            <div class="wztools-bar-search" ><a class="wztools-btn wztools-btn-info  wztools-btn-lg wztools-btn-block" id="bar-search-show">搜索</a></div>
            <div class="wztools-bar-save"><a class="wztools-btn wztools-btn-danger wztools-btn-lg wztools-btn-block" onclick="wz_tools_save();" href="javascript:">保存</a></div>
        </div>
    </div>

</div>

<!-- ------------search-bar-------------- -->
<div  class="search-bar" style="display: none" >
    <div class="wztools-row">
        <div class="wztools-col-md-2"></div>
        <div class="wztools-col-md-8" style="text-align: center">
            <div class="wztools-form-inline">
                <div class="form-group">
                    <select class="wztools-form-control wztools-search-select wztools--xuanze" name="wztools_type" id="wztools_type">
                        <option value="title">名称</option>
                        <option value="custom_id">模板id</option>
                        <option value="templatedata">模板内容</option>
                        <option value="note">备注</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="input" class="wztools-form-control wztools-search-input" id="wztools_keyword" name="wztools_keyword" placeholder="请输入关键词">
                </div>
                <div class="form-group">
                    <button type="submit" class="wztools-btn  wztools-btn-info wztools-btn-lg wztools--sousuo" onclick="wztools_search();">&nbsp;&nbsp;&nbsp;搜索&nbsp;&nbsp;&nbsp;</button>
                </div>
            </div>
        </div>
        <div class="wztools-col-md-2"></div>
    </div>
    <div class="search-bar-close" id="bar-search-hide"></div>
</div>

<!--关闭隐藏搜索 search-bar-->
<script type="text/javascript">
    $(document).ready(function(){
        $("#bar-search-hide").click(function(){
            $(".search-bar").hide();
        });
        $("#bar-search-show").click(function(){
            $(".search-bar").show();
        });
    });
    function wztools_search() {
        var wztools_type=$("#wztools_type").val();
        var wztools_keyword=$("#wztools_keyword").val();
        $.get("index.php?m=core&f=layout&v=view&pageid=<?php echo $GLOBALS['pageid'];?>&tid=<?php echo $tid.$this->su();?>", { gettoolsjs: 1,wztools_type:wztools_type,wztools_keyword:wztools_keyword},
            function(data){
                $("#wztools-wrap").html(data);
                $(".search-bar").hide();
                wztools_marquee();
                wztools_draggable();
            });
    }
</script>

<!--********************** -本次修改新加 4.29- ************************ -->
<!--无缝滚动-->
<script type="text/javascript" src="<?php echo R;?>js/layout/marquee.js"></script>

<script>
    $('body').css('padding-top','150px');
    var elementPos = 0;
    var pageid = '<?php echo $pageid;?>';//当前模板id。如 首页，内容页
    var _su = '<?php echo $this->su();?>';//后台管理
    var tid = '<?php echo intval($GLOBALS['tid']);?>';//专题tid

    function addnew_widget(custom_id,str) {

        var grid = $('.grid-stack').data('gridstack');
        var el = '<div class="grid-stack-item" id="'+custom_id+'" data-custom-id="'+custom_id+'"> <div class="grid-stack-item-content">'+str+'</div></div>';
//addWidget(el[, x, y, width, height, autoPosition, minWidth, maxWidth, minHeight, maxHeight, id])
        grid.addWidget(el, 0, 0, 4, 4, false,1,100,1,100,custom_id);
        //$("html,body").animate({scrollTop:$("#"+id).offset().top},1000)
    }

    function wz_tools_save() {
        var res = _.map($('.grid-stack .grid-stack-item:visible'), function (el) {
            el = $(el);

            var node = el.data('_gridstack_node');
            return {
                id: el.attr('data-custom-id'),
                x: node.x,
                y: node.y,
                width: node.width,
                height: node.height,
                layout_dir: el.parent().attr('id')
            };
        });
        var datas = JSON.stringify(res);

        $.post("?m=core&f=layout&v=save"+_su, { pageid:pageid,datas: datas}, function(data) {
            if(data=='100') {
                tools_tips();
            } else {
                console.log(data);
                alert('报错数据异常，请打开chrome浏览器->开发者工具->Console 下面查看错误详情');
            }
        });
    }

    function wztools_draggable() {
        $(".wztools-col-xs-2 .grid-stack-item" ).draggable({
            revert: 'invalid',
            handle: '.grid-stack-item-content',
            scroll: false,
            helper: function( e) {
                //存在的问题
                $(".tools-widget-drag").remove();
                return $("<div class='tools-widget-drag'>拖拽到红色区域</div>");
            },
            appendTo: 'body',
            start: function(event, ui) {
                var custom_id = $(this).attr('id');
                elementPos = $("#"+custom_id).offset().top;
                $('.grid-stack').addClass('tools-darg-area');
            },
            stop: function( event, ui ) {
                $('.grid-stack').removeClass('tools-darg-area');
                var custom_id = $(this).attr('id');
                var elementPos2 = $("#"+custom_id).offset().top;
                if(elementPos!=elementPos2) {
                    var layout_dirname = $("#"+custom_id).parent().attr('id');
                    $.getJSON("?m=core&f=layout&v=get_html"+_su, {pageid:pageid,custom_id: custom_id,tid:tid,layout_dirname:layout_dirname}, function(data) {
                        $("#"+custom_id).remove();
                        addnew_widget(custom_id,data['html']);
                    });
                }
            }
        });
    }

    wztools_draggable();

    var wzlefttime = 3;
    function tools_tips() {
        wzlefttime = 3;
        var d = dialog({
            id: 'tips',
            fixed: true,
            content: '保存成功 <span style="font-size:12px;color:#b0bebf;"><span id="wzlefttime">3</span> 秒后，自动关闭</span>'
        });
        d.showModal();
        var timer = setInterval("lefttimes()",1000);
        setTimeout(function () {
            clearInterval(timer);
            wzlefttime = 3;
            d.close().remove();
        }, 3000);
    }
    function lefttimes() {
        wzlefttime=wzlefttime-1;
        $("#wzlefttime").html(wzlefttime);
    }

    $('.grid-stack').on("mouseover",".grid-stack-item",function(){
        $(this).addClass('grid--stack-edit');
    });
    $('#wztools').on("mouseover","",function(){
        $(".grid--stack-edit").removeClass('grid--stack-edit');
    });
    $('.grid-stack').on("dragstart",".grid-stack-item",function(){
        $(".grid-stack").off('mouseover',".grid-stack-item");
        $(this).removeClass('grid--stack-edit');
    });
    $('.grid-stack').on("dragstop",".grid-stack-item",function(){
        $('.grid-stack').on("mouseover",".grid-stack-item",function(){
            $(this).addClass('grid--stack-edit');
        });
    });
    $('.grid-stack').on("resizestart",".grid-stack-item",function(){
        $(".grid-stack").off('mouseover',".grid-stack-item");
        $(this).removeClass('grid--stack-edit');
    });

    $('.grid-stack').on('resizestop', function (event, ui) {
        $('.grid-stack').on("mouseover",".grid-stack-item",function(){
            $(this).addClass('grid--stack-edit');
        });
    });

    function tools_iframe(iframeurl,id,title,width,height,returntype) {
        if(document.body.clientWidth<860) {
            width = document.body.clientWidth-50;
            height = 300;
        }
        top.dialog({
            id: 'wz'+id,
            fixed: true,
            width: width,
            height: height,
            title: title,
            padding: 5,
            url: iframeurl,
            onclose: function () {
                if (this.returnValue) {
                    //$("#"+id+">:first-child").html('<div class="grid-stack-item-content">'+this.returnValue+'</div>');
                    $.getJSON("?m=core&f=layout&v=get_html"+_su, {pageid:pageid,custom_id: id,layout_dirname:'layout-'+this.returnValue}, function(data) {
                        $("#"+id+">:first-child").html(data['html']);
                    });
                }
            }
        }).showModal(this);
        return false;
    }
    function remove_widget(custom_id) {
        if(confirm('确认要删除【'+custom_id+'】吗？')) {
            $.post("?m=core&f=layout&v=delete_layout"+_su, { pageid:pageid,custom_id: custom_id}, function(data) {
                if(data=='100') {
                    $("#"+custom_id).remove();
                }
            });
        }
    }

</script>