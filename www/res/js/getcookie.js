function getcookie(name) {
    name = cookie_pre+name;
    let arg = name + "=";
    let alen = arg.length;
    let clen = document.cookie.length;
    let i = 0;
    while(i < clen) {
        let j = i + alen;
        if(document.cookie.substring(i, j) == arg) return getcookieval(j);
        i = document.cookie.indexOf(" ", i) + 1;
        if(i == 0) break;
    }
    return null;
}

function setcookie(name, value, days) {
    name = cookie_pre+name;
    let argc = setcookie.arguments.length;
    let argv = setcookie.arguments;
    let secure = (argc > 5) ? argv[5] : false;
    let expire = new Date();
    if(days==null || days==0) days=1;
    expire.setTime(expire.getTime() + 3600000*24*days);
    document.cookie = name + "=" + escape(value) + ("; path=" + cookie_path) + ((cookie_domain == '') ? "" : ("; domain=" + cookie_domain)) + ((secure == true) ? "; secure" : "") + ";expires="+expire.toGMTString();
}

function delcookie(name) {
    let exp = new Date();
    exp.setTime (exp.getTime() - 1);
    let cval = getcookie(name);
    name = cookie_pre+name;
    document.cookie = name+"="+cval+";expires="+exp.toGMTString();
}

function getcookieval(offset) {
    let endstr = document.cookie.indexOf (";", offset);
    if(endstr == -1)
        endstr = document.cookie.length;
    return unescape(document.cookie.substring(offset, endstr));
}
function set_option(id,value,vals) {
    $("#"+id).val(value);
    $("#option_"+id).html(vals);
}
let _uid=getcookie('_uid');
