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
        var heights = iframestrs[0]-20,
            Body = $('body');
        $('#iframeid').height(heights);
        if (iframestrs[1] < 980) {
            Body.attr('scroll', '');
            Body.removeClass('pxgridsbody')
        } else {
            Body.attr('scroll', 'no');
            Body.addClass('pxgridsbody')
        }
        var sidebar = $("#iframeid").height()-20;
        $('#treemain').height(sidebar+35);
        $('#iframeid').height(sidebar+35);
        iframeWindowSize();
    }
    iframeSize();