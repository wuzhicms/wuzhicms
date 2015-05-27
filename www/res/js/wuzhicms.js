//通过artdialog打开iframe
//example: openiframe('index.php?app=demo&c=dialog&a=iframe2','id','title...',800,300)
function openiframe(iframeurl,id,title,width,height,returntype) {
	top.dialog({
			id: id,
			fixed: true,
			width: width,
			height: height,
			title: title,
			padding: 5,
			url: iframeurl,
            onclose: function () {
            if (this.returnValue) {
                if(returntype==1) {//返回缩略图＋隐藏input
                    $('#'+id+"_thumb").attr('src',this.returnValue);
                    $('#'+id).val(this.returnValue);
                }else if(returntype > 1){ //返回字符串,多文件
					$('#'+id+" ul").append(this.returnValue);
				}
				else {
                    $('#'+id).val(this.returnValue);
                }
            }
        }
		}).showModal(this);
	return false;
}
//跳转到url
function gotourl(url) {
	location.href = url;
}
//确认操作
function makedo(url,message) {
    if(confirm(message)) gotourl(url);
}
//分页快捷键跳转
$(document).keydown(function(e){
    if(e.which == 37 && $('#page-up').val()) {
        gotourl($('#page-up').val());
    }
    if(e.which == 39 && $('#page-next').val()) {
        gotourl($('#page-next').val());
    }
});
//联动菜单
function linkage(fieldid,linkid) {
    if(linkid!=0) {
        $("#"+fieldid).val(linkid);
    }
}

function msgtip(msgcontent) {
    var d = dialog({
        content: msgcontent
    });
    d.show();
    setTimeout(function () {
        d.close().remove();
    }, 2000);
}

function relation_add(iframeurl) {
    var text = $("#relation_search").val();
    top.dialog({
        id: 'relation',
        fixed: true,
        width: 900,
        height: 530,
        title: '相关内容添加',
        padding: 5,
        url: iframeurl+'&keywords='+encodeURIComponent(text),
        onclose: function () {
            if (this.returnValue) {
                var text=this.returnValue;
                var rela=$('#relation').val();
                $('#relation').val(rela+text);
                var htmls = text.split("~wuzhicms~");
                var sstext = '';
                $.each(htmls, function(i,value){
                    if(value!='') {
                        sstext = value.split("~wz~");
                        $("#relation_result").css("padding-top","5px");
                        $("#relation_result").append("<li><strong>标题：</strong>"+sstext[0]+" <strong style='padding-left:30px;'>链接：</strong>"+sstext[1]+"</li>");
                    }
                });
            }
        }
    }).showModal(this);
}
function change_value(id,value) {
    $("#"+id).val(value);
}

/**
 * 全选/反选
 * @param value selectAll或空
 * @param obj 当前对象
 */

function checkall(value,obj)  {
    var form=document.getElementsByTagName("form")
    for(var i=0;i<form.length;i++){
        for (var j=0;j<form[i].elements.length;j++){
            if(form[i].elements[j].type=="checkbox"){
                var e = form[i].elements[j];
                if (value=="selectAll"){e.checked=obj.checked}
                else{e.checked=!e.checked;}
            }
        }
    }
}
//记录当前URL，用于框架刷新
var iframe_url = window.location.href;
top.$("#iframeid").attr('url',iframe_url);

function baidumap(field) {
    top.dialog({
        id: 'baidumap',
        fixed: true,
        width: 960,
        height: 600,
        title: '地图标注',
        padding: 5,
        url: 'index.php?m=core&f=map&v=baidumap&x='+$("#"+field+"_x").val()+'&y='+$("#"+field+"_y").val()+'&zoom='+$("#"+field+"_zoom").val()+'&address='+$("#address").val(),
        onclose: function () {
            if (this.returnValue) {
                var returnValue=this.returnValue;
                var bmaps = returnValue.split(',');
                $("#"+field+"_x").val(bmaps[0]);
                $("#"+field+"_y").val(bmaps[1]);
                $("#"+field+"_zoom").val(bmaps[2]);
            }
        }
    }).showModal(this);
}
function getareaid(id) {
    $.getJSON("?m=content&f=city&v=getareaid", { id: id},
        function(data){
            $("#areaid").val(data.areaid);
            $("#fuwuid").val(data.fuwu);
        });
}


// iframe同域部分和iframe自动适应窗口大小
var iframeWindowSize = function() {
    return ["Height", "Width"].map(function(name) {
        return window["inner" + name] || document.compatMode === "CSS1Compat" && document.documentElement["client" + name] || document.body["client" + name]
    })
}
window.onload = function() {
    if (!+"\v1" && !document.querySelector) {
        document.body.onresize = iframeresize
    } else {
        window.onresize = iframeresize
    }
    function iframeresize() {
        iframeSize();
        return false
    }
}
function iframeSize() {
    var str = iframeWindowSize();
    var pxstrs = new Array();
    iframestrs = str.toString().split(",");
    var heights = iframestrs[0] - 102,
    Body = $('body');
    $('#iframeid').height(heights);
    if (iframestrs[1] < 980) {
        Body.attr('scroll', '');
        Body.removeClass('pxgridsbody')
    } else {
        Body.attr('scroll', 'no');
        Body.addClass('pxgridsbody')
    }
    var sidebar = $("#iframeid").height()+0;
    $('#treemain').height(sidebar+10);
    $("#sidebar").height(sidebar+42);
    iframeWindowSize();
}
iframeSize();