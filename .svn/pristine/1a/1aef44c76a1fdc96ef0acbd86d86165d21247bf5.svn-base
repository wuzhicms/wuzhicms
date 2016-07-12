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
