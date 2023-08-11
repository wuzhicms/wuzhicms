/*
    像素格工作室 Pixel grid studio www.xiangsuge.com
*/

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
    var pxstrs = [];
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

//Tooltip提示
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})




var Script = function () {
// 部件工具
    jQuery('.panel .tools .icon-chevron-down').click(function () {
        var el = jQuery(this).parents(".panel").children(".panel-body");
        if (jQuery(this).hasClass("icon-chevron-down")) {
            jQuery(this).removeClass("icon-chevron-down").addClass("icon-chevron-up");
            el.slideUp(200);
        } else {
            jQuery(this).removeClass("icon-chevron-up").addClass("icon-chevron-down");
            el.slideDown(200);
        }
    });
    jQuery('.panel .tools .icon-times2').click(function () {
        jQuery(this).parents(".panel").parent().remove();
    });

// 自定义统计报表
    if ($(".custom-bar-chart")) {
        $(".bar").each(function () {
            var i = $(this).find(".value").html();
            $(this).find(".value").html("");
            $(this).find(".value").animate({
                height: i
            }, 150)
        })
    }
}();
