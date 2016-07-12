/*
    像素格工作室 Pixel grid studio www.pxgrids.com
*/
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

//    工具提示
    $('.tooltips').tooltip();
    $('.tooltipsfrom').tooltip();
//    浮动提示
    $('.popovers').popover();

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

var Script = function () {
// 自定义滚动条
    $("html").niceScroll({autohidemode:false,cursorcolor : "#bfc2cb",cursorwidth: '8',cursorborder:"none",horizrailenabled:false,mousescrollstep:55});
}();