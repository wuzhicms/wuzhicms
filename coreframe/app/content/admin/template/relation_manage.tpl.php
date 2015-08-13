<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body">
<style type="text/css">
    .cur{cursor: pointer;}
</style>
<section class="wrapper" style="padding: 5px;">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <div class="panel-body">
                    <form class="form-inline" action="" method="get" onsubmit="return false;">
                        <div class="input-group">
                            <input type="hidden" name="m" value="content">
                            <input type="hidden" name="f" value="relation">
                            <input type="hidden" name="v" value="listing">
                            <input type="hidden" name="_su" value="<?php echo $GLOBALS['_su'];?>">
                            <select name="keytype" id="keytype" class="form-control">
                                <option value="keywords" <?php if($GLOBALS['keytype']=='keywords') echo "selected";?>>关键字</option>
                                <option value="username" <?php if($GLOBALS['keytype']=='username') echo "selected";?>>用户名</option>
                            </select>
                        </div>
                        <input type="text" id="keywords" name="keywords" value="<?php echo $keywords;?>">
                        <div class="input-group">
                            <?php
                            echo $form->tree_select($categorys, $cid, 'name="cid" id="cid" class="form-control"');
                            ?>
                        </div>
                        <button type="submit" name="button" class="btn btn-info btn-sm" onclick="search_form();">搜索</button>
                        <div class="pull-right"><button type="button" class="btn btn-primary" onclick="add_relation();">自定义添加</button></div>
                    </form>

                </div>

            </section>
        </div>
    </div>
<div class="row">
    <div class="col-sm-6">
        <section class="panel tasks-widget">

            <div class="panel-body" id="panel-bodys">
            </div>
        </section>

    </div>
    <div class="col-sm-6">

        <section class="panel tasks-widget">
                <div class="" style="height: 360px;overflow:auto;" id="sheiht">

                    <ul class="task-list" id="slist">
                    </ul>
                </div>

        </section>
        <div style="padding: 3px 13px;">
            <button class="btn btn-info pull-right" onclick="save_result();">确定</button>
        </div>
    </div>
</div>
    <script type="text/javascript">
		var cid = <?php echo $cid;?>;
        function changepage(pageid) {
            var keytype = $("#keytype").val();
            var keywords = $("#keywords").val();
            $("#panel-bodys").load("?m=content&f=relation&v=listing&keytype="+keytype+"&keywords="+keywords+"&cid="+cid+"<?php echo $this->su();?>&page="+pageid, {},function(){
            });
        }
        changepage(1);
        function search_form() {
            cid = $("#cid").val();
            var keywords = $("#keywords").val();
            var keytype = $("#keytype").val();
            $("#panel-bodys").load("?m=content&f=relation&v=listing&charset=1&&keytype="+keytype+"&cid="+cid+"&keywords="+keywords+"<?php echo $this->su();?>", {},function(){});

        }
        function changeList(title,url,origin_id,origin_cid) {
            title = title.replace('<','&lt;');
            $("#slist").append('<li><div class="task-title"><span class="task-title-sp"><a href="'+url+'" target="_blank" origin_id="'+origin_id+'" origin_cid="'+origin_cid+'">'+title+'</a></span><div class="pull-right cur" onclick="removeList(this);">移 除</div></div></li>');
            document.getElementById('sheiht').scrollTop = document.getElementById('sheiht').scrollHeight;


        }
        function removeList(obj) {
            $(obj).parent().parent().remove();
        }
        function save_result() {
            var dialog = top.dialog.get(window);
            var htmls = '';
            $("#slist a").each(function(){
                htmls += $(this).html()+"~wz~"+$(this).attr('href')+"~wz~"+$(this).attr('origin_id')+"~wz~"+$(this).attr('origin_cid')+"~wuzhicms~";
                //alert($(this).html());
            });
            dialog.close(htmls).remove();
            return false;

           // var oldfile = parent.$('#relation').val();
            var ids = $("#resvalue").val();
            dialog.close(ids).remove();
        }
        function add_relation() {
            $("#panel-bodys").html('<div class="panel-body"><label class="control-label"><strong>标题</strong></label><div class="col-sm-10 input-group"><input type="text" class="form-control" id="diytitle" name="diytitle"  placeholder="请输入标题" ></div><br><label class="control-label"><strong>链接</strong></label><div class="col-sm-10 input-group"><input type="text" class="form-control" id="diyurl"  placeholder="请输入链接地址" ></div><br><div class="col-sm-10 input-group"><button class="btn btn-info pull-left" onclick="insert_rdiy();">确定</button></div></div>');
        }

        function insert_rdiy() {
            var diytitle=$("#diytitle").val();
            var diyurl=$("#diyurl").val();
            if(diytitle=='') {
                var d = dialog({
                    content: '请输入标题'
                });
                d.show();
                setTimeout(function () {
                    d.close().remove();
                }, 2000);
                return false;
            }
            if(diyurl=='') {
                var d = dialog({
                    content: '请输入链接地址'
                });
                d.show();
                setTimeout(function () {
                    d.close().remove();
                }, 2000);
                return false;
            }
            $("#diytitle").val('');
            $("#diyurl").val('');
            changeList(diytitle,diyurl);
            var d = dialog({
                content: '已添加至右侧列表'
            });
            d.show();
            setTimeout(function () {
                d.close().remove();
            }, 2000);

        }
    </script>

</section>
</body>
</html>