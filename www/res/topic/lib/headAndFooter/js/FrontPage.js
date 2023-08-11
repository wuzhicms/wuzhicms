/**
 * Created by Aber on 2017/7/6.
 */
var FrontPage;
FrontPage = function (pos,char,appid) {
    var p;
    var c;
    var a;
    p = pos;
    c = char;
    a = appid;


    var utf = "_utf8";
    var url = "/res/topic/lib/headAndFooter/js/";
    var nav = "nav_small_2017_1000";
    var copyright = "copyright_2017_1000";

    switch (p)
    {
        case "nav":
            url = url + nav;
            break;
        case "copyright":
            url = url + copyright;
            break;
        default:
            break;
    }


    if (c.toLowerCase() == "UTF-8".toLowerCase())
        url = url + utf;

    url = url + ".js";
    document.write('<script src="' + url + '"><\/script>')
};
