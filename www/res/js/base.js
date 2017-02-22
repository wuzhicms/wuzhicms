/**
 * wuzhicms 公用js
 */
//跳转到url

//通过artdialog打开iframe
//example: openiframe('index.php?app=demo&c=dialog&a=iframe2','id','title...',800,300)

function openiframe(iframeurl,id,title,width,height,returntype) {
    if(document.body.clientWidth<860) {
        width = document.body.clientWidth-50;
        height = 300;
    }
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
                    $('#' + id + "_thumb").attr('src', this.returnValue);
                    $('#' + id).val(this.returnValue);
                } else if(returntype==5) {//ckeditor
                    var instance = CKEDITOR.instances[id];
                    instance.insertHtml(this.returnValue);
                }else if(returntype > 1){ //返回字符串,多文件
					$('#'+id+" ul").append(this.returnValue);
				} else {
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
function linkage(fieldid,linkid,obj) {
    //console.log();
    if(linkid!=0) {
        $("#"+fieldid).val(linkid);
    }
    if($(obj).attr('name')=='LK6_3') {
        if(linkid!='' && linkid!=0) {
            $.getJSON("/api/get_linkagedata.php", { lid:linkid, time: "2pm",getone:1}, function(json){
                if(json.lists.thumb!='') $("#thumb").val(json.lists.thumb);
            });
        }
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
if("undefined" != typeof set_iframe_url && set_iframe_url==true){
    var iframe_url = window.location.href;
    top.$("#iframeid").attr('url',iframe_url);
}

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



function getcookie(name) {
    name = cookie_pre+name;
    var arg = name + "=";
    var alen = arg.length;
    var clen = document.cookie.length;
    var i = 0;
    while(i < clen) {
        var j = i + alen;
        if(document.cookie.substring(i, j) == arg) return getcookieval(j);
        i = document.cookie.indexOf(" ", i) + 1;
        if(i == 0) break;
    }
    return null;
}

function setcookie(name, value, days) {
    name = cookie_pre+name;
    var argc = setcookie.arguments.length;
    var argv = setcookie.arguments;
    var secure = (argc > 5) ? argv[5] : false;
    var expire = new Date();
    if(days==null || days==0) days=1;
    expire.setTime(expire.getTime() + 3600000*24*days);
    document.cookie = name + "=" + escape(value) + ("; path=" + cookie_path) + ((cookie_domain == '') ? "" : ("; domain=" + cookie_domain)) + ((secure == true) ? "; secure" : "") + ";expires="+expire.toGMTString();
}

function delcookie(name) {
    var exp = new Date();
    exp.setTime (exp.getTime() - 1);
    var cval = getcookie(name);
    name = cookie_pre+name;
    document.cookie = name+"="+cval+";expires="+exp.toGMTString();
}

function getcookieval(offset) {
    var endstr = document.cookie.indexOf (";", offset);
    if(endstr == -1)
        endstr = document.cookie.length;
    return unescape(document.cookie.substring(offset, endstr));
}
function set_option(id,value,vals) {
    $("#"+id).val(value);
    $("#option_"+id).html(vals);
}
var _uid=getcookie('_uid');
function login_form(iframeurl,id,title,width,height,formname) {
    top.dialog({
        id: id,
        fixed: true,
        width: width,
        height: height,
        title: title,
        padding: 5,
        url: iframeurl,
        onclose: function () {
            if (this.returnValue==1 && formname!='') {
                formname.submit();
            }
        }
    }).show();
    return false;
}
function setcity(cityname,city_key) {
    $("#cityname").html(cityname);
    setcookie('city_key',city_key);
    setcookie('cityname',cityname);
    window.location.reload();
}
function GetRTime(end_time,div){
    var EndTime= new Date(end_time);
    var NowTime = new Date();
    var t =EndTime.getTime() - NowTime.getTime();
    var d=Math.floor(t/1000/60/60/24);
    var h=Math.floor(t/1000/60/60%24);
    var m=Math.floor(t/1000/60%60);
    var s=Math.floor(t/1000%60);
    if(d<0) d=0;
    if(h<0) h=0;
    if(m<0) m=0;
    if(s<0) s=0;
    $("#"+div+"d").html(d);
    $("#"+div+"h").html(h);
    $("#"+div+"m").html(m);
    $("#"+div+"s").html(s);
}

function remove_debug_div() {
    $(".remove_debug").remove();
}

function dymlist(iframeurl) {
    top.dialog({
        id: 'relation',
        fixed: true,
        width: 900,
        height: 530,
        title: '动态用户列表',
        padding: 5,
        url: iframeurl,
        onclose: function () {
            if (this.returnValue) {

            }
        }
    }).showModal(this);
}

function open_sortyear(id,obj) {
    $('.sortyear'+id).removeClass('hide');
    $(obj).remove();
}
function set_timer() {
    var t=setTimeout(function(){$('#alert-warning').addClass('hide');clearInterval(t);},3000);
}