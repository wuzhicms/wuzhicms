/**
 * wuzhicms 公用js
 */
//跳转到url
function gotourl(url) {
    location.href = url;
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
function set_cha(value) {
    if(value=='') {
        $("#cha_user").attr('placeholder','体检卡号');
    } else {
        $("#cha_user").attr('placeholder','身份证号码');
    }
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